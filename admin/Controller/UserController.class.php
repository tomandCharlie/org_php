<?php
	//用户模块
	class UserController{
		//显示列表页面
		public function index(){
			// 用户搜索
			if(empty($_GET['name'])){
				$data = array();
			}else{
				$data['name'] = array('like',$_GET['name']);
			}

			// 显示用户列表
			echo '用户列表页';
			$user = new Model('user');
			$total = $user->where($data)->count();
			$page = new Page($total,3); 
			$userlist = $user->where($data)->limit($page->limit)->select();
			$i = 1; 
			
			include './View/User/index.html';
		}

		public function add(){
			// echo '用户添加';
			include './View/User/add.html';
		}
		public function doadd(){
			
			if($_POST['password']!==$_POST['repassword']){
					echo '<a href="./index.php?c=user&a=add">两次密码不一致</a>' ;
						exit; 
			} 
			unset($_POST['repassword']); 

			$_POST['password']=md5($_POST['password']);
			
			$_POST['status'] = 0;
			$_POST['addtime'] = time();
		
			$user = new Model('user');
			// var_dump($user);
			$bool = $user->add($_POST);
			// var_dump($bool);
			if ($bool){
				echo '<script>alert("添加成功");location="./index.php?c=user&a=index"</script>';
				}else{echo '<script>alert("添加失败");location="./index.php?c=user&a=add"</script>';
			}
		}
		//删除
		public function del(){
			$id = $_GET['id'];
			$user = new Model('user');
			if ($user->del($id)){
				header('location:index.php?c=user&a=index');
			}else{
				header('location:index.php?c=user&a=index');
			}
		}

		
			public function edit(){ 
			$id = $_GET['id'];
			// var_dump($id);
			// exit;
			//通过得到的id来进行查询操作
			$user = new Model('user');
			$userlist = $user->find($id);
			// var_dump($userlist);
			// 
			include './View/User/edit.html';
		}
		//处理修改页面的方法
		public function doedit(){ 
			$_POST['password']=md5($_POST['password']);
			$user = new Model('user');
			$bool = $user->update($_POST);

			// var_dump($_GET['id']);
			
			// var_dump($bool);
			// var_dump($_POST);
			
			if($bool){ 
				echo '<meta http-equiv="refresh" content="3,url=./index.php?c=user&a=index"/>';
				echo '修改成功,三秒后自动跳转如不跳转请点击<a href="./index.php?c=user&a=index">返回</a>';
			}else{ 
				echo '修改失败<a href="./index.php?c=user&a=edit&id='.$_POST['id'].'">返回</a>';

			}
		}


// echo '修改失败<a href="./index.php?c=user&a=edit&id='.$_POST['id'].'">返回</a>';




		public function status(){
			$data =array();
			$data['id']=$_GET['id'];
			$data['status']=$_GET['status'];

			//连接数据库
			$user= new Model('user');
			//修改数据
			if($user->update($data)){
				header('location:index.php?c=user&a=index');
				}else{
					header('location:index.php?c=user&a=index');
			}
		}
		//用户详情的四大操作
		//传递到detail 的数组使用$userinfo命名

		public function detail(){
			$info = new Model('user_info');
			$data['uid'] = $_GET['id'];
			$result = $info->where($data)->find();
			$userinfo = $result;

			// var_dump($userinfo);

			include './View/User/detail.html';
		}

		public function dodetail(){

			if($_POST['uid']== ''){
				$this->detailadd();
			}else{

				$this->detailedit();
			}

		}

		protected function detailadd(){

			$upload = new Uploads('pic');
			$upload->typelist = array('image/jpeg','image/gif','image/png') ;

			$upload->path = '../public/uploads/';
			$bool = $upload->upload();

			if(!$bool){
				echo '文件上传失败';
				exit;
			}
			$_POST['pic'] = $upload->savename;

			$_POST['uid']=$_GET['id'];

			$info = new Model('user_info');
			$result = $info->add($_POST);
			if($result){
				echo '添加成功';
			}else{
				echo '添加失败';
			}

		}

		protected function detailedit(){

			if($_FILES['pic']['name']==''){

				$info = new Model('user_info');

				$data['uid'] = $_POST['uid'];
				$result = $info->where($data)->update($_POST);
				// var_dump($result);	
				// var_dump($_FILES);

				$resu = $info->where($data)->find();
					unset($resu['id']);
					unset($resu['pic']);
		
				if($result){
					echo '<script>alert("修改成功");location="./index.php?c=user"</script>';
				}else{
					//判断是否有内容改变,没改就是数据没有更新
					if ($resu == $_POST ) {
					echo '<script>alert("没有更新数据");location="./index.php?c=user"</script>';
					}
					echo '<script>alert("数据没有完全修改,更新失败");location="./index.php?c=user"</script>';
				}
			/*if($_FILES['pic']['name']=='')的真括号到此,也就是当图片不需要修改*/
			}else{
				/*当图片需要修改*/
				$info = new Model('user_info');
				$data['uid'] = $_POST['uid'];

				$result = $info->where($data)->find();
					//这里是找到旧的图片名字
				$oldname = $result['pic'];

				$upload = new Uploads('pic');

				$upload->typelist=array('image/jpeg','image/gif','image/png');
				$upload->path='../public/uploads/';
				$bool = $upload->upload();
				//判断新文件上传情况
				if(!$bool){
					echo '文件上传失败';
					exit;
				}
				$newname = $upload->savename;
				//将新图片放入到要修改的$_POST数组中
				$_POST['pic']=$newname;
				$data['uid']=$_POST['uid'];
				$res = $info->where($data)->update($_POST);
				$resu = $info->where($data)->find();
					unset($resu['id']);
					// 为了防止 修改过程中,有表单的部分信息未被修改,但是由于有影响行数所以依然提示修改成功,所以比对修改过后的数据

					if($res && ($resu == $_POST) ){
					//删除原来图片
					@unlink('../public/uploads/'.$oldname);
					echo  '<script>alert("修改成功");location="./index.php?c=user"</script>';
				}else{
					echo '<script>alert("数据没有完全更新失败");location="./index.php?c=user"</script>';
				}

			}
		}
	}