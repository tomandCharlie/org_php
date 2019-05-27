<?php

	class Uploads{

		protected $upfile;
		protected $error;
		protected $typelist = array();

		protected $savename;
		protected $path;

		public function __construct($name){

			$this->upfile = $_FILES[$name];
		}

		public function upload(){

			$this->path = rtrim($this->path,'/').'/';

			return $this->checkError() && $this->checkType() && $this->createName() && $this->move();
		}


		protected function checkError(){
			if ($this->upfile['error']>0) {
				switch ($this->upfile['error']) {
					case 1:
						$info = '上传文件超过upload限制';
						break;
					case 2:
						$info = '文件超过html大小限制';	
						break;
					case 3:
						$info = '文件上传不完整';	
						break;
					case 4:
						$info = '文件没有上传';	
						break;		
					case 6:
						$info = '没有找到文件临时路径';	
						break;
					case 7:
						$info = '文件写入失败';	
						break;	
				}
				$this->error = $info;
				return false;
			}
			return true;
		}

		public function checkType(){
			if(count($this->typelist)){
				if(!in_array($this->upfile['type'],$this->typelist)){
					$this->error = '文件类型不符合';
					return false;
				}
			}
			return true;
		}

		protected function createName(){

			$ext = pathinfo($this->upfile['name'],PATHINFO_EXTENSION);
			$this->savename = date('Ymd').uniqid().mt_rand(0,999).'.'.$ext;
			return true;

		}

		protected function move(){
		
			if (is_uploaded_file($this->upfile['tmp_name'])){

				 if(move_uploaded_file($this->upfile['tmp_name'],$this->path.$this->savename)){
				return true;
			}else{
				$this->error = '文件移动失败';
				return false;
					}

				}else{
			$this->error = '有点问题';
			return false;
			}

		}	

		public function __set($key,$value){

			if($key == 'typelist'){
				$this->$key = $value;
			}
			if($key == 'path'){
				$this->$key = $value;
			}
		}

		public function __get($key){

			if($key == 'savename'){
				return $this->$key;
			}

			if($key == 'error'){
				return $this->$key;
			}
		}

	}