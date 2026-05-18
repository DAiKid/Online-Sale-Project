<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocailLoginController extends Controller
{
    //redirect login
    public function redirect($provider){
        return Socialite::driver($provider)->redirect();
    }
    //rollback
    public function rollback($provider){
        $userData = Socialite::driver($provider)->user();
        // dd($userData);

        $user = User::updateOrCreate([
            'provider_id' => $userData->id,
        ], [
            'name' => $userData->name,
            'nickname' => $userData->nickname,
            'profile' => $userData->avatar,
            'email' => $userData->email,
            'provider'=> $provider,
            'provider_token' => $userData->token,
            'provider_id' => $userData->id,
            'role' => 'user'
        ]);

        Auth::login($user);

        return to_route('user#page');
    }
}
