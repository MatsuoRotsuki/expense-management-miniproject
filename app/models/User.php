<?php
require_once 'app/models/Model.php';

class User extends Model
{
    protected $table = 'users';

    protected $primaryKey = 'id';

    protected $attributes = [
        'first_name',
        'last_name',
        'email',
        'password',
    ];
}
