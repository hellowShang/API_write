<?php

namespace App\Http\Controllers\Api;

use App\Model\UserModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TestController extends Controller
{
    // 查询审核状态
    public function selectStatus(){
        $uid = $_GET['uid']??'';
        if(empty($uid)){
            die(json_encode(['errcode' => 40004,'errmsg' => '缺少用户id'],JSON_UNESCAPED_UNICODE));
        }
        $arr = UserModel::where('id',$uid)->first()->toArray();
        if($arr['status'] == 0){
            die(json_encode(['msg' => '审核中，请耐心等待'],JSON_UNESCAPED_UNICODE));
        }elseif($arr['status'] == 2){
            UserModel::where('id',$uid)->update(['delete_status' => 2]);
            die(json_encode(['msg' => '审核未通过，请重新注册'],JSON_UNESCAPED_UNICODE));
        }elseif($arr['status'] == 1){
            die(json_encode(['msg' => '审核已通过','data' => ['appid' => $arr['appid'],'key' => $arr['key']]],JSON_UNESCAPED_UNICODE));
        }
    }

    // 显示客户端ip
    public function showIP(){
        // 返回ip
        die(json_encode(['errcode' =>0,'IP' => $_SERVER['SERVER_ADDR']]));
    }

    // 显示客户端UA
    public function showUA(){
        // 返回UA
        die(json_encode(['errcode' =>0,'UA' => $_SERVER['HTTP_USER_AGENT']]));
    }

    // 返回所有用户注册信息
    public function getUserInfo(){
        // 查询数据并返回
        $userInfo = UserModel::all()->toArray();
        if($userInfo){
            die(json_encode(['data' => $userInfo],JSON_UNESCAPED_UNICODE));
        }else{
            die(json_encode(['msg' => '暂无数据'],JSON_UNESCAPED_UNICODE));
        }
    }
}
