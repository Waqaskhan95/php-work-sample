<?php

namespace App\Repository\Eloquent;

use App\Models\User;
use App\Models\Order;
use App\Models\GlobalNotification;
use App\Models\OrderDetail;
use App\Models\OrderShipping;
use App\Models\PaymentLog;
use App\Models\Product;
use App\Models\OrderPayment;
use App\Repository\OrderRepositoryInterface;
use Illuminate\Support\Collection;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Resources\OrderResource;
use App\Http\Resources\OrderDetailResource;

class OrderRepository extends BaseRepository implements OrderRepositoryInterface
{

    public function __construct(Order $model)
    {
       parent::__construct($model);
    }

    public static function generateOrderNumber(){
        return time() . rand(1000, 9999);
    }

    public function addOrder(Request $request) {
        $totalPrice = $this->getPriceAfterDiscount($request->totalPrice,$request->discount) ?? 0;
        // $totalPrice = $this->getPriceAfterDiscount(array_sum($request->price),$request->discount) ?? 0;
        $order = $this->model->create([
            'user_id'       => auth()->user()->id,
            'order_number' => static::generateOrderNumber(),
            'total_amount' => $totalPrice,
            'discount'     => $request->discount ?? 0,
            'status'       => 1   
        ]);

        if($order){
            for($i = 0; $i < count($request->products); $i++ ){
                OrderDetail::create([
                    'order_id'      => $order->id,
                    'user_id'       => auth()->user()->id,
                    'product_id'    => $request->products[$i]['product_id'],
                    'product_variation_id'    => $request->products[$i]['variation_id'],
                    'quantity'    => $request->products[$i]['count'],
                    'price'    => $request->products[$i]['price'],
                ]);

                $this->sendNotificationOrderMade($request->products[$i]['product_id']);
            }
            OrderShipping::create([
                'order_id'  => $order->id,
                'address'   => $request->address,
                'country_id'=> $request->country_id,
                'state_id'  => $request->state_id,
                'city_id'   => $request->city_id,
                'zip_code'  => $request->zip_code
            ]);
            auth()->user()->createOrGetStripeCustomer();
            return $this->orderPayment($request,$order,$totalPrice);    
            
            
        }
    }

    public function orderPayment(Request $request,$order,$amount,$subscription = null){
        $paymentMethod = createPaymentMethod($request);
        if($paymentMethod['id']){
            auth()->user()->updateDefaultPaymentMethod($paymentMethod['id']);
            $charge = auth()->user()->charge($amount * 100, $paymentMethod['id']);
            $paymentLog = PaymentLog::create([
                'user_id'           => auth()->user()->id,
                'subscription_id'   => $subscription->id ?? null,
                'gateway'           => 'Stripe',
                'gateway_reference' => $charge->id ?? null,
                'currency'          => '$',
                'amount'            => $amount
            ]);

            OrderPayment::create([
                'order_id'  => $order->id,
                'payment_id'=> $paymentLog->id,
                'user_id'   => auth()->user()->id,
                'status'    => 1,    
            ]);

            return ['message' => 'Order Placed Successfully','data' => $order ,'status' => 200];
        }
        return ['message' => 'Payment Failed.','status' => 400]; 
    }

    public function getPriceAfterDiscount($price,$discount){
        if($discount) {
           $finalAmount = $price - $discount;
           return $finalAmount;
        }else{
            return $price;
        }
    }

    public function getMyOrders(Request $request) {
        $orders = $this->model->where('user_id',auth()->user()->id);

        $orders = $orders->orderByDesc('id')->paginate(env('APP_PAGINATE',10));

        $orderCollection = OrderResource::collection($orders)->response()->getData(true);

        return [
            'data'  => paginate($orderCollection),
            'status'    => 200 
        ];

    }

    public function orderDetail($id) {
        $order = $this->model->with('details')->find($id);
        $orderCollection = new OrderDetailResource($order);

        return [
            'data'  => $orderCollection,
            'status'    => 200 
        ];

    }

    public function sendNotificationOrderMade($productId) {
       $getProduct = Product::find($productId);
       
        if ($getProduct) {
            
            $notification = GlobalNotification::create([
                'user_id' => $getProduct->user_id,
                'message' => 'New Order Has Been Made of your Product ID : ' . $productId, 
            ]);

            return $notification;
        }
        return true;
    }

    
    
}