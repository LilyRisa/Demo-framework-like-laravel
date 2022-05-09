<?php

namespace CM\Core\Abstracts;

use CM\Core\Database;
use CM\Core\Functional;
use eftec\bladeone\BladeOne;

class Controller{
    public $connection = null;

    function __construct(){
        $this->openConnection();
    }

    private function openConnection(){
        global $db;
        $this->connection = Database::getInstance($db);
    }

    public function view($view, $data_array = [])
    {
        // use BladeOne template
        // see more https://github.com/EFTEC/BladeOne/wiki

        global $cache_view, $_ROUTE_INSTANCES;

        $views = PATH_VIEW;
        $cache = PATH_VIEW . '/cache';
        $blade = new BladeOne($views,$cache,BladeOne::MODE_DEBUG);
        $blade->setBaseUrl("public/"); // MODE_DEBUG allows to pinpoint troubles.
        return $blade->run($view,$data_array);
    }
}