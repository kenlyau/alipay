<?php

namespace App\Controllers;

class BaseController {
    protected $ci;
    public function __construct($ci) {
         $this->ci = $ci;
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
