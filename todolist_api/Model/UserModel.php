<?php
/**
 * Created by PhpStorm.
 * User: Liliaze
 * Date: 14/11/2019
 * Time: 10:50
 */

/**
 * Class UserModel
 */
class UserModel
{

    private $id = 0;
    private $username = null;
    private $password = null;
    private $token = null;

    /**
     * @param $username
     * @param $password
     */

    public function setUserByRequest($pdoResults)
    {
        $this->setId($pdoResults['id']);
        $this->setUsername($pdoResults['username']);
        $this->setPassword($pdoResults['password']);
        $this->setToken($pdoResults['token']);
    }

    public function setUser($id, $username, $password, $token)
    {
        $this->setId($id);
        $this->setUsername($username);
        $this->setPassword($password);
        $this->setToken($token);
    }
    /**
     * @return null
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param null $token
     */
    public function setToken($token)
    {
        $this->token = $token;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

}