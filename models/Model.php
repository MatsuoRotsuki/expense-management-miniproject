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

class User extends Model {
    protected $table = 'users';

    protected $primaryKey = 'id';

    protected $attributes = [
        'first_name',
        'last_name',
        'email',
        'password',
    ];
}

echo json_encode(User::create([
    'first_name' => 'Loc',
    'last_name' => 'Pham Tien',
    'email' => 'loclienhadonganh@gmail.com',
    'password' => '123456',
]));

?>