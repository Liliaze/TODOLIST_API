<?php
/**
 * Created by PhpStorm.
 * User: Liliaze
 * Date: 12/11/2019
 * Time: 14:50
 */

/**
 * Class PdoModel
 */
class PdoModel
{

    /**
     * @var string
     */
    private $_host = 'localhost';
    private $_port = "3306";
    private $_dbName = 'todolist';
    private $_user = 'root';
    private $_password ='';
    private $_pdo = null;

    /**
     * @return null|PDO
     */
    public function getPdo()
    {
        return $this->_pdo;
    }

    private static $instance = null;

    public static function getInstance()
    {
        if (self::$instance) {
            return self::$instance;
        }
        self::$instance = new PdoModel();
        return self::$instance;
    }

    public function __construct() {

        try {
            $this->_pdo = new PDO('mysql:host='.$this->_host.';port='.$this->_port.';dbname='.$this->_dbName, $this->_user, $this->_password);

        } catch(Exception $e) {
            throw new \Exception();
        }
    }

}