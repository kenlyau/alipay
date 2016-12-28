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
    public function jsRedirect($reponse, $method, $to, $params) {
         $html = '<html><head><meta charset="utf-8"></head><body><form action="'. $to .'" method="'.$method.'" name="return_url" id="return_url">';
	 foreach ($params as $key => $value ) {
	     $html .= '<input type="hidden" name="'. $key .'" value="'. $value .'"/>';
	 }
	 $html .= '</form><script>document.forms["return_url"].submit();</script></body></html>';
         return $reponse->getBody()->write($html);
    }
}
