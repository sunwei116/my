<?php

namespace App\Http\Controllers\goods;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\model\Goods;

class GoodsController extends Controller
{
    //添加
    public function add()
    {
        $goods_name = request()->input('goods_name');
        $goods_price = request()->input('goods_price');
//        $goods_img = request()->file('file');
        if (empty($goods_name) || empty($goods_price)) {
            return json_encode(['code'=>301,'msg'=>'参数不能为空']);
        }
        $res = Goods::insert([
            'goods_name' => $goods_name,
            'goods_price' => $goods_price,
            'goods_img'  => $goods_img,
        ]);
        if ($res){
            return json_encode(['code'=>200,'msg'=>'添加成功']);
        }else{
            return json_encode(['code'=>302,'msg'=>'添加失败']);
        }
    }
}
