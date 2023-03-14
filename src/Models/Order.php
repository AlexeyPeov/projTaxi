<?php

namespace App\Models;

class Order
{
    const STATE_NEW = 1;
    const STATE_ACCEPTED = 2;
    const STATE_IN_PROGRESS = 3;
    const STATE_COMPLETE = 4;
    const STATE_FAILED = 0;

    public static function calculatePrice(int $class, int $personalDiscount): int
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

    public static function statusToString(int $state) : string {
        return match ($state) {
            self::STATE_NEW => "Created",
            self::STATE_ACCEPTED => "Accepted",
            self::STATE_IN_PROGRESS => "In Progress",
            self::STATE_COMPLETE => "Complete",
            self::STATE_FAILED => "Failed",
            default => "Unknown State"
        };
    }
}

