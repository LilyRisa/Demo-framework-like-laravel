<?php

namespace CM\Libs\Abstracts;

use CM\Libs\Database;

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
        $twig_loader = new \Twig\Loader\FilesystemLoader(PATH_VIEW);
        $twig = new \Twig\Environment($twig_loader, [
            'cache' => PATH_VIEW.'/compilation_cache',
        ]);
        $function = new \Twig\TwigFunction('asset', function($path){
            global $root_site;
            return $root_site.'public/'.$path;
        });
        $twig->addFunction($function);
        return $twig->render($view, $data_array);
    }
}