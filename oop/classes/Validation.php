<?php

class Validation {

    /**
     * container errors
     *
     * @var array
     */
    private $_error = [];

    /**
     * store the instance from DB class
     *
     * @var object
     */
    private $_db;

    /**
     * Validation constructor
     *
     * set _db attribute
     */
    public function __construct() {

        $this->_db = DB::getInstance();
    }

    /**
     * check validation
     *
     * @param $source
     * @param $items
     */
    public function check($source , $items) {

        foreach ($items as $item => $rules) {

            $value = clean($source[$item]);

            foreach ($rules as $rule => $ruleValue) {

                if ($rule === 'required') {

                    $this->required($value , $item . ' is required');

                } elseif ($rule === 'min') {

                    $this->min($value , $ruleValue , $item . ' should be larger than '.$ruleValue . ' characters');

                } elseif ($rule === 'max') {

                    $this->max($value , $ruleValue , $item . ' should be less than '.$ruleValue .' characters');

                } elseif ($rule === 'unique') {

                    if (is_array($ruleValue)) {
                        $tableName = $ruleValue[0];
                        $columnName = $ruleValue[1];

                        $this->unique($value , $tableName , $columnName , $item .' is exists');
                    }

                } elseif ($rule === 'matches') {

                    $this->matches($value , $source[$ruleValue] , $item . ' must matches ' . $rules[$rule]);

                } elseif ($rule === 'email') {

                    $this->email($value , ' invalid email format');

                } elseif ($rule === 'str') {

                    $this->str($value , $item . ' must be letters only');

                } elseif ($rule === 'num') {

                    $this->num($value , $item . ' must be digits only');

                } elseif ($rule === 'str&num') {

                    $this->str_num($value , $item . ' must be letters and digits only');

                }elseif ($rule === 'str&num&space') {

                    $this->str_num_space($value , $item . ' must be letters ,digits and space only');

                }
            }

        }

    }

    /**
     * add error to error container
     *
     * @param $error
     */
    private function add_error($error) {
        $this->_error[] = $error;
    }

    /**
     * check required input
     *
     * @param $value
     * @param $error
     */
    private function required($value , $error) {
        if ($value == '') {
            $this->add_error($error);
        }
    }

    /**
     * check min length input
     *
     * @param $value
     * @param $num
     * @param $error
     */
    private function min ($value , $num , $error) {
        if (strlen($value) <= $num) {
            $this->add_error($error);
        }
    }

    /**
     * check max length input
     *
     * @param $value
     * @param $num
     * @param $error
     */
    private function max ($value , $num , $error) {
        if (strlen($value) >= $num) {
            $this->add_error($error);
        }
    }

    /**
     * check if value is unique or no
     *
     * @param $value
     * @param $tableName
     * @param $fieldName
     * @param $error
     */
    private function unique($value , $tableName , $fieldName  , $error) {

        $val = $this->_db->get($tableName , [$fieldName , '=' , $value]);

        if ($val->count()) {
            $this->add_error($error);
        }
    }

    /**
     * check if values matches
     *
     * @param $value1
     * @param $value2
     * @param $error
     */
    private function matches($value1 , $value2 , $error) {

        if ($value1 !== $value2) {
            $this->add_error($error);
        }
    }

    /**
     * check email valid
     *
     * @param $value
     * @param $error
     */
    private function email($value , $error) {

        if (!filter_var($value , FILTER_VALIDATE_EMAIL)) {
            $this->add_error($error);
        }
    }

    /**
     * check value is string
     *
     * @param $value
     * @param $error
     */
    private function str($value , $error) {

        if (!preg_match("/^[a-zA-Z ]+$/" , $value)) {
            $this->add_error($error);
        }

    }

    /**
     * check value is digit
     *
     * @param $value
     * @param $error
     */
    private function num($value , $error) {

        if (!is_numeric($value)) {  //or regExp preg_match("/^[0-9]+$/")
            $this->add_error($error);
        }

    }

    /**
     * check if value is string|number
     *
     * @param $value
     * @param $error
     */
    private function str_num($value , $error) {

        if (ctype_alnum($value)) {  //or regExp preg_match("/^[a-zA-Z0-9]+$/")
            $this->add_error($error);
        }

    }

    /**
     * check value is string|number|space
     *
     * @param $value
     * @param $error
     */
    private function str_num_space($value , $error) {

        if (!preg_match("/^[a-zA-Z0-9 ]+$/" , $value)) {
            $this->add_error($error);
        }

    }

    /**
     * check there is error in errors container
     *
     * @return bool
     */
    public function passes() {
        return !empty($this->_error) ? false : true;
    }

    /**
     * get errors
     *
     * @return array
     */
    public function get_error() {
        return $this->_error;
    }

}