<?php

namespace CM\Core\Abstracts;
use CM\Core\Database;
use CM\Core\Abstracts\Instance;


class ModelsForward{

    protected $field = [];
    protected $table = null;
    protected $properties = [];
    protected static $connection;
    public $sql;

    public function __construct($subclass){
        self::openConnection();
        if($this->table == null){
            $subclass = explode('\\',$subclass);
            $subclass_name = end($subclass);
            $this->table = $subclass_name;
        }
        if($this->field == []){
            $column = self::$connection->db_query('DESCRIBE '.$this->table);
            if($column){
                while($row = $column->fetch_assoc()) {
                    $this->field[] = $row;
                }
            }
        }
    }

    private static function openConnection(){
        global $db;
        self::$connection = Database::getInstance($db);
    }


    public function __get($name){
        if(isset($this->properties[$name]))
          return $this->properties[$name];
    }

    protected function hasMany($model, $column){

    }
    protected function belongTo(){

    }

    public function get(){
        $data = self::$connection->db_query($this->sql);
        if($data){
            $rows = [];
            while($row = $data->fetch_assoc()) {
                $rows[] = new Instance($row);
            }
            return $rows;
        }
        return null;
    }

    public function all(){
        $field = $this->_field($this->field);
        $this->sql = "select $field from $this->table";
        return $this->get();
    }

    public function where($column, $value){
        $field = $this->_field($this->field);
        $this->sql = "select $field from $this->table where $column = ".(is_string($value) ? "'".$value."'" : $value);
        return $this;
    }

    public function find($column, $value){
        $field = $this->_field($this->field);
        $this->sql = "select $field from $this->table where $column = ".is_string($value) ? "'".$value."'" : $value;
        return $this->get();
    }

    public function orderBy($column, $value){
        $this->sql .=  "ORDER BY $column $value";
        return $this;
    }

    private function _field($arr){
        $arrcov = [];
        foreach($arr as $item){
            $arrcov[] = $item['Field'];
        }
        return implode(',', $arrcov);
    }


    

    // public static function find($column, $logic = null, $value = null){
    //     if($logic == null && $value == null){
    //         return self::all("id=$column");
    //     }else if(($logic == null && $value != null)||($logic != null && $value == null)){
    //         throw new Exception("Error");
    //     }else{
    //         return self::all("$column $logic '$value'");
    //     }
        
    // }

    // public static function search($match = [], $orderby = []){
    //     $sql = '';
    //     for($i=0; $i < count($match); $i++){
    //         $match[$i][2] = gettype($match[$i][2]) == 'string' ? "'".$match[$i][2]."'" : $match[$i][2];
    //         if($i == (count($match)-1)){
    //             $sql .= implode(' ',$match[$i]);
    //         }else{
    //             $sql .= implode(' ',$match[$i]).' AND ';
    //         }
    //     }

    //     if(empty($orderby)){
    //         return self::all("$sql");
    //     }

    //     $order = end($orderby);
    //     array_pop($orderby);
    //     $sql = $sql.' ORDER BY '.implode(',',$orderby).' '.$order;
    //     return self::all("$sql");
    // }

}