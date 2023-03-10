<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitba598bfcb4afaa7d33122a22dbdae0b3
{
    public static $prefixLengthsPsr4 = array (
        'A' => 
        array (
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'App\\App' => __DIR__ . '/../..' . '/src/App.php',
        'App\\Controllers\\CarController' => __DIR__ . '/../..' . '/src/Controllers/CarController.php',
        'App\\Controllers\\CustomerController' => __DIR__ . '/../..' . '/src/Controllers/CustomerController.php',
        'App\\Controllers\\GuestController' => __DIR__ . '/../..' . '/src/Controllers/GuestController.php',
        'App\\Controllers\\OrderController' => __DIR__ . '/../..' . '/src/Controllers/OrderController.php',
        'App\\Controllers\\TaxiDriverController' => __DIR__ . '/../..' . '/src/Controllers/TaxiDriverController.php',
        'App\\Models\\Car' => __DIR__ . '/../..' . '/src/Models/Car.php',
        'App\\Models\\Customer' => __DIR__ . '/../..' . '/src/Models/Customer.php',
        'App\\Models\\Order' => __DIR__ . '/../..' . '/src/Models/Order.php',
        'App\\Models\\TaxiDriver' => __DIR__ . '/../..' . '/src/Models/TaxiDriver.php',
        'App\\Repositories\\CarRepository' => __DIR__ . '/../..' . '/src/Repositories/CarRepository.php',
        'App\\Repositories\\CustomerRepository' => __DIR__ . '/../..' . '/src/Repositories/CustomerRepository.php',
        'App\\Repositories\\OrderRepository' => __DIR__ . '/../..' . '/src/Repositories/OrderRepository.php',
        'App\\Repositories\\TaxiDriverRepository' => __DIR__ . '/../..' . '/src/Repositories/TaxiDriverRepository.php',
        'App\\Services\\OrderService' => __DIR__ . '/../..' . '/src/Services/OrderService.php',
        'App\\Views\\layout\\Layout' => __DIR__ . '/../..' . '/src/Views/layout/Layout.php',
        'App\\config\\RouteLoader' => __DIR__ . '/../..' . '/src/config/RouteLoader.php',
        'App\\config\\Router' => __DIR__ . '/../..' . '/src/config/Router.php',
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitba598bfcb4afaa7d33122a22dbdae0b3::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitba598bfcb4afaa7d33122a22dbdae0b3::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitba598bfcb4afaa7d33122a22dbdae0b3::$classMap;

        }, null, ClassLoader::class);
    }
}
