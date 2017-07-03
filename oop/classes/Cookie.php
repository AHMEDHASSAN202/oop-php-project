<?php


class Cookie {


    /**
     * set cookie
     *
     * @param $name
     * @param $value
     * @param $expire_with_day
     * @return mixed
     */
    public static function set($name , $value , $expire_with_day) {

        $time = $expire_with_day == -1 ? -1 : time() + (86400 * $expire_with_day);

        return setcookie($name , $value , $time , '/' , '' , false , true);
    }

    /**
     * get cookie
     *
     * @param $name
     * @return null
     */
    public static function get($name) {

        return $_COOKIE[$name];
    }

    /**
     * Check has cookie
     *
     * @param $name
     * @return bool
     */
    public static function has($name) {

        return (isset($_COOKIE[$name])) ? true : false;
    }

    /**
     * Remove cookie
     *
     * @param $name
     */
    public static function remove($name) {

        self::set($name , '' , -1);

    }

    /**
     * Destroy all cookies
     *
     * @null
     */
    public static function destroy()
    {
        foreach ($_COOKIE as $key => $value) {

            self::set($key , '' , -1);
        }

        unset($_COOKIE);
    }

}