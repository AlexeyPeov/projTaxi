<?php

namespace App\Repositories;

class OrderRepository
{
    private PDO $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function findById(int $id): ?Order
    {

        $specificOrder = "SELECT * FROM `order` WHERE id = :id";
        $statement = $this->connection->prepare($specificOrder);
        $statement->execute(["id" => $id]);
        $order = $statement->fetch();

        if ($order !== false) {
            return new Order(
                $order->id,
                $order->orderStatus,
                $order->customerId,
                $order->taxiDriverId,
                $order->class,
                $order->price,
                $order->pointA,
                $order->pointB,
                date_create_from_format('Y-m-d H:i:s', $order->dayCreated),
                $order->reviewGiven,
                true
            );
        }
        return null;
    }

    public function save(Order $order)
    {
        if (!$order->isSaved()) {
            $command = "INSERT INTO `order`
                (
                    orderStatus,
                    customerId,
                    class,
                    price,
                    pointA,
                    pointB,
                    dayCreated,
                    reviewGiven
                ) 
            VALUES (:orderStatus, :customerId, :class, :price, :pointA, :pointB, :dayCreated, :reviewGiven)";
            $stmt = $this->connection->prepare($command);
            $stmt->execute(
                [
                    "orderStatus" => $order->getOrderStatus(),
                    "customerId" => $order->getCustomerId(),
                    "class" => $order->getClass(),
                    "price" => $order->getPrice(),
                    "pointA" => $order->getPointA(),
                    "pointB" => $order->getPointB(),
                    "dayCreated" => $order->getDayCreated()->format('Y-m-d H:i:s'),
                    "reviewGiven" => 0
                ]
            );
        } else {
            $command = "UPDATE `order`
                    SET 
                        orderStatus = :orderStatus,
                        taxiDriverId = :taxiDriverId,
                        reviewGiven = :reviewGiven
                        WHERE id = :id;";
            $stmt = $this->connection->prepare($command);
            $stmt->execute(
                [
                    "id" => $order->getId(),
                    "orderStatus" => $order->getOrderStatus(),
                    "taxiDriverId" => $order->getTaxiDriverId(),
                    "reviewGiven" => (int)$order->isReviewGiven()

                ]
            );
        }
    }

    public function findNewOrderById(int $id): ?Order
    {

        $specificOrder = "SELECT * FROM `order` WHERE id = :id AND orderStatus = :orderStatus";
        $statement = $this->connection->prepare($specificOrder);
        $statement->execute(["id" => $id, "orderStatus" => Order::STATE_NEW]);
        $order = $statement->fetch();

        if ($order !== false) {
            return new Order(
                $order->id,
                $order->orderStatus,
                $order->customerId,
                $order->taxiDriverId,
                $order->class,
                $order->price,
                $order->pointA,
                $order->pointB,
                date_create_from_format('Y-m-d H:i:s', $order->dayCreated),
                $order->reviewGiven,
                true
            );
        }
        return null;
    }

}