<?php

namespace App\Http\Controllers\superadmin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminListController extends Controller
{
    // direct to page
    public function adminListPage(){
        $admins = User::select('id','name','nickname','email','phone','address','role','profile','provider','created_at')
                        ->whereIn('role',['superadmin','admin'])
                        ->when(request('searchKey'),function($query){
                            $query -> whereAny(['name','nickname','role','email','address','phone','provider'], 'like', '%'.request('searchKey').'%');
                        })
                        ->paginate(4);
        return view('superadmin/adminList',compact('admins'));
    }

    // admin Delete
    public function adminListDelete($id){
        User::where('id',$id)->delete();
        return back();
    }
}
