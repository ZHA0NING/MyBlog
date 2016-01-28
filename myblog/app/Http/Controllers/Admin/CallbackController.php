<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Article;

use Redirect, Input, Auth;

class CallbackController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $pre_page = 6;
        $articles = DB::table('article')->where('article.status', '=', 2)
            ->leftJoin('articleType', 'article.articleType_id', '=', 'articleType.id')
            ->select('article.*', 'articleType.typeName as typeName')
            ->orderBy('article.create_time','desc')
            ->paginate($pre_page);
        $articles->setPath('callback');
        foreach($articles as $article)
        {
            $article->create_time = date("Y-m-d H:i:s",$article->create_time);
            switch($article->selType){
                case 1:
                    $article->selType = "原创";
                    break;
                case 2:
                    $article->selType = "转载";
                    break;
                case 3:
                    $article->selType = "翻译";
                    break;
                default:
                    $article->selType = "其他";
                    break;
            }
        }
        return view('admin/callback/index')->with('articles',$articles);
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
        $article = Article::find($id);
        $article->status = 1;
        if ($article->save()) {
            return Redirect::to('Admin/Article/callback');
        } else {
            return Redirect::back()->withErrors('恢复失败！');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update($id)
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
        $article = Article::find($id);
        $article->delete();
        return Redirect::to('Admin/Article/callback');
    }
}
