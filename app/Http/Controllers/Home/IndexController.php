<?php
/**
 * 文件：IndexController.php
 * 作者: 董坤鸿
 * 日期: 16/3/29
 * 时间: 下午3:00
 */

namespace App\Http\Controllers\Home;

use App\Http\Model\Article;
use App\Http\Model\Links;
use Illuminate\Http\Request;
use App\Http\Requests;

class IndexController extends CommonController {

    /**
     * 首页
     * @return mixed
     */
    public function index() {
        //站长推荐6篇文章(缩略图形式)
        $master = Article::orderBy('view', 'DESC')->take(6)->get();

        //文章推荐每页10篇文章(带分页)(图文形式)
        $photo = Article::leftJoin('category', 'article.cid', '=', 'category.id')->select('article.*', 'category.name')->orderBy('release_time', 'DESC')->paginate(4);
        
        //友情链接n条(列表形式)
        $links = Links::where('status', 1)->where(function ($query) {
            $query->where('valid', '>', time())->orWhere('valid', 0);
        })->orderBy('sort', 'ASC')->get();
        return view('home.index.index', compact('master', 'photo', 'new', 'hot', 'links'));
    }

}
