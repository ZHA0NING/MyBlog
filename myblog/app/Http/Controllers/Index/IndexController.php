<?php

namespace App\Http\Controllers\Index;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use DB;
use App\Article;
use Redirect, Input, Auth;

class IndexController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $pre_page = 5;
        $articles = DB::table('article')->where('article.status', '<>', 2)
            ->leftJoin('articleType', 'article.articleType_id', '=', 'articleType.id')
            ->select('article.*', 'articleType.typeName as typeName')
            ->orderBy('article.create_time','desc')
            ->paginate($pre_page);
        $articles->setPath('index');
        foreach($articles as $article)
        {
            $article->create_time = date("Y-m-d",$article->create_time);
            $arr = explode("-",$article->create_time);
            //var_dump($arr);
            //echo "----";
            $article->create_time_month = $arr[1]."/".$arr[2];
        }
        //return view('admin/article/create')->with('article_types',$article_types);
        return view('index/index/index')->with('articles',$articles);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
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
        //
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
        //
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
    }
}
