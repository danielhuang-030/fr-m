<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    public function getActiveLink(User $user)
    {
        // 拼接提示消息
        $url = url('register/again/send/' . $user->id);
        $msg = "User is not activated， <a href='{$url}'>Click here to resend the activation email</a>";

        return $msg;
    }
}