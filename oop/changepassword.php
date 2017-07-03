<?php

require_once 'core/init.php';

$user = new User();

if (!$user->is_logged()) {
    Redirect::to('index');
}

echo $header;

if (Input::exists()) {

    $validate = new Validation();

    $validate->check($_POST , [

        'current_password'  => [
            'required'  => true,
            'min'       => 5,
        ],
        'new_password'  => [
            'required'  => true,
            'min'       => 5,
            'max'       => 12
        ],
        'new_password_again'  => [
            'required'  => true,
            'matches'   => 'new_password'
        ]

    ]);

    if ($validate->passes()) {

        $current_password = clean(Input::get('current_password'));
        $new_password = clean(Input::get('new_password'));

        if ($user->check_password($current_password)) {
            //it means current password is true

            try {

                $user->update([

                    'password'  => password_hash($new_password , PASSWORD_DEFAULT)

                ]);

                Session::set('success' , '<div style="padding: 10px; background-color: #4CAF50;color: #fff">your password have been updated</div>');

                Redirect::to('index');

            }catch (Exception $obj) {

                die($obj->getMessage());

            }

        }else {
            //it means current password is false
            echo ('current password is wrong');
        }

    }else {
        pre($validate->get_error());
    }



}




?>

<html>
<head>
    <title>change password</title>
    <style>
        div {
            margin: 10px;
        }
    </style>
</head>
<body>
    <h2>change password</h2>
    <form action="<?php echo escape($_SERVER['PHP_SELF']); ?>" method="post">
        <div>
            <label for="current_password">current password : </label>
            <input type="password" name="current_password" id="current_password">
        </div>
        <div>
            <label for="new_password">new password : </label>
            <input type="password" name="new_password" id="new_password">
        </div>
        <div>
            <label for="new_password_again">new password again : </label>
            <input type="password" name="new_password_again" id="new_password_again">
        </div>
        <div>
            <input type="submit" value="change">
        </div>
    </form>
</body>
</html>



