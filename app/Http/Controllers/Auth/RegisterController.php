<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Auth;
use SMS;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function sendSmsValidator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required',
            'telephone' => 'required|phone:UA',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required|min:6',
        ]);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        Validator::extend('sms_confirmed', function($name, $value){
            return $this->checkSessionCode(SMS::formatPhone(request('telephone')), $value);
        });
        return Validator::make($data, [
            'name' => 'required',
            'code' => 'required|sms_confirmed',
            'telephone' => 'required|phone:UA',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $telephone = SMS::formatPhone($data['telephone']);

        if($user = User::whereTelephone($telephone)->first()) {
            $user->password = bcrypt($data['password']);
            $user->save();
            return $user;
        }

        return User::create([
            'name' => $data['name'],
            'telephone' => $telephone,
            'password' => bcrypt($data['password']),
            'is_confirmed' => 1,
        ]);
    }

    /**
     * 
     */
    public function getRegister()
    {
        return view('register');
    }

    public function checkValidatorErrors($validator)
    {
        if($errors = $validator->errors()) {
            return ajaxResponse($errors, 422);
        }

        return true;
    }


    public function postSmsConfirmation(Request $request)
    {
        $this->sendSmsValidator($request->all())->validate();

        if ($this->confirmViaSms(SMS::formatPhone($request->get('telephone')))) {


            return ajaxResponse([
                'sent' => true,
                'status' => 'success',
            ]);

        }  

        return ajaxResponse([
            'sent' => false,
            'status' => 'error',
        ]);
    }

    /**
     * 
     */
    public function postRegister(Request $request)
    {
        $this->validator($request->all())->validate();

        $user = $this->create(array_replace($request->all(),[
            'telephone' => SMS::formatPhone($request->get('telephone'))
        ]));

        if ($user && Auth::loginUsingId($user->id)) {
            $this->clearSession(SMS::formatPhone($request->get('telephone')));

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

    public function confirmViaSms($phoneNumber) 
    {
        $code = rand(1000,9999);
        $this->setSessionCode($phoneNumber, $code);
        return $this->sendConfirmSms($phoneNumber, $code);
    }



    /**
     * 
     */
    public function sendConfirmSms($phoneNumber, $code)
    {
        try {

            $smsSender = SMS::setData('Globalize', $phoneNumber, 'Код: ' . $code);
            $smsSender->send();
            $response = $smsSender->getResponse();
            return array_get($response, 'success');

        } catch (\Exception $e) {

        }

        return false;
    }

    /**
     * 
     */
    public function setSessionCode($phoneNumber, $code)
    {
        session(
            [
                'confirmViaSms.' . $phoneNumber => [

                    'timestamp' => time(),
                    'code' => $code,

                ]
            ]
        );
    }

    /**
     * 
     */
    public function checkSessionCode($phoneNumber, $code)
    {
        $sessionData =  session()->get('confirmViaSms.'. $phoneNumber);

        if (time() - array_get($sessionData, 'timestamp', 0) > 1800) {
            return false;
        }

        if (array_get($sessionData, 'code', false) != $code) {
            return false;
        }

        return true;
    }

    /**
     * 
     */
    public function clearSession($phoneNumber)
    {
        session(['confirmViaSms' => null]);
    }
}
