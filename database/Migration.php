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
            CREATE TABLE cars (
            id SERIAL PRIMARY KEY,
            brand VARCHAR(50),
            plates VARCHAR(50),
            color VARCHAR(50),
            car_class INTEGER,
            created_at TIMESTAMP DEFAULT NOW(),
            updated_at TIMESTAMP DEFAULT NOW()
        );

        CREATE TABLE customers (
            id SERIAL PRIMARY KEY,
            phone_number VARCHAR(20) UNIQUE,
            password VARCHAR(255) DEFAULT NULL,
            first_name VARCHAR(50) DEFAULT NULL,
            second_name VARCHAR(50) DEFAULT NULL,
            birthday TIMESTAMP DEFAULT NULL,
            personal_discount INTEGER DEFAULT NULL,
            order_count INTEGER NOT NULL,
            order_declined_count INTEGER,
            user_type VARCHAR(255) DEFAULT \'Customer\',
            created_at TIMESTAMP DEFAULT NOW(),
            updated_at TIMESTAMP DEFAULT NOW()
        );

        CREATE TABLE taxi_drivers (
            id SERIAL PRIMARY KEY,
            phone_number VARCHAR(20) UNIQUE,
            password VARCHAR(255) NOT NULL,
            first_name VARCHAR(50) NOT NULL ,
            second_name VARCHAR(50) NOT NULL ,
            birthday TIMESTAMP NOT NULL ,
            experience INT,
            rating FLOAT,
            qualification varchar(20) NOT NULL,
            car_driving INT,
            review_heap INT,
            reviews_given INT,
            order_declined_count INTEGER,
            user_type VARCHAR(255) DEFAULT \'TaxiDriver\',
            created_at TIMESTAMP DEFAULT NOW(),
            updated_at TIMESTAMP DEFAULT NOW(),
            FOREIGN KEY(car_driving) REFERENCES cars(id)
        );

        CREATE TABLE orders (
            id SERIAL PRIMARY KEY,
            taxi_driver_id INTEGER,
            customer_id INTEGER,
            status INTEGER NOT NULL,
            class INTEGER NOT NULL,
            price FLOAT NOT NULL,
            point_a VARCHAR(50) NOT NULL,
            point_b VARCHAR(255) NOT NULL,
            review_given BOOLEAN DEFAULT false,
            created_at TIMESTAMP DEFAULT NOW(),
            updated_at TIMESTAMP DEFAULT NOW(),
            FOREIGN KEY(taxi_driver_id) REFERENCES taxi_drivers(id),
            FOREIGN KEY (customer_id) REFERENCES customers(id)
        );
        ';
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

