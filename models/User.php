<?php
namespace models;

use PDO;

class User extends Base
{
    public function add($title,$content,$is_show)
    {
        $stmt = self::$pdo->prepare("INSERT INTO blogs(title,content,is_show,user_id) VALUES(?,?,?,?)");
        $ret = $stmt->execute([
            $title,
            $content,
            $is_show,
            $_SESSION['id']
        ]);
        if(!$ret){
            echo '失败';
            // 获取失败信息
            $error = $stmt->errorInfo();
            echo '<pre>';
            var_dump($error);
            exit;
        }
        // 返回新插入的记录的ID
        return self::$pdo->lastInsertId();
    }
    public function login($email,$password){
        $stmt = self::$pdo->prepare('SELEST * FROM users WHERE email = ? AND passqord = ?');
        $stmt = execute([
            $email,
            $password
        ]);
        $user = $stmt ->fetch(\PDO::FETCH_ASSOC);
        if($user){
            $_SESSION['id'] = $user['id'];
            $_SESSION['email'] = $user['email'];
            return TRUE;
        }else{
            return FALSE;
        }
    }
}