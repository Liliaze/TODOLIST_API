<?php
/**
 * Created by PhpStorm.
 * User: Liliaze
 * Date: 12/11/2019
 * Time: 13:25
 */

require_once "./Repository/TaskListRepository.php";
require_once "./Repository/TaskRepository.php";
require_once "./Exception/NotFoundException.php";

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
        $this->checkDataFormat($title);
        //create a TaskListModel
        $newTaskList = new TaskListModel();
        $newTaskList->setTaskList(0, $userId, $title);
        //Send List in database
        if ($newListDB = \TaskListRepository::getInstance()->createTaskList($newTaskList)) {
            return $newListDB;
        }
        throw new UnknownException('TaskList not created');
    }

    public function createTask($content, $userId, $taskListId) {
        //vérifier les droits de l'utilisateur sur la liste et l'éxistence de la liste
        $this->checkUserRight($taskListId,  $userId);

        //vérifier le format du contenu
        $this->checkDataFormat($content);

        //créer la nouvelle tâche
        $newTask = new TaskModel();
        $newTask->setTaskModel($userId,$taskListId, $content, "active");

        //envois des données en base de données
        $taskIsCreated = \TaskRepository::getInstance()->createTask($newTask);
        //retourner une réponse
        if ($taskIsCreated)
            return ($taskIsCreated);
        //si pas de réponse
        throw new UnknownException('Task not created');
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
        throw new UnknownException('TaskList not updated');
    }

    public function deleteTaskList($taskListId, $userId)
    {
        $this->checkUserRight($taskListId,  $userId);
        //Send List in database to update
        if ($deletedListDB = \TaskListRepository::getInstance()->deleteTaskList($taskListId)) {
            return $deletedListDB;
        };
        throw new UnknownException('TaskList not deleted');
    }

    public function getTaskLists($userId) {
        $taskList = \TaskListRepository::getInstance()->getTaskList($userId);
        if (!$taskList || !$taskList[0]['id_tasklist'])
            throw new NotFoundException("TaskLists not found");
        return $taskList;
    }

    public function getTaskListById($taskListId, $userId) {
        $taskList = \TaskListRepository::getInstance()->getTaskListById($taskListId);
        if (!$taskList || !$taskList->getIdTasklist())
            throw new NotFoundException("TaskList ".$taskListId." not found");
        if ($taskList->getIdUser() != $userId)
            throw new UnauthorizedException("Invalid_rights on this ressources");
        return $taskList;
    }

    public function getTasksByIdTaskList($taskListId, $userId) {
        //check user rights on this list
        $this->checkUserRight($taskListId,  $userId);

        //get all tasks in this listId
        $taskFinded = \TaskRepository::getInstance()->getAllTasksInList($taskListId);

        //return tasks
        if (is_array($taskFinded)) {
            return $taskFinded;
        }
        throw new UnknownException("Ressource not finded");
    }

    private function checkDataFormat($data) {

        if (empty($data) || $data == ""){
            throw new FormatException('Data not should be empty');
        }
        else if (!ctype_alnum(str_replace(" ", "", $data))) {
            throw new FormatException('Data need contains only alphanumeric characters, excepted space');
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