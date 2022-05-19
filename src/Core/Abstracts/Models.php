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
    protected static $_filed = [];
    public static $with = [];
    private $w = null;

    public function __construct(){
        // global $db;

        // self::$connection = Database::getInstance($db);
        // self::$context = new ModelsForward(static::class, static::$_filed, $this->with);
        // self::$context->field = static::$_filed;

        $this->w = &self::$with;
        
        
        
    }

    public static function __callStatic($method, $args)
    {
        if(empty(self::$context)){

            $class = new \ReflectionClass(static::class);
            $methods = $class->getMethods(\ReflectionMethod::IS_PUBLIC);

            $method = array_filter($methods, function($item){
                if($item->class == (new \ReflectionClass(static::class))->name){
                    return $item;
                }
            });
            $class = new static();
            foreach($method as $md){
                call_user_func($class->{$md->name}());
                $class->{$md->name}();
            }

            self::$context = new ModelsForward(static::class, static::$_filed, self::$with);
            // return self::$context->$method(...$args);
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

    //relationship

    protected function hasOne( $model, $column_target, $this_column){
        $relationship = get_calling_function();
        self::$with[$relationship] = [
            'rel' => 'hasOne',
            'model' => $model,
            'column_target' => $column_target,
            'column_this' => $this_column
                
        ];
    }

    protected function belongTo($model, $column_target, $this_column){
        $relationship = get_calling_function();
        self::$with[$relationship] = [
            'rel' => 'belongTo',
            'model' => $model,
            'column_target' => $column_target,
            'column_this' => $this_column
        ];
            
    }
}