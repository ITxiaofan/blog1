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
    // 开启事物
    public function startTrans(){
        self::$pdo->exec('start transaction');

    }
    // 提交事务
    public function commit(){
        self::$pdo->exec('commit');
    }
    // 回滚事务
    public function rollback(){
        self::$pdo->exec('rollback');
    }

}