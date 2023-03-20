<?php

namespace App;

use App\Framework\ORM;
use App\Framework\RouteLoader;
use App\Framework\Router;
use App\Models\Order;
use App\Services\OrderService;
use PDO;

include __DIR__ .  "/Framework/csrf.php";


class App
{
    public function init(){

        //db connection
        $env = parse_ini_file(__DIR__ . '/../.env');
        $host = $env["DB_HOST"];
        $db = $env["DB_NAME"];
        $user = $env["DB_USER"];
        $pass = $env["DB_PASS"];
        $dsn = "pgsql:host=$host;dbname=$db";
        $connection = new PDO($dsn, $user, $pass);
        $connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

        $ORM = new ORM($connection);
        $orderService = new OrderService($ORM);

        //routes
        $router = new Router($orderService);

        session_start();

        $router->initRouting(RouteLoader::get());

    }
}