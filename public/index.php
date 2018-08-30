<?php
// 定义常量
define('ROOT',dirname(__FILE__)."/../");
// 实现自动加载
function autoload($class){
    // $path = str_replace('\\','/',$class);
    require_once ROOT.str_replace('\\','/',$class).'.php';

}
spl_autoload_register('autoload');
// 添加路由：解析url上的路径：控制器/方法
// 获取url上的路径

if(isset($_SERVER['PATH_INFO'])){
    $pathInfo = $_SERVER['PATH_INFO'];
    // 根据/转成数组
    $pathInfo = explode('/',$pathInfo);
    // 得到控制器和方法名
    $controller = ucfirst($pathInfo[1]).'Controller';
    $action = $pathInfo[2];

}else{
    // 默认控制器和方法
    $controller = 'IndexController';
    $action = 'index';

}
//为控制器添加命名空间
$fullController = 'controllers\\'.$controller;
$_C = new $fullController;
$_C->$action();

// 加载视图
function view($viewFileName,$data=[]){
    // extract可以把数组解压成变量
    extract($data);
    $path = str_replace('.','/',$viewFileName).'.html';
    // 加载视图
    require(ROOT.'views/'.$path);
}
