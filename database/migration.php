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
            CREATE TABLE cars (
            id SERIAL PRIMARY KEY,
            brand VARCHAR(50),
            plates VARCHAR(50),
            color VARCHAR(50),
            carClass INTEGER,
            created_at TIMESTAMP,
            updated_at TIMESTAMP
        );

        CREATE TABLE customers (
            id SERIAL PRIMARY KEY,
            phoneNumber VARCHAR(20),
            password VARCHAR(255) DEFAULT NULL,
            firstName VARCHAR(50) DEFAULT NULL,
            secondName VARCHAR(50) DEFAULT NULL,
            birthday TIMESTAMP DEFAULT NULL,
            personalDiscount INTEGER DEFAULT NULL,
            orderCount INTEGER NOT NULL,
            orderDeclinedCount INTEGER NOT NULL,
            user_type VARCHAR(255) DEFAULT 'Customer',
            created_at TIMESTAMP NOT NULL,
            updated_at TIMESTAMP NOT NULL
        );

        CREATE TABLE taxi_drivers (
            id INT NOT NULL AUTO_INCREMENT,
            phoneNumber VARCHAR(20),
            password VARCHAR(255) NOT NULL,
            firstName VARCHAR(50) NOT NULL ,
            secondName VARCHAR(50) NOT NULL ,
            birthday DATETIME NOT NULL ,
            experience INT,
            rating FLOAT,
            qualification varchar(20) NOT NULL,
            carDriving INT,
            reviewHeap INT,
            reviewsGiven INT,
            user_type VARCHAR(255) DEFAULT 'TaxiDriver',
            PRIMARY KEY (id),
            FOREIGN KEY(carDriving) REFERENCES cars(id)
        );

        CREATE TABLE orders (
            id SERIAL PRIMARY KEY,
            taxiDriverId INTEGER,
            customerId INTEGER,
            orderStatus INTEGER NOT NULL,
            class INTEGER NOT NULL,
            price FLOAT NOT NULL,
            pointA VARCHAR(50) NOT NULL,
            pointB VARCHAR(255) NOT NULL,
            reviewGiven BOOLEAN DEFAULT NULL,
            created_at TIMESTAMP NOT NULL,
            updated_at TIMESTAMP NOT NULL,
            FOREIGN KEY(taxiDriverId) REFERENCES taxi_drivers(id),
            FOREIGN KEY (customerId) REFERENCES customers(id)
        );
        ";
        $this->connection->query($create);
    }

    public function down()
    {
        $delete = "
                DROP TABLE orders;
                DROP TABLE taxi_drivers;
                DROP TABLE cars;
                DROP TABLE customers;
            
        ";
        $this->connection->query($delete);
    }
}

