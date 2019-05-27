<?php

	class CartController{

		public function index(){
		
			include './View/Cart/BuyCar.html';
		}

		public function addCart(){
			//echo  '加入购物车';
			if(!empty($_GET['gid'])){
				//判断你是否已经添加过这个内容
				if(!empty($_SESSION['cart'][$_GET['gid']])){
					$_SESSION['cart'][$_GET['gid']]['num']+=1;
					header('location:index.php');
					exit;
				}

				//指定商品添加到购物车
				try {
					$dsn = 'mysql:host=localhost;dbname=ss34_shop;charset=utf8';
					$pdo = new PDO($dsn,'root','');
					$pdo->setAttribute(3,1);
					$sql="SELECT * FROM goods WHERE id=:id";
					$stmt = $pdo->prepare($sql);
					$stmt->bindParam(':id',$_GET['gid']);
					//执行sql语句
					$stmt->execute();
					if($stmt->rowCount()){
						$row = $stmt->fetch(2);
						var_dump($row);
						//添加一个购买数量
						$row['num'] =1;
						//将商品添加到购物车
						$_SESSION['cart'][$_GET['gid']]=$row;	
						//var_dump($_SESSION);
					//	include './View/Cart/addCart.html';
						header('location:./index.php');
					}
				} catch (PDOException $e) {
					echo $e->getMessage();
				}
			}else{
				//你没有指定商品
				echo '<script>alert("请添加指定商品");location="./index.php?c=Index&a=index"</script>';
			}
		}

		//显示购物车
		// public function index(){
		// 	//将导航引入即可
		// 	$index = new IndexController;
		// 	$index->nav();
		// 	$i=1;
		// 	$total = 0;
		// 	include './View/Cart/showCart.html';
		// }
		//数量加方法
		public function jia(){
			var_dump($_GET);
			
			//接受商品id
			$id = $_GET['id'];
			//根据我们传递过来的商品id进行购买数量的累加
			//$_SESSION['cart'][$id]['num']=$_SESSION['cart'][$id]['num']+1;
			$_SESSION['cart'][$id]['num']+=1;
			//记得判断一下你的库存
			header('location:index.php?c=cart&a=index');
		}
			//数量减方法
		public function jian(){
			var_dump($_GET);
			
			//接受商品id
			$id = $_GET['id'];
			//根据我们传递过来的商品id进行购买数量的累加
			//$_SESSION['cart'][$id]['num']=$_SESSION['cart'][$id]['num']+1;
			$_SESSION['cart'][$id]['num']-=1;
			if($_SESSION['cart'][$id]['num']<1){
				$_SESSION['cart'][$id]['num']=1;
			//	unset($_SESSION['cart'][$id]);
			}
			
			header('location:index.php?c=cart&a=index');
		}

		//删除某个商品
		public function del(){
			//var_dump($_GET);
			$id = $_GET['id'];
			unset($_SESSION['cart'][$id]);
			header('location:index.php?c=cart&a=index');
		}
		//清空购物车
		public function delete(){
			unset($_SESSION['cart']);
			header('location:index.php?c=cart&a=index');
		}

	}

