<?php

require 'core/init.php';

$user = new User;

if ($user->is_logged()) {
    Redirect::to('index');
}



if (Input::exists()) {

    if (Token::check(Input::get('token'))) {

        $validate = new Validation();

        $validate->check($_POST, [
            'email'    => [
                'required'  => true,
                'email'     => true,
                'unique'    => ['users' , 'email']
            ],
            'username' => [
                'required' => true,
                'min' => 5,
                'max' => 14,
                'str&num&space' => true
            ],
            'password' => [
                'required' => true,
                'min' => 5,
                'max' => 15,
            ],
            'confirm_password' => [
                'required' => true,
                'matches' => 'password'
            ]
        ]);


        if ($validate->passes()) {

            try {

                $user = new User;

                $user->create([
                    'email'     => clean(Input::get('email')),
                    'username'  => clean(Input::get('username')),
                    'password'  => password_hash(clean(Input::get('password')) , PASSWORD_DEFAULT),
                    'code'      => sha1(time() . mt_rand()),
                    'joined'    => date('Y:m:d H:i:s'),
                ]);

            }catch (Exception $e) {

                die($e->getMessage());
            }

            Session::set('success' , '<div style="padding: 10px; background-color: #4CAF50;color: #fff">you registered successfully!</div>');

            Session::set(Config::get('session/session_name') , $user->get_user_data()->code);

            Redirect::to('index');

        } else {
            pre($validate->get_error());
        }
    }

}else {


}


?>

<html>
    <head>
        <title>register</title>
        <style>
            div {
                margin: 10px;
            }
        </style>
    </head>
    <body style="font-family: sans-serif ,Arial;">
        <h2>register</h2>
        <form action="" method="post">
            <div>
                <label for="email">email: </label>
                <input type="text" name="email" id="email" autocomplete="off">
            </div>
            <div>
                <label for="username">username: </label>
                <input type="text" name="username" id="username" autocomplete="off">
            </div>
            <div>
                <label for="password">password: </label>
                <input type="password" name="password" id="password" autocomplete="off">
            </div>
            <div>
                <label for="confirm_password">confirm password: </label>
                <input type="password" name="confirm_password" id="confirm_password" autocomplete="off">
            </div>
            <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
            <input type="submit" value="register">
        </form>
    </body>
</html>


