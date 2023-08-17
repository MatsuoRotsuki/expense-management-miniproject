<?php
class Validation
{
    public static function validate(array $inputArray)
    {
        foreach ($inputArray as $string => $regex) {
            if (!preg_match($regex, $string)) {
                return false;
            }
        }
        return true;
    }
}
