<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'Index\IndexController@index');
Route::get('Index/index', 'Index\IndexController@index');
//Route::get('Article/index', 'Index\ArticleController@index');
//Route::get('Article/articleList', 'Index\ArticleController@articleList');  //文章列表

Route::post('Article/comment', 'Index\ArticleController@comment');
Route::controller('Article', 'Index\ArticleController');  //文章
Route::get('About/index', 'Index\AboutController@index');

Route::group(['prefix' => 'Admin', 'namespace' => 'Admin'], function()
{
    Route::get('/', 'IndexController@index');
    Route::get('Index/index', 'IndexController@index');
    Route::post('Article/article/create', 'ArticleController@store');
    Route::post('Article/article/update', 'ArticleController@update');
    Route::resource('Article/article', 'ArticleController');
    Route::resource('Article/type', 'ArticleTypeController');
    Route::resource('Article/comment', 'CommentController');
    Route::resource('Article/callback', 'CallbackController');

    Route::get('Person/introduction', 'PersonController@introduction');
    Route::get('Person/setIntroduction', 'PersonController@setIntroduction');
    Route::get('Person/password', 'PersonController@setPassword');
    Route::get('Statistic/articleCount', 'StatisticController@articleCount');
    Route::get('Statistic/visitCount', 'StatisticController@visitCount');
});
