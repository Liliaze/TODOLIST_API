<?php
/**
 * Created by PhpStorm.
 * User: Liliaze
 * Date: 12/11/2019
 * Time: 13:24
 */


class UserRepository
{
    private static $instance = null;

    public static function getInstance() {
        if (self::$instance) {
            return self::$instance;
        }
        self::$instance = new UserRepository();
        return self::$instance;
    }

    public function createUser($username, $password) {
        //tmp result to test
        //to do
        return "youpi".$username.$password;
    }

    public function getUserByUsername($username) {
        //tmp user to test
        //to do
        $userTest = new UserModel();
        $userTest->setUsername("diana");
        return $userTest;
    }
}