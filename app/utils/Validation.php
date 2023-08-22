<?php
require_once 'app/enums/Category.php';

class Validation
{
    public static function validate($data, $rules)
    {
        $errors = [];

        foreach ($rules as $field => $rule) {
            $rulesArray = explode('|', $rule);

            foreach ($rulesArray as $singleRule) {
                $ruleParts = explode(':', $singleRule);
                $ruleName = $ruleParts[0];
                $ruleValue = isset($ruleParts[1]) ? $ruleParts[1] : '';

                switch ($ruleName) {
                    case 'required':
                        if (!isset($data[$field]) || empty($data[$field])) {
                            $errors[] = "The $field field is required.";
                        }
                        break;
                    case 'max':
                        $fieldValue = isset($data[$field]) ? $data[$field] : '';
                        if (strlen($fieldValue) > $ruleValue) {
                            $errors[] = "The $field field must not exceed $ruleValue characters.";
                        }
                        break;
                    case 'min':
                        $fieldValue = isset($data[$field]) ? $data[$field] : '';
                        if (strlen($fieldValue) < $ruleValue) {
                            $errors[] = "The $field field must more than $ruleValue characters.";
                        }
                        break;
                    case 'email':
                        if (!preg_match('/^[\w.-]+@[\w.-]+\.\w+$/', $data[$field])) {
                            $errors[] = "The $field field must be in correct email format";
                        }
                        break;
                    case 'numeric':
                        if (!preg_match('/^[-+]?\d+(\.\d+)?$/', $data[$field])) {
                            $errors[] = "The $field field must be a number";
                        }
                        break;
                    case 'url':
                        if (!filter_var($data[$field], FILTER_VALIDATE_URL)) {
                            $errors[] = "The $field field must be an url";
                        }
                        break;
                    case 'integer':
                        if (!preg_match('/^-?\d+$/', $data[$field])) {
                            $errors[] = "The $field field must be an integer";
                        }
                        break;
                    case 'category':
                        if (!in_array($data[$field], array_keys(Category::CATEGORY))) {
                            $errors[] = "The $field field must be a category value";
                        }
                        break;
                    default:
                        break;
                }
            }
        }

        return $errors;
    }
}
