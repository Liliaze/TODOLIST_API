<?php
/**
 * Created by PhpStorm.
 * User: Liliaze
 * Date: 12/11/2019
 * Time: 13:25
 */

require_once "./Repository/ListRepository.php";

class ListService
{
    private static $instance = null;

    public static function getInstance()
    {
        if (self::$instance) {
            return self::$instance;
        }
        self::$instance = new ListService();
        return self::$instance;
    }

    public function createList($title, $user_id)
    {
        //check format of data
        if ($this->checkDataFormat($title))
        {
            //create a ListModel
            $newList = new ListModel();
            $newList->setList(0, $user_id, $title);
            //Send List in database
            if ($newListDB = \ListRepository::getInstance()->createList($newList)) {
                return $newListDB;
            };
        }
        throw new Exception('user not created');

    }

    private function checkDataFormat($data) {

        if (empty($data) || $data == ""){
            throw new FormatException('data not should be empty');
        }
        else if (!ctype_alnum(str_replace(" ", "", $data))) {
            throw new FormatException('data need contains only alphanumeric characters, excepted space');
        }
        else if (strlen($data) < 1 || strlen($data) > 250) {
            throw new FormatException('The length of the data must be between 1 and 250 characters');
        }
        return true;
    }
}