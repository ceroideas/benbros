<?php

namespace App\Http\Middleware;

use Closure;

class LangMiddleware
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
        $langArr = ['it','fr'];
        if (!session('lang')) {
            if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
                $languages = explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']);
                if (in_array($languages[0], $langArr)) {
                    session(['lang' => $languages[0]]);
                    \App::setLocale(session('lang'));
                }else{
                    session(['lang' => 'it']);
                    \App::setLocale(session('lang'));
                }
            }
        }else{
            \App::setLocale(session('lang'));
        }
        return $next($request);
    }
}
