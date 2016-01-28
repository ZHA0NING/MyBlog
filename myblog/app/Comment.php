<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    //
    protected $table = 'comment';   //设置关联表
    public $timestamps = false;  //设置没有created_at，updated_at
}
