<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/8/19
 * Time: 8:52
 */

namespace App\Http\Controllers\wechat;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Tools\Wechat;


class WeController extends Controller
{
    public $request;
    public $wechat;

    public function __construct(Request $request,Wechat $wechat)
    {
        $this->request = $request;
        $this->wechat = $wechat;
    }

    public function index()
    {
        return view('we.index');
    }

    public function login()
    {
        $redirect_url = urlencode("http://w3.shop.com/we/getUserOpenId");
        $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=".env('WECHAT_APPID')."&redirect_uri=".$redirect_url."&response_type=code&scope=snsapi_base&state=STATE#wechat_redirect";
        header('location:'.$url);
    }

    public function getUserOpenId(Request $request)
    {
        //获取网页授权的access_token
        $code = $request->all()['code'];
        $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".env('WECHAT_APPID')."&secret=".env('WECHAT_APPSECRET')."&code=".$code."&grant_type=authorization_code";
        $res = file_get_contents($url);
        $result = json_decode($res,1);
        $openid = $result['openid'];
        $wechatUserInfo = $this->wechat->wechat_user_info($openid);
        $user_openid = DB::connection('mysql4')->table('user_wechat')->where('openid',$openid)->first();
        if (empty($user_openid)) {
            //没有注册
            DB::connection("mysql4")->beginTransaction();
            $uid=DB::connection('mysql4')->table('user')->insertGetId([
                'pwd' =>'',
                'name' => $wechatUserInfo['nickname'],
                'add_time' => time()
            ]);
            DB::connection('mysql4')->table('user_wechat')->insert([
                'uid' => $uid,
                'openid' =>$openid
            ]);
            DB::connection('mysql4')->commit();
            //登陆操作
            $user_info = DB::connection('mysql4')->table('user')->where(['id' => $uid])->first();
            $request->session()->put('username',$user_info->name);
        }else{
            $user_info = DB::connection('mysql4')->table('user')->where(['id'=>$user_openid->uid])->first();
            $request->session()->put('username',$user_info->name);
        }
        header('location:userList');
    }

    public function userList()
    {

    }
}