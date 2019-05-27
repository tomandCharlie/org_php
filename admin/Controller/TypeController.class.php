<?php
//商品分类模块
//
	class TypeController{
		public function index(){
			if(empty($_GET['id'])){
				$data['pid']=0;
			}else{
				$data['pid']=$_GET['id'];
			}
			$type = new Model('type');
			$typelist = $type->where($data)->select();
			include './View/Type/index.html';
		}

		public function add(){
	
			if(empty($_GET['id'])){
				$pid = 0;
				$path = '0,'; 
			}else{
				$pid = $_GET['id'];
				$type = new Model('type');
				$typeinfo = $type->find($pid);
				// var_dump($typeinfo);
				// exit;
				$path = $typeinfo['path'].$pid.',';
			}
			include './View/Type/add.html';
		}

		public function doadd(){
			var_dump($_POST);
			$type = new Model('type');
			if($type->add($_POST)){
				echo '<script>alert("添加成功");location="./index.php?c=type&a=index";</script>';
			}else{
				echo '<script>alert("添加失败");location="./index.php?c=type&a=index";</script>';
			}
		}

		//删除分类
		public function del(){
			var_dump($_GET['id']);

			$type = new Model('type');
			$data['pid'] = $_GET['id'];
			$xid =  $data['pid'];
			var_dump($xid);
			$result = $type->where($data)->select();
			if($result){

				echo '<script>alert("请点击查看子类中,删除子类再删除");location="./index.php?c=type&a=index&id='.$_GET['id'].'";</script>';
				
			}else{
				if($type->del($_GET['id'])){
					header('location:./index.php?c=type&a=index');

				}else{
					header('location:./index.php?c=type&a=index');
				}
			}

		}

		public function edit(){ 
			if(empty($_GET['id'])){
				$pid = 0;
				$path = '0,'; 
			}else{
				$pid = $_GET['id'];
				$type = new Model('type');
				$typeinfo = $type->find($pid);
				var_dump($typeinfo);
				// exit;
				$path = $typeinfo['path'].$pid.',';
			}
			include './View/Type/edit.html';
		}


		public function doedit(){ 
			$type = new Model('type');
			$_POST['path']=($_POST['path']);
		
			$bool = $type ->update($_POST);

			var_dump($_GET['id']);
			var_dump($bool);
			var_dump($_POST);
			
			if($bool){ 
				echo '<meta http-equiv="refresh" content="3,url=./index.php?c=user&a=index"/>';
				echo '修改成功,三秒后自动跳转如不跳转请点击<a href="./index.php?c=user&a=index">返回</a>';
			}else{ 
				echo '修改失败<a href="./index.php?c=user&a=edit&id='.$_POST['id'].'">返回</a>';

			}
		}

		//点击修改显示图标
		
		public function display(){
			$data =array();
			$data['id']=$_GET['id'];
			$data['display']=$_GET['display'];
				var_dump($data);
			//连接数据库
			$type= new Model('type');
			//修改数据
			if($type->update($data)){
				header('location:index.php?c=type&a=index');
				}else{
					header('location:index.php?c=type&a=index');
			}
		}



	}

?>