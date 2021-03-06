<?php

namespace App\Http\Controllers\User;

use App\Models\Product;
use App\Models\User;
use Auth;
use Hash;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        return view('user.homes.index', compact('user'));
    }

    public function setting()
    {
        $user = Auth::user();
        return view('user.users.setting', compact('user'));
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required:unique:users'
        ]);

        auth()->user()->update($request->only(['name', 'avatar']));

        return back()->with('status', 'Successfully modified');
    }


    public function subscribe(Request $request)
    {
        $response = [
            'code' => 402,
            'msg' => '服务器出错，请稍后再试',
        ];

        if (auth()->user()->subscribe()->create($request->all())) {
            $response = [
                'code' => 200,
                'msg' => '订阅成功',
            ];
        }

        return $response;
    }

    public function deSubscribe(Request $request)
    {
        $response = [
            'code' => 402,
            'msg' => '服务器出错，请稍后再试',
        ];

        if (auth()->user()->subscribe()->delete()) {
            $response = [
                'code' => 200,
                'msg' => '取消订阅成功',
            ];
        }

        return $response;
    }


    public function uploadAvatar(Request $request)
    {
        if (! $request->hasFile('file')) {
            return [
                'code' => 302,
                'msg' => 'No images selected',
                'data' => []
            ];
        }

        // move file to public
        if (! $avatar = $request->file('file')->store(config('web.upload.avatar'), 'public')) {
            return [
                'code' => 402,
                'msg' => 'Server error. Please try again later',
                'data' => []
            ];
        }
        $link = sprintf('%s/storage/%s', config('app.url'), $avatar);

        return [
            'code' => 0,
            'msg' => 'Image uploaded successfully',
            'data' => [
                'avatar' => $avatar,
                'src' => $link,
            ]
        ];
    }


    public function showPasswordForm()
    {
        return view('user.users.password');
    }

    public function updatePassword(Request $request)
    {
        $this->validate($request, [
            'old_password' => 'required',
            'password' => 'required|min:6|confirmed',
        ], [
//            'old_password.required' => '旧密码不能为空',
//            'password.required' => '新密码不能为空',
//            'password.min' => '新密码必须大于6位',
//            'password.confirmed' => '两次密码不一致',
        ]);

        if (! $this->validatePassword($request->input('old_password'))) {
            return back()->withErrors(['old_password' => 'The old password is incorrect']);
        }


        $user = $request->user();
        $user->password = Hash::make($request->input('password'));
        $user->save();

        return back()->with('status', 'Password reset complete');
    }

    private function validatePassword($oldPassword)
    {
        return Hash::check($oldPassword, auth()->user()->password);
    }

}
