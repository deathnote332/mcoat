<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

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

    use AuthenticatesUsers{
        logout as performLogout;
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    public function logout(Request $request)
    {
        User::where('id',Auth::user()->id)->update(['active'=>0]);
        $this->performLogout($request);
        return redirect()->route('login');
    }
    public function authenticate(Request $request)
    {
        $credentials = array(
            'email' => $request->email,
            'password' => $request->password,
            'status'=>1

        );

        if (Auth::attempt($credentials))
        {
            User::where('id',Auth::user()->id)->update(['active'=>1]);
            return redirect()->intended('dashboard');
        }
        else {
            return Redirect::to('login')
                ->withMessage(['Invalid username or password','Account need to be approve first by the admin']);
        }
    }


}
