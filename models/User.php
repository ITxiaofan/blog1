<?php
namespace models;

use PDO;

class User extends Base
{
    public function getAll()
    {
        $stmt = self::$pdo->query('SELECT * FROM users');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // 设置头像
    public function setAvatar($path){
        $stmt = self::$pdo->prepare('UPDATE users SET avatar=? WHERE id=?');
        $stmt->execute([
            $path,
            $_SESSION['id'],
        ]);
        
    }
    // 获取余额
    public function getMoney(){
        $id = $_SESSION['id'];
        // 查询数据库
        $stmt = self::$pdo->prepare('SELECT money FROM users WHERE id = ?');
        $stmt->execute([$id]);
        $money = $stmt->fetch(PDO::FETCH_COLUMN);
        // 更新到SESSION中
        $_SESSION['money'] = $money;
        return $money;
    }
    // 为用户增加金额
    public function addMoney($money, $userId)
    {
        $stmt = self::$pdo->prepare("UPDATE users SET money=money+? WHERE id=?");
        return $stmt->execute([
            $money,
            $userId
        ]);
        // 更新 SESSION 中的余额
        $_SESSION['money'] += $money;
    }
    // 为用户增加金额

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
            $_SESSION['money'] = $user['money'];
            $_SESSION['avatar'] = $user['avatar'];
            return TRUE;
        }else{
            return FALSE;
        }
    }
}