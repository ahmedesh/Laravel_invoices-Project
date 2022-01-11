<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{

    use AuthenticatesUsers;


    protected $redirectTo = RouteServiceProvider::HOME;


    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function credentials(\Illuminate\Http\Request $request)
    {
        return ['email' => $request->email, 'password' => $request->password, 'status' => 'مفعل'];
        // اذا كان الايميل اللي دخلته هو نفس الايميل اللي فالداتابيز والباسورد اللي دخلته هو نفس اللي فالداتابيز والحاله لازم تكةن مفعله
        // فالحاله دي اسمح له بالدخول غير كدا لا

    }
}
