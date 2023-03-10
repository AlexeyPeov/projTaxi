<?php

namespace App;

use App\config\RouteLoader;
use App\config\Router;


class App
{
    public static function init(){
        $router = new Router();
        $router->initRouting(RouteLoader::get());
    }
}