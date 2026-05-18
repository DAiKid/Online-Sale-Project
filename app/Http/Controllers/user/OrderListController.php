<?php

namespace App\Http\Controllers\user;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class OrderListController extends Controller
{
    //direct to orderList Page
    public function page(){
        $orders = Order::select('id','status','order_code','created_at')
                        ->where('user_id',Auth::user()->id)
                        ->groupBy('order_code')
                        ->orderBy('created_at','desc')
                        ->get();
        return view('user/orderList',compact('orders'));
    }
}
