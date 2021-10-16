<?php
namespace CM\Core;

class Functional{

    public static function array_find($needle, array $haystack)
    {
        $key_arr = [];
        foreach ($haystack as $key => $value) {
            if (false !== stripos($value, $needle)) {
                $key_arr[] = ['key'=> $key, 'value' => explode('{',explode('}',$value)[0])[1] ];
            }
        }
        return $key_arr;
    }

    public static function url_convert($vitural_url, $real_url){
        
        $vitural_url = explode('/',$vitural_url);
        $real_url = explode('/',$real_url);
        // var_dump($vitural_url);
        // var_dump($real_url);
        $key_vitural = self::array_find('{',$vitural_url);
        // var_dump($key_vitural);

        if($vitural_url[0] != $real_url[0]){
            return ['bool' => false, 'compare' => []];
        }

        if(count($vitural_url) == count($real_url)){
            if(empty($key_vitural)){
                return ['bool' => true, 'compare' => []];
            }
        }

        // $key_vitural = self::array_find('{',$vitural_url);

        $return = [];

        // var_dump($vitural_url);
        // var_dump($real_url);

        foreach($key_vitural as $v){
            // if(array_key_exists($v['key'], $real_url)){
                $return[] = $real_url[$v['key']];
                unset($vitural_url[$v['key']]);
                unset($real_url[$v['key']]);
            // }
            // return ['bool' => false];
        }

        
        return ['bool' => ($vitural_url == $real_url), 'compare' => $return];
        
    }
}

