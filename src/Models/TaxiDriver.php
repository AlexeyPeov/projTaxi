<?php

namespace App\Models;
use DateTime;

class TaxiDriver
{
    private int $id;
    private string $firstName;
    private string $secondName;
    private DateTime $birthday;
    private int $experience;
    private ?float $rating;
    private string $qualification;
    private int $carDriving;
    private ?int $reviewHeap;
    private ?int $reviewsGiven;
    private bool $isSaved;

    public function __construct(
        int      $id,
        string   $firstName,
        string   $secondName,
        DateTime $birthday,
        int      $experience,
        ?float   $rating,
        string   $qualification,
        int      $carDriving,
        ?int     $reviewTotal,
        ?int     $reviewsGiven,
        bool     $isSaved
    )
    {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->secondName = $secondName;
        $this->birthday = $birthday;
        $this->experience = $experience;
        $this->rating = $rating;
        $this->qualification = $qualification;
        $this->carDriving = $carDriving;
        $this->reviewHeap = $reviewTotal;
        $this->reviewsGiven = $reviewsGiven;
        $this->isSaved = $isSaved;
    }

    public function isSaved(): bool
    {
        return $this->isSaved;
    }

    public function getReviewsGiven(): ?int
    {
        return $this->reviewsGiven;
    }

    public function getReviewHeap(): ?int
    {
        return $this->reviewHeap;
    }

    public function setReviewsGiven(int $reviewsGiven): void
    {
        $this->reviewsGiven = $reviewsGiven;
    }

    public function setReviewHeap(int $reviewHeap): void
    {
        $this->reviewHeap = $reviewHeap;
    }

    public function getCarDriving(): int
    {
        return $this->carDriving;
    }

    public function setCarDriving(int $carDriving): void
    {
        $this->carDriving = $carDriving;
    }

    public function getQualification(): string
    {
        return $this->qualification;
    }

    public function getRating(): ?float
    {
        return $this->rating;
    }

    public function getExperience(): int
    {
        return $this->experience;
    }

    public function getSecondName(): string
    {
        return $this->secondName;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getBirthday(): DateTime
    {
        return $this->birthday;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setRating(float $rating): void
    {
        $this->rating = $rating;
    }

    public function setQualification(string $qualification): void
    {
        $this->qualification = $qualification;
    }

    public function setExperience(int $experience): void
    {
        $this->experience = $experience;
    }

    public function setSecondName(string $secondName): void
    {
        $this->secondName = $secondName;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setBirthday(DateTime $birthday): void
    {
        $this->birthday = $birthday;
    }

    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    public function takeCar(int $carId)
    {

    } //todo ????????????

    public function reviewIsGiven(): void
    {
        $this->reviewsGiven = +1;
    }

    public function addReviewToHeap(int $review): void
    {
        $this->reviewHeap = +$review;
    }

    public function displayRating(): void
    {
        if ($this->reviewsGiven > 9) {
            $this->rating = $this->reviewHeap / $this->reviewsGiven;
        }
    }


}