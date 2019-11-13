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

    public function createUser($userName, $password) {
        return "youpi".$userName.$password;
    }
}