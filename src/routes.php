<?php

use App\Controllers;
// Routes

$app->get('/', 'App\Controllers\HomeController:index');
$app->get('/demo', 'App\Controllers\HomeController:demo');

$app->group('/api', function() {
    $this->get('', 'App\Controllers\ApiController:index');
    $this->get('/', 'App\Controllers\ApiController:index');
    $this->get("/order/{id}", 'App\Controllers\ApiController:orderInfo');
    $this->post("/order", 'App\Controllers\ApiController:createOrder');
    $this->post('/reception', 'App\Controllers\ApiController:reception');


});
