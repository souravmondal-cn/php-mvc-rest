<?php

use Controllers\Api\UserController;
use Utilities\ApiAuthencation;

$app['UserController.controller'] = $app->factory(function() use ($app) {
    return new UserController($app);
});

$app['ApiAuthencation'] = $app->factory(function() use ($app) {
    return new ApiAuthencation($app);
});

/*
 * API Related Routes
 */
$app->before('ApiAuthencation:authenticate');

$app->get('/api', function () use ($app) {
    return new Symfony\Component\HttpFoundation\JsonResponse(array(
        'status' => 'api is operating normally',
        'version' => '1.0.0'
    ), 200);
});
$app->get('/api/users', 'UserController.controller:getAll');
$app->get('/api/user/{userId}', 'UserController.controller:getUser');
$app->post('/api/user/add', 'UserController.controller:addUser');
$app->put('/api/user/update/{userId}', 'UserController.controller:updateUser');
$app->delete('/api/user/delete/{userId}', 'UserController.controller:deleteUser');
$app->post('/api/user/authencate', 'UserController.controller:login');

/*
 * Web App Routes
 */
