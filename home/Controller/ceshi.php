<?php


		$dsn = 'mysql:dbname=ss34_shop;host=localhost;charset=utf8';
		try{
			$pdo= new PDO($dsn,'root','');
		}catch(PDOException $e){
			echo $e->getMessage();
		}
			$pdo->setAttribute(3,1);

			$sql="INSERT INTO info(name,password,level,status,addtime) VALUES(:名字,:密码,:等级,'0',:添加时间)";
			$stmt = $pdo->prepare($sql);
		// 添加
		// 
				unset($_POST['repassword']); 
				$_POST['password']=md5($_POST['password']);
				$_POST['level'] = 0;
				$_POST['status'] = 0;
				$_POST['addtime'] = time();
				unset($_POST['mail']);
				unset($_POST['tel']);
				var_dump($_POST);
		
			// $bool = $stmt->exec($_POST)

			





