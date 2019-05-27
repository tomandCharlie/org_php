<?php

	class GoodsController{


			public function PList(){	
			//连接数据库
			
			$dsn = 'mysql:host=localhost;dbname=ss34_shop;charset=utf8';
			try {
				//2.得到pdo对象
				$pdo = new PDO($dsn,'root','');
			} catch (PDOException $e) {
				echo $e->getMessage();
			}
			//3.设置错误
			$pdo->setAttribute(3,1);
			//准备预处理语句
			$sql="SELECT id,pid,path,name,display FROM type WHERE display=0";
			//将sql语句模版发送出去预处理
			$stmt = $pdo->prepare($sql);
			//执行sql语句
			$stmt->execute();
			if($stmt->rowCount()){
				//拿出所有值
				 $types = $stmt->fetchAll(2);
				 //遍历子分类使用的内容
				 $pid = $types;
			}else{
				echo '没有内容';
			}
			// var_dump($pid);
				include './View/Goods/PList.html';
		}

		public function Product(){
			
			var_dump($_GET);
			
			$this->PList();
			//遍历所有商品
			try {
				
				//1.准备dsn
				$dsn = 'mysql:host=localhost;dbname=ss34_shop;charset=utf8';
				$pdo = new PDO($dsn,'root','');
				$pdo->setAttribute(3,1);
				//判断你是否点击了导航
				if(empty($_GET['typeid'])){
					//将所有商品全部拿出来
					$sql="SELECT * FROM goods Where `status`=0 LIMIT 8";
					//echo $sql;exit;
					$stmt= $pdo->prepare($sql);
				}else{
					$sql="SELECT * FROM goods Where `status`=0 AND typeid=:typeid LIMIT 8";
					//echo $sql;exit;
					$stmt= $pdo->prepare($sql);
					$stmt->bindParam(':typeid',$_GET['typeid']);
				}	
				$stmt->execute();
				if($stmt->rowCount()){
					$goods= $stmt->fetchAll(2);
				}
				//var_dump($goods);
			} catch (PDOException $e) {
				echo $e->getMessage();	
			}

		}

			
		

		// public function nav(){
		// 	include './View/Goods/PList.html';
		// 	//连接数据库
		// 	$dsn = 'mysql:host=localhost;dbname=ss34_shop;charset=utf8';
		// 	try {
		// 		//2.得到pdo对象
		// 		$pdo = new PDO($dsn,'root','');
		// 	} catch (PDOException $e) {
		// 		echo $e->getMessage();
		// 	}
		// 	//3.设置错误
		// 	$pdo->setAttribute(3,1);

		// 	//准备预处理语句
		// 	$sql="SELECT id,pid,path,name,display FROM type WHERE display=0";
		// 	//将sql语句模版发送出去预处理
		// 	$stmt = $pdo->prepare($sql);
		// 	//执行sql语句
		// 	$stmt->execute();
		// 	if($stmt->rowCount()){
		// 		//拿出所有值
		// 		 $types = $stmt->fetchAll(2);
		// 		 //遍历子分类使用的内容
		// 		 $pid = $types;
		// 	}else{
		// 		echo '没有内容';
		// 	}
			
		// }

		// public function product(){
		// 	var_dump($_GET);
		// 	//echo '前台首页';
		// 	//引入头部文件
		// 	$this->nav();
		// 	//遍历所有商品
		// 	try {
		// 		include './View/Goods/PList.html';
		// 		//1.准备dsn
		// 		$dsn = 'mysql:host=localhost;dbname=ss34_shop;charset=utf8';
		// 		$pdo = new PDO($dsn,'root','');
		// 		$pdo->setAttribute(3,1);
		// 		//判断你是否点击了导航
		// 		if(empty($_GET['typeid'])){
		// 			//将所有商品全部拿出来
		// 			$sql="SELECT * FROM goods Where `status`=0 LIMIT 8";
		// 			//echo $sql;exit;
		// 			$stmt= $pdo->prepare($sql);
		// 		}else{
		// 			$sql="SELECT * FROM goods Where `status`=0 AND typeid=:typeid LIMIT 8";
		// 			//echo $sql;exit;
		// 			$stmt= $pdo->prepare($sql);
		// 			$stmt->bindParam(':typeid',$_GET['typeid']);
		// 		}	
		// 		$stmt->execute();
		// 		if($stmt->rowCount()){
		// 			$goods= $stmt->fetchAll(2);
		// 		}
		// 		//var_dump($goods);
		// 	} catch (PDOException $e) {
		// 		echo $e->getMessage();	
		// 	}

		// }
	}

