<?php
namespace app\controller\home;

use core\Controller;

class Common extends Controller
{
    protected  $cates = [];
    public function __construct()
    {
        parent::__construct();
        $this->cates = $this->cate();
        $this->assign('cate', $this->cates);
    }
    /**
     * 查询分类
     */
    private function cate()
    {
        $cates = $this->mongodb->select('clm_category',['status'=>1],['url'=>0,'status'=>0]);
        return $cates->toArray();
    }
}