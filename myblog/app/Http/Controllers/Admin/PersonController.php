<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class PersonController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function introduction()
    {
        //
        return view('admin/person/introduction');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function setPassword()
    {

        return view('admin/person/setPassword');
    }
}
