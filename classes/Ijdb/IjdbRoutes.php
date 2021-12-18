<?php

namespace Ijdb;

use Ijdb\Controllers\Category;
use Ijdb\Controllers\Joke;
use Ijdb\Controllers\Login;
use Ijdb\Controllers\Register;
use Ijdb\Entity\Author;
use Ninja\Authentication;
use Ninja\DatabaseTable;
use Ninja\Routes;

class ijdbRoutes implements Routes
{
    private $authorsTable;
    private $jokesTable;
    private $categoriesTable;
    private $authentication;
    private $jokeCategoriesTable;

    public function __construct()
    {
        require_once __DIR__ . '/../../include/DatabaseConnection.php';

        $this->jokesTable = new DatabaseTable($pdo, 'jokes', 'id', '\Ijdb\Entity\Joke', [ & $this->authorsTable, &$this->jokeCategoriesTable]);
        $this->authorsTable = new DatabaseTable($pdo, 'author', 'id', '\Ijdb\Entity\Author', [ & $this->jokesTable]);
        $this->categoriesTable = new DatabaseTable($pdo, 'category', 'id', '\Ijdb\Entity\Category', [ & $this->jokesTable, &$this->jokeCategoriesTable]);
        $this->authentication = new Authentication($this->authorsTable, 'authoremail', 'password');
        $this->jokeCategoriesTable = new DatabaseTable($pdo, 'joke_category', 'categoryid');
    }

    public function getRoutes(): array
    {

        $jokeController = new Joke($this->jokesTable, $this->authorsTable, $this->authentication, $this->categoriesTable);
        $authorController = new Register($this->authorsTable);
        $loginController = new Login($this->authentication);
        $CategoryController = new Category($this->categoriesTable);

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
            'author/permission' => [
                'GET' => [
                    'controller' => $authorController,
                    'action' => 'permission',
                ],
                'POST' => [
                    'controller' => $authorController,
                    'action' => 'savePermission',
                ],
                'login' => true,
            ],
            'author/list' => [
                'GET' => [
                    'controller' => $authorController,
                    'action' => 'lists',
                ],
                'login' => true,
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
            'category/error' => [
                'GET' => [
                    'controller' => $CategoryController,
                    'action' => 'error',
                ],
            ],
            'category/edit' => [
                'POST' => [
                    'controller' => $CategoryController,
                    'action' => 'saveEdit',
                ],
                'GET' => [
                    'controller' => $CategoryController,
                    'action' => 'edit',
                ],
                'login' => true,
                'permission' => Author::EDIT_CATEGORIES,
            ],
            'category/list' => [
                'GET' => [
                    'controller' => $CategoryController,
                    'action' => 'lists',
                ],
                'login' => true,
                'permission' => Author::LIST_CATEGORIES,
            ],
            'category/delete' => [
                'POST' => [
                    'controller' => $CategoryController,
                    'action' => 'delete',
                ],
                'login' => true,
                'permission' => Author::REMOVE_CATEGORIES,
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

    public function checkPermission($permission): bool
    {
        $user = $this->authentication->getUser();

        if ($user && $user->hasPermission($permission)) {
            return true;
        } else {
            return false;
        }
    }
}
