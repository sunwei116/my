<?php

namespace App\Http\Controllers\liu;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class LiuController extends Controller
{
    public function login()
    {
        return view('liu/login');
    }
    public function do_login(Request $request)
    {
       $data = $request->all();
        $user = DB::table('user')->where(['account'=>$data['account']])->first();
        if (!$user){
            return '账号密码错误1';
        }
        if ($user->pwd == $data['pwd']) {
            session(['user'=>$user]);
            return redirect('liu/lists');
        }else{
            return '账号密码错误2';
        }
    }

    public function lists(Request $request)
    {
        $redis = new \Redis();
        $redis->connect('127.0.0.1','6379');
        $redis->incr('kan');
        $kan = $redis->get('kan');
        echo '浏览了'.$kan.'次';

        if (!session('user')) {
            return redirect('liu/login');
        }
        $ss = $request->all();
        if(empty($ss['sou'])){
            $data = DB::table('liu')->get()->toArray();
            foreach ($data as $k => $v) {
                $v->add_time = date("Y-m-d H:i:s",$v->add_time);
            }
        }else{
            $data = DB::table('liu')->where('name',$ss)->get()->toArray();
        }

        return view('liu.lists',['data'=>$data]);
    }

    public function create(Request $request)
    {
       $user = session('user');
        if (!$user){
            return redirect('liu/login');
        }
        $data = $request->all();
        $res = DB::table('liu')->insert([
            'content' =>$data['content'],
            'name' =>$user->account,
            'add_time' =>time(),
            'uid' =>$user->id
        ]);
        if ($res){
            return redirect('liu/lists');
        }else{
            echo '留言失败';
        }
    }

    public function delete(Request $request)
    {
        $id = $request->all()['id'];
        if (!session('user')){
            return redirect('liu/login');
        }
        $res = DB::table('liu')->where(['id'=>$id,'uid'=>session('user')->id])->first();
        if (empty($res)){
            return '只能删除自己的留言！！';
        }
        $time = $res->add_time;
        if ((time() - $time) > 1800){
            return '留言超过了半小时，不能删除！';
        }else{
            DB::table('liu')->where('id',$id)->delete();
            return redirect('liu/lists');
        }

    }

    public function index(Request $request)
    {
        if (empty($request->all()['access_token'])) {
            return '没有';
        }
        echo 1111;
    }
}
