<?php
/**
 * 文件：IndexController.php
 * 作者: 董坤鸿
 * 日期: 16/4/6
 * 时间: 上午10:23
 */

namespace App\Http\Controllers\Admin;

use App\Http\Model\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class IndexController extends CommonController {

    /**
     * 显示后台首页
     * @return mixed
     */
    public function index() {
        return view('admin.index.index');
    }

    /**
     * 系统基本信息页
     * @return mixed
     */
    public function info() {
        return view('admin.index.info');
    }

    /**
     * 显示更改密码
     * @return mixed
     */
    public function password() {
        return view('admin.index.password');
    }

    /**
     * 更改密码
     * @return mixed
     */
    public function changePwd(){
        $input = Input::all();
        $rules = [
            'password' => 'required|between:6,20|confirmed',
        ];
        $message = [
            'password.required' => '新密码不能为空!',
            'password.between' => '新密码必须在6-20位之间',
            'password.confirmed' => '新密码和确认密码不一致',
        ];
        $validator = Validator::make($input, $rules, $message);
        if ($validator->passes()) {
            $user = User::where('username', session('user.username'))->first();
            $password = Crypt::decrypt($user->password);
            if ($input['password_o'] == $password) {
                $user->password = Crypt::encrypt($input['password']);
                $user->update();
                return back()->with('errors', '密码修改成功!');
            } else {
                return back()->with('errors', '原密码错误');
            }
        } else {
            return back()->withErrors($validator);
        }
    }

    /**
     * 后台退出登录
     * @return mixed
     */
    public function logout() {
        //销毁登录后session里的user
        session(['user' => null]);
        return redirect('admin/login');
    }

    
}
