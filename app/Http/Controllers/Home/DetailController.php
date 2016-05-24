<?php
/**
 * 文件：DetailController.php
 * 作者: 董坤鸿
 * 日期: 16/4/28
 * 时间: 上午10:20
 */

namespace App\Http\Controllers\Home;

use App\Http\Model\Article;
use App\Http\Model\Category;
use Illuminate\Http\Request;
use App\Http\Requests;

class DetailController extends CommonController {

    /**
     * 详情页面
     * @param $id
     * @return mixed
     */
    public function index($id) {
        //查看次数自增
        Article::where('id',$id)->increment('view');
        $info = Article::leftJoin('category', 'article.cid', '=', 'category.id')->select('article.*', 'category.name')->where('article.id', $id)->first();
        $category = Category::get();    //获取分类
        $parent = $this->getParents($category, $info->cid);
        $last = count($parent) -1;
        $pre = Article::where('id','<',$id)->orderBy('id','desc')->first(); //上一篇
        $next = Article::where('id','>',$id)->orderBy('id','asc')->first(); //下一篇
        $related = Article::where('cid',$info->cid)->orderBy('id','desc')->take(6)->get();

        return view('home.detail.index', compact('info', 'parent','last', 'pre', 'next', 'related'));
    }

    /**
     * 根据子级ID返回所有父级ID
     * @param $category
     * @param $id
     * @return array
     */
    public function getParents($category, $id) {
        $arr = array();
        foreach ($category as $value){
            if($value['id'] == $id) {
                $arr[] = $value;
                $arr = array_merge($this->getParents($category, $value['pid']) , $arr);
            }
        }
        return $arr;
    }
}
