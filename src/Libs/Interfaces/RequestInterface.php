<?php

namespace CM\Libs\Interfaces;

interface RequestInterface{
    public function method();
    public function input($string);
}