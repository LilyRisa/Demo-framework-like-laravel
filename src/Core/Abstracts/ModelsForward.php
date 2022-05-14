<?php

namespace CM\Core\Abstracts;
use CM\Core\Database;
use CM\Core\Abstracts\Instance;

class ModelsForward{

    protected $field = [];
    protected $table = null;
    protected $properties = [];
    protected static $connection; 
    public $tmp_data = null;
    private $primary_key = null;
    public $sql;

    public $instance = null;

    public function __construct($subclass){
        $this->tmp_data = new \stdClass;
        self::openConnection();
        if($this->table == null){
            $subclass = explode('\\',$subclass);
            $subclass_name = end($subclass);
            $this->table = $subclass_name;
        }
        $this->tmp_data = new \stdClass;
        if($this->field == []){
            $column = self::$connection->query('DESCRIBE '.$this->table);
            if($column){
                while($row = $column->fetch_assoc()) {
                    $this->field[] = $row;
                    $this->tmp_data->{$row['Field']} = null;
                }
            }
        }   
    }

    private static function openConnection(){
        global $db;
        self::$connection = Database::getInstance($db);
    }


    public function __get($name){
        if(isset($this->instance->original[$name]))
          return $this->instance->original[$name];
    }


    public function get($param = null, $create = false, $first = false, $instance = false){
        $data = self::$connection->multi_query($this->sql);
        if($data){
            $rows = [];
            do {
                if ($result = self::$connection->store_result()) {
                    while($row = $result->fetch_assoc()) {
                        if($create){
                            $rows[] = $row['LAST_INSERT_ID()'];
                        }else{
                            $rows[] = new Instance($row);
                        }
                    }
                }
            } while (self::$connection->next_result());

            

            if(!empty($param)){  // update by $param
                $ins = [];
                foreach ($rows as $v) {
                    $ins[] = clone $v;
                }
                foreach($ins as &$ins_item){
                    $ins_item->prim = $param;
                }
                $this->primary_key = $ins;
            }
            if($instance){
                // dd($rows[0])
                if(!empty($rows)){
                    $this->instance = $rows[0];
                    return $this;
                }else{
                    return null;
                }
                
            }

            if($create || $first){  // If created, return id, not array or If first, return id, get the first element
                if(!empty($rows)){
                    return $rows[0];
                }else{
                    return null;
                }
            }
            
            return $rows;
        }
        return null;
    }

    public function __set($property, $value){;
        if(!property_exists($this, $property)){
            if(property_exists($this->tmp_data, $property)){
                $this->tmp_data->$property = $value;
            }
            
        }
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

    public function find(...$args){
        switch (count($args)) {
            case 1:
                $column = 'id';
                $value = $args[0];
                break;
            case 2:
                $column = $args[0];
                $value = $args[1];
                break;
            default:
                throw new \Exception("The parameter passed to the function is not valid. Maximum of only 2 parameters. There are currently ".count($args)." parameters being passed in");
                break;
        }
        $field = $this->_field($this->field);
        $this->sql = "select $field from $this->table where $column = ".(is_string($value) ? "'".$value."'" : $value);
        return $this->get($column, false, false, true);
    }

    public function save(){

        if(empty($this->primary_key) && $this->tmp_data != null){
            $field = ($this->_field(get_object_vars($this->tmp_data), true))['key'];
            $value = ($this->_field(get_object_vars($this->tmp_data), true))['value'];
            $this->sql = "INSERT INTO `$this->table`($field) VALUES ($value);SELECT LAST_INSERT_ID();";
            return $this->get();
        }else if(!empty($this->primary_key) && $this->tmp_data != null){

            $data = (array) $this->tmp_data;
            $value = $this->_updateParam($data);
            $this->sql = null;
            foreach($this->primary_key as $item){
                $vali = self::$connection->real_escape_string($item->original[$item->prim]);
                $this->sql .= "UPDATE `$this->table` SET $value WHERE $item->prim = $vali;";
            }
            return $this->get();
        }else{
            throw new \Exception("Invalid function call");
        }
    }

    public function delete(){
        if(!empty($this->primary_key)){
            $this->sql = null;
            foreach($this->primary_key as $item){
                $vali = self::$connection->real_escape_string($item->original[$item->prim]);
                $this->sql = "DELETE FROM `$this->table` WHERE $item->prim = $vali;";
            }           
            return $this->get();
        }else{
            throw new \Exception("Invalid function call");
        }

    }

    public function orderBy($column, $value){
        $this->sql .=  "ORDER BY $column $value";
        return $this;
    }

    private function _field($arr, $setting = false){
        $arrcov = [];
        $keycov = [];
        $arr = array_filter($arr);
        foreach($arr as $key => $item){
            if($setting){
                $arrcov[] = is_string($item) ? "'".$item."'" : $item;
                $keycov[] = $key;
            }else{
                $arrcov[] = $item['Field'];
            }
            
        }
        if($setting){
            return ['key' => implode(',', $keycov), 'value' => implode(',', $arrcov)];
        }
        return implode(',', $arrcov);
    }

    private function _updateParam($arr){
        $arrcov = [];
        $arr = array_filter($arr);
        foreach($arr as $key => $item){
            $arrcov[] = $key."=".(is_string($item) ? "'".$item."'" : $item);
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