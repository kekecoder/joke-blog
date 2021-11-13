<?php

try {

    require_once __DIR__ . '/classes/EntryPoint.php';
    require_once __DIR__ . '/classes/IjdbRoutes.php';

    $route = ltrim(strtok($_SERVER['REQUEST_URI'], '?'), '/');

    $entryPoint = new EntryPoint($route, new ijdbRoutes());
    $entryPoint->run();

} catch (PDOException $e) {
    $title = 'An error has occured';

    $output = "Sorry server busy " . $e->getMessage() . ' in ' . $e->getFile() . ' : ' . $e->getLine();
}
