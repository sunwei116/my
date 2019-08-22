<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/8/15
 * Time: 16:15
 */

namespace App\Http\Controllers\wechat;


class menuController
{
    public $wechat;
    public function __construct(Wechat $wechat)
    {
        $this->wechat = $wechat;
    }

    public function menuList()
    {
        return view('admin.wechat.menuList');
    }
}