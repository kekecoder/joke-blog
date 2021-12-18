<?php

namespace Ijdb\Controllers;

use DateTime;
use Ninja\Authentication;
use Ninja\DatabaseTable;

class Joke
{
    private $authorsTable;
    private $jokesTable;
    private $categoriesTable;
    private $authentication;

    public function __construct(DatabaseTable $jokesTable, DatabaseTable $authorsTable, Authentication $authentication, DatabaseTable $categoriesTable)
    {
        $this->jokesTable = $jokesTable;
        $this->authorsTable = $authorsTable;
        $this->authentication = $authentication;
        $this->categoriesTable = $categoriesTable;
    }

    public function lists()
    {
        if (isset($_GET['category'])) {
            $category = $this->categoriesTable->findById($_GET['category']);
            $jokes = $category->getJokes();
        } else {
            $jokes = $this->jokesTable->findAll();
        }

        $title = 'Joke List';

        $totalJokes = $this->jokesTable->total();

        $author = $this->authentication->getUser();

        return ['template' => 'jokes.html.php', 'title' => $title, 'variables' => [
            'totalJokes' => $totalJokes,
            'jokes' => $jokes,
            'userId' => $author->id ?? null,
            'categories' => $this->categoriesTable->findAll(),
        ]];

    }

    public function home()
    {
        $title = 'Internet Joke Database';

        return ['template' => 'home.html.php', 'title' => $title];
    }

    public function delete()
    {
        $author = $this->authentication->getUser();

        $joke = $this->jokesTable->findById($_POST['id']);

        if ($joke->authorid != $author->id) {
            return;
        }

        $this->jokesTable->delete($_POST['id']);

        header('Location: /joke/list');
    }

    public function saveEdit()
    {
        $author = $this->authentication->getUser();

        if (isset($_GET['id'])) {
            $joke = $this->jokesTable->findById($_GET['id']);

            if ($joke->authorid != $author->id) {
                return;
            }
        }

        $joke = $_POST['joke'];
        $joke['jokedate'] = new DateTime();
        $joke['authorid'] = $author->id;

        $joketext = $joke['joketext'];

        $valid = true;
        $errors = [];

        if (empty($joketext)) {
            $valid = false;
            $errors[] = 'Cannot be left blank';
        }
        if ($valid == true) {
            $jokeEntity = $author->addJoke($joke);

            $jokeEntity->clearCategories();

            foreach ($_POST['category'] as $categoryid) {
                $jokeEntity->addCategory($categoryid);
            }

            header('Location: /joke/list');
        } else {
            return ['template' => 'editjoke.html.php', 'title' => 'Error', 'variables' => [
                'errors' => $errors,
            ],
            ];
        }
    }

    public function edit()
    {
        $author = $this->authentication->getUser();
        $categories = $this->categoriesTable->findAll();

        if (isset($_GET['id'])) {
            $joke = $this->jokesTable->findById($_GET['id']);
        }

        $title = 'Edit Joke';

        return ['template' => 'editjoke.html.php', 'title' => $title, 'variables' => ['joke' => $joke ?? null, 'userId' => $author->id ?? null, 'categories' => $categories]];

    }
}
