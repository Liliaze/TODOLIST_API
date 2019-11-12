<?php
/**
 * Created by PhpStorm.
 * User: Liliaze
 * Date: 12/11/2019
 * Time: 11:58
 */
namespace Router;

require ("RouterException");

class Router
{

    private $_url;
    private $_argcUrl;
    private $_method;

    public function __construct() {
        $this->_url = '';
        $this->_argcUrl = 0;
        $this->_method = '';
    }

    private function getRoutes($url, $count) {
        // GET users
        if ($count == 2 && $url[0] == "users")
            echo json_encode("get method : users/myName");
        // GET lists
        else if ($count == 1 && $url[0] == "lists")
            echo json_encode("get method : lists");
        // GET lists/mylist
        else if ($count == 2 && $url[0] == "lists")
            echo json_encode("get method : lists/exemple");
        // GET tasks
        else if ($count == 1 && $url[0] == "tasks")
            echo json_encode("get method : tasks");
        // GET tasks/1
        else if ($count == 2 && $url[0] == "tasks")
            echo json_encode("get method : tasks/1");
        // GET other
        else
            throw new RouterException('No routes matches');
    }

    private function postRoutes($url, $count)
    {
        //to do
        echo json_encode("post method".$url[0]);
    }

    private function deleteRoutes($url, $count)
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
            }
            switch ($this->_method) {
                case 'GET' :
                    $this->getRoutes($this->_url, $this->_argcUrl);
                    break;
                case 'POST' :
                    $this->postRoutes($this->_url, $this->_argcUrl);
                    break;
                case 'DELETE' :
                    $this->deleteRoutes($this->_url, $this->_argcUrl);
                    break;
                default:
                    throw new RouterException('No Request Method Matches');
                    break;
            }
        } else {
            throw new RouterException('Missing request method');
        }
    }
}