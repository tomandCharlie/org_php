<?php
		include '../public/Config/config.php';
		
		//时区
		date_default_timezone_set('PRC');
		//开启session
		session_start();
		//错误级别
		error_reporting(E_ALL ^ E_NOTICE);

		//自动加载
		function __autoload($className){
			//echo $className;exit;
			//include './Controller/'.$className.'.class.php';
			//判断加载什么样的文件的类文件
			if(substr($className,-10)=='Controller'){
				include './Controller/'.$className.'.class.php';
			}elseif(substr($className,-5)=='Model'){
				Include './Model/'.$className.'.class.php';
			}else{
				Include './Org/'.$className.'.class.php';
			}

		}

	
//如果想用用户相关的类 需要操作
// $user = new UserController;
// $user->index();
// $user->add();

// //如果想使用商品相关类的需要操作
// $goods = new GoodsController;
// $goods ->index();
// $goods->edit();

//var_dump($_GET);
//接受地址连传递过来过的c参数
//为了让各种情况都兼容
//1.先使用strtolower() 函数将参数统一变为小写
//2.在使用ucfirst首字母大写
$c = isset($_GET['c'])?$_GET['c']:'Index';
//将首字母大写其他字母小写
$c = ucfirst(strtolower($c));//User Goods
//拼接$c变量与controller字符串形式操作类
$controller= $c.'Controller';

//使用new关联字得到我们传递过来的参数的类
$info = new $controller;


//var_dump($_GET);
//方法的跳转方式
$a = isset($_GET['a'])?$_GET['a']:'index';
//使用类调用方法变量后面加上();
$info->$a();


//index.php?c=goods&a=edit
//Goods 表示是的要跳转类  c参数表示类
//edit: 表示要跳转的方法  a参数表示方法
//
//
//