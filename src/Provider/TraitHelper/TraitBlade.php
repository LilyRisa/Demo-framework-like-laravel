<?php

namespace CM\Provider\TraitHelper;
use CM\Core\Functional;

trait TraitBlade{

    public function compileRoute($expression=null){
        if ($expression===null || $expression==='()') {
            return "<?php echo ''; ?>";
        }
        
        $field = explode('(',$expression);
        $field = $field[1];
        $field = explode(')',$field);
        $field = $field[0];
        $field = (array)json_decode($field);
        $name = $field['name'];
        unset($field['name']);
        $arr = $field;
        // var_dump($arr);
        if(empty($arr)){
            return "<?php echo '/$name'; ?>"; 
        }

        global $_ROUTE_INSTANCES;
        $ls = $_ROUTE_INSTANCES;

        $isEmpty = null;
        foreach($ls as $key => $item){
            if($name == $item->name){
                $vitural_url = explode('/',$item->url);
                $check_var_url = Functional::array_find('{', $vitural_url);
                    if($check_var_url && $arr == []){
                        throw new \Exception("Route {$item->name}: Missing parameter");
                        return;
                    }
                    $isEmpty = $key;
            }
        }


        $route = $ls[$isEmpty];
        $vitural_url = explode('/',$route->url);
        foreach($check_var_url as $var){
            $route->url = str_replace('{'.$var['value'].'}',$arr[$var['value']] , $route->url);
        }

        $url_target = $route->url;
        return "<?php echo '/$url_target'; ?>"; 
    }
}