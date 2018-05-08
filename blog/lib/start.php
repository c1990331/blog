<?php
namespace core;

use core\App;
use core\Config;
use core\Route;

final class Start
{
	private static $classFile;
    public static function run()
    {
         //初始化配置
        self::_set_const();
        $url = Route::url();
       
        Config::load();

        self::_create_dir();
        App::run($url);
    }
    
    private static function _set_const()
    {
        $path = str_replace('\\', '/', __FILE__);
        
        define('OWNER_VERSION','1.0');
        define('ROOT_PATH',dirname($path));
        define('OWNER_PATH',dirname(ROOT_PATH));
        define('CORE_PATH',ROOT_PATH.'/core'); // 核心文件
        define('TPL_PATH',CORE_PATH.'/tpl'); //公共模板文件  比如展示hello world
        define('CACHE_PATH',CORE_PATH.'/cache'); // 缓存配置文件  redis memacached session
        define('TEMPLATE_PATH',CORE_PATH.'/template'); // 生成、检测模板缓存  
        define('COMMON_PATH',CORE_PATH.'/common'); // 存放函数文件
        define('VENDOR_PATH',CORE_PATH.'/vendor/captcha'); // 其他核心类库
        define('TWIG_PATH',CORE_PATH.'/vendor/twig/lib/Twig'); // 其他核心类库
    }
    
    /**
     * 创建应用目录
     */
    private static function _create_dir()
    {
        $arr = [
            APP_PATH,
            APP_PATH.'/common',
            APP_PATH.'/config',
            APP_PATH.'/model',
            APP_PATH.'/public',
            APP_PATH.'/view',
        ];
        foreach($arr as $va){
            is_dir($va) || mkdir($va,0777,true);
        }
        // 引入函数
        if(is_file(APP_PATH.'/common/function.php')){
            include APP_PATH.'/common/function.php';
        }
        if(is_file(ROOT_PATH.'/'.APP_NAME.'/common/function.php')){
            include ROOT_PATH.'/'.APP_NAME.'/common/function.php';
        }
    }
     // 自动加载
    public static function autoload($class)
    {
        $class = str_replace('\\', '/', $class);
    	if(isset(self::$classFile[$class])){
    		return true;
    	}
    	$arr = [
    		ROOT_PATH,
    	    TWIG_PATH,
    	    OWNER_PATH,
    	];
    	foreach($arr as $val){
    		if(is_file($val.'/'.$class.'.php')){
    			include $val.'/'.$class.'.php';
    			self::$classFile[$class] = $class;
    			return true;
    		}
    	}
    }
}

spl_autoload_register('core\Start::autoload');
\core\Start::run();