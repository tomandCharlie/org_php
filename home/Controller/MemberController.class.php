<?php

	class MemberController{

		public function regist(){

		
			include './Include/head.html';
			include './View/Login/main_Regist.html';
			include './Include/foot.html';
		}


		public function center(){

		
			include './Include/head.html';
			include './View/Member/main_M_User.html';
			include './Include/foot.html';
		}

		public function check(){
			var_dump();
			// //匹配每一个值
			// $_POST['password'];
			// $p = '/^[a-zA-Z]\w{5,17}$/'
			// // 返回0或1
			// preg_match();
		}


		public function doadd(){
			// var_dump($_POST);
			// exit;
			// 检验输入数据是否为空
			 if(in_array('',$_POST)){
			 	echo '<script>alert("请将注册信息填写完整");location="./index.php?c=Member&a=regist"</script>' ;}
			else{
						// 检验输入密码是否一致
				if($_POST['password']!==$_POST['repassword']){
					echo '<script>alert("两次密码不一致");location="./index.php?c=Member&a=regist"</script>' ;
					exit; 
				} 
					// 使用pdo防止sql注入,连接数据库
			$dsn = 'mysql:dbname=ss34_shop;host=localhost;charset=utf8';
				try{
					$pdo= new PDO($dsn,'root','123456');
				}catch(PDOException $e){
					echo $e->getMessage();
				}
					$pdo->setAttribute(3,1);
					//绑定参数	 
					$sql="INSERT INTO user(name,password,level,status,addtime) VALUES(:name,:password,:level,:status,:addtime)";
					$stmt = $pdo->prepare($sql);
 				//删除多余变量,加入默认设置
				unset($_POST['repassword']); 
				$_POST['password']=md5($_POST['password']);
				$_POST['level'] = 0;
				$_POST['status'] = 0;
				$_POST['addtime'] = time();
				unset($_POST['mail']);
				unset($_POST['tel']);
				// var_dump($_POST);
				
				$bool = $stmt->execute($_POST);
				// var_dump($bool);
				// exit;
				if ($bool){
					echo '<script>alert("添加成功");location="./index.php?c=index&a=index"</script>';
					}else{echo '<script>alert("添加失败");location="./index.php?c=Member&a=regist"</script>';
				}
			}
		
		}

		// public function m_info(){
		// 	$dsn = 'mysql:dbname=ss34_shop;host=localhost;charset=utf8';
		// 		try{
		// 			$pdo= new PDO($dsn,'root','');
		// 		}catch(PDOException $e){
		// 			echo $e->getMessage();
		// 		}
		// 			$pdo->setAttribute(3,1);
		// 			//绑定参数	 
		// 			$sql="INSERT INTO user_info(id,uid,zname,sex,age,tel,adress,hunfou,pic) VALUES(:id,:uid,:zname,:sex,:age,:tel,:address,:hunfou,:pic)";
		// 			$stmt = $pdo->prepare($sql);
 	// 			//删除多余变量,加入默认设置
		// 		unset($_POST['repassword']); 
		// 		$_POST['password']=md5($_POST['password']);
		// 		$_POST['level'] = 0;
		// 		$_POST['status'] = 0;
		// 		$_POST['addtime'] = time();
		// 		unset($_POST['mail']);
		// 		unset($_POST['tel']);
		// 		// var_dump($_POST);
				
		// 		$bool = $stmt->execute($_POST);
		// 		// var_dump($bool);
		// 		// exit;
		// 		if ($bool){
		// 			echo '<script>alert("添加成功");location="./index.php?c=index&a=index"</script>';
		// 			}else{echo '<script>alert("添加失败");location="./index.php?c=Member&a=regist"</script>';
		// 		}
		// }




	}

?>


