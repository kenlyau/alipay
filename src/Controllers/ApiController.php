<?php

namespace App\Controllers;

class ApiController extends BaseController {
    public function index($request, $response, $args) {
        return "api index";
    }
    public function createOrder($request, $response, $args) {
     
        $res = [
          "rest" => 1
   
        ];
        return $this->echoJson($response, $res);
    }
    public function orderInfo($request, $response, $args) {
        return "api orderInfo" . $args['id'];
    }
    public function reception($request, $response, $args) {
        return "success";
    }
}
