<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $lang = $request->header('lang');

        if(isset($lang)){
               $request->merge(['name'.$lang  >= $request->only('name')]);
               $newRequest = $request->except('name');
               return $next($newRequest);

        }
        else{
            $request->merge(['name_en'  >= $request->only('name')]);
               $newRequest = $request->except('name');
               return $next($newRequest);
        }
    }
}
