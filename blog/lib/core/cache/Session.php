<?php
namespace core\cache;

use core\Config;

final class Session
{
    private static $config = [];
    private static $init = null;
    
    public function __construct()
    {
        self::init();
    }
    
    public static function init($name=[])
    {
       if(!self::$config){
           self::$config = array_merge(Config::get('session'),$name);
       }
       if(!self::$init){
           self::start();
       }
    }
    
    /**
     * 保存session
     */
    public static function set($name,$value,$prefix=null)
    {
        empty(self::$init) && self::start();
        if($prefix){
            $_SESSION[$prefix][$name] = $value; 
        }else if(isset(self::$config['prefix'])){
            $_SESSION[self::$config['prefix']][$name] = $value; 
        }else{
            $_SESSION[$name] = $value; 
        }
    }
    /**
     * 获取session
     */
    public static function get($name,$prefix=null)
    {
        empty(self::$init) && self::start();
        
        $value = null;
        if(isset($_SESSION[self::$config['prefix']][$name])){
            $value = $_SESSION[self::$config['prefix']][$name];
        }else if(isset($_SESSION[$name])){
            $value = $_SESSION[$name];
        }
        return $value;
    }
    /**
     * 清空session数据
     */
    public static function clear($prefix = null)
    {
        empty(self::$init) && self::start();
        $prefix = !is_null($prefix) ? $prefix : self::$config['prefix'];
        if ($prefix) {
            unset($_SESSION[$prefix]);
        } else {
            $_SESSION = [];
        }
    }
    /**
     * 删除session
     */
    public static function delete($name,$prefix=null)
    {
        if($prefix){
            if(isset($_SESSION[$prefix][$name])){
                unset($_SESSION[$prefix][$name]);
            }
        }else{
            if(isset($_SESSION[$name])){
                unset($_SESSION[$name]);
            }
        }
    }
     /**
     * 启动session
     */
    public static function start()
    {
        session_start();
        self::$init = true;
    }

    /**
     * 销毁session
     */
    public static function destroy()
    {
        if (!empty($_SESSION)) {
            $_SESSION = [];
        }
        session_unset();
        session_destroy();
        self::$init = null;
    } 
}