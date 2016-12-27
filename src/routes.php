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
    $this->get('/return_url', 'App\Controllers\ApiController:returnUrl');
});

$app->group('/manage', function() {
    $this->get('', 'App\Controllers\ManageController:index');
    $this->get('/', 'App\Controllers\ManageController:index');
    $this->get('/bill', 'App\Controllers\ManageController:bill');
    $this->delete('/bill/{id}', 'App\Controllers\ManageController:deleteBill');
    $this->get('/order', 'App\Controllers\ManageController:order');
    $this->delete('/order/{id}', 'App\Controllers\ManageController:deleteOrder');
    $this->get('/user', 'App\Controllers\ManageController:user');
    $this->put('/pass', 'App\Controllers\ManageController:pass');
})->add(new Auth());

$app->group('/auth', function() {
    $this->get('', 'App\Controllers\AuthController:login');
    $this->get('/', 'App\Controllers\AuthController:login');
    $this->get('/login', 'App\Controllers\AuthController:login');
    $this->post('/login', 'App\Controllers\AuthController:loginDo');
    $this->get('/loginout', 'App\Controllers\AuthController:loginOut');
});
