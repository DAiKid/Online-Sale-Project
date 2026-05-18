<?php

namespace App\Http\Controllers\user;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class CommentController extends Controller
{
    //create comment
    public function createComment (Request $request){
        // dd($request -> toArray());
        Comment::create([
            'message' => $request->comment,
            'product_id' => $request->productId,
            'user_id' => Auth::user()->id,
        ]);
        Alert::success('Success Title', 'Updated Successfully');
        return back();
    }

    // comment delete
    public function delete ($id){
        // dd($id);
        Comment::where('id',$id)->delete();
        return back();
    }
}
