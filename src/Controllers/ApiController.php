<?php

namespace App\Controllers;

class ApiController {
    public function index($request, $response, $args) {
        return "api index";
    }
    public function createOrder($request, $response, $args) {
        return "api createOrder";
    }
    public function orderInfo($request, $response, $args) {
        return "api orderInfo" . $args['id'];
    }
    public function reception($request, $response, $args) {
        return "success";
    }
};
