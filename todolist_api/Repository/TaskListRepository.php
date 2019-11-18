<?php
/**
 * Created by PhpStorm.
 * User: Liliaze
 * Date: 12/11/2019
 * Time: 13:24
 */

require_once './Repository/PdoHelper.php';

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

    public function createTaskList($listModel) {
        $request =  parent::getPdo()->prepare("INSERT INTO tasklist (`id_tasklist`, `id_user`, `title`) VALUES (?, ?, ?)");
        $result = $request->execute(array($listModel->getIdTaskList(), $listModel->getIdUser(), $listModel->getTitle()));
        if (!$result)
            throw new Exception('list not created');
        return $result;
    }

    public function getTaskList($userId) {
        $request =  parent::getPdo()->prepare("SELECT * FROM `tasklist` WHERE id_user LIKE :u");
        $request->bindParam(":u",$userId);
        $request->execute();
        $pdoresults = $request->fetchAll();
        return $pdoresults;
    }
    public function getTaskListById($taskListId, $userId) {
        $request =  parent::getPdo()->prepare("SELECT * FROM `tasklist` WHERE `id_tasklist` LIKE :t AND `id_user` LIKE :u ");
        $request->bindParam(":t",$taskListId);
        $request->bindParam(":u",$userId);
        $request->execute();
        $pdoresults = $request->fetchAll();
        return $pdoresults;
    }
/*
    public function getUserByUsername($username)
    {
        $request = \PdoHelper::getInstance()->getPdo()->prepare("SELECT * FROM `user` WHERE `username` LIKE :u ");
        $request->bindParam(':u', $username);
        $request->execute();
        $pdoresults = $request->fetchAll();
        $user = new TaskListModel();
        if ($pdoresults != null && isset($pdoresults[0])) {
            $user->setUserByRequest($pdoresults[0]);
        }
        return $user;
    }

    public function getUserByToken($token)
    {
        $request = \PdoHelper::getInstance()->getPdo()->prepare("SELECT * FROM `user` WHERE `token` LIKE :t ");
        $request->bindParam(':t', $token);
        $request->execute();
        $pdoresults = $request->fetchAll();

        $user = new TaskListModel();
        if ($pdoresults != null && isset($pdoresults[0])) {
            $user->setUserByRequest($pdoresults[0]);
            return $user;
        }
        else
            return null;
    }
*/
}