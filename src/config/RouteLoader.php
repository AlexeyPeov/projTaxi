<?php

namespace App\config;
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
                    '/customer/{$id}' => ['App\Controllers\CustomerController', 'show'],
                    '/customer/update/{$id}' => ['App\Controllers\CustomerController', 'update'],
                    '/customer/create' => ['App\Controllers\CustomerController', 'create'],
                    '/customer/delete/{$id}' => ['App\Controllers\CustomerController', 'delete'],
                ],


                'taxiDriverRoutes' =>
                    [
                        //TaxiDriverControllerRoutes
                    ],


                'carRoutes' =>
                    [
                        //CarControllerRoutes
                    ],


                'orderRoutes' =>
                    [
                        //OrderControllerRoutes
                    ],
            ];
    }
}