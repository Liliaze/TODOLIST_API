<?php
/**
 * Created by PhpStorm.
 * User: Liliaze
 * Date: 12/11/2019
 * Time: 14:50
 */

namespace Repository;


class Pdo
{
    private $_host = 'localhost';
    private $_port = "3306";
    private $_dbName = 'todolist';
    private $_user = 'root';
    private $_password ='';
    public $pdo = null;

    /**
     * @return null
     */
    public function getPdo()
    {
        return $this->pdo;
    }

    public function __construct() {

        try {
            $this->pdo = new PDO('mysql:host='.$this->_host.';port='.$this->_port.';dbname='.$this->_dbName, $this->_user, $this->_password);

        } catch(Exception $e) {
            throw new \Exception();
        }
    }
}