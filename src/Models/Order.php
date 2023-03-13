<?php

namespace App\Models;

use DateTime;

class Order
{
    private ?int $id;
    private int $orderStatus;
    private int $customerId;
    private ?int $taxiDriverId;
    private int $class;
    private float $price;
    private string $pointA;
    private string $pointB;
    private ?DateTime $dayCreated;
    private bool $reviewGiven;


    const STATE_NEW = 1;
    const STATE_ACCEPTED = 2;
    const STATE_IN_PROGRESS = 3;
    const STATE_COMPLETE = 4;
    const STATE_FAILED = 0;

    const FIRST = 1;
    const SECOND = 2;
    const THIRD = 3;


    public function __construct(
        ?int      $id,
        int       $orderStatus,
        int       $customerId,
        ?int      $taxiDriverId,
        int       $class,
        float     $price,
        string    $pointA,
        string    $pointB,
        ?DateTime $dayCreated,
        bool      $reviewGiven,

    )
    {
        $this->id = $id;
        $this->orderStatus = $orderStatus;
        $this->customerId = $customerId;
        $this->taxiDriverId = $taxiDriverId;
        $this->class = $class;
        $this->price = $price;
        $this->pointA = $pointA;
        $this->pointB = $pointB;
        $this->dayCreated = $dayCreated;
        $this->reviewGiven = $reviewGiven;
    }



    public function isReviewGiven(): bool
    {
        return $this->reviewGiven;
    }

    public function setReviewGiven(bool $reviewGiven): void
    {
        $this->reviewGiven = $reviewGiven;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getPointB(): string
    {
        return $this->pointB;
    }

    public function getPointA(): string
    {
        return $this->pointA;
    }

    public function getTaxiDriverId(): ?int
    {
        return $this->taxiDriverId;
    }

    public function getCustomerId(): int
    {
        return $this->customerId;
    }

    public function getClass(): int
    {
        return $this->class;
    }

    public function getDayCreated(): DateTime
    {
        return $this->dayCreated;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getStatus(): int
    {
        return $this->orderStatus;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setPointB(string $pointB): void
    {
        $this->pointB = $pointB;
    }

    public function setPointA(string $pointA): void
    {
        $this->pointA = $pointA;
    }

    public function setTaxiDriverId(?int $taxiDriverId): void
    {
        $this->taxiDriverId = $taxiDriverId;
    }

    public function setCustomerId(int $customerId): void
    {
        $this->customerId = $customerId;
    }

    public function setClass(int $class): void
    {
        $this->class = $class;
    }

    public function setDayCreated(DateTime $dayCreated): void
    {
        $this->dayCreated = $dayCreated;
    }

    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    public function setOrderStatus(int $orderStatus): void
    {
        $this->orderStatus = $orderStatus;
    }

    public function getOrderStatus(): int
    {
        return $this->orderStatus;
    }

    public function failed(): void
    {
        $this->orderStatus = self::STATE_FAILED;
    }

    public function stateNew(): void
    {
        $this->orderStatus = self::STATE_NEW;
    }

    public function accepted(): void
    {
        $this->orderStatus = self::STATE_ACCEPTED;
    }

    public function inProgress(): void
    {
        $this->orderStatus = self::STATE_IN_PROGRESS;
    }

    public function complete(): void
    {
        $this->orderStatus = self::STATE_COMPLETE;
    }

    public function reviewGiven(): void
    {
        $this->reviewGiven = true;
    }


    public function calculatePrice(Customer $customer): int
    {
        $priceDefault = rand(50, 250);

        if ($this->class == Car::FIRST) {
            $this->price = $priceDefault * 3;
        } elseif ($this->class == Car::SECOND) {
            $this->price = $priceDefault * 2;
        } elseif ($this->class == Car::THIRD) {
            $this->price = $priceDefault;
        }
        $this->price = $this->price - ($this->price * ($customer->getPersonalDiscount() / 100)); //цена со скидкой
        return $this->price;
    }

    public function calculateDayCreated(): DateTime
    {
        $dateCreated = new DateTime();
        $this->dayCreated = $dateCreated;
        $this->dayCreated->setTimezone(new DateTimeZone("Europe/Moscow"));
        return $this->dayCreated;
    }
}

