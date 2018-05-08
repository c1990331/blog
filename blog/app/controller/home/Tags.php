<?php
namespace app\controller\home;

use \app\controller\home\Common;

class Tage extends Common
{
    public function index()
    {
        $this->fetch('home/tags.html');
    }
}