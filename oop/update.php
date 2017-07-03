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
        'email' => [
            'required'  => true,
            'email'     => true
        ],
        'username' => [
            'required'  => true,
            'min'       => 5,
            'max'       => 15,
            'str'       => true
        ]
    ]);

    if ($validate->passes()) {

        try {

            $user->update([
                'email'     => clean(Input::get('email')),
                'username'  => clean(Input::get('username'))
            ]);

            Session::set('success' , '<div style="padding: 10px; background-color: #4CAF50;color: #fff">your details have been updated</div>');

            Redirect::to('index');

        }catch (Exception $obj) {

            die($obj->getMessage());

        }

    }else {

        pre($validate->get_error());
    }

}





?>

<html>
    <head>
        <title>update</title>
        <style>
            div {
                margin: 10px;
            }
        </style>
    </head>
    <body>
        <h2>update data</h2>
        <form action="<?php echo htmlentities($_SERVER['PHP_SELF']) ?>" method="post">
            <div class="field">
                <label>email: </label>
                <input type="email" name="email" value="<?php echo escape($user->get_user_data()->email); ?>">
            </div>
            <div class="field">
                <label>username: </label>
                <input type="text" name="username" value="<?php echo escape($user->get_user_data()->username); ?>">
            </div>
            <input type="submit" value="update">
        </form>
    </body>
</html>
