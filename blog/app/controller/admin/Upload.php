<?php
namespace app\controller\admin;

// use app\admin\controller\Common;

class Upload extends Common
{
    public function img()
    {
        $file = $_FILES;
        if(isset($file['editormd-image-file']) && isset($file['editormd-image-file']['tmp_name'])){
            $ext = strstr($file['editormd-image-file']['name'],'.');
            $fileName = time().rand(1000,10000).$ext;
            $rel = move_uploaded_file( $file['editormd-image-file']['tmp_name'],APP_PATH.'/public/images/admin/file/'.$fileName);
            if($rel){
                return $this->response_status(0,'',PUBLIC_URL.'/images/admin/file/'.$fileName); 
            }
            return $this->response_status(1,'图片上传失败');
        }
    }
}