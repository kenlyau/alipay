<?php

namespace App\Controllers;

class ManageController extends BaseController 
{
    public function index($request, $response, $args) 
    {
        $data = [];
        $data['stats'] = array(
             [
                'name' => '订单总数',
                'number' => 99
             ],
             [
                'name' => '成交订单',
                'number' => 88
             ],
             [
                 'name' => '成交金额',
                 'number' => 789
             ],
             [
                  'name' => '交易总数',
                  'number' => 87
             ]
        );
        $this->view->render($response, 'manage/index.html', $data);
    }
    
    public function bill($request, $response, $args)
    {
       $data = [];
       $this->view->render($response, 'manage/bill.html', $data);
    }

    public function order($request, $response, $args)
    {
       $data = [];
       $this->view->render($response, 'manage/order.html', $data);
    }

    public function user($request, $response, $args)
    {
       $data = [];
       $this->view->render($response, 'manage/user.html', $data);
    }

    public function pass()
    { 

    }
}
