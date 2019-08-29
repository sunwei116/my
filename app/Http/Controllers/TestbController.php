<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/8/29
 * Time: 8:43
 */

namespace App\Http\Controllers;

use App\Http\Tools\Wechat;

class TestbController
{
    public function menu(Wechat $wechat)
    {
        $token = $wechat->get_access_token();
        $url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=$token";
        $arr = [
            'button'=>[
                  [
                      'type' => 'click',
                      'name' => '签到',
                      'key'  => 'qian'
                  ] ,
                [
                  'type' => 'click',
                  'name' => '积分查询',
                  'key'  => 'score',
                ],
            ]
        ];
        $dd = $wechat->post($url,json_encode($arr,JSON_UNESCAPED_UNICODE));
        $res = json_decode($dd,1);
        dd($res);
    }
}