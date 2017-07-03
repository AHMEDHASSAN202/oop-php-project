<?php
require_once 'core/init.php';

$user = new User();

if (!$user->is_logged()) {
    Redirect::to('index');
}

echo $header;

?>

<html>
    <head>
        <title>profile</title>
        <style>
            h4 {
                margin-left: 50px;
            }
        </style>
    </head>
    <body>
        <h2>profile</h2>
        <h4>username: <?php echo escape($user->get_user_data()->username); ?></h4>
        <h4>email: <?php echo escape($user->get_user_data()->email); ?></h4>
        <h4>joined: <?php echo escape(date('Y-m-d' , strtotime($user->get_user_data()->joined))); ?></h4>
        <h4>group: <?php echo escape($user->get_permission()); ?></h4>
    </body>
</html>
