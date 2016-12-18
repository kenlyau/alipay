<?php
// Routes

$app->get('/', function ($request, $response, $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");
   
    // Render index view
    return $this->renderer->render($response, 'index.phtml', $args);
});
$app->group('/api', function() {
    $this->get('', 'App\Controllers\ApiController:index');
    $this->get('/', 'App\Controllers\ApiController:index');
    $this->get("/order/{id}", 'App\Controllers\ApiController:orderInfo');
    $this->post("/order", 'App\Controllers\ApiController:createOrder');
    $this->post('/reception', 'App\Controllers\ApiController:reception');


});
