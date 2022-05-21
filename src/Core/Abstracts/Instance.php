<?php

namespace CM\Core\Abstracts;

use Exception;

class Instance{
    public $field = [];
    public $original = [];
    public $relationship = [];

    public function __construct($data, $relationship = null)
    {
        $this->field = array_keys($data);
        foreach($data as $key => $item){
            $this->original[$key] = $item;
        }
        if(!empty($relationship)){
            foreach($relationship as $key => $relationship_child){
                foreach($relationship_child as $rel){
                    $this->$relationship[$key] = new self($rel);
                }
            }
        }
    }
    public function set_relationship($key,$arr){
        $this->relationship[$key] = $arr;
    }
    public function __get($name){
        if(isset($this->original[$name])){
            return $this->original[$name];
        }
        if(isset($this->relationship[$name])){
            if(count($this->relationship[$name]) == 1){
                return $this->relationship[$name][0];
            }
            return $this->relationship[$name];
        }

    }
} 