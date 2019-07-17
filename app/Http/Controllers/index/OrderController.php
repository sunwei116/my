<?php

namespace App\Http\Controllers\index;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    //生成订单
    public function confirmOrder(Request $request)
    {
        if (!session('info')){
            return redirect('index/login');
        }
        $data = $request->all();
        $arr = [
            'oid' => time().rand(100000,999999),
            'uid' => session('info')->uid,
            'pay_money' => $data['sum'],
            'status' => 1,
            'pay_time' => 0,
            'add_time' => time()
        ];
        //生成订单返回id
       $id = DB::connection('mysql2')->table('order')->insertGetId($arr);
        $oid = DB::connection('mysql2')->table('order')->where('id',$id)->select('oid')->first();
        $car = DB::connection('mysql2')->table('cart')->where(['uid'=>session('info')->uid],['goods_id'=>$data['gid']])->get()->toArray();
        foreach($car as $k =>$v){
            DB::connection('mysql2')->table('order_detail')->insert([
                'oid' => $oid->oid,
                'goods_id' => $car[$k]->goods_id,
                'goods_name' => $car[$k]->goods_name,
                'goods_pic' => $car[$k]->goods_pic,
                'add_time' => time()
            ]);
        }
        return redirect()->action('index\OrderController@orderList',['oid'=>$oid->oid,'price'=>$data['sum']]);
    }
    //确认订单
    public function orderList(Request $request)
    {

        if (!session('info')){
            return redirect('index/login');
        }
        $oid = $request->all()['oid'];
        $price = $request->all()['price'];
       $data = DB::connection('mysql2')->table('order_detail')->where('oid',$oid)->get()->toArray();
        return view('/index/order/orderList',['data' =>$data,'price'=>$price,'oid'=>$data[0]->oid]);
    }
}
