<?php
namespace core;

final class Config
{
    private static $config;
    
    public static function load()
    {
        self::_appConst();
        $file = APP_CONFIG_PATH.'/config.php';
        
        if(is_file($file)){
             self::set(self::$config,include $file);
        }
        if(isset(self::$config['config_load'])){
            foreach(self::$config['config_load'] as $val){
                if(is_file(APP_CONFIG_PATH.'/'.$val.'.php')){
                    self::set($val,include APP_CONFIG_PATH.'/'.$val.'.php');
                }
            }
        }
    }
    /**
     * 配置一些应用框架路径常量
     */
    private static function _appConst()
    {
        
        define('HOST_NAME',isset($_SERVER['SERVER_NAME'])?'//'.$_SERVER['SERVER_NAME']:'');
        define('APP_PATH',OWNER_PATH.'/'.APP_NAME);
        define('APP_CONFIG_PATH',APP_PATH.'/config');
        define('RUNTIME_PATH',APP_PATH.'/runtime'); // 其他核心类库
        // namespace
        define('NAMESPACE_APP','\\'.APP_NAME.'\\controller\\'.URL_MODULE.'\\');
    }
    /**
     * 
     * @param  $name
     * @return param
     */
    public static function get($name)
    {
        if(isset(self::$config[strtolower($name)])){
            return self::$config[strtolower($name)];
        }
        return ;
    }
    
    /**
     * 
     * @param  $name 
     * @param  $value
     * @return void|boolean
     */
    public static function set($name,$value=null)
    {
        if(is_string($name)){
            return self::$config[strtolower($name)] = $value;
        }else if(empty($name)){
            return self::$config = $value;
        }
        return;
    }
    
}