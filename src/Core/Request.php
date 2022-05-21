<?php
namespace CM\Core;
use CM\Core\Interfaces\RequestInterface;

class Request implements RequestInterface{
    protected $request = [];
    protected $method = null;
    protected $header;

    public function __construct($get_variable){
        $this->request = ['GET'=>$get_variable, 'POST' => $_POST];
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->header = $_SERVER;
    }

    public function method(){
        return $this->method;
    }

    public function input($input){
        // var_dump($this->request['POST']);
        return $this->request['POST'][$input];
    }

    public function header($pHeaderKey  = null){
        if($pHeaderKey == null){
            return getallheaders();
        }
        $SERVER = getallheaders();
        foreach($SERVER as $key => $s){
            if($key == strtoupper($pHeaderKey)){
                return $s;
            }
        }
    }

}