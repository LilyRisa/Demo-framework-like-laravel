<?php


session_start();

$root_site = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/';

define('ROOTPATH', __DIR__);

function assets($path){
    global $root_site;
    return $root_site.'Public/'.$path;
}


use CM\Core\Functional;

// var_dump($_ROUTE_INSTANCES);

function get_route($name, $arr = []){
    global $_ROUTE_INSTANCES;
    $ls = $_ROUTE_INSTANCES;
    // var_dump($ls);
    $isEmpty = null;
    foreach($ls as $key => $item){
        if($name == $item->name){
            $vitural_url = explode('/',$item->url);
            $check_var_url = Functional::array_find('{', $vitural_url);
                if($check_var_url && $arr == []){
                    throw new \Exception("Route {$item->name}: Missing parameter");
                    return;
                }
                $isEmpty = $key;
        }
    }
    // echo $isEmpty;
    // if($isEmpty == null){
    //     throw new \Exception("Route {$name} Does not exist !");
    // }

    $route = $ls[$isEmpty];
    $vitural_url = explode('/',$route->url);
    foreach($check_var_url as $var){
        $route->url = str_replace('{'.$var['value'].'}',$arr[$var['value']] , $route->url);
    }

    return '?route='.$route->url;

}

