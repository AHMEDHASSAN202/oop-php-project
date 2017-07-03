<?php

class Token {

    public static function generate() {

        return Session::set(Config::get('session/token_name') , md5(uniqid()));

    }


    public static function check($token) {

        $tokenName = Config::get('session/token_name'); //token

        if (Session::has($tokenName) && $token === Session::get($tokenName)) {

            Session::remove($tokenName);

            return true;
        }

        return false;
    }


}