<?php

require_once('classes.php');

$regExpPhoneNum = "/^\s?(\+\s?7|8)([- ()]*\d){10}$/";
$regExpDateOfBirth = "/^\s?([- ]*\d){8}/";

$host = 'localhost';
$db   = 'taxi';
$user = 'postgres';
$pass = 'fuck';

$dsn = 'pgsql:host=' . $host . ";dbname=" . $db;

$connection = new PDO($dsn, $user, $pass);
$connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

$orderRepository = new OrderRepository($connection);
$customerRepository = new CustomerRepository($connection);
$taxiDriverRepository = new TaxiDriverRepository($connection);
$carRepository = new CarRepository($connection);


$orderService = new OrderService($orderRepository, $customerRepository, $taxiDriverRepository, $carRepository);

$file = file_get_contents("jopa.json");

$arr = json_decode($file, true);

// $orderService->createOrder(
//     $arr["firstName"],
//     "Обабус",
//     new DateTime("1992-12-04"),
//     "+7824 522 52 32",
//     "Бабушка",
//     "дедушка",
//     Car::FIRST
// );
//$orderService->takeOrder(4, 2);
//$orderService->clientTaken(4,2);
// $orderService->reviewOrder(4,1, 5);

//$orderService->createOrder("ass","eater",new DateTime("1992-08-12"),"+8777 23 42 423","DOM","RABOTA",1);

$m = new Migration($connection);
$m->up();