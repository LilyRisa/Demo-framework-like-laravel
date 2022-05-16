<?php

if(!isset($_SESSION)) 
{ 
    session_start(); 
}

$root_site = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/';

if (!defined('ROOTPATH')) define('ROOTPATH', __DIR__);
if (!defined('PATH_VIEW')) define('PATH_VIEW', __DIR__.'/../Views');
try{
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();

}catch(Exception $e){
    throw new Exception($e);
}

create_config_db();
create_config_enviroment();
create_config_middleware();

