<?php
namespace core;

final class Config
{
    private static $config;
    
    public static function load()
    {
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