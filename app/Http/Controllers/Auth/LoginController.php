<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\User;
use Hash;
use Auth;
use SMS;

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
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
       $this->middleware('guest', ['except' => 'getLogout']);
    }

    /**
     * 
     */
    public function getLogin()
    {
        return view('auth.login');
    }

    /**
     * 
     */
    public function postLogin(Request $request)
    {
        $this->validateLogin($request);

        $telephone = SMS::formatPhone($request->get('telephone'));

        $user = User::whereTelephone($telephone)->first();

        if ($user && Hash::check($request->get('password'), $user->password)) {
            Auth::loginUsingId($user->id); 
            return ajaxResponse([
                'authorized' => true,
                'status' => 'success',
                'redirect_url' => action('TimelineController@getTimeline'),
            ]);           
        }

        return ajaxResponse([
            'authorized' => false,
            'status' => 'error',
        ]);   
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            'password' => 'required', 'telephone' => 'required|phone:UA',
        ]);
    }

    /**
     * 
     */
    public function getLogout()
    {

        Auth::logout();

        return redirect(action('Auth\LoginController@getLogin'));
    }
}
