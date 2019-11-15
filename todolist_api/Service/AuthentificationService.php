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
            echo "pasfluffy";
            $newUser = new UserModel();
            $newUser->setUser(null, $username, $this->encodePassword($password), $this->generateToken());
            return \UserRepository::getInstance()->createUser($newUser);
        }
        throw new Exception('bad format for username or password');
    }

    //function login($username, $password): Success(user->auth_token) |
    // Error(invalid_credentials) $user = UserRepository->getInstance()->getUserByUsername($username);
    // if ($user->getPassword() === $password) ..
    public function login($username, $password)
    {
        //check the format of datas
        if ($this->checkUsernameFormat($username) && $this->checkPasswordFormat($password))
        {
            $userFind = $this->getUserByUsername($username);
            //check user data with data in database
            if ($userFind->getUsername() == $username && $userFind->getPassword() === $this->encodePassword($password)) {
                //return token
                return $userFind->getToken();
            }
        }
        throw new UnauthorizedException('invalid_credentials');
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
        $userFindName = null;
        $userFind = $this->getUserByUsername($username);
        if ($userFind)
            $userFindName = $userFind->getUsername();
        if ($userFindName == $username) {
            throw new ConflictException('This username is already used ! Please login or choose another');
        }
        return true;
    }

    private function getUserByUsername($username) {
        $userFind = \UserRepository::getInstance()->getUserByUsername($username);
        if (!$userFind) {
            throw new UnauthorizedException('user not found');
        }
        return $userFind;
    }

    private function encodePassword($password) {
        $encodePassword = md5($password);
        return $encodePassword;
    }

    private function generateToken()
    {
        return ($this->Salt());
    }

    private function Salt(){
        return substr(strtr(base64_encode(hex2bin($this->RandomToken(32))), '+', '.'), 0, 44);
    }

    private function RandomToken($length = 32){
        if(!isset($length) || intval($length) <= 8 ){
            $length = 32;
        }
        if (function_exists('random_bytes')) {
            return bin2hex(random_bytes($length));
        }
        if (function_exists('mcrypt_create_iv')) {
            return bin2hex(mcrypt_create_iv($length, MCRYPT_DEV_URANDOM));
        }
        if (function_exists('openssl_random_pseudo_bytes')) {
            return bin2hex(openssl_random_pseudo_bytes($length));
        }
    }
}