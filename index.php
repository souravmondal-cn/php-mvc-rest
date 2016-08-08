<?php

require_once './vendor/autoload.php';
require './bootstrap.php';
require './dev/QuickGit.php';

use Controllers\Application;
use Silex\Provider\ServiceControllerServiceProvider;

$app = new Application();
$app->register(new ServiceControllerServiceProvider());


$app['debug'] = false;
if (ENV == 'dev') {
    $app['debug'] = true;
}

$app['doctrine'] = $entityManager;

//$buildVersion = new QuickGit();
//$app['buildVersion'] = $buildVersion->getBuildVersion();
require_once './routes.php';
$app->run();
