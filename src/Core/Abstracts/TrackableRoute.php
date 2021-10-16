<?php

namespace CM\Core\Abstracts;

use CM\Core\Functional;

class TrackableRoute{
    protected static $_instances = [];

    public function __construct($arr){

        $check_url = $this->compare_url($arr['url'], $arr['url_vitural']);
        // var_dump($check_url);
        if($check_url != -1){
            self::$_instances[$arr['method']] = [
                'controller' => $arr['controller'],
                'method_controller' => $arr['method_controller'],
                'post_var' => $arr['post_var'],
                'get_var' => $check_url,
                'method_request' => $arr['method_request']
            ];
        }
    }

    public function __destruct(){
    }

    public static function getInstances(){
        return self::$_instances;
    }

    private function compare_url($url_real, $url_vitural){
        $url_after = Functional::url_convert($url_vitural, $url_real);
        // var_dump($url_after);
        if($url_after['bool']){
            return $url_after['compare'];
        }
        return -1;
    }
}