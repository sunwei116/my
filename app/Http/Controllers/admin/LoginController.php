<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    public function login()
    {
        return view('admin/login/login');
    }

    public function doLogin(Request $request)
    {
      $data = $request->all();
      dd($data);
    }

    public function register()
    {
        return view('admin/login/register');
    }

    public function doRegister(Request $request)
    {
        $data = $request->all();
        $validatedData = $request->validate([
            'name' => 'required',
            'password' => 'required',
            'email' => 'required',
        ],[
            'name.required' => '账号不能为空',
            'password.required' => '密码不能为空',
            'email.required' => '邮箱不能为空'
        ]);
        $res = DB::connection('mysql2')->table('user')->insert([
            'name' => $data['name'],
            'password' => $data['password'],
            'email' => $data['email'],
            'reg_time' => time()
        ]);
        if ($res){
            return redirect('admin/login/login');
        }else{
            echo '注册失败';
        }

    }
}
