<?php
namespace core;

use core\App;
use core\Config;
use core\Route;
use core\vendor\captcha\Captcha;
use SebastianBergmann\Environment\Runtime;

final class Start
{
	private static $classFile;
    public static function run()
    {
         //初始化配置
        self::_set_const();
        self::_create_dir();

        Config::load();
        App::run();
        self::twig();
//         $captcha = new Captcha();
    }
    public static function twig()
    {
        // 定义模板目录
        $loader = new \Twig_Loader_Filesystem(CORE_PATH.'tpl');
        //初始化
        $twig = new \Twig_Environment($loader,[
            'cache'=>RUNTIME_PATH.'/twig',
            'debug'=>true,
        ]);
       print_r($twig);die;
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
        define('TWIG_PATH',CORE_PATH.'/vendor/twig/twig/lib/Twig/Loader/'); // 其他核心类库
       
        define('APP_PATH',OWNER_PATH.'/'.APP_NAME);
        define('APP_COMMON_PATH',APP_PATH.'/common');
        define('APP_CONFIG_PATH',APP_PATH.'/config');
        define('RUNTIME_PATH',APP_PATH.'/runtime'); // 其他核心类库
        define('APP_CONTROLLER_PATH',APP_PATH.'/controller');
        define('APP_MODEL_PATH',APP_PATH.'/model');
        define('APP_PUBLIC_PATH',APP_PATH.'/public');
        define('APP_VIEW_PATH',APP_PATH.'/view');

    }
    
    /**
     * 创建应用目录
     */
    private static function _create_dir()
    {
        $arr = [
            APP_PATH,
            APP_COMMON_PATH,
            APP_CONFIG_PATH,
            APP_MODEL_PATH,
            APP_PUBLIC_PATH,
            APP_VIEW_PATH,
        ];
        foreach($arr as $va){
            is_dir($va) || mkdir($va,0777,true);
        }
    }
     // 自动加载
    public static function autoload($class)
    {
    	if(isset(self::$classFile[$class])){
    		return true;
    	}
    	$arr = [
    		ROOT_PATH,
    		CORE_PATH,
    		TPL_PATH,
    		CACHE_PATH,
    		TEMPLATE_PATH,
    	    VENDOR_PATH,
    	    TWIG_PATH,
    	];
    	foreach($arr as $val){
    		if(is_file($val.'/'.$class.'.php')){
    			include $val.'/'.$class.'.php';
    			self::$classFile[$class] = $class;
    			return true;
    		}else{
    			return false;
    		}
    	}
    }
}

spl_autoload_register('core\Start::autoload');
\core\Start::run();