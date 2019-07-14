<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TeacherController extends Controller
{
    public function index()
    {
        return '123';
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