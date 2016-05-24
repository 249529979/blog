<?php
/**
 * 文件：User.php
 * 作者: 董坤鸿
 * 日期: 16/4/5
 * 时间: 上午10:29
 */

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class User extends Model {

    protected $table = 'user';
    protected $primaryKey = 'id';
    public $timestamps = false;

}
