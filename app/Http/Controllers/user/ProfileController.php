<?php

namespace App\Http\Controllers\user;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;


class ProfileController extends Controller
{
    //direct to ProfileEditPage
    public function editPage(){
        return view('user/profile/profileEditPage');
    }

    // profile edit
    public function profileEdit(Request $request){
        // dd($request->all());
        $this -> checkProfileEditValidation($request);
        $data = $this -> editProfileData($request);

        if ($request->hasFile('image')) {
            if (Auth::user()->profile !== Null){
               if(file_exists(public_path('profilePhoto/'.Auth::user()->profile))){
                unlink(public_path('profilePhoto/'.Auth::user()->profile));
               }
            }

            $photoName = uniqid() . $request->file('image') -> getClientOriginalName();
            $request->file('image') -> move(public_path().'/profilePhoto/' ,$photoName);
            $data['profile'] = $photoName;
        } else{
            $data['profile'] = Auth::user()->profile;
        }

        // dd($data);
        User::where('id',Auth::user()->id)->update($data);

        Alert::success('Success Title', 'Updated Successfully');
        return back();
    }

    // change password page
    public function changePasswordPage(){
        return view('user/profile/passwordChangePage');
    }

    // change password
    public function changePassword(Request $request){

        if (Hash::check($request->oldPassword,Auth::user()->password)) {
            $this -> checkPasswordChangeValidation($request);
            User::where('id',Auth::user()->id)
                ->update(['password' => Hash::make($request -> newPassword)]);
            
            Alert::success('Success Title', 'Successfully Changed');
            return back();
            // dd('true');
        } else {
            Alert::error("Failed", "Old password doesn't match");
            return back();
        }
    }

    // get edit data
    private function editProfileData($request){
        return [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
        ];
    }

    // check edit validation
    private function checkProfileEditValidation($request){
        $request -> validate([
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'address' => 'required',
        ]);
    }

    // change password validation
    private function checkPasswordChangeValidation($request){
        $request -> validate([
            'oldPassword' => 'required|min:6|max:20',
            'newPassword' => 'required|min:6|max:20',
            'confirmPassword' => 'required|same:newPassword',
        ]);
    }

}
