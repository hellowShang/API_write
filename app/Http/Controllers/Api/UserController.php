<?php

namespace App\Http\Controllers\Api;

use App\Model\UserModel;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

class UserController extends Controller
{
    // 用户注册
    public function register(){
        $data = request()->all();

        // 文件上传处理
        $upload_path = $this->uplode('business_license');

        // 处理数据
        unset($data['_token']);
        $data['business_license'] = $upload_path;
        $data['create_time'] = time();

        // 查询是否注册
        $arr = UserModel::where(['firmname'=>$data['firmname'],'delete_status' => 1])->first();
        if($arr){
            header('Refresh:3;url=http://api.create.com');
            die(json_encode(['errcode' => 40005,'errmsg' => '该企业已经注册过了'],JSON_UNESCAPED_UNICODE));
        }else{
            // 数据入库
            $uid = UserModel::insertGetId($data);

            // 入库成功，返回uid给客户端
            if($uid){
                die(json_encode(['msg' => '注册成功,等待审核中','uid' => $uid],JSON_UNESCAPED_UNICODE));
            }else{
                die(json_encode(['errcode' => 40003,'errmsg' => '注册失败'],JSON_UNESCAPED_UNICODE));
            }

        }
    }

    // 文件上传
    public function uplode($fileName){
        if (request()->hasFile($fileName) && request()->file($fileName)->isValid()) {
            $photo = request()->file($fileName);
            // 返回文件后缀
            $extension = $photo->getClientOriginalExtension();
            // 文件自定义名字
            $name = time().Str::random(10);
            $store_result = $photo->storeAs('upload/'.date('Ymd'), $name.'.'.$extension);
            return $store_result;
        }
        exit('未获取到上传文件或上传过程出错');
    }
}


