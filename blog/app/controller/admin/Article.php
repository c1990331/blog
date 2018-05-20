<?php
namespace app\controller\admin;

use app\controller\admin\Common;
use core\Request;

class Article extends Common
{
    /**
     * 编辑添加文章
     */
    public function file()
    {
        $type = Request::get('cate');
       
        $this->assign('type', $type);
        return $this->fetch('admin/file.html');
    }
    /**
     * 添加文件
     */
    public function addFile()
    {
        $param = Request::post();
       
        if(isset($param['type'])){
            if(empty($param['title'])){
                return $this->response_status(1,'标题错误！');
            }
            if(empty($param['desc'])){
                return $this->response_status(1,'描述为空！');
            }
            if(empty($param['article'])){
                return $this->response_status(1,'内容为空！');
            }
           $table = 'clm_'.str_replace(' ','',strtolower($param['type']));
           $arr = [
               'title'=>$param['title'],
               'status'=>(int)1,
               'description'=>$param['desc'],
               'content'=>$param['article'],
               'add_time'=>(int)time(),
           ];
           $rel = $this->mongodb->insert($table,$arr);
           if($rel)return $this->response_status(0,'添加成功！',['url'=>'/admin/category/categorys?cate='.$param['type']]);
           return $this->response_status(1,'添加失败！');
        }
        return $this->response_status(1,'参数错误！');
    }
    /**
     * 编辑文件
     */
    public function editFile()
    {
        $param = Request::post();
        if(empty($param['id']))return $this->response_status(1,'文章ID错误！');
        if(isset($param['type'])){
            if(empty($param['title'])){
                return $this->response_status(1,'标题错误！');
            }
            if(empty($param['desc'])){
                return $this->response_status(1,'描述为空！');
            }
            if(empty($param['article'])){
                return $this->response_status(1,'内容为空！');
            }
            if(empty($param['status']) || !in_array($param['status'],[1,2,3,4])){
                return $this->response_status(1,'状态错误！');
            }
           $table = 'clm_'.str_replace(' ','',strtolower($param['type']));
           if($table=='clm_lifeessays' && in_array($param['status'],[3,4])){
               switch ($param['status']){
                   case 3:// 首页更多文章 8
                       $life = count($this->mongodb->select($table,['status'=>3],['status'=>0,'title'=>0,'content'=>0,'description'=>0]));
                       if($life >= 6){
                          return $this->response_status(1,'更多文章推荐已存在6篇！');
                       }
                       
                       break;
                   case 4:// 生活随笔 1
                       
                       $life = $this->mongodb->select($table,['status'=>(int)4,'_id'=>['$ne'=>new \MongoDB\BSON\ObjectId($param['id'])]],['status'=>0,'title'=>0,'content'=>0,'description'=>0]);
                       $count = count($life->toArray());
                       if($count >= 1){
                         return  $this->response_status(1,'生活随笔置顶状态已存在！');
                       }
                       break;
               }
           }
           $arr = [
               'title'=>$param['title'],
               'status'=>(int)$param['status'],
               'description'=>$param['desc'],
               'content'=>$param['article'],
               'add_time'=>(int)time(),
           ];
           $rel = $this->mongodb->update($table,$arr,['_id'=>new \MongoDB\BSON\ObjectId($param['id'])]);
           if($rel)return $this->response_status(0,'编辑成功！',['url'=>'/admin/category/categorys?cate='.$param['type']]);
           return $this->response_status(1,'编辑失败！');
        }
        return $this->response_status(1,'参数错误！');
    }
    /**
     * 详情页
     */
    public function detail()
    {
        $post = Request::post();
        $param = Request::get();
        if(empty($param['cate'])) {
            redirect('admin/user/index');exit;
        }
        if(empty($param['id'])) {
            redirect('admin/user/index');exit;
        }
        $table = str_replace(' ','','clm_'.strtolower($param['cate']));
        $rel = $this->mongodb->select($table,['_id'=>new \MongoDB\BSON\ObjectId($param['id'])]);
        $arr = [];
        if($rel){
            $arr = $rel->toArray();
            $arr = isset($arr['0'])?$arr['0']:$arr;
        }
        
        $this->assign('type',$param['cate']);
        $this->assign('id',$param['id']);
        $this->assign('article',$arr);
        return $this->fetch('admin/detail.html');
    }
}