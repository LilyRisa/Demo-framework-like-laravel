<?php
require __DIR__ . '/../../vendor/autoload.php';

require __DIR__ .'/../../conf.php';

foreach (glob(__DIR__."/../config/*.php") as $filename)
{
    require $filename;
}

require '../Routes/Web.php';
require '../Routes/Api.php';

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
        $_ROUTE_INSTANCES = CallRoute::getInstances(); // list url by name() route
        // dd(TrackableRoute::getInstances());
        $app = new Core(TrackableRoute::getInstances());
        $app->run();
    }catch(Exception $e){
        
        $logs = "read_at: ".date($_datetimeFormat)."\n".$e;
        if (file_exists($_filename)){
            $logs .= "\n-------------------------- \n".file_get_contents($_filename);
        }
        file_put_contents($_filename, $logs);
        throw new Exception($e);
    }
}




