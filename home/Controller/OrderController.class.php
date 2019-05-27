<?php

	class OrderController{

		public function add(){
			//分出商品和订单的id
			$car = $_SESSION['cart'];
			$oid = $_POST['oid'];
// echo '每个取出商品<br>';
			// var_dump($_SESSION['cart']['3']);
			$mysql ="mysql:dbname=ss34_shop;host=localhost;charset=utf8";
			try {
			$pdo =new PDO($mysql,'root','123456');
			} catch (PDOException $e) {
				echo $e->getMessage();
			}
			$pdo->setAttribute(3,1);
			
			foreach($car as $val){
				
				unset($val['typeid']);
				unset($val['store']);
				unset($val['status']);
				unset($val['pic']);
				unset($val['sales']);
				unset($val['company']);
				unset($val['descr']);	
				// var_dump($val);				
				// var_dump();
				$a = $oid.','.join(',',$val);
				$b = explode(',',$a);
				var_dump($b);
												
				$sqla = "INSERT INTO order_info(oid,gid,gname,price,gnum) VALUES(?,?,?,?,?)";
			
				$stmtl = $pdo->prepare($sqla);
				// var_dump($stmtl);
				$stmtl->bindParam(1,$b[0]);
				$stmtl->bindParam(2,$b[1]);
				$stmtl->bindParam(3,$b[2]);
				$stmtl->bindParam(4,$b[3]);
				$stmtl->bindParam(5,$b[4]);
				// var_dump($stmtl);
				$resultl = $stmtl->execute();	
				var_dump($resultl);		

			}
			
			$sqlc = "INSERT INTO orders(id,uid,linkname,address,tel,code,total,status,time) VALUES(:id,:uid,:linkname,:address,:tel,:code,:total,:status,:time)";
			// var_dump($sqlc);
				$stmtc = $pdo->prepare($sqlc);
				// var_dump($stmtl);
				
				$orders = $_POST;
				$orders['status'] = '0';
				$orders['time'] = time();
				unset($orders['oid']);

				var_dump($orders);
				
				$bool = $stmtc->execute($orders);
				var_dump($bool);
				// exit;
				if (!$bool) {
						echo '订单数据传输异常';
						exit;
					}else{
						unset($_SESSION['cart']);
						echo '<script>alert("下单成功");location="./index.php?c=Goods&a=index"</script>';
					}
		

		}

		public function index(){
			// $this->$orders;
			
			$uid = $_SESSION['home']['id'];
			
			$mysql ="mysql:dbname=ss34_shop;host=localhost;charset=utf8";
			try {
			$pdo =new PDO($mysql,'root','123456');
			} catch (PDOException $e) {
				echo $e->getMessage();
			}
			$pdo->setAttribute(3,1);
	
			$sqlcha = "select * from orders where uid = :uid ";
			//预处理
			$stmtcha = $pdo->prepare($sqlcha);
			//绑定参数
			$stmtcha->bindParam('uid',$uid);
			// query和execute有什么区别
			$bool = $stmtcha->execute();
			
			// $bool = $stmtcha->query();
			$olist = $stmtcha->fetchAll(2);
			// var_dump($olist);

			include './Include/head.html';
			include './View/Order/main_M_Order.html';
			include './Include/foot.html';
		}




	}



