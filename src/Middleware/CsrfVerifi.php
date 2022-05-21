<?php

namespace CM\Middleware;

use CM\Core\Interfaces\Middleware as MiddlewareInterface;
use CM\Core\Request;
use CM\Core\Abstracts\Middleware;
use CM\Core\Hash;
use CM\Core\Response;
use Exception;

class CsrfVerifi extends Middleware implements MiddlewareInterface{

    public function handle(Request $request){
        global $_ENV, $_SESSION;
        if($request->method() == 'POST' || $request->method() == 'PUT'){
            $token = !empty($request->header('X-CSRF-TOKEN')) ? $request->header('X-CSRF-TOKEN') : (!empty($request->input('csrf-token')) ? $request->input('csrf-token') : null);
            $token = Hash::factory()->decrypt($token);
            $token = explode('@@', $token);
            if(isset($_SESSION['CSRF-TOKEN'])){
                if($token[0] == $_ENV['APP_KEY'] && $token[1] == $_SESSION['CSRF-TOKEN']){
                    $_SESSION['CSRF-TOKEN'] = null;
                    return $this->next();
                }
            }
            
            throw new Exception('csrf token is invalid!');
        }
        return $this->next();
    }
}