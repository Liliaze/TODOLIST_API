<?php

require './Router/Router.php';

try {

    $router = new Router();
    $result = $router->run();
    //to do erase all echo.
    echo json_encode($result);
    }
catch(Exception $e) {
   //todo return no echo but template error intern
   echo json_encode('Erreur : ' . $e->getMessage());
}