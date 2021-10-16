<?php
namespace CM\Core;

class CallRoute{
    public $url;
    public $name;

    protected static $_instance;

    public function __construct($url){
        $this->url = $url;
    }

    public function name($name){
        $this->name = $name;
        self::$_instance[] = $this;
    }

    public static function getInstances(){
        return self::$_instance;
    }


}