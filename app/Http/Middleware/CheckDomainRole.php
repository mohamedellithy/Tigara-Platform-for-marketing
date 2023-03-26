<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckDomainRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $hosts_parts = explode('.', $request->getHttpHost());
        if(count($hosts_parts) != 3){
            return $next($request);
        }

        $account_type = \Config::get('app.'.$hosts_parts[0]);
        if(!isset($account_type)){
            abort('404');
        }

        \Config::set('app.Current_Domain', $account_type);
        \Config::set('app.Current_Domain_txt',$hosts_parts[0]);

        //dd(\Config::get('auth.providers.users.model'));
        return $next($request);
    }
}
