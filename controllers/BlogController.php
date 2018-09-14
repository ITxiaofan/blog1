<?php
namespace controllers;

use models\Blog;

class BlogController
{
    public function agreements_list(){
        $id = $_GET['id'];
        // 获取这个日志所有点赞的用户
        $model = new \models\Blog;
        $data = $modle->agreeList($id);
        // 转成JSON返回
        echo json_encode([
            'status_code' => 200,
            'data' => $data,
        ]);
    }
    public function makeExcel(){
        // 获取当前标签页
        $spreadsheet = new Spreadsheet();
        // 获取当前工作
        $sheet = $spreadsheet->getActiveSheet();
        // 设置第一行内容
        $sheet->setCellValue('A1','标题');
        $sheet->setCellValue('B1','内容');
        $sheet->setCellValue('C1','发表时间');
        $sheet->setCellValue('D1','是否公开');
        
        // 取出数据库中的日志
        $model = new \libs\Blog;
        // 获取最新的20个日志
        $blogs = $model->getNew();
        foreach($blogs as $v){
            $sheet->setCellValue('A'.$i,$v['title']);
            $sheet->setCellValue('B'.$i,$v['content']);
            $sheet->setCellValue('C'.$i,$v['created_at']);
            $sheet->setCellValue('D'.$i,$v['is_show']);
            $i++;
        }
        // 生成excel文件
        $writer = new Xlsx($spreadsheet);
        $write->save(ROOT . 'excel/'.$date.'.xlsx');
        
        // 下载
        // 调用header函数设置协议头，告诉浏览器开始下载文件
        // 下载文件路径
        $file = 'xxxx';
        // 下载时文件名
        $fileName = 'xxxx';
            
        //告诉浏览器这是一个文件流格式的文件    
        Header ( "Content-type: application/octet-stream" ); 
        //请求范围的度量单位  
        Header ( "Accept-Ranges: bytes" );  
        //Content-Length是指定包含于请求或响应中数据的字节长度    
        Header ( "Accept-Length: " . filesize ( $file ) );  
        //用来告诉浏览器，文件是可以当做附件被下载，下载后的文件名称为$file_name该变量的值。
        Header ( "Content-Disposition: attachment; filename=" . $fileName );    
            
        // 读取并输出文件内容
        readfile($file);
    }
    // 删除日志
    public function delete(){
        $id = $_POST['id'];

        $blog = new Blog;
        $blog->delete($id);
        message('删除成功',2,'/blog/index');
    }
    // 修改
    public function edit(){
        $id = $_GET['id'];
        // 根据ID取出日志的信息
        $blog = new Blog;
        $data = $blog->find($id);
        if($is_show == 1){
            $blog->makeHtml($id);
        }else{
            // 如果改为私有，就要将原来的静态页删除掉
            $blog->deleteHtml($id);
        }
        view('blogs.edit',[
            'data'=>$data
        ]);
    }
    public function update(){
        $title = $_POST['title'];
        $content = $_POST['content'];
        $is_show = $_POST['is_show'];
        $id = $_POST['id'];
        $blog = new Blog;
        $blog->update($title,$content,$is_show,$id);
        if($is_show == 1){
            $blog->makeHtml($id);
        }
        message('修改成功！',0,'/blog/index');

    }
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
        $display = $blog->getDisplay($id);
        // 返回多个数据时必须要用JSON
        echo json_encode([
            'display' => $display,
            'email' => isset($_SESSION['emsil']) ? $_SESSION['email'] : ''
        ]);
        
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
        $blog = new Blog;
        $blog->add($title,$content,$is_show);
        if($is_show == 1){
            $blog->makeHtml($id);
        }
        // 跳转
        message('发表成功',2,'/blog.index');
    }
    public function content(){
        // 接收ID，并取出日志信息
        $id = $_GET['id'];
        $model = new Blog;
        $blog = $model->find($id);
        // 判断这个日志是不是自己的日志
    if($_SESSION['id'] != $blog['user_id'])
    die('无权访问！');
    // 加载视图
    view('blogs.content',[
        'blog' => $blog,
    ]);
    }
}
