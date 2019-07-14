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
    return view('welcome');
});
Route::get('/student/index', 'StudentController@index');
//Route::get('member/index', 'MemberController@index');
//Route::any('member/index', ['uses' => 'memberController@index']);
Route::any('member/index/{id}', [
    'uses' => 'memberController@index',
    'as' => 'memberindex'
])->where('id', '[0-9]+');
//添加
Route::get('/student/create', 'StudentController@create');
Route::post('student/save', 'StudentController@save');
//修改
Route::get('/student/edit', 'StudentController@edit');
Route::post('/student/update', 'StudentController@update');
//删除
Route::get('/student/delete', 'StudentController@delete');

//教师
//Route::get('/teacher/index', ['uses' => 'TeacherController@index']);

Route::any('text1', ['uses' => 'TeacherController@text1']);
Route::any('goods', ['uses' => 'TeacherController@goods']);
Route::any('addGoods', ['uses' => 'TeacherController@addGoods']);

//Route::group(['middleware' => ['login']], function () {
//    Route::get('/index/login', 'LoginController@login');
//});

//登录
Route::get('/index/login', 'index\LoginController@login');
Route::post('/index/doLogin', 'index\LoginController@doLogin');
//注册
Route::get('index/register', 'index\LoginController@register');
Route::post('index/doRegister', 'index\LoginController@doRegister');

//后台
Route::get('admin/index/index', 'admin\IndexController@index');
//商品添加
Route::get('admin/goods/create', 'admin\GoodsController@create');
//图片上传
Route::any('admin/goods/upload', 'admin\GoodsController@upload');
Route::post('admin/goods/save', 'admin\GoodsController@save');
//展示
Route::get('admin/goods/lists', 'admin\GoodsController@lists');
//修改
Route::get('admin/goods/edit', 'admin\GoodsController@edit');
Route::post('admin/goods/update', 'admin\GoodsController@update');
//删除
Route::get('admin/goods/delete', 'admin\GoodsController@delete');

//前台
Route::get('/index/index/index', 'index\IndexController@index');