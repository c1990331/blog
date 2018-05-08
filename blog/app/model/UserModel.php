<?php
namespace app\model;

use core\Model;

class UserModel extends Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function userList()
    {
       $user = $this->mongodb->select('clm_user',['status'=>(int)1],['user'=>1,'add_time'=>1],['limit'=>5]);
       return $user->toArray();
    }
}