<?php
/**
 *  1，定义常量
 *  2，加载函数库
 *  3，启动框架
 *  4，测试一个，packagist是否自动更新
 */
date_default_timezone_set('PRC');

define('APP_NAME','app');
define('DEFAULT_MODULE','home');
define('DEBUG',true);


if(DEBUG){
    ini_set('dispatch_error','on');
}else{
    ini_set('dispatch_error','off');
}

require __DIR__.'/lib/start.php';
