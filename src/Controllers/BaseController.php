<?php

namespace App\Controllers;

use Slim\Views\PhpRenderer;

class BaseController {
   
    protected $ci;

    public function __construct($ci) {
     
         $this->ci = $ci;
    }
    
    public function __get($property){
         if ($this->ci->{$property}){
             return $this->ci->{$property};
         }
    }

    public function echoJson($response, $res, $statusCode=200) {
         $newResponse = $response->withJson($res, $statusCode);
         return $newResponse;
    }
    public function redirect($response, $to) {
         $newResponse = $response->withStatus(302)->withHeader('Location', $to);
         return $newResponse;
    } 
}
