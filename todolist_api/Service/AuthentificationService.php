<?php
/**
 * Created by PhpStorm.
 * User: Liliaze
 * Date: 12/11/2019
 * Time: 13:25
 */
require "./Repository/UserRepository.php";

class AuthentificationService
{
    private static $instance = null;

    public static function getInstance()
    {
        if (self::$instance) {
            return self::$instance;
        }
        self::$instance = new AuthentificationService();
        return self::$instance;
    }

    public function createUser($userName, $password)
    {
        //TO DO
        //$this->checkUsernameFormat($userName);
        //$this->checkPasswordFormat($password);
        //\UserRepository::getInstance()->getUserByUsername($userName);
        return \UserRepository::getInstance()->createUser($userName, $password);
    }
}