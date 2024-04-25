<?php

namespace App\Http\Middleware;

use App\Exceptions\ExtraVerificationIsExpired;
use App\Exceptions\NotExtraVerified;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Symfony\Component\HttpFoundation\Response;

class IsExtraVerifiedMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = User::first();
        if ($user->extra_verified_expires_at > Carbon::now()){
            return $next($request);
        }
        else {
            isset($user->extra_verified_expires_at) ? throw new ExtraVerificationIsExpired() : throw new NotExtraVerified();
        }
    }
}
