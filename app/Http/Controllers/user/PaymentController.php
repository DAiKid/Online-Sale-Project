<?php

namespace App\Http\Controllers\user;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Models\PaymentHistory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;

class PaymentController extends Controller
{
    //direct to page
    public function page(){

        $payment = Payment::get();
        $orderTemp = Session::get('tempOrder');
        // dd($orderTemp);
        return view('user/payment',compact('payment','orderTemp'));
    }

    // create payment
    public function order(Request $request){
        // dd($request->toArray());
        $request->validate([
            'name' => 'required|min:3|max:20',
           'phone' => 'required|max:20',
           'address' => 'required|min:3|max:100',
           'paymentType' => 'required',
           'payslipImage' => 'required',
        ]);

        $paymentData=[
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'paymentType' => $request->paymentType,
            'orderCode' => $request->orderCode,
            'totalAmt' => $request->totalAmount,
        ];
        if ($request->hasFile("payslipImage")) {
            $photoFile = uniqid() . $request->file("payslipImage")->getClientOriginalName();
            $request->file("payslipImage")->move( public_path(). "/paymentImage", $photoFile );
            $paymentData['payslip_image'] = $photoFile;
        }
        // dd($paymentData);
        PaymentHistory::create($paymentData);

        $orderList = Session::get('tempOrder');
        foreach ($orderList as $order) {
           Order::create([
                'user_id' => $order['user_id'],
                'product_id' => $order['product_id'],
                'count' => $order['count'],
                'status' => $order['status'],
                'order_code' => $order['order_code'],
           ]);
        // dd($order);
           $cart=Cart::where('user_id',$order['user_id'])
                ->where('product_id',$order['product_id'])
                ->delete();
            // dd($cart);
        }
        Alert::success("Success","Thanks for shopping");
        return back();
    }
}


