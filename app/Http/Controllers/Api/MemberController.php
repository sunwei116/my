<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Member;

class MemberController extends Controller
{
    //查询数据库
    public function lists()
    {
        $data = Member::get()->toArray();
        return json_encode($data,JSON_UNESCAPED_UNICODE);

    }

    public function create()
    {
        $name = request()->get('name');
        $age = request()->get('age');

        if (empty($age) || empty($name)){
            return json_encode(['code'=>201,'msg'=>'参数不能为空']);
        }
     $res = Member::insert([
            'name' => $name,
            'age' => $age
        ]);
        if ($res) {
            return json_encode(['code'=>200,'msg'=>'添加成功']);
        }else{
            return json_encode(['code'=>202,'msg'=>'添加失败']);
        }
    }

    public function bbb()
    {
        echo md6('eweww');
        echo 11;
    }

    public function ppp()
    {
        
    }
}
