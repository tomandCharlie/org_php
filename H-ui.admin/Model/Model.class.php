<?php

	//数据库操作类
	class Model{
		public $link;//连接数据库对象
		public $tabName;//存储数据表
		public $fields='*';//用于存储要查询的字段
		public $allFields;//用来存储数据库缓存字段内容
		public $limit;//每页显示多少条数
		public $order;//用来进行数据排序的
		public $sql;//用来存储数据库语句
		public $where;//子条件语句
		//初始化 构造方法
		public function __construct($tabName){
			//连接数据库方法
			$this->getConnect();
			//初始化数据表
			$this->tabName = $tabName;
			//获取数据库字段
			$this->getFields();

		}
		//增
		//$data['name']='张三';
		//$data['age']=18;
		//$data['sex']=0;
		//$data['city']='背景';
		public function add($data=array()){
			//var_dump($data);exit;
			//1.得到字段列表
			//1.1获取数组中的键作为我们sql语句的字段列表
			$key = array_keys($data);
			//1.2. 将得到的键名之后的数组变为字符串即可
			$keys = join('`,`',$key);
			//2.得到要添加的值
			//2.1获取数字的值作为我们sql语句的值
			$value = array_values($data);
			//2.2 将得到数组的值之后的数组变为字符串
			//'张三','1','19','ximalaya';
			$values = join("','",$value);
			//echo $values;exit;
			
			$sql="INSERT INTO {$this->tabName}(`{$keys}`)  VALUES('{$values}')";
			//echo $sql;exit;
			$bool = $this->execute($sql);
			return $bool;
		}
		//删
		public function del($id=''){
			if(empty($id)){
				$where =$this->where;
			}else{
				$where = "WHERE id={$id}";
			}
			if(empty($where)){
				return false;
			}
			$sql="DELETE FROM {$this->tabName} {$where}";
			$bool = $this->execute($sql);
			return $bool;

		}
		//改
		public function update($data=array()){
			
			//var_dump($data);exit;
			//判断是否为数组 是否是空数组
			//var
			if(!is_array($data) || empty($data)){
				return false;
			}
			//判断你是否使用id作为修改条件如果使用则id有值 如果不使用则id没有值
			if(empty($data['id'])){
				//使用where条件修改
				$where = $this->where;
			}else{
				//用id作为修改条件
				$where = " WHERE id= '{$data['id']}' ";
			}
			if(empty($where)){
				return false;
			}



			//将我们传递过来的数组让他的键和值拼接在一起
			$result ='';
			foreach($data as $key=>$value){
				if($key !='id'){
					$result = $result. "`{$key}` = '{$value}',";
				}
			}

			//将多出来的逗号去掉
			$result = rtrim($result,',');

			//echo $result;exit;
			$sql="UPDATE  {$this->tabName} SET {$result} {$where}";
			
			// echo $sql;exit;
			$bool = $this->execute($sql);
			return $bool;
		}
		//查
		public function select(){
			$sql="SELECT {$this->fields} FROM {$this->tabName} {$this->where} {$this->order} {$this->limit}";
			$userlist= $this->query($sql);
			return $userlist;
		}
		//查询一条数据的内容
		public function  find($id=''){
			if(empty($id)){
				$where = $this->where;
			}else{
				$where = "WHERE id={$id}";
			}
			if(empty($where)){
				return '请输入条件';
			}
			$sql="SELECT {$this->fields} FROM {$this->tabName} {$where} {$this->order}";
			$userlist=$this->query($sql);
			return $userlist[0];
		}
		//统计总条数
		public  function count(){
			$sql="SELECT COUNT(*) as total FROM {$this->tabName} {$this->where} {$this->order}";
			$total = $this->query($sql);
			//var_dump($total);
			return $total[0]['total'];
		}
		//字段筛选
		public  function field($fields=array()){
			//判断$fields 是否是数组
			if(!is_array($fields)){
				return $this;
			}
			//检测数据库内容删除没有的字段
			$fields=$this->check($fields);
			if(empty($fields)){
				return $this;
			}
			//拼接字符串得到我们想要的内容
			$this->fields = join(',',$fields);
			//连贯操作
			return $this;
			//var_dump($fields);
		}
		//每页显示多少条
		public function limit($limit){
			$this->limit = ' LIMIT '.$limit;
			return $this;
		}
		//写一个order by 排序   ORDER  BY  字段名   ASC|DESC
		public function order($order){
			$this->order = ' ORDER BY '.$order;
			//echo $this->order;
			//返回值
			return $this;
		}
		//连接数据库操作查询条件的
		//$data['name']='琦琦';
		//$data['id']=1;
		//$data['name']=array('like','琦琦');
		
		public  function where($data=array()){
			//var_dump($data);
			//判断data是否是数组而且这个数组是否为空
			if(is_array($data) && !empty($data)){
				//说明不是空的数组
				foreach($data as $key=>$value){
					//判断你的值是否是数组
					if(is_array($value)){
							//var_dump($value);exit;
							switch($value[0]){
								case 'like':
									$result[]="`{$key}` LIKE '%{$value[1]}%'";
									break;
								case 'gt':
									$result[]="`{$key}` > '{$value[1]}'";
									break;
								case 'lt':
									$result[]="`{$key}` < '{$value[1]}'";
									break;
								case 'in':
									$result[]="`{$key}` in({$value[1]})";
									break; 
							}
					}else{
						//不是数组就是简单的等于关系
						$result[]="`{$key}`='{$value}'";
					}
				}
				//var_dump($result);exit;
				$where = '  WHERE  '.join('  and  ',$result);
				//echo $where;exit;
				$this->where=$where;
				// echo $where;
			}else{
				return $this;
			}
			return $this;
		}

		/*******************辅助方法************************/
		//查询方法  返回二维数组
		public function query($sql){
			$this->sql=$sql;
			//echo $sql;exit;
			$result = mysqli_query($this->link,$sql);
			if($result && mysqli_num_rows($result)>0){
				$userlist = array();
				while($row = mysqli_fetch_assoc($result)){
					$userlist[]=$row;
				}
				return $userlist;
			}else{
				return false;
			}
		}
		//增删改方法  用于执行 true或者false 如果是添加我们返回上一次添加的id
		public function execute($sql){
			$this->sql = $sql;
			$result= mysqli_query($this->link,$sql);
			if($result && mysqli_affected_rows($this->link)>0){
				//判断是否是添加操作 如果是添加操作则返回上一次添加id
				if(mysqli_insert_id($this->link)){
					return mysqli_insert_id($this->link);
				}
				return true;
				
			}else{
				return false;
			}
		}
		//连接数据库方法
		protected function getConnect(){
			$this->link = mysqli_connect(HOST,USER,PWD);
			if(mysqli_connect_errno($this->link)>0){
				echo  mysqli_connect_error($this->link);exit;
			}
			mysqli_select_db($this->link,DB);
			mysqli_set_charset($this->link,CHARSET);

		}

		//获取数据库字段
		protected function getFields(){
			//查看表信息的数据库语句我们得到我们想要的数据字段
			//DESC 表名
			$sql="DESC {$this->tabName}";
			//发送sql语句
			$result = $this->query($sql);
			//var_dump($result);
			//新建一个数组用来存储我们数据字段
			$fields = array();
			foreach($result as $value){
				//var_dump($value['Field']);
				$fields[]=$value['Field'];
			}
			//var_dump($fields);
			//设置为缓存字段
			$this->allFields = $fields;
		}

		//检测数据是否在数据库中
		public function check($arr){
			// var_dump($arr);
			// var_dump($this->allFields);
			//传递过来的数组需要拿出每个值和存储字段数组进行比较如果存在则保留如果不存在则删除
			foreach($arr as $key=>$value){
				//var_dump($value);
				//判断得到的值是否在存储字段的 数组中如果在保留不在删除
				if(!in_array($value,$this->allFields)){
					unset($arr[$key]);
				}
				//var_dump($arr);
			}
			return $arr;
		}


		//析构方法
		public function  __destruct(){
			mysqli_close($this->link);
		}

	}
