<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    /**
     * 与模型关联的表名
     *
     * @var string
     */
    protected $table = 'user';
    protected $primaryKey = 'id';
    public $timestamps = false;

}
