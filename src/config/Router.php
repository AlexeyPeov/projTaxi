<?php

namespace App\config;

use App\Controllers\GuestController;
use Exception;


class Router
{
    private $routes = [];

    public function init() : void {
    }
    public function addRoute($route, $callback): void
    {
        $this->routes[$route] = $callback;
    }

    public function errorPage(int $errorCode, array $routes): void
    {
        if (array_key_exists($errorCode, $routes['errorPages'])) {
            http_response_code($errorCode);
            require $routes['errorPages'][$errorCode];
            die();
        }
    }

    public function initRouting(array $routes): void
    {
        $uri = parse_url($_SERVER['REQUEST_URI'])['path'];
        $method = $_SERVER['REQUEST_METHOD'];

        foreach ($routes as $routeGroup) {
            foreach ($routeGroup as $routePath => $controller) {
                if ($uri === $routePath) {
                    list($controllerClass, $functionName) = $controller;
                    $controllerClass = new $controllerClass();
                    call_user_func([$controllerClass, $functionName]);
                    return;
                }
            }
        }
        $this->errorPage(404, $routes);
    }
}