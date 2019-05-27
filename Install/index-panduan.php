<?php

	if(!file_exists('./Install/wang.lock')){
		header('location:./home/index.php');
	}else{
		header('location:./install/index.php');
	}
