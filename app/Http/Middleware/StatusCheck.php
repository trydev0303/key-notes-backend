<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StatusCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user_id = Auth::id();
        $user = DB::table('users')->where('id', $user_id)->first();
        if ($user->status == 1) {
            return $next($request);
        } elseif ($user->status == 2) {
            return Response()->json(['statusCode' => 510, 'message' => 'Sorry, Your Account has been suspended by Admin.'], 510);
        } else {
            return Response()->json(['statusCode' => 510, 'message' => 'Sorry, Your Account has been deactivated by Admin.'], 510);
        }
    }
}
