<?php

namespace App\Http\Controllers\user;

use App\Models\Rating;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class RatingController extends Controller
{
    //create rating
    public function rating(Request $request){
        // dd($request->all());
        Rating::updateOrCreate([
            'user_id' => Auth::user()->id,
            'product_id' => $request->productId,
        ],[
            'user_id' => Auth::user()->id,
            'product_id' => $request->productId,
            'count' => $request->productRating
        ]);
        Alert::success('Success Title', 'Thanks for Rating.');
        return back();
    }

    
}
