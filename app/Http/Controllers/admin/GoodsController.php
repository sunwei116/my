<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
class GoodsController extends Controller
{
    public function lists()
    {
        $goods = DB::connection('mysql2')->table('goods')->paginate(2);
        return view('admin.goods.lists',['goods' => $goods]);
    }

    public function create()
    {
        return view('admin/goods/create');
    }

    public function save(Request $request)
    {
       $data = $request->all();
        $validatedData = $request->validate([
            'goods_name' => 'required',
            'goods_price' => 'required',
            'goods_pic' => 'required',
        ],[
            'goods_name.required' => '商品名称不能为空',
            'goods_price.required' => '商品价格不能为空',
            'goods_pic.required' => '请上传商品图片'
        ]);
        $res = DB::connection('mysql2')->table('goods')->insert([
            'goods_name' => $data['goods_name'],
            'goods_pic' => '/'.$data['goods_pic'],
            'goods_price' => $data['goods_price'],
            'add_time' => time()
        ]);
        if($res){
            echo json_encode(['msg' => '添加成功', 'icon' => 6, 'code' => 1]);
        }else{
            echo json_encode(['msg' => '添加失败', 'icon' => 5, 'code' => 1]);
        }
    }

    public function upload(Request $request)
    {
        $file = $request->file('file');
        $path = $file->store('goods');
        echo json_encode(['path'=>'storage'.'/'.$path, 'code' => 1, 'msg' => '上传成功']);
    }



    public function edit(Request $request)
    {
        $id = $request->all();
        $goods = DB::connection('mysql2')->table('goods')->where('id',$id)->first();
        return view('admin/goods/edit', ['goods' => $goods]);
    }

    public function update(Request $request)
    {
       $data = $request->all();
       $goods_pic = DB::connection('mysql2')->table('goods')->select('goods_pic')->first($data['id']);
        if (empty($data['goods_pic'])) {
            unset($data['goods_pic'],$data['_token'],$data['file']);
        }else{
            unset($data['_token'],$data['file']);
        }
        $res = DB::connection('mysql2')->table('goods')->where('id',$data['id'])->update($data);
        if ($res){
            echo json_encode(['msg'=>'修改成功','icon'=>6,'code'=>1]);
        }else{
            echo json_encode(['msg'=>'修改失败','icon'=>5,'code'=>0]);
        }

    }


    public function delete()
    {

    }

}
