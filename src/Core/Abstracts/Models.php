<?php 
namespace CM\Core\Abstracts;
use CM\Core\Abstracts\ModelsForward;
use CM\Core\Abstracts\Instance;
use CM\Core\Database;
use Exception;

abstract class Models{

    protected $column = [];
    protected $table = null;
    protected $properties = [];
    public static $context = null;
    protected static $connection;
    public $sql;

    public function __construct(){
        global $db;
        self::$connection = Database::getInstance($db);
        self::$context = new ModelsForward(static::class);
        
    }

    public static function __callStatic($method, $args)
    {
        if(empty(self::$context)){
            self::$context = new ModelsForward(static::class);
        }
        if (method_exists(self::$context,$method)) {
            return self::$context->$method(...$args);
        }
    }

    public function __set($property, $value){;
        if(!property_exists($this, $property)){
            self::$context->{$property} = $value;
        }
    }

    public function __get($property){;
        if(!property_exists($this, $property)){
            return self::$context->{$property};
        }
    }

    public function __call($method, $args){

        if (!method_exists($this, $method))
        {
            return self::$context->$method(...$args);
        }
    }

    protected function hasMany($model, $column, $this_column){

    }
    protected function belongTo($model, $column, $this_column){

    }
}