<?php

use Ijdb\IjdbRoutes;
use Ninja\EntryPoint;

try {

    include __DIR__ . '/include/autoload.php';

    $route = ltrim(strtok($_SERVER['REQUEST_URI'], '?'), '/');

    $requests = $_SERVER['REQUEST_METHOD'];

    $entryPoint = new EntryPoint($route, $requests, new IjdbRoutes());
    $entryPoint->run();

} catch (PDOException $e) {
    $title = 'An error has occured';

    $output = "Sorry server busy " . $e->getMessage() . ' in ' . $e->getFile() . ' : ' . $e->getLine();
}
