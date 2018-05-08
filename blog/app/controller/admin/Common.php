<?php
namespace app\controller\admin;

use core\Controller;
use core\cache\Session;
use app\model\CategoryModel;

class Common extends Controller
{
    
    protected $_id = null;
    protected $_name = null;
    
    public function __construct()
    {
        parent::__construct();
        $_id = Session::get('key');
        if(!isset($_id)){
            redirect('/admin/login/login','未登录！',2);
        }else{
            $this->_id = Session::get('key');
            $this->_name = Session::get('name');
        }
        $cateList = $this->category();
        $this->assign('category',$cateList);
        $this->assign('name', $this->_name);
        $this->assign('title', 'php程序员后台');
    }
    /**
     * 查询所有类
     */
    public function category()
    {
        $cate = new CategoryModel();
        $cateList = $cate->allCategory();
        return $cateList->toArray();
    }
    
}