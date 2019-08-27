<?php

namespace App\Http\Controllers;

use App\Http\Tools\Wechat;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{
    public function __construct(Wechat $wechat)
    {
        $this->wechat = $wechat;
    }
    //新建微信菜单
    public function wechatMenu()
    {
        $access_token = $this->wechat->get_access_token();
        $url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$access_token;
        $arr = [
            "button"=>[
                [
                    "type"=>"view",
                    'name'=>"我要表白",
                    'url'=>"http://www.wei678.top/biaobai"
                ],
                [
                    'type'=>'click',
                    'name'=>'我的表白',
                    'key' =>'love'
                ]
            ]
        ];
        $post = json_encode($arr,JSON_UNESCAPED_UNICODE);
        $res = $this->wechat->post($url,$post);
        dd($res);
    }

    public function aa()
    {
        $redis = new \Redis();
        $redis->connect('127.0.0.1','6379');
        $data = file_get_contents("http://www.wei678.top/api/index");
        $data = json_decode($data, 1);
        echo $redis->get('北京');
        foreach ($data['result'] as $key => $value){
                if ($redis->exists($value['city'].'信息')){
                    $redisInfo = json_decode($value['city'].'信息',1);
                    dd($redisInfo);
                }
        }
    }

    public function biaobai()
    {
       $access = $this->wechat->get_access_token();
       $url = "https://api.weixin.qq.com/cgi-bin/user/get?access_token={$access}&next_openid=";
       $dd = file_get_contents($url);
       $res = json_decode($dd,1);
       $arr=[];
       foreach ($res['data']['openid'] as $k=>$v){
           $arr['user_list'][]=[
               'openid'=>$v,
               'lang'=>"zh_CN"
           ];
       }

        $url1 = "https://api.weixin.qq.com/cgi-bin/user/info/batchget?access_token={$access}";
       $postJson=json_encode($arr);
       $res = $this->wechat->post($url1,$postJson);
       $res = json_decode($res,1);
       //将所有表白的人加入数据库
       foreach ($res['user_info_list'] as $k=>$v){
            $a = DB::connection('mysql4')->table('testuser')->where('openid',$v['openid'])->get()->toArray();
            if (empty($a)){
                $array =[
                    'openid'=>$v['openid'],
                    'city'=>$v['city'],
                    'headimgurl'=>$v['headimgurl'],
                    'nickname'=>$v['nickname'],
                ];
                DB::connection('mysql4')->table('testuser')->insert($array);
            }
       }
       $userInfo = $this->getUserInfo();//当前表白的人
        return view('test.addbiaobai',['user'=>$userInfo,'res'=>$res['user_info_list']]);
    }

    public function dobiaobai()
    {
        $access_token =$this->wechat->get_access_token();
       $data = request()->post();
       $res = DB::connection('mysql4')->table('biaobai')->insert($data);
       if ($res){
           if (!empty($data['status'])){
               $data['userName'] = '匿名用户';
           }
            $url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token={$access_token}";
           $postJson = [
               'touser' => $data['openid'],
               'template_id' => '0EN58O4NDGaNWff_5_d_ErDn7jhSKB8tgrn9TIoRvXU',
               'url' => '',
               'miniprogram' => '',
               'data' => [
                   'first' => [
                       'value' => '有人对你表白',
                       'color' => '#173177',
                   ],
                   'userName' =>[
                       'value' => $data['userName'],
                       'color' =>'#ff1127',
                   ],
                   'content' =>[
                       'value' => $data['content'],
                       'color' => '#ff1127'
                   ],

               ],
           ];
           $postData = json_encode($postJson,JSON_UNESCAPED_UNICODE);
           $res      = $this->wechat->post($url,$postData);
           $res = json_decode($res,1);
           if ($res['errmsg'] == 'ok'){
                echo "<script>alert('表白成功，信息发送成功');history.back(-1)</script>";
           }else{
               echo "<script>alert('表白失败，信息好像没有发送成功');history.back(-1)</script>";
           }
       }else{
           echo "<script>alert('表白失败');history.back(-1)</script>";
       }
    }

    public function wode()
    {
        $xml = file_get_contents("php://input");
        file_put_contents('kaoshi.txt',$xml);
        $xmlObj = simplexml_load_string($xml);
        dd($xmlObj);
        if ($xmlObj->MsgType = 'event' && $xmlObj->Event == 'ClICK'){
            $data = DB::connection('mysql4')->table('biaobai')->where('openid',$xmlObj->FromUserName)->get()->toArray();
//            \Log::info($data);
            $msg = '';
            foreach ($data as $k => $v){
                if ($v->status == 2){
                    $v->userName = "匿名用户";
                }
                $msg .="收到".$v->userName."的表白：".$v->content."\n";
            }
            echo "
            <xml>
              <ToUserName><![CDATA[".$xmlObj->FromUserName."]]></ToUserName>
              <FromUserName><![CDATA[".$xmlObj->ToUserName."]]></FromUserName>
              <CreateTime>".time()."</CreateTime>
              <MsgType><![CDATA[text]]></MsgType>
              <Content><![CDATA[".$msg."]]></Content>
            </xml>
            ";
        }

    }
    public function getUserInfo()
    {
        $userInfo = request()->session()->get('userInfo');
        if (!empty($userInfo)){
            return $userInfo;
        }
       $code = request()->input('code');
       if (empty($code)){
           //没有code没有授权
       $host = $_SERVER['HTTP_HOST'];
       $uri  = $_SERVER['REQUEST_URI'];
       $redirect_uri = urlencode('http://'.$host.$uri);
       $url  = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=".env('WECHAT_APPID')."&redirect_uri=".$redirect_uri."&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect";
       header("location:".$url);die();
       }else{
        $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".env('WECHAT_APPID')."&secret=".env('WECHAT_APPSECRET')."&code={$_GET['code']}&grant_type=authorization_code";
        $dd = file_get_contents($url);
        $userInfo = json_decode($dd,true);
        $access_token = $userInfo['access_token'];
        $uu = "https://api.weixin.qq.com/sns/userinfo?access_token={$access_token}&openid={$userInfo['openid']}&lang=zh_CN";
        $data = file_get_contents($uu);
        $data = json_decode($data,true);
        request()->session()->put('userInfo',$data);
       }
       return $data;
    }

}