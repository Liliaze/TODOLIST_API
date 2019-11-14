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
    private $username = null;
    private $password = null;
    private $encode_password = null;
    private $id = 0;

    /**
     * @param $username
     * @param $password
     */
    public function setUser($username, $password)
    {
        $this->setUsername($username);
        $this->setPassword($password);
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
    public function getEncodePassword()
    {
        return $this->encode_password;
    }

    /**
     * @param mixed $encode_password
     */
    public function setEncodePassword($encode_password)
    {
        $this->encode_password = $encode_password;
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