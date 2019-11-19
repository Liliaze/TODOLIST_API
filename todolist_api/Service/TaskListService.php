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

    public function createTaskList($title, $userId)
    {
        //check format of data
        if ($this->checkDataFormat($title))
        {
            //create a TaskListModel
            $newTaskList = new TaskListModel();
            $newTaskList->setTaskList(0, $userId, $title);
            //Send List in database
            if ($newListDB = \TaskListRepository::getInstance()->createTaskList($newTaskList)) {
                return $newListDB;
            };
        }
        throw new Exception('user not created');

    }

    public function updateTaskList($taskListId, $userId, $title)
    {
        $this->checkUserRight($taskListId,  $userId);
        //check format of data
        if ($this->checkDataFormat($title))
        {
            //Send List in database to update
            if ($updatedListDB = \TaskListRepository::getInstance()->updateTaskList($taskListId, $title)) {
                return $updatedListDB;
            };
        }
        throw new Exception('taskList not updated');
    }

    public function deleteTaskList($taskListId, $userId)
    {
        $this->checkUserRight($taskListId,  $userId);
        //Send List in database to update
        if ($deletedListDB = \TaskListRepository::getInstance()->deleteTaskList($taskListId)) {
            return $deletedListDB;
        };
        throw new Exception('taskList not deleted');
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
        if ($taskList->getIdUser() != $userId)
            throw new UnauthorizedException("invalid_rights on this ressources or ressources not exist");
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

    private function checkUserRight($taskListId, $userId) {
        $taskListInDB = $this->getTaskListById($taskListId, $userId);
        if ($taskListInDB){
            return true;
        }
        return false;
    }

}