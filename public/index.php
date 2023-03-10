<?php


require 'debug.php';
include '../config/routesMethods.php';
$routes = include '../config/routes.php';
initRouting($routes);

/*$uri = parse_url($_SERVER['REQUEST_URI'])['path'];

if ($uri == '/customer') {
    require '../views/customers/index.php';
}

if ($uri == '/') {
    require '../views/whoami.php';
}*/

/*require_once('classes.php');*/



/*if($uri = '/') {
    require '../views/main.php';
}*/

/*$regExpPhoneNum = "/^\s?(\+\s?7|8)([- ()]*\d){10}$/";
$regExpDateOfBirth = "/^\s?([- ]*\d){8}/";

$host = 'localhost';
$db   = 'taxiapp';
$user = 'root';
$pass = 'fuck';


$dsn = 'mysql:host=' . $host . ";dbname=" . $db;

$connection = new PDO($dsn, $user, $pass);
$connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

$orderRepository = new OrderRepository($connection);
$customerRepository = new CustomerRepository($connection);
$taxiDriverRepository = new TaxiDriverRepository($connection);
$carRepository = new CarRepository($connection);


$orderService = new OrderService($orderRepository, $customerRepository, $taxiDriverRepository, $carRepository);

$file = file_get_contents("jopa.json");

$arr = json_decode($file, true);

 $orderService->createOrder(
     $arr["firstName"],
     "Обабус",
     new DateTime("1992-12-04"),
     "+7824 522 52 32",
     "Бабушка",
     "дедушка",
     Car::FIRST
 );
$orderService->takeOrder(4, 2);
$orderService->clientTaken(4,2);
 $orderService->reviewOrder(4,1, 5);

$orderService->createOrder("ass","eater",new DateTime("1992-08-12"),"+8777 23 42 423","DOM","RABOTA",1);*/