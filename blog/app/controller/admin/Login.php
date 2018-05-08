<?php
namespace app\controller\admin;

use core\Controller;
use core\cache\Session;
use core\Request;

class Login extends Controller
{
   
        /**
         * 登录
         */
        public function login()
        {
            $_id = Session::get('key');
            if(!empty($_id)){
                redirect('/admin/user/index');
            }
            $this->assign('title', '请登录！');
            $this->fetch('admin/login.html');
        }
        /**
         * 登录验证
         */
        public function pwdLogin()
        {
            $post = Request::post();
            if(!isset($post['name']) || !isset($post['password']) || !preg_match('/^\w+$/',$post['password'])){
                $this->response_status(1,'用户名或者密码错误！');
            }
            $user = $this->mongodb->select('clm_user',['user'=>$post['name']],['password'=>1,'_id'=>1],['limit'=>1])->toArray();
            
            if($user){
                if(md5($post['password']) == $user['0']->password){
                    Session::set('key', $user['0']->_id);
                    Session::set('name', $post['name']);
                    $this->response_status(0,'登录成功！',array('url'=>'/admin/user/index'));
                }else{
                    $this->response_status(1,'密码错误！');
                }
            }else{
                $this->response_status(1,'当前用户不存在！');
            }
        }
        /**
         * 退出登录
         */
        public function loginOut()
        {
            Session::clear();
            redirect('/admin/login/login','退出成功！',2);
        }
}