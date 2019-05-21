<?php

namespace App\Admin\Controllers;

use App\Model\UserModel;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Layout\Content;

class UserController extends Controller
{
    use HasResourceActions;

    public function index(Content $content)
    {
        $arr = UserModel::where('delete_status',1)->get();
        return $content
            ->header('注册信息详情')
            ->body(view('user.list',['arr' => $arr]));
    }

    // 审核
    public function operation(){
        $id = request()->id;
        $type = request()->type;

        if(empty($id) || empty($type)){
            die(json_encode(['errcode' => 40006,'errmsg' => '缺少参数'],JSON_UNESCAPED_UNICODE));
        }

        if($type == 1){

            // 生成APPID和key
            $appid = UserModel::createAppid();
            $key = UserModel::createKey();
            $res = UserModel::where('id',$id)->update(['appid' => $appid,'key' => $key,'status' => 1,'update_time' => time()]);
            if($res){
                die(json_encode(['msg' => '审批成功'],JSON_UNESCAPED_UNICODE));
            }else{
                die(json_encode(['msg' => '审批失败'],JSON_UNESCAPED_UNICODE));
            }
        }else{
            $res = UserModel::where('id',$id)->update(['status' => 2,'update_time' => time()]);
            if($res){
                die(json_encode(['msg' => '驳回成功'],JSON_UNESCAPED_UNICODE));
            }else{
                die(json_encode(['msg' => '驳回失败'],JSON_UNESCAPED_UNICODE));
            }
        }
    }
}
