<?php
namespace controllers;

// 引入模型类
use models\User;

class UserController
{
    public function login(){
        // 接收传过来的数据
        $email = $_POST['email'];
        $password = md5($_POST['password']);
        $user = new \models\User;
        if($user->login($email,$password)){
            die('登录成功!');
        }else{
            die('用户名和密码错误！');

        }
        view('users.login');
    }
    public function logout(){
        // 清空session
        $_SESSION=[];
        die('退出成功！');
    }
    public function dologin(){
        // 接收表单
        $email = $_POST['email'];
        $password = $_POST['password'];
        // 使用模型登录
        $user = new User;
        if($user->login($email,$password)){
            message('登陆成功！',2,'/blog/index');


        }else{
            message('账号或密码错误！',1,'/user/login');
        }
    }
    public function register()
    {
        // 显示视图
        view('users.add');
    }

    public function hello()
    {
        // 取数据
        $user = new User;
        $name = $user->getName();

        // 加载视图
        view('users.hello', [
            'name' => $name
        ]);
    }

    public function world()
    {
        echo 'world';
    }

    public function store()
    {
        // 1. 接收表单
        $email = $_POST['email'];
        $password = md5($_POST['password']);

        // 2. 插入到数据库中
        $user = new User;
        $ret = $user->add($email, $password);
        if(!$ret)
        {
            die('注册失败！');
        }
        $mail = new \libs\Mail;
        $content = '恭喜您，注册成功！';
        // 3. 把消息放到队列中

        // 从邮箱地址中取出姓名 
        $name = explode('@', $email);
        // 构造收件人地址[    fortheday@126.com   ,    fortheday  ]
        $from = [$email, $name[0]];

        // 构造消息数组
        $message = [
            'title' => '欢迎加入全栈1班',
            'content' => "点击以下链接进行激活：<br> <a href=''>点击激活</a>。",
            'from' => $from,
        ];
        // 把消息转成字符串(JSON ==> 序列化)
        $message = json_encode($message);

        // 放到队列中
        $redis = \libs\Radis::getInstance();

        $redis->lpush('email', $message);

        // echo 'ok';
        redirect('/user/login');

    }
}
