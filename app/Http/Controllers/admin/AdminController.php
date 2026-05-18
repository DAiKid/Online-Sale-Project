<?php

namespace App\Http\Controllers\admin;

use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    //direct admin dashboard
    public function dashboard(){

        $orders = Order::select('orders.status','payment_histories.totalAmt')
                ->leftJoin('payment_histories','payment_histories.orderCode','orders.order_code')
                ->groupBy('order_code')
                ->orderBy('orders.created_at','desc')
                ->get();
        $users = User::select('id')
                    ->where('role','=','user')
                    ->get();

            $totalSellAmount = 0;
            $pending = 0;


        foreach ($orders as $item) {

            $price = $item->totalAmt;

            if ($item->status === 0) {
                $pending ++;
            }

             if ($item->status === 1) {
                $totalSellAmount += $price;
            }

        }

        // dd($price);

        // dd($orderRequestAmount,$totalSellAmount);

        return view('admin/dashboard/main',compact('orders','pending','totalSellAmount','users'));
    }



}
