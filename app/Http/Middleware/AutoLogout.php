<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class AutoLogout
{
    protected $timeout = 300;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $encrypter = app(\Illuminate\Contracts\Encryption\Encrypter::class);
        if(Cookie::has('last_active')) {
            $time = $encrypter->decryptString(Cookie::get('last_active'));
            if(time() - intval($time) >= $this->timeout){
                auth()->logout(); 
            }else{
                Cookie::queue(Cookie::make('last_active', time(), time() + (86400 * 30))); 
            }
        }else{
            Cookie::queue(Cookie::make('last_active', time(), time() + (86400 * 30))); 
        }
                
        return $next($request);          
        }
        
}
