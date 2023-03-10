<?php

namespace App\Controllers;

use App\config\RouteLoader;

class GuestController
{
   /* public function index() {
        include __DIR__ . '../Views/whoami.php';
    }*/

    public static function index(): void
    {
        include __DIR__ . '/../Views/whoami.php';
    }
}

