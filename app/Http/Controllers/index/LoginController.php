<?php

namespace App\Http\Controllers\index;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    public function login()
    {
        return view('index.login');
    }

    public function doLogin(Request $request)
    {
        $data = $request->all();
       $info = DB::connection('mysql2')->table('user')->where('name',$data['name'])->first();
       if($info){
           if ($data['password'] !=$info->password){
                echo '密码错误';
           }else{
               session(['info'=>$info]);
               return redirect('index/index/index');
           }
       }else{
           echo '账号错误！';
       }

    }

    public function register()
    {
        return view('index.register');
    }
    public function doRegister(Request $request)
    {
        $data = $request->all();
//        dd($data);
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required'
        ],[
            'name.required' => '用户名不可以为空',
            'email.required' => '年龄不可以为空',
            'password.required' => '密码不可以为空'
        ]);
       $count = DB::connection('mysql2')->table('user')->where('name',$data['name'])->count();
       if ($count){
           echo '用户名已被注册';die();
       };
        $res = DB::connection('mysql2')->table('user')->insert([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'reg_time' => time()
        ]);
        if ($res){
            return redirect('/index/login');
        }else{
            echo '注册失败';
        }
    }
}
