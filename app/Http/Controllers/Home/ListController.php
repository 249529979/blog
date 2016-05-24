<?php
/**
 * 文件：ListController.php
 * 作者: 董坤鸿
 * 日期: 16/4/28
 * 时间: 上午10:20
 */

namespace App\Http\Controllers\Home;

use App\Http\Model\Article;
use App\Http\Model\Category;
use Illuminate\Http\Request;
use App\Http\Requests;

class ListController extends CommonController {

    /**
     * 列表页面
     * @param $id
     * @return mixed
     */
    public function index($id) {
        Category::where('id', $id)->increment('views');  //分类查看次数自增
        $category = Category::find($id);   //获取当前分类数据
        $childData = Category::where('pid', $id)->get();   //获取子级数据
        $photo = $this->getArticle($id); //文章数据
        return view('home.list.index', compact('category', 'photo', 'childData'));
    }

    /**
     * 获取文章数据
     * @param $id
     * @return array()
     */
    public function getArticle($id) {
        $category = new Category();
        $cIds = $category->getCategoryId($id);  //获取当前分类子级
        //文章推荐每页10篇文章(带分页)(图文形式)
        $article = Article::leftJoin('category', 'article.cid', '=', 'category.id')->select('article.*', 'category.name')->whereIn('cid', $cIds)->orderBy('release_time', 'DESC')->paginate(4);
        return $article;
    }

}
