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
        echo $name,$age;

    }
}
