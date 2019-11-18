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
class TaskListModel
{

    public $id_user = 0;
    public $id_tasklist = 0;
    public $title = null;

    public function setTaskListByRequest($pdoResults)
    {
        $this->setIdUser($pdoResults['id_user']);
        $this->setIdTasklist($pdoResults['id_tasklist']);
        $this->setTitle($pdoResults['title']);
    }

    public function setTaskList($id_list, $id_user, $title)
    {
        $this->setIdUser($id_user);
        $this->setIdTasklist($id_list);
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
    public function getIdTasklist()
    {
        return $this->id_tasklist;
    }

    /**
     * @param int $id_tasklist
     */
    public function setIdTasklist($id_tasklist)
    {
        $this->id_tasklist = $id_tasklist;
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