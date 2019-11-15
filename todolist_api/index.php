<?php

require_once './Router/Router.php';
require_once "./Model/UserModel.php";
require_once './Exception/FormatException.php';
require_once './Exception/ConflictException.php';
require_once './Exception/UnauthorizedException.php';

$HttpResponse = new HttpResponseModel();
try {
    header('Content-Type: application/json');

    $router = new Router();
    $result = $router->run();
    //to do erase all echo.
    echo json_encode($result);
    }
catch (Exception $e) {
    $HttpResponse->setParams($e->getCode(),  'Content-Type: application/json', $e->getMessage());
    if ($HttpResponse->getCode() == null) {
        $HttpResponse->setParams('500',  'Content-Type: application/json', 'internal unkwnow error : '.$e->getMessage());
    }
    echo json_encode($HttpResponse->getHttpResponse());
}