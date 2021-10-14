<?php

namespace CM\Libs;
use CM\Libs\Interfaces\RouteInterface;
use CM\Libs\Functional;
use CM\Libs\Request;


class Route implements RouteInterface{


    public static function get($url, $controller, $middle = null){
        global $middleware;
        $class_controller = (explode('@', $controller))[0];
        $method_controller = (explode('@', $controller))[1];
        $class_controller = "CM\\Controllers\\".$class_controller;

        $request = new Request($url);
        $class_controller = new $class_controller();

        if($middle != null){
            $check = new $middleware[$middle]();
            if(!$check->handle()['status']){
                http_response_code($check->handle()['http_code']);
                echo $check->handle();
            }
        }
        $url = Functional::url_convert($url, $_GET['route']);
        if($url['bool']){
            if(is_callable(array($class_controller, $method_controller))){
                echo $class_controller->{$method_controller}($url['compare']);
            }else{
                throw new \Exception("{$method_controller}: Method does  not exist");
            }
        }
    }

    public static function post($url, $controller, $middle = null){
        global $middleware;
        $class_controller = (explode('@', $controller))[0];
        $method_controller = (explode('@', $controller))[1];
        $class_controller = "CM\\Controllers\\".$class_controller;

        $request = new Request($url);
        $class_controller = new $class_controller();

        if($middle != null){
            $check = new $middleware[$middle]();
            
            if(!$check->handle()['status']){
                http_response_code($check->handle()['http_code']);
                echo $check->handle();
            }
        }

        $url = Functional::url_convert($url, $_GET['route']);
        if($url['bool']){
            if(is_callable(array($class_controller, $method_controller))){
                echo $class_controller->{$method_controller}($request,$url['compare']);
            }else{
                throw new \Exception("{$method_controller}: Method does  not exist");
            }
        }
    }
}