<?php
	//分页思路
	//1.每页显示多少条
	//2.总共有多少条
	//3.共有多少页
	//4.当前是第几页
	//5.偏移量
	//6.实现分页

	//分页类
	
		class Page{
			protected $num;//每页显示数
			protected $total;//总条数
			protected $amount;//总页数
			protected $current;//当前页码
			protected $offset ;//偏移量
			protected $limit ;//分页字符串
			public function __construct($total,$num){
				//1.每页显示数
				$this->num = $num;
				
				//2.总条数
				$this->total = $total;

				//3. 总页数
				$this->amount = ceil($total/$num);

				//4当前是第几页
				$this->init();

				//5.偏移量(当前页码-1)*每页显示数
				$this->offset= ($this->current -1)*$num;

				//6. 实现分页字符串
				$this->limit = "{$this->offset},{$this->num}";


			}
			//初始化当前页码
			public function init(){
				//获取当前页码
				$this->current = empty($_GET['page'])?'1':$_GET['page'];
				//判断最小值
				if($this->current <1){
					$this->current=1;
				}
				//判断最大值
				if($this->current > $this->amount){
					$this->current=$this->amount;
				}
			}
			public function __get($key){
				if($key == 'limit'){
					return $this->limit;
				}
				if($key=='current'){
					return $this->current;
				}
				if($key=='offset'){
					return $this->offset;
				}
			}
			//获取按钮的方法
			public function getButton(){
				//var_dump($_GET);
				//将我们$_GET 里面的所有内容赋值给两个变量
				$_GET['page']=empty($_GET['page'])?'1':$_GET['page'];

				//$prev = $next = $_GET;
				$prev = $_GET;
				$next = $_GET;

				//上一页
				$prev['page']=$prev['page']-1;

				//判断上一页不能超出范围如果超出范围设置为1
				if($prev['page']<1){
					$prev['page']=1;
				}
				//下一页
				$next['page']=$next['page']+1;
				//判断下一页不能超出范围如果超出范围设置为最大值
				if($next['page']>$this->amount){
					$next['page']=$this->amount;
				}

				//http://localhost/oto/ss34/oop07/user/index.php
				//拼接我们的路径
			//	var_dump($_SERVER);
				$url = 'http://'.$_SERVER['SERVER_NAME'].$_SERVER['SCRIPT_NAME'];
				
				//http_build_query()将数组中的每个单元以参数的形式连接在一起
				
				// var_dump($prev);
				// echo http_build_query($prev);
				// exit;
				$prev = http_build_query($prev);
				$next = http_build_query($next);
				//name=哥&page=1
				// echo $prev;
				// echo '<hr/>';
				// echo $next;
				// exit;

				//拼接一个上一页的完整路径
				$prevpath = $url.'?'.$prev;
				//拼接一个下一页的完整路径
				$nextpath = $url.'?'.$next;

				// echo $prevpath;
				// echo '<hr/>';
				// echo $nextpath;
				// exit;

				 $str = '';

				 $str .='<a href="'.$prevpath.'">上一页</a>';
				 $str .='<a href="'.$nextpath.'">下一页</a>';
				 return $str;
			}
		}