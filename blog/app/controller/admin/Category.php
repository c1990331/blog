<?php
namespace app\controller\admin;

use app\controller\admin\Common;
use app\model\CategoryModel;
use core\Request;

class Category extends Common
{
    public function categorys()
    {
        $param = Request::param('cate');
        $page = Request::param('page');
        $keyword = Request::get('user_search');
        $page = $page?$page:1;
        $arr = [];
        $arr['type'] = $param;
        $size = 10;
        $skip = ($page-1)*$size;
        if($param){
            $cateModel = new CategoryModel();
            $cates = [];
            $table = str_replace(' ','',strtolower('clm_'.$param));
            $where = [];
            if(!empty($keyword)){
                $arr['keyword'] = $keyword;
                $where = [
                    '$or'=>[
                        ['title'=>['$regex'=>$keyword]],
                        ['description'=>['$regex'=>$keyword]],
                        ['content'=>['$regex'=>$keyword]],
                    ],
                ];
            }
            $count = $cateModel->allCategory($table,$where,['title'=>0,'content'=>0]);
            $count = count($count->toArray());
            $cates = $cateModel->allCategory($table,$where,['title'=>1,'description'=>1],['skip'=>$skip,'limit'=>$size]);
        }
        $arr['cate'][] = [];
        $data = $cates->toArray();
        if($data){
            $i = 0;
            foreach($data as $val){
                $num = count($arr['cate'][$i])??0;
                if($num == 5){
                    $i ++;
                }
                $arr['cate'][$i][] =  $val;
                    
            }
        }
        $arr['pageHtml'] = $this->page($count,$page,'/admin/category/categorys?cate='.$param.'&user_search='.$keyword);
        $this->assign('arr',$arr);
        $this->fetch('admin/category.html');
    }
   
    /**
     * 添加用户
     */
    public function addUser()
    {
        $arr = [
            'user'=>'admin',
            'password'=>md5('clm123456'),
            'add_time'=>time(),
            'status'=>1
        ];
        $rel = $this->mongodb->insert('clm_user',$arr);
        print_r($rel);die;
    }
    /**
     * 添加新的分类
     */
    public function addCate()
    {
        $arr = [
            'category_id'=>'9',
            'category_name'=>'Life Essays',
            'status'=>(int)1,
        ];
        $rel = $this->mongodb->insert('clm_category',$arr);
    }
}