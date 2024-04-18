<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Mockery\Undefined;
use Symfony\Component\HttpFoundation\Response;

class EnsureNotBanned
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $now = date_create("now");
        $active_ban = null;

        foreach (auth()->user()->bans as $ban) {
            if (date_create($ban->active_from) <= $now && date_create($ban->active_to) >= $now) {
                $active_ban = $ban;
                break;
            }
        }
        if ($active_ban) {
            auth()->logout();
            echo $ban->acive_to;
            return redirect()->route("login")->with(["ban" => $active_ban]);
        }
        return $next($request);
    }
}
