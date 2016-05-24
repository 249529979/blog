<?php
/**
 * 文件：Category.php
 * 作者: 董坤鸿
 * 日期: 16/4/5
 * 时间: 下午4:08
 */

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Category extends Model {
    
    protected $table = 'category';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $guarded=[];

    /**
     * 获取分类信息
     * @return array
     */
    public function getCategory() {
        $category = $this->orderBy('sort', 'asc')->get();
        return $this->getTree($category, 'name', 'id', 'pid', 0);
    }

    /**
     * 获取当前分类和子级的ID
     * @param $id
     * @return array
     */
    public function getCategoryId($id) {
        $category = $this->get();    //获取分类
        $cIds = $this->getChildId($category, $id);  //获取当前分类子级
        $cIds[] = (int)$id; //压入当前分类ID
        return $cIds;
    }

    /**
     * 获得树状数据
     * @param $data
     * @param $fieldName
     * @param string $fieldId
     * @param string $fieldPid
     * @param int $pid
     * @return array
     */
    public function getTree($data, $fieldName, $fieldId = 'id', $fieldPid = 'pid', $pid = 0) {
        if(empty($data)){
            return array();
        }
        $arr = array();
        foreach ($data as $k => $v) {
            if ($v->$fieldPid == $pid) {
                $data[$k]["_" . $fieldName] = $data[$k][$fieldName];
                $arr[] = $data[$k];
                foreach ($data as $m => $n) {
                    if ($n->$fieldPid == $v->$fieldId) {
                        $data[$m]["_" . $fieldName] = '├─ ' . $data[$m][$fieldName];
                        $arr[] = $data[$m];
                    }
                }
            }
        }
        return $arr;
    }

    /**
     * 根据父级ID获取所有子级ID
     * @param $data
     * @param int $pid
     * @param string $fieldId
     * @param string $fieldPid
     * @return array
     */
    public function getChildId($data, $pid=0, $fieldId = 'id', $fieldPid = 'pid') {
        if(empty($data)){
            return array();
        }
        $arr = array();
        foreach ($data as $v) {
            if ($v['pid'] == $pid) {
                $arr[] = $v['id'];
                $arr = array_merge($arr, $this->getChildId($data, $v['id']));
            }
        }
        return $arr;
    }

}
