<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/7/7
 * Time: 18:46
 */

namespace App\Http\Controllers;


class MemberController extends Controller
{
    public function index($id)
    {
        return 'Member-info-id-' . $id;
//        return route('memberindex');

    }
}