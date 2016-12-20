<?php

namespace App\Services;

class Config {
    private static $settings; 
    public function __construct ($set) {

         self::$settings = $set['settings'];
    }
    public static function getAlipayConfig() {
         $alipay_path =  self::$settings['alipay']['config_path'];
         return json_decode(file_get_contents($alipay_path), true);
      
    }
}
