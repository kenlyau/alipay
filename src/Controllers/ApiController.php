<?php

namespace App\Controllers;

use App\Models\Order;
use App\Models\Bill;

class ApiController extends BaseController {
    
    private $page_item = 20;

    public function index($request, $response, $args) {
        $params = $request->getQueryParams();
        if (isSet($params['page'])){
         
            $page = $params['page'];
         }else{
            $page = 1;
         }
        $result = Order::limit(20)->offset($this->page_item * ($page-1))->get();
        return $this->echoJson($response, $result);
    }
    public function createOrder($request, $response, $args) {
    
    $body = $request->getParsedBody();
    print_r($body); 
    $order = new Order;
    $order->order_id = $body['order_id'];
    $order->subject = $body['subject'];
    $order->user_id = $body['user_id'];
    $order->amount = $body['amount'];
    $order->from = $body['from'];

    $result = $order->save();
    if (!$result){
       return "error";
    }
    $alipayParams = [
         'out_trade_no' => $body['order_id'],
         'total_fee' => $body['amount'],
         'subject' => $body['subject'],
         'body' => $body['body'],
         'show_url' => $body['show_url']
    ];

    
    $alipayBody = $this->alipay->buildRequestFormHTML($alipayParams) ;    
    //    var_dump($this->alipay);die;
    //    $response->getBody()->write($body);
    //    return $response;
    }
    public function orderInfo($request, $response, $args) {
        return "api orderInfo" . $args['id'];
    }
    public function reception($request, $response, $args) {
        $body = $request->getParsedBody();
        $this->logger->info(json_encode($body));
        
        $bill = new Bill;
        $bill->out_trade_no = $body['out_trade_no'];//order_id
        $bill->trade_no = $body['trade_no'];
        $bill->trade_status = $body['trade_status'];
        $bill->buyer_email = $body['buyer_eamil'] ;
        $bill->price = $body['price'] ;
        $bill->subject = $body['subject'] ;
        $bill->gmt_create = $body['gmt_create'];
        $bill->full_info = json_decode($body) ;

        $bill->save();
        
        $result = Order::where('order_id', '=', $body['out_trade_no'])->first();
        
        if(empty($result)){
           return "i-success";
        }

        if($body['trade_status'] == 'TRADE_SUCCESS'){
            $result->status = 'success';
            $result->save();
        }
           
        return "success";
    }
}
