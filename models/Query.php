<?php

require_once "../database/Database.php";

trait Query {

    /**
     * Retrieve all data from table
     */
    public static function all() : array
    {
        try {
            $model = new static;
            $table = $model->table;
            $statement = "SELECT * from $table";
            $result = Database::getConnection()->query($statement);
            $rows = [];

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $rows[] = $row;
                }
            }
            return $rows;
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
            $statement = "SELECT * from $table where $primaryKey = $identifier";
            $result = Database::query($statement);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                foreach ($row as $key => $value) {
                    $model->{$key} = $value;
                }
                return $model;
            } else return null;
        } catch(Exception $e)
        {
            echo $e->getMessage();
        }
    }

    /**
     * Call where clause
     * Model::where(['attr1' => $value1, 'attr2' => $value2 ]);
     * Example Model::where('name','like','something');
     * Example Model::where(['amount','>=','something']);
     * Model::whereIn('name',['A','B']);
     * Model::whereBetween('attribute','2023-07-08', '2023-07-09')
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
            $result = Database::getConnection()->query($statement);
    
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
        $model = new static;
        $table = $model->table;

        try {
            $statement = "SELECT * FROM $table WHERE $attribute_name BETWEEN $lower_bound AND $upper_bound";
            $result = Database::query($statement);

            $rows = [];
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $rows[] = $row;
                }
            }
            
            // foreach($rows as $row) {
            //     foreach ($row as $key => $value){
            //         $model->{$key} = $value;
            //     }
            // }
            return $rows;

        } catch (Exception $e)
        {
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

        try {
            $assoc_array['created_at'] = date('Y-m-d H:i:s');
            $assoc_array['updated_at'] = date('Y-m-d H:i:s');
    
            $columns = [];
            $values = [];
            foreach($assoc_array as $key => $value){
                $columns[] = $key;
                $values[] = "'" . $value . "'";
            }
    
            $columns = join(', ', $columns);
            $values = join(', ', $values);
    
            $statement = "INSERT INTO $table ($columns) VALUES ($values)";
            $result = Database::query($statement);

            if ($result) {
                foreach($assoc_array as $key => $value){
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
     * Update model object into tables and return updated one
     */
    public static function update($id, array $data)
    {
        $model = new static;
        $table = $model->table;
        $primaryKey = $model->primaryKey;
        
        try {
            
            $setParts = [];
        
            foreach ($data as $key => $value) {
                $setParts[] = $key . " = " . "'$value'";
            }

            $setClauses = join(", ", $setParts);

            $statement = "UPDATE $table SET $setClauses WHERE $primaryKey = $id";
            Database::query($statement);
            
            return self::find($id);

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
            $result = Database::getConnection()->query($statement);
            return $result;
        } catch (Exception $e)
        {
            echo $e->getMessage();
        }
    }
}

?>