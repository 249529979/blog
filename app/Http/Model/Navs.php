<?php
/**
 * 文件：Navs.php
 * 作者: 董坤鸿
 * 日期: 16/4/20
 * 时间: 上午11:12
 */

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Navs extends Model {
    protected $table = 'navs';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $guarded=[];
}
