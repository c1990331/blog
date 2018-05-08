<?php
namespace app\controller\home;

use app\controller\home\Common;

class Category extends  Common
{
    public function index()
    {
        $this->fetch('hoem/category.html');
    }
}