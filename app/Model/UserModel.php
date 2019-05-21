<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class UserModel extends Model
{
    //指定表名
    protected $table = 'register';
    public $timestamps = false;

    // 生成appid
    public static function createAppid(){
        $str = substr(md5(Str::random(16).time().rand(1111,9999)),5,20);
        $appid = 'wx'.$str;
        return $appid;
    }

    // 生成key
    public static function createKey(){
       return md5(Str::random(16).'lening'.time().rand(1111,9999).Str::random(8).'1809a');
    }
}
