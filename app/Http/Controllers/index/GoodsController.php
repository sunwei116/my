<?php

namespace App\Http\Controllers\index;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class GoodsController extends Controller
{
    public function lists(Request $request)
    {
        $id = $request->all()['id'];
        $goods = DB::connection('mysql2')->table('goods')->where('id',$id)->first();
        return view('index/goods/lists',['goods' =>$goods]);
    }
}
