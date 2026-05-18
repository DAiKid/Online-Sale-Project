<?php

namespace App\Http\Controllers\user;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomePageController extends Controller
{
    //user home page
    public function userPage (){

        $products = Product::select('products.id','products.name','products.price','products.photo','products.category_id','products.description','products.stock','products.created_at','categories.name as category_name')
                            ->leftJoin('categories','products.category_id','categories.id')
                            ->when(request('CategoryId'),function($query){
                               $query->where('products.category_id',request('CategoryId'));
                            })
                            ->when(request('minPrice') === null && request('maxPrice') !== null,function($query){
                                $query->where('products.price', '<=' , request('maxPrice'));
                            })
                            ->when(request('minPrice') !== null && request('maxPrice') === null,function($query){
                                $query->where('products.price','>=',request('minPrice'));
                            })
                            ->when(request('minPrice') !== null && request('maxPrice') !== null,function($query){
                                $query->whereBetween('products.price',[request('minPrice'),request('maxPrice')]);
                            } )
                            ->when(request('searchKey'),function($query){
                                $query->where('products.name','like','%'.request('searchKey').'%');
                            })
                            ->when(request('sortingType'),function($query){
                                $sortingRule = explode('-', request('sortingType'));
                                // dd($sortingRule);
                                $query -> orderBy('products.'.$sortingRule[0],$sortingRule[1]);
                            })
                            ->get();


        $categories = Category::select('id','name')->get();

        return view('user/category/home',compact('products','categories'));
    }
}
