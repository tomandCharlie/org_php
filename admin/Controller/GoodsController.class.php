 <?php

 	//商品的模块操作
  	class GoodsController{

  		public function index(){
        // 新加入的
        

      if(empty($_GET['name'])){
        $data = array();
          }else{
         $data['name'] = array('like',$_GET['name']);
      }
        var_dump($data);

      // echo '商品列表页';
      $goods = new Model('goods');
      $total = $goods->where($data)->count();
      $page = new Page($total,3); 
      $userlist = $goods->where($data)->limit($page->limit)->select();
      $i = 1; 

      
        // exit;
        //新加结束

  			// $goods = new Model('goods');这是原来的good页面
  			$goodslist = $goods->select();
        //原来
      
  			include './View/goods/index.html';

  		}

  		public function add(){

  			$type = new Model('type');
  			$result = $type->order('concat(path,id,",") ASC')-> select();
  			include './View/Goods/add.html';

  		}

  		public function doadd(){

  			foreach($_POST as $val){
  				if ($val == '') {
  					echo '内容有误';
  					exit;
  				}
  			}

  			$upload = new Uploads('pic');
  			
  			$upload->typelist = array('image/jpeg','image/jpg','image/gif','image/png');

  			$upload->path = '../public/goods/';

  			$bool = $upload->upload();
  			if(!$bool){
  				echo '文件上传失败';
  				exit;
  			}

  			$_POST['pic'] = $upload->savename;
  			$goods = new Model('goods');
  			if($goods->add($_POST)){
  				echo '添加成功';
  			}else{
  				//出现上传或者是其他问题失败要删除已经上传的文件
  				unlink('../public/goods/'.$_POST['pic']);
  				echo '添加失败';
  			}

  		}

  		public function del(){

  			$gid = $_GET['id'];
  			$goods = new Model('goods')	;
  			$goodslist = $goods->find($gid);

  			$oldimg = $goodslist['pic'];

  			$result = $goods->del($gid);

  			if($result){

  				unlink('../public/goods/'.$oldimg);

  				header('location:./index.php?c=goods&a=index');
  			}else{
  				header('location:./index.php?c=goods&a=index');
  			}
  		}


      public function edit(){ 

        $gid = $_GET['id'];

        // var_dump($gid);

        $goods = new Model('goods');
        $goodsinfo = $goods->find($gid);

        // echo $goods->sql;

        // var_dump($goodsinfo);

        $type = new Model('type');
      //select concat(path,id,',') from type;
      
      $result = $type->order('concat(path,id,",") ASC')->select();




        include './View/Goods/edit.html';
    }


    public function doedit(){ 

          // var_dump($_POST);

          $id = $_GET['id'];
   
        // var_dump($id);


        $goods = new Model('goods');

        $goodslist = $goods->find($id);

        $upload = new Uploads('pic');

        $upload->typelist = array('image/jpeg','image/jpg','image/gif','image/png');

        $upload->path = '../public/goods/';

         $bool = $upload->upload();

         if($bool){

          @unlink('../public/goods/'.$goodslist['pic']);
          $_POST['pic']  = $upload->savename;

         }else{
          echo '修改失败';
         }

         $goods = new Model('goods');

         // var_dump($_POST);
         unset($_POST['last_pic']);
          // var_dump($_POST);
          // 
          $result = $goods->update($_POST);
           echo '<script>alert("修改成功");location="./index.php?c=user"</script>';
          
        
     }    



  }