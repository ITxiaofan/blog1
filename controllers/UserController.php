<?php
namespace controllers;

// 引入模型类
use models\User;
use models\Order;
use Intervention\Image\ImageManaerStatic as Image;
class UserController
{
    public function setavatar(){
        // 上传新头像
        $upload = \libs\Uploader::make();
        $path = $upload->upload('avatar','avatar');
        //裁切图片
        $image = Image::make(ROOT.'public/uploads/'.$path);
        $image->crop((int)$_ROOT['w'],(int)$_POST['h'],(int)$_POST['x'],(int)$_POST['y']);
        // 保存时覆盖
        $image->save(ROOT.'/public/uploads/'.$path);
        // 保存到user表中
        $model = new \models\User;
        $model->setAvatar('/uploads'.$path);
        @unlink(ROOT.'public'.$_SESSION['avatar']);
        // 设置新头像
        $_SESSION['avatar'] = '/uploads/'.$path;
        message('设置成功',2,'/blog/index');
    }
    public function uploadbig(){
        $count =  $_POST['count'];
        $i = $_POST['i'];
        $size = $_POST['size'];
        $img = $_FILES['img'];

        // 把每个图片保存到服务器中
        move_uploaded_file($img['tmp_name'],ROOT.'tmp/'.$i);

        $redis = \libs\Redis::make();
        $uploadedCount = $redis->incr('conn_id');
        
        if($uploadedCount == $count){
            $fp = fopen(ROOOT.'public.uploads/big/'.$name.'png','a');
            // 循环所有的分片
            for($i=0;$i<$count;$i++){
                fwrite($fp,file_get_contents(ROOT.'tmp/'.$i));
                // 删除第i号文件
                unlink(ROOT.'tmp/'.$i);
            }
            // 关闭文件
            fclose($fp);
            // 从redis中删除这个文件对应的编号这个位置
            $redis->del($name);

        }
    }
    public function uploadall(){
        echo "<pre>";
        var_dump($_FILES);
        // 先创建目录
        $root = ROOT.'public/uploads/';
        // 获取 今天日期 
        $date = date('Ymd');
        if(!is_dir($root.$date)){
            // 创建目录
            mkdir($root,$date,0777);
        }
        foreach ($_FILES['images'] as $k => $v){
            $name = md5(time().rand(1,9999));
            $ext = strrchr($v,'.');
            $name = $name.$ext;
            // 根据name的下标找到对应的文件
            move_uploaded_file($_FILES['avatar']['tmp_name'][$k],$root.$date.'/'.$name);
            echo $root.$date.'/'.$name.'<hr>';
        } 
    }
    
    public function album(){
        view('user.album');
    }
    // 设置头像方法
    public function setavatar(){
        $upload = \libs\Uploader::make();
        $path = $upload->upload('avatar','avatar');
        // 保存到user表中
        $model = new \models\User;
        $model->setAvatar('/uploads/'.$path);
        // 删除原头像
        @unlink( ROOT . 'public'.$_SESSION['avatar']);
        // 设置新头像
        $_SESSION['avatar'] = '/uploads/'.$path;
        message('设置成功',2,'/blog/index');
    }

    public function avatar(){
        view('users.avatar');
    }
    public function docharge(){
        // 生成订单
        $money = $_POST['money'];
        $model = new Order;
        $model->create($money);
        message('充值订单已生成，请立即支付！',2,'/user/orders');
    }
    // 列出所有订单
    public function orders(){
        $order = new Order;
        // 搜索数据
        $data = $order->search();
        // 加载视图
        view('users.order', $data);
    }
    public function charge(){
        view('users.charge');
    }
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
    public function create(){
        view('blogs.create');
    }
}
