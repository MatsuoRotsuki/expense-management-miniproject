<?php

require_once "app/database/Database.php";

trait Query
{

    /**
     * Retrieve all data from table
     */
    public static function all(): array
    {
        $model = new static;
        $table = $model->table;
        $statement = "SELECT * from $table";
        $result = Database::getConnection()->query($statement);
        $rows = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }
        }
        return $rows;
    }

    /**
     * Retrieve one instance from table with specific id
     */
    public static function find($id)
    {
        $model = new static;
        $table = $model->table;
        $statement = "SELECT * from $table where id = $id";
        $result = Database::getConnection()->query($statement);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row;
        } else return null;
    }

    public static function where($assoc_array)
    {
        $model = new static;
        $table = $model->table;

        $whereparts = [];

        foreach ($assoc_array as $key => $value) {
            $whereparts[] = $key . " = '" . $value . "' ";
        }

        $whereclauses = join(" AND ", $whereparts);

        $statement = "SELECT * FROM $table WHERE $whereclauses";
        $result = Database::getConnection()->query($statement);

        $rows = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }
        } else return null;

        return $rows;
    }

    public static function create(array $assoc_array)
    {
        $model = new static;
        $table = $model->table;

        $columns = implode(', ', array_keys($assoc_array));
        $values = implode(', ', array_fill(0, count($assoc_array), '?'));

        $statement = "INSERT INTO $table ($columns) VALUES ($values)";

        $connection = Database::getConnection();
        $stmt = $connection->prepare($statement);

        $types = '';
        $params = [];

        foreach ($assoc_array as $key => $value) {
            $types .= 's';
            $params[] = $value;
        }

        $stmt->bind_param($types, ...$params);
        $stmt->execute();

        $id = $stmt->insert_id;

        $query = "SELECT * FROM $table WHERE id = ?";
        $stmt = $connection->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $record = $result->fetch_assoc();

        return $record;
    }

    public static function update($id, array $data): bool
    {
        $model = new static;
        $table = $model->table;
        $setParts = [];

        foreach ($data as $key => $value) {
            $setParts[] = $key . " = " . "'$value'";
        }

        $setClauses = join(", ", $setParts);

        $statement = "UPDATE $table SET $setClauses WHERE id = $id";
        $result = Database::getConnection()->query($statement);

        return $result;
    }

    public static function delete($id): bool
    {
        $model = new static;
        $table = $model->table;
        $statement = "DELETE FROM $table WHERE id = $id";
        $result = Database::getConnection()->query($statement);
        return $result;
    }
}
