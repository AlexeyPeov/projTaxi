<?php

namespace App\Models;

class Order
{
    const STATE_NEW = 1;
    const STATE_ACCEPTED = 2;
    const STATE_IN_PROGRESS = 3;
    const STATE_COMPLETE = 4;
    const STATE_FAILED = 0;

    public static function calculatePrice(int $class, int $personalDiscount): float
    {
        $priceDefault = rand(50, 250);
        $price = 0;

        if ($class == Car::FIRST) {
            $price = $priceDefault * 3;
        } elseif ($class == Car::SECOND) {
            $price = $priceDefault * 2;
        } elseif ($class== Car::THIRD) {
            $price = $priceDefault;
        }

        $price -= $price * ($personalDiscount / 100);
        return $price;
    }
}

