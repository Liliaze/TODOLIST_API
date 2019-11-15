<?php
/**
 * Created by PhpStorm.
 * User: Liliaze
 * Date: 12/11/2019
 * Time: 13:24
 */

require_once './Model/PdoModel.php';

class ListRepository
{
    private static $instance = null;

    public static function getInstance() {
        if (self::$instance) {
            return self::$instance;
        }
        self::$instance = new ListRepository();
        return self::$instance;
    }

    public function createList($listModel) {
        $request =  \PdoModel::getInstance()->getPdo()->prepare("INSERT INTO `list` (`id_list`, `id_user`, `title`) VALUES (?, ?, ?)");
        $result = $request->execute(array($listModel->getIdList(), $listModel->getIdUser(), $listModel->getTitle()));
        if (!$result)
            throw new Exception('list not created');
        return $result;
    }
/*
    public function getUserByUsername($username)
    {
        $request = \PdoModel::getInstance()->getPdo()->prepare("SELECT * FROM `user` WHERE `username` LIKE :u ");
        $request->bindParam(':u', $username);
        $request->execute();
        $pdoresults = $request->fetchAll();
        $user = new ListModel();
        if ($pdoresults != null && isset($pdoresults[0])) {
            $user->setUserByRequest($pdoresults[0]);
        }
        return $user;
    }

    public function getUserByToken($token)
    {
        $request = \PdoModel::getInstance()->getPdo()->prepare("SELECT * FROM `user` WHERE `token` LIKE :t ");
        $request->bindParam(':t', $token);
        $request->execute();
        $pdoresults = $request->fetchAll();

        $user = new ListModel();
        if ($pdoresults != null && isset($pdoresults[0])) {
            $user->setUserByRequest($pdoresults[0]);
            return $user;
        }
        else
            return null;
    }
*/
}