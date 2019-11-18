<?php
/**
 * Created by PhpStorm.
 * User: Liliaze
 * Date: 12/11/2019
 * Time: 13:25
 */

require_once "./Repository/TaskListRepository.php";

class TaskListService
{
    private static $instance = null;

    public static function getInstance()
    {
        if (self::$instance) {
            return self::$instance;
        }
        self::$instance = new TaskListService();
        return self::$instance;
    }

    public function createTaskList($title, $user_id)
    {
        //check format of data
        if ($this->checkDataFormat($title))
        {
            //create a TaskListModel
            $newList = new TaskListModel();
            $newList->setTaskList(0, $user_id, $title);
            //Send List in database
            if ($newListDB = \TaskListRepository::getInstance()->createTaskList($newList)) {
                return $newListDB;
            };
        }
        throw new Exception('user not created');

    }

    public function getTaskLists($userId) {
        $taskList = \TaskListRepository::getInstance()->getTaskList($userId);
        if (!$taskList)
            throw new FormatException("taskLists not found");
        return $taskList;
    }

    public function getTaskListById($taskListId, $userId) {
        $taskList = \TaskListRepository::getInstance()->getTaskListById($taskListId, $userId);
        if (!$taskList)
            throw new FormatException("taskList n°".$taskListId." not found");
        return $taskList;
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