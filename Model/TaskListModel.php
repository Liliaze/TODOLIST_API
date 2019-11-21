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
class TaskListModel implements Serializable
{

    private $idUser = 0;
    private $idTasklist = 0;
    private $title = null;

    public function serialize() {
        return array(
                'id_user' => $this->idUser,
                'id_tasklist' => $this->idTasklist,
                'title' => $this->title
            );
    }
    public function unserialize($pdoResults) {
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
        return $this->idUser;
    }

    /**
     * @param int $idUser
     */
    public function setIdUser($idUser)
    {
        $this->idUser = $idUser;
    }

    /**
     * @return int
     */
    public function getIdTasklist()
    {
        return $this->idTasklist;
    }

    /**
     * @param int $idTasklist
     */
    public function setIdTasklist($idTasklist)
    {
        $this->idTasklist = $idTasklist;
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