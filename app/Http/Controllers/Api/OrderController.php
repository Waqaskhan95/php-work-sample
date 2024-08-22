<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repository\OrderRepositoryInterface;

class OrderController extends Controller
{
    protected $orderInterface;
    function __construct(OrderRepositoryInterface $orderInterface) {
        $this->orderInterface = $orderInterface;
    }

    public function addOrder(Request $request){
        try {
          // return $this->orderInterface->addOrder($request); 
          $order = $this->orderInterface->addOrder($request); 
          return response()->json($order);
          // return response()->json([ 'message' => 'Order Added Successfully','data' => $order , 'status' => 200 ]);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage() ,'status' => 500]);
        } 
        
    }

    public function getMyOrders(Request $request) {
        try {
          $orders = $this->orderInterface->getMyOrders($request); 
          return response()->json($orders);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage() ,'status' => 500]);
        } 
    }

    public function orderDetail($id) {
        try {
          $details = $this->orderInterface->orderDetail($id); 
          return response()->json($details);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage() ,'status' => 500]);
        }
    }
}
