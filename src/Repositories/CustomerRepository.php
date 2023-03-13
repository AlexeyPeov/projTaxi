<?php

namespace App\Repositories;

use App\Models\Customer;
use PDO;

class CustomerRepository
{
    private PDO $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function findById(int $id): ?Customer
    {

        $specificCustomer = "SELECT * FROM customer WHERE id = :id";
        $statement = $this->connection->prepare($specificCustomer);
        $statement->execute(["id" => $id]);
        $customer = $statement->fetch();

        if ($customer !== false) {
            return new Customer(
                $customer->id,
                $customer->firstName,
                $customer->secondName,
                date_create_from_format('Y-m-d H:i:s', $customer->birthday),
                $customer->personalDiscount,
                $customer->phoneNum,
                $customer->orderCount,
                $customer->orderDeclinedCount,
                true
            );
        }
        return null;
    }

    public function findByPhoneNum(string $phoneNum): ?Customer
    {
        $specificCustomer = "SELECT * FROM customer WHERE phoneNum = :phoneNum";
        $statement = $this->connection->prepare($specificCustomer);
        $statement->execute(["phoneNum" => $phoneNum]);
        $customer = $statement->fetch();

        if ($customer !== false) {
            return new Customer(
                $customer->id,
                $customer->firstName,
                $customer->secondName,
                date_create_from_format('Y-m-d H:i:s', $customer->birthday),
                $customer->personalDiscount,
                $customer->phoneNum,
                $customer->orderCount,
                $customer->orderDeclinedCount,
                true
            );
        }
        return null;
    }

    public function save(Customer $customer): void
    {
        if (!$customer->isSaved()) {
            $insert = "INSERT INTO `customer`
                (
                    firstName,
                     secondName,
                     birthday,
                     personalDiscount,
                     phoneNum,
                    orderCount,
                    orderDeclinedCount
                ) 
        VALUES (:firstName, :secondName, :birthday, :personalDiscount, :phoneNum, :orderCount, :orderDeclinedCount )";
            $stmt = $this->connection->prepare($insert);
            $stmt->execute(
                [
                    "firstName" => $customer->getFirstName(),
                    "secondName" => $customer->getSecondName(),
                    "birthday" => $customer->getBirthday()->format('Y-m-d H:i:s'),
                    "personalDiscount" => $customer->getPersonalDiscount(),
                    "phoneNum" => $customer->getPhoneNum(),
                    "orderCount" => $customer->getOrderCount(),
                    "orderDeclinedCount" => $customer->getOrderDeclinedCount()
                ]
            );
        } else {
            $update = "UPDATE `customer`
                    SET 
                        firstName = :firstName,
                        secondName = :secondName,
                        birthday = :birthday,
                        personalDiscount = :personalDiscount,
                        phoneNum = :phoneNum,
                        orderCount = :orderCount,
                        orderDeclinedCount = :orderDeclinedCount
                        WHERE id = :id;";
            $stmt = $this->connection->prepare($update);
            $stmt->execute(
                [
                    "id" => $customer->getId(),
                    "firstName" => $customer->getFirstName(),
                    "secondName" => $customer->getSecondName(),
                    "birthday" => $customer->getBirthday()->format('Y-m-d H:i:s'),
                    "personalDiscount" => $customer->getPersonalDiscount(),
                    "phoneNum" => $customer->getPhoneNum(),
                    "orderCount" => $customer->getOrderCount(),
                    "orderDeclinedCount" => $customer->getOrderDeclinedCount()
                ]
            );
        }
    }
}