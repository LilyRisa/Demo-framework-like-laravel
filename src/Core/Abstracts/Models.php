<?php 
namespace CM\Core\Abstracts;
use CM\Core\Abstracts\ModelsForward;
abstract class Models{

    public static function __callStatic($method, $args)
    {
        if (!method_exists(self::class,$method)) {
            return (new ModelsForward(static::class))->$method(...$args);
        }
    }
}