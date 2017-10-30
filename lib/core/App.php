<?php
namespace core;

use core\Config;

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
    }
}