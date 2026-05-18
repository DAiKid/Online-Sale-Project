<?php

namespace App\Http\Controllers\user;

use App\Models\Contact;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class ContactController extends Controller
{
    //direct to page
    public function contactPage(){
        return view('user/contact');
    }

    // contact create
    public function contactCreate(Request $request){
        // dd($request->toArray());
        $this->checkValidation($request);
        Contact::create([
            'title' => $request->title,
            'message' => $request->message,
            'user_id' => Auth::user()->id
        ]);

        Alert::success('Success Title', 'Success Message');
        return back();

    }

    // check validation
    private function checkValidation($request){
        return $request->validate([
            'title' => 'required|min:2|max:20',
            'message' => 'required|min:2|max:200'
        ]);
    }
}
