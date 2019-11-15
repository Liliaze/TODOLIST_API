<?php
/**
 * Created by PhpStorm.
 * User: Liliaze
 * Date: 12/11/2019
 * Time: 13:22
 */


require_once './Service/AuthentificationService.php';
require_once './Model/HttpResponseModel.php';


class AccountController
{

    private static $instance = null;
    private static $HttpResponse;

    public static function getInstance() {
        if (self::$instance) {
            return self::$instance;
        }
        self::$instance = new AccountController();
        self::$HttpResponse = new HttpResponseModel();
        return self::$instance;
    }

    public function signup($data)
    {
        if (isset($data['username']) && isset($data['password']))
        {
            $newUser = \AuthentificationService::getInstance()->createUser($data['username'], $data['password']);
            if ($newUser) {
                $array['auth_token'] = $token = $newUser->getToken();
                self::$HttpResponse->setParams('201', 'Content-Type: application/json', $array);
                return self::$HttpResponse->getHttpResponse();
            }
        }
        throw new FormatException('username or password not define');
    }

    public function login($data)
    {
        if (isset($data['username']) && isset($data['password']))
        {
            $token = \AuthentificationService::getInstance()->login($data['username'], $data['password']);
            if ($token) {
                $array['auth_token'] = $token;
                self::$HttpResponse->setParams('200', 'Content-Type: application/json', $array);
                return self::$HttpResponse->getHttpResponse();
            }
        }
        throw new FormatException('bad username or password');
    }
}