<?php
$host="127.0.0.1";
$dbname="blog";
$user = 'root';
$pass = '123456';
 // 连接数据库
 $pdo = new PDO("mysql:host={$host};dbname={$dbname}",$user,$pass);
 $pdo->exec("set names utf8");
 // 插入数据
 $pdo->exec("insert into blogs (title,content) values('标题4','内容4')");
// 修改数据
// $pdo->exec("update blogs set title='标题1',content='内容2' where id=1");
// 删除数据
// $pdo->exec("delete from blogs");
// 清除数据
// $pdo->exec("truncate blogs");
$ret = $pdo->exec("update blogs set title='天天',content='好心情' where id=4");
if($ret === FALSE){
    die("出错了");
}
$ret = $pdo->query("select * from blogs where title like '%心%'");
// $ret->fetch();
// $ret->fetchAll();
$stmt = $pdo->prepare('select * from blogs where id = ? or title= ? ');
$stmt->execute([5,'标题4']);
$stmt = $pdo->prepare("select * from blogs where id=:id or title=':title'");
$stmt->execute([
        ':id' => 6,
        ':title' => '标题5'
    ]);
    $data = $stmt->fetchAll();

$stmt = $pdo->prepare('insert into blogs(id,titel,content) values (6,?,?)');
$ret = $stmt->execute([
    '铎铎',
    '对自己好点，多休息，这几天累'
   ]);
   if($ret){
       echo "添加成功新纪录的ID=".$pdo->lastInsertId();

   }else{
    //    获取失败的原因
    $error = $stmt->errorInfo();
    var_dump($error);
   }