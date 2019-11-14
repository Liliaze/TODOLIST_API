<?php

require_once './Router/Router.php';
require_once "./Model/UserModel.php";

header('Content-Type: application/json');

try {

    $router = new Router();
    $result = $router->run();
    //to do erase all echo.
    echo json_encode($result);
    }
catch (Exception $e) {
   //todo
   echo json_encode('Erreur : ' . $e->getMessage());
}