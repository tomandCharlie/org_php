<?php

	class Install{
		//显示协议页面的方法
		public function index(){
			//echo '协议页面';
			include './index.html';
		}
		//显示系统信息方法
		public function myserver(){
			//var_dump($_POST);
			if(empty($_POST['yd'])){
				echo '<script>alert("请点击已阅读");location="./index.php"</script>';exit;
			}
			include './myserver.html';
		}
		//显示让用户输入的数据信息
		public function config(){
			include './config.html';
		}
		//处理用户输入信息
		public function doconfig(){
			var_dump($_POST);
			//1要创建数据库
			//CREATE DATABASE IF NOT EXISTS 数据库
			//1.1 连接数据库
			$link = mysqli_connect($_POST['host'],$_POST['dbuser'],$_POST['dbpwd']);
			var_dump($link);
			exit;
			//1.2删除数据库
			mysqli_query($link,'DROP DATABASE IF EXISTS '.$_POST['db']);
			//1.3创建数据库
			$bool=mysqli_query($link,"CREATE DATABASE IF NOT EXISTS ".$_POST['db']);

			//var_dump($bool);exit;
			//1.4 选择数据库
			mysqli_select_db($link,$_POST['db']);

			//1.5 设置字符集
			mysqli_set_charset($link,'utf8');
			//创建数据表
			include './ss34.php';
			var_dump($arr);
			//获取sql语句进行循环发送sql语句
			foreach($arr as $value){
				//echo $value.'<br/>';
				mysqli_query($link,$value);
				echo '创建表成功<br/>';
			}
			//3.将管理员用户添加到用户表中进行操作
			//3.1 获取当前添加时间
			$time = time();
			//3.2 加密密码
			$pwd = md5($_POST['adminpwd']);
			var_dump($link);
			//3.3 准备sql语句
			$sql = "INSERT INTO user(name,password,level,status,addtime) VALUES('{$_POST['name']}','{$pwd}',3,0,$time)";
			//echo $sql;exit;
			//3.4发送sql语句
			$result = mysqli_query($link,$sql);
			var_dump($result);
			if($result && mysqli_affected_rows($link)>0){
				echo '安装成功';
				unlink('./wang.lock');
				echo '<a href="../admin/index.php">后台</a>';
				echo '<a href="../index.php">前台</a>';
			}else{
				echo '安装失败';
			}
			//4修改config.php文件
			
			$str = <<<EOF
<?php

	//主机名
	define('HOST','{$_POST['host']}');

	//用户名
	define('USER','{$_POST['dbuser']}');

	//密码
	define('PWD', '{$_POST['dbpwd']}');

	//字符集
	define('CHARSET', 'utf8');

	//数据库名
	define('DB', '{$_POST['db']}');
EOF;
//	替换的方式写入到配置文件
	file_put_contents('../public/Config/config.php',$str);
		}
	}