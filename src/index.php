<?php
require __DIR__ . '/../vendor/autoload.php';

require __DIR__ .'/../conf.php';

foreach (glob("config/*.php") as $filename)
{
    require $filename;
}

require 'Routes/Web.php';

use CM\Core\CallRoute;

require __DIR__ .'/../global.php';

use Symfony\Component\ErrorHandler\Debug;
use Symfony\Component\ErrorHandler\ErrorHandler;
use Symfony\Component\ErrorHandler\DebugClassLoader;

if($debug){
    Debug::enable();
}


use CM\Core\Abstracts\TrackableRoute;
use CM\Core\Abstracts\Core;

// var_dump($_ROUTE_INSTANCES);
try{
    $_ROUTE_INSTANCES = CallRoute::getInstances();
    $app = new Core(TrackableRoute::getInstances());
    $app->run();
}catch(Exception $e){
    throw new Exception($e);
}

$data = ErrorHandler::call(static function () use ($filename, $datetimeFormat) {
    // if any code executed inside this anonymous function fails, a PHP exception
    // will be thrown, even if the code uses the '@' PHP silence operator
    $data = json_decode(file_get_contents($filename), true);
    $data['read_at'] = date($datetimeFormat);
    file_put_contents($filename, json_encode($data));

    return $data;
});




