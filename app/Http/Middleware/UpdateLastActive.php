<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;


// used on all authenticated requests to update user's last active time
class UpdateLastActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        date_default_timezone_set("Europe/Dublin");
        $hasProfile = isset(Auth::user()->profile);
        if (!$hasProfile) {
            if (!str_contains(request()->route()->getName(), "profile.")) {
                return redirect("profile");
            }
            return $next($request);
        } else {
            $user = $request->user();
            $user->profile->last_active = date_create("now");
            $user->profile->save();
            return $next($request);
        }
    }
}
