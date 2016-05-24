<?php
/**
 * 文件：Article.php
 * 作者: 董坤鸿
 * 日期: 16/4/18
 * 时间: 上午10:15
 */

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Article extends Model {
    protected $table = 'article';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $guarded=[];
    
}
