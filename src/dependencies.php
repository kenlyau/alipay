<?php

// DIC configuration

$container = $app->getContainer();

// view renderer
//$container['renderer'] = function ($c) {
//    $settings = $c->get('settings')['renderer'];
//    return new Slim\Views\PhpRenderer($settings['template_path']);
//i};

$container['view'] = function($c) {
    $settings = $c->get('settings')['renderer'];
    $view = new Slim\Views\Twig($settings['template_path']);
    $view->parseOptions = array(
        'debug' => true,
        'cache' => BASE_PATH . '/data/cache'
    ); 
    $basePath = rtrim(str_ireplace('index.php', '', $c['request']->getUri()->getBasePath()), '/');
    $view->addExtension(new Slim\Views\TwigExtension($c['router'], $basePath));

    return $view;
};


// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
    return $logger;
};

// config
$container['config'] = function($c) {
    $settings = $c->get('settings');
    $config = new App\Services\Config($settings);
    return $config;
};

// alipaypay
$container['alipay'] = function($c) {
    $settings = $c->get('settings');
    $alipay_config = json_decode(file_get_contents($settings['alipay']['config_path']), true);
    $alipay = new App\Services\Alipay($alipay_config);
    return $alipay;
};

//database
//$container['db'] = function($c) {
//    $settings = $c->get('settings');
//    $capsule = new \Illuminate\Database\Capsule\Manager;
//    $capsule->addConnection($settings['db']);
//
//    $capsule->setAsGlobal();
//    $capsule->bootEloquent();
//
//    return $capsule;
//};

$container['BaseController'] = function($c) {
    return new  App\Controllers\BaseController($c);
};
