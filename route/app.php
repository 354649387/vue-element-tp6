<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\facade\Route;

Route::get('think', function () {
    return 'hello,ThinkPHP6!';
});

Route::get('hello/:name', 'index/hello');


//进行api版本控制 v1  And  v2
$v = request()->header('Api-Version');
//默认为版本v1
if ($v !== 'v1' && $v !== 'v2') $v = 'v1';

//用户   这个用prefix简写
Route::group('user',function (){

    Route::post('register','register');

    Route::post('login','login');

    Route::get('getToken','getToken');

    Route::get('tokenRefresh','tokenRefresh');

    Route::post('getUserInfo','getUserInfo')->middleware(\app\middleware\CheckToken::class);

})->prefix($v.'.user/')->pattern(['id' => '\d+']);

//用户 以下是不用prefix的写法，不提倡
//Route::group('user',function() use ($v){
//    Route::post('login',$v.'.User/login');
//})->pattern(['id'=>'\d+']);
