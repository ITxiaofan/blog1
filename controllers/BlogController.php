<?php
namespace controllers;

use models\Blog;

class BlogController
{
    // 日志列表
    public function index()
    {
        $blog = new Blog;
        // 搜索数据
        $data = $blog->search();
        // 加载视图
        view('blogs.index', $data);
    }

    // 为所有的日志生成详情页
    public function content_to_html()
    {
        $blog = new Blog;
        $blog->content2html();
    }

    public function index2html()
    {
        $blog = new Blog;
        $blog->index2html();
    }

    public function display()
    {
        // 接收日志ID
        $id = (int)$_GET['id'];

        $blog = new Blog;
        echo $blog->getDisplay($id);
        
    }

    public function displayToDb()
    {
        $blog = new Blog;
        $blog->displayToDb();
    }
    public function store(){
        $title = $_POST['title'];
        $content = $_POST['content'];
        $is_show = $_POST['is_show'];

        $blog->add($title,$content,$is_show);
        // 跳转
        message('发表成功',2,'/blog.index');
    }
}
