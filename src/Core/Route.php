<?php

namespace CM\Core;
use CM\Core\Interfaces\RouteInterface;
use CM\Core\Abstracts\TrackableRoute;
use CM\Core\Functional;
use CM\Core\Request;
use CM\Core\CallRoute;


class Route implements RouteInterface{

    protected $url;
    protected $controller;
    protected $middle = null;


    public static function get($url, $controller, $middle = null){
        return self::Processing_route('GET', $url, $controller, $middle);
         
    }

    public static function post($url, $controller, $middle = null){
        return self::Processing_route('POST', $url, $controller, $middle);
    }

    private static function Processing_route($method, $url, $controller, $middle = null){
        global $middleware, $_autoload, $_api;
         $class_controller = (explode('@', $controller))[0];
         $method_controller = (explode('@', $controller))[1];
         $class_controller = "CM\\Controllers\\".$class_controller;
 
         $request = new Request($url);
         $class_controller = new $class_controller();
 
         
         $url_after = Functional::url_convert($url, !is_cli() ?  $_GET['route'] : $_SERVER["REQUEST_URI"]);
         // var_dump($url_after['bool']);
         $name_route = new CallRoute($url);
 
         if($url_after['bool']){
             if(is_callable(array($class_controller, $method_controller))){
                 $data = [
                     'url' => !is_cli() ?  $_GET['route'] : $_SERVER["REQUEST_URI"],
                     'url_vitural' => $url,
                     'method' => $method,
                     'method_request' => $request->method(),
                     'controller' => $class_controller,
                     'method_controller' => $method_controller,
                     // 'get_var' => $url_after['compare'],
                     'post_var' => $method == 'GET' ? null : $request,
                 ];  

                $file = debug_backtrace();
                $file = self::getNameFileCall($file);

                if($file != 'Api.php'){
                    //  autoload middleware route web.php
                    foreach($_autoload as $f){
                        (new $f($data))->handle($request);
                    }
                }else{
                    if(!empty($_api['cors'])){
                        foreach($_api['cors'] as $f){  //cors
                            header($f);
                        }
                    }
                    
                    if(!empty($_api['middleware'])){
                        //  autoload middleware route web.php
                        foreach($_api['middleware'] as $f){
                            (new $f($data))->handle($request);
                        }
                    }
                        
                }
                

                 if($middle != null){
                     $check = new $middleware[$middle]($data);
                     echo $check->handle($request);
                     exit;
                 }else{
                     new TrackableRoute($data);
                 }
                 // return $class_controller->{$method_controller}(...$url_after['compare']);
             }else{
                 throw new \Exception("{$method_controller}: Method does  not exist");
             }
             return $name_route;
         }
         return $name_route;
    }

    private static function getNameFileCall($args){
        $filename = end($args);
        $filename = $filename['args'];
        if(count($filename) > 1){
            throw new \Exception('Duplicate routes API and WEB!');
        }
        $filename = $filename[0];
        $filename = explode('\\', $filename);
        $filename = end($filename);
        return $filename;
    }
}