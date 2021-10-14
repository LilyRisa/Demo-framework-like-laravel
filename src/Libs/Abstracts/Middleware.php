<?php
namespace CM\Libs\Abstracts;

abstract class Middlware{
    public $return = true;

    public function status(Request $request, $http_code){
        return ['status' => $this->return,'http_code' => $http_code, 'request' => $request];
    }
}