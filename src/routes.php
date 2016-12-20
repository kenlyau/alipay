<?php

use App\Controllers;
use App\Services\Config;
use App\Services\Alipay;
// Routes

$app->get('/', function ($request, $response, $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");
    $alipay_config = Config::getAlipayConfig();
    $alipay = new Alipay($alipay_config);
    $body = $alipay->buildRequestFormHtml(array(
        'out_trade_no'    => '12345',
        'subject'         => 'abcxxx',
        'total_fee'       => 0.05,
        'show_url'        => '',
        'anti_phishing_key' => '',
        'exter_invoke_ip'   => '',
        'it_b_pay'          => '',
        '_input_charset'    => 'utf-8'
    ),null,'_blank');
    var_dump($body);
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
