<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PageView extends Model
{
    //
    protected $table = 'pageView';   //设置关联表
    public $timestamps = false;  //设置没有created_at，updated_at
}
