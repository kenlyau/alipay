<?php

namespace App\Controllers;

use App\Models\Bill;
use App\Models\Order;

class ManageController extends BaseController 
{
    private $page_item = 20;

    public function index($request, $response, $args) 
    {
        $data = [];
        $data['stats'] = array(
             [
                'name' => '订单总数',
                'number' => Order::count()
             ],
             [
                'name' => '成交订单',
                'number' => Order::where('status', '=', 'success')->count()
             ],
             [
                 'name' => '成交金额',
                 'number' => Order::where('status', '=', 'success')->sum('amount')
             ],
             [
                  'name' => '支付总数',
                  'number' => Bill::count()
             ]
        );

        $this->view->render($response, 'manage/index.html', $data);
    }
    
    public function bill($request, $response, $args)
    {
        $pageNum = 1;
        if (isSet($request->getQueryParams()['page'])) {
            $pageNum = $request->getQueryParams()['page'];
        }
        
       
        $data = Bill::paginate($this->page_item, ['*'], 'page', $pageNum);
        $data->setPath('/manage/bill');
        $result = [
            'bills' => $data 
        ]; 
        $this->view->render($response, 'manage/bill.html', $result);
    }

    public function deleteBill($request, $response, $args) 
    {
        $result = [
            'ret' => 0
        ];

        if (isset($args['id'])){
            Bill::destroy($args['id']);
            $result['ret'] = 1;
        }

        return $this->echoJson($response, $result);
    }

    public function order($request, $response, $args)
    {
       $pageNum = 1;
       if (isset($request->getQueryParams()['page'])){
           $pageNum = $request->getQueryParams()['page'];
       }

       $data = Order::paginate($this->page_item, ['*'], 'page', $pageNum);
       $data->setPath('/manage/order');
       $result = [
           'orders' => $data
       ];
       $this->view->render($response, 'manage/order.html', $result);
    }

    public function deleteOrder($request, $response, $args)
    {
        $result = [
            'ret' => 0
        ];

        if (isset($args['id'])){
            Order::destroy($args['id']);
            $result['ret'] = 1;
        }

        return $this->echoJson($response, $result);
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
