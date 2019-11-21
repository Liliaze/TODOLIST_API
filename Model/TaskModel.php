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
class TaskModel implements Serializable
{
    private $id_task = 0;
    private $id_user = 0;
    private $id_tasklist = 0;
    private $content = null;
    private $status = null;
    private $created = null;
    private $updated = null;

    public function serialize() {
        return array(
            'id_task' => $this->id_task,
            'id_user' => $this->id_user,
            'id_tasklist' => $this->id_tasklist,
            'content' => $this->content,
            'status' => $this->status,
            'created' => $this->created,
            'updated' => $this->updated
            );
    }

    public function unserialize($pdoResults) {
        $this->setIdTask($pdoResults['id_task']);
        $this->setIdUser($pdoResults['id_user']);
        $this->setIdTasklist($pdoResults['id_tasklist']);
        $this->setContent($pdoResults['content']);
        $this->setStatus($pdoResults['status']);
        $this->setDateCreation($pdoResults['created']);
        $this->setDateUpdate($pdoResults['updated']);
    }

    public function setTaskModel($idUser, $idTaskList, $content, $status) {
        $this->setIdUser($idUser);
        $this->setIdTasklist($idTaskList);
        $this->setContent($content);
        $this->setStatus($status);
    }

    /**
     * @return int
     */
    public function getIdTask()
    {
        return $this->id_task;
    }

    /**
     * @param int $id_task
     */
    public function setIdTask($id_task)
    {
        $this->id_task = $id_task;
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
    public function getIdTaskList()
    {
        return $this->id_tasklist;
    }

    /**
     * @param int $id_tasklist
     */
    public function setIdTaskList($id_tasklist)
    {
        $this->id_tasklist = $id_tasklist;
    }

    /**
     * @return null
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param null $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return null
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param null $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return null
     */
    public function getDateCreation()
    {
        return $this->created;
    }

    /**
     * @param null $date_creation
     */
    public function setDateCreation($date_creation)
    {
        $this->created = $date_creation;
    }

    /**
     * @return null
     */
    public function getDateUpdate()
    {
        return $this->date_update;
    }

    /**
     * @param null $date_update
     */
    public function setDateUpdate($date_update)
    {
        $this->date_update = $date_update;
    }

}