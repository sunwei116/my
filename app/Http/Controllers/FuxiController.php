<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FuxiController extends Controller
{
    public function denglu()
    {
        return view('fuxi.denglu');
    }

    public function do_denglu(Request $request)
    {
       $data = $request->all();
    }

    public function create()
    {
        return view('fuxi.create');
    }

    public function save(Request $request)
    {
        $data = $request->all();
        $res = DB::connection('fuxi')->table('student')->insert([
            'sex' => $data['sex'],
            'age' => $data['age'],
            'name' => $data['name'],
            'class' => $data['class']
        ]);
        if ($res){
            return redirect('lists');
        }else{
            echo '添加失败';
        }
    }

    public function lists()
    {
        $data = DB::connection('fuxi')->table('student')->get();
        return view('fuxi.lists',['data'=>$data]);
    }

    public function delete(Request $request)
    {
       $id = $request->id;
       $res = DB::connection('fuxi')->table('student')->delete($id);
       if ($res){
           echo "<script>alert('删除成功');history.back(-1)</script>";
       }else{
           echo "<script>alert('删除失败');history.back(-1)</script>";
       }
    }

    public function edit(Request $request)
    {
       $id = $request->id;
       $time = date('Y-m-d H:i:s',1567094400);
//       $time = strtotime($time);
       dd($time);
    }
}
