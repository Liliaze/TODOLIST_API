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
class ListModel
{

    private $id_user = 0;
    private $id_list = 0;
    private $title = null;

    public function setListByRequest($pdoResults)
    {
        $this->setIdUser($pdoResults['id_user']);
        $this->setIdList($pdoResults['id_list']);
        $this->setTitle($pdoResults['title']);
    }

    public function setList($id_list, $id_user, $title)
    {
        $this->setIdUser($id_user);
        $this->setIdList($id_list);
        $this->setTitle($title);
    }

    /**
     * @return int
     */
    public function getIdUser()
    {
        return $this->id_user;
    }

    /**
     * @param int $id_user
     */
    public function setIdUser($id_user)
    {
        $this->id_user = $id_user;
    }

    /**
     * @return int
     */
    public function getIdList()
    {
        return $this->id_list;
    }

    /**
     * @param int $id_list
     */
    public function setIdList($id_list)
    {
        $this->id_list = $id_list;
    }

    /**
     * @return null
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param null $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }


}