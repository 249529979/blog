<?php
/**
 * 文件：ConfigController.php
 * 作者: 董坤鸿
 * 日期: 16/4/22
 * 时间: 上午10:49
 */

namespace App\Http\Controllers\Admin;

use App\Http\Model\Config;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class ConfigController extends CommonController {

    /**
     * 配置列表
     * GET admin/config
     * @return mixed
     */
    public function index() {
        $data = Config::orderBy('sort', 'asc')->get();
        //处理配置内容
        foreach ($data as $key => $value) {
            switch ($value->type) {
                case 'input':
                    $data[$key]->_html = '<input type="text" class="md" name="content[]" value="' . $value->content . '">';
                    break;
                case 'textarea':
                    $data[$key]->_html = '<textarea type="text" class="md" name="content[]">' . $value->content . '</textarea>';
                    break;
                case 'radio':
                    //1|开启,0|关闭
                    $array = explode(',', $value->value);
                    $str = '';
                    foreach ($array as $k => $v) {
                        //1|开启
                        $result = explode('|', $v);
                        $checked = $value->content == $result[0] ? ' checked="checked" ' : '';
                        $str .= '<input type="radio" name="content[]" value="' . $result[0] . '"' . $checked . '>' . $result[1] . '　';
                    }
                    $data[$key]->_html = $str;
                    break;
            }

        }
        return view('admin.config.index', compact('data'));
    }

    /**
     * 新增配置
     * GET admin/config/create
     * @return mixed
     */
    public function create() {
        return view('admin.config.create');
    }

    /**
     * 插入配置
     * POST admin/config
     * @return mixed
     */
    public function store() {
        $input = Input::except('_token', 's');
        $rules = [
            'title' => 'required',
            'name' => 'required'
        ];
        $message = [
            'title.required' => '配置标题不能为空!',
            'name.required' => '配置名称不能为空!'
        ];

        $validator = Validator::make($input, $rules, $message);
        if ($validator->passes()) {
            $result = Config::create($input);
            if ($result) {
                return redirect('admin/config');
            } else {
                return back()->with('errors', '数据填充失败,请稍后重试!');
            }
        } else {
            return back()->withErrors($validator);
        }
    }

    /**
     * 显示单个配置信息
     * GET admin/config/{config}
     * @return mixed
     */
    public function show() {

    }

    /**
     * 编辑配置
     * GET admin/config/{config}/edit
     * @param $id
     * @return mixed
     */
    public function edit($id) {
        $field = Config::find($id);
        return view('admin.config.edit', compact('field'));
    }

    /**
     * 更新配置
     * PUT admin/config/{config}
     * @param $id
     * @return mixed
     */
    public function update($id) {
        $input = Input::except('_token', '_method', 's');
        $rules = [
            'title' => 'required',
            'name' => 'required'
        ];
        $message = [
            'title.required' => '配置标题不能为空!',
            'name.required' => '配置名称不能为空!'
        ];

        $validator = Validator::make($input, $rules, $message);
        if ($validator->passes()) {
            $result = Config::where('id', $id)->update($input);
            if ($result) {
                $this->putConfig();
                return redirect('admin/config');
            } else {
                return back()->with('errors', '数据更新失败,请稍后重试!');
            }
        } else {
            return back()->withErrors($validator);
        }
    }

    /**
     *
     * 删除配置
     * DELETE admin/config/{config}
     * @param $id
     * @return array
     */
    public function destroy($id) {
        $result = Config::ere('id', $id)->delete();
        if ($result) {
            $this->putConfig();
            $data = [
                'status' => 0,
                'message' => '配置删除成功!',
            ];
        } else {
            $data = [
                'status' => 1,
                'message' => '配置删除失败，请稍后重试!',
            ];
        }
        return $data;
    }

    /**
     * 异步更新配置排序
     * @return array
     */
    public function changeSort() {
        $input = Input::all();
        $config = Config::find($input['id']);
        $config->sort = $input['sort'];
        $result = $config->update();
        if ($result) {
            $data = [
                'status' => 0,
                'message' => '配置排序更新成功!'
            ];
        } else {
            $data = [
                'status' => 1,
                'message' => '配置排序更新失败,请稍后重试!'
            ];
        }
        return $data;
    }

    /**
     * 更新配置项
     * @return mixed
     */
    public function changeContent() {
        $input = Input::all();
        foreach ($input['id'] as $key => $value) {
            Config::where('id', $value)->update(['content' => $input['content'][$key]]);
        }
        $this->putConfig();
        return back()->with('errors','配置项更新成功!');
    }

    /**
     * 把配置文件写入web.php
     */
    private function putConfig() {
        $config = Config::pluck('content', 'name')->all();
        $path = base_path() . '/config/web.php';
        $str = "<?php \r\n return " . var_export($config, true) . ";";
        file_put_contents($path, $str);
    }

}
