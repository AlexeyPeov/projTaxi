<?php

namespace App\Controllers;

use App\config\RouteLoader;

class GuestController
{
   /* public function index() {
        include __DIR__ . '../Views/whoami.php';
    }*/

    public function index(): void
    {
        require __DIR__ . '/../Views/whoami.php';
    }
}

