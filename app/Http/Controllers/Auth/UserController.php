<?php

namespace App\Http\Controllers\Auth;

use App\Mail\UserRegister;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public function activeAccount($token)
    {
        if ($user = User::where('active_token', $token)->first()) {
            $user->is_active = 1;
            // 重新生成激活token
            $user->active_token = str_random(60);
            $user->save();

            return view('hint.success', ['status' => "{$user->name} activation succeeded!", 'url' => url('login')]);
        } else {
            return view('hint.error', ['status' => 'Invalid token']);
        }
    }

    public function sendActiveMail($id)
    {
        if ($user = User::find($id)) {
            // again send active link, join queue
            Mail::to($user->email)->send(new UserRegister($user));
            return view('hint.success', ['status' => 'Sending mail is successful', 'url' => route('login')]);
        }

        return view('hint.error', ['status' => 'Username or password is incorrect']);
    }
}
