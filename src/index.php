<?php
require __DIR__ . '/../vendor/autoload.php';

require __DIR__ .'/../conf.php';
require 'Routes/Web.php';

use CM\Core\CallRoute;
$_ROUTE_INSTANCES = CallRoute::getInstances();

require __DIR__ .'/../global.php';

use CM\Core\Abstracts\TrackableRoute;
use CM\Core\Abstracts\Core;

// var_dump($_ROUTE_INSTANCES);

$route = TrackableRoute::getInstances();
$app = new Core($route);
$app->run();

