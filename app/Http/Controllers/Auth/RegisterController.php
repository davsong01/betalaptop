<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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
    protected $redirectTo = RouteServiceProvider::HOME;

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
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255',
            'unique:users', 'not_regex:/(' . preg_quote(env('APP_DOMAIN')) . ')$/i'],
            'username' => ['required', 'string', 'max:255', 'unique:users', 'not_regex:/(admin)/i'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'username' => $data['username'],
            'password' => Hash::make($data['password']),
            'children' => [null, null], // empty children
        ]);
    }

    protected function register(Request $request)
    {
        $this->validator($request->all())->validate();
        event(new Registered($user = $this->create($request->all())));

        if (Auth::attempt($request->only(['email', 'password']))) {
            $request->session()->regenerate();

            $emailContent = "Dear " . $user->name . ",<br><br>"
            . "Welcome to " . env('APP_NAME') . "<br><br>"
                . "Your account registration was successful<br><br>
                Your login details are: <br> Email: " . $user->email . "<br>Password: your specified password <br><br><br>"
                . "Kindly <a href ='" . env('APP_URL') . "/wallet" . "'>login to your back office to start referring and earning</a> <br><br> Warm Regards <br><br>";
            $this->sendEmail($user->name, $user->email, 'Welcome to ' . env('APP_NAME'), $emailContent);
            return redirect()->intended('account');
        }

        return $this->registered($request, $user)
            ?: redirect($this->redirectPath());
    }
}
