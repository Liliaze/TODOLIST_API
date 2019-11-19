<?php

require_once './Router/Router.php';
require_once './Model/UserModel.php';
require_once './Exception/FormatException.php';
require_once './Exception/ConflictException.php';
require_once './Exception/UnauthorizedException.php';
require_once './Exception/UnknownException.php';

$HttpResponse = null;

try {
    $router = new Router();
    $HttpResponse = $router->run();
} catch (Exception $e) {
    $HttpResponse = new HttpResponseModel($e->getHttpCode(), 'Content-Type: application/json', $e->getMessage());
} finally {
    header_remove();
    header($HttpResponse->getHeader());
    http_response_code($HttpResponse->getCode());
    if (is_array($HttpResponse->getMessage()) || is_object($HttpResponse->getMessage()))
        echo json_encode($HttpResponse->getMessage(), JSON_FORCE_OBJECT | JSON_NUMERIC_CHECK);
    else {
        $array['message'] = $HttpResponse->getMessage();
        echo json_encode($array, JSON_FORCE_OBJECT);
    }
}