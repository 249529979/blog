<?php
/**
 * 文件：Config.php
 * 作者: 董坤鸿
 * 日期: 16/4/22
 * 时间: 下午4:12
 */

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Config extends Model {
    protected $table = 'config';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $guarded=[];
}
