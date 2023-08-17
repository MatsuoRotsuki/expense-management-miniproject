<?php

class Category
{
    public const CATEGORY = [
        'Utilities' => 1,
        'Meal' => 2,
        'Rent' => 3,
        'Education' => 4,
        'Travel' => 5,
        'Medical' => 6,
        'Charity' => 7,
        'Tax' => 8,
        'Commuting' => 9,
        'Shopping' => 10,
        'Insurance' => 11,
        'Other' => 12,
    ];

    public static function getKeyFromValue($value)
    {
        $key = array_search($value, self::CATEGORY);
        return $key !== false ? $key : null;
    }
}
