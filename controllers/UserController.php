<?php
namespace controllers;
use models\User;
class UserController{
    public function register(){
        view('user.add');
    }
    public function hello(){
        // 取数据
        $user = new User;
        $name = $user->getName();
        // 加载视图
      return  view('users.hello',['name'=>$name]); 
    }
    function store(){
        // 接收表单
        $email = $_POST['email'];
        $password = md5($_POST['password']);
    }
   
}
