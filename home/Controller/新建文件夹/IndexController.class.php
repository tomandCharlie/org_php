<?php


	class IndexController{

		public function index(){
			//载入首页
			// 显示后台主页面
			
			include './View/Index.html';
			
			
		}

		public function login(){
			// echo 'aaaa';
			include './View/Login/Login.html';
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
			header('location:./index.php');
			
			}


}		
