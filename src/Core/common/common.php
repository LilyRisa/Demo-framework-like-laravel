<?php
use eftec\bladeone\BladeOne;
use CM\Provider\ClassHelper\Blade;

if (!function_exists('dd')) {
    function dd(...$data){
        foreach($data as $item){
            echo '<pre style="border: solid #ff2222 1px;">';
            print_r($item);
            echo '</pre>';
            echo '</br>';
        }
        exit;
    }
}

if (!function_exists('ddQuery')) {
    function ddQuery($data){
        echo '<pre style="border: solid #ff2222 1px;">';
        print_r($data->sql);
        echo '</pre>';
        exit;
    }
}
if (!function_exists('view')) {
    function view($view, $data_array = [])
    {
        // use BladeOne template
        // see more https://github.com/EFTEC/BladeOne/wiki

        global $cache_view, $_ROUTE_INSTANCES;

        $views = ROOTPATH;
        $cache = ROOTPATH . 'src/cache/views';
        $blade = new Blade($views,$cache,BladeOne::MODE_DEBUG);
        $blade->setBaseUrl("public/"); // MODE_DEBUG allows to pinpoint troubles.
        return $blade->run($view,$data_array);
    }
}

if (!function_exists('cache_clear')) {
    function cache_clear($args = 'view'){
        try{
            switch ($args) {
                case 'view':
                    $files = glob(__DIR__.'../../../Views/cache/*'); // get all file names
                    foreach($files as $file){ // iterate files
                        if(is_file($file)) {
                            unlink($file); // delete file
                        }
                    }
                    break;
                
                default:
                    # code...
                    break;
            }
            return true;
        }catch(Exception $e){
            return false;
        } 
        
    }
}

if (!function_exists('create_config_db')) {
    function create_config_db(){
        global $_ENV;
        if (!file_exists(ROOTPATH.'/src/config/database.php')){
            $host = isset($_ENV['DB_HOST']) ? $_ENV['DB_HOST'] : null;
            $user = isset($_ENV['DB_USER']) ? $_ENV['DB_USER'] : null;
            $password = isset($_ENV['DB_PASSWORD']) ? $_ENV['DB_PASSWORD'] : null;
            $database = isset($_ENV['DB_DATABASE']) ? $_ENV['DB_DATABASE'] : null;
            $port = isset($_ENV['DB_PORT']) ? $_ENV['DB_PORT'] : null;
        
             $env = "
<?php 
$"."db = [
    'host' => '$host',
    'user' => '$user',
    'password' => '$password',
    'database' => '$database',
    'port' => '$port',
];
";
            file_put_contents(ROOTPATH.'/src/config/database.php', $env);
        }
    }
}

if (!function_exists('create_config_enviroment')) {
    function create_config_enviroment(){
        if (!file_exists(ROOTPATH.'/src/config/enviroment.php')){
            $cache_view = isset($_ENV['CACHE_VIEW']) ? $_ENV['CACHE_VIEW'] : ROOTPATH.'/src/Views/cache';
            $debug = isset($_ENV['DEBUG']) ? ($_ENV['DB_HOST'] == "prod" ? false : true) : true;
            $env = "
<?php
$"."filename = ROOTPATH.'/src/logs/logs.txt';
$"."datetimeFormat = 'd-m-Y';
$"."cache_view = '$cache_view';
$"."debug = $debug;

    ";
            file_put_contents(ROOTPATH.'/src/config/enviroment.php', $env);
        }
    }
}

if (!function_exists('create_config_middleware')) {
    function create_config_middleware(){
        if (!file_exists(ROOTPATH.'/src/config/middleware.php')){
            $env = "
<?php
$"."middleware = [


]; //middleware config
    ";
            file_put_contents(ROOTPATH.'/src/config/middleware.php', $env);
        }
    }
}

if ( ! function_exists('getSubClassNames')) {
    function getSubClassNames(string $className): array
    {
        $ref = new \ReflectionClass($className);
        $parentRef = $ref->getParentClass();

        return array_unique(array_merge(
            [$className],
            $ref->getInterfaceNames(),
            $ref->getTraitNames(),
            $parentRef ?getSubClassNames($parentRef->getName()) : []
        ));
    }
}

if ( ! function_exists('clear_file')) {
    function clear_file(string $path): void
    {
        $files = glob($path."/*", GLOB_BRACE); // get all file names
        foreach($files as $file){ // iterate files
            if(is_file($file)) {
                unlink($file); // delete file
            }
        }
    }
}
if ( ! function_exists('remove_dir')) {
    function remove_dir($dir) { 
        if (is_dir($dir)) { 
          $objects = scandir($dir);
          foreach ($objects as $object) { 
            if ($object != "." && $object != "..") { 
              if (is_dir($dir. DIRECTORY_SEPARATOR .$object) && !is_link($dir."/".$object))
              remove_dir($dir. DIRECTORY_SEPARATOR .$object);
              else
                unlink($dir. DIRECTORY_SEPARATOR .$object); 
            } 
          }
          rmdir($dir); 
        } 
      }
}

if ( ! function_exists('is_cli')) {
    function is_cli()
    {
        if ( defined('STDIN') )
        {
            return true;
        }
    
        if ( php_sapi_name() === 'cli' || php_sapi_name() === "cli-server")
        {
            return true;
        }
    
        if ( array_key_exists('SHELL', $_ENV) ) {
            return true;
        }
    
        if ( empty($_SERVER['REMOTE_ADDR']) and !isset($_SERVER['HTTP_USER_AGENT']) and count($_SERVER['argv']) > 0) 
        {
            return true;
        } 
    
        if ( !array_key_exists('REQUEST_METHOD', $_SERVER) )
        {
            return true;
        }
    
        return false;
    }
}

if ( ! function_exists('folder_exist')) {
    function folder_exist($folder)
    {
        // Get canonicalized absolute pathname
        $path = realpath($folder);

        // If it exist, check if it's a directory
        if($path !== false AND is_dir($path))
        {
            // Return canonicalized absolute pathname
            return $path;
        }

        // Path/folder does not exist
        return false;
    }
}

if ( ! function_exists('folder_create')) {
    function folder_create($folder, $permission){
        if(!folder_exist($folder)){
            try{
                mkdir($folder, $permission);
                return true;
            }catch(\Exception $e){
                throw new Exception($e);
            }
        }else{
            return false;
        }
    }

}

if ( ! function_exists('get_calling_function')) {
    function get_calling_function($function = null) {

        //get the trace
        $trace = debug_backtrace();

        // Get the class that is asking for who awoke it
        if($function == null){
            $function = $trace[1]['function'];
        }
        
        $ls = [];

        // +1 to i cos we have to account for calling this function
        for ( $i=1; $i<count( $trace ); $i++ ) {
            if ( isset( $trace[$i] ) ) // is it set?
                if ( $function != $trace[$i]['function'] ) // is it a different class
                    $ls[] =  $trace[$i]['function'];
        }

        if(count($ls) == 1){
            return $ls[0];
        }
        return $ls;
    }
}