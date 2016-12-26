<?php

namespace App\Controllers;

use App\Models\Bill;
use App\Models\Order;
use App\Models\User;

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

        
        $currentMonthOrder = Order::whereDate('create_date', '>=', date('Y-m-01'))->where('status', '=', 'success')->get();
        
        $startDate = date('Y-m-d', strtotime('-1 months', time()));
        $endDate = date('Y-m-d');
        $days = date('t', strtotime($startDate));
        $dateArray = [];
        $dateXaxes = [];
        for($i=1; $i<=$days; $i++) 
        {
            $dateArray[date('Y-m-d', strtotime($startDate) + $i*24*60*60)] = 0 ;
            $dateXaxes[] = date('m-d', strtotime($startDate) + $i*24*60*60);
        }
        
        foreach($currentMonthOrder as $order){
            $newDay = date('Y-m-d',strtotime($order['create_date']));
            if(isset($dateArray[$newDay ])){
                $dateArray[$newDay] += $order['amount']; 
            }
        }
       
        $data['dateXaxes'] = $dateXaxes;
        $data['dateYaxes'] = array_values($dateArray);
        $this->view->render($response, 'manage/index.html', $data);
    }
    
    public function bill($request, $response, $args)
    {
        $pageNum = 1;
        if (isSet($request->getQueryParams()['page'])) {
            $pageNum = $request->getQueryParams()['page'];
        }
        
       
        $data = Bill::orderBy('id', 'desc')->paginate($this->page_item, ['*'], 'page', $pageNum);
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

       $data = Order::orderBy('id', 'desc')->paginate($this->page_item, ['*'], 'page', $pageNum);
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
        $user = User::first();
        $data = [
            'user' => $user
        ];
       
       $this->view->render($response, 'manage/user.html', $data);
    }

    public function pass($request, $response, $args)
    { 
        $result = [
            "ret" => 0
        ];
        
        if (!isset($request->getParsedBody()['id'])){
            $result['msg'] = "not found id";
            return $this->echoJson($response,$result);
        }
        
        $user = User::find($request->getParsedBody()['id']);
        
        if (empty($user)){
            $result['msg'] = "not found user";
            return $this->echoJson($response,$result);
        }
        $user['pass'] = sha1($request->getQueryParams()['pass']);
        $user->save();
        $result['ret'] = 1;

        return $this->echoJson($response, $result);
    }
}
