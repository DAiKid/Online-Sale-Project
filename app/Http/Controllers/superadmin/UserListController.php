<?php

namespace App\Http\Controllers\superadmin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserListController extends Controller
{
    // direct to page
    public function userListPage(){
        $users = User::select('id','name','nickname','email','phone','address','role','profile','provider','created_at')
                        ->whereIn('role',['user'])
                        ->when(request('searchKey'),function($query){
                            $query -> whereAny(['name','nickname','email','address','phone','provider'], 'like', '%'.request('searchKey').'%');
                        })
                        ->paginate(4);
        return view('superadmin/userList',compact('users'));
    }

    // admin Delete
    public function userListDelete($id){
        User::where('id',$id)->delete();
        return back();
    }
}
