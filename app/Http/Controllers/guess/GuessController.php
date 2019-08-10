<?php

namespace App\Http\Controllers\guess;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class GuessController extends Controller
{
    public function index()
    {
        return view('guess.index');
    }

    public function save(Request $request)
    {
        $data = $request->all();
        if ($data['team1'] == $data['team2']){
            return '两只队伍不能一样';
        }
        $data['add_time'] = strtotime($data['add_time']);
        $dd = mt_rand(1,3);
        $data['result']=$dd;
        unset($data['_token']);
        $res = DB::table('guess')->insert($data);
        if ($res){
            return redirect('guess/lists');
        }
    }

    public function lists()
    {
        $data = DB::table('guess')->get()->toArray();
        return view('guess.lists',['data'=>$data]);
    }

    public function result(Request $request)
    {
       $id = $request->all()['id'];
       $data = DB::table('guess')->where('id',$id)->first();
       return view('guess.result',['data'=>$data]);
    }

    public function guess(Request $request)
    {
      $id = $request->all()['id'];
      $data = DB::table('guess')->where('id',$id)->first();
        return view('guess.guess',['data'=>$data]);
    }

    public function do_guess(Request $request)
    {
      $data = $request->all();
        $time = DB::table('guess')->where('id',$data['id'])->first();
        if (time() > $time->add_time){
            return '抱歉！竞猜已结束';
        }
      $res = DB::table('guess')->where('id',$data['id'])->update([
          'guess' => $data['guess']
      ]);
        if ($res){
            return redirect()->action('guess\GuessController@result',['id'=>$data['id']]);
        }
    }
}
