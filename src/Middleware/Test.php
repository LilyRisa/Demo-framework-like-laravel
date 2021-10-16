<?php

namespace CM\Middleware;

use CM\Core\Interfaces\Middleware as MiddlewareInterface;
use CM\Core\Request;
use CM\Core\Abstracts\Middleware;
use CM\Core\Response;

class Test extends Middleware implements MiddlewareInterface{

    public function handle(Request $request){
        if($request->method() == 'GET'){
            // var_dump('hehe');
            return (new Response(200))->html('hehe');
        }
        return $this->next();
    }
}