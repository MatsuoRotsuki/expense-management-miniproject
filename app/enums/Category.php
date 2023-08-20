<?php

class Category
{
    public const CATEGORY = [
        1 => 'Utilities',
        2 => 'Meal',
        3 => 'Rent',
        4 => 'Education',
        5 => 'Travel',
        6 => 'Medical',
        7 => 'Charity',
        8 => 'Tax',
        9 => 'Commuting',
        10 => 'Shopping',
        11 => 'Insurance',
        12 => 'Other',
    ];

    public const ICONS = [
        1 => './public/icons/utilities.svg',
        2 => './public/icons/meal.svg',
        3 => './public/icons/rent.svg',
        4 => './public/icons/education.svg',
        5 => './public/icons/travel.svg',
        6 => './public/icons/medical.svg',
        7 => './public/icons/charity.svg',
        8 => './public/icons/tax.svg',
        9 => './public/icons/commuting.svg',
        10 => './public/icons/shopping.svg',
        11 => './public/icons/insurance.svg',
        12 => './public/icons/rent.svg',
    ];

    public static function getKeyFromValue($value)
    {
        $key = array_search($value, self::CATEGORY);
        return $key !== false ? $key : null;
    }
}
