<?php
namespace models;
class User{
    public function getName(){
        return '铎铎';
    }
    function add(){
        $this->prepare("insert into users (email,password) values ('1724940950@qq.com')");
    }
}

?>