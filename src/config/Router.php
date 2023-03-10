<?php

namespace App\config;

use App\Controllers\GuestController;



class Router
{
    private $routes = [];

    public function init() : void {

    }
    public function addRoute($route, $callback): void
    {
        $this->routes[$route] = $callback;
    }

    public function dispatch($route)
    {
        if (array_key_exists($route, $this->routes)) {
            return call_user_func($this->routes[$route]);
        } else {
            return "404 - Not Found";
        }
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
                    call_user_func($controller);
                    return;
                }
            }
        }
        $this->errorPage(404, $routes);
    }
}