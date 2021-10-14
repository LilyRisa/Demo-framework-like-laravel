<?php

namespace CM\Middleware;

use CM\Libs\Interfaces\Middleware as MiddlewareInterface;
use CM\Libs\Request;
use CM\Libs\Abstracts\Middlware;

class Test extends Middlware implements MiddlewareInterface{

    public function handle(Request $request){
        if($request->method() == 'GET'){
            $this->return = false;
            return $this->status($request, 300);
        }
        return $this->status($request);
    }
}