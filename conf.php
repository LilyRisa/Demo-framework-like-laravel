<?php

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$middleware = [
    'TestMiddleware' => 'CM\\Middleware\\Test'
];

$db = [
    'host' => $_ENV['DB_HOST'],
    'user' => $_ENV['DB_USER'],
    'password' => $_ENV['DB_PASSWORD'],
    'datbase' => $_ENV['DB_DATABASE'],
    'port' => $_ENV['DB_PORT'],
];

$cache_view = $_ENV['CACHE_VIEW'];

define('PATH_VIEW', __DIR__.'/src/Views');