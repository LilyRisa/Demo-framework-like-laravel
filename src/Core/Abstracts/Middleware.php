<?php
namespace CM\Core\Abstracts;

use CM\Core\Request;
use CM\Core\Abstracts\TrackableRoute;

abstract class Middleware{
    private $data;

    public function __construct($data){
        $this->data = $data;
    }

    public function next(){
        new TrackableRoute($data);
    }

}