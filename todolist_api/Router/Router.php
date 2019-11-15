<?php
/**
 * Created by PhpStorm.
 * User: Liliaze
 * Date: 12/11/2019
 * Time: 11:58
 */

require './Controller/AccountController.php';
require './Exception/RouterException.php';

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

    private function getRoutes($urlParameterArray, $argumentCount, $headerData, $parameterData) {

        //GET' /api/authToken => AccountController->getInstance()->login(); $request.header: { username, password }
        // GET /api/authToken
        if ($argumentCount == 2 && $urlParameterArray[1] == "authToken") {
            return \AccountController::getInstance()->login($headerData);
        }
        // GET users
        else if ($argumentCount == 2 && $urlParameterArray[1] == "users")
            echo json_encode("get method : users/myName");
        // GET lists
        else if ($argumentCount == 1 && $urlParameterArray[1] == "lists")
            echo json_encode("get method : lists");
        // GET lists/mylist
        else if ($argumentCount == 2 && $urlParameterArray[1] == "lists")
            echo json_encode("get method : lists/exemple");
        // GET tasks
        else if ($argumentCount == 1 && $urlParameterArray[1] == "tasks")
            echo json_encode("get method : tasks");
        // GET tasks/1
        else if ($argumentCount == 2 && $urlParameterArray[1] == "tasks")
            echo json_encode("get method : tasks/1");
        // GET other
        else
            throw new RouterException('No routes matches');
    }

    private function postRoutes($urlParameterArray, $argumentCount, $headerData, $parameterData)
    {
        //POST /api/user
        if ($argumentCount == 2 && $urlParameterArray[1] == "user")
            return \AccountController::getInstance()->signup($parameterData);
        else
            throw new RouterException('no routes matches');
    }

    private function deleteRoutes($urlParameterArray, $argumentCount, $headerData, $parameterData)
    {
        //to do
        if ($urlParameterArray == 'tasks')
            return json_encode("delete method".$urlParameterArray[1]);
        else
            throw new RouterException('no routes matches');
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