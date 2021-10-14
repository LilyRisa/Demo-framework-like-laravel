<?php
namespace CM\Libs;

class Database
{
    private static $instance = null;
    public $connection;
 
    private function __construct($host,$username,$password, $database, $port)
    {
        
        $this->connection = new \mysqli($host, $username, $password, $database, $port);
        $this->connection->set_charset("utf8");
    }

    public function db_query($sql){
        return $this->connection->query($sql);
    }
 
    public static function getInstance($arr)
    {
        if (self::$instance == null) {
            $className = __CLASS__;
            self::$instance = new $className($arr['host'],$arr['user'],$arr['password'],$arr['datbase'],$arr['port']);
        }
        return self::$instance;
    }

    public function __destruct(){
        $this->connection->close();
    }
}