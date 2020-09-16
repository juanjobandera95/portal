<?php

use App\Core\AppException;
use App\Core\Request;
try {
    require_once __DIR__ . '/../src/bootstrap.php';
    $request = new Request();
    require __DIR__ . '/../config/routes.php';//coge las rutas
    echo $router->route($request);//hace la peticion por ruta
} catch (AppException $appException) {
    echo $appException->handleException();//se ejecutara la excepcion global
}

