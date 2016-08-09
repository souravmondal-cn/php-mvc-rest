<?php

use Controllers\Api\UserController;
use Controllers\Web\UserController as UserWebController;
use Controllers\Api\ApiAuthencation;

$app['UserController.api'] = $app->factory(function() use ($app) {
    return new UserController($app);
});

$app['UserController.web'] = $app->factory(function() use ($app) {
    return new UserWebController($app);
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
$app->get('/api/users', 'UserController.api:getAll');
$app->get('/api/user/{userId}', 'UserController.api:getUser');
$app->post('/api/user/add', 'UserController.api:addUser');
$app->put('/api/user/update/{userId}', 'UserController.api:updateUser');
$app->delete('/api/user/delete/{userId}', 'UserController.api:deleteUser');
$app->post('/api/user/authencate', 'UserController.api:login');

/*
 * Web App Routes
 */

$app->get('/', 'UserController.web:home');
$app->get('/login', 'UserController.web:login');
$app->post('/login', 'UserController.web:loginCheck');
$app->get('/signup', 'UserController.web:signup');
$app->post('/signup', 'UserController.web:signupProcess');
$app->get('/logout', 'UserController.web:logout');
$app->get('/home', 'UserController.web:home');