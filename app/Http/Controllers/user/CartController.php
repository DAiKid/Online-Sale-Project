<?php

namespace App\Http\Controllers\user;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;


class CartController extends Controller
{
    //direct to cartPage
    public function cartPage(){
        $carts = Cart::where('user_id',Auth::user()->id)
                    ->leftJoin('products','carts.product_id','products.id')
                    ->select('carts.id','qty','products.name','products.price','products.photo','products.stock','products.id as product_id')
                    ->get();
        // dd($carts->toArray());

        $total = 0;
        foreach ($carts as $item) {
            $total += $item->qty * $item->price;
        }
        // dd($total);

        return view('user/cart',compact('carts','total'));
    }

    // delete cart
    public function deleteCart(Request $request){
        // logger($request['cartId']);
        $cartId = $request['cartId'];
        // logger($cartId);
        Cart::where('id',$cartId)->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'deleted successfully'
        ],200);
    }

    // temporary oderlist
    public function tempOrder(Request $request){

        $tempOrderList = [];
        foreach ($request->all() as $item) {
            logger($item);
            $tempOrderList = Arr::prepend($tempOrderList,[
                'user_id' => $item['user_id'],
                'product_id' => $item['product_id'],
                'count' => $item['count'],
                'status' => $item['status'],
                'order_code' => $item['order_code'],
                'total_cost' => $item['total_cost']
            ]);
        }

        // logger($tempOrderList);
        Session::put('tempOrder',$tempOrderList);

        return response()->json([
            'status' => 'success'
        ]);
    }


    // add to cart
    public function addToCart(Request $request){

        $productStock = Product::where('id',$request->productId)
                                ->value('stock');

        $orderStock = intval($request->count);
        // dd($productStock->toArray());
        // dd(gettype($orderStock));

        if ( $orderStock <= $productStock) {
            // dd('pass');
            Cart::create([
                'user_id' => Auth::user()->id,
                'product_id' => $request->productId,
                'qty' => $request->count
            ]);
            Alert::success("Success","Added to your shopping cart");
        } else {
            // dd("error");
            Alert::error("Failed", "Sry we don't have enough available stocks");
            return back();
        }




        return back();
    }
}
