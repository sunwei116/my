<?php

namespace App\Http\Controllers\exam;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ExambController extends Controller
{
    public function login(Request $request)
    {
        return view('exam.login');
    }

    public function doLogin(Request $request)
    {
        $user = $request->all();
        $data = DB::table('user')->where(['account'=>$user['account']])->first();
        if (!$data){
            echo '账号不存在';die;
        }
        if ($user['pwd'] == $data->pwd){
           session(['user'=>$data]);
            return redirect('exam/index');
        }else{
            echo '账号密码错误';
        }
    }

    public function index(Request $request)
    {
        return view('exam/index');
    }

    public function ti(Request $request)
    {
        $data = $request->all();
        return view('exam/ti',['data'=>$data]);
    }

    public function doti(Request $request)
    {
        $data = $request->all();
        unset($data['_token']);
       $res = DB::table('ti')->insert($data);
        if ($res) {
            return redirect('exam/tianjia');
        }else{
            echo '失败';
        }
    }

    public function tianjia()
    {
        return view('exam.tianjia');
    }

    public function shengcheng(Request $request)
    {
       $ming = $request->all()['ming'];
       if (empty($ming)){
           echo '请输入试卷名称';die();
       }
      $ti = DB::table('ti')->get()->toArray();

       return view('exam/shengcheng',['ming'=>$ming,'ti'=>$ti]);

    }

    public function save(Request $request)
    {
       $data = $request->all()['id'];
       $ming = $request->all()['ming'];
      $tid = implode($data,',');
      $res = DB::table('shijuan')->insertGetId([
          'ming' => $ming,
              'tid' => $tid
          ]);
      if ($res){
        echo $res;
      }

    }

    public function lists(Request $request)
    {
        $id= $request->all()['id'];
        $shi = DB::table('shijuan')->where('id',$id)->first();
        $aa[] = explode(',',$shi->tid);
       foreach ($aa as $v){
           foreach ($v as $val){
               $bb[]= $val;
           }
       }
      $res =  DB::table('ti')->whereIn('id',$bb)->get()->toArray();
       return view('exam/lists',['data'=>$res,'ming'=>$shi->ming]);
    }
}
