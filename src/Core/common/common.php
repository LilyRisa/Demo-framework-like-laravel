<?php
use eftec\bladeone\BladeOne;
use CM\Provider\ClassHelper\Blade;

if ( ! function_exists('dd')) {
    function dd($data){
        echo '<pre style="border: solid #ff2222 1px;">';
        print_r($data);
        echo '</pre>';
        exit;
    }
}

if ( ! function_exists('ddQuery')) {
    function ddQuery($data){
        echo '<pre style="border: solid #ff2222 1px;">';
        print_r($data->sql);
        echo '</pre>';
        exit;
    }
}
if ( ! function_exists('view')) {
    function view($view, $data_array = [])
    {
        // use BladeOne template
        // see more https://github.com/EFTEC/BladeOne/wiki

        global $cache_view, $_ROUTE_INSTANCES;

        $views = PATH_VIEW;
        $cache = PATH_VIEW . '/cache';
        $blade = new Blade($views,$cache,BladeOne::MODE_DEBUG);
        $blade->setBaseUrl("public/"); // MODE_DEBUG allows to pinpoint troubles.
        return $blade->run($view,$data_array);
    }
}