<?php

namespace CM\Models;
use CM\Core\Abstracts\Models;

class Exam extends Models{

    public function User(){
        return $this->belongTo('CM\Models\Users','id', 'user_id');
    }
    
}