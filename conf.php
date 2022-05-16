<?php
try{
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();

}catch(Exception $e){
    throw new Exception($e);
}
create_config_db();
create_config_enviroment();
create_config_middleware();

