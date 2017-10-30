<?php

if(!function_exists('p')){
    function p($arr)
    {
        echo '<pre>';
        print_r($arr);
        echo '</pre>';
    }
}