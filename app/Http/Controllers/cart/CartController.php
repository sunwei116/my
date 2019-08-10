<?php

namespace App\Http\Controllers\cart;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class CartController extends Controller
{

    public function login(Request $request)
    {
        return view('cart.login');
    }

    public function doLogin(Request $request)
    {
        $user = $request->all();
        $data = DB::table('user')->where(['account'=>$user['account']])->first();
        if (!$data){
            echo '账号不存在';die;
        }
        if ($user['pwd'] == $data->pwd){
            $status = $data->status;
            if ($status == 1){
                session(['user'=>$data]);
                return redirect('cart/wuye');
            }else{
                session(['user'=>$data]);
                return redirect('cart/index');
            }

        }else{
            echo '账号密码错误';
        }
    }

    public function index()
    {
        $redis = new \Redis();
        $redis->connect('127.0.0.1','6379');
        $chewei =  $redis->get('cart');
        return view('cart.index',['chewei'=>$chewei]);
    }
    public function wuye()
    {
//        $data = DB::select("select FROM_UNIXTIME(del_time,'%Y-%m-%d') as shijian,sum(price) from cart group by FROM_UNIXTIME(del_time,'%Y-%m-%d')");

        return view('cart.wuye');
    }
    public function shujv()
    {
        $data = DB::select("select FROM_UNIXTIME(del_time,'%Y-%m-%d') as shijian,sum(price) as price  from cart group by FROM_UNIXTIME(del_time,'%Y-%m-%d')");

        return view('cart.shujv',['data'=>$data]);
    }
    public function register()
    {
        return view('cart.register');
    }
    public function do_register(Request $request)
    {
       $data = $request->all();
      $res =  DB::table('user')->insert([
           'account' => $data['account'],
           'pwd' => $data['pwd'],
           'status' => 2
       ]);
      if ($res){
          return redirect('cart/login');
      }else{
          echo '注册失败';
      }

    }

    public function create()
    {
        return view('cart.create');
    }
    public function save(Request $request)
    {
        $redis = new \Redis();
        $redis->connect('127.0.0.1','6379');
        $num = $redis->get('cart');
        if ($num){
            $cart_num = $request->all()['cart_num'];
            $res = DB::table('cart')->insert([
                'cart_num' =>$cart_num,
                'add_time' =>time(),
                'status' => 1,
                'price' => 0,
            ]);
            if($res){
                $redis->set('cart',$num-1);
                echo "<script>alert('入库成功')</script>";
                return redirect('cart/index');
            }
        }else{
            return '车位已满';
        }

    }

    public function edit()
    {
        return view('cart.edit');
    }

    public function do_edit(Request $request)
    {
        $cart_num = $request->all()['cart_num'];
        $data = DB::table('cart')->where(['cart_num'=>$cart_num,'status'=>1])->first();
        if ($data){
            $add_time = $data->add_time;
            if ((time()-$add_time)<900){
                $price = 0;
                $time=time()-$add_time;
               $mins = ceil($time / 60);
                $hours=0;
            /* $res =  DB::table('cart')->where('id',$data->id)->update([
                    'del_time' => time(),
                    'status' => 2,
                    'price' =>0
                ]);*/
            }elseif ((time() - $add_time)>900 && (time()-$add_time)<21600){
                $time = time()-$add_time;
                if ($time > 3600){
                    $h = floor($time/3600);
                    $hours = $h;
                    $remain = $time%3600;
                    $mins = ceil($remain / 60);
                    $h = $time/3600;
                    $i=ceil($h*2)*2;
                    $price =$i;
                }elseif($time <1801 ) {
                    $price = 2;
                    $h = 0;
                    $mins = ceil($time / 60);
                 }else{
                    $h=0;
                    $price = 4;
                    $mins = ceil($time / 60);
                }

               /* $res = DB::table('cart')->where('id',$data->id)->update([
                    'del_time' => time(),
                    'status' => 2,
                    'price' =>$i
                ]);*/
            }else{
                $time=time();
                //6小时之后的价钱
                $t = time()-$add_time;
               $h = floor($t/3600);
               $hours = $h;
                $remain = ($t%3600);
                $mins = ceil($remain / 60);
                $m = ceil(($t-21600)/3600);
                $price = $m+24;
              /*$res = DB::table('cart')->where('id',$data->id)->update([
                    'del_time' => time(),
                    'status' => 2,
                    'price' =>$m+24
                ]);*/
            }
            return view('cart/do_edit',['cart'=>$data->cart_num,'price'=>$price,'h'=>$hours,'m'=>$mins,'time'=>time(),'id'=>$data->id]);
        }else{
            return '车库没有此车辆';
        }
    }
    public function update(Request $request)
    {
        $data = $request->all();
        $res = DB::table('cart')->where('id',$data['id'])->update([
            'del_time' =>$data['time'],
            'status' => 2,
            'price' =>$data['price']
        ]);
        if ($res){
            $redis = new \Redis();
            $redis->connect('127.0.0.1','6379');
            $num = $redis->get('cart');
            $redis->set('cart',$num+1);
            return redirect('cart/index');
        }else{
            echo '缴费失败';
        }

    }
}
