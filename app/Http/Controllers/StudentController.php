<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $data = DB::connection('mysql2')->table('wen')->get()->toArray();
        dd($data);
        $redis = new \Redis();
        $redis->connect('127.0.0.1','6379');
        $redis->incr('num');
        $num = $redis->get('num');
        echo '你的访问次数：'.$num;
       $search = $request->all();
//       dd($search);
        $sear = '';

       if (!empty($search['search'])){
           $sear = $search['search'];
           $info = DB::table('student')->where('name','like',"%{$search['search']}%")->paginate(2);
       }else {
           $info = DB::table('student')->paginate(2);
       }
       return view('studentList',['student'=>$info,'search'=>$sear]);
    }

    public function create()
    {
        return view('studentCreate',[]);
    }
    public function save(Request $request)
    {
        $data = $request->all();
        unset($data['_token']);
        $validatedData = $request->validate([
            'name' => 'required',
            'age' => 'required',
            'sex' => 'required',
            'content' => 'required'
        ],[
            'name.required' => '用户名不可以为空',
            'age.required' => '年龄不可以为空',
            'sex.required' => '性别不可以为空',
            'content.required' => '介绍不可以为空'
        ]);
//        dd($data);die;
        $res = Db::table('student')->insert($data);
        if ($res){
            return redirect('student/index');
        }else{
            echo '添加失败';
        }
    }
    //删除
    public function delete(Request $request)
    {
        $id = $request->all();
        $res = Db::table('student')->delete($id);
        if ($res){
            return redirect('student/index');
        }
    }
    //修改
    public function edit(Request $request)
    {
        $id = $request->all();
        $data = Db::table('student')->where('id',$id)->first();
        return view('studentEdit',['data'=>$data]);
    }
//执行修改
    public function update(Request $request)
    {
        $data = $request->all();
        unset($data['_token']);
        $res = Db::table('student')->where('id',$data['id'])->update($data);
        if ($res){
            return redirect('/student/index');
        }else{
            echo '修改失败';
        }

    }

}
