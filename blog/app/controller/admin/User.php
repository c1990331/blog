<?php
namespace app\controller\admin;

use app\controller\admin\Common;
use core\Request;
use core\cache\Session;
use app\model\UserModel;

class User extends Common
{
    public function __construct()
    {
        parent::__construct();
    }
    public function index()
    {
        // 查询所有用户
        $user = new UserModel();
        $userList = $user->userList();
        $this->assign('userList',$userList);
        
        $this->assign('title','用户管理');
        $this->fetch('admin/users.html');
    }
   
}