<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/7/9
 * Time: 11:49
 */
namespace app;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    public static function getStudent()
    {
        return 'student name is wei';
    }
}