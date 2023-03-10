<?php

namespace App\Repositories;
class TaxiDriverRepository
{
    private PDO $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function findById(int $id): ?TaxiDriver
    {

        $specificTaxiDriver = "SELECT * FROM taxidriver WHERE id = :id";
        $statement = $this->connection->prepare($specificTaxiDriver);
        $statement->execute(["id" => $id]);
        $taxiDriver = $statement->fetch();

        if ($taxiDriver !== false) {
            return new TaxiDriver(
                $taxiDriver->id,
                $taxiDriver->firstName,
                $taxiDriver->secondName,
                date_create_from_format('Y-m-d H:i:s', $taxiDriver->birthday),
                $taxiDriver->experience,
                $taxiDriver->rating,
                $taxiDriver->qualification,
                $taxiDriver->carDriving,
                $taxiDriver->reviewHeap,
                $taxiDriver->reviewsGiven,
                true
            );
        }
        return null;
    }

    public function save(TaxiDriver $taxiDriver)
    {
        if (!$taxiDriver->isSaved()) {
            $insert = "INSERT INTO `taxidriver`
                (
                firstName,
                secondName,
                birthday,
                experience,
                rating,
                qualification,
                carDriving,
                reviewHeap,
                reviewsGiven
                ) 
        VALUES (
                :firstName,
                :secondName,
                :birthday,
                :experience,
                :rating,
                :qualification,
                :carDriving,
                :reviewHeap,
                :reviewsGiven)";
            $stmt = $this->connection->prepare($insert);
            $stmt->execute(
                [
                    "firstName" => $taxiDriver->getFirstName(),
                    "secondName" => $taxiDriver->getSecondName(),
                    "birthday" => $taxiDriver->getBirthday()->format('Y-m-d H:i:s'),
                    "experience" => $taxiDriver->getExperience(),
                    "rating" => $taxiDriver->getRating(),
                    "qualification" => $taxiDriver->getQualification(),
                    "carDriving" => $taxiDriver->getCarDriving(),
                    "reviewHeap" => $taxiDriver->getReviewHeap(),
                    "reviewsGiven" => $taxiDriver->getReviewsGiven()
                ]
            );
        } else {
            $command = "UPDATE `taxidriver`
                    SET 
                        experience = :experience,
                        rating = :rating,
                        carDriving = :carDriving,
                        reviewHeap = :reviewHeap,
                        reviewsGiven = :reviewsGiven
                        WHERE id = :id;";
            $stmt = $this->connection->prepare($command);
            $stmt->execute(
                [
                    "id" => $taxiDriver->getId(),
                    "experience" => $taxiDriver->getExperience(),
                    "rating" => $taxiDriver->getRating(),
                    "carDriving" => $taxiDriver->getCarDriving(),
                    "reviewHeap" => $taxiDriver->getReviewHeap(),
                    "reviewsGiven" => $taxiDriver->getReviewsGiven()
                ]
            );
        }
    }
}