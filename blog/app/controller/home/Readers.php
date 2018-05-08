<?php
namespace app\controller\home;

use app\controller\home\Common;

class Readers extends Common
{
    public function index()
    {
        $this->fetch('hoem/readers.html');
    }
}