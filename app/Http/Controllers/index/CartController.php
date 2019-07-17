<?php

namespace App\Http\Controllers\index;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function index(Request $request)
    {
//        接受首页加入购物车的gid
        $gid = $request->all()['gid']??'';
        if (empty($gid)){
            return redirect('/index/index/index');
        }
        $user = session('info');
        if (!$user){
           echo json_encode(0);die();
        }
        $where = [
            'uid' => $user->uid,
            'goods_id' => $gid
        ];
        $res = DB::connection('mysql2')->table('cart')->where($where)->first();
        if ($res){
          $res =  DB::connection('mysql2')->table('cart')->where('id',$res->id)->update(['goods_num'=>$res->goods_num+1]);
        }else{
            $goods = DB::connection('mysql2')->table('goods')->where('id',$gid)->first();
            $arr = [
                'uid' => $user->uid,
                'goods_id' => $goods->id,
                'goods_price' => $goods->goods_price,
                'goods_name' => $goods->goods_name,
                'goods_pic' => $goods->goods_pic,
                'add_time' => time(),
                'goods_num' => 1
            ];
            $res = DB::connection('mysql2')->table('cart')->insert($arr);
        }
       if ($res){
           echo json_encode('加入购物车成功');
       }else{
           echo json_encode('加入购物车失败');
       }
    }
//购物车列表
    public function lists()
    {
        $user = session('info');
        if (!$user){
            return redirect('/index/login');
        }
        $goods = DB::connection('mysql2')->table('cart')->where('uid',$user->uid)->get();
        $g = $goods->toArray();
       $price = array_column($g,'goods_price');
       $id = array_column($g,'id');
       $gid = implode($id,',');
       $sum = array_sum($price);
        return view('index/cart/lists',['goods' => $goods, 'sum'=>$sum,'gid'=>$gid]);
    }
}
