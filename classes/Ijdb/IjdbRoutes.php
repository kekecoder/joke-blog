<?php

namespace Ijdb;

use Ijdb\Controllers\Joke;
use Ninja\DatabaseTable;
use Ninja\Routes;

class ijdbRoutes implements Routes
{
    public function getRoutes()
    {
        require_once __DIR__ . '/../../include/DatabaseConnection.php';

        $jokesTable = new DatabaseTable($pdo, 'jokes', 'jokeid');
        $authorsTable = new DatabaseTable($pdo, 'author', 'id');

        $jokeController = new Joke($jokesTable, $authorsTable);

        $routes = [
            'joke/edit' => [
                'POST' => [
                    'controller' => $jokeController,
                    'action' => 'saveEdit',
                ],
                'GET' => [
                    'controller' => $jokeController,
                    'action' => 'edit',
                ],
            ], 'joke/delete' => [
                'POST' => [
                    'controller' => $jokeController,
                    'action' => 'delete',
                ],
            ], 'joke/list' => [
                'GET' => [
                    'controller' => $jokeController,
                    'action' => 'lists',
                ],
            ], '' => [
                'GET' => [
                    'controller' => $jokeController,
                    'action' => 'home',
                ],
            ],
        ];

        return $routes;
    }
}
