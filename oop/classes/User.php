<?php


class User {

    /**
     * instance db
     *
     * @var object
     */
    private $_db;

    /**
     * table name
     *
     * @var string
     */
    private $_tableName = 'users';

    /**
     * store user data
     *
     * @var array
     */
    private $_user;

    /**
     * User constructor
     *
     * @param null $user
     */
    public function __construct($user = null) {

        $this->_db = Db::getInstance();
    }

    /**
     * create new user
     *
     * @param array $field
     * @throws Exception
     */
    public function create($field = []) {

        if (!$this->_db->insert($this->_tableName , $field)) {
            throw new Exception('there was a problem creating an account');
        }

        $this->_user = $this->_db->get($this->_tableName , ['id' ,'=' , $this->_db->last_insert_id()])->result();
    }

    /**
     * login users
     *
     * @param $email
     * @param $password
     * @param $remember
     * @return bool
     */
    public function login($email , $password , $remember) {

        $checkEmail = $this->_db->get($this->_tableName , ['email', '=', $email])->result();

        if ($checkEmail) {

            $this->_user = $checkEmail;

            if (password_verify($password , $checkEmail->password)) {

                if (!$remember) {
                    //create session
                    Session::set(Config::get('session/session_name') , $this->_user->code);

                }else {
                    //create cookie
                    Cookie::set(Config::get('remember/cookie_name') , $this->_user->code , Config::get('remember/cookie_expire'));

                }

                return true;
            }
        }

        return false;
    }

    /**
     * get user data
     *
     * @return array
     */
    public function get_user_data() {
        return $this->_user;
    }

    /**
     * check if user is logged
     *
     * @return bool
     */
    public function is_logged()
    {

        if (Session::has(Config::get('session/session_name'))) {

            $code = Session::get(Config::get('session/session_name'));

        } elseif (Cookie::has(Config::get('remember/cookie_name'))) {

            $code = Cookie::get(Config::get('remember/cookie_name'));

        }else {

            return false;
        }

        $this->_user = $this->_db->get($this->_tableName , ['code', '=' , $code])->result();

        return $this->_db->count();

    }

    /**
     * update data
     *
     * @param array $data
     * @throws Exception
     */
    public function update($data = []) {

        $update = $this->_db->update($this->_tableName , ['id' , '=' , $this->_user->id] , $data);

        if (!$update) {
            throw new Exception('there was a problem updating data');
        }

    }

    /**
     * check password for change password
     *
     * @param $password
     * @return bool
     */
    public function check_password($password) {

        return password_verify($password , $this->_user->password);

    }

    /**
     * check permissions
     *
     * @param $key
     * @return bool
     */
    public function has_permission($key) {

        $group = $this->_db->get('groups' , ['id' , '=' , $this->_user->group])->result();

        if ($group) {

            $permission = json_decode($group->permissions , true);

            if (isset($permission[$key])) {

                return true;

            }

        }

        return false;
    }

    /**
     * get permission name
     *
     * @return string
     */
    public function get_permission() {

        return $this->_db->get('groups' , ['id' , '=' , $this->_user->group])->result()->name;
    }

    /**
     * logout user
     *
     * @return void
     */
    public function logout() {

        Session::remove(Config::get('session/session_name'));
        Cookie::remove(Config::get('remember/cookie_name'));
        Redirect::to('index');
    }

}