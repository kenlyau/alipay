<?php

namespace App\Controllers;

class HomeController extends BaseController
{
    public function index($request, $response, $args)
    {
        $this->view->render($response, 'index.html');
    }
   
    public function demo($request, $response, $args)
    {
        $data = [
            'out_trade_no'   => 'no' . time(),
            'subject'        => '小面包',
            'total_fee'      => '0.13',
            'body'           => '啤酒配面包',
            'show_url'       => ''
        ];
        $this->view->render($response, 'demo.html', $data);
    }

}
