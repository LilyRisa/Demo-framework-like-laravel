<?php
namespace CM\Libs;
use CM\Libs\Interfaces\RequestInterface;

class Request implements RequestInterface{
    protected $request = [];
    protected $method = null;

    public function __construct($get_variable){
        $this->request = ['GET'=>$get_variable, 'POST' => $_POST];
        $this->method = $_SERVER['REQUEST_METHOD'];
    }

    public function method(){
        return $this->method;
    }

    public function input($input){
        // var_dump($this->request['POST']);
        return $this->request['POST'][$input];
    }

}