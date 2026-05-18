<?php

namespace App\Http\Controllers\admin;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;

class CategoryController extends Controller
{
    //direct category list
    public function list (){
        $categories = Category::orderBy('created_at','desc')
                                ->paginate(3);

        return view('admin/category/list',compact('categories'));
    }

    // delete category list
    public function delete($id){
        // dd($id);
        Category::where('id',$id)->delete();
        return back();
    }

    //create category data
    public function create (Request $request){
        $this -> checkValidation($request);
        // dd($request->toArray());
        Category::create([
            'name' => $request->categoryName,
        ]);
        Alert::success('Success Title', 'Created Successfully');
        return back();
    }

    // category edit
    public function edit($id){
        $category = Category::where('id',$id)->first();
        return view('admin/category/update',compact('category'));
    }

    // category update
    public function update($id,Request $request){
        $request['id'] = $id;
        $this -> checkValidation($request);

        Category::where('id',$id)->update([
            'name' => $request->categoryName
        ]);

        return to_route('category#list');
    }

    //check validation
    private function checkValidation(Request $request){
        $request->validate([
            'categoryName' => 'required|min:2|max:30|unique:categories,name',
        ]);
    }


}
