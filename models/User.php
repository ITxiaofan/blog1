<?php
namespace models;

use PDO;

class User extends Base
{
    public function add($email,$password)
    {
        $stmt = $this->pdo->prepare("INSERT INTO users (email,password) VALUES(?,?)");
        return $stmt->execute([
                                $email,
                                $password,
                            ]);
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