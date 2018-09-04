<?php
namespace libs;
class Redis{
    private $redis;

    private function __cloone(){}

    private function __construct(){} 

    public  static function getInstance(){
        
        if(self::Redis===null){
            // 连接 Redis
             $redis = new \Predis\Client([
                'scheme' => 'tcp',
                'host'   => '127.0.0.1',
                'port'   => 6379,
            ]);
        }
        return self::$redis;
    }
}