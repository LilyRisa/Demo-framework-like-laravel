<?php
namespace CM\Provider;

class Autoload{

    public static $helper = [

    ];

    public static function autoload($args){
        if(!empty($args)){
            return static::$helper;
        }
        return static::$helper[$args];
    }
}