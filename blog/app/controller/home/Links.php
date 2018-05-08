<?php
namespace app\controller\home;

use app\controller\Common\home;

class Links extends  Common
{
    public function index()
    {
        $this->fetch('home/links.html');
    }
}