<?php
namespace core;

use core\View;
use core\db\Mongodb;

class Controller
{
    protected $mongodb;
    
    public function __construct()
    {
        $this->mongodb = new Mongodb();
       
//         $rel = $this->mongodb->select('user',[],['user'=>1,'_id'=>0]);
//         foreach($rel as $re){
//             print_r($rel);
//         }
//         die;
//         print_r($this->mongodb);die;
    }
    
    public function fetch($template)
    {
        View::fetch($template);
    }
    
    public function assign($name,$value){
        View::assign($name,$value);
    }
    public function page($count,$page,$url='',$size = 10)
    {
        return View::page($count,$page,$url,$size);
    }
    protected function response_status($code=0,$message='',$data=[])
    {
        $arr = [
            'code'=>$code,
            'msg'=>$message,
            'data'=>$data,
        ];
        echo json_encode($arr);
        exit;
    }
}