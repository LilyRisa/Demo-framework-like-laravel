<?php 
namespace CM\Core\Abstracts;
use CM\Core\Abstracts\ModelsForward;
use CM\Core\Abstracts\Instance;
use CM\Core\Database;
use Exception;

class DB_forward{

    private $sql = '';
    private $table = '';
    private $field = '';
    private $conditions = [];
    private static $connection = null;

    public function __construct(){
        self::openConnection();
    }

    public function table($table){
        $this->table = $table;
        return $this;
    }

    public function select(...$sql){
        if(count($sql) == 1){
            $this->sql = $sql[0];
        }else{
            if(!is_array($sql[1])) throw new Exception('The 2nd argument must be an array');
            foreach($sql[1] as $key => $arg){
                $arg = is_string($arg) ? "'$arg'" : $arg;
                $sql[0] = str_replace(':'.$key, $arg, $sql[0]);
            }
            $this->sql = $sql[0];
        }
        return $this->get();
    }

    public function insert(...$sql){
        if(count($sql) == 1){
            $this->sql = $sql[0];
        }else{
            if(!is_array($sql[1])) throw new Exception('The 2nd argument must be an array');
            foreach($sql[1] as $key => $arg){
                $arg = is_string($arg) ? "'$arg'" : $arg;
                $sql[0] = str_replace(':'.$key, $arg, $sql[0]);
            }
            $this->sql = $sql[0];
        }
        return $this->get(false, true);
    }

    public function update(...$sql){
        if(count($sql) == 1){
            $this->sql = $sql[0];
        }else{
            if(!is_array($sql[1])) throw new Exception('The 2nd argument must be an array');
            foreach($sql[1] as $key => $arg){
                $arg = is_string($arg) ? "'$arg'" : $arg;
                $sql[0] = str_replace(':'.$key, $arg, $sql[0]);
            }
            $this->sql = $sql[0];
        }
        return $this->get(false, true);
    }

    public function delete(...$sql){
        if(count($sql) == 1){
            $this->sql = $sql[0];
        }else{
            if(!is_array($sql[1])) throw new Exception('The 2nd argument must be an array');
            foreach($sql[1] as $key => $arg){
                $arg = is_string($arg) ? "'$arg'" : $arg;
                $sql[0] = str_replace(':'.$key, $arg, $sql[0]);
            }
            $this->sql = $sql[0];
        }
        return $this->get(false, true);
    }

    public function statement(...$sql){
        if(count($sql) == 1){
            $this->sql = $sql[0];
        }else{
            if(!is_array($sql[1])) throw new Exception('The 2nd argument must be an array');
            foreach($sql[1] as $key => $arg){
                $arg = is_string($arg) ? "'$arg'" : $arg;
                $sql[0] = str_replace(':'.$key, $arg, $sql[0]);
            }
            $this->sql = $sql[0];
        }
        return $this->get(true);
    }

    public function get($status = false, $effect = false){
        $data = self::$connection->multi_query($this->sql);
        // dd($this->sql);
        if($data && !$status){
            $rows = [];
            do {
                if ($result = self::$connection->store_result()) {
                    while($row = $result->fetch_assoc()) {
                        if(!$effect){
                            $rows[] = new Instance($row);  
                        }
                    }
                }
            } while (self::$connection->more_results());
            
            if($effect){
                return self::$connection->affected_rows;
            }

            return $rows;
        }else if($data && $status){
            return $data;
        }else{
            return null;
        }
        
    }


    private function _field($arr){
       
        return implode(',', $arr);
    }

    private static function openConnection(){
        global $db;
        self::$connection = Database::getInstance($db);
    }
}