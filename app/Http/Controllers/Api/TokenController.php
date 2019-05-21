<?php

namespace App\Http\Controllers\Api;

use App\Model\UserModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;

class TokenController extends Controller
{
    // 请求access_token
    public function access_token(){
        $appid = $_GET['appid']??'';
        $key = $_GET['key']??'';

        // 验证appid和key
        if(!$appid || !$key){
            die(json_encode(['errcode' => 40002,'errmsg' => '缺少APPID或key'],JSON_UNESCAPED_UNICODE));
        }

        $info = UserModel::where('appid',$appid)->first();
        if($info){
            if($key == $info->key){
                // 查看token请求次数
                $token_num_key = 'token_num_appid_'.$appid;
                $token_num = Redis::get($token_num_key);
                if($token_num > 100){
                    die(json_encode(['errcode' => 50002,'errmsg' => 'access_token请求上限，上限为100次/天'],JSON_UNESCAPED_UNICODE));
                }
                Redis::incr($token_num_key);
                Redis::expire($token_num_key,86400);

                // 生成token
                $key = 'access_token_'.$_SERVER['REMOTE_ADDR'];
                $token = base64_encode(md5(md5(Str::random(16).time().$key.rand(1111,9999)).$appid));
                Redis::set($key,$token);
                Redis::expire($key,3600);

                // token存入集合中
                $token_key = 'access_tokens'.$_SERVER['REMOTE_ADDR'];
                Redis::sadd($token_key,$token);

                die(json_encode(['access_token' => $token,'expires_in' => 3600]));
            }else{
                die(json_encode(['errcode' => 40002,'errmsg' => 'KEY不正确'],JSON_UNESCAPED_UNICODE));
            }
        }else{
            die(json_encode(['errcode' => 40002,'errmsg' => 'APPID不正确'],JSON_UNESCAPED_UNICODE));
        }
    }
}
