 <?php

 	//商品的模块操作
  // include '../Model/Model.class.php';
  	class OrdersController{

  		public function index(){
        //'商品列表页';
        //进入数据库的orders表
        echo 'dsad';
        // exit;
        $orders = new Model('user');
        // 数组装入所有订单信息
        var_dump($orders);
        exit;
        $orderslist = $orders->select();
        var_dump($orderslist);
        $_SESSION['home'] = $orderslist;
        var_dump($_SESSION['home']);

          // exit;      
    			include './View/Member/Member_Order.html';
      
  		}
      
      public function order_info(){
        // '订单详情列表页';
        // 先接受订单id,在order_info中列名为oid
        $data['oid'] = $_GET('id');

        var_dump($data);
        $orders = new Model('orders');
        // 数组装入所有订单详情信息
        $orderslist = $orders->where($data)->select();    
        // 在页面点击后回订单页,再跳回订单页
        include './View/My order.html';
      }
}

$a = new OrdersController();

$c = $a->index();

echo $c;