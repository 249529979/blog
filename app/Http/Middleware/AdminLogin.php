<?php
/**
 * 文件：AdminLogin.php
 * 作者: 董坤鸿
 * 日期: 16/4/9
 * 时间: 上午9:45
 */

namespace App\Http\Middleware;

use Closure;

class AdminLogin {

    /**
     * 处理传入的请求
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        //判断session中是否有user
        if (!session('user')) {
            return redirect('admin/login');
        }
        return $next($request);
    }
}
