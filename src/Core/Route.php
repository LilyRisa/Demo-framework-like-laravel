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
        // var_dump($url);
        global $middleware;
        $class_controller = (explode('@', $controller))[0];
        $method_controller = (explode('@', $controller))[1];
        $class_controller = "CM\\Controllers\\".$class_controller;

        $request = new Request($url);
        $class_controller = new $class_controller();

        
        $url_after = Functional::url_convert($url, $_GET['route']);
        // var_dump($url_after['bool']);
        $name_route = new CallRoute($url);

        if($url_after['bool']){
            if(is_callable(array($class_controller, $method_controller))){
                $data = [
                    'url' => $_GET['route'],
                    'url_vitural' => $url,
                    'method' => 'GET',
                    'method_request' => $request->method(),
                    'controller' => $class_controller,
                    'method_controller' => $method_controller,
                    // 'get_var' => $url_after['compare'],
                    'post_var' => null,
                ];
                // var_dump($data);
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

    public static function post($url, $controller, $middle = null){
        global $middleware;
        $class_controller = (explode('@', $controller))[0];
        $method_controller = (explode('@', $controller))[1];
        $class_controller = "CM\\Controllers\\".$class_controller;

        $request = new Request($url);
        $class_controller = new $class_controller();

        if($middle != null){
            $check = new $middleware[$middle]();
            
            if(!$check->handle($request)['status']){
                http_response_code($check->handle($request)['http_code']);
                return $check->handle($request);
            }
        }

        $name_route = new CallRoute($url);

        $url_after = Functional::url_convert($url, $_GET['route']);
        if($url_after['bool']){
            if(is_callable(array($class_controller, $method_controller))){
                $data = [
                    'url' => $_GET['route'],
                    'url_vitural' => $url,
                    'method' => 'POST',
                    'method_request' => $request->method(),
                    'controller' => $class_controller,
                    'method_controller' => $method_controller,
                    // 'get_var' => $url_after['compare'],
                    'post_var' => $request,
                ];
                if($middle != null){
                    $check = new $middleware[$middle]($data);
                    echo $check->handle($request);
                    return $name_route;
                    exit;
                }else{
                    new TrackableRoute($data);
                }
                return $name_route;
                // new TrackableRoute($data);
                // return $class_controller->{$method_controller}($request,...$url_after['compare']);
            }else{
                throw new \Exception("{$method_controller}: Method does  not exist");
            }
            return $name_route;
        }
        return $name_route;
    }
}