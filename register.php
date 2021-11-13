<?php

function loadTemplate($templatFileName, $variables = [])
{
    extract($variables);

    ob_start();

    include __DIR__ . '/../template/' . $templatFileName;

    return ob_get_clean();
}

try {
    require_once __DIR__ . '/../classes/databasetable.php';
    require_once __DIR__ . '/../classes/controller/RegisterController.php';

    $jokesTable = new DatabaseTable($pdo, 'jokes', 'jokeid');
    $authorsTable = new DatabaseTable($pdo, 'author', 'id');
    $regsiterController = new RegisterController($authorsTable);

    $action = $_GET['action'] ?? 'home';

    if ($action == strtolower($action)) {
        $regsiterController->$action();
    } else {
        http_response_code(301);
        header('Location: index.php?action=' . strtolower($action));
    }

    $title = $page['title'];

    if (isset($page['variables'])) {
        $output = loadTemplate($page['template'], $page['variables']);
    } else {
        $output = loadTemplate($page['template']);
    }
} catch (PDOException $e) {
    $title = 'An error has occured';

    $output = "Sorry server busy " . $e->getMessage() . ' in ' . $e->getFile() . ' : ' . $e->getLine();
}

include __DIR__ . '/../template/layout.html.php';
