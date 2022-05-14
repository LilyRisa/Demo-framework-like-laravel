<?php

namespace CM\Core\Abstracts;

use CM\Core\Database;
use CM\Core\Functional;
use eftec\bladeone\BladeOne;
use CM\Provider\ClassHelper\Blade;

class Controller{
    public $connection = null;

    function __construct(){
        $this->openConnection();
    }

    private function openConnection(){
        global $db;
        $this->connection = Database::getInstance($db);
    }

}