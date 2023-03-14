<?php

namespace App\Models;

use DateTime;

class Customer
{
    public static function calculatePersonalDiscount(int $orderCount) : int
    {
        return match (true) {
            $orderCount > 20 => 20,
            $orderCount > 15 => 15,
            $orderCount > 10 => 10,
            $orderCount > 5 => 5,
            default => 0,
        };
    }

}