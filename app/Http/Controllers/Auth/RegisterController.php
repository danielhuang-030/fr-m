<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\UserRegister;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
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
    protected $redirectTo = '/login';

    /**
     * 核心注册方法
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        return $this->registered($request, $user)
            ?: redirect($this->redirectPath())->with('status', 'Registration success');
    }

    /**
     * registered event (send email)
     * @param Request $request
     * @param $user
     */
    protected function registered(Request $request, $user)
    {
        Mail::to($user->email)->send(new UserRegister($user));
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'captcha' => 'required|captcha',
        ], [
//            'name.required' => 'Username can not be empty',
//            'name.max' => 'Username can not over 255 characters',
//            'name.unique' => 'Username has been used',
//            'email.unique' => 'Email has been used',
//            'email.required' => 'Email can not be empty',
//            'email.email' => 'Email format is incorrect',
//            'password.min' => 'Password at least 6 characters',
//            'password.required' => 'Password can not be empty',
//            'password.confirmed' => 'Inconsistent Password',
            'captcha.required' => 'Verification Code can not be empty',
            'captcha.captcha' => 'Verification Code is incorrect',
        ]);
    }

    protected function create(array $data)
    {
        // $faker = Factory::create();

        // email_active,
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'active_token' => str_random(60),
            // 'avatar' => $faker->imageUrl(120, 120)
        ]);

    }

}
