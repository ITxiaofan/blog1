<?php
namespace controllers;

class TestController{
    function register(){
         // 连接 Redis
         $redis = new \Predis\Client([
            'scheme' => 'tcp',
            'host'   => '127.0.0.1',
            'port'   => 32768,
        ]);
        // 消息队列
        $data = [
            'email' =>'1724940950@qq.com'
        ];
    }
    public function mail(){

    }

}