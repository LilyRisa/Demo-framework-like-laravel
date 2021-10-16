<?php

namespace CM\Core\Interfaces;
use CM\Core\Request;

interface Middleware{
    public function handle(Request $request);
}