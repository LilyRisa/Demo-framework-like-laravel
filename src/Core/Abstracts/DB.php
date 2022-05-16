<?php 
namespace CM\Core\Abstracts;
use CM\Core\Abstracts\DB_forward;
use CM\Core\Abstracts\ModelsForward;
use CM\Core\Abstracts\Instance;
use CM\Core\Database;
use Exception;

class DB{


    public static function __callStatic($method, $args)
    {
        if(!method_exists(self::class, $method)){
            return (new DB_forward())->$method(...$args);
        }
    }
    
}