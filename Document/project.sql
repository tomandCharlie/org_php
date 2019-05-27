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


-- 创建分类表
CREATE TABLE IF NOT EXISTS `type`(
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(255) NOT NULL,
	pid  INT NOT NULL,
	path VARCHAR(255) NOT NULL,
	display TINYINT NOT NULL
)ENGINE = InnoDB DEFAULT CHARSET=utf8;




