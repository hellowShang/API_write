<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('user.register');
});


// 用户注册
Route::any('register','Api\UserController@register');

// 请求次数的中间件
Route::middleware('num')->group(function () {
    // access_token
    Route::get('token','Api\TokenController@access_token');

    // 查询审核状态
    Route::get('selstatus','Api\TestController@selectStatus');

    // 验证token的中间件
    Route::middleware('token')->group(function () {
        // 获取客户端ip
        Route::get('showIP', 'Api\TestController@showIP');

        // 获取UA
        Route::get('showUA', 'Api\TestController@showUA');

        //获取用户注册信息
        Route::get('userInfo', 'Api\TestController@getUserInfo');
    });
});

