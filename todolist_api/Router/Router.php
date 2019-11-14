<?php
/**
 * Created by PhpStorm.
 * User: Liliaze
 * Date: 12/11/2019
 * Time: 11:58
 */

require './Controller/AccountController.php';
require 'RouterException.php';

class Router
{

    private $_url;
    private $_argcUrl;
    private $_data;
    private $_method;

    public function __construct() {
        $this->_url = '';
        $this->_argcUrl = 0;
        $this->_method = '';
    }

    private function getRoutes($url, $argumentCount) {
        // GET users
        if ($argumentCount == 2 && $url[0] == "users")
            echo json_encode("get method : users/myName");
        // GET lists
        else if ($argumentCount == 1 && $url[0] == "lists")
            echo json_encode("get method : lists");
        // GET lists/mylist
        else if ($argumentCount == 2 && $url[0] == "lists")
            echo json_encode("get method : lists/exemple");
        // GET tasks
        else if ($argumentCount == 1 && $url[0] == "tasks")
            echo json_encode("get method : tasks");
        // GET tasks/1
        else if ($argumentCount == 2 && $url[0] == "tasks")
            echo json_encode("get method : tasks/1");
        // GET other
        else
            throw new FormatException('No routes matches');
    }

    private function postRoutes($url, $argumentCount, $data)
    {
        if ($argumentCount == 1 && $url[0] == "user")
            return \AccountController::getInstance()->signup($data);
    }

    private function deleteRoutes($url, $argumentCount)
    {
        //to do
        echo json_encode("delete method".$url[0]);
    }

    public function run() {
        if (isset($_SERVER['REQUEST_METHOD'])) {
            $this->_method = $_SERVER['REQUEST_METHOD'];
            if (isset($_GET['url'])) {
                $this->_url = explode('/',$_GET['url']);
                $this->_argcUrl = count($this->_url);
                $this->_data = json_decode(file_get_contents('php://input'), true);

                switch ($this->_method) {
                    case 'GET' :
                        $this->getRoutes($this->_url, $this->_argcUrl);
                        break;
                    case 'POST' :
                        return $this->postRoutes($this->_url, $this->_argcUrl, $this->_data);
                        break;
                    case 'DELETE' :
                        $this->deleteRoutes($this->_url, $this->_argcUrl);
                        break;
                    default:
                        throw new FormatException('No Request Method Matches');
                        break;
                }
            }
        } else {
            throw new FormatException('Missing request method');
        }
    }
}