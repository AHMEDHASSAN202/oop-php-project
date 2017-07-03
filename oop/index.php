<?php
/**
 * Created by PhpStorm.
 * User: AHMED
 * Date: 6/22/2017
 * Time: 1:01 AM
 */
require_once 'core/init.php';

if (Session::has('success')) {
    echo Session::pull('success');  }

if (Session::has('success_login')) {
    echo Session::pull('success_login');    }

$user = new User();
if ($user->is_logged()) {

    echo sprintf('<h2 style="color: #4CAF50">Hello %s</h2>' , strtoupper($user->get_user_data()->username));

    echo $header;


    if ($user->has_permission('admin')) {

        echo 'you ara an administrator!';

    }

}else {

    echo '<h2>you need to <a href="login.php">login</a> or <a href="register.php">register</a></h2>';

}



?>

<html>
    <head>
        <title>home</title>
    </head>
</html>
