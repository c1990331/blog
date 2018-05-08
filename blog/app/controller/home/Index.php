<?php
namespace app\controller\home;

use app\controller\Common\home;
// use app\model\User;
use core\Request;
use core\Config;

class Index extends Common
{
    public function __construct()
    {
        parent::__construct();
    }
    public function Index(){
        $categorys = $this->cates;
        $cates = [];
        $table = [];
        foreach($categorys as $val){
            if($val->category_id){
                $cates[] = $val->category_id;
                $table[$val->category_id] = $val->category_name;
            }
        }
        $keyword = Request::get('keyword');
        
        $cate = Request::get('cate');
        $page = Request::get('page');
        $page = $page?$page:1;
        $cate = in_array($cate,$cates)?$cate:1;
        $size = 10;
        $skip = ($page-1)*$size;
        
        $tableCate = isset($table[$cate])?$table[$cate]:'';
        $prefix = Config::get('database');
        $tableName = str_replace(' ', '', strtolower($prefix['mongodb']['dbprefix'].$tableCate));
        //今日推荐
        $todayRecommend = $this->mongodb->select('clm_php',['status'=>1],['content'=>0,'status'=>0],['limit'=>1,'sort'=>['add_time'=>-1]]);
        $where = [
            'status'=>1
        ];
        if(!empty($keyword)){
            $where['$or'] = [
                ['title'=>['$regex'=>$keyword]],
                ['description'=>['$regex'=>$keyword]],
                ['content'=>['$regex'=>$keyword]],
            ];
        }
        //最新发布
        $newPublish = $this->mongodb->select($tableName,$where,['content'=>0,'status'=>0],['limit'=>$size,'skip'=>$skip]);
        $count = $this->mongodb->select($tableName,$where,['content'=>0,'status'=>0,'add_time'=>0]);
        $count = count($count->toArray());

        $page = $this->page($count,$page,'?cate='.$cate.'&keyword='.$keyword);
        
        // 生活随笔 status=4
        $lifeEssays = $this->mongodb->select('clm_lifeessays',['status'=>4],['content'=>0,'status'=>0,'description'=>0]);
        //更多文章 status= 3
        $moreEssays = $this->mongodb->select('clm_lifeessays',['status'=>3],['content'=>0,'status'=>0,'description'=>0]);
        $todayRecommend = $todayRecommend->toArray();
        $todayRecommend = isset($todayRecommend[0])?$todayRecommend[0]:[];
        
        $lifeEssays = $lifeEssays->toArray();
        $lifeEssays = isset($lifeEssays[0])?$lifeEssays[0]:[];
        $this->assign('todayRecommend',$todayRecommend);
       
        $this->assign('life_essays',$lifeEssays);
        $this->assign('more_essays',$moreEssays->toArray());
        $this->assign('new_publish',$newPublish->toArray());
        $this->assign('page_url',$page);
        $this->assign('param_cate',$cate);
        $this->assign('cate_type',$tableCate);
        $this->assign('title','php程序员');
        $this->fetch('home/index.html');
    }
}