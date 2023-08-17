<?php

require_once './Model.php';

class Expense extends Model {
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

echo var_dump(Expense::update(1,['description' => 'thu dien dien', 'amount' => '100000', 'category' => 1, 'location' => 'Dai hoc bach khoa Ha Noi', 'user_id' => 1]));

?>