<?php

class Input {


    /**
     * check if exists element in global variable post or get
     *
     * @param string $type
     * @return bool
     */
    public static function exists($type = 'post') {

        $type = strtolower($type);

        switch ($type) {
            case 'post':
                return (!empty($_POST)) ? true : false;
            break;

            case 'get':
                return (!empty($_GET)) ? true : false;
            break;

            default:
                return false;
            break;
        }
    }

    /**
     * get element from global variable post or get
     *
     * @param $name
     * @return null
     */
    public static function get($name) {

        if (isset($_POST[$name])) {

            return $_POST[$name];

        }else if (isset($_GET[$name])) {

            return $_GET[$name];

        }else {

            return null;
        }
    }

}