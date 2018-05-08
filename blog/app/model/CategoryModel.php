<?php
namespace app\model;

use core\Model;

class CategoryModel extends Model
{
    public function allCategory($collection='clm_category',$where=['status'=>1],$projection=[],$option=[],$aggregate=[])
    {
        $cate = $this->mongodb->select($collection,$where,$projection,$option,$aggregate);
        return $cate;
    }
    public function updateCategory($arr,$where,$collection='clm_category')
    {
        $rel = $this->mongodb->update($collection,$arr,$where);
        return $rel;
    }
    public function delCategory($where,$collection='clm_category')
    {
        $rel = $this->mongodb->delete($collection, $where);
        return $rel;
    }
    public function insertCategory($data,$collection='clm_category')
    {
        
        $rel = $this->mongodb->insert($collection, $data);
        return $rel;
    }
    
}