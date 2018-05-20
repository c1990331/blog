<?php
namespace app\controller\home;

use app\controller\home\Common;
use core\Request;

class Article extends Common
{
   public function index()
   {
       echo header("Access-Control-Allow-Origin:*");  
       $cate = Request::get('cate');
       $id = Request::get('id');
       $categorys = $this->cates;
       $cates = [];
       $table = [];
       foreach($categorys as $val){
           if($val->category_id){
               $cates[] = $val->category_id;
               $table[$val->category_id] = $val->category_name;
           }
       }
       $tableName = '';
       if(!empty($id) && isset($table[$cate])){
           $tableName = str_replace(' ', '', strtolower('clm_'.$table[$cate]));
       }
       $article =  [];
       if($tableName){       
           try{
               $article = $this->mongodb->select($tableName,['status'=>['$ne'=>0],'_id'=>new \MongoDB\BSON\ObjectId($id)],['status'=>0]);
           }catch(\Exception $e){
               return $this->fetch('home/404.html');
           }
        
       }
       $article = $article?$article->toArray()[0]:[];
       $title = isset($article->title)?$article->title:'php程序员';
       $cates = isset($table[$cate])?$table[$cate]:'';
       $this->assign('title',$title);
       $this->assign('param_cate',$cate);
       $this->assign('cate_type',$cates);
       $this->assign('article',$article);
       return $this->fetch('home/article.html');
   }
}