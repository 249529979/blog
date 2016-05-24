<?php
/**
 * 文件：NavsController.php
 * 作者: 董坤鸿
 * 日期: 16/4/21
 * 时间: 下午2:30
 */

namespace App\Http\Controllers\Admin;

use App\Http\Model\Navs;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class NavsController extends CommonController {

    /**
     * 菜单列表
     * GET admin/navs
     * @return mixed
     */
    public function index() {
        $data = Navs::orderBy('sort', 'asc')->get();
        return view('admin.navs.index', compact('data'));
    }

    /**
     * 新增菜单
     * GET admin/navs/create
     * @return mixed
     */
    public function create() {
        return view('admin.navs.create');
    }

    /**
     * 插入菜单
     * POST admin/navs
     * @return mixed
     */
    public function store() {
        $input = Input::except('_token', 's');
        $rules = [
            'name' => 'required',
            'alias' => 'required',
            'url' => 'required'
        ];
        $message = [
            'name.required' => '菜单名称不能为空!',
            'alias.required' => '菜单别名不能为空!',
            'url.required' => '菜单地址不能为空!'
        ];

        $validator = Validator::make($input, $rules, $message);
        if ($validator->passes()) {
            $result = Navs::create($input);
            if ($result) {
                return redirect('admin/navs');
            } else {
                return back()->with('errors', '数据填充失败,请稍后重试!');
            }
        } else {

            return back()->withErrors($validator);
        }
    }

    /**
     * 显示单个菜单信息
     * GET admin/navs/{navs}
     * @return mixed
     */
    public function show() {

    }

    /**
     * 编辑菜单
     * GET admin/navs/{navs}/edit
     * @param $id
     * @return mixed
     */
    public function edit($id) {
        $field = Navs::find($id);
        return view('admin.navs.edit', compact('field'));
    }

    /**
     * 更新菜单
     * PUT admin/navs/{navs}
     * @param $id
     * @return mixed
     */
    public function update($id) {
        $input = Input::except('_token', '_method', 's');
        $rules = [
            'name' => 'required',
            'alias' => 'required',
            'url' => 'required'
        ];
        $message = [
            'name.required' => '菜单名称不能为空!',
            'alias.required' => '菜单别名不能为空!',
            'url.required' => '菜单地址不能为空!'
        ];
        $validator = Validator::make($input, $rules, $message);
        if ($validator->passes()) {
            $result = Navs::where('id', $id)->update($input);
            if ($result) {
                return redirect('admin/navs');
            } else {
                return back()->with('errors', '数据更新失败,请稍后重试!');
            }
        } else {
            return back()->withErrors($validator);
        }
    }

    /**
     *
     * 删除菜单
     * DELETE admin/navs/{navs}
     * @param $id
     * @return array
     */
    public function destroy($id) {
        $result = Navs::where('id', $id)->delete();
        if ($result) {
            $data = [
                'status' => 0,
                'message' => '菜单删除成功!',
            ];
        } else {
            $data = [
                'status' => 1,
                'message' => '菜单删除失败，请稍后重试!',
            ];
        }
        return $data;
    }

    /**
     * 异步更菜单排序
     * @return array
     */
    public function changeSort() {
        $input = Input::all();
        $navs = Navs::find($input['id']);
        $navs->sort = $input['sort'];
        $result = $navs->update();
        if ($result) {
            $data = [
                'status' => 0,
                'message' => '菜单排序更新成功!'
            ];
        } else {
            $data = [
                'status' => 1,
                'message' => '菜单排序更新失败,请稍后重试!'
            ];
        }
        return $data;
    }

}
