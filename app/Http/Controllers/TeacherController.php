<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TeacherController extends Controller
{
    public function index()
    {
        $pos = 'gmt_create=2019-07-19+17%3A17%3A55&charset=utf-8&gmt_payment=2019-07-19+17%3A18%3A05&notify_time=2019-07-19+17%3A18%3A07&subject=test+subject+-+%E6%B5%8B%E8%AF%95&sign=GqGUMed1JecUjJZkmjECEmScjnaWYLCxgJqIRE7155g2wvx3MA1CJrudbEwxzkq%2BZUMF0ndToNROJKj08FLhJD%2FFe1%2FG95QNnvu9Pxbocep7o8oO0Swd1Lgbhux%2FL5lfO05tFQwNNmByRzDJG0jLiBPVV8Du2ma%2BVOR6VaK%2FrPRcjGq117k%2BEFbMJmEvEPTzxobUmolauAc%2BgYu92tG8rkSL1SKbQlOUcljvkWhT6iG3yitkPGaffja4IgQfLUzlT48CPm2dJ6GanzfieCI%2FjBMLRxoF%2Fb%2BaOQtAckfOXvoLX4SShAZLhEW1UDOJsj63mfIe1Pljaz9cRCBjxqwACA%3D%3D&buyer_id=2088102178910564&invoice_amount=10122.00&version=1.0&notify_id=2019071900222171806010561000411188&fund_bill_list=%5B%7B%22amount%22%3A%2210122.00%22%2C%22fundChannel%22%3A%22ALIPAYACCOUNT%22%7D%5D&notify_type=trade_status_sync&out_trade_no=1563527831649393&total_amount=10122.00&trade_status=TRADE_SUCCESS&trade_no=2019071922001410561000036051&auth_app_id=2016101100657610&receipt_amount=10122.00&point_amount=0.00&app_id=2016101100657610&buyer_pay_amount=10122.00&sign_type=RSA2&seller_id=2088102179020628';
        $pos = explode('&',$pos);
        print_r($pos);
    }
    public function text1()
    {
//       $teacher = DB::select('select * from teacher');
//       var_dump($teacher);
       $bool = DB::insert('insert into teacher(name,age) values(?,?)',
        ['sean',18]);
       var_dump($bool);
    }
    public function goods()
    {
       return view('app');
    }
    public function addGoods(Request $request)
    {
        $path = $request->file('goods_pic');
        if (empty($path)){
            echo '请选择文件';die;
        }else{
            $path->store('goods');
        }
        echo  'storage'.'/'.$path;

    }
}