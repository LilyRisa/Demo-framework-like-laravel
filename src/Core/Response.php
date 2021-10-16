<?php
namespace CM\Core;

class Response {
    protected $http = 200;

    public function __construct($http_code){
        $this->http = $http_code;
        return $this;
    }

    public function header($header){
        header($header);
        return $this;
    }

    public function json($arr){
        header('Content-Type: application/json');
        return json_encode($arr);
    }

    public function html($html){
        header('content-type: text/html; charset=UTF-8');
        return $html;
    }

}