<?php

require_once 'libs/router/router.php';

require_once 'libs/jwt/JWTMiddleware.php';

require_once 'app/controllers/FutbolistasApiController.php';
require_once 'app/controllers/AuthApiController.php';

$router = new Router();

/* Middleware JWT */
$router->addMiddleware(
    new JWTMiddleware()
);

/* LOGIN */
$router->addRoute(
    'auth/token',
    'POST',
    'AuthApiController',
    'getToken'
);

/* GET listado */
$router->addRoute(
    'futbolistas',
    'GET',
    'FutbolistasApiController',
    'getFutbolistas'
);

/* GET por ID */
$router->addRoute(
    'futbolistas/:id',
    'GET',
    'FutbolistasApiController',
    'getFutbolistaById'
);

/* PUT ACTUALIZACION */
$router->addRoute(
    'futbolistas/:id',
    'PUT',
    'FutbolistasApiController',
    'updateFutbolista'
);
//POST
$router->addRoute('futbolistas','POST','FutbolistasApiController','addFutbolista');

$router->route(
    $_GET['resource'],
    $_SERVER['REQUEST_METHOD']
);
