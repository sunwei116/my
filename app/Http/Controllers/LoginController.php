<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/7/7
 * Time: 18:46
 */

namespace App\Http\Controllers;


use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login()
    {
//        return 'Member-info-id-' . $id;
        return view('login');

    }

    public function doLogin(Request $request)
    {

        $data = $request->all();
        $request->session()->put('info',$data);
       return redirect('/student/index');
    }
}