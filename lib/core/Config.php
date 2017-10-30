<?php
namespace core;

final class Config
{
    private static $config;
    
    public static function load()
    {
        if(is_file(APP_CONFIG_PATH.'/config.php')){
            require APP_CONFIG_PATH.'/config.php';
            if(isset($config)){
	            self::$config = $config;
            }
        }
        
        if(isset(self::$config['config_load'])){
            foreach($file as $val){
                if(is_file(APP_CONFIG_PATH.'/'.$val.'.php')){
                    require APP_CONFIG_PATH.'/'.$val.'.php';
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
        if(isset(self::$file[strtoupper($name)])){
            return self::$file[strtoupper($name)];
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
            self::$file[strtoupper($name)] = $value;
            return  true;
        }
        return;
    }
    
}