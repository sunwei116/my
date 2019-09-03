<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Member;

class MemberController extends Controller
{
    //查询数据库
    public function info()
    {
        $data = Member::get()->toArray();
        return json_encode($data,JSON_UNESCAPED_UNICODE);

    }

    public function show()
    {
        
    }
}
