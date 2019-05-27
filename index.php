<?php

//显示注册或者我们的前台首页
if(!file_exists('./Install/wang.lock')){
		header('location:./home/index.php');
	}else{
		header('location:./Install/index.php');
	}
?>