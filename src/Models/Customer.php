<?php

namespace App\Models;

use DateTime;

class Customer
{
    private ?int $id;

    private ?string $password;
    private string $user_type;

    private ?string $firstName;
    private ?string $secondName;
    private ?DateTime $birthday;
    private int $personalDiscount;
    private string $phoneNum;
    private int $orderCount;
    private int $orderDeclinedCount;
    private bool $isSaved;


    public function __construct( // с параметрами
        ?int      $id,
        ?string   $firstName,
        ?string   $secondName,
        ?DateTime $birthday,
        int       $personalDiscount,
        string    $phoneNum,
        int       $orderCount,
        int       $orderDeclinedCount,
        bool      $isSaved
    )
    {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->secondName = $secondName;
        $this->birthday = $birthday;
        $this->personalDiscount = $personalDiscount;
        $this->phoneNum = $phoneNum;
        $this->orderCount = $orderCount;
        $this->orderDeclinedCount = $orderDeclinedCount;
        $this->isSaved = $isSaved;
    }

    public function isSaved(): bool
    {
        return $this->isSaved;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function getBirthday(): ?DateTime
    {
        return $this->birthday;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getSecondName(): ?string
    {
        return $this->secondName;
    }

    public function getPersonalDiscount(): int
    {
        return $this->personalDiscount;
    }

    public function getOrderCount(): int
    {
        return $this->orderCount;
    }

    public function getOrderDeclinedCount(): int
    {
        return $this->orderDeclinedCount;
    }

    public function getPhoneNum(): string
    {
        return $this->phoneNum;
    }

    public function setBirthday(?DateTime $birthday): void
    {
        $this->birthday = $birthday;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setSecondName(?string $secondName): void
    {
        $this->secondName = $secondName;
    }

    public function setPersonalDiscount(int $personalDiscount): void
    {
        $this->personalDiscount = $personalDiscount;
    }

    public function setFirstName(?string $firstName): void
    {
        $this->firstName = $firstName;
    }

    public function setOrderCount(int $orderCount): void
    {
        $this->orderCount = $orderCount;
    }

    public function setOrderDeclinedCount(int $orderDeclinedCount): void
    {
        $this->orderDeclinedCount = $orderDeclinedCount;
    }

    public function setPhoneNum(string $phoneNum): void
    {
        $this->phoneNum = $phoneNum;
    }

    public function updateOrderCount()
    {
        $this->orderCount = ($this->orderCount + 1);
        if ($this->orderCount > 5 && $this->orderCount <= 10) {
            $this->personalDiscount = 5;
        } elseif ($this->orderCount > 10 && $this->orderCount <= 15) {
            $this->personalDiscount = 10;
        } elseif ($this->orderCount > 15 && $this->orderCount <= 20) {
            $this->personalDiscount = 15;
        } elseif ($this->orderCount > 20) {
            $this->personalDiscount = 20;
        }
    }

    public function declinedOrder(): void
    {
        $this->orderDeclinedCount = +1;
    }

}