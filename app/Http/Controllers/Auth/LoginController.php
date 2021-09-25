<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{

    use AuthenticatesUsers;
    protected $redirectTo = "/";
    public function __construct()
    {
        if (request()->isMethod('post')) {
            $user = User::where('email',request('email'))->first();
            if($user) {
                $user->remember_token = md5(uniqid());
                $user->save();
            }
        }
        $this->middleware('guest')->except('logout');
    }
}
