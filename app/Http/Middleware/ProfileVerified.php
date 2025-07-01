<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class ProfileVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::user()->is_profile_verified==2 || Auth::user()->is_verified==2){
            $redirect_url = '';
            if(Auth::user()->user_type==1){
                $redirect_url = route('buyer.profile');
            }else if(Auth::user()->user_type==2){
                $redirect_url = route('vendor.profile');
            }
            if ($request->ajax() || $request->expectsJson()) {
                return response()->json([
                    'message' => 'Profile not verified.',
                ], 403); // 403 Forbidden
            }else{
                return redirect()->to($redirect_url);
            }
        }
        return $next($request);
    }
}
