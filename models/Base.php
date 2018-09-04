<?php
namespace models;
use PDO;

class Base {
    // 保存 PDO 对象
    public static $pdo;

    public function __construct()
    {
        if(self::$pdo === null){
            $config = config('db');
             // 取日志的数据
            self::$pdo = new \PDO('mysql:host='.$config['host'].';dbname='.$config['dbname'], $congfig['user'], $config['pass']);
            self::$pdo->exec('SET NAMES '.$config['charset']);
        }
       
    }

}