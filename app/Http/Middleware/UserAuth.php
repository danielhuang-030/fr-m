<?php

namespace App\Http\Middleware;

use Auth;
use Closure;


class UserAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!auth()->check()) {

            $url = route('login', [
                'redirect_url' => url()->current(),
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'code' => 301,
                    'msg'  => 'Please login first',
                    'data'  => $url,
                ]);
            }
            return redirect($url)->with('status', 'Please login first');
        }
        return $next($request);
    }
}
