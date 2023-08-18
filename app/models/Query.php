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
    public static function find($identifier)
    {
        try {
            $model = new static;
            $table = $model->table;
            $primaryKey = $model->primaryKey;

            $statement = "SELECT * from $table where $primaryKey = $identifier";
            $result = Database::query($statement);
    
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                foreach ($row as $key => $value) {
                    $model->{$key} = $value;
                }
                return $model;
            } else return null;
        } catch (Exception $e)
        {
            echo $e->getMessage();
        }
    }

    /**
     * Call where clause
     * Model::where(['attr1' => $value1, 'attr2' => $value2 ]);
     * Example Model::where('name','like','something');
     * Example Model::where(['amount','>=','something']);
     * Example Model::whereIn('name',['A','B']);
     * Example Model::whereBetween('attribute','2023-07-08', '2023-07-09')
     */
    public static function where(array $assoc_array)
    {
        try {
            $model = new static;
            $table = $model->table;

            $whereparts = [];

            foreach($assoc_array as $key => $value) {
                $whereparts[] = $key . " = '" . $value . "' ";
            }

            $whereclauses = join(" AND ", $whereparts);

            $statement = "SELECT * FROM $table WHERE $whereclauses";
            $result = Database::query($statement);

            $rows = [];
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $rows[] = $row;
                }
            } else return null;

            return $rows;
        } catch (Exception $e)
        {
            echo $e->getMessage();
        }
    }

    public static function whereIn(string $attribute_name, array $assoc_array)
    {
        try {
            $model = new static;
            $table = $model->table;

            $values = join(', ', $assoc_array);
            $statement = "SELECT * FROM $table WHERE $attribute_name IN (" . $values . ')';
            $result = Database::query($statement);

            $rows = [];
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $rows[] = $row;
                }
            }
            return $rows; 
        } catch (Exception $e)
        {
            echo $e->getMessage();
        }
    }

    public static function whereBetween(string $attribute_name, $lower_bound, $upper_bound)
    {
        try {
            $model = new static;
            $table = $model->table;

            $statement = "SELECT * FROM $table WHERE $attribute_name BETWEEN $lower_bound AND $upper_bound";
            $result = Database::query($statement);

            $rows = [];
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $rows[] = $row;
                }
            }
            return $rows;

        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Create model object and insert into table
     * Model::create(['attr1' => $value1, 'attr2' => $value2]);
     */
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

    public static function update($identifier, array $data)
    {
        try {
            $model = new static;
            $table = $model->table;
            $primaryKey = $model->primaryKey;
            $setParts = [];

            foreach ($data as $key => $value) {
                $setParts[] = $key . " = " . "'$value'";
            }

            $setClauses = join(", ", $setParts);

            $statement = "UPDATE $table SET $setClauses WHERE $primaryKey = $identifier";
            Database::query($statement);

            return self::find($identifier);
        } catch (Exception $e)
        {
            echo $e->getMessage();
        }
    }

    public static function delete($identifier)
    {
        try {
            $model = new static;
            $table = $model->table;
            $primaryKey = $model->primaryKey;
            $statement = "DELETE FROM $table WHERE $primaryKey = $identifier";
            $result = Database::query($statement);
            return $result;
        } catch (Exception $e)
        {
            echo $e->getMessage();
        }
    }
}
