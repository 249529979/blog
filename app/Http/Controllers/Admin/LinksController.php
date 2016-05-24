<?php
/**
 * 文件：LinksController.php
 * 作者: 董坤鸿
 * 日期: 16/4/19
 * 时间: 下午4:19
 */

namespace App\Http\Controllers\Admin;

use App\Http\Model\Links;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class LinksController extends CommonController {

    /**
     * 友情链接列表
     * GET admin/links
     * @return mixed
     */
    public function index() {
        $data = Links::orderBy('sort', 'asc')->get();
        return view('admin.links.index', compact('field', 'data'));
    }

    /**
     * 新增友情链接
     * GET admin/links/create
     * @return mixed
     */
    public function create() {
        return view('admin.links.create');
    }

    /**
     * 插入友情链接
     * POST admin/links
     * @return mixed
     */
    public function store() {
        $input = Input::except('_token', 'file_upload', 's');
        $input['valid'] = empty($input['valid']) ? 0 : strtotime($input['valid']); //过期时间
        $rules = [
            'name' => 'required',
            'url' => 'required'
        ];
        $message = [
            'name.required' => '友情链接名称不能为空!',
            'url.required' => '友情链接地址不能为空!'
        ];

        $validator = Validator::make($input, $rules, $message);
        if ($validator->passes()) {
            if ($input['display'] && $input['logo'] == '') {
                return back()->with('errors', '请上传LOGO图片文件!');
            } else {
                $result = Links::create($input);
                if ($result) {
                    return redirect('admin/links');
                } else {
                    return back()->with('errors', '数据填充失败,请稍后重试!');
                }
            }
        } else {
            return back()->withErrors($validator);
        }
    }

    /**
     * 显示单个友情链接信息
     * GET admin/links/{links}
     * @return mixed
     */
    public function show() {

    }

    /**
     * 编辑友情链接
     * GET admin/links/{links}/edit
     * @param $id
     * @return mixed
     */
    public function edit($id) {
        $field = Links::find($id);
        return view('admin.links.edit', compact('field'));
    }

    /**
     * 更新友情链接
     * PUT admin/links/{links}
     * @param $id
     * @return mixed
     */
    public function update($id) {
        $input = Input::except('_token', '_method', 'file_upload', 's');
        $input['valid'] = empty($input['valid']) ? 0 : strtotime($input['valid']); //过期时间
        $rules = [
            'name' => 'required',
            'url' => 'required'
        ];
        $message = [
            'name.required' => '友情链接名称不能为空!',
            'url.required' => '友情链接地址不能为空!'
        ];
        $validator = Validator::make($input, $rules, $message);
        if ($validator->passes()) {
            if ($input['display'] && $input['logo'] == '') {
                return back()->with('errors', '请上传LOGO图片文件!');
            } else {
                $result = Links::where('id', $id)->update($input);
                if ($result) {
                    return redirect('admin/links');
                } else {
                    return back()->with('errors', '数据更新失败,请稍后重试!');
                }
            }
        } else {
            return back()->withErrors($validator);
        }
    }

    /**
     *
     * 删除友情链接
     * DELETE admin/links/{links}
     * @param $id
     * @return array
     */
    public function destroy($id) {
        $result = Links::where('id', $id)->delete();
        if ($result) {
            $data = [
                'status' => 0,
                'message' => '友情链接删除成功!',
            ];
        } else {
            $data = [
                'status' => 1,
                'message' => '友情链接删除失败，请稍后重试!',
            ];
        }
        return $data;
    }

    /**
     * 异步更新友情链接排序
     * @return array
     */
    public function changeSort() {
        $input = Input::all();
        $links = Links::find($input['id']);
        $links->sort = $input['sort'];
        $result = $links->update();
        if ($result) {
            $data = [
                'status' => 0,
                'message' => '友情链接排序更新成功!'
            ];
        } else {
            $data = [
                'status' => 1,
                'message' => '友情链接排序更新失败,请稍后重试!'
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
            $thumbPath = '/upload/links/' . date('Ymd') . '/';
            $path = $file->move(base_path() . '/public' . $thumbPath, $newName);  //移动文件并重命名
            $filepath = $thumbPath . $newName;
            return $filepath;
        } else {
            return '上传失败';
        }
    }

}
