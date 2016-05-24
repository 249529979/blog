<?php

/*
|--------------------------------------------------------------------------
| 应用程序路由
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

//后台路由配置
//普通路由
Route::group(['middleware' => ['web']], function () {

    Route::get('/', 'Home\IndexController@index');                              //前台首页
    Route::get('/c_{id}', 'Home\ListController@index');                         //前台文章列表
    Route::get('/a_{id}', 'Home\DetailController@index');                       //前台文章详情
    Route::get('admin/login', 'Admin\LoginController@index');                   //后台登陆页
    Route::post('admin/check', 'Admin\LoginController@check');                  //后台检查登陆页
    Route::get('admin/code', 'Admin\LoginController@code');                     //后台验证码
});

//是用中间件验证登录路由
Route::group(['middleware' => ['web', 'admin.login'], 'prefix' => 'admin', 'namespace' => 'Admin'], function () {
    Route::get('index', 'IndexController@index');                               //后台首页
    Route::get('info', 'IndexController@info');                                 //后台欢迎页
    Route::any('changePwd', 'IndexController@changePwd');                       //后台更改密码
    Route::get('logout', 'IndexController@logout');                             //后台退出登录
    Route::resource('category', 'CategoryController');                          //后台分类
    Route::post('category/changeSort', 'CategoryController@changeSort');        //后台分类异步排序
    Route::resource('article', 'ArticleController');                            //后台文章
    Route::any('article/upload', 'ArticleController@upload');                   //后台文章上传图片
    Route::resource('links', 'LinksController');                                //后台友情链接
    Route::any('links/upload', 'LinksController@upload');                       //后台友情链接上传LOGO
    Route::post('links/changeSort', 'LinksController@changeSort');              //后台友情链接异步排序
    Route::resource('navs', 'NavsController');                                  //后台菜单
    Route::post('navs/changeSort', 'NavsController@changeSort');                //后台菜单异步排序
    Route::resource('config', 'ConfigController');                              //后台配置
    Route::resource('config/changeSort', 'ConfigController@changeSort');        //后台配置异步排序
    Route::resource('config/changeContent', 'ConfigController@changeContent');  //后台配置保存内容
});