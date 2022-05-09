<?php
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