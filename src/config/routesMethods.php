<?php

namespace App\config;

use App\Controllers\CarController;
use App\Controllers\CustomerController;
use App\Controllers\GuestController;
use App\Controllers\OrderController;

/*function initRouting(array $routes) : void{
    $uri = parse_url($_SERVER['REQUEST_URI'])['path'];

    if(array_key_exists($uri, $routes)){
        require $routes[$uri];
    } else {
        http_response_code(404);
        require $routes['/404'];
        die();
    }
}*/

function errorPage(int $errorCode, array $routes) : void {
    if(array_key_exists($errorCode, $routes['errorPages'])){
        http_response_code($errorCode);
        require $routes['errorPages'][$errorCode];
        die();
    }
}

/*function initRouting(array $routes) : void {
    $uri = parse_url($_SERVER['REQUEST_URI'])['path'];
    $method = $_SERVER['REQUEST_METHOD'];

    foreach ($routes as $routeGroup) {
        foreach ($routeGroup as $routePath => $controller) {
            if ($uri === $routePath) {
                require $controller;
                return;
            }
        }
    }
    errorPage(404, $routes);
}*/

function initRouting(array $routes) : void {
    $uri = parse_url($_SERVER['REQUEST_URI'])['path'];
    $method = $_SERVER['REQUEST_METHOD'];


    foreach ($routes as $routeGroup) {
        foreach ($routeGroup as $routePath => $controller) {
            if ($uri === $routePath) {
                call_user_func($controller);
                return;
            }
        }
    }
    errorPage(404, $routes);
}


