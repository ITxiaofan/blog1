<?php
namespace models;
use PDO;
class Order extends Base{
    //设置订单已支付的状态
    public function setPaid($sn){
        $stmt = self::$pdo->prepare("UPDATE orders SET status=1,pay_time=now() WHERE sn=?");
        return $stmt->execute([
            $sn
        ]);
    }
    // 根据编号从数据库中取出订单
    public function findBysn($sn){
        $stmt = self::$pdo->prepare('SELECT * FROM orders WHERE sn=?');
        $stmt->execute([
            $sn
        ]);
        // 取数据
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function create($money){
        $stmt = self::$pdo->prepare('INSERT INTO orders(user_id,money,sn) VALUES(?,?,?)');
        $stmt->execuute([
            $_SESSION['id'],
            $money,
            $flake->nextId()
        ]);
    }
    // 搜索订单
    public function search()
    {
        // 设置的 $where
        $where = 'user_id'.$_SESSION['id'];
        /***************** 排序 ********************/
        // 默认排序
        $odby = 'created_at';
        $odway = 'desc';

        /****************** 翻页 ****************/
        $perpage = 15; // 每页15
        $page = isset($_GET['page']) ? max(1,(int)$_GET['page']) : 1;

        $offset = ($page-1)*$perpage;

        $stmt = self::$pdo->prepare("SELECT COUNT(*) FROM orders WHERE $where");
        $stmt->execute();
        $count = $stmt->fetch( PDO::FETCH_COLUMN );
        // 计算总的页数（ceil：向上取整（天8花板）， floor：向下取整（地板））
        $pageCount = ceil( $count / $perpage );

        $btns = '';
        for($i=1; $i<=$pageCount; $i++)
        {
            // 先获取之前的参数
            $params = getUrlParams(['page']);

            $class = $page==$i ? 'active' : '';
            $btns .= "<a class='$class' href='?{$params}page=$i'> $i </a>";
            
        }

        /*************** 执行 sqL */
        // 预处理 SQL
        $stmt = self::$pdo->prepare("SELECT * FROM orders WHERE $where ORDER BY $odby $odway LIMIT $offset,$perpage");
        // 执行 SQL
        $stmt->execute($value);

        // 取数据
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return [
            'btns' => $btns,
            'data' => $data,
        ];
    }

}