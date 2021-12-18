<?php

namespace Ijdb\Controllers;

use Ninja\DatabaseTable;

class Category
{
    private $categoriesTable;

    public function __construct(DatabaseTable $categoriesTable)
    {
        $this->categoriesTable = $categoriesTable;
    }

    public function edit()
    {
        if (isset($_GET['id'])) {
            $category = $this->categoriesTable->findById($_GET['id']);
        }

        $title = 'Edit Category';

        return ['template' => 'editcategory.html.php', 'title' => $title, 'variable' => ['category' => $category ?? null],
        ];
    }

    public function saveEdit()
    {
        $category = $_POST['category'];

        $valid = true;
        $errors = [];

        if (empty($category['name'])) {
            $valid = false;
            $errors[] = 'Cannot be left blank';
        }

        if ($valid == true) {
            $this->categoriesTable->save($category);

            header('Location: /category/list');
        } else {
            return ['template' => 'editcategory.html.php', 'title' => 'Error', 'variables' => [
                'errors' => $errors,
            ],
            ];
        }
    }

    public function lists()
    {
        $categories = $this->categoriesTable->findAll();

        $title = 'Joke Categories';

        return ['template' => 'categories.html.php', 'title' => $title, 'variables' => ['categories' => $categories]];
    }

    public function delete()
    {
        $this->categoriesTable->delete($_POST['id']);

        header('Location: /category/list');
    }

    public function error()
    {
        return ['template' => 'catlisterror.html.php', 'title' => 'Error'];
    }
}
