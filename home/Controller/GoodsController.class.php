<?php




	class GoodsController{
		
		public function index(){
			include './Include/head.html';
			// var_dump($_GET);
			//echo '前台首页';
			//引入头部文件
			// $this->nav();
			//遍历所有商品
			try {
				//1.准备dsn
				$dsn = 'mysql:host=localhost;dbname=ss34_shop;charset=utf8';
				$pdo = new PDO($dsn,'root','123456');
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
			
			include './View/Goods/main_PList.html';
			include './Include/foot.html';
		}

		public function product(){
			include './Include/head.html';
			//从数据库中读取商品的名字,图片信息
			//
			try {
				//1.准备dsn
				$dsn = 'mysql:host=localhost;dbname=ss34_shop;charset=utf8';
				$pdo = new PDO($dsn,'root','123456');
				$pdo->setAttribute(3,1);
				
					$_GET['id'] = '2';
					$sql="SELECT * FROM goods Where `id`=:id ";
					//echo $sql;exit;
					$stmt= $pdo->prepare($sql);
					$stmt->bindParam(':id',$_GET['id']);
				
				$stmt->execute();
				if($stmt->rowCount()){
					$goods= $stmt->fetchAll(2);
				}
				//var_dump($goods);
			} catch (PDOException $e) {
				echo $e->getMessage();	
			}
			// var_dump($goods);
			$val = $goods['0'];
			// var_dump($val);
			include './View/Goods/main_Product.html';
			include './Include/foot.html';
		}


}		
