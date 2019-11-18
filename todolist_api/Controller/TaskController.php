<?php
/**
 * Created by PhpStorm.
 * User: Liliaze
 * Date: 12/11/2019
 * Time: 13:24
 */

require_once "./Model/TaskListModel.php";
require_once "./Service/TaskListService.php";
require_once "./Service/AuthentificationService.php";

/*
 * function getUserTaskLists(): HttpResponse(200 | 401)
function updateTaskList(): HttpResponse(200 | 401)
function deleteTaskList(): HttpResponse(200 | 401)
function createTask(): HttpResponse(200 | 401)
function getTaskListTasks(): HttpResponse(200 | 401)
function updateTask(): HttpResponse(200 | 401)
function deleteTask(): HttpResponse(200 | 401)
 */
class TaskController
{
    private static $instance = null;
    private static $HttpResponse;

    public static function getInstance() {
        if (self::$instance) {
            return self::$instance;
        }
        self::$instance = new TaskController();
        self::$HttpResponse = new HttpResponseModel();
        return self::$instance;
    }

    public function createTaskList($header, $data) {
        if (!isset($data['title'])) {
            throw new FormatException('title of new list not define in parameter');
        }
        $userFind = $this->checkUserAuthentification($header);

        $isCreate = \TaskListService::getInstance()->createTaskList($data['title'], $userFind->getId());
        if ($isCreate) {
            self::$HttpResponse->setParams('201', 'Content-Type: application/json', "new list created");
            return self::$HttpResponse;
        }
    }

    public function updateTaskList($header, $taskListId, $data) {
        if (!isset($data['title'])) {
            throw new FormatException('new title of list not define in parameter');
        }
        $userFind = $this->checkUserAuthentification($header);

        $isUpdate = \TaskListService::getInstance()->updateTaskList($taskListId, $userFind->getId(), $data['title']);
        if ($isUpdate) {
            self::$HttpResponse->setParams('200', 'Content-Type: application/json', "taskList n°".$taskListId." has been updated");
            return self::$HttpResponse;
        }
    }

    public function deleteTaskList($header, $taskListId) {
        $userFind = $this->checkUserAuthentification($header);

        $isDelete = \TaskListService::getInstance()->deleteTaskList($taskListId, $userFind->getId());
        if ($isDelete) {
            self::$HttpResponse->setParams('200', 'Content-Type: application/json', "taskList n°".$taskListId." has been deleted");
            return self::$HttpResponse;
        }
    }

    public function getUserTaskLists($header) {
        $userFind = $this->checkUserAuthentification($header);

        $taskLists = \TaskListService::getInstance()->getTaskLists($userFind->getId());
        if ($taskLists) {
            self::$HttpResponse->setParams('200', 'Content-Type: application/json', $taskLists);
            return self::$HttpResponse;
        }
    }

    public function getUserTaskListById($header, $taskListId) {
        $userFind = $this->checkUserAuthentification($header);

        $taskList = \TaskListService::getInstance()->getTaskListById($taskListId, $userFind->getId());
        if ($taskList) {
            $taskList;
            self::$HttpResponse->setParams('200', 'Content-Type: application/json', $taskList);
            return self::$HttpResponse;
        }
    }

    private function checkUserAuthentification($header) {
        if (!isset($header['auth_token'])) {
            throw new UnauthorizedException('auth_token not define in header');
        }

        $userFind = \AuthentificationService::getInstance()->getUserByToken($header['auth_token']);
        if (!$userFind)
            throw new UnauthorizedException('auth_token not recognize');
        else
            return $userFind;
    }
}