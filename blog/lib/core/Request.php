<?php
namespace core;

class Request
{
    public static function get($param='')
    {
        $arr = $_GET;
        if($param){
            if(isset($arr[$param])){
                return $arr[$param];
            }
            return '';
        }
        
        return $_GET;
    }
    public static function post($param='')
    {
        $arr = $_POST;
        if($param){
            if(isset($arr[$param])){
                return $arr[$param];
            }
            return '';
        }
        return $_POST;
    }
    public static function param($param='')
    {
        if(!empty($param)){         
            $get = isset($_GET[$param])?$_GET[$param]:'';
            $post = isset($_POST[$param])?$_POST[$param]:'';
            if(isset($_GET[$param])){
                return $_GET[$param];
            }
            if(isset($_POST[$param])){
                return $_POST[$param];
            }
            return '';
        }
        return array_unique(array_merge($_GET,$_POST));
    }
}