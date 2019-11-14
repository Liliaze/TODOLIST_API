<?php
/**
 * Created by PhpStorm.
 * User: Liliaze
 * Date: 12/11/2019
 * Time: 13:25
 */

require_once "./Repository/UserRepository.php";

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

    public function createUser($username, $password)
    {
        //check the format and availability of datas
        if ($this->checkUsernameFormat($username) && $this->checkPasswordFormat($password) &&
            $this->checkAvailabilityUserName($username)) {
            $newUser = new UserModel();
            $newUser->setUser(null, $username, $this->encodePassword($password), $this->generateToken());
            return \UserRepository::getInstance()->createUser($newUser);
        }
        throw new Exception('bad format for username or password');
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
            if (strlen($password) < 6 || strlen($password) > 12) {
                throw new FormatException('Password must contain between 6 and 12 characters !');
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
            throw new ConflictException('This username is already used ! Please login or choose another');
        }
        return true;
    }

    private function encodePassword($password) {
        $encodePassword = md5($password);
        return $encodePassword;
    }


    private function generateToken()
    {
        //to do creation of token
        return ("abcd1234-*/");
    }
}