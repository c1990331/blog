<?php
namespace core;

use core\Config;
use core\cache\Session;

class App
{
    public function __construct()
    {
    	
    }
    /**
     * 初始化配置文件和路由
     */
    public static function init()
    {
    	Config::load();
    	Session::init(['prefix'=>'core']);
//     	print_r(Config::get('session'));
    }
}