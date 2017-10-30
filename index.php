<?php
/**
 *  1，定义常量
 *  2，加载函数库
 *  3，启动框架
 */
define('APP_NAME','app');
define('DEBUG',false);
if(DEBUG){
    ini_set('dispatch_error','on');
}else{
    ini_set('dispatch_error','off');
}


require __DIR__.'/lib/start.php';