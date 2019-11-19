<?php
/**
 * Created by PhpStorm.
 * User: Liliaze
 * Date: 12/11/2019
 * Time: 11:58
 */

require_once './Controller/AccountController.php';
require_once "./Controller/TaskListController.php";
require_once './Exception/RouterException.php';

class Router
{

    private $_url;
    private $_argcUrl;
    private $_data;
    private $_method;
    private $_header;

    public function __construct() {
        $this->_url = '';
        $this->_argcUrl = 0;
        $this->_method = '';
    }
    /*




        'POST' /api/task/{taskId} => TaskListController->getInstance()->updateTask(); $request : { header: { authToken }, body: { name: string, status: string } }

        'DELETE' /api/task/{taskId} => TaskListController->getInstance()->deleteTask(); $request.header: { authToken }
    */
    private function getRoutes($urlParameterArray, $argumentCount, $headerData, $parameterData) {

        //GET' /api/authToken => AccountController->getInstance()->login(); $request.header: { username, password }
        if ($argumentCount == 2 && $urlParameterArray[1] == "authToken") {
            return \AccountController::getInstance()->login($headerData);
        }
        //'GET' /api/taskList => TaskListController->getInstance()->getUserTaskLists(); $request.header: { authToken }
        else if ($argumentCount == 2 && $urlParameterArray[1] == "taskList")
            return \TaskListController::getInstance()->getUserTaskLists($headerData);
        //'GET' /api/taskList/{idList}
        else if ($argumentCount == 3 && $urlParameterArray[1] == "taskList" && ctype_digit($urlParameterArray[2]))
            return \TaskListController::getInstance()->getUserTaskListById($headerData, $urlParameterArray[2]);
        //'GET' /api/taskList/{taskListId}/tasks => TaskListController->getInstance()->getTaskListTasks(); $request.header: { authToken }
        else if ($argumentCount == 4 &&  $urlParameterArray[1] == "taskList" && ctype_digit($urlParameterArray[2]) && $urlParameterArray[3] == "tasks")
            return TaskListController::getInstance()->getTasks($headerData, $urlParameterArray[2]);
        else
            throw new RouterException('No routes matches');
    }

    private function postRoutes($urlParameterArray, $argumentCount, $headerData, $parameterData)
    {
        //'POST' /api/user => AccountController->getInstance()->signup(); $request.body: { username, password }
        if ($argumentCount == 2 && $urlParameterArray[1] == "user")
            return \AccountController::getInstance()->signup($parameterData);
        //POST /api/taskList
        else if ($argumentCount == 2 && $urlParameterArray[1] == "taskList")
            return TaskListController::getInstance()->createTaskList($headerData, $parameterData);
        //'POST' /api/taskList/{taskListId} => TaskListController->getInstance()->updateTaskList(); $request : { header: { authToken }, body: { taskIds: int[] } }
        else if ($argumentCount == 3 && $urlParameterArray[1] == "taskList" && ctype_digit($urlParameterArray[2]))
            return TaskListController::getInstance()->updateTaskList($headerData, $urlParameterArray[2], $parameterData);
        //'POST' /api/taskList/{taskListId}/task => TaskListController->getInstance()->createTask(); $request : { header: { authToken }, body: { name: string, status: string } }
        else if ($argumentCount == 4 &&  $urlParameterArray[1] == "taskList" && ctype_digit($urlParameterArray[2]) && $urlParameterArray[3] == "task")
            return TaskListController::getInstance()->createTask($headerData, $urlParameterArray[2], $parameterData);
        throw new RouterException('No routes matches');
    }

    private function deleteRoutes($urlParameterArray, $argumentCount, $headerData, $parameterData)
    {
        //'DELETE' /api/taskList/{taskListId} => TaskListController->getInstance()->deleteTaskList(); $request.header: { authToken }
        if ($argumentCount == 3 && $urlParameterArray[1] == "taskList" && ctype_digit($urlParameterArray[2]))
            return TaskListController::getInstance()->deleteTaskList($headerData, $urlParameterArray[2]);
        else
            throw new RouterException('No routes matches');
    }

    public function run() {
        if (isset($_SERVER['REQUEST_METHOD'])) {
            $this->_method = $_SERVER['REQUEST_METHOD'];
            if (isset($_GET['url'])) {

                //get routes
                $this->_url = explode('/',$_GET['url']);
                $this->_argcUrl = count($this->_url);

                //check if the routes contains /api/ in first parameter
                if ($this->_url[0] != "api") {
                    throw new RouterException('path request need contains [api] in first parameter');
                }

                //save POST params in $_data
                $this->_data = json_decode(file_get_contents('php://input'), true);

                //save header params in $_header
                $this->_header = apache_request_headers();

                //call controllers by request method
                switch ($this->_method) {
                    case 'GET' :
                        return $this->getRoutes($this->_url, $this->_argcUrl, $this->_header, $this->_data);
                        break;
                    case 'POST' :
                        return $this->postRoutes($this->_url, $this->_argcUrl, $this->_header, $this->_data);
                        break;
                    case 'DELETE' :
                        return $this->deleteRoutes($this->_url, $this->_argcUrl, $this->_header, $this->_data);
                        break;
                    default:
                        throw new RouterException('No Request Method Matches');
                }
            }
        }
        throw new RouterException('No routes matches or missing argument');
    }
}