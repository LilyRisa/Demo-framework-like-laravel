<?php
namespace CM\Core;

use CM\Core\Hash;


class Cookie{
    
    public static function make($cookie_name, $value, $seconds, $url = '/'){
        $value = Hash::factory()->encrypt($value);
        setcookie($cookie_name, $value, time() + ($seconds * 30), $url);
    }

    public static function get($cookie_name){
        if(!isset($_COOKIE[$cookie_name])) {
            return Hash::factory()->decrypt($_COOKIE[$cookie_name]);
        }
        return null;
    }

    public static function hasCookie($cookie_name){
        if(isset($_COOKIE[$cookie_name])) {
            return true;
        }
        return false;
    }
    
}