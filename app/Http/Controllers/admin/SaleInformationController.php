<?php

namespace App\Http\Controllers\admin;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\PaymentHistory;
use App\Http\Controllers\Controller;

class SaleInformationController extends Controller
{
    //direct to saleInfo page
    public function saleInfoPage(){

        $order = Order::select('orders.order_code','orders.status','orders.created_at','orders.count','users.name','users.nickname','payment_histories.paymentType','payment_histories.totalAmt')
                        ->groupBy('order_code')
                        ->orderBy('created_at','desc')
                        ->where('orders.status','=','1')
                        ->leftJoin('users','orders.user_id','users.id')
                        ->leftJoin('payment_histories','payment_histories.orderCode','orders.order_code')
                        ->when(request('searchKey'),function($query){
                            $query->whereAny(['orders.order_code','users.name'],'like','%'.request('searchKey').'%');
                        })
                        ->get();
        return view('admin/saleInfo',compact('order'));

    }

    // direct to saleDetail Page
    public function saleDetailPage($orderCode){
        $payment = PaymentHistory::select('name','phone','address','orderCode','totalAmt','created_at','paymentType','payslip_image')
                            ->where('orderCode',$orderCode)
                            ->get();

        $orders = Order::select('orders.count','orders.status','products.name','products.id','products.photo','products.price','products.stock','users.phone','users.name as user_name','users.nickname')
                        ->leftJoin('products','products.id','orders.product_id')
                        ->leftJoin('users','users.id','orders.user_id')
                        ->where('order_code',$orderCode)
                        ->get();

        return view('admin/saleDetail',compact('payment','orders'));
    }
}
