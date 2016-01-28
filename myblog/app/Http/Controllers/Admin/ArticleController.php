<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use App\Article;
use App\ArticleType;
use Redirect, Input, Auth;

class ArticleController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $pre_page = 6;
        $articles = DB::table('article')->where('article.status', '<>', 2)
            ->leftJoin('articleType', 'article.articleType_id', '=', 'articleType.id')
            ->select('article.*', 'articleType.typeName as typeName')
            ->orderBy('article.create_time','desc')
            ->paginate($pre_page);
        $articles->setPath('article');
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
        return view('admin/article/index')->with('articles',$articles);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $article_types = ArticleType::where('status', '<>', 2)->get();
        return view('admin/article/create')->with('article_types',$article_types);
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
        $article = new Article;
        $article->title = Input::get('title');
        $article->tag = Input::get('tag');
        $article->selType = Input::get('selType');
        $article->img_url = '123';
        $article->articleType_id = Input::get('articleType_id');
        $article->content = Input::get('content');
        $article->introduction = Input::get('introduction');
        $article->create_time = time();
        $article->update_time = 0;
        $article->status = 1;
        if ($article->save()) {
            return response()->json(array(
                'status' => 1,
                'msg' => 'ok'
            ));
        } else {
            //echo "error";
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
        //
        $article_types = ArticleType::where('status', '<>', 2)->get();
        $article = Article::find($id);
        $article->content = str_replace('"', '', $article->content);
        $article->tag = array_filter(explode("×,",$article->tag));
        return view('admin/article/edit')
            ->with('article',$article)
            ->with('article_types',$article_types);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request)
    {
        //
        $id = Input::get('id');
        $article = Article::find($id);
        $article->title = Input::get('title');
        $article->tag = Input::get('tag');
        $article->selType = Input::get('selType');
        $article->articleType_id = Input::get('articleType_id');
        $article->content = Input::get('content');
        $article->introduction = Input::get('introduction');
        $article->update_time = time();
        if ($article->save()) {
            return response()->json(array(
                'status' => 1,
                'msg' => 'ok'
            ));
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
        Article::where('id',$id)->update(array('status'=>2));
        return Redirect::to('Admin/Article/article');
    }
}
