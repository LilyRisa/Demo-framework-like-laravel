<?php

namespace CM\Libs\Interfaces;

interface Middleware{
    public function handle(Request $request);
}