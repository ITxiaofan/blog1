<?php
namespace controllers;
use models\User;
class UserController{
    public function hello(){
        // 取数据
        $user = new User;
        $name = $user->getName();
        // 加载视图
      return  view('users.hello',['name'=>$name]); 
    }
   
}
