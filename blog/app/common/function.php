<?php

if(!function_exists('redirect')){
    function redirect($url,$message='',$time=0)
    {
        if($message){
            echo '<div style="background-color:#A38F99;width:90%;height:35px;margin:50 auto;line-height:35px;text-align:center;">'.$message.'</div>';
        }
        if($time){
            header("refresh:3;url=$url");
        }else{
            header("Location: $url",$time);  
        }
        exit;
    }
}

if(!function_exists('object_array')){
    function object_array($array) {
        if(is_object($array)) {
            $array = (array)$array;
        } if(is_array($array)) {
            foreach($array as $key=>$value) {
                $array[$key] = object_array($value);
            }
        }
        return $array;
    }
}