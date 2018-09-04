<?php
namespace libs;
class Redis{
    public function __construct()
    {
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