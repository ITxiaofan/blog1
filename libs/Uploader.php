<?php
namespace libs;
class Uploader{
    // 不允许被new生成对象
    private function __construct(){}
        // 不允许被克隆
    private function __clone(){}
    // 保存唯一的对象
    private static $_obj = null;

    public static function make(){
        if(self::$_obj === null){
            self::$obj = new self;

        }
        return self::$_obj;
    }
    private $_root = ROOT . 'public/iploads/';
    private $_ext = ['image/jpeg','images/ejpeg','image/png','image/gif','image/bmp'];
    private $_maxSize = 1024*1024*1.8;  //允许上传的最大尺寸
    private $_file;
    private $_subDir;

    // 上传图片

    public function upload($name,$subdir){
        // 把用户图片的信息保存到属性上
        $this->_file = $_FILES[$name];
        $this->_subDir = $subdir;
        if(!$this->_checkType()){
            return in_array($this->file['type'],$this->_ext);
            // die ('图片类型不正确！');

        }
        if(!$this->_checkSize()){
            return $this->_file['size'] < $this->_makeSize;
            // die('图片尺寸不正确！');
        }
        // 创建目录
        $this->_makeDir();
        // 生成唯一的名字
        $name = $this->_makeName();
        // 移动图片
        move_uploaded_file($this->_file['tmp_name'],$this->_root.$dir.$name);
        // 返回上传之后的图片路径
        return $this->$dir.$name;
    }
    // 创建目录
    public function _makeDir(){
        
        $dir = $this->_subDir . '/' . date('Ymd');
        if(!is_dir($this->root . $dir)){
            // 第三个参数 TRUE 递归创建
            mkdir($this->_root . $dir, 0777,TRUE);
        }
        return $dir;
    }
    // 生成唯一的名字
    private function _makeName(){
        
        $name = md5(time().rand(1,9999));
        $ext = strrchr($_FILES['avatar']['name'],'.');
        return $name.$ext;
    }
    private function _checkType(){
        if(!in_array($this->_file['type'],$this->_ext))
        return false;

    }
    private function _checkedSize(){
        if($this->file['size'] > $this->_maxSize)
        return false;
    }



}