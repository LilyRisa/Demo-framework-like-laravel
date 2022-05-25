<?php
namespace CM\Core\Abstracts;


class Core{
    protected $method;
    protected $controller;
    protected $method_controller;
    protected $get_var;
    protected $post_var;
    protected $method_request;


    public function __construct($arr){
        
        if(empty($arr)){
            return $this->error();
        }
        $key_arr = array_keys($arr);
        $key = array_search($_SERVER['REQUEST_METHOD'], $key_arr);
        $arr = $arr[$key_arr[$key]];
        // var_dump($key_arr[$key]);
        $this->method = $key_arr[$key];
        $this->controller = $arr['controller'];
        $this->method_controller = $arr['method_controller'];
        $this->post_var = $arr['post_var'];
        $this->get_var = $arr['get_var'];
        $this->method_request = $arr['method_request'];
    }

    public function run(){
        if($this->method_request != $this->method){
            throw new \Exception("{$this->method}: only method");
            exit;
        }

        // echo $this->controller->{$this->method_controller}($this->post_var,...$this->get_var);

        if($this->method == 'POST'){
            echo $this->controller->{$this->method_controller}($this->post_var,...$this->get_var);
        }else{
            echo $this->controller->{$this->method_controller}(...$this->get_var);
        }
        
    }

    public function error(){
        $html = file_get_contents(ROOTPATH.'/src/Core/Component/404.html');
        echo $html;
        exit;
    }
}