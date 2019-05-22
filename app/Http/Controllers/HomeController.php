<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    // 签到
    public function sign(){
        $key = 'sign:'.date('Y-m-d');
        $uid = Auth::id();
        // 检测当前用户是否签到
        $res = Redis::getbit($key,$uid);
        if($res){
            die(json_encode(['msg' => '你今天已经签到过了'],JSON_UNESCAPED_UNICODE));
        }
        // 签到存值
        Redis::setbit($key,$uid,1);
        die(json_encode(['msg' => '签到成功'],JSON_UNESCAPED_UNICODE));
    }

    // 获取签到人数
    public function countSign(){
        $key = 'sign:'.date('Y-m-d');
        $num = Redis::bitcount($key);
        die(json_encode(['num' => $num],JSON_UNESCAPED_UNICODE));
    }
}
