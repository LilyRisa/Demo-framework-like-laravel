<?php
require __DIR__ . '/../vendor/autoload.php';

require __DIR__ .'/../conf.php';
require 'Routes/Web.php';

use CM\Core\CallRoute;

require __DIR__ .'/../global.php';

use CM\Core\Abstracts\TrackableRoute;
use CM\Core\Abstracts\Core;

// var_dump($_ROUTE_INSTANCES);
try{
    $_ROUTE_INSTANCES = CallRoute::getInstances();
    $app = new Core(TrackableRoute::getInstances());
    $app->run();
}catch(Exception $e){
    var_dump($e);
}


