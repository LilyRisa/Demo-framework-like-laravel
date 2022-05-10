<?php
try{
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();
}catch(Exception $e){
    print_r($e);
}


$middleware = [
    'TestMiddleware' => 'CM\\Middleware\\Test'
];

$db = [
    'host' => isset($_ENV['DB_HOST']) ? $_ENV['DB_HOST'] : null,
    'user' => isset($_ENV['DB_USER']) ? $_ENV['DB_USER'] : null,
    'password' => isset($_ENV['DB_PASSWORD']) ? $_ENV['DB_PASSWORD'] : null,
    'datbase' => isset($_ENV['DB_DATABASE']) ? $_ENV['DB_DATABASE'] : null,
    'port' => isset($_ENV['DB_PORT']) ? $_ENV['DB_PORT'] : null,
];

$cache_view = isset($_ENV['CACHE_VIEW']) ? $_ENV['CACHE_VIEW'] : __DIR__.'/src/Views/cache';

define('PATH_VIEW', __DIR__.'/src/Views');