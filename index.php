<?php

require_once './vendor/autoload.php';
require './bootstrap.php';
require './dev/QuickGit.php';

use Controllers\Application;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\SessionServiceProvider;

$app = new Application();
$app->register(new ServiceControllerServiceProvider());


$app['debug'] = false;
if (ENV == 'dev') {
    $app['debug'] = true;
}

$app->register(new SessionServiceProvider());
$app['session.storage.handler'] = null;

$app->register(new TwigServiceProvider(), array(
    'twig.path' => __DIR__ . '/views',
));

$app['doctrine'] = $entityManager;

//$buildVersion = new QuickGit();
//$app['buildVersion'] = $buildVersion->getBuildVersion();
require_once './routes.php';
$app->run();
