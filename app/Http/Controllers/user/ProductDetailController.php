<?php

namespace App\Http\Controllers\user;

use App\Models\Rating;
use App\Models\Comment;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProductDetailController extends Controller
{
    //direct to detail page
    public function detailPage($id){
        $product = Product::select('categories.name as category_name','products.name','products.id','products.price','products.photo','products.description','products.category_id','products.stock')
                        ->leftJoin('categories','products.category_id','categories.id')
                        ->where('products.id',$id)
                        ->first();
        // dd($product->toArray());

        $comments = Comment::select('comments.id','comments.message','comments.product_id','comments.user_id','comments.created_at','users.name','users.nickname','users.profile')
                            ->leftJoin('users','comments.user_id','users.id')
                            ->where('comments.product_id',$id)
                            ->get();
        // dd($comments->toArray());

        $stars = number_format(Rating::where('product_id',$id)->avg('count'));
        // dd($stars);

        $userStars = number_format(Rating::where('product_id',$id)->where('user_id',Auth::user()->id)->value('count'));
        // dd($userStars);
        return view('user/category/productDetail',compact('product','comments','stars','userStars'));
    }
}
