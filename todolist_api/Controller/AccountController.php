<?php
namespace Controller;
/**
 * Created by PhpStorm.
 * User: Liliaze
 * Date: 12/11/2019
 * Time: 13:22
 */

require "./Service/AuthentificationService.php";

class AccountController
{

    private static $instance = null;

    public static function getInstance() {
        if (self::$instance) {
            return self::$instance;
        }
        self::$instance = new AccountController();
        return self::$instance;
    }

    public function signup($data) {
        var_dump($data);
        if (isset($data['userName']) && isset($data['password'])) //check username validity
            return \AuthentificationService::getInstance()->createUser($data['userName'], $data['password']);
        return "fail";
    }

}