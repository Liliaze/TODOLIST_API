<?php
/**
 * Created by PhpStorm.
 * User: Liliaze
 * Date: 12/11/2019
 * Time: 14:50
 */


/**
 * Class PdoHelper
 */
class PdoHelper
{
    /**
     * @var string
     */
    private $_pdo = null;

    protected function getPdo()
    {
        $database = include './config.php';
        try {
            $this->_pdo = new PDO('mysql:host='.$database['host'].';port='.$database['port'].';dbname='.$database['dbName'], $database['user'], $database['password']);
        } catch(Exception $e) {
            throw new \Exception();
        }
        return $this->_pdo;
    }
}