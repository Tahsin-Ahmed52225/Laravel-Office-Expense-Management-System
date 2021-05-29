<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    //protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    public function login(Request $request)
    {
        $email = $request->email;
        $password = $request->password;

        if ($request->isMethod('POST')) {

            if (Auth::attempt(['email' =>  $email, 'password' => $password])) {
                if (Auth::user()->stage == 0) {
                    Auth::logout();
                    return redirect()->back()->with(session()->flash('alert-warning', 'Your account has been lock!! '));
                } else {
                    if (Auth::user()->role == "admin") {
                        return redirect()->route("admin.dashboard");
                    } else if (Auth::user()->role == "user") {
                        return redirect()->route("user.dashboard");
                    } else {
                        return redirect()->back()->with(session()->flash('alert-warning', 'Something went wrong '));
                    }
                }
            } else {
                return redirect()->back()->with(session()->flash('alert-danger', 'Incorrect Credentials'));
            }
        }
        return view('auth.login');
    }
}
