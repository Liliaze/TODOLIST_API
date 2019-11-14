<?php
/**
 * Created by PhpStorm.
 * User: Liliaze
 * Date: 12/11/2019
 * Time: 13:25
 */
require "./Repository/UserRepository.php";
require "FormatException.php";
require "./Model/UserModel.php";

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

    private function checkUserNameFormat($username) {
        if (empty($username) || $username == ""){
            throw new FormatException('Username not should be empty');
        }
        else if (!ctype_alnum($username)) {
            throw new FormatException('Username need contains only alphanumeric characters');
        }
        else if (strlen($username) < 5 || strlen($username) > 30) {
            throw new FormatException('The length of the username must be between 5 and 30 characters');
        }
        return true;
    }

    private function checkPasswordFormat($password) {

        if(!empty($password) && $password != "" ) {
            if (strlen($password) <= 8) {
                throw new FormatException('Password must contain ct least 8 Digits !');
            } else if (!preg_match("#[0-9]+#", $password)) {
                throw new FormatException('Password must contain at least 1 Number !');
            } else if (!preg_match("#[A-Z]+#", $password)) {
                throw new FormatException('Password must contain ct least 1 Capital Letter ');
            } else if (!preg_match("#[a-z]+#", $password)) {
                throw new FormatException('Password must contain at least 1 Lowercase Letter !');
            } else if (!preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $password)) {
                throw new FormatException('Password must contain at least 1 Special Character !');
            }
            return true;
        }
    }

    private function checkAvailabilityUserName($username)
    {
        $userFindName = \UserRepository::getInstance()->getUserByUsername($username)->getUserName();
        if ($userFindName == $username) {
            throw new Exception('This username is already used ! Please login or choose another');
        }
        return true;
    }

    public function createUser($username, $password)
    {
        //check the format and availability of datas
        if ($this->checkPasswordFormat($password) && $this->checkUsernameFormat($username) &&
        $this->checkAvailabilityUserName($username)) {
            return \UserRepository::getInstance()->createUser($username, $password);
        }
        throw new Exception('bad format for username or password');
    }
}