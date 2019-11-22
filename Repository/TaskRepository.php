<?php
/**
 * Created by PhpStorm.
 * User: Liliaze
 * Date: 12/11/2019
 * Time: 13:24
 */

require_once './Repository/PdoHelper.php';
require_once './Model/TaskModel.php';

class TaskRepository extends PdoHelper
{
    private static $instance = null;

    public static function getInstance() {
        if (self::$instance) {
            return self::$instance;
        }
        self::$instance = new TaskRepository();
        return self::$instance;
    }

    public function createTask($taskModel) {
        //request
        $request =  parent::getPdo()->prepare("INSERT INTO task (id_task, id_tasklist, id_user, content, status, created, updated) VALUES (null, ?, ?, ?, ?, NOW(), NOW())");
        $result = $request->execute(array($taskModel->getIdTaskList(), $taskModel->getIdUser(), $taskModel->getContent(), $taskModel->getStatus()));
        return $result;
    }

    public function getAllTasksInList($taskListId) {
        //request
        $request =  parent::getPdo()->prepare("SELECT * FROM `task` WHERE id_tasklist LIKE :id");
        $request->bindParam(":id",$taskListId);
        $success = $request->execute();

        //ckeck success of request
        if (!$success)
            return $success;

        //preparation of the data obtained before return
        $pdoresults = $request->fetchAll();
        $taskArray = [];
        foreach ($pdoresults as $key => $task) {
            $newTask = new TaskModel();
            $newTask->unserialize($task);
            array_push($taskArray, $newTask->serialize());
        }
        return $taskArray;
    }

    public function getTaskById($taskId) {
        //request
        $request =  parent::getPdo()->prepare("SELECT * FROM `task` WHERE `id_task` = :id");
        $request->bindParam(":id",$taskId);
        $request->execute();

        //preparation of the data obtained before return
        $pdoresults = $request->fetchAll();
        $newTask = new TaskModel();
        if ($pdoresults != null && isset($pdoresults[0])) {
            $newTask->unserialize($pdoresults[0]);
        }
        return $newTask;
    }

    public function updateTask($taskModel) {
        //request
        $request =  parent::getPdo()->prepare("UPDATE `task` SET `id_tasklist` = ?, `content` = ?, `status` = ?, updated = NOW() WHERE `task`.`id_task` = ?;");
        $success = $request->execute(array($taskModel->getIdTaskList(), $taskModel->getContent(),$taskModel->getStatus(), $taskModel->getIdTask()));
        return $success;
    }

    public function deleteTask($taskId) {
        //request
        $request =  parent::getPdo()->prepare("DELETE FROM `task` WHERE `task`.`id_task` = :id");
        $request->bindParam(":id",$taskId);
        $success = $request->execute();
        return $success;
    }
}