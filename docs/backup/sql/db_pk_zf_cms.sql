/*
SQLyog Ultimate v12.09 (64 bit)
MySQL - 5.5.39 : Database - db_pk_zf_cms
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`db_pk_zf_cms` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `db_pk_zf_cms`;

/*Table structure for table `tbl_account` */

DROP TABLE IF EXISTS `tbl_account`;

CREATE TABLE `tbl_account` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Primary key',
  `group_id_json` varchar(255) NOT NULL DEFAULT '' COMMENT 'String of group ids (encoded)',
  `group_id` int(11) DEFAULT NULL COMMENT 'Group id',
  `username` varchar(255) NOT NULL DEFAULT '' COMMENT 'Account''s username',
  `password` varchar(55) NOT NULL DEFAULT '' COMMENT 'Account''s password',
  `avatar` varchar(255) NOT NULL DEFAULT '' COMMENT 'Account''s avatar',
  `fullname` varchar(255) NOT NULL DEFAULT '' COMMENT 'Account''s fullname',
  `last_login_time` datetime DEFAULT NULL COMMENT 'Account''s last login time',
  `active` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Flag: is active?',
  `draft` datetime DEFAULT NULL COMMENT 'Datetime: mark as data draft?',
  `note` varchar(512) NOT NULL DEFAULT '' COMMENT 'Account''s note',
  `create_account_id` int(11) DEFAULT NULL COMMENT 'Creator id',
  `created_time` datetime DEFAULT NULL COMMENT 'Created time',
  `last_modified_account_id` int(11) DEFAULT NULL COMMENT 'Last modifier id',
  `last_modified_time` datetime DEFAULT NULL COMMENT 'Last modified time',
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQUE_username` (`username`),
  KEY `ACCOUNT__GROUP` (`group_id`),
  KEY `ACCOUNT__CREATE_ACCOUNT` (`create_account_id`),
  KEY `ACCOUNT__LAST_MODIFIED_ACCOUNT` (`last_modified_account_id`),
  KEY `IDX_fullname` (`fullname`),
  KEY `IDX_active` (`active`),
  KEY `IDX_draft` (`draft`),
  KEY `IDX_created_time` (`created_time`),
  CONSTRAINT `ACCOUNT__CREATE_ACCOUNT` FOREIGN KEY (`create_account_id`) REFERENCES `tbl_group` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `ACCOUNT__GROUP` FOREIGN KEY (`group_id`) REFERENCES `tbl_group` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `ACCOUNT__LAST_MODIFIED_ACCOUNT` FOREIGN KEY (`last_modified_account_id`) REFERENCES `tbl_account` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='Tbl, manage accounts!';

/*Data for the table `tbl_account` */

insert  into `tbl_account`(`id`,`group_id_json`,`group_id`,`username`,`password`,`avatar`,`fullname`,`last_login_time`,`active`,`draft`,`note`,`create_account_id`,`created_time`,`last_modified_account_id`,`last_modified_time`) values (1,'',9,'admin','e10adc3949ba59abbe56e057f20f883e','','Administrator',NULL,1,NULL,'',NULL,'2016-07-26 11:10:36',NULL,NULL);

/*Table structure for table `tbl_group` */

DROP TABLE IF EXISTS `tbl_group`;

CREATE TABLE `tbl_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Primary key',
  `code` varchar(55) NOT NULL DEFAULT '' COMMENT 'Group''s code',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT 'Group''s name',
  `note` varchar(512) NOT NULL DEFAULT '' COMMENT 'Group''s note',
  `acl` longtext COMMENT 'Group''s acl (encoded permission string)',
  `active` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Flag: is active?',
  `draft` datetime DEFAULT NULL COMMENT 'Datetime: mark as data draft?',
  `create_account_id` int(11) DEFAULT NULL COMMENT 'Creator id',
  `created_time` datetime DEFAULT NULL COMMENT 'Created time',
  `last_modified_account_id` int(11) DEFAULT NULL COMMENT 'Last modifier id',
  `last_modified_time` datetime DEFAULT NULL COMMENT 'Last modified time',
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQUE_CODE` (`code`),
  KEY `IDX_name` (`name`),
  KEY `IDX_active` (`active`),
  KEY `IDX_draft` (`draft`),
  KEY `GROUP__CREATE_ACCOUNT` (`create_account_id`),
  KEY `GROUP__LAST_MODIFIED_ACCOUNT` (`last_modified_account_id`),
  KEY `IDX_create_time` (`created_time`),
  CONSTRAINT `GROUP__CREATE_ACCOUNT` FOREIGN KEY (`create_account_id`) REFERENCES `tbl_account` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `GROUP__LAST_MODIFIED_ACCOUNT` FOREIGN KEY (`last_modified_account_id`) REFERENCES `tbl_account` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COMMENT='Tbl, manage account''s groups!';

/*Data for the table `tbl_group` */

insert  into `tbl_group`(`id`,`code`,`name`,`note`,`acl`,`active`,`draft`,`create_account_id`,`created_time`,`last_modified_account_id`,`last_modified_time`) values (3,'MOD','Moderator','@author khanhdtp','a:1:{s:7:\"backend\";a:18:{i:0;s:21:\"default/account/login\";i:1;s:22:\"default/account/logout\";i:2;s:23:\"default/account/profile\";i:3;s:21:\"default/account/index\";i:4;s:22:\"default/account/active\";i:5;s:22:\"default/account/create\";i:6;s:22:\"default/account/update\";i:7;s:22:\"default/account/detail\";i:8;s:22:\"default/account/delete\";i:9;s:19:\"default/group/index\";i:10;s:20:\"default/group/active\";i:11;s:20:\"default/group/create\";i:12;s:20:\"default/group/update\";i:13;s:20:\"default/group/detail\";i:14;s:17:\"default/group/acl\";i:15;s:20:\"default/group/delete\";i:16;s:19:\"default/index/index\";i:17;s:20:\"default/index/layout\";}}',1,NULL,1,'2016-07-25 09:55:40',NULL,NULL),(4,'USER','Users','','a:1:{s:8:\"frontend\";a:2:{i:0;s:19:\"default/error/error\";i:1;s:19:\"default/index/index\";}}',0,NULL,1,'2016-07-26 10:19:47',NULL,NULL),(5,'PUBLISHER','PUBLISHER','',NULL,1,NULL,1,'2016-06-28 23:33:20',NULL,NULL),(6,'OTHERS','Khác','',NULL,1,NULL,1,'2016-06-28 23:33:49',NULL,NULL),(8,'BOD-Dup','Duplicate of Board of Director','@author khanhdtp',NULL,0,NULL,1,'2016-07-26 10:19:48',NULL,NULL),(9,'ADMIN','Administrator','Built-in group','a:1:{s:7:\"backend\";a:18:{i:0;s:21:\"default/account/login\";i:1;s:22:\"default/account/logout\";i:2;s:23:\"default/account/profile\";i:3;s:21:\"default/account/index\";i:4;s:22:\"default/account/active\";i:5;s:22:\"default/account/create\";i:6;s:22:\"default/account/update\";i:7;s:22:\"default/account/detail\";i:8;s:22:\"default/account/delete\";i:9;s:19:\"default/group/index\";i:10;s:20:\"default/group/active\";i:11;s:20:\"default/group/create\";i:12;s:20:\"default/group/update\";i:13;s:20:\"default/group/detail\";i:14;s:17:\"default/group/acl\";i:15;s:20:\"default/group/delete\";i:16;s:19:\"default/index/index\";i:17;s:20:\"default/index/layout\";}}',1,NULL,1,'2016-07-25 09:55:47',NULL,NULL),(10,'new_ADMIN','Administrator (new)','Administrator (new)\'s note!',NULL,1,NULL,1,'2016-07-25 05:37:40',NULL,NULL),(11,'MOD_new','(new) Moderator','(new) Moderator\'s note!',NULL,1,NULL,1,'2016-07-25 09:55:48',1,'2016-07-25 05:46:36');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
