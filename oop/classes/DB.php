<?php

class DB {

    /**
     * stored instance [singleton design pattern]
     *
     * @var null
     */
    private static $_instance = null;

    private $_pdo,
            $_query,
            $_error = false,
            $_count = 0,
            $_lastInsertId;


    //private construct for prevent new object
    private function __construct() {
        try {

            $this->_pdo = new PDO('mysql:dbhost='.Config::get('database/host').';dbname='.Config::get('database/name').';' , Config::get('database/username') , Config::get('database/password'));
            $this->_pdo->setAttribute(PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION);
            $this->_pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE , PDO::FETCH_OBJ);
            $this->_pdo->exec('SET NAMES utf8');

        }catch (PDOException $error) {

            die($error->getMessage());
        }


    }

    /**
     * Get Instance
     *
     * @return object
     */
    public static function getInstance() {

        if (is_null(static::$_instance)) {

            static::$_instance = new self();

        }

        return static::$_instance;
    }


    /**
     * Generate query statement
     *
     * @param $sql
     * @param array $bindings
     * @return $this
     */
    public function query($sql , $bindings = []) {

        $this->_error = false;

        if ($this->_query = $this->_pdo->prepare($sql)) {
            if (count($bindings)) {

                $count = 1;

                foreach ($bindings as $binding) {

                    $this->_query->bindValue($count , $binding);

                    ++$count;
                }

            }

            if ($this->_query->execute()) {

                $this->_count   = $this->_query->rowCount();
                $this->_lastInsertId   = $this->_pdo->lastInsertId();

            }else {

                $this->_error = true;
            }
        }

        return $this;
    }

    /**
     * Generate stmt
     *
     * @param $action
     * @param $table
     * @param array $wheres
     * @return $this|bool
     */
    private function action($action , $table , $wheres = []) {

        if (count($wheres) === 3) {
            $field    = $wheres[0];
            $operator = $wheres[1];
            $value = $wheres[2];
        }

        $operators = ['=' , '>' , '<' , '>=' , '<='];

        if (in_array($operator , $operators)) {

            $sql = "{$action} FROM {$table} WHERE {$field} {$operator} ?";

            if (!$this->query($sql , [$value])->error()) {
                return $this;
            }

        }

        return false;
    }

    /**
     * Get the data
     *
     * @param $table
     * @param $wheres
     * @return bool|DB
     */
    public function get($table , $wheres = []) {

        return $this->action('SELECT *' , $table , $wheres);
    }

    /**
     * Delete from database
     *
     * @param $table
     * @param $wheres
     * @return bool|DB
     */
    public function delete($table , $wheres) {

        return $this->action('DELETE' , $table , $wheres);
    }

    /**
     * insert data to database
     *
     * @param $table
     * @param array $data
     * @return bool
     */
    public function insert($table , $data = []) {
        //insert into users SET username = ? , password = ? , email = ?;
        if (count($data)) {
            $sql = 'INSERT INTO `' . $table . '` SET ' ;

            $fields = array_keys($data);


            foreach ($fields as $field) {

                $sql .= '`' . $field . '` = ? , ';

            }

            $sql = rtrim($sql , ' ,');

            if (!$this->query($sql , $data)->error()) {
                return true;
            }

        }

        return false;
    }

    /**
     * update data
     *
     * @param $table
     * @param array $wheres
     * @param array $data
     * @return bool
     */
    public function update($table , $wheres = [] , $data = [] ) {

        if ($data) {

            if (count($wheres) === 3) {
                $field    = $wheres[0];
                $operator = $wheres[1];
                $id = $wheres[2];
            }

            $operators = ['=' , '>' , '<' , '>=' , '<='];

            if (in_array($operator , $operators)) {

                $sql = "UPDATE `{$table}` SET";

                foreach ($data as $key => $value) {
                    $sql .= " `{$key}` = ?,";
                }

                $sql = rtrim($sql , ',');

                $sql .= " WHERE `{$field}` {$operator} ?";

                $data[] = $id;

                if (!$this->query($sql , $data)->error()) {
                    return true;
                }

                return false;
            }

        }

    }

    /**
     * Get errors
     *
     * @return bool
     */
    public function error() {
        return $this->_error;
    }

    /**
     * Get results
     *
     * @return array
     */
    public function results() {
        return $this->_query->fetchAll();
    }

    /**
     * Get result
     *
     * @return stdClass
     */
    public function result() {
        return $this->_query->fetch();
    }

    /**
     * Get count results
     *
     * @return int
     */
    public function count() {
        return $this->_count;
    }

    public function last_insert_id() {
        return $this->_lastInsertId;
    }

}