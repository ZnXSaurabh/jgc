<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use DB;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $guard = null): Response
    {

        if (Auth::guard($guard)->check()) {
            if(Auth::user()->hasRole('Super Admin') || Auth::user()->hasRole('Admin') || Auth::user()->hasRole('HR Manager') || Auth::user()->hasRole('HR') || Auth::user()->hasRole('Vendor')){
                return redirect('common/dashboard');
            }else if (Auth::user()->hasRole('Candidate')){
                $user = User::findOrFail(Auth::user()->id);
                if($user->profile->country=='' || $user->profile->city=='' || $user->profile->state=='' ){
                    return redirect()->route('common.candidate.edit',Auth::user()->id)->with('message','Please Complete Your Profile');
                }  
                return redirect('common/candidate-profile');
            }
        }
        return $next($request);
    }
}
