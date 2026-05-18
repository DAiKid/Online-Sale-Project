<?php

namespace App\Http\Controllers\admin;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\PaymentHistory;
use App\Http\Controllers\Controller;

class OrderBoardController extends Controller
{
    //direct to OrderBoard Page
    public function orderListPage($action = 'default'){

        $orders = Order::select('orders.order_code','orders.status','orders.created_at','orders.count','users.name','users.nickname','products.stock')
                        ->groupBy('order_code')
                        ->orderBy('created_at','desc')
                        ->leftJoin('users','orders.user_id','users.id')
                        ->leftJoin('products','products.id','orders.product_id')
                        ->when($action === 'Pending',function($query){
                            $query->where('status','=','0');
                        })
                        ->when($action === 'Reject',function($query){
                            $query->where('status','=','2');
                        })
                        ->when(request('searchKey'),function($query){
                            $query->where('order_code','like','%'.request('searchKey').'%');
                        })
                        ->get();



        // dd($order->toArray());
        return view('admin/orderList',compact('orders'));
    }

    // direct to orderDetail page
    public function orderDetailPage($orderCode){

        $payment = PaymentHistory::select('name','phone','address','orderCode','totalAmt','created_at','paymentType','payslip_image')
                            ->where('orderCode',$orderCode)
                            ->get();

        $orders = Order::select('orders.count','orders.status','products.name','products.id','products.photo','products.price','products.stock','users.phone','users.name as user_name','users.nickname')
                        ->leftJoin('products','products.id','orders.product_id')
                        ->leftJoin('users','users.id','orders.user_id')
                        ->where('order_code',$orderCode)
                        ->get();

        foreach ($orders as $item) {
            $status = true;
            if ( $item->count <= $item->stock ) {
                $status = true;
            } else {
                $status = false;
                break;
            }
        }
        // dd($payment->toArray());
        // dd($status);
        return view('admin/orderDetail',compact('payment','orders','status'));
    }

    // order statusChange
    public function statusChange(Request $request){
        // logger($request);
        Order::where('order_code',$request['orderCode'])->update([
            'status' => $request['status']
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'order status changed'
        ],200);
    }

    // orderReject
    public function orderReject(Request $request){
        // logger($request);
        Order::where('order_code',$request['orderCode'])->update([
            'status' => 2
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'order rejected'
        ],200);
    }

    // orderAccept
    public function orderAccept (Request $request){
        logger($request);
        Order::where('order_code',$request['orderCode'])->update([
            'status' => 1
        ]);

        foreach ($request->all() as $item) {
            Product::where('id',$item['productId'])
                    ->decrement('stock',$item['orderCount']);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'order accepted'
        ],200);
    }
}
