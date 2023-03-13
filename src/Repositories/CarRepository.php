<?php

namespace App\Repositories;


use PDO;

class CarRepository
{
    private PDO $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function findById(int $id): ?Car
    {

        $specificCar = "SELECT * FROM car WHERE id = :id";
        $statement = $this->connection->prepare($specificCar);
        $statement->execute(["id" => $id]);
        $car = $statement->fetch();

        if ($car !== false) {
            return new Car($car->id, $car->brand, $car->plates, $car->color, $car->carClass);
        }
        return null;
    }

    public function findByPlates(string $plates): ?Car
    {
        $specificCar = "SELECT * FROM car WHERE plates = :plates";
        $statement = $this->connection->prepare($specificCar);
        $statement->execute(["plates" => $plates]);
        $car = $statement->fetch();

        if ($car !== false) {
            return new Car($car->id, $car->brand, $car->plates, $car->color, $car->carClass);
        }
        return null;
    }
}