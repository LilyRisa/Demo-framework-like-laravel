<?php
namespace CM\Core;

class Session{

    private static $_instance = null;


    private function __construct()
    {
        
    }

    public static function getInstance(){
        if(self::$_instance == null){
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public static function __callStatic($name, $arguments)
    {
        if(self::$_instance == null){
            self::$_instance = new self();
        }
        if(method_exists(self::class, $name)){
            return self::$_instance->{$name}(...$arguments);
        }
    }
    
    public function make($session, $value){
        global $_SESSION;
        $_SESSION[$session] = $value;
    }

    public function set($session, $value){
        $this->make($session, $value);
    }

    public function get($session){
        global $_SESSION;
        if(!isset($_SESSION[$session])) {
            return $_SESSION[$session];
        }
        return null;
    }

    public function exists($session){
        global $_SESSION;
        if(isset($_SESSION[$session])) {
            return true;
        }
        return false;
    }

    public function has($session){
        global $_SESSION;
        if(isset($_SESSION[$session])) {
            if($_SESSION[$session] != null)
                return true;
        }
        return false;
    }
    
}