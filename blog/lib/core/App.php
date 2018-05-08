<?php
namespace core;

use core\Config;
use core\cache\Session;
use core\View;

class App
{
    protected static $action = null;
    protected static $method = null;
    
    /**
     * 初始化配置文件和路由
     */
    public static function init()
    {
    	Config::load();
    	Session::init(['prefix'=>'core']);
    	self::run();
    }
    /**
     * 加载控制器和方法
     */
    public static function run($url)
    {
        if(isset($url)){
            if($url !== '/'){
                $arr = explode('/', $url);
                if(isset($arr['2'])){
                    self::$action = ucfirst($arr['2']);
                }
                if(isset($arr['3'])){
                    self::$method = strstr($arr['3'],'?')?substr($arr['3'],0,strpos($arr['3'],'?')):$arr['3'];
                }
                if(strstr(self::$action,'.html')){
                    self::$action = str_replace('.html', '', self::$action);
                    self::$method = 'index';
                }
                if(strstr(self::$method,'.html')){
                    self::$method = str_replace('.html', '', self::$method);
                }
                
            }
            self::$action = self::$action?self::$action:'Index';
            self::$method = self::$method?self::$method:'index';
            $file = APP_PATH.'/controller/'.URL_MODULE.'/'.self::$action.'.php';
            if(is_file($file)){
                include $file;
                $action = NAMESPACE_APP.self::$action;
                $controller = new $action;
                $method = self::$method;
                if(!class_exists($action)){
                    if(DEBUG){
                        throw new \Exception('class no found ');
                    }else{
                        View::fetch('home/404.html');
                    }
                }
                if(method_exists($controller,$method)){
                    $controller->$method();
                }else{
                    if(DEBUG){
                        throw new \Exception('method no found ');
                    }else{
                        View::fetch('home/404.html');
                    }
                }
            }else{
                View::fetch('home/404.html');
            }
        }
    }
}