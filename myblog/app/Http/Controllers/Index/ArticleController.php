<?php

namespace App\Http\Controllers\Index;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Redirect, Input, Auth;

use DB;
use App\Article;
use App\Comment;

class ArticleController extends Controller
{
    /**
     *文章分类列表
     */
    public function getIndex()
    {
        $typeLists = DB::table('articleType')
            ->where('articleType.status', '<>', 2)
            ->select('articleType.*')
            ->get();
        foreach($typeLists as $typeList)
        {
            $typeList->create_time = date("Y-m-d",$typeList->create_time);
            $article = DB::table('article')->where("status","<>",2)->where("articleType_id","=",$typeList->id)->count("*");
            $typeList->articleCount = $article;
        }
        return view('index/article/index')->with("typeLists",$typeLists);
    }
    /**
     *单个类别的文章列表
     */
    public function getArticlelist(Request $requests)
    {
        $id =  $requests->input('id');
        if ($id == "" || preg_match('/^\d+$/i', $id) == 0)
        {
            return view('errors/404');
        }
        $pre_page = 5;
        $articles = DB::table('article')->where('article.status', '<>', 2)->where('article.articleType_id', '=', $id)
            ->leftJoin('articleType', 'article.articleType_id', '=', 'articleType.id')
            ->select('article.*', 'articleType.typeName as typeName')
            ->orderBy('article.create_time','desc')
            ->paginate($pre_page);
        $articles->setPath('index');
        //dump($articles);
        $count = $articles->total();
        //if()
        foreach($articles as $article)
        {
            //var_dump($article);
            $article->create_time = date("Y-m-d",$article->create_time);
            $arr = explode("-",$article->create_time);
            //var_dump($arr);
            //echo "----";
            $article->create_time_month = $arr[1]."/".$arr[2];
        }
        //return view('admin/article/create')->with('article_types',$article_types);
        return view('index/article/articleList')->with('articles',$articles)->with("count",$count);
        //return view('index/article/articleList');
    }
    /**
     *显示文章
     */
    public function getArticle(Request $requests)
    {
        //dump($requests->input());
        $id =  $requests->input('id');
        if ($id == "" || preg_match('/^\d+$/i', $id) == 0)
        {
            return view('errors/404');
        }
        $articles = DB::table('article')->where('article.id', '=', $id)
            ->leftJoin('articleType', 'article.articleType_id', '=', 'articleType.id')
            ->select('article.*', 'articleType.typeName as typeName')
            ->get();
        $key = "";
        foreach($articles as $article)
        {
            $article->create_time = date("Y-m-d",$article->create_time);
            //$article->tag = array_filter(explode("×,",$article->tag));
            $key = str_replace("×","",$article->tag);
            //$arr = explode("-",$article->create_time);
            //var_dump($arr);
            //echo "----";
            //$article->create_time_month = $arr[1]."/".$arr[2];
        }
        $comments = DB::table('comment')
            ->where('article_id', '=', $id)
            ->get();
        foreach($comments as $comment){
            $comment->visit_time = date("Y-m-d H:i:s",$comment->visit_time);
        }

        return view('index/article/article')
            ->with("articles",$articles)
            ->with("key",$key)
            ->with("comments",$comments);
    }

    /**
     *提交评论
     */
    public function comment(Request $requests)
    {
        $comment = new Comment;
        $comment->article_id = Input::get('id');
        $comment->visit_message = Input::get('email');
        $comment->visit_content = Input::get('comment');
        $comment->visit_time = time();
        if ($comment->save()) {
            return response()->json(array(
                'status' => 1,
                'msg' => 'ok'
            ));
        } else {
            //echo "error";
            return Redirect::back()->withInput()->withErrors('保存失败！');
        }
    }

}
