<?php

namespace App\Framework;

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
     * returns array of stdClass if more than one matches, null if there aren't any, and stdClass if one match found
     */

    public function findByValue($table, $columnName, $value): mixed
    {
        $stmt = $this->connection->prepare("SELECT * FROM $table WHERE $columnName = :value");
        $stmt->execute([':value' => $value]);
        $models = $stmt->fetchAll(PDO::FETCH_OBJ);
        return count($models) === 1 ? $models[0] : (count($models) > 1 ? $models : null);
    }

    /**
     * @return stdClass (Model) from table, with empty parameters.
     */
    public function createModel(string $table): stdClass
    {
        $model = new stdClass();
        $columns = $this->connection->query(
            "SELECT column_name FROM information_schema.columns WHERE table_name = '$table'"
        )
            ->fetchAll(PDO::FETCH_COLUMN);

        foreach ($columns as $column) {
            $model->$column = null;
        }

        return $model;
    }

    /**
     * Inserts or updates a model in the specified table.
     * * Notice that this method WILL NOT insert null parameters into db
     *  * If model does not yet exist in db, returns same model with id, set by database,
     * using lastInsertId()
     */
    public function push(string $table, stdClass $model): stdClass
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
        $thisModel = $stmt->fetch(PDO::FETCH_OBJ);
        if ($thisModel) {
            // If model exists, update it
            $update = [];
            foreach ($arrKeys as $column) {
                if ($column != $id)
                    $update[] = "$column = :$column";
            }
            $update = implode(',', $update);
            $stmt = $this->connection->prepare("UPDATE $table SET $update WHERE $id = :id");
            $stmt->execute($notNullArr);
        } else {
            $columns = implode(',', $arrKeys);
            $values = ':' . implode(', :', $arrKeys);
            $stmt = $this->connection->prepare("INSERT INTO $table ($columns) VALUES ($values)");
            $stmt->execute($notNullArr);
            $model->id = (int) $this->connection->lastInsertId();
        }
        return $model;
    }

}