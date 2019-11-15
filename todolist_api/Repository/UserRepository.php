<?php
/**
 * Created by PhpStorm.
 * User: Liliaze
 * Date: 12/11/2019
 * Time: 13:24
 */

require_once './Model/PdoModel.php';

class UserRepository
{
    private static $instance = null;

    public static function getInstance() {
        if (self::$instance) {
            return self::$instance;
        }
        self::$instance = new UserRepository();
        return self::$instance;
    }

    public function createUser($user) {
        $request =  \PdoModel::getInstance()->getPdo()->prepare("INSERT INTO `user` (`id`, `username`, `password`, `token`) VALUES (?, ?, ?, ?)");
        $result = $request->execute(array($user->getId(), $user->getUsername(), $user->getPassword(), $user->getToken()));
        if (!$result)
            throw new Exception('internal server error, user not created');
        return $result;
    }

    public function getUserByUsername($username)
    {
        $request = \PdoModel::getInstance()->getPdo()->prepare("SELECT * FROM `user` WHERE `username` LIKE :u ");
        $request->bindParam(':u', $username);
        $request->execute();
        $pdoresults = $request->fetchAll();
        $user = new UserModel();
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

        $user = new UserModel();
        if ($pdoresults != null && isset($pdoresults[0])) {
            $user->setUserByRequest($pdoresults[0]);
            return $user;
        }
        else
            return null;
    }
}