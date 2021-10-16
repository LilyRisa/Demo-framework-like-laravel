<?php

namespace CM\Core\Interfaces;

interface RequestInterface{
    public function method();
    public function input($string);
    public function header($data = null);
}