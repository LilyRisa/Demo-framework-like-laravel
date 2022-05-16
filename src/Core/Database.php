<?php
namespace CM\Core;

class Database
{
    private static $instance = null;
    public $connection;
 
    private function __construct($host,$username,$password, $database, $port)
    {
        
        $this->connection = new \mysqli($host, $username, $password, $database, $port);
        $this->connection->set_charset("utf8");
    }

    
    public function __call($method, $args){

        if (!method_exists($this, $method))
        {
            return $this->connection->$method(...$args);
        }
    }

    public function __get($property){

        if (!property_exists($this, $property))
        {
            return $this->connection->{$property};
        }
    }
 
    public static function getInstance($arr)
    {
        if (self::$instance == null) {
            $className = __CLASS__;
            self::$instance = new $className($arr['host'],$arr['user'],$arr['password'],$arr['database'],$arr['port']);
        }
        return self::$instance;
    }

    public function __destruct(){
        $this->connection->close();
    }
}