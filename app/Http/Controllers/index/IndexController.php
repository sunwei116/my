<?php

namespace App\Http\Controllers\index;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    public function index()
    {
        $data = DB::connection('mysql2')->table('goods')->get();
        return view('index.index.index',['data' => $data]);

    }
}
