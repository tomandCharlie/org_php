<?php


	class IndexController{

		public function nav(){
			//连接数据库
			$dsn = 'mysql:host=localhost;dbname=ss34_shop;charset=utf8';
			try {
				//2.得到pdo对象
				$pdo = new PDO($dsn,'root','123456');
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
			include './Include/head.html';
		}


		public function index(){
			// var_dump($_GET);
			//echo '前台首页';
			//引入头部文件
			$this->nav();
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
			include './View/main_Index.html';
			include './Include/foot.html';
		}

		public function login(){
			include './Include/head.html';
			include './View/Login/main_Login.html';
			include './Include/foot.html';
		}
		

		public function dologin(){
			$m_name = $_POST['m_name'];
			$password = md5($_POST['password']);
			
			$map['name'] = $m_name;
			$map['password'] = $password;
			$map['level'] = array('lt',1);
			$map['status'] = 0;
			
			$user = new Model('user');
			$userinfo = $user->where($map)->select();
			// var_dump($map);
			// echo 'trr';
			// exit;
			if($userinfo){
				unset($userinfo[0]['password']);
				$_SESSION['home']=$userinfo[0];
				
				echo '<script>alert("登录成功");location="./index.php"</script>';
			}else{
				echo 
				'<script>
				alert("可能是密码或者用户名错误");
				location="./index.php"
				</script>';
			}
		}

		
		public function outlogin(){
			//销毁session
			unset($_SESSION['home']);
			echo '<script>alert("退出后请清理浏览器缓存,保护隐私");location="./index.php?c=Index&a=index"</script>';
			
			}


}		
