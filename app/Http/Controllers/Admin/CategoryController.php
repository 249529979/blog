<?php
/**
 * 文件：CategoryController.php
 * 作者: 董坤鸿
 * 日期: 16/4/9
 * 时间: 下午3:13
 */

namespace App\Http\Controllers\Admin;

use App\Http\Model\Category;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class CategoryController extends CommonController {

    /**
     * 分类列表
     * GET admin/category
     * @return mixed
     */
    public function index() {
        $category = new Category();
        $data = $category->getCategory();
        return view('admin.category.index')->with('data', $data);
    }

    /**
     * 新增分类
     * GET admin/category/create
     * @return mixed
     */
    public function create() {
        $data = Category::where('pid', 0)->get();
        return view('admin.category.create')->with('data', $data);
    }

    /**
     * 插入分类
     * POST admin/category
     * @return mixed
     */
    public function store() {
        $input = Input::except('_token', 's');
        $rules = [
            'name' => 'required|between:1,60',
            'title' => 'required'
        ];
        $message = [
            'name.required' => '分类名称不能为空!',
            'name.between' => '分类名称必须在1-60之间!',
            'title.required' => '分类标题不能为空!'
        ];
        $validator = Validator::make($input, $rules, $message);
        if ($validator->passes()) {
            $result = Category::create($input);
            if ($result) {
                return redirect('admin/category');
            } else {
                return back()->with('errors', '数据填充失败,请稍后重试!');
            }
        } else {
            return back()->withErrors($validator);
        }
    }

    /**
     * 显示单个分类信息
     * GET admin/category/{category}
     * @return mixed
     */
    public function show() {

    }

    /**
     * 编辑分类
     * GET admin/category/{category}/edit
     * @param $id
     * @return mixed
     */
    public function edit($id) {
        $field = Category::find($id);
        $data = Category::where('pid', 0)->get();
        return view('admin.category.edit', compact('field', 'data'));
    }

    /**
     * 更新分类
     * PUT admin/category/{category}
     * @param $id
     * @return mixed
     */
    public function update($id) {
        $input = Input::except('_token', '_method', 's');
        $rules = [
            'name' => 'required|between:1,60',
            'title' => 'required'
        ];
        $message = [
            'name.required' => '分类名称不能为空!',
            'name.between' => '分类名称必须在1-60之间!',
            'title.required' => '分类标题不能为空!'
        ];
        $validator = Validator::make($input, $rules, $message);
        if ($validator->passes()) {
            $result = Category::where('id', $id)->update($input);
            if ($result) {
                return redirect('admin/category');
            } else {
                return back()->with('errors', '数据更新失败,请稍后重试!');
            }
        } else {
            return back()->withErrors($validator);
        }
    }

    /**
     *
     * 删除分类
     * DELETE admin/category/{category}
     * @param $id
     * @return array
     */
    public function destroy($id) {
        $result = Category::where('id', $id)->delete();
        if ($result) {
            Category::where('pid', $id)->update(['pid' => 0]);
            $data = [
                'status' => 0,
                'message' => '分类删除成功!',
            ];
        } else {
            $data = [
                'status' => 1,
                'message' => '分类删除失败，请稍后重试!',
            ];
        }
        return $data;
    }

    /**
     * 异步更新分类排序
     * @return array
     */
    public function changeSort() {
        $input = Input::all();
        $category = Category::find($input['id']);
        $category->sort = $input['sort'];
        $result = $category->update();
        if ($result) {
            $data = [
                'status' => 0,
                'message' => '分类排序更新成功!'
            ];
        } else {
            $data = [
                'status' => 1,
                'message' => '分类排序更新失败,请稍后重试!'
            ];
        }
        return $data;
    }

}
