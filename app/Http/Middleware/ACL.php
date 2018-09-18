<?php

namespace App\Http\Middleware;
use Closure;
use Auth;

class ACL 
{
    
	public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::user()->privilege != '1') {
	    	return response('Unauthorized.', 401);
	    }

        return $next($request);
    }
}
