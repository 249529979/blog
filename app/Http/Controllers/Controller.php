<?php
/**
 * 文件：Controller.php
 * 作者: 董坤鸿
 * 日期: 16/4/6
 * 时间: 上午9:23
 */

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController {
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
