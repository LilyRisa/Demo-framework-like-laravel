<?php

namespace CM\Core\Abstracts;
use CM\Core\Database;

abstract class Models{

    protected $field;
    protected static $connection;

    public function __construct(){
        self::openConnection();
    }

    private static function openConnection(){
        global $db;
        self::$connection = Database::getInstance($db);
    }

    public static function all($match=null){
        self::openConnection();
        $subclass = static::class;
        $subclass = explode('\\',$subclass);
        $subclass_name = end($subclass);
        $sql = $match == null ? "SELECT * FROM $subclass_name" : "SELECT * FROM $subclass_name WHERE $match";
        $data = self::$connection->db_query($sql);
        if($data){
            $rows = [];
            while($row = $data->fetch_assoc()) {
                $rows[] = $row;
            }
            return $rows;
        }
        return null;
    }

    public static function find($column, $logic = null, $value = null){
        if($logic == null && $value == null){
            return self::all("id=$column");
        }else if(($logic == null && $value != null)||($logic != null && $value == null)){
            throw new Exception("Error");
        }else{
            return self::all("$column $logic '$value'");
        }
        
    }

    public static function search($match = [], $orderby = []){
        $sql = '';
        for($i=0; $i < count($match); $i++){
            $match[$i][2] = gettype($match[$i][2]) == 'string' ? "'".$match[$i][2]."'" : $match[$i][2];
            if($i == (count($match)-1)){
                $sql .= implode(' ',$match[$i]);
            }else{
                $sql .= implode(' ',$match[$i]).' AND ';
            }
        }

        if(empty($orderby)){
            return self::all("$sql");
        }

        $order = end($orderby);
        array_pop($orderby);
        $sql = $sql.' ORDER BY '.implode(',',$orderby).' '.$order;
        return self::all("$sql");
    }

}