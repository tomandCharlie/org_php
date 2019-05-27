-- 创建数据库
CREATE DATABASE IF NOT EXISTS ss34_shop;

-- 选择数据库
USE ss34_shop;


-- 创建用户表 user
CREATE TABLE  IF NOT EXISTS `user`(
	`id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	`name` VARCHAR(255) NOT NULL UNIQUE,-- 唯一索引
	`password` CHAR(32) NOT NULL,
	`level` TINYINT NOT NULL DEFAULT 0, -- 0 普通用户 1 vip 2管理员 3超级管理员
	`status` TINYINT NOT NULL DEFAULT 0, -- 0开启  1 禁用
	`addtime` INT UNSIGNED NOT NULL 
)ENGINE =InnoDB DEFAULT CHARSET=utf8;

-- 添加超级管理员权限
INSERT INTO user(id,name,password,level,status,addtime) VALUES(NULL,'admin',md5(123456),3,0,0);

-- 创建用户详情表 user_info
CREATE TABLE IF NOT EXISTS `user_info`(
	`id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	`uid` INT NOT NULL, -- 用户表id
	`zname` VARCHAR(255) NOT NULL,
	`sex`  TINYINT NOT NULL DEFAULT 0,
	`age`  TINYINT UNSIGNED NOT NULL DEFAULT 0,
	`tel`   CHAR(11)  NOT NULL,
	`address`  VARCHAR(255) NOT NULL,
	`hunfou`    TINYINT NOT NULL DEFAULT 0, -- 0 未婚 1 已婚 2 离异 3丧偶
	`pic`     VARCHAR(255)
)ENGINE = InnoDB DEFAULT CHARSET=utf8;







-- 创建分类表
CREATE TABLE IF NOT EXISTS `type`(
	`id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	`name` VARCHAR(255) NOT NULL,
	`pid`  INT NOT NULL,
	`path` VARCHAR(255) NOT NULL,
	`display` TINYINT NOT NULL
)ENGINE = InnoDB DEFAULT CHARSET=utf8;

-- 创建商品表
CREATE TABLE IF NOT EXISTS `goods`(
	`id`  INT  UNSIGNED  AUTO_INCREMENT PRIMARY KEY,
	`name`  VARCHAR(255) NOT NULL,
	`typeid` INT NOT NULL,
	`price`  DECIMAL(10,2) NOT NULL,
	`store` INT  UNSIGNED NOT  NULL DEFAULT 0,
	`status` TINYINT NOT NULL DEFAULT 0, -- 0 上架 1  下架
	`pic`  VARCHAR(255) NOT NULL,
	`sales` INT NOT NULL DEFAULT 0,
	`company` VARCHAR(255) NOT NULL,
	`descr` VARCHAR(255)
)ENGINE= InnoDB DEFAULT CHARSET=utf8;


订单详情表		order_info				
id		id	int		不能为空		主键自增
订单id	oid	int		不能为空		
商品id	gid	int		不能为空		
商品名称	gname	varchar(255)		不能为空		
商品单价	price	decimal(10,2)		不能为空		
商品数量	gnum	int		不能为空		


-- 订单表 	orders						
-- id		id			int		不能为空		主键自增	
-- 会员id	uid			int		不能为空			
-- 联系人	linkname	varchar（255）		不能为空			
-- 地址		address		varcahr（）		不能为空			
-- 电话		tel	char(11)		不能为空			
-- 邮编		code		char(6)		不能为空	邮编默认值000000		
-- 总金额	total		decimal(10,2)		不能为空			
-- 状态		status		tinyint		不能为空	默认值    0  新订单   1  已发货  2  已收货  3.评论  4订单完成		













-- 创建商城的客户表Member

CREATE TABLE  IF NOT EXISTS `Member`(
	`id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	`name` VARCHAR(255) NOT NULL UNIQUE,-- 唯一索引
	`password` CHAR(32) NOT NULL,
	`mail` VARCHAR(255) NOT NULL DEFAULT 0, -- 0开启  1 禁用
	`phone` CHAR(32) NOT NULL 
)ENGINE =InnoDB DEFAULT CHARSET=utf8;

