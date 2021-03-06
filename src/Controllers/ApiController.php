<?php

namespace App\Controllers;

use App\Models\Order;
use App\Models\Bill;
use App\Services\Utils;

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
        
        $order = new Order;
        $order->order_id = $body['order_id'];
        $order->subject = $body['subject'];
        $order->user_id = $body['user_id'];
        $order->amount = $body['amount'];
        $order->from = $body['from'];
        $order->notifi = $body['notifi'];
        $order->return_url = $body['return_url'];
        $order->create_date = time();

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
        $response->getBody()->write($alipayBody);
        return $response;
    }
    public function orderInfo($request, $response, $args) {
        $id = $args['id'];
        $result = Order::where('order_id','=', $id)->first();
        if(empty($result)){
            $res = [
               "ret" => 0,
               "msg" => "not found order info"
            ];
            return $this->echoJson($response, $res);
       }
       return $this->echoJson($response, $result);
    }
    public function reception($request, $response, $args) {
        
        $body = $request->getParsedBody();
        $this->logger->info(json_encode($body));
        
        $verify = $this->alipay->verifyCallback();
        if (empty($body['sign']) || !$verify){
            return "error";
        }
        
        $bill = new Bill;
        $bill->out_trade_no = $body['out_trade_no'];//order_id
        $bill->trade_no = $body['trade_no'];
        $bill->trade_status = $body['trade_status'];
        $bill->buyer_email = $body['buyer_email'] ;
        $bill->price = $body['price'] ;
        $bill->subject = $body['subject'] ;
        $bill->gmt_create = $body['gmt_create'];
        $bill->full_info = json_decode($body) ;

        $bill->save();
        
        $result = Order::where('order_id', '=', $body['out_trade_no'])->first();
        
        if(empty($result)){
           return "success";
        }

        if($body['trade_status'] == 'TRADE_SUCCESS'){
            $result->status = 'success';
            $result->save();
          
        }

        if (!empty($result->notifi)) {
            Utils::curlPost($result->notifi, $body);
        }
           
        return "success";
    }

    public function returnUrl ($request, $response, $args)
    { 
         $params = $request->getQueryParams();
         $verify = $this->alipay->verifyCallback() ;
         if (!isset($params['sign']) || !$verify || !isset($params['out_trade_no'])) {
              return "error";
         }     
         $order = Order::where('order_id', '=', $params['out_trade_no'])->first();
         if (empty($order)){
             return "error";
         }
         if (empty($order->return_url)){
	  
             return "支付成功";
         }
         return $this->jsRedirect($response, 'get', $order->return_url, $params); 
    }
}
