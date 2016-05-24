<?php
/**
 * 文件：ArticleController.php
 * 作者: 董坤鸿
 * 日期: 16/3/29
 * 时间: 下午4:08
 */

namespace App\Http\Controllers\Admin;

use App\Http\Model\Article;
use App\Http\Model\Category;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class ArticleController extends CommonController {

    /**
     * 文章列表
     * GET admin/article
     * @return mixed
     */
    public function index() {
        $data = Article::orderBy('id', 'desc')->paginate(10);
        return view('admin.article.index', compact('data'));
    }

    /**
     * 新增文章
     * GET admin/article/create
     * @return mixed
     */
    public function create() {
        $category = new Category();
        $data = $category->getCategory();
        return view('admin.article.create')->with('data', $data);
    }

    /**
     * 插入文章
     * POST admin/article
     * @return mixed
     */
    public function store() {
        $input = Input::except('_token', 'file_upload', 's');
        $input['release_time'] = time();
        $rules = [
            'title' => 'required',
            'author' => 'required',
            'content' => 'required'
        ];
        $message = [
            'title.required' => '文章标题不能为空!',
            'author.required' => '作者不能为空!',
            'content.required' => '文章内容不能为空!'
        ];
        $validator = Validator::make($input, $rules, $message);
        if ($validator->passes()) {
            $result = Article::create($input);
            if ($result) {
                return redirect('admin/article');
            } else {
                return back()->with('errors', '数据填充失败,请稍后重试!');
            }
        } else {
            return back()->withErrors($validator);
        }
    }

    /**
     * 显示单个文章信息
     * GET admin/article/{article}
     * @return mixed
     */
    public function show() {

    }

    /**
     * 编辑文章
     * GET admin/article/{article}/edit
     * @param $id
     * @return mixed
     */
    public function edit($id) {
        $field = Article::find($id);
        $category = new Category();
        $data = $category->getCategory();
        return view('admin.article.edit', compact('field', 'data'));
    }

    /**
     * 更新文章
     * PUT admin/article/{article}
     * @param $id
     * @return mixed
     */
    public function update($id) {
        $input = Input::except('_token', '_method', 'file_upload', 's');
        $rules = [
            'title' => 'required',
            'author' => 'required',
            'content' => 'required'
        ];
        $message = [
            'title.required' => '文章标题不能为空!',
            'author.required' => '作者不能为空!',
            'content.required' => '文章内容不能为空!'
        ];
        $validator = Validator::make($input, $rules, $message);
        if ($validator->passes()) {
            $result = Article::where('id', $id)->update($input);
            if ($result) {
                return redirect('admin/article');
            } else {
                return back()->with('errors', '文章更新失败，请稍后重试！');
            }
        } else {
            return back()->withErrors($validator);
        }
    }

    /**
     * 删除文章
     * DELETE admin/article/{article}
     * @param $id
     * @return array
     */
    public function destroy($id) {
        $result = Article::where('id', $id)->delete();
        if ($result) {
            $data = [
                'status' => 0,
                'message' => '文章删除成功!',
            ];
        } else {
            $data = [
                'status' => 1,
                'message' => '文章删除失败，请稍后重试!',
            ];
        }
        return $data;
    }

    /**
     * 上传图片
     * @return string
     */
    public function upload(){
        $file = Input::file('Filedata');
        if ($file->isValid()) {
            $entension = $file->getClientOriginalExtension(); //上传文件的后缀
            $newName = time() . mt_rand(111, 999) . '.' . $entension;
            $thumbPath = '/upload/thumb/' . date('Ymd') . '/';
            $path = $file->move(base_path() . '/public' . $thumbPath, $newName);  //移动文件并重命名
            $filepath = $thumbPath . $newName;
            return $filepath;
        } else {
            return '上传失败';
        }
    }

}
