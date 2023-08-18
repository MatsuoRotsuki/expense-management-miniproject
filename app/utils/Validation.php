<?php
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
                    default:
                        break;
                }
            }
        }

        return $errors;
    }
}
