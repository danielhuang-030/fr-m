<?php

namespace App\Jobs;

use App\Mail\UserRegister;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class InstallShopWarn implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $time = date('Y-m-d H:i:s');
        $msg = '网站已启动|启动时间: ' . $time;
        Log::info($msg);

        // 注册成功发送邮件加入队列
        // Mail::to('1033404553@qq.com')->queue(new UserRegister($this->user));
    }
}
