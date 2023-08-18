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
        $stmt = Database::prepare($statement);
        $stmt->execute();

        $result = $stmt->get_result();

        $rows = [];
        while($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }

        $stmt->close();
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

            $statement = "SELECT * from $table where id = ?";
            $stmt = Database::prepare($statement);
            $stmt->bind_param('i', $identifier);
            $stmt->execute();

            $result = $stmt->get_result();
    
            if ($result->num_rows === 0) {
                $stmt->close();
                return null;
            } else {
                $row = $result->fetch_assoc();
                foreach ($row as $key => $value) {
                    $model->{$key} = $value;
                }
                $stmt->close();
                return $model;
            }
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

            $types = '';
            $params = [];

            $whereConditions = [];
            foreach ($assoc_array as $key => $value) {
                $whereConditions[] = $key . " = ?";
                $types .= 's';
                $params[] = $value;
            }

            $whereClause = implode(" AND ", $whereConditions);

            $statement = "SELECT * FROM $table WHERE $whereClause";
            $stmt = Database::prepare($statement);

            $stmt->bind_param($types, ...$params);
            $stmt->execute();
            
            $result = $stmt->get_result();

            $rows = [];
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $rows[] = $row;
                }
            }

            $stmt->close();
            return $rows;
        } catch (Exception $e)
        {
            echo $e->getMessage();
        }
    }

    public static function whereIn(string $attribute_name, array $array)
    {
        try {
            $model = new static;
            $table = $model->table;

            $types = '';
            $params = [];

            $values = implode(', ', array_fill(0, count($array), '?'));
            foreach ($array as $value) {
                $types .= 's';
                $params[] = $value;
            }
            $statement = "SELECT * FROM $table WHERE $attribute_name IN ($values)";
            $stmt = Database::prepare($statement);

            $stmt->bind_param($types, ...$params);
            $stmt->execute();

            $result = $stmt->get_result();

            $rows = [];
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $rows[] = $row;
                }
            }
            $stmt->close();
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

            $statement = "SELECT * FROM $table WHERE $attribute_name BETWEEN ? AND ?";
            $stmt = Database::prepare($statement);

            $stmt->bind_param('ss', $lower_bound, $upper_bound);
            $stmt->execute();

            $result = $stmt->get_result();

            $rows = [];
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $rows[] = $row;
                }
            }
            $stmt->close();
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

    public static function update($identifier, array $assoc_array)
    {
        try {
            $model = new static;
            $table = $model->table;
            $primaryKey = $model->primaryKey;
            $types = '';
            $params = [];
            $setParts = [];

            foreach ($assoc_array as $key => $value) {
                $setParts[] = $key . ' = ?';
                $types .= 's';
                $params[] = $value;
            }
            
            //id
            $types .= 'i';
            $params[] = $identifier;

            $setClauses = join(", ", $setParts);

            $statement = "UPDATE $table SET $setClauses WHERE $primaryKey = ?";
            $stmt = Database::prepare($statement);

            $stmt->bind_param($types, ...$params);
            $stmt->execute();

            $stmt->close();

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

            $model = self::find($identifier);

            $statement = "DELETE FROM $table WHERE $primaryKey = ?";
            $stmt = Database::prepare($statement);

            $stmt->bind_param('i', $identifier);
            $stmt->execute();
            
            $stmt->close();
            return $model;
        } catch (Exception $e)
        {
            echo $e->getMessage();
        }
    }
}
