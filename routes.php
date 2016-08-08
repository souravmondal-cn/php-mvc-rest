<?php

use Controllers\UserController;
use Utilities\ApiAuthencation;

$app['UserController.controller'] = $app->factory(function() use ($app) {
    return new UserController($app);
});

$app['ApiAuthencation'] = $app->factory(function() use ($app) {
    return new ApiAuthencation($app);
});

$app->before('ApiAuthencation:authenticate');

$app->get('/', function () use ($app) {
    return new Symfony\Component\HttpFoundation\JsonResponse(array(
        'status' => 'api is operating normally',
        'version' => '1.0.0'
    ), 200);
});
$app->get('/users', 'UserController.controller:getAll');
$app->get('/user/{userId}', 'UserController.controller:getUser');
$app->post('/user/add', 'UserController.controller:addUser');
$app->put('/user/update/{userId}', 'UserController.controller:updateUser');
$app->delete('/user/delete/{userId}', 'UserController.controller:deleteUser');
$app->post('/user/authencate', 'UserController.controller:login');
