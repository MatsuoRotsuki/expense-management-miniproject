<?php

require_once 'app/models/Model.php';

class Expense extends Model
{
    protected $table = 'expenses';

    protected $primaryKey = 'id';
    protected $attributes = [
        'category',
        'description',
        'amount',
        'image',
        'location',
        'created_at',
        'updated_at',
        'user_id',
    ];
}
