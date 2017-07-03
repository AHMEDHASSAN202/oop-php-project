<?php


class Session {

    /**
     * Set session
     *
     * @param $name
     * @param $value
     * @return mixed
     */
    public static function set($name , $value) {

        return $_SESSION[$name] = $value;
    }

    /**
     * Get session
     *
     * @param $name
     * @return null
     */
    public static function get($name) {

        return (isset($_SESSION[$name])) ? $_SESSION[$name] : null;
    }

    /**
     * Check has session
     *
     * @param $name
     * @return bool
     */
    public static function has($name) {

        return (isset($_SESSION[$name])) ? true : false;
    }

    /**
     * Remove session
     *
     * @param $name
     */
    public static function remove($name) {

        unset($_SESSION[$name]);
    }

    /**
     * Destroy all session
     *
     * @null
     */
    public static function destroy()
    {

        unset($_SESSION);

        session_destroy();
    }

    /**
     * Get session and remove it
     *
     * @param $name
     * @return mixed
     */
    public static function pull($name) {

        $value = $_SESSION[$name];

        unset($_SESSION[$name]);

        return $value;
    }


}