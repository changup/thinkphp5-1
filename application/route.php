<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

use think\Route;

//注册路由
//GET方式
Route::get('test','api/test/index');
//PUT
Route::put('test/:id','api/test/update');

Route::resource('test','api/test');

//新闻栏目
Route::get('api/cat','api/cat/read');

//版本控制路由
Route::get('api/:ver/cat','api/:ver.cat/read');

//首页新闻头图
Route::get('api/:ver/index','api/:ver.index/index');