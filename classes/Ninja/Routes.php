<?php

namespace Ninja;

use Ninja\Authentication;

interface Routes
{
    public function getRoutes(): array;
    public function getAuthentication(): Authentication;
}
