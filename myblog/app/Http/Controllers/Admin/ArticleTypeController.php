<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\ArticleType;
use Redirect, Input, Auth;

class ArticleTypeController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $pre_page = 6;
        $articleType = ArticleType::where('status', '<>', 2)
            ->paginate($pre_page);
        //return view('admin/article/index');
        $articleType->setPath('type');
        return view('admin/articleType/index')->with('types',$articleType);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin/articleType/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $articleType = new ArticleType;
        $articleType->typeName = Input::get('typeName');
        $articleType->introduction = Input::get('introduction');
        $articleType->status = 1;
        $articleType->create_time = time();
        if ($articleType->save()) {
            return Redirect::to('Admin/Article/type');
        } else {
            return Redirect::back()->withInput()->withErrors('保存失败！');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        return view('admin/articleType/edit')->with('articleType',ArticleType::find($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $articleType = ArticleType::find($id);
        $articleType->typeName = Input::get('typeName');
        $articleType->introduction = Input::get('introduction');
        if ($articleType->save()) {
            return Redirect::to('Admin/Article/type');
        } else {
            return Redirect::back()->withInput()->withErrors('保存失败！');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
        $articleType = ArticleType::find($id);
        $articleType->status = 2;
        if ($articleType->save()) {
            return Redirect::to('Admin/Article/type');
        } else {
            return Redirect::back()->withInput()->withErrors('保存失败！');
        }
    }
}
