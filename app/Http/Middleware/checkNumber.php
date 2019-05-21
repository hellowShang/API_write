<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Redis;
class checkNumber
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
        // 每个接口每分钟请求次数限制20次
        $str = substr($_SERVER['REQUEST_URI'],0,strpos($_SERVER['REQUEST_URI'],'?'));
        $key = 'request_num_'.$str;
        $num = Redis::get($key);
        if($num>20){
            die('接口请求上限');
        }else{
            echo $num."<br>";
            Redis::incr($key);
            Redis::expire($key,60);
        }
        return $next($request);
    }
}
