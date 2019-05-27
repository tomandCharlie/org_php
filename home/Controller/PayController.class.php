<?php

	class PayController{

		public function index(){
				
				// var_dump($_SESSION['home']);

				$uid = $_SESSION['home']['id'];

			try {
				//1.准备dsn
				$dsn = 'mysql:host=localhost;dbname=ss34_shop;charset=utf8';
				$pdo = new PDO($dsn,'root','123456');
				$pdo->setAttribute(3,1);

				//把用户信息取出
				} catch (PDOException $e) {
					echo $e->getMessage();	
				}
					$sql="SELECT * FROM user_info Where `uid`= {$uid} ";
					
					$stmt = $pdo->query($sql);

					
					$res = $stmt->fetchall(2);
					// var_dump($res);

					$u_info = $res['0'];

					$u_info['oid'] = time().rand(0,999);
					var_dump($u_info);
					// var_dump($u_info['oid']);

					// var_dump($userinfo);

					// foreach($userinfo as $val){
					// 	var_dump($val);
					// }

				// exit;
				include './Include/head.html';
				include './View/Pay/main_Pay.html';
				include './Include/foot.html';
			// include './View/Goods/main_Pay.html';
			// include './Include/foot.html';
			}
					
					// include './Include/head.html';
					// include './View/Login/main_Login.html';
					// include './Include/foot.html';
				
		

		public function addpay(){
			// 检查传过来的是否为空
			
			// 连上数据库
			
			// 把订单存入数据库,订单只有一个(order表),详细的订单信息有多个(order_info),就是执行两次插入,一次一个pag表



		}


	}



