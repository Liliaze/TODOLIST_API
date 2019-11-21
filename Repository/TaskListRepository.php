<?php
/**
 * Created by PhpStorm.
 * User: Liliaze
 * Date: 12/11/2019
 * Time: 13:24
 */

require_once './Repository/PdoHelper.php';
require_once './Model/TaskListModel.php';

class TaskListRepository extends PdoHelper
{
    private static $instance = null;

    public static function getInstance() {
        if (self::$instance) {
            return self::$instance;
        }
        self::$instance = new TaskListRepository();
        return self::$instance;
    }

    public function createTaskList($taskListModel) {
        $request =  parent::getPdo()->prepare("INSERT INTO tasklist (`id_tasklist`, `id_user`, `title`) VALUES (?, ?, ?)");
        $success = $request->execute(array($taskListModel->getIdTaskList(), $taskListModel->getIdUser(), $taskListModel->getTitle()));
         return $success;
    }

    public function updateTaskList($taskListId, $title) {
        $request =  parent::getPdo()->prepare("UPDATE `tasklist` SET `title` = :t WHERE `tasklist`.`id_tasklist` = :id");
        $request->bindParam(":t",$title);
        $request->bindParam(":id",$taskListId);
        $success = $request->execute();
        return $success;
    }

    public function deleteTaskList($taskListId) {
        $request =  parent::getPdo()->prepare("DELETE FROM `tasklist` WHERE `tasklist`.`id_tasklist` = :id");
        $request->bindParam(":id",$taskListId);
        $success = $request->execute();
        return $success;
    }

    public function getTaskList($userId) {
        //request
        $request =  parent::getPdo()->prepare("SELECT * FROM `tasklist` WHERE id_user LIKE :u");
        $request->bindParam(":u",$userId);
        $request->execute();

        //preparation of the data obtained before return
        $pdoresults = $request->fetchAll();
        $taskListArray = [];
        foreach ($pdoresults as $key => $taskList) {
            $newTaskList = new TaskListModel();
            $newTaskList->unserialize($taskList);
            $taskListArray[$key] = $newTaskList->serialize();
        }
        return $taskListArray;
    }

    public function getTaskListById($taskListId) {
        //request
        $request =  parent::getPdo()->prepare("SELECT * FROM `tasklist` WHERE `id_tasklist` = :t");
        $request->bindParam(":t",$taskListId);
        $request->execute();

        //preparation of the data obtained before return
        $pdoresults = $request->fetchAll();
        $newTaskList = new TaskListModel();
        if ($pdoresults != null && isset($pdoresults[0])) {
            $newTaskList->unserialize($pdoresults[0]);
        }
        return $newTaskList;
    }

}