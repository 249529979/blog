<?php
/**
 * 文件：LoginController.php
 * 作者: 董坤鸿
 * 日期: 16/4/5
 * 时间: 上午10:29
 */

namespace App\Http\Controllers\Admin;

use App\Http\Model\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\libs\Code;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Input;

class LoginController extends CommonController {

    /**
     * 登陆显示页面
     * @return mixed
     */
    public function index() {
        //显示模板
        if (session('user')) {
            return redirect('admin/index');
        } else {
            return view('admin.login.index');
        }

    }

    /**
     * 验证登录
     * @return mixed
     */
    public function check() {
        $input = Input::all();
        //验证验证码
        $code = new Code();
        $_code = $code->get();
        if (strtoupper($input['code']) != $_code) {
            return back()->with('msg', '验证码错误！');
        }
        //验证用户名和密码
        $user = User::where('username', $input['username'])->first();   //使用模型查用户信息
        if ($user->username != $input['username'] || Crypt::decrypt($user->password) != $input['password']) {
            return back()->with('msg', '用户名或者密码错误！');
        }
        //把用户信息写入session
        session(['user' => $user]);
        return redirect('admin/index');

    }

    /**
     * 验证码
     */
    public function code() {
        $code = new Code();
        $code->make();
    }

}
