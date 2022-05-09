<?php

namespace CM\Core\Abstracts;

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
    public function __get($name){
        if(isset($this->original[$name])){
            return $this->original[$name];
        }else if(isset($this->relationship[$name])){
            return $this->relationship[$name];
        }

    }
} 