<?php

require_once "app/models/Query.php";

abstract class Model implements JsonSerializable
{

    use Query;

    protected $table;

    protected $primaryKey;

    protected $attributes = [];

    public function getTable()
    {
        return $this->table;
    }

    public function jsonSerialize(): mixed
    {
        return $this;
    }
}
