<?php

namespace Ijdb\Controllers;

use DateTime;
use Ninja\Authentication;
use Ninja\DatabaseTable;

class Joke
{
    private $authorsTable;
    private $jokesTable;

    public function __construct(DatabaseTable $jokesTable, DatabaseTable $authorsTable, Authentication $authentication)
    {
        $this->jokesTable = $jokesTable;
        $this->authorsTable = $authorsTable;
        $this->authentication = $authentication;
    }

    public function lists()
    {
        $result = $this->jokesTable->findAll();

        $jokes = [];

        foreach ($result as $joke) {
            $author = $this->authorsTable->findById($joke['authorid']);

            $jokes[] = [
                'jokeid' => $joke['jokeid'],
                'joketext' => $joke['joketext'],
                'jokedate' => $joke['jokedate'],
                'authorname' => $author['authorname'],
                'authoremail' => $author['authoremail'],
                'authorid' => $author['id'],
            ];
        }

        $title = 'Joke List';

        $totalJokes = $this->jokesTable->total();

        $author = $this->authentication->getUser();

        return ['template' => 'jokes.html.php', 'title' => $title, 'variables' => [
            'totalJokes' => $totalJokes,
            'jokes' => $jokes,
            'userId' => $author['id'] ?? null,
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

        $joke = $this->jokesTable->findById($_POST['jokeid']);

        if ($joke['authorid'] != $author['id']) {
            return;
        }

        $this->jokesTable->delete($_POST['jokeid']);

        header('Location: /joke/list');
    }

    public function saveEdit()
    {
        $author = $this->authentication->getUser();

        if (isset($_GET['jokeid'])) {
            $joke = $this->jokesTable->findById($_GET['jokeid']);

            if ($joke['authorid'] != $author['id']) {
                return;
            }
        }

        $joke = $_POST['joke'];
        $joke['jokedate'] = new DateTime();
        $joke['authorid'] = $author['id'];

        $this->jokesTable->save($joke);

        header('Location: /joke/list');
    }

    public function edit()
    {
        $author = $this->authentication->getUser();

        if (isset($_GET['id'])) {
            $joke = $this->jokesTable->findById($_GET['id']);
        }

        $title = 'Edit Joke';

        return ['template' => 'editjoke.html.php', 'title' => $title, 'variables' => ['joke' => $joke ?? null, 'userId' => $author['id'] ?? null]];

    }
}
