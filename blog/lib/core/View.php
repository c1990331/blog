<?php
namespace core;

class View
{
    private static $data = [];
    /**
     * Twig 初始化
     */
    public static function init()
    {
        
        include TWIG_PATH.'/Autoloader.php';
        \Twig_Autoloader::register();
        // 定义模板目录
        $loader = new \Twig_Loader_Filesystem(APP_PATH.'/view');
        
        //初始化
        $twig = new \Twig_Environment($loader,[
            'cache'=>DEBUG?false:RUNTIME_PATH.'/twig',
            'debug'=>DEBUG,
        ]);
        return $twig;
    }
    /**
     * 模板赋值
     */
    public static function assign($name,$value=null)
    {
        if(is_array($name)){
            self::$data = array_merge(self::$data,$name);
        }else{
            self::$data[$name] = $value;
        }
    }
    /**
     * 加载视图文件
     */
    public static function fetch($template)
    {
        $twig = self::init();
        $template = $twig->loadTemplate($template);
        echo $template->render(self::$data);
    }
    /**
     * 分页
     */
    public static function page($count,$page,$url='',$size = 10)
    {
        $url = strstr($url,'?')?$url:$url.'?';
        $str = '<div class="pub_pagination"><ul class="pagination">';
        if($count==0 || empty($count)){
            $str .= '<li class="disabled"><span>«</span></li><li class="disabled"><a>»</a></li></ul></div>';
        }else{
            $len = ceil($count/$size);
            $len = min(10,$len);
            if($page==1){
                $str .= '<li class="disabled"><span>«</span></li>';
            }else{
                $str .= '<li><a href="'.$url.'&page='.($page-1).'">«</a></li>';
            }
            for($i=1;$i<=$len;){
                if($page==$i){
                    $str .= '<li class="active"><span>'.$i.'</span></li>';
                }else{
                    $str .= '<li><a href="'.$url.'&page='.$i.'">'.$i.'</a></li>';
                }
                $i++;
            }
            if($page == $len){
                $str .= '<li class="disabled"><span>»</span></li>';
            }else{                
                $str .= '<li><a href="'.$url.'&page='.($page+1).'">»</a></li>';
            }
            $str .= '</ul></div>';
        }
        return $str;
    }
}