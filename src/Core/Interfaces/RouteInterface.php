<?php
namespace CM\Core\Interfaces;

interface RouteInterface{
    public static function get($url, $controller, $middle = null);
    public static function post($url, $controller, $middle = null);
}