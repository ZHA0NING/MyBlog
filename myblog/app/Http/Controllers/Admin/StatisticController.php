<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class StatisticController extends BaseController
{

    public function articleCount()
    {
        return view('admin/statistic/articleCount');
    }


    public function visitCount()
    {
        return view('admin/statistic/visitCount');
    }
}
