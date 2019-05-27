<?php

//首页类
	class IndexController{
		public function index(){
			// echo '后台首页';
			// 显示后台主页面
			
			if(empty($_SESSION['admin'])){
				header('location:index.php?c=index&a=login');
			}else{
				include './View/index.html';
			}
		}

		public function login(){
			include './View/login.html';
		}

		public function dologin(){
			$username = $_POST['username'];
			$password = md5($_POST['password']);
			
			$map['name'] = $username;
			$map['password'] = $password;
			$map['level'] = array('gt',0);
			$map['status'] = 0;
			// var_dump($map);
			// exit;
			$user = new Model('user');
			$userinfo = $user->where($map)->select();
			// var_dump($user->where($map));die;
				

			

			if($userinfo){
				unset($userinfo[0]['password']);
				$_SESSION['admin']=$userinfo[0];
				
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
			unset($_SESSION['admin']);
			header('location:./index.php');
			
			}

	}