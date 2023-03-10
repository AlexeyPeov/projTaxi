<?php

namespace App\Models;
class Car
{
    private int $id;
    private string $brand;
    private string $plates;
    private string $color;
    private int $carClass;

    const FIRST = 1;
    const SECOND = 2;
    const THIRD = 3;

    public function __construct(int $id, string $brand, string $plates, string $color, int $carClass)
    {
        $this->id = $id;
        $this->brand = $brand;
        $this->plates = $plates;
        $this->color = $color;
        $this->carClass = $carClass;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getBrand(): string
    {
        return $this->brand;
    }

    public function getCarClass(): int
    {
        return $this->carClass;
    }

    public function getColor(): string
    {
        return $this->color;
    }

    public function getPlates(): string
    {
        return $this->plates;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setBrand(string $brand): void
    {
        $this->brand = $brand;
    }

    public function setCarClass(int $carClass): void
    {
        $this->carClass = $carClass;
    }

    public function setColor(string $color): void
    {
        $this->color = $color;
    }

    public function setPlates(string $plates): void
    {
        $this->plates = $plates;
    }
}