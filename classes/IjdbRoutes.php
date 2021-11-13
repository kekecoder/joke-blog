<?php

class ijdbRoutes
{
    public function callAction($route)
    {
        require_once __DIR__ . '/../include/dbconfig.php';
        require_once __DIR__ . '/databasetable.php';

        $jokesTable = new DatabaseTable($pdo, 'jokes', 'jokeid');
        $authorsTable = new DatabaseTable($pdo, 'author', 'id');

        if ($route === 'joke/list') {
            include __DIR__ . '/../controller/JokeController.php';
            $controller = new JokeController($jokesTable, $authorsTable);
            $page = $controller->lists();
        } elseif ($route === '') {
            include __DIR__ . '/../controller/JokeController.php';
            $controller = new JokeController($jokesTable, $authorsTable);
            $page = $controller->home();
        } elseif ($route === 'joke/edit') {
            include __DIR__ . '/../controller/JokeController.php';
            $controller = new JokeController($jokesTable, $authorsTable);
            $page = $controller->edit();
        } elseif ($route === 'joke/delete') {
            include __DIR__ . '/../controller/JokeController.php';
            $controller = new JokeController($jokesTable, $authorsTable);
            $page = $controller->delete();
        } elseif ($route === 'register') {
            include __DIR__ . '/../controller/JokeController.php';
            $controller = new RegisterController($authorsTable);
            $page = $controller->showForm();
        } else {
            echo 'page not found';
            exit();
        }

        return $page;
    }
}
