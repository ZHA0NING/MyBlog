<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Session;

class BaseController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth');
        $user = Session::get('user');
        if($user == null)
        {
            //echo "not login";
        }else{
            //echo "login";
        }
    }
}
