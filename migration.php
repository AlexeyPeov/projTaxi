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
        $create = "
            CREATE TABLE car (
            id INT NOT NULL AUTO_INCREMENT,
            brand VARCHAR(50) NOT NULL,
            plates VARCHAR(20) NOT NULL,
            color VARCHAR(50) NOT NULL,
            carClass INT NOT NULL,
            PRIMARY KEY (id)
                               
        );

        CREATE TABLE customer (
            id INT NOT NULL AUTO_INCREMENT,
            firstName VARCHAR(50),
            secondName VARCHAR(50),
            birthday DATETIME,
            personalDiscount INT,
            phoneNum VARCHAR(20) NOT NULL,
            orderCount INT,
            orderDeclinedCount INT,
            PRIMARY KEY (id)
        );

        CREATE TABLE taxidriver (
            id INT NOT NULL AUTO_INCREMENT,
            firstName VARCHAR(50) NOT NULL ,
            secondName VARCHAR(50) NOT NULL ,
            birthday DATETIME NOT NULL ,
            experience INT,
            rating FLOAT,
            qualification varchar(20) NOT NULL,
            carDriving INT,
            reviewHeap INT,
            reviewsGiven INT,
            PRIMARY KEY (id),
            FOREIGN KEY(carDriving) REFERENCES car(id)
        );

        CREATE TABLE `order` (
            id INT NOT NULL AUTO_INCREMENT,
            orderStatus INT NOT NULL,
            customerId INT,
            taxiDriverId INT,
            class INT NOT NULL,
            price FLOAT NOT NULL,
            pointA VARCHAR(50) NOT NULL,
            pointB VARCHAR(50) NOT NULL,
            dayCreated DATETIME NOT NULL,
            reviewGiven BOOLEAN,
            PRIMARY KEY (id),
            FOREIGN KEY(taxiDriverId) REFERENCES taxidriver(id),
           FOREIGN KEY (customerId) REFERENCES customer(id)
        );
        ";
        $this->connection->query($create);
    }

    public function down()
    {
        $delete = "
                DROP TABLE `order`;
                DROP TABLE taxidriver;
                DROP TABLE car;
                DROP TABLE customer;
            
        ";
        $this->connection->query($delete);
    }
}

