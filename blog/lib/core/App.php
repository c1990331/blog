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
    /**
     * 加载控制器和方法
     */
    public static function run()
    {
        print_r(file_get_contents('php://input'));
    }
}