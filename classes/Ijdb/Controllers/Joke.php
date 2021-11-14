<?php

namespace Ijdb\Controllers;

use DateTime;
use Ninja\DatabaseTable;

class Joke
{
    private $authorsTable;
    private $jokesTable;

    public function __construct(DatabaseTable $jokesTable, DatabaseTable $authorsTable)
    {
        $this->jokesTable = $jokesTable;
        $this->authorsTable = $authorsTable;
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
            ];
        }

        $title = 'Joke List';

        $totalJokes = $this->jokesTable->total();

        return ['template' => 'jokes.html.php', 'title' => $title, 'variables' => [
            'totalJokes' => $totalJokes,
            'jokes' => $jokes,
        ]];

    }

    public function home()
    {
        $title = 'Internet Joke Database';

        return ['template' => 'home.html.php', 'title' => $title];
    }

    public function delete()
    {
        $this->jokesTable->delete($_POST['jokeid']);

        header('Location: /joke/list');
    }

    public function saveEdit()
    {
        $joke = $_POST['joke'];
        $joke['jokedate'] = new DateTime();
        $joke['authorid'] = 1;

        $this->jokesTable->save($joke);

        header('Location: /joke/list');
    }

    public function edit()
    {
        if (isset($_GET['id'])) {
            $joke = $this->jokesTable->findById($_GET['id']);
        }

        $title = 'Edit Joke';

        return ['template' => 'editjoke.html.php', 'title' => $title, 'variables' => ['joke' => $joke ?? null]];

    }
}
