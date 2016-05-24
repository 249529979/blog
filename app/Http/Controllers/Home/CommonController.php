<?php
/**
 * 文件：CommonController.php
 * 作者: 董坤鸿
 * 日期: 16/4/26
 * 时间: 上午11:09
 */

namespace App\Http\Controllers\Home;

use App\Http\Model\Article;
use App\Http\Model\Navs;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;

class CommonController extends Controller {

    /**
     * 初始化导航数据
     * CommonController constructor.
     */
    public function __construct() {
        //前台菜单列表
        $navs = Navs::where('status' , 1)->get();

        //最新文章8篇文章(列表形式)
        $new = Article::orderBy('release_time', 'DESC')->take(8)->get();

        //点击排行5篇文章(列表形式)
        $hot = Article::orderBy('view', 'DESC')->take(5)->get();

        View::share('navs', $navs);
        View::share('new', $new);
        View::share('hot', $hot);
    }
}
