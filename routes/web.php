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
Route::get('/goods/index', 'goodsController@index');
Route::get('/goods/create', 'goodsController@create');
Route::post('/goods/save', 'goodsController@save');
Route::get('/goods/delete', 'goodsController@delete');
Route::post('/goods/update', 'goodsController@update');
Route::group(['middleware' => ['goods']], function () {
    Route::get('/goods/edit', 'goodsController@edit');
});
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
Route::get('/teacher/index', ['uses' => 'TeacherController@index']);

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

//注册
Route::get('/admin/login/register', 'admin\LoginController@register');
Route::post('/admin/login/doRegister', 'admin\LoginController@doRegister');
//登录
Route::get('/admin/login/login', 'admin\LoginController@login');
//首页
Route::get('/admin/index/index', 'admin\IndexController@index');
//商品添加
Route::get('/admin/goods/create', 'admin\GoodsController@create');
//图片上传
Route::any('/admin/goods/upload', 'admin\GoodsController@upload');
Route::post('/admin/goods/save', 'admin\GoodsController@save');
//展示
Route::get('/admin/goods/lists', 'admin\GoodsController@lists');
//修改
Route::get('/admin/goods/edit', 'admin\GoodsController@edit');
Route::post('/admin/goods/update', 'admin\GoodsController@update');
//删除
Route::get('/admin/goods/delete', 'admin\GoodsController@delete');

//前台
Route::get('/index/index/index', 'index\IndexController@index');
//详情
Route::get('/index/goods/lists', 'index\GoodsController@lists');
//购物车
Route::get('/index/cart/index', 'index\CartController@index');
Route::get('/index/cart/lists', 'index\CartController@lists');

//订单
Route::get('/index/order/confirmOrder', 'index\OrderController@confirmOrder');
Route::get('/index/order/orderList', 'index\OrderController@orderList');
//列表
Route::get('/index/order/lists', 'index\OrderController@lists');

//支付同步
Route::get('/return_url', 'PayController@return_url');

Route::post('/notify_url', 'PayController@notify_url');
Route::get('/pay', 'PayController@do_pay');

//车票
Route::get('fare/create', 'FareController@create');
Route::post('fare/save', 'FareController@save');
Route::get('fare/lists', 'FareController@lists');

Route::get('identiyt/login', 'identity\IdentityController@login');
Route::post('identity/dologin', 'identity\IdentityController@doLogin');
//考试
Route::get('cart/login', 'Cart\CartController@login');
Route::post('cart/dologin', 'cart\CartController@doLogin');
Route::group(['middleware' => ['login']], function () {
    Route::get('exam/index', 'exam\ExambController@index');
    Route::post('exam/ti', 'exam\ExambController@ti');
    Route::any('exam/doti', 'exam\ExambController@doti');
    Route::get('exam/tianjia', 'exam\ExambController@tianjia');
    Route::post('exam/shengcheng', 'exam\ExambController@shengcheng');
    Route::post('exam/save', 'exam\ExambController@save');
    Route::get('exam/lists', 'exam\ExambController@lists');
    Route::get('survey/index', 'survey\SurveyController@index');

    //调研
    Route::get('survey/index', 'survey\SurveyController@index');
    Route::post('survey/issue', 'survey\SurveyController@issue');
    Route::post('survey/wenti', 'survey\SurveyController@wenti');
    Route::post('survey/save', 'survey\SurveyController@save');
    Route::get('survey/lists', 'survey\SurveyController@lists');
    Route::post('survey/delete', 'survey\SurveyController@delete');
    Route::get('survey/check', 'survey\SurveyController@check');

    //车库
    Route::get('cart/index', 'cart\CartController@index');
    Route::get('cart/wuye', 'cart\CartController@wuye');
    Route::get('cart/shujv', 'cart\CartController@shujv');
    Route::get('cart/menwei', 'cart\CartController@menwei');
    Route::get('cart/register', 'cart\CartController@register');
    Route::post('cart/do_register', 'cart\CartController@do_register');
    Route::get('cart/create', 'cart\CartController@create');
    Route::get('cart/edit', 'cart\CartController@edit');
    Route::post('cart/do_edit', 'cart\CartController@do_edit');
    Route::post('cart/update', 'cart\CartController@update');
    Route::post('cart/save', 'cart\CartController@save');
    //身份认证

});
Route::get('identity/index', 'identity\IdentityController@index');
Route::post('identity/pp', 'identity\IdentityController@pp');

//竞猜
Route::get('guess/index', 'guess\GuessController@index');
Route::post('guess/save', 'guess\GuessController@save');
Route::get('guess/lists', 'guess\GuessController@lists');
Route::get('guess/result', 'guess\GuessController@result');
Route::get('guess/guess', 'guess\GuessController@guess');
Route::post('guess/do_guess', 'guess\GuessController@do_guess');

//留言
Route::get('liu/login', 'liu\LiuController@login');
Route::post('liu/do_login', 'liu\LiuController@do_login');
Route::get('liu/lists', 'liu\LiuController@lists');
Route::post('liu/create', 'liu\LiuController@create');
Route::get('liu/delete', 'liu\LiuController@delete');
Route::get('liu/sou', 'liu\LiuController@sou');

Route::post('liu/index', 'liu\LiuController@index');

//微信
Route::get('wechat/get_user_list', 'wechat\WechatController@get_user_list');
Route::get('wechat/get_user_info', 'wechat\WechatController@get_user_info');
Route::get('wechat/user_list', 'wechat\WechatController@user_list');
Route::get('wechat/user_details', 'wechat\WechatController@user_details');
Route::get('wechat/login', 'wechat\WechatController@login');
Route::get('wechat/code', 'wechat\WechatController@code');
Route::get('wechat/template_list', 'wechat\WechatController@template_list');
//删除模板
Route::get('wechat/del_template', 'wechat\WechatController@del_template');
Route::get('wechat/send_template', 'wechat\WechatController@send_template');
//上传素材
Route::get('wechat/upload', 'wechat\WechatController@upload');
Route::post('wechat/do_upload', 'wechat\WechatController@do_upload');
Route::get('wechat/get_source', 'wechat\WechatController@get_source');
Route::get('wechat/get_video_source', 'wechat\WechatController@get_video_source');
Route::get('wechat/get_voice_source', 'wechat\WechatController@get_voice_source');
//素材列表
Route::get('wechat/source_list', 'wechat\WechatController@source_list');
//获取永久素材列表
Route::get('wechat/upload_source', 'wechat\WechatController@upload_source');
//创建标签
Route::get('wechat/create_tag', 'wechat\WechatController@create_tag');
Route::post('wechat/save_tag', 'wechat\WechatController@save_tag');
Route::get('wechat/tag_list', 'wechat\WechatController@tag_list');
Route::get('wechat/del_tag', 'wechat\WechatController@del_tag');
Route::get('wechat/add_user_tag', 'wechat\WechatController@add_user_tag');
//标签下粉丝
Route::get('wechat/tag_fans', 'wechat\WechatController@tag_fans');
//粉丝下的标签
Route::get('wechat/get_user_tag', 'wechat\WechatController@get_user_tag');
Route::get('wechat/del_user_tag', 'wechat\WechatController@del_user_tag');
//修改标签
Route::get('wechat/edit_tag', 'wechat\WechatController@edit_tag');
Route::post('wechat/update_tag', 'wechat\WechatController@update_tag');
Route::get('wechat/push_tag_message', 'wechat\WechatController@push_tag_message');
Route::post('wechat/do_push_tag_message', 'wechat\WechatController@do_push_tag_message');
Route::post('wechat/event', 'wechat\WechatController@event');
//二维码
Route::get('wechat/getTimeQrCode', 'wechat\WechatController@getTimeQrCode');
Route::get('wechat/agentUserList', 'wechat\WechatController@agentUserList');
//自定义菜单
Route::get('wechat/definedMenu', 'wechat\WechatController@definedMenu');
Route::get('wechat/menuCreate', 'wechat\WechatController@menuCreate');
Route::get('wechat/menuSave', 'wechat\WechatController@menuSave');
Route::get('wechat/reload_menu', 'wechat\WechatController@reload_menu');


Route::get('menu/menu_list', 'MenuController@menu_list');
Route::post('menu/do_add_menu', 'MenuController@do_add_menu');
Route::get('menu/reload_menu', 'MenuController@reload_menu');
/////////
 Route::get('we/index', 'wechat\WeController@index');
Route::get('we/login', 'wechat\WeController@login');
Route::get('we/getUserOpenId', 'wechat\WeController@getUserOpenId');
Route::get('we/userList', 'wechat\WeController@userList');

//表白
Route::get('wechatMenu','TestController@wechatMenu');
Route::get('biaobai','TestController@biaobai');
Route::post('dobiaobai','TestController@dobiaobai');
Route::post('wode','TestController@wode');




