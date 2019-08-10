<?php

namespace App\Http\Controllers\survey;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
class SurveyController extends Controller
{

    public function login(Request $request)
    {
        return view('survey.login');
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
            return redirect('survey/index');
        }else{
            echo '账号密码错误';
        }
    }
    public function index()
    {
        return view('survey.index');
    }

    public function issue(Request $request)
    {
      $name = $request->all()['name'];
      if (!$name){
          echo "请选择问题";die;
      }
      $id = DB::table('survey')->insertGetId(['survey'=>$name]);
      if ($id){
          return view('survey.create',['id'=>$id]);
      }else{
          echo '添加失败';
      }
    }

    public function create()
    {
        return view('survey/create');
    }

    public function wenti(Request $request)
    {
        $data = $request->all();
        return view('survey.wenti',['data'=>$data]);
    }

    public function save(Request $request)
    {
        $data = $request->all();
        unset($data['_token']);
        if (empty($data['result'])){
            $data['result']=$data['res'];
            unset($data['res']);
            $res = DB::table('issue')->insert($data);
        }else{
            $data['result'] = implode($data['result'],',');
            $res = DB::table('issue')->insert($data);
        }
        if ($res){
            return redirect('survey/lists');
        }
    }

    public function lists()
    {
       $data = DB::table('survey')->paginate(5);
       return view('survey.lists',['data'=>$data]);
    }

    public function delete(Request $request)
    {
      $id = $request->all()['id'];
        DB::beginTransaction();
            $res1 = DB::table('survey')->where('id', $id)->delete();

            $res2 = DB::table('issue')->where('sid', 30)->delete();
           if ($res1 && $res2){
               DB::commit();
               echo 1;
           }else{
               DB::rollBack();
               echo 0;
           }
    }

    public function check(Request $request)
    {
        $id = $request->all()['id'];
        $survey = DB::table('survey')->where('id', $id)->first();
        $issue = DB::table('issue')->where('sid', $id)->first();
        return view('survey.check',['survey'=>$survey,'issue'=>$issue]);
    }
}
