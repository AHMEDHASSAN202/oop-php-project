<?php


if (!function_exists('pre')) {

    function pre($var) {
        echo '<pre>';
        print_r($var);
        echo '</pre>';
    }

}


if (!function_exists('required')) {

    function required($file) {

        $file = $file . '.php';

        $file = str_replace(['/' , '\\'] , DIRECTORY_SEPARATOR , $file);

        if (! file_exists($file)) {

            die($file . ' not found');
        }

        return require_once $file;
    }

}