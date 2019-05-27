<?php

	class MemberController{


		//显示列表页面
		public function user(){
			include './View/Login/Menber_User.html';
		}

		public function add(){
			// echo '用户添加';
			include './View/Login/Regist.html';
		}

		public function doadd(){
			
			if($_POST['password']!==$_POST['repassword']){
					echo '<a href="./index.php?c=user&a=add">两次密码不一致</a>' ;
						exit; 
			} 
			unset($_POST['repassword']); 

			$_POST['password']=md5($_POST['password']);
			$user = new Model('user');
			// var_dump($user);
			$bool = $user->add($_POST);
			// var_dump($bool);
			if ($bool){
				echo '<script>alert("注册成功");location="./index.php?c=user&a=index"</script>';
				}else{echo '<script>alert("注册失败");location="./index.php?c=user&a=add"</script>';
			}
		}
		
	}