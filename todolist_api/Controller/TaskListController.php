<?php
/**
 * Created by PhpStorm.
 * User: Liliaze
 * Date: 12/11/2019
 * Time: 13:24
 */

require_once "./Model/TaskListModel.php";
require_once "./Model/TaskModel.php";
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
class TaskListController
{
    private static $instance = null;

    public static function getInstance() {
        if (self::$instance) {
            return self::$instance;
        }
        self::$instance = new TaskListController();
        return self::$instance;
    }

    public function createTaskList($header, $data) {
        $userFind = \AuthentificationService::getInstance()->checkUserAuthentification($header);

        if (!isset($data['title'])) {
            throw new FormatException('title of new list not define in parameter');
        }

        $isCreate = \TaskListService::getInstance()->createTaskList($data['title'], $userFind->getUserId());

        return new HttpResponseModel('201', 'Content-Type: application/json', "New list created");
    }

    public function createTask($header, $idTaskList, $data) {
        $userFind = \AuthentificationService::getInstance()->checkUserAuthentification($header);

        if (!isset($data['content'])) {
            throw new FormatException('Content of new task not define in parameter');
        }

        $isCreate = \TaskListService::getInstance()->createTask($data['content'], $userFind->getUserId(), $idTaskList);

        return new HttpResponseModel('201', 'Content-Type: application/json', "New task created");
    }

    public function getTasks($header, $idTaskList) {
        $userFind = \AuthentificationService::getInstance()->checkUserAuthentification($header);

        $tasksFinded = \TaskListService::getInstance()->getTasksByIdTaskList($idTaskList, $userFind->getUserId());

        return new HttpResponseModel('200', 'Content-Type: application/json', $tasksFinded);
    }

    public function updateTaskList($header, $taskListId, $data) {
        if (!isset($data['title'])) {
            throw new FormatException('new title of list not define in parameter');
        }
        $userFind = \AuthentificationService::getInstance()->checkUserAuthentification($header);

        $isUpdate = \TaskListService::getInstance()->updateTaskList($taskListId, $userFind->getUserId(), $data['title']);

        return new HttpResponseModel('200', 'Content-Type: application/json', "taskList n°".$taskListId." has been updated");
    }

    public function updateTask($header, $taskId, $data) {
        if (!isset($data['id_tasklist']) && !isset($data['content']) && !isset($data['status'])) {
            throw new FormatException('no data in parameter to update');
        }
        $userFind = \AuthentificationService::getInstance()->checkUserAuthentification($header);

        \TaskListService::getInstance()->updateTask($taskId, $userFind->getUserId(), $data);

        return new HttpResponseModel('200', 'Content-Type: application/json', "Task n°".$taskId." has been updated");
    }

    public function deleteTaskList($header, $taskListId) {
        $userFind = \AuthentificationService::getInstance()->checkUserAuthentification($header);

        $isDelete = \TaskListService::getInstance()->deleteTaskList($taskListId, $userFind->getUserId());

        return new HttpResponseModel('200', 'Content-Type: application/json', "taskList n°".$taskListId." has been deleted");
    }

    public function getUserTaskLists($header) {
        $userFind = \AuthentificationService::getInstance()->checkUserAuthentification($header);

        $taskLists = \TaskListService::getInstance()->getTaskLists($userFind->getUserId());

        return new HttpResponseModel('200', 'Content-Type: application/json', $taskLists);
    }

    public function getUserTaskListById($header, $taskListId) {
        $userFind = \AuthentificationService::getInstance()->checkUserAuthentification($header);

        $taskList = \TaskListService::getInstance()->getTaskListById($taskListId, $userFind->getUserId());

        return new HttpResponseModel('200', 'Content-Type: application/json', $taskList->serialize());
    }

}