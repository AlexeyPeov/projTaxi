<?php

namespace App;

use App\config\ORM;
use App\config\RouteLoader;
use App\config\Router;
use PDO;


class App
{
    public function init(){
        //routes
        $router = new Router();
        $router->initRouting(RouteLoader::get());

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
        /*$car = $ORM->createModel('cars');
        $car1 = $ORM->findById('cars', 2);
        $car1->brand = "ASDASDASD";
        $car1->updated_at = date('Y-m-d H:i:s');
        $ORM->push('cars', $car1);
        $car->brand = 'aboba';
        $car->plates = '02AS-SS';*/

        $taxiDriver = $ORM->createModel('taxi_drivers');
        $taxiDriver->phoneNumber = '+1234567890';
        $ORM->push('taxi_drivers', $taxiDriver);

    }
}