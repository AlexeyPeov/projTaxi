<?php

namespace App\config;

use PDO;
use stdClass;

class ORM
{
    private PDO $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @return PDO
     */
    public function getConnection(): PDO
    {
        return $this->connection;
    }

    /**
     * @return ?stdClass (Model) from db if exists, and null if it doesn't
     */
    public function findById($table, $id): ?stdClass
    {
        $model = new stdClass();
        $columns = $this->connection->query(
            "SELECT column_name FROM information_schema.columns WHERE table_name = '$table'"
        )->fetchAll(PDO::FETCH_COLUMN);

        $stmt = $this->connection->prepare("SELECT * FROM $table WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            foreach ($columns as $column) {
                $model->$column = $row[$column];
            }
        } else {
            $model = null;
        }
        return $model;
    }

    /**
     * @return stdClass (Model) from table, with empty parameters.
     */
    public function createModel(string $table): stdClass
    {
        $model = new stdClass();
        $columns = $this->connection->query(
            "SELECT column_name FROM information_schema.columns 
                   WHERE table_name = '$table'"
        )->fetchAll(PDO::FETCH_COLUMN);

        foreach ($columns as $column) {
            $model->$column = null;
        }

        return $model;
    }

    /*$arr = get_object_vars($model);
    $clearArr = [];
    foreach ($arr as $k => $v){
    if($v != null){
    $clearArr[$k] = $v;
    }
    }*/

    /**
     * Inserts or updates a model in the specified table.
     * * Notice that this method WILL NOT insert null parameters into db
     */
    /*public function push(string $table, stdClass $model): void
    {
        // Get the columns and values of the model
        $rawColumns = array_keys(get_object_vars($model));
        $rawValues = array_values(get_object_vars($model));
        // Filter out columns that have null values
        $columns = array_filter($rawColumns, function ($column) use ($model) {
            return $model->$column !== null;
        });
        $values = array_intersect_key($rawValues, array_flip($columns));


        $arr = get_object_vars($model);
        $clearArr = [];
        $arrKeys = [];
        $arrValues = [];
        foreach ($arr as $k => $v){
            if($v != null){
                $clearArr[$k] = $v;
                $arrKeys[] = $k;
                $arrValues[] = $v;
            }
        }



        // Check if a row with the same id as the model exists in the table
        $stmt = $this->connection->prepare("SELECT * FROM $table WHERE id = ?");
        $stmt->execute([$model->id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            // If the row exists, update it with the values of the model
            $update = [];
            foreach ($columns as $column) {
                $update[] = "$column = ?";
            }
            $update = implode(',', $update);
            $stmt = $this->connection->prepare("UPDATE $table SET $update WHERE id = ?");
            $values[] = $model->id;
            $stmt->execute($values);
        } else {
            // If the row doesn't exist, insert a new row with the values of the model
            //cast array of values to string
            $columns = implode(',', $arrKeys);
            $num = count($arrValues);
            $result = ":" . implode(", :", $arrValues);

            // create as many '?' as there are columns of table
            $questionMarks = implode(',', array_fill(0, $num, '?'));
            $stmt = $this->connection->prepare("INSERT INTO $table ($columns) VALUES ($result)");

            $stmt->execute($values);
        }
    }*/

    public function push(string $table, stdClass $model): void
    {
        $arr = get_object_vars($model);
        $arrKeys = [];
        $notNullArr = [];
        foreach ($arr as $k => $v) {
            if ($v != null) {
                $notNullArr[$k] = $v;
                $arrKeys[] = $k;
            }
        }

        //in case 'id' is not called 'id' for some reason
        $stmt = $this->connection->prepare(
            "SELECT kcu.column_name
                    FROM information_schema.table_constraints tc
                    JOIN information_schema.key_column_usage kcu
                    ON tc.constraint_name = kcu.constraint_name
                    WHERE tc.table_name = ? AND tc.constraint_type = 'PRIMARY KEY'"
        );
        $stmt->execute([$table]);
        $id = $stmt->fetchColumn();


        // Check if a row with the same id as the model exists in the table
        $stmt = $this->connection->prepare("SELECT * FROM $table WHERE $id = ?");
        $stmt->execute([$model->id]);
        $thisModel = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($thisModel) {
            // If model exists, update it
            $update = [];
            foreach ($arrKeys as $column) {
                if($column != $id)
                $update[] = "$column = :$column";
            }
            $update = implode(',', $update);

            $stmt = $this->connection->prepare("UPDATE $table SET $update WHERE $id = :id");
        } else {
            $columns = implode(',', $arrKeys);
            $values = ':' . implode(', :', $arrKeys);
            $stmt = $this->connection->prepare("INSERT INTO $table ($columns) VALUES ($values)");
        }
        $stmt->execute($notNullArr);
    }

}