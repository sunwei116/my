<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FareController extends Controller
{
    public function lists(Request $request)
    {
        $redis = new \Redis();
        $redis->connect('127.0.0.1','6379');
        $ss = $request->all();
        $aa = '';
        if (!$redis->exists('data')){
            if (empty($ss)){
                $data = DB::table('fare')->get()->toArray();
                $data = json_decode(json_encode($data),true);
                echo 333;
            }else{
                $redis->incr('num');
                $num = $redis->get('num');
                echo '搜索了'.$num.'次';
                $aa =$ss['ss'];
                $data = DB::table('fare')->where('depart','like',"%{$aa}%")->orwhere('arrive','like',"%{$aa}%")->get()->toArray();
                $data = json_decode(json_encode($data),true);
                if ($num > 5){
                    $data = json_encode($data);
                    echo 444;
                    $redis->set('data',$data,1800);
                    $data = json_decode($redis->get('data'),1);
                }
            }
        }else{
            echo 111;
            $data = json_decode($redis->get('data'),1);
//            dd($data);
        }
//        dd($data);
        return view('fare/lists',['data'=>$data,'ss'=>$aa]);
    }

    public function create()
    {
        return view('fare/create');
    }

    public function save(Request $request)
    {
       $data = $request->all();
       unset($data['_token']);
       $data['dtime']=strtotime($data['dtime']);
       $data['atime']=strtotime($data['atime']);
       $res = DB::table('fare')->insert([
           'checi' => $data['checi'],
           'depart' => $data['depart'],
           'arrive' => $data['arrive'],
           'price' => $data['price'],
           'num' => $data['num'],
           'dtime' => $data['dtime'],
           'atime' => $data['atime']
       ]);
        if ($res){
            return redirect('fare/lists');
        }else{
            echo '添加失败';
        }
    }
}
