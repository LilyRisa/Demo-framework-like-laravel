<?php

namespace CM\Core\Abstracts;

use CM\Core\Database;
use CM\Core\Functional;

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

        global $cache_view, $_ROUTE_INSTANCES;
        // var_dump($_ROUTE_INSTANCES);
        //if($cache_view){
            //$twig = new \Twig\Environment($twig_loader, [
                //'cache' => PATH_VIEW.'/compilation_cache',
            //]);
        //}else{
            $twig = new \Twig\Environment($twig_loader);
        //}
        
        $function = new \Twig\TwigFunction('asset', function($path){
            global $root_site;
            return $root_site.'public/'.$path;
        });
        $twig->addFunction($function);
        $route_add = new \Twig\TwigFunction('route', 'get_route');
        $twig->addFunction($route_add);
        // var_dump(get_defined_functions());
        return $twig->render($view, $data_array);
    }
}