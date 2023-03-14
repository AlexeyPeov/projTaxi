<?php

namespace App\Models;
class Car
{

    const FIRST = 1;
    const SECOND = 2;
    const THIRD = 3;

    public static function classToString(int $class) : string {
        return match ($class) {
            self::FIRST => "First",
            self::SECOND => "Second",
            self::THIRD => "Third",
            default => "error at Car::statusToSting() - unknown class - $class"
        };
    }
}