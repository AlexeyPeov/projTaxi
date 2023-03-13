<?php
namespace App\Framework;


return
    [
        'errorPages' =>
            [
                '404' => '../views/404.php',
            ],

        'guestRoutes' =>
            [
                '/' => ['GuestController', 'index'],
            ],

        'customerRoutes' => [
            //controllerRoutes
            '/customer' => ['CustomerController', 'index'],
            '/customer/{$id}' => ['CustomerController', 'show'],
            '/customer/update/{$id}' => ['CustomerController', 'update'],
            '/customer/create' => ['CustomerController', 'create'],
            '/customer/delete/{$id}' => ['CustomerController', 'delete'],
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