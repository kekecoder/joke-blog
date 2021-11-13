<?php

class RegisterController
{
    public function __construct(DatabaseTable $authorsTable)
    {
        $this->authorsTable = $authorsTable;
    }

    public function showForm()
    {}
}
