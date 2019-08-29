<?php

namespace App\Http\Controllers\wechat;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Tools\Wechat;
use Illuminate\Support\Facades\Storage;

class WechatController extends Controller
{
    public $request;
    public $wechat;

    public function __construct(Request $request,Wechat $wechat)
    {
        $this->request = $request;
        $this->wechat = $wechat;
    }

    public function get_user_list()
    {
       //获得access_token
       $access_token = $this->wechat->get_access_token();
        //获得所有用户
       $wechat_user  = file_get_contents("https://api.weixin.qq.com/cgi-bin/user/get?access_token={$access_token}&next_openid=");
       $user_info    = json_decode($wechat_user,1);
       $openid =  $user_info['data']['openid'];
            $i = 0;
            for ($i=0;$i<count($openid);$i++){
                //获取subscribe
                $access_token = $this->wechat->get_access_token();
                $wechat_info = file_get_contents("https://api.weixin.qq.com/cgi-bin/user/info?access_token={$access_token}&openid={$openid[$i]}&lang=zh_CN");
                $user_info = json_decode($wechat_info,1);
                //获取openid
                $user_openid = DB::connection('mysql4')->table('wechat_openid')->where('openid',$user_info['openid'])->first();
                if(empty($user_openid)){
                    $openid = $openid[$i];
                    DB::connection('mysql4')->table('wechat_openid')->insert([
                        'openid' => $openid,
                        'add_time' => time(),
                        'subscribe' =>$user_info['subscribe']
                    ]);
                }
            }
        return redirect('wechat/user_list');
    }

    public function get_user_info()
    {
        $openid = "oNESkw1iY09qZujedFTAPP-nc8QI";
        $access_token = $this->wechat->get_access_token();
        $wechat_info = file_get_contents("https://api.weixin.qq.com/cgi-bin/user/info?access_token={$access_token}&openid={$openid}&lang=zh_CN");
        $user_info = json_decode($wechat_info,1);
        dd($user_info);
    }



    public function user_list()
    {
        $tag_id = !empty($this->request->all()['id'])?$this->request->all()['id']:'';
       $user = DB::connection('mysql4')->table('wechat_openid')->get()->toArray();
        return view('admin.wechat.user_list',['user'=>$user,'tag_id'=>$tag_id]);
    }
    //用户详情
    public function user_details(Request $request)
    {
        $openid = $request->all()['openid'];
        dd($openid);
       $user = DB::connection('mysql4')->table('wechat_openid')->get()->toArray();

    }

    public function login()
    {
        $redirect_url = 'http://w3.shop.com/wechat/code';
        $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=".env('WECHAT_APPID')."&redirect_uri=".urlencode($redirect_url)."&response_type=code&scope=snsapi_base&state=STATE#wechat_redirect";
        header('Location:'.$url);
    }
    public function code(Request $request)
    {
        $data = $request->all();
        $code = $data['code'];
        $res = file_get_contents("https://api.weixin.qq.com/sns/oauth2/access_token?appid=".env('WECHAT_APPID')."&secret=".env('WECHAT_APPSECRET')."&code=$code&grant_type=authorization_code");
        $result = json_decode($res,1);
        $access_token = $result['access_token'];
        $openid = $result['openid'];
        //获取用户基本信息
        $wechat_user_info = $this->wechat->wechat_user_info($openid);

        //去user_wechat查
        $user_openid = DB::connection('mysql4')->table('user_wechat')->where(['openid'=>$openid])->first();
        if (!empty($user_openid)) {
            $user_info = DB::connection('mysql4')->table('user')->where(['id'=>$user_openid->uid])->first();
            $request->session()->put('username',$user_info->name);

        }else{
            //没有数据 注册信息
            DB::connection("mysql4")->beginTransaction();
            $uid = DB::connection('mysql4')->table('user')->insertGetId([
                'pwd' =>'',
                'name' => $wechat_user_info['nickname'],
                'add_time' => time()
            ]);
            $openid_res = DB::connection('mysql4')->table('user_wechat')->insert([
                'uid' => $uid,
                'openid' =>$openid
            ]);
            DB::connection('mysql4')->commit();
            //登陆操作
            $user_info = DB::connection('mysql4')->table('user')->where(['id' => $uid])->first();
            $request->session()->put('username',$user_info->name);
        }
    }
    
    //模板列表
    public function template_list()
    {
       $res = file_get_contents('https://api.weixin.qq.com/cgi-bin/template/get_all_private_template?access_token='.$this->wechat->get_access_token());
       $arr = json_decode($res,1);

       return view('admin.wechat.template',['data'=>$arr]);
    }
    
    //删除模板
    public function del_template()
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/template/del_private_template?access_token='.$this->wechat->get_access_token();
        $id = $this->request->all()['id'];
        $data = [
            'template_id' =>$id
        ];
       $res = $this->wechat->post($url,json_encode($data));
      $res = json_decode($res,1);
       if ($res['errcode'] == 0){
           echo '删除成功';
       }else{
            echo '删除失败';
       }
    }

//发送模板消息
    public function send_template()
    {
       $template_id = $this->request->all()['id'];
        $openid = DB::connection('mysql4')->table('wechat_openid')->select('openid')->limit(10)->get()->toArray();
        foreach ($openid as $val) {

            $res = $this->wechat->push_template($val->openid,$template_id);
        }
        dd($res);
    }
//素材管理
    public function upload()
    {
        return view('admin.wechat.upload');
    }
    public function do_upload()
    {
       $upload_type = $this->request->all()['up_type'];

        if ($this->request->hasFile('image')) {
            $res = $this->wechat->upload_source($upload_type,'image');
        } elseif ($this->request->hasFile('voice')) {
            $res = $this->wechat->upload_source($upload_type, 'vice');
        } elseif ($this->request->hasFile('video')) {
            $res = $this->wechat->upload_source($upload_type,'video','视频标题','视频描述');

        } elseif ($this->request->hasFile('thumb')) {
            //缩略图
            $res = $this->wechat->upload_source($upload_type, 'thumb');
        }
        echo $res;
        die();
    }

    public function get_source()
    {

        $media_id = $this->request->all()['id'];
        $url = 'https://api.weixin.qq.com/cgi-bin/media/get?access_token='.$this->wechat->get_access_token().'&media_id='.$media_id;
        //保存图片
        $client = new Client();
        $response = $client->get($url);
//        $h = $response->getHeaders();
//        echo '<pre>';print_r($h);echo '</pre>';die;
        $file_info = $response->getHeader('Content-disposition');
        $file_name = substr(rtrim($file_info[0],'"'),-20);
        //保存图片
        $path = 'wechat/image/'.$file_name;
        $res = Storage::disk('local')->put($path, $response->getBody());
        echo env('APP_URL').'/storage/'.$path;
        dd($res);
    }
//获得视频
    public function get_video_source()
    {
//      $media_id = 'Hidj0QYd420g66U_zr-NefRJMfYMUJy__S5zrq6RJ6Sb3GaEmoMXUMMveiJLF6yL';
        $media_id = $this->request->all()['id'];
        $url = 'https://api.weixin.qq.com/cgi-bin/media/get?access_token='.$this->wechat->get_access_token().'&media_id='.$media_id;
        $client = new client();
        $response = $client->get($url);
//        echo $response->getBody();
//        $res = file_get_contents($url);
//        file_put_cont|ents('./uploads/1.mp3',$res);
        $video_url = json_decode($response->getBody(),1)['video_url'];
        $file_name = explode('/',parse_url($video_url)['path'])[2];
        //设置超时参数
        $opts=array(
            "http"=>array(
                "method"=>"GET",
                "timeout"=>3  //单位秒
            ),
        );
        //创建数据流上下文
        $contents = stream_context_create($opts);
        //$url请求的地址：例如
        $read = file_get_contents($video_url,false,$contents);
        $res = file_put_contents('./storage/wechat/video/' . $file_name, $read);

        var_dump($res);
        die();
    }
    //音频
    public function get_voice_source()
    {
        $media_id = $this->request->all()['id'];
        $url = 'https://api.weixin.qq.com/cgi-bin/media/get?access_token='.$this->wechat->get_access_token().'&media_id='.$media_id;
        //保存图片
        $client = new Client();
        $response = $client->get($url);
        //获取文件名
//        $h = $response->getHeaders();
//        echo '<pre>';print_r($h);echo '</pre>';die;
        $file_info = $response->getHeader('Content-disposition');
        $file_name = substr(rtrim($file_info[0],'"'),-20);
//        $wx_image_path = 'wx/images'.$file_name;
        //保存音频
        $path = 'wechat/voice/'.$file_name;
        $res = Storage::put($path,$response->getBody());
        echo env('APP_URL').'/storage/'.$path;
        dd($res);
    }
    //素材列表
    public function source_list()
    {
        $data = DB::connection('mysql4')->table('source')->get()->toArray();
        return view('admin.wechat.source_list',['data'=>$data]);
    }
//获取永久素材
    public function upload_source()
    {
        $type = $this->request->all()['type'];
        $url = 'https://api.weixin.qq.com/cgi-bin/material/batchget_material?access_token='.$this->wechat->get_access_token();
        $data = ['type'=>$type,'offset'=>0,'count'=>20];
        $res = $this->wechat->post($url,json_encode($data));
        $data = json_decode($res, 1);

        $data = json_decode($res,1);
        return view('admin.wechat.upload_source',['data'=>$data]);
    }
    //删除永久素材
    public function del_source()
    {
        $media_id = $this->request->all();
        $url = 'https://api.weixin.qq.com/cgi-bin/material/del_material?access_token='.$this->wechat->get_access_token();
        $this->wechat->post($url,json_encode($media_id));
    }

    public function create_tag()
    {
        return view('admin.wechat.create_tag');
    }

    public function save_tag()
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/tags/create?access_token='.$this->wechat->get_access_token();
        $data = [
            'tag' => ['name'=>$this->request->all()['name']]
        ];
        $res = $this->wechat->post($url,json_encode($data,JSON_UNESCAPED_UNICODE));
        dd(json_decode($res,1));
    }
    //标签列表
    public function tag_list()
    {
       $data = $this->wechat->tag_list();
        $data = $data['tags'];
       return view('admin.wechat.tag_list',['data'=>$data]);
    }

    //删除标签
    public function del_tag()
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/tags/delete?access_token='.$this->wechat->get_access_token();
        $data = [
          'tag' => ['id' =>$this->request->all()['id']]
        ];
       $res =  $this->wechat->post($url, json_encode($data));
       $res = json_decode($res, 1);
        if ($res['errcode'] == 45058) {
            return '不能删除';
        }elseif ($res['errcode'] == 45057){
            return '该标签下粉丝数超过10w，不允许直接删除';
        } elseif ($res['errcode'] == 0) {
            return redirect('wechat/tag_list');
        }else{
            return '删除失败';
        }
    }
//为用户添加标签
    public function add_user_tag()
    {
        if (empty($this->request->all()['tag_id'])){
            return redirect('wechat/tag_list');
        }
        //接受选择的id
       $id = $this->request->all()['id_list'];
        $openid = DB::connection('mysql4')->table('wechat_openid')->whereIn('id', $id)->select('openid')->get()->toArray();
        $openid_list = [];
        foreach ($openid as $v) {
            $openid_list = $v->openid;
        }
        $url = 'https://api.weixin.qq.com/cgi-bin/tags/members/batchtagging?access_token='.$this->wechat->get_access_token();
        $data = [
            'openid_list' =>$openid_list,
            'tagid' => $this->request->all()['tag_id']
        ];
        $res = $this->wechat->post($url, json_encode($data));
        $res = json_decode($res, 1);
        if ($res['errcode'] == 0) {
            return redirect('wechat/tag_list');
        }
    }
    //标签下的粉丝列表
    public function tag_fans()
    {
        $tag_id = $this->request->all()['id'];
        $res = $this->wechat->tag_fans($tag_id);
        if ($res['count'] == 0) {
            return '该标签下暂无粉丝';
        }
        $openid = $res['data']['openid'];
        return view('admin.wechat.tag_fans',['openid'=>$openid]);
    }
//获取粉丝下的标签
    public function get_user_tag()
    {
      $openid = $this->request->all()['openid'];
      //得到用户下的标签
      $user_tag_info = $this->wechat->get_user_tag($openid);
      //获取所有标签信息
       $tag_info = $this->wechat->tag_list();
       $tags = $tag_info['tags'];
        foreach ($tags as $val) {
            foreach ($user_tag_info['tagid_list'] as $v) {
                if ($v == $val['id']) {
                    echo $val['name']."<a href=".env('APP_RUL').'/wechat/del_user_tag'.'?tag_id='.$v.'&openid='.$openid.">删除</a><p>";
                }
            }
        }
    }
    //取消用户下的标签
    public function del_user_tag()
    {
       $url = 'https://api.weixin.qq.com/cgi-bin/tags/members/batchuntagging?access_token='.$this->wechat->get_access_token();
        if (is_array($this->request->all()['openid'])) {
            $openid_list = [$this->request->all()['openid']];
        }else{
            $openid_list = $this->request->all()['openid'];
        }
        $data = [
            'openid_list' =>$openid_list,
            'tagid'       =>$this->request->all()['tag_id']
        ];
        $res = $this->wechat->post($url, json_encode($data));
        $res = json_decode($res, 1);
        if ($res['errcode'] ==0){
            return redirect('wechat/user_list');
        }else{
            return '删除失败';
        }
    }

    public function edit_tag()
    {
      $data = $this->request->all();
      return view('admin.wechat.edit_tag',['data'=>$data]);
    }
    public function update_tag()
    {
        $tag_id = $this->request->all()['id'];
        $url = 'https://api.weixin.qq.com/cgi-bin/tags/update?access_token='.$this->wechat->get_access_token();
        $data = [
            'tag' => ['id'=>$tag_id,'name'=>$this->request->all()['name']]
        ];
        $res = $this->wechat->post($url, json_encode($data,JSON_UNESCAPED_UNICODE));
        if (json_decode($res, 1)['errcode'] == 0) {
            return redirect('wechat/tag_list');
        }else{
            echo '修改失败';
        }
    }
    //根据标签推送消息
    public function push_tag_message()
    {
        if (empty($this->request->all()['id'])) {
            return redirect('wechat/tag_list');
        }
        //接受标签id
        $tag_id = $this->request->all()['id'];
        //查询标签下的粉丝
        $res = $this->wechat->tag_fans($tag_id);
        if ($res['count'] == 0) {
            return '该标签下暂无粉丝';
        }
        $openid = $res['data']['openid'];
        return view('admin.wechat.push_tag_message',['tag_id'=>$tag_id,'openid'=>json_encode($openid)]);
    }
    //执行标签群发消息
    public function do_push_tag_message()
    {
        //接受
        $push_type= $this->request->all()['push_type'];
        $tag_id= $this->request->all()['tag_id'];
        $media_id= $this->request->all()['media_id'];
        $message= $this->request->all()['message'];
        $res = $this->wechat->do_push_tag_message($push_type,$tag_id,$message,$media_id);
        dd($res);
    }

    public function event()
    {
//        echo $_GET['echostr'];die;
        $data = file_get_contents("php://input");
        //解析xml  转化为对象
        $postObj = simplexml_load_string($data);
//        dd(strtolower($postObj->Event));
//        dd($postObj->CreateTime);
//        $ii = date('Y-m-d H:i:s')."\n".$postObj->Event.'|'.strtolower($postObj->Event)."\n<<<<<";
//        \Log::info($ii);
        $log_str = date('Y-m-d H:i:s') . "\n" . $data . "\n<<<<<<<";
        file_put_contents(storage_path('logs/wx_event.log'),$log_str,FILE_APPEND);
//        var_dump($postObj->Event);die;
//        $message = '你好';
//        $postObj->ToUserName = '';
//        $postObj->FromUserName = '';
//        $postObj->CreateTime = '';
//        $postObj->MsgType = '';
//        $postObj->Event = '';
        //判断该数据包是否是订阅推送
        if (strtolower($postObj->MsgType) == 'event') {
            //如果是关注 subscribe事件
//            dd(strtolower($postObj->FromUserName));
            if (strtolower($postObj->Event) == 'subscribe') {
//                if (empty($postObj->EventKey)){
//                    \Log::info(1111);
//                    \Log::info($postObj->EventKey);
//                    $agent_code = explode('_',$postObj->EventKey)[1];
//                    $agent_info = DB::connection('mysql4')->table('user_agent')->where(['uid'=>$agent_code,'openid'=>$postObj->FromUserName])->first();
//                    if (empty($agent_info)) {
//                        DB::connection('mysql4')->table('user_agent')->insert([
//                            'uid' => $agent_code,
//                            'openid' => strtolower($postObj->FromUserName),
//                            'add_time' => time()
//                        ]);
//                    }
//                }
                $token = $this->wechat->get_access_token();
                $info = file_get_contents("https://api.weixin.qq.com/cgi-bin/user/info?access_token={$token}&openid={$postObj->FromUserName}&lang=zh_CN");
                $info = json_decode($info,1);
                \Log::info($info);
                //回复用户消息
                $toUser   = $postObj->FromUserName;
                $fromUser = $postObj->ToUserName;
                $time     = time();
                $msgType  = 'text';
                $content  = '欢迎'.$info['nickname'].'同学，感谢关注';
                $template = "<xml>
                              <ToUserName><![CDATA[%s]]></ToUserName>
                              <FromUserName><![CDATA[%s]]></FromUserName>
                              <CreateTime>%s</CreateTime>
                              <MsgType><![CDATA[%s]]></MsgType>
                              <Content><![CDATA[%s]]></Content>
                            </xml>";
                $info     = sprintf($template,$toUser,$fromUser,$time,$msgType,$content);
                \Log::info($info);
                echo $info;
//                $qian = DB::connection('mysql4')->table('jifen')->insert([
//                    'openid' => $toUser,
//                ]);

            }elseif($postObj->Event == 'CLICK' && $postObj->EventKey == 'love'){
                //回复用户消息
                \Log::info($postObj);
                $data = DB::connection('mysql4')->table('biaobai')->where('userOpenid',$postObj->FromUserName)->get();
                $msg = '';
//                \Log::info($data);
                if (empty($data)){
                    $msg = "赞无你的表白";
                }else{
                    foreach ($data as $k => $v){
                        if ($v->status == 2){
                            $v->userName = '匿名用户';
                        }
                        $msg .='收到'.$v->userName.'的表白：'."\n".$v->content."\n";
                    }
                }

                \Log::info($msg);
                $toUser   = $postObj->FromUserName;
                $fromUser = $postObj->ToUserName;
                $time     = time();
                $msgType  = 'text';
                $content  = $msg;
                $template = "<xml>
                              <ToUserName><![CDATA[%s]]></ToUserName>
                              <FromUserName><![CDATA[%s]]></FromUserName>
                              <CreateTime>%s</CreateTime>
                              <MsgType><![CDATA[%s]]></MsgType>
                              <Content><![CDATA[%s]]></Content>
                            </xml>";
                $info     = sprintf($template,$toUser,$fromUser,$time,$msgType,$content);
                \Log::info('1232'.$msg.'<<<<'.$info);
                echo $info;
            }elseif ($postObj->Event == 'CLICK' && $postObj->EventKey == 'qian'){
                $data = DB::connection('mysql4')->table('qian')->where('openid',$postObj->FromUserName)->first();
                if (empty($data)){
                   $uid = DB::connection('mysql4')->table('qian')->where('openid',$postObj->FromUserName)->insertGetId([
                        'openid' => $postObj->FromUserName,
                        'addtime' => time(),
                        'cishuo' =>1,
                        'qian' =>1
                    ]);
                    DB::connection('mysql4')->table('jifen')->insert([
                        'score' => 5,
                        'openid' => $postObj->FromUserName
                    ]);
                    $msg = '签到成功';
                    $msgType = 'text';
                    \Log::info('12221');
                    echo "<xml>
                              <ToUserName><![CDATA[".$postObj->FromUserName."]]></ToUserName>
                              <FromUserName><![CDATA[".$postObj->ToUserName."]]></FromUserName>
                              <CreateTime>".time()."</CreateTime>
                              <MsgType><![CDATA[".$msgType."]]></MsgType>
                              <Content><![CDATA[".$msg."]]></Content>
                            </xml>";
                }else{
                    \Log::info('12222');
                    //如果不到一天
                    $msg = '今日已签到';
                    $msgType = 'text';
                    if (($data->addtime) < ($data->addtime + 86400)){
                        echo "<xml>
                              <ToUserName><![CDATA[".$postObj->FromUserName."]]></ToUserName>
                              <FromUserName><![CDATA[".$postObj->ToUserName."]]></FromUserName>
                              <CreateTime>".time()."</CreateTime>
                              <MsgType><![CDATA[".$msgType."]]></MsgType>
                              <Content><![CDATA[".$msg."]]></Content>
                            </xml>";
                    }elseif (($data->cishuo) > 5 || ($data->addtime) > ($data->addtime + 172800)){
                        DB::connection('mysql4')->table('qian')->where('openid',$postObj->FromUserName)->update([
                            'addtime' => time(),
                            'cishuo' =>1,
                            'qian' =>1
                        ]);
                        $jf = DB::connection('mysql4')->table('qian')->where('openid',$postObj->FromUserName)->first();
                        DB::connection('mysql4')->table('qian')->where('openid',$postObj->FromUserName)->update([
                            'score' => ($jf->score)+5,
                        ]);
                    }else{
                        $jf = DB::connection('mysql4')->table('qian')->where('openid',$postObj->FromUserName)->first();
                        DB::connection('mysql4')->table('qian')->where('openid',$postObj->FromUserName)->update([
                            'addtime' => time(),
                            'cishuo' =>($data->cishuo)+1,
                            'qian' =>1
                        ]);
                        DB::connection('mysql4')->table('qian')->where('openid',$postObj->FromUserName)->update([
                            'score' => ($jf->score) * 5,
                        ]);
                    }
                }
            }elseif ($postObj->Event == 'CLICK' && $postObj->EventKey == 'score'){
                $jf = DB::connection('mysql4')->table('qian')->where('openid',$postObj->FromUserName)->first();
                $msg = '您的剩余积分'.$jf->score;
                $msgType = 'text';
                echo "<xml>
                              <ToUserName><![CDATA[".$postObj->FromUserName."]]></ToUserName>
                              <FromUserName><![CDATA[".$postObj->ToUserName."]]></FromUserName>
                              <CreateTime>".time()."</CreateTime>
                              <MsgType><![CDATA[".$msgType."]]></MsgType>
                              <Content><![CDATA[".$msg."]]></Content>
                            </xml>";
            }
        }elseif ($postObj->MsgType == 'text'){
                $preg = preg_match("/.*?油价/",$postObj->Content);
            if ($preg){
                $city = substr($postObj->Content,0,-6);
                $priceInfo = file_get_contents("http://www.wei678.top/api/index");
                $priceInfo = json_decode($priceInfo,1);
                $arr =[];
                foreach ($priceInfo['result'] as $key => $value){
                    $arr[] = $value['city'];
                }
                if (!in_array($city,$arr)){
                    $message = "赞无该城市油价";
                    echo "<xml>
                              <ToUserName><![CDATA[".$postObj->FromUserName."]]></ToUserName>
                              <FromUserName><![CDATA[".$postObj->ToUsreName."]]></FromUserName>
                              <CreateTime>".time()."</CreateTime>
                              <MsgType><![CDATA[text]]></MsgType>
                              <Content><![CDATA[".$message."]]></Content>
                          </xml>";
                    die();
                }
                foreach ($priceInfo['result'] as $key => $value){
                    if ($city == $value['city']){
                        $redis = new \Redis();
                        $redis->connect('127.0.0.1','6379');
                        $redis->incr($city);
                        $findNun = $redis->get($city);
                        if ($findNun > 10){
                           if ($redis->exists($city.'信息')){
                               $cityInfo = $redis->get($city.'信息');
                               $value = json_decode($cityInfo,1);
                           }else{
                               $redis->set($city.'信息',json_encode($value));
                           }
                        }
                        $message = $city."目前油价"."\n".'92h：'.$value['92h']."\n"."95h：".$value['95h']."\n"."98h：".$value['98h']."\n".'0h：'.$value['0h'];
                        echo "<xml>
                              <ToUserName><![CDATA[".$postObj->FromUserName."]]></ToUserName>
                              <FromUserName><![CDATA[".$postObj->ToUsreName."]]></FromUserName>
                              <CreateTime>".time()."</CreateTime>
                              <MsgType><![CDATA[text]]></MsgType>
                              <Content><![CDATA[".$message."]]></Content>
                          </xml>";
                    }
                }
            }
        }
    }
//获取临时二维码
    public function getTimeQrCode()
    {
        $uid = $this->request->all()['uid'];
        //获取ticket
        $access_token  = $this->wechat->get_access_token();
        $url = "https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=".$access_token;
        //{"expire_seconds": 604800, "action_name": "QR_SCENE", "action_info": {"scene": {"scene_id": 123}}}
        $postArr = [
            'expire_seconds' => 604800,
            'action_name'    => "QR_SCENE",
            'action_info'    => [
                'scene'      => [ 'scene_id' => $uid]
            ]
        ];
        $postJson = json_encode($postArr);
        $res = $this->wechat->post($url,$postJson);
        $res = json_decode($res,1);
        $ticket = $res['ticket'];
        //获取二维码  图片
        $url = "https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=".urlencode($ticket);
        $client   = new client();
        $response = $client->get($url);
        $res      = $response->getHeaders();
        //取出后缀名
        $ext   = explode('/',$res['Content-Type'][0])[1];
        $fileName = time().mt_rand(1000,9999).'.'.$ext;
        $path     = 'qrcode/'.$fileName;
        storage::disk('local')->put($path,$response->getBody());
        //拼接路径
        $qrcode_url = '/storage/'.$path;
        DB::connection('mysql4')->table('user')->where('id',$uid)->update([
           'agent_code' => $uid,
           'qrcode_url' => $qrcode_url
        ]);
        return redirect('wechat/agentUserList');


    }

    public function agentUserList()
    {
        $user = DB::connection('mysql4')->table('user')->get()->toArray();
        return view('admin.wechat.agentUserList',['user'=>$user]);
    }

    public function definedMenu()
    {
        $url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$this->wechat->get_access_token();
        $postArr = [
            'button'=>[
                    [
                        'name'=>'菜单一',
                        'type'=>'click',
                        'key'=>'item1'
                     ],//第一个一级菜单
                    [
                        'name'=>'菜单二',
                        'sub_button'=>[
                            [
                                'name'=>'音乐',
                                'type'=>'click',
                                'key'=>'music'
                            ], // 第二个二级菜单
                            [
                                'name'=>'电影',
                                'type'=>'view',
                                'url'=>'http://www.iqiyi.com/',
                            ], // 第二个二级菜单

                        ],
                    ],//第二个一级菜单
                    [
                        'name'=>'菜单三',
                        'type'=>'view',
                        'url'=>'http://www.qq.com',
                    ],//第三个一级菜单
                ]
        ];
//        dd($postArr);
        $postJson = json_encode($postArr,JSON_UNESCAPED_UNICODE);
       $res = $this->wechat->post($url,$postJson);
       dd($res);
    }

    public function getCateInfo($data,$pid=0,$lev=0)
    {
        static $info = [];
        foreach ($data as $k => $v){
            if ($v->pid==$pid){
                $v->lev=$lev;
                $info[]=$v;
               $this->getCateInfo($data,$v->id,$lev+1);
            }
        }
        return $info;
    }

    public function menuCreate()
    {
        $res = DB::connection('mysql4')->table('menu2')->where('pid',0)->get()->toArray();
        return view('admin.wechat.menuCreate',['res'=>$res]);
    }

    public function menuSave()
    {
        $data = $this->request->all();
        $m_key ='';
        $m_url ='';
        if($data['m_type'] == 'click'){
            $m_key = $data['select'];
        }else{
            $m_url = $data['select'];
        }
//        dd($data);
        $res = DB::connection('mysql4')->table('menu2')->insert([
            'm_name' => $data['m_name'],
            'm_type' => $data['m_type'],
            'pid'    => $data['pid'],
            'm_key'  => $m_key,
            'm_url'  => $m_url
        ]);
//        dd($res);
       $res = $this->reload_menu();
        dd($res);
    }
    //刷新菜单
    public function reload_menu()
    {

        /*$sub_button = [];
        foreach ($parent as $v){
             foreach ($dd as $val){
                 if ($val->pid == $v->id){
                     echo 11,"<br>";
//                     $name = DB::connection('mysql4')->table('menu2')->select(['m_name'])->where('id', $val->pid)->first();
                     if ($val->m_type == 'view'){
                         $sub_button[]=[
                             'name' => $val->m_name,
                             'type' => $val->m_type,
                             'url'  => $val->m_url,
                         ];
                     }else{
                         $sub_button[]=[
                             'name' => $v->m_name,
                             'type' => $v->m_type,
                             'key'  => $v->m_key,
                         ];
                     }
                 }
             }
        }*/
//        dd($data);
//        dd($sub_button);
        $parent = DB::connection('mysql4')->table('menu2')->where('pid',0)->orderBy('id','desc')->limit(3)->get()->toArray();
//        $dd = DB::connection('mysql4')->table('menu2')->get()->toArray();
        $sub_button = [];
        foreach ($parent as $val) {
//            dd($val);
            $menu_info = DB::connection('mysql4')->table('menu2')->where('pid', $val->id)->get()->toArray();
            if ($val->m_type == 'view'){
                $data['button'][] = [
                    'name' => $val->m_name,
                    'type' => $val->m_type,
                    'url' => $val->m_url,
                ];
            }else{
                $data['button'][] = [
                    'name' => $val->m_name,
                    'type' => $val->m_type,
                    'key' => $val->m_key,
                ];
            }
            foreach ($menu_info as $k => $v) {
               $name = DB::connection('mysql4')->table('menu2')->select(['m_name'])->where('id', $v->pid)->first();
                if ($v->m_type == 'view'){
                    $sub_button[] = [
                        'name' => $v->m_name,
                        'type' => $v->m_type,
                        'url' => $v->m_url,
                    ];

                }else{
                    $name = DB::connection('mysql4')->table('menu2')->select(['m_name'])->where('id', $v->pid)->first();
                    $sub_button[] = [
                        'name' => $v->m_name,
                        'type' => $v->m_type,
                        'key'  => $v->m_key,
                    ];
                }
            }
            }
        if (!empty($sub_button)){
            $data['button'][]=['name'=>$name->m_name,'sub_button'=>$sub_button];
        }
//         dd($data);
        $url = 'https://api.weixin.qq.com/cgi-bin/menu/create?access_token='.$this->wechat->get_access_token();
        $postJson = json_encode($data,JSON_UNESCAPED_UNICODE);
        $res = $this->wechat->post($url,$postJson);
        return $res;
//        $menu_info = DB::connection('mysql4')->table('menu')->get();
//        $data = $this->getCateInfo($menu_info);
//        dd($data);
        /*foreach ($menu_info as $val){
            $menu_list = DB::connection('mysql4')->table('menu')->where('m_name',$val->m_name)->get()->toArray();
            foreach ($menu_list as $v) {
                if ($v->pid == 0) { //一级菜单
//                    echo 1;die;
                    if ($v->m_type == 'view'){
                        $data['button'][] = [
                          'type'=>$v->m_type,
                          'name'=>$v->m_name,
                          'url'=>$v->m_url
                        ];
                    }else{
                        $data['button'][]=[
                            'type'=>$v->m_type,
                            'name'=>$v->m_name,
                            'key'=>$v->m_key
                        ];
                    }
                }else{ //二级菜单
                    $m_name = DB::connection('mysql4')->table('menu')->select('m_name')->where('id',$v->pid)->first();
                    if ($v->m_type == 'view') {
                       $sub_button = [
                           [
                             'name'=>$m_name->m_name,
                            'sub_button' => [
                                [
                                    'type'=>$v->m_type,
                                    'name'=>$v->m_name,
                                    'url'=>$v->m_url
                                ],

                            ]
                               ]
                        ];
                    }elseif($v->m_type=='media_id'){

                    }else{
                        $m_name = DB::connection('mysql4')->table('menu')->select('m_name')->where('id',$v->pid)->first();
                        $sub_button = [
                            [
                            'name'=>$m_name->m_name,
                            'sub_button'=>[
                                [
                                    'type'=>$v->m_type,
                                    'name'=>$v->m_name,
                                    'key'=>$v->m_key
                                ],

                            ]
                        ]
                        ];
                    }
                }
            }*/
            /*if (!empty($sub_button)) {
                $data['button']=$sub_button;
            }
            dd($data);
            $url = 'https://api.weixin.qq.com/cgi-bin/menu/create?access_token='.$this->wechat->get_access_token();
            $postJson = json_encode($data,JSON_UNESCAPED_UNICODE);
            $res = $this->wechat->post($url,$postJson);
            return $res;*/
//        }
    }



} //class end
