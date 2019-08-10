<?php

namespace App\Http\Controllers\identity;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IdentityController extends Controller
{
    public function index()
    {
        /*$path = "http://api.map.baidu.com/geocoder/v2/?address=美国洛杉矶&output=json&ak=CxF13N48UHZ12G8sIVpa2YTG";
        $p = file_get_contents($path);
        $p = json_decode($p,1);*/
        return view('identity.index');
    }

    public function pp(Request $request)
    {
        $site = $request->all();
        $path = "http://api.map.baidu.com/geocoder/v2/?address={$site['site']}&output=json&ak=CxF13N48UHZ12G8sIVpa2YTG";
        $p = file_get_contents($path);
        $p = json_decode($p,1);


        return view('identity.pp',['p'=>$p]);
    }
}
