<?php
namespace Ijdb\Entity;

use Ninja\DatabaseTable;

class Author
{
    const EDIT_JOKES = 1;
    const DELETE_JOKES = 2;
    const LIST_CATEGORIES = 4;
    const EDIT_CATEGORIES = 8;
    const REMOVE_CATEGORIES = 16;
    const EDIT_USER_ACCESS = 32;

    public $id;
    public $name;
    public $email;
    public $password;
    private $jokesTable;

    public function __construct(DatabaseTable $jokesTable)
    {
        $this->jokesTable = $jokesTable;
    }
    public function getJokes()
    {
        return $this->jokesTable->find('authorid', $this->id);
    }

    public function addJoke($joke)
    {
        $joke['authorid'] = $this->id;
        return $this->jokesTable->save($joke);
    }

    public function hasPermission($permission)
    {
        $permissions = $this->userPermissionsTable->find('authorid', $this->id);

        foreach ($permissions as $permission) {
            if ($permission->permission == $permission) {
                return true;
            }
        }
    }
}
