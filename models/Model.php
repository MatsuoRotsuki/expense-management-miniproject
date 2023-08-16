<?php

require_once "./Query.php";

abstract class Model implements JsonSerializable {
    
    use Query;

    protected $table;

    protected $primaryKey;

    protected $attributes = [];

    public function getTable() {
        return $this->table;
    }

    public function jsonSerialize() : mixed
    {
        return $this;
    }
}

?>