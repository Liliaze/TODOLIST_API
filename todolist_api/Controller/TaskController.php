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

    public static function getInstance() {
        if (self::$instance) {
            return self::$instance;
        }
        self::$instance = new TaskController();
        return self::$instance;
    }

    public function createTaskList($header, $data) {
        if (!isset($data['title'])) {
            throw new FormatException('title of new list not define in parameter');
        }
        $userFind = \AuthentificationService::getInstance()->checkUserAuthentification($header['auth_token']);

        $isCreate = \TaskListService::getInstance()->createTaskList($data['title'], $userFind->getUserId());
        if ($isCreate) {
            return new HttpResponseModel('201', 'Content-Type: application/json', "new list created");
        }
    }

    public function updateTaskList($header, $taskListId, $data) {
        if (!isset($data['title'])) {
            throw new FormatException('new title of list not define in parameter');
        }
        $userFind = \AuthentificationService::getInstance()->checkUserAuthentification($header['auth_token']);

        $isUpdate = \TaskListService::getInstance()->updateTaskList($taskListId, $userFind->getUserId(), $data['title']);
        if ($isUpdate) {
            return new HttpResponseModel('200', 'Content-Type: application/json', "taskList n°".$taskListId." has been updated");
        }
    }

    public function deleteTaskList($header, $taskListId) {
        $userFind = \AuthentificationService::getInstance()->checkUserAuthentification($header['auth_token']);

        $isDelete = \TaskListService::getInstance()->deleteTaskList($taskListId, $userFind->getUserId());
        if ($isDelete) {
            return new HttpResponseModel('200', 'Content-Type: application/json', "taskList n°".$taskListId." has been deleted");
        }
    }

    public function getUserTaskLists($header) {
        $userFind = \AuthentificationService::getInstance()->checkUserAuthentification($header['auth_token']);

        $taskLists = \TaskListService::getInstance()->getTaskLists($userFind->getUserId());
        if ($taskLists) {
            return new HttpResponseModel('200', 'Content-Type: application/json', $taskLists);
        }
    }

    public function getUserTaskListById($header, $taskListId) {
        $userFind = \AuthentificationService::getInstance()->checkUserAuthentification($header['auth_token']);

        $taskList = \TaskListService::getInstance()->getTaskListById($taskListId, $userFind->getUserId());
        if ($taskList) {
            return new HttpResponseModel('200', 'Content-Type: application/json', $taskList->serialize());
        }
    }

}