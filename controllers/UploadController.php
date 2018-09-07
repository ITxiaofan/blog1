<?php
namespace controllers;
class UploadController{
    public function upload(){
        // 接收图片
        $file = $FILES['image'];
        // 随机生成文件名
        $name = time();
        // 移动图片
        move_uploaded_file($file['tmp_name'],ROOT.'public/uploads/'.$name.'.png');
        // 把数组转成JSON并返回
        echo json_encode([
            'success'=>true,
            'file_path'=>'/public/uploads/'.$name.'.png'
        ]);
    }
}