<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        '/admin/products/upload/*',
        '/user/upload/avatar',
        '/user/pay/*',

        // 暫時排除 cart, 測試用
        '/cart',
        '/cart/*',
    ];
}
