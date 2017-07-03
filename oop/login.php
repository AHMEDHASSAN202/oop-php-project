<?php

require_once 'core/init.php';

$user = new User();

if ($user->is_logged()) {
    Redirect::to('index');
}

if (Input::exists()) {
    if (Token::check(Input::get('token'))) {

        $validate = new Validation();
        $validate->check($_POST , [
            'email' => [
                'required'  => true,
                'email'     => true,
            ],
            'password' => [
                'required'  => true
            ]
        ]);

        if ($validate->passes()) {

            $remember = (clean(Input::get('remember')) === 'on') ? true : false;

            $login = $user->login(clean(Input::get('email')) , clean(Input::get('password')) , $remember);

            if ($login) {

                Session::set('success_login' , '<div style="padding: 10px; background-color: #4CAF50;color: #fff">success login</div>');

                Redirect::to('index');

            }else {

                echo 'invalid email or password';
            }

        }else {
            pre($validate->get_error());
        }

    }

}



?>

<html>
    <head>
        <title>login</title>
        <style>
            div {
                margin: 10px;
            }
        </style>
    </head>
    <body>
        <h2>login</h2>
        <form action="" method="post">
            <div>
                <label for="email">email: </label>
                <input type="text" id="email" name="email" autocomplete="off">
            </div>
            <div>
                <label for="password">password: </label>
                <input type="password" id="password" name="password" autocomplete="off">
            </div>
            <div>
                <label for="remember">remember me: </label>
                <input type="checkbox" id="remember" name="remember">
            </div>
            <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
            <input type="submit" name="submit" value="login">
        </form>
    </body>
</html>
