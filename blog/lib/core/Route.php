<?php
namespace core;

/**
 * 简单的路由处理，此框架路由不需要正则匹配
 * @author clm
 *
 */
class Route
{
    private static $route = [];
    
    public function __construct()
    {
      
    }
    public static function url()
    {
        $url = $_SERVER['REQUEST_URI'];
        if(is_file(OWNER_PATH.'/'.APP_NAME.'/config/route.php')){
           self::$route =  include OWNER_PATH.'/'.APP_NAME.'/config/route.php';
        }
        $get = '';
        if(strpos($url,'?')){
            $url = substr($url,0,strpos($url,'?'));
            $get = str_replace($url, '',  $_SERVER['REQUEST_URI']);
        }
        if(self::$route){
            foreach(self::$route as $k=>$va){
                if($k ==$url){
                    $url = $va;
                }
            }
        }
        $moduleArr = explode('/',$url);
        
        $url_module = '';
        if(isset($moduleArr['1']) && $moduleArr['1']){
            define('URL_MODULE',$moduleArr['1']);
        }else{
            define('URL_MODULE', DEFAULT_MODULE);
        }
        return $url.$get;
    }
}