<?php

namespace App\Http\Controllers\superadmin;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;

class AddNewAdminController extends Controller
{
    //direct to page
    public function page(){
        return view('superadmin/addNewAdminPage');
    }

    // add new admin
    public function addAdmin(Request $request){
        $this -> checkValidation($request);
        $data = $this -> newAdminData($request);

        User::create($data);
        Alert::success('Success Title', 'Created Successfully');
        return back();
    }

    // validation check
    private function checkValidation($request){
        $request -> validate([
            'name' => 'required|min:3|max:20',
            'email' => 'required|unique:users,email',
            'password' => 'required|min:6|max:20',
            'confirmPassword' => 'required|same:password',
        ]);
    }

    // get newAdmin Data
    private function newAdminData($request){
        return[
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'role' => 'admin',
            'created_at' => Carbon::now(),
        ];
    }
}
