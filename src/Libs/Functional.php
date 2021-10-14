<?php
namespace CM\Libs;

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

        $key_vitural = Functional::array_find('{',$vitural_url);

        $return = [];

        foreach($key_vitural as $v){
            $return[$v['value']] = $real_url[$v['key']];
            unset($vitural_url[$v['key']]);
            unset($real_url[$v['key']]);
        }

        return ['bool' => ($vitural_url == $real_url), 'compare' => $return];
        
    }
}

