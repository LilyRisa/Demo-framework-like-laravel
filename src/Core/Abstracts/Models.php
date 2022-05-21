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
    protected static $_field = [];
    public static $with = [];

    public function __construct(){

        
        
        
    }

    public static function __callStatic($method, $args)
    {
        if(empty(self::$context)){
            self::$context = new ModelsForward(static::class, static::$_field, self::$with);
        }
        if (!method_exists(static::class, $method) && method_exists(self::$context,$method)) {
            return self::$context->$method(...$args);
        }
    }

    public static function with(...$args){
        $self_instance = new static();
        foreach($args as $f){
            $self_instance->{$f}(); 
        }
        return (new ModelsForward(static::class, static::$_field, $self_instance::$with));
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
        $class = new \ReflectionClass(static::class);
        $methods = $class->getMethods(\ReflectionMethod::IS_PUBLIC); 

        $method = array_filter($methods, function($item){
                if($item->class == (new \ReflectionClass(static::class))->name){
                    return $item;
                }
            });

        $relationship = get_calling_function();
        $rels = [];
        foreach($relationship as $rel){
            foreach($method as $mt){
                if($rel == $mt->name){
                    $rels[] = $rel;
                }
            }
        }
        foreach($rels as $r){
            static::$with[$r] = [
                'rel' => 'hasOne',
                'model' => $model,
                'field' => [],
                'column_target' => $column_target,
                'column_this' => $this_column
                    
            ];
        }
        
    }

    protected function belongTo($model, $column_target, $this_column){
        $class = new \ReflectionClass(static::class);
        $methods = $class->getMethods(\ReflectionMethod::IS_PUBLIC); 

        $method = array_filter($methods, function($item){
                if($item->class == (new \ReflectionClass(static::class))->name){
                    return $item;
                }
            });

        $relationship = get_calling_function();
        $rels = [];
        foreach($relationship as $rel){
            foreach($method as $mt){
                if($rel == $mt->name){
                    $rels[] = $rel;
                }
            }
        }
        foreach($rels as $r){
            static::$with[$r] = [
                'rel' => 'belongTo',
                'model' => $model,
                'field' => [],
                'column_target' => $column_target,
                'column_this' => $this_column
                    
            ];
        }
            
    }
}