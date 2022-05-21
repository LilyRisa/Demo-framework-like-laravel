<?php
require __DIR__ . '/../vendor/autoload.php';

require __DIR__ .'/../conf.php';

foreach (glob(__DIR__."/config/*.php") as $filename)
{
    require $filename;
}

require 'Routes/Web.php';

use CM\Core\CallRoute;


use Symfony\Component\ErrorHandler\Debug;
use Symfony\Component\ErrorHandler\ErrorHandler;
use Symfony\Component\ErrorHandler\DebugClassLoader;
use Phpfastcache\Helper\Psr16Adapter;
use Phpfastcache\Config\ConfigurationOption;

if(isset($_ENV['DEBUG'])){
    if((bool)$_ENV['DEBUG'] == true){
        Debug::enable();
    }
    

}
if(isset($_ENV['CACHE'])){
    $config = new ConfigurationOption([
        'path' => ROOTPATH.'/src/cache/system', // or in windows "C:/tmp/"
    ]);
    $__CACHE = new Psr16Adapter('Files', $config);
}


use CM\Core\Abstracts\TrackableRoute;
use CM\Core\Abstracts\Core;


if(is_cli()){  // run via cli
    require __DIR__.'/Core/Serve/PHPWebserverRouter.php';
    PHPWebserverRouter();
}else{
    try{
        $_ROUTE_INSTANCES = CallRoute::getInstances();
        $app = new Core(TrackableRoute::getInstances());
        $app->run();
    }catch(Exception $e){
        throw new Exception($e);
    }
}

$data = ErrorHandler::call(static function () use ($filename, $datetimeFormat) {
    // if any code executed inside this anonymous function fails, a PHP exception
    // will be thrown, even if the code uses the '@' PHP silence operator
    $data = json_decode(file_get_contents($filename), true);
    $data['read_at'] = date($datetimeFormat);
    file_put_contents($filename, json_encode($data));

    return $data;
});




