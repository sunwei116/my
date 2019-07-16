<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/7/7
 * Time: 18:46
 */

namespace App\Http\Controllers;



use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GoodsController extends Controller
{
    public function index(Request $request)
    {
        $redis = new \Redis();
        $redis->connect('127.0.0.1','6379');
        $redis->incr('num');
        $num = $redis->get('num');
        echo '你的访问次数：'.$num;
        $data = $request->all();
        $ss = '';
        if (empty($data['ss'])){
            $goods = DB::table('goods')->paginate(2);
        }else{
            $ss = $data['ss'];
            $goods = DB::table('goods')->where('name','like',"%{$ss}%")->paginate(2);
        }

        return view('goodsIndex',['goods'=>$goods,'ss'=>$ss]);
    }

    public function create()
    {
        return view('goodsCreate');
    }

    public function save(Request $request)
    {
       $file = $request->file('pic');
        $validatedData = $request->validate([
            'name' => 'required',
            'pic' => 'required',
            'store' => 'required',
        ],[
            'name.required' => '名字不能为空',
            'pic.required' => '图片不能为空',
            'store.required' => '库存不能为空',
        ]);
        if (empty($file)) {
            echo '请选择图片';die();
        }else{
           $path = $file->store('goods');
        }
       $data = $request->all();
        $res = DB::table('goods')->insert([
            'name' => $data['name'],
            'pic' => '/storage'.'/'.$path,
            'store' => $data['store'],
            'add_time' => time()
        ]);
        if ($res){
            return redirect('/goods/index');
        }else{
            echo '添加失败';
        }
    }

    public function edit(Request $request)
    {
        $id = $request->all()['id'];
        $goods = DB::table('goods')->where('id',$id)->first();
        return view('goodsEdit',['goods'=>$goods]);
    }
    public function update(Request $request)
    {
        $data = $request->all();
        $file = $request->file('pic');
        if (empty($file)){
            $res = DB::table('goods')->update([
                'name' => $data['name'],
                'store' => $data['store'],
                'add_time' => time()
            ]);
            if ($res){
                return redirect('/goods/index');
            }else{
                echo '修改失败';
            }
            die();
        }
           $path = $file->store('goods');
            $res = DB::table('goods')->update([
                'name' => $data['name'],
                'pic' => '/storage'.'/'.$path,
                'store' => $data['store'],
                'add_time' => time()
            ]);

            if ($res){
                return redirect('/goods/index');
            }else{
                echo '修改失败';
            }
    }

    public function delete(Request $request)
    {
        $id = $request->all();
        $res = DB::table('goods')->where('id',$id)->delete();
        if ($res){
            return redirect('/goods/index');
        }else{
            echo '删除失败';
        }
    }
}