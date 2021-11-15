<?php

namespace Ijdb;

use Ijdb\Controllers\Joke;
use Ijdb\Controllers\Login;
use Ijdb\Controllers\Register;
use Ninja\Authentication;
use Ninja\DatabaseTable;
use Ninja\Routes;

class ijdbRoutes implements Routes
{
    private $authorsTable;
    private $jokesTable;
    private $authentication;

    public function __construct()
    {
        require_once __DIR__ . '/../../include/DatabaseConnection.php';

        $this->jokesTable = new DatabaseTable($pdo, 'jokes', 'jokeid');
        $this->authorsTable = new DatabaseTable($pdo, 'author', 'id');
        $this->authentication = new Authentication($this->authorsTable, 'authoremail', 'password');

    }

    public function getRoutes(): array
    {

        $jokeController = new Joke($this->jokesTable, $this->authorsTable, $this->authentication);
        $authorController = new Register($this->authorsTable);
        $loginController = new Login($this->authentication);

        $routes = [
            'author/register' => [
                'GET' => [
                    'controller' => $authorController,
                    'action' => 'registrationForm',
                ],
                'POST' => [
                    'controller' => $authorController,
                    'action' => 'registerUser',
                ],
            ],
            'author/success' => [
                'GET' => [
                    'controller' => $authorController,
                    'action' => 'success',
                ],
            ],
            'joke/edit' => [
                'POST' => [
                    'controller' => $jokeController,
                    'action' => 'saveEdit',
                ],
                'GET' => [
                    'controller' => $jokeController,
                    'action' => 'edit',
                ],
                'login' => true,
            ], 'joke/delete' => [
                'POST' => [
                    'controller' => $jokeController,
                    'action' => 'delete',
                ],
                'login' => true,
            ], 'joke/list' => [
                'GET' => [
                    'controller' => $jokeController,
                    'action' => 'lists',
                ],
            ],
            'login/error' => [
                'GET' => [
                    'controller' => $loginController,
                    'action' => 'error',
                ],
            ],
            'login' => [
                'GET' => [
                    'controller' => $loginController,
                    'action' => 'loginForm',
                ],
                'POST' => [
                    'controller' => $loginController,
                    'action' => 'processLogin',
                ],
            ],
            'login/success' => [
                'GET' => [
                    'controller' => $loginController,
                    'action' => 'success',
                ],
                'login' => 'true',
            ],
            'logout' => [
                'GET' => [
                    'controller' => $loginController,
                    'action' => 'logout',
                ],
            ],
            '' => [
                'GET' => [
                    'controller' => $jokeController,
                    'action' => 'home',
                ],
            ],
        ];
        return $routes;
    }

    public function getAuthentication(): Authentication
    {
        return $this->authentication;
    }
}
