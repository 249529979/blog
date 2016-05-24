<?php
/**
 * 文件：Config.php
 * 作者: 董坤鸿
 * 日期: 16/4/19
 * 时间: 下午3:12
 */

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Links extends Model {
    protected $table = 'links';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $guarded=[];
}
