<?php

namespace CM\Core;

class Hash{

    private $iv_length = null;
    private $encryption_iv = null;
    private $ciphering = null;
    private $encryption_key = null;
    private static $_instance = null;

    private function __construct()
    {
        global $_ENV;

        $this->iv_length = openssl_cipher_iv_length("AES-128-CTR");
        $this->encryption_iv = '1234567891011121';
        $this->ciphering = 'AES-128-CTR';
        if(empty($_ENV['APP_KEY']) || !isset($_ENV['APP_KEY'])){
            throw new \Exception('APP_KEY was not found in the environment. Let\'s initialize inside the .env . file');
            // $this->encryption_key = bin2hex(random_bytes(10));
        }else{
            $this->encryption_key = $_ENV['APP_KEY'];
        }
       
    }

    public static function factory(){
        if(self::$_instance == null){
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function encrypt($string){
        return openssl_encrypt($string, $this->ciphering, $this->encryption_key, 0, $this->encryption_iv);
    }

    public function decrypt($string){
        return openssl_decrypt($string, $this->ciphering, $this->encryption_key, 0, $this->encryption_iv);
    }
}