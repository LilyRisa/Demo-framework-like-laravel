<?php
namespace CM\Core;
use CM\Core\Interfaces\RequestInterface;

class Request implements RequestInterface{
    protected $request = [];
    protected $method = null;
    protected $header;

    public function __construct($get_variable){
        $this->request = ['GET'=>$get_variable, 'POST' => $_POST];
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->header = $_SERVER;
        $this->session = Session::getInstance();
    }

    public function method(){
        return $this->method;
    }

    public function input($input){
        // var_dump($this->request['POST']);
        return $this->request['POST'][$input];
    }

    public function path(){
        return $_GET['route'];
    }
    public function ip(){
        return $this->get_client_ip();
    }
    public function isMethod($mt){
        return $mt == $this->method;
    }

    public function browser(){
        return $this->get_browser();
    }

    public function userAgent(){
        return $this->get_browser('full');
    }

    public function session(){
        return $this->session;
    }


    public function header($pHeaderKey  = null){
        if($pHeaderKey == null){
            return getallheaders();
        }
        $SERVER = getallheaders();
        foreach($SERVER as $key => $s){
            if($key == strtoupper($pHeaderKey)){
                return $s;
            }
        }
    }

    private function get_client_ip() {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if(getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if(getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if(getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if(getenv('HTTP_FORWARDED'))
           $ipaddress = getenv('HTTP_FORWARDED');
        else if(getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = null;
        return $ipaddress;
    }

    private function get_browser($agent = null) {
        $agent = $_SERVER["HTTP_USER_AGENT"];

        if($agent == 'full'){
            return $agent;
        }

        if( preg_match('/MSIE (\d+\.\d+);/', $agent) ) {
            return "Internet Explorer";
        } else if (preg_match('/Chrome[\/\s](\d+\.\d+)/', $agent) ) {
            return "Chrome";
        } else if (preg_match('/Edge\/\d+/', $agent) ) {
            return "Edge";
        } else if ( preg_match('/Firefox[\/\s](\d+\.\d+)/', $agent) ) {
            return "Firefox";
        } else if ( preg_match('/OPR[\/\s](\d+\.\d+)/', $agent) ) {
            return "Opera";
        } else if (preg_match('/Safari[\/\s](\d+\.\d+)/', $agent) ) {
            return "Safari";
        }else{
            return $agent;
        }
    }

}