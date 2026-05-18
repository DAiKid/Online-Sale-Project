<?php

namespace App\Http\Controllers\admin;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;

class Productcontroller extends Controller
{
    // direct productCreate page
    public function page(){
        $categories = Category::select('id','name')->get();
        return view('admin/product/productCreate',compact('categories'));
    }

    // create product data
    public function create(Request $request){
        $this -> checkValidation($request,'create');
        // dd($request->all());
        $data = $this->getData($request);
        if ($request->hasFile('image')) {
            $photoName = uniqid() . $request->image -> getClientOriginalName();
            $request->image -> move(public_path() . "/productPhoto/" , $photoName);
            $data['photo'] = $photoName;
        }
        // dd($data);
        Product::create($data);
        Alert::success('Success Title', 'Created Successfully');
        return back();
    }

    //edit product
    public function edit($id){
        $product = Product::where('id',$id)->first();
        $categories = Category::get();
        // dd($product);
        return view('admin/product/productEdit',compact('product','categories'));
    }

    // delete product
    public function delete($id){
        Product::where('id',$id)->delete();
        return back();
    }

    // update product
    public function update(Request $request){
        $this -> checkValidation($request,'update');
        // dd($request -> all());
        $data = $this->getData($request);

        if($request->hasFile('image')){
            $oldPhotoName = $request -> oldPhoto;

            if (file_exists(public_path('productPhoto/'.$oldPhotoName))) {
                unlink(public_path('productPhoto/'.$oldPhotoName));
            }

            $photoName = uniqid() . $request->image -> getClientOriginalName();
            $request->image -> move(public_path() . "/productPhoto/" , $photoName);
            $data['photo'] = $photoName;
        } else {
            $data['photo'] = $request -> oldPhoto;
        }
        Product::where('id',$request->productId)->update($data);
        Alert::success('Success Title', 'Updated Successfully');
        return to_route('product#list');
    }

    // show product data
    public function list($action = "default"){
        // dd($action);
        $products = Product::select('products.id','products.name','products.price','products.photo','products.description','products.category_id','products.stock','categories.name as category_name')
                            ->leftJoin('categories','products.category_id','categories.id')
                            ->when(request('searchKey'),function($query){
                                $query->whereAny(['products.name','categories.name'], 'like' , '%'.request('searchKey').'%');
                            })
                            ->when($action === 'lowAmt',function($query){
                                $query->where('products.stock', '<=', '3' );
                            })
                            ->get();

        return view('admin/product/productList',compact('products'));
    }

    // detail product
    public function detail($id){
        // dd($id);
        $products = Product::select('products.id','products.name','products.price','products.photo','products.description','products.category_id','products.stock','categories.name as category_name')
                            ->leftJoin('categories','products.category_id','categories.id')
                            ->where('products.id',$id)
                            ->first();
        // dd($products);
        return view('admin/product/productDetail',compact('products'));
    }

    // get data
    private function getData($request){
        return [
        'name' => $request->name,
       'category_id' => $request->categoryId,
       'price' => $request->price,
       'stock' => $request->stock,
       'description' => $request->description,
       ];
    }

    // check Validation
    private function checkValidation($request,$action){
        $rules = [
            'name' => 'required|min:2|max:50|unique:products,name', /* $request->id, */
            'categoryId' => 'required',
            'price' => 'required|max:9',
            'stock' => 'required|max:4',
            'description' => 'required|min:3|max:700',
        ];

        if ($action === 'create') {
            $rules['image'] = 'required';
        }

        $message = [

        ];
        $request -> validate($rules,$message);
    }

}
