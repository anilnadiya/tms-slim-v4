<?php

use Slim\App;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use Slim\Routing\RouteCollectorProxy;

use App\Controllers\UserController;

$app->group('/users', function (RouteCollectorProxy $group) {
    $group->get('', UserController::class . ':getUsers');
    $group->get('/{id}', UserController::class . ':getUser');
    $group->post('', UserController::class . ':createUser');
});


return function (App $app) {
    $app->get('/', function (Request $request, Response $response, array $args) {
        $response->getBody()->write("Hello world!");
        return $response;
    });
    $app->get('/test', function (Request $request, Response $response, array $args) {
        $payload = json_encode(['hello' => 'world'], JSON_PRETTY_PRINT);
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    });
    
    $app->group('/api', function ($group) {
        $group->get('/users', UserController::class . ':getUsers');
        $group->get('/users/{id}', UserController::class . ':getUserDataById');
        $group->get('/getProfile/:id', UserController::class . ':getUserByField');
        $group->get('/getTreeMenu', UserController::class . ':getTreeMenu');
    });

};
