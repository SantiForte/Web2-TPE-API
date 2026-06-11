<?php

require_once 'libs/router/router.php';
require_once 'app/controllers/FutbolistasApiController.php';

$router = new Router();

/*
|--------------------------------------------------------------------------
| MIEMBRO A
|--------------------------------------------------------------------------
| - GET listado de futbolistas
| - PUT actualización de futbolistas
| - Ordenamiento (se implementa dentro del GET mediante query params)
*/

// Listado
$router->addRoute(
    'futbolistas',
    'GET',
    'FutbolistasApiController',
    'getFutbolistas'
);

// Actualización
$router->addRoute(
    'futbolistas/:id',
    'PUT',
    'FutbolistasApiController',
    'updateFutbolista'
);

// Ejecuta el router
$router->route(
    $_GET['resource'],
    $_SERVER['REQUEST_METHOD']
);