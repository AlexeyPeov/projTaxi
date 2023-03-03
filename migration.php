<?php

class Migration
{
    private PDO $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function up()
    {
        $create = '
            CREATE TABLE "car" (
            id SERIAL,
            brand CHAR(50) NOT NULL,
            plates CHAR(20) NOT NULL,
            color CHAR(50) NOT NULL,
            carClass INT NOT NULL,
            PRIMARY KEY (id)
                               
        );

        CREATE TABLE "customer" (
            id SERIAL,
            firstName CHAR(50),
            secondName CHAR(50),
            birthday TIMESTAMP,
            personalDiscount INT,
            phoneNum CHAR(20) NOT NULL,
            orderCount INT,
            orderDeclinedCount INT,
            PRIMARY KEY (id)
        );

        CREATE TABLE "taxidriver" (
            id SERIAL,
            firstName CHAR(50) NOT NULL,
            secondName CHAR(50) NOT NULL,
            birthday TIMESTAMP NOT NULL,
            experience INT,
            rating FLOAT,
            qualification char(20) NOT NULL,
            carDriving INT,
            reviewHeap INT,
            reviewsGiven INT,
            PRIMARY KEY (id),
            FOREIGN KEY(carDriving) REFERENCES car(id)
        );

        CREATE TABLE "order" (
            id SERIAL,
            orderStatus INT NOT NULL,
            customerId INT,
            taxiDriverId INT,
            class INT NOT NULL,
            price FLOAT NOT NULL,
            pointA CHAR(50) NOT NULL,
            pointB CHAR(50) NOT NULL,
            dayCreated TIMESTAMP NOT NULL,
            reviewGiven BOOLEAN,
            PRIMARY KEY (id),
            FOREIGN KEY(taxiDriverId) REFERENCES taxidriver(id),
            FOREIGN KEY (customerId) REFERENCES customer(id)
        );
        ';
    }

    public function down()
    {
        $delete = '
                DROP TABLE "order";
                DROP TABLE taxidriver;
                DROP TABLE car;
                DROP TABLE customer;
            
        ';
        $this->connection->query($delete);
    }

    public function downCar()
    {
        $delete = '
            DROP TABLE "car";
        ';

        $this->connection->query($delete);
    }
}

