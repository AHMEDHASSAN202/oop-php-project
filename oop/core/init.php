<?php
ini_set('session.use_only_cookies',  1);
session_start();


$GLOBALS['config'] = [

    'database' => [
        'host'      => 'localhost',
        'username'  => 'root',
        'password'  => '',
        'name'    => 'codecourse'
    ],

    'remember' => [
        'cookie_name'   => 'hash',
        'cookie_expire' => 30 //expire with days [here Ex: 30 days]
    ],

    'session'  => [
        'session_name'  => 'user',
        'token_name'    => 'token'
    ],

];


spl_autoload_register(function($className) {

    $file = 'classes/' . $className;

    required($file);
});

require_once 'functions/helpers.php';  //require helper file


required('functions/sanitize');

$header = '<ul>
            <li><a href="index.php">home</a></li>
            <li><a href="update.php">update</a></li>
            <li><a href="changepassword.php">change password</a></li>
            <li><a href="profile.php">profile</a></li>
            <li><a href="logout.php">logout</a></li>
          </ul>';
