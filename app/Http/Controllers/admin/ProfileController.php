<?php

namespace App\Http\Controllers\admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class ProfileController extends Controller
{
    // direct profile edit page
    public function editPage(){
        return view('admin/profile/profileEdit');
    }

    // profile update

    public function editProfile(Request $request){
        $this -> profileValidation($request);
        $data = $this -> getData($request);

        if ($request->hasFile('image')) {
            if (Auth::user()->profile != null) {

                if (file_exists(public_path('profilePhoto/'.Auth::user()->profile))) {
                    unlink(public_path('profilePhoto/'.Auth::user()->profile));
                }
            }

            $photoName = uniqid() . $request->image -> getClientOriginalName();
            $request->image -> move(public_path() . "/profilePhoto/" , $photoName);
            $data['profile'] = $photoName;

        } else{
            $data['profile'] = Auth::user()->profile;

        }

        // dd($data);

        User::where('id',Auth::user()->id)
            ->update($data);

        Alert::success('Success Title', 'Updated Successfully');
        return back();
    }

    // get data for proile edit
    private function getData($request){
        return [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
        ];
    }


    // direct ChangePassword Page
    public function page(){
        return view('admin/profile/changePassword');
    }

    // update password
    public function update(Request $request){

        if (Hash::check($request->oldPassword,Auth::user()->password)) {
            // dd("correct");
            $this -> passwordValidation($request);
            User::where('id',Auth::user()->id)
                ->update([
                    'password' => Hash::make($request->newPassword)
                ]);

            Alert::success('Success Title', 'Password Updated Successfully');
            return back();
        } else {
            Alert::error("Failed", "Old password doesn't match");
            return back();
        }
    }

    // password check validation
    private function passwordValidation($request){
        $request -> validate([
            'oldPassword' => 'required|min:6',
            'newPassword' => 'required|min:6|max:20',
            'confirmPassword' => 'required|min:6|max:20|same:newPassword',
        ]);
    }

    // editProfile validation
    private function profileValidation($request){
        $request -> validate([
            'name' => 'required|min:3|max:50',
            'email' => 'required|min:5|max:50',
            'phone' => 'required|max:20',
            'address' => 'required|min:5|max:50'
        ]);
    }
}
