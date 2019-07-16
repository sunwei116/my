<?php

namespace App\Http\Middleware;

use Closure;

class goods
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
       $h = date('H');
       dd($h);
        if ($h <9 || $h>17){
            echo '修改需要在【9:00-17:00】才可以进入';die();
        }
        return $next($request);
    }
}
