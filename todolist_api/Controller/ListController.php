<?php
/**
 * Created by PhpStorm.
 * User: Liliaze
 * Date: 12/11/2019
 * Time: 13:24
 */

require_once "./Model/ListModel.php";
require_once "./Service/ListService.php";
require_once "./Service/AuthentificationService.php";

class ListController
{
    private static $instance = null;
    private static $HttpResponse;

    public static function getInstance() {
        if (self::$instance) {
            return self::$instance;
        }
        self::$instance = new ListController();
        self::$HttpResponse = new HttpResponseModel();
        return self::$instance;
    }

    public function addList($header, $data) {
        if (!isset($data['title']))
        {
            throw new FormatException('title of new list not define in parameter');
        }
        if (!isset($header['auth_token']))
        {
            throw new UnauthorizedException('auth_token not define in header');
        }

        $userFind = \AuthentificationService::getInstance()->getUserByToken($header['auth_token']);

        if($userFind)
        {
            $newList = \ListService::getInstance()->createList($data['title'], $userFind->getId());
            if ($newList) {
                self::$HttpResponse->setParams('201', 'Content-Type: application/json', "new list created");
                return self::$HttpResponse;
            }
        }
    }
}