<?php
namespace libs;
class Log{
    private $fp;
    public function __construct($fileNmae){
        $this->fp = fopen(ROOT.'logs/'.$fileNmae.'.log','a');
    }
    public function log($content){
        // 获取当前时间
        $date = date('Y-m-d H:i:s');
        $c = $date."\r\n";
        $c .=str_repeat('=',120)."\r\n";
        $c .=$content."\r\n\r\n";
        fwrite($this->fp,$c);
    }
}