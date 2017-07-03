<?php

class Config {

    //Config::get('database/host');
    public static function get($value = null) {

        if ($value) {

            $config = $GLOBALS['config'];
            $keys = explode('/' , $value); //explode $value with '/'

            foreach ($keys as $value) {
                if (isset($config[$value])) {
                    $config = $config[$value];
                }
            }

            return $config;
        }

        return false;
    }




}