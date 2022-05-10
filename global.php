<?php


session_start();

$root_site = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/';

define('ROOTPATH', __DIR__);

