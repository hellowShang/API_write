<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Redis;

class CheckToken
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
        $token = $_GET['access_token']??'';
        if(empty($token)){
            die(json_encode(['errcode' => 40002,'errmsg' => '缺少access_token'],JSON_UNESCAPED_UNICODE));
        }

        // 验证access_token
        $token_key = 'access_tokens'.$_SERVER['REMOTE_ADDR'];
        $redis_token = Redis::sismember($token_key,$token);
        if(!$redis_token){
            die(json_encode(['errcode' => 40002,'errmsg' => 'access_token验证失败'],JSON_UNESCAPED_UNICODE));
        }
        return $next($request);
    }
}

