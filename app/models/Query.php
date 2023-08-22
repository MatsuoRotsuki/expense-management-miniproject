<?php

require_once "app/database/Database.php";

trait Query
{

    /**
     * Retrieve all data from table
     */
    public static function all(): array
    {
        try {
            $model = new static;
            $table = $model->table;

            $statement = "SELECT * from $table";
            $stmt = Database::prepare($statement);
            $stmt->execute();

            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $results;
        } catch (Exception $e) {
            echo $e->getMessage();
            return [];
        }
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

            $statement = "SELECT * from $table where $primaryKey = :identifier";
            $stmt = Database::prepare($statement);
            $stmt->bindParam(':identifier', $identifier);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
            if (!$result) {
                return null;
            } else {
                foreach ($result as $key => $value) {
                    $model->{$key} = $value;
                }
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

            $whereConditions = [];
            foreach ($assoc_array as $key => $value) {
                $whereConditions[] = $key . " = :$key";
            }

            $whereClause = implode(" AND ", $whereConditions);

            $statement = "SELECT * FROM $table WHERE $whereClause";
            $stmt = Database::prepare($statement);

            $stmt->execute($assoc_array);
            
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $results;
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

            $values = implode(', ', $array);

            $statement = "SELECT * FROM $table WHERE :attribute_name IN (:values)";
            $stmt = Database::prepare($statement);

            $stmt->execute([
                'attribute_name' => $attribute_name,
                'values' => $values
            ]);

            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $results;
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

            $statement = "SELECT * FROM $table WHERE $attribute_name BETWEEN :lower_bound AND :upper_bound";
            $stmt = Database::prepare($statement);

            $stmt->execute([
                'lower_bound' => $lower_bound,
                'upper_bound' => $upper_bound,
            ]);

            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $results;

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
        try {
            $model = new static;
            $table = $model->table;
            $primaryKey = $model->primaryKey;
    
            $columns =  [];
            $createvalues = [];
            foreach ($assoc_array as $key => $value)
            {
                $columns[] = $key;
                $createvalues[] = ':' . $key;
            }
            $columns = implode(', ', $columns);
            $createvalues = implode(', ', $createvalues);
    
            $statement = "INSERT INTO $table ($columns) VALUES ($createvalues)";
            $stmt = Database::prepare($statement);

            $stmt->execute($assoc_array);

            //GET INSERTED ROW
            $insert_id = Database::getConnection()->lastInsertId();
            $newSTMT = Database::prepare("SELECT * FROM $table WHERE $primaryKey = :identifier");
            $newSTMT->bindParam(':identifier', $insert_id);
            $newSTMT->execute();

            $result = $newSTMT->fetch(PDO::FETCH_ASSOC);

            return $result;

        } catch(Exception $e)
        {
            echo $e->getMessage();
        }

        // $stmt->bind_param($types, ...$params);
        // $stmt->execute();

        // $id = $stmt->insert_id;

        // $query = "SELECT * FROM $table WHERE id = ?";
        // $stmt = $connection->prepare($query);
        // $stmt->bind_param('i', $id);
        // $stmt->execute();
        // $result = $stmt->get_result();
        // $record = $result->fetch_assoc();

        // return $record;
    }

    public static function update($identifier, array $assoc_array)
    {
        try {
            $model = new static;
            $table = $model->table;
            $primaryKey = $model->primaryKey;

            foreach ($assoc_array as $key => $value) {
                $setParts[] = $key . ' = :' . $key;
            }

            $setClauses = join(", ", $setParts);

            $statement = "UPDATE $table SET $setClauses WHERE $primaryKey = :identifier";
            $stmt = Database::prepare($statement);
            $assoc_array['identifier'] = $identifier;

            $stmt->execute($assoc_array);

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

            $statement = "DELETE FROM $table WHERE $primaryKey = :identifier";
            $stmt = Database::prepare($statement);

            $stmt->bindParam(':identifier', $identifier);
            $stmt->execute();
            
            return $model;
        } catch (Exception $e)
        {
            echo $e->getMessage();
        }
    }
}
