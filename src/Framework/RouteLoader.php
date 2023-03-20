<?php

namespace App\Framework;
class RouteLoader
{

    public static function get() : array{
        return
            [
                'errorPages' =>
                    [
                        '404' => __DIR__ . '/../Views/404.php',
                    ],

                'guestRoutes' =>
                    [
                        '/' => ['App\Controllers\GuestController', 'index'],
                    ],

                'customerRoutes' => [
                    //controllerRoutes
                    '/customer' => ['App\Controllers\CustomerController', 'index'],

                    //todo наверно нужно придумать что то получше
                    '/customer/orders' => ['App\Controllers\CustomerController', 'show'],
                    '/customer/{$id}' => ['App\Controllers\CustomerController', 'show'],

                    '/customer/update/{$id}' => ['App\Controllers\CustomerController', 'update'],
                    '/customer/create' => ['App\Controllers\CustomerController', 'create'],
                    '/customer/delete/{$id}' => ['App\Controllers\CustomerController', 'delete'],
                ],


                'taxiDriverRoutes' =>
                    [
                        //TaxiDriverControllerRoutes
                        '/taxidriver/auth' => ['App\Controllers\TaxiDriverController', 'auth'],
                        '/taxidriver' => ['App\Controllers\TaxiDriverController', 'index'],
                        '/taxidriver/{$id}' => ['App\Controllers\TaxiDriverController', 'show'],
                        '/taxidriver/update' => ['App\Controllers\TaxiDriverController', 'update'],
                        '/taxidriver/create' => ['App\Controllers\TaxiDriverController', 'create'],
                        '/taxidriver/login' => ['App\Controllers\TaxiDriverController', 'login'],
                        '/taxidriver/signup' => ['App\Controllers\TaxiDriverController', 'signup'],
                        '/taxidriver/delete/{$id}' => ['App\Controllers\TaxiDriverController', 'delete'],
                    ],


                'carRoutes' =>
                    [
                        //CarControllerRoutes
                    ],


                'orderRoutes' =>
                    [
                        //OrderControllerRoutes
                        '/orders' => ['App\Controllers\OrderController', 'index'],
                        '/order/{$id}' => ['App\Controllers\OrderController', 'show'],
                        '/order/update' => ['App\Controllers\OrderController', 'update'],
                        '/order/create' => ['App\Controllers\OrderController', 'create'],
                        '/order/delete/{$id}' => ['App\Controllers\OrderController', 'delete'],
                    ],
            ];
    }
}