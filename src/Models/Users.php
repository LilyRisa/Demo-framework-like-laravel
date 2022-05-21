<?php

namespace CM\Models;
use CM\Core\Abstracts\Models;

class Users extends Models{
    public static $_field = ['name', 'dev'];

    public function Exam(){
        return $this->hasOne('CM\Models\Exam','user_id', 'id');
    }
}