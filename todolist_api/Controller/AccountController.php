<?php
/**
 * Created by PhpStorm.
 * User: Liliaze
 * Date: 12/11/2019
 * Time: 13:22
 */


require_once './Service/AuthentificationService.php';
require_once './Model/HttpResponseModel.php';
require_once "./Exception/FormatException.php";
require_once "./Exception/ConflictException.php";

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
        $HttpResponse = new HttpResponseModel();
        try {
            if (isset($data['userName']) && isset($data['password'])) {
                $isUserCreated = \AuthentificationService::getInstance()->createUser($data['userName'], $data['password']);
                if ($isUserCreated) {
                    $HttpResponse->setParams('201', 'Content-Type: application/json', 'user '.$data['userName'].' created.');
                } else
                    $HttpResponse->setParams('500', 'Content-Type: application/json', 'internal server unknow error');
            }
        }
        catch (ConflictException $e){
            $HttpResponse->setParams('409',  'Content-Type: application/json', 'Conflict : '.$e->getMessage());
        } catch (FormatException $e){
            $HttpResponse->setParams('400',  'Content-Type: application/json', 'Bad request : '.$e->getMessage());
        } finally {
            return $HttpResponse->getHttpResponse();
        }
    }

    public function login($data) {
        if (isset($data['userName']) && isset($data['password'])) //check username validity
            return \AuthentificationService::getInstance()->createUser($data['userName'], $data['password']);
        return "fail";
    }
}