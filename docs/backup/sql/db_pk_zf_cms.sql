/*
SQLyog Ultimate v12.09 (64 bit)
MySQL - 5.5.16 : Database - db_pk_zf_cms
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
  `settings` text COMMENT 'Account''s personal settings',
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

insert  into `tbl_account`(`id`,`group_id_json`,`group_id`,`username`,`password`,`avatar`,`fullname`,`last_login_time`,`settings`,`active`,`draft`,`note`,`create_account_id`,`created_time`,`last_modified_account_id`,`last_modified_time`) values (1,'',9,'admin','e10adc3949ba59abbe56e057f20f883e','/khanh-avatar.jpg','khanhdtp',NULL,'a:1:{s:6:\"DWRefs\";a:2:{s:7:\"DSW1000\";a:2:{s:6:\"offset\";s:4:\"1000\";s:4:\"size\";s:1:\"6\";}s:7:\"DSW1010\";a:2:{s:6:\"offset\";s:4:\"1010\";s:4:\"size\";s:1:\"6\";}}}',1,NULL,'',NULL,'2016-07-26 11:10:36',NULL,NULL);

/*Table structure for table `tbl_cart` */

DROP TABLE IF EXISTS `tbl_cart`;

CREATE TABLE `tbl_cart` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'Primary',
  `type` varchar(25) NOT NULL DEFAULT '' COMMENT 'Cart''s type',
  `code` varchar(25) DEFAULT NULL COMMENT 'Cart''s code',
  `payment_method` varchar(15) NOT NULL DEFAULT '' COMMENT 'Cart''s payment method',
  `payment_note` varchar(255) NOT NULL DEFAULT '' COMMENT 'Cart''s payment noted',
  `payment_log` text COMMENT 'Cart''s payment log',
  `transport_method` varchar(15) NOT NULL DEFAULT '' COMMENT 'Cart''s transport method',
  `transport_note` varchar(255) NOT NULL DEFAULT '' COMMENT 'Cart''s transport noted',
  `gift` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Cart''s use gift?',
  `gift_note` varchar(255) NOT NULL DEFAULT '' COMMENT 'Cart''s use gift noted',
  `invoice` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Cart''s exports invoice?',
  `invoice_info` text COMMENT 'Cart''s exports invoice info?',
  `transport_price` double NOT NULL DEFAULT '0' COMMENT 'Cart''s transport price',
  `total_promotion` double NOT NULL DEFAULT '0' COMMENT 'Cart''s total promotion price',
  `total_qty` double NOT NULL DEFAULT '0' COMMENT 'Cart''s total product''s quantity',
  `total_price` double NOT NULL DEFAULT '0' COMMENT 'Cart''s total product''s price',
  `status` tinyint(4) NOT NULL COMMENT 'Cart''s status',
  `process_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'Cart''s process status',
  `process_log` text COMMENT 'Cart''s process log',
  `data` longtext COMMENT 'Cart''s extra data',
  `note` varchar(512) NOT NULL DEFAULT '' COMMENT 'Cart''s user noted',
  `create_account_id` int(11) DEFAULT NULL COMMENT 'Creator id',
  `created_time` datetime DEFAULT NULL COMMENT 'Created time',
  PRIMARY KEY (`id`),
  UNIQUE KEY `IDX_UNIQUE_Code` (`code`),
  KEY `CART__CREATE_ACCOUNT` (`create_account_id`),
  KEY `IDX_payment_method` (`payment_method`),
  KEY `IDX_transport_method` (`transport_method`),
  KEY `IDX_status` (`status`),
  KEY `IDX_process_status` (`process_status`),
  KEY `IDX_created_time` (`created_time`),
  KEY `IDX_type` (`type`),
  CONSTRAINT `CART__CREATE_ACCOUNT` FOREIGN KEY (`create_account_id`) REFERENCES `tbl_account` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='Cart';

/*Data for the table `tbl_cart` */

insert  into `tbl_cart`(`id`,`type`,`code`,`payment_method`,`payment_note`,`payment_log`,`transport_method`,`transport_note`,`gift`,`gift_note`,`invoice`,`invoice_info`,`transport_price`,`total_promotion`,`total_qty`,`total_price`,`status`,`process_status`,`process_log`,`data`,`note`,`create_account_id`,`created_time`) values (1,'PRODUCT','cart00000000001','CASH','Trả tiền mặt khi nhận hàng',NULL,'SELLER','',1,'',0,NULL,0,0,0,128000,0,2,'Xử lý xong, đã thu tiền đầy đủ!',NULL,'@khanhdtp',1,'2016-09-26 13:39:39');

/*Table structure for table `tbl_cart_detail` */

DROP TABLE IF EXISTS `tbl_cart_detail`;

CREATE TABLE `tbl_cart_detail` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'Primary',
  `cart_id` bigint(20) NOT NULL COMMENT 'Cart''s primary',
  `product_id` bigint(20) DEFAULT NULL COMMENT 'Product''s primary',
  `product_sku` varchar(255) NOT NULL DEFAULT '' COMMENT 'Product''s sku',
  `product_code` varchar(25) NOT NULL DEFAULT '' COMMENT 'Product''s code',
  `product_name` varchar(255) NOT NULL DEFAULT '' COMMENT 'Product''s name',
  `product_price` double NOT NULL DEFAULT '0' COMMENT 'Product''s price',
  `promotion` double NOT NULL DEFAULT '0' COMMENT 'Promition price',
  `price` double NOT NULL DEFAULT '0' COMMENT 'Final price',
  `qty` double NOT NULL DEFAULT '0' COMMENT 'Quantity',
  `subtotal` double NOT NULL DEFAULT '0' COMMENT 'Subtotal',
  `note` varchar(255) DEFAULT '' COMMENT 'Note',
  `created_time` datetime DEFAULT NULL COMMENT 'Created time',
  PRIMARY KEY (`id`),
  UNIQUE KEY `IDX_UNIQUE_CART_DETAIL__CART` (`cart_id`,`product_id`),
  KEY `CART_DETAIL__PRODUCT` (`product_id`),
  KEY `IDX_product_info` (`product_sku`,`product_code`,`product_name`),
  CONSTRAINT `CART_DETAIL__CART` FOREIGN KEY (`cart_id`) REFERENCES `tbl_cart` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `CART_DETAIL__PRODUCT` FOREIGN KEY (`product_id`) REFERENCES `tbl_product` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='Cart''s details.';

/*Data for the table `tbl_cart_detail` */

insert  into `tbl_cart_detail`(`id`,`cart_id`,`product_id`,`product_sku`,`product_code`,`product_name`,`product_price`,`promotion`,`price`,`qty`,`subtotal`,`note`,`created_time`) values (1,1,2,'sp_sku_02','sp_code_02','Tên sản phẩm 02',1199999,0,1199999,1,1199999,'@khanhdtp','2016-09-27 15:30:11');

/*Table structure for table `tbl_cart_log` */

DROP TABLE IF EXISTS `tbl_cart_log`;

CREATE TABLE `tbl_cart_log` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'Primary',
  `cart_id` bigint(20) NOT NULL COMMENT 'Cart''s primary',
  `process_status` tinyint(4) NOT NULL COMMENT 'Cart''s process status',
  `content` text NOT NULL COMMENT 'Cart''s process log',
  `create_account_id` int(11) DEFAULT NULL COMMENT 'Creator id',
  `created_time` datetime NOT NULL COMMENT 'Created time',
  PRIMARY KEY (`id`),
  KEY `CART_LOG__CREATE_ACCOUNT` (`create_account_id`),
  KEY `CART_LOG__CART` (`cart_id`),
  KEY `IDX_process_status` (`process_status`),
  KEY `IDX_created_time` (`created_time`),
  CONSTRAINT `CART_LOG__CART` FOREIGN KEY (`cart_id`) REFERENCES `tbl_cart` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `CART_LOG__CREATE_ACCOUNT` FOREIGN KEY (`create_account_id`) REFERENCES `tbl_account` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='Cart''s process log.';

/*Data for the table `tbl_cart_log` */

insert  into `tbl_cart_log`(`id`,`cart_id`,`process_status`,`content`,`create_account_id`,`created_time`) values (3,1,1,'DXL!',1,'2016-09-27 13:20:01'),(4,1,2,'Xử lý xong, đã thu tiền đầy đủ!',1,'2016-09-27 13:20:18');

/*Table structure for table `tbl_category` */

DROP TABLE IF EXISTS `tbl_category`;

CREATE TABLE `tbl_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Primary key',
  `parent_id` int(11) DEFAULT NULL COMMENT 'Parent''s primary key',
  `code` varchar(55) NOT NULL DEFAULT '' COMMENT 'Category''s code',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT 'Category''s name',
  `alias` varchar(255) NOT NULL DEFAULT '' COMMENT 'Category''s name no mark',
  `type` varchar(25) NOT NULL DEFAULT '' COMMENT 'Category''s type',
  `imgs` text COMMENT 'Category''s images',
  `viewed` int(11) NOT NULL DEFAULT '0' COMMENT 'Viewed count',
  `note` varchar(512) NOT NULL DEFAULT '' COMMENT 'Category''s note',
  `active` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Flag: is active?',
  `draft` datetime DEFAULT NULL COMMENT 'Datetime: mark as data draft?',
  `create_account_id` int(11) DEFAULT NULL COMMENT 'Creator id',
  `created_time` datetime DEFAULT NULL COMMENT 'Created time',
  `last_modified_account_id` int(11) DEFAULT NULL COMMENT 'Last modifier id',
  `last_modified_time` datetime DEFAULT NULL COMMENT 'Last modified time',
  `phrase` varchar(8) NOT NULL DEFAULT 'CATEGORY' COMMENT 'Phrase''s context string',
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQUE_IDX1` (`code`,`type`),
  KEY `IDX_name` (`name`),
  KEY `IDX_type` (`type`),
  KEY `IDX_active` (`active`),
  KEY `IDX_created_time` (`created_time`),
  KEY `CATEGORY__PARENT` (`parent_id`),
  KEY `CATEGORY__CREATE_ACCOUNT` (`create_account_id`),
  KEY `CATEGORY__LAST_MODIFIED_ACCOUNT` (`last_modified_account_id`),
  KEY `IDX_alias` (`alias`),
  CONSTRAINT `CATEGORY__CREATE_ACCOUNT` FOREIGN KEY (`create_account_id`) REFERENCES `tbl_account` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `CATEGORY__LAST_MODIFIED_ACCOUNT` FOREIGN KEY (`last_modified_account_id`) REFERENCES `tbl_account` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `CATEGORY__PARENT` FOREIGN KEY (`parent_id`) REFERENCES `tbl_category` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COMMENT='Category, grouping many kinds of data.';

/*Data for the table `tbl_category` */

insert  into `tbl_category`(`id`,`parent_id`,`code`,`name`,`alias`,`type`,`imgs`,`viewed`,`note`,`active`,`draft`,`create_account_id`,`created_time`,`last_modified_account_id`,`last_modified_time`,`phrase`) values (2,NULL,'dm_san_pham_1','Danh mục sản phẩm 1','danh-muc-san-pham-1','PRODUCT','/9.png\r\n/8.png\r\n/4.png\r\n/1.png\r\n/2.png\r\n/3.png\r\n/5.png\r\n/6.png\r\n/7.png',0,'@author khanhdtp',1,NULL,1,NULL,1,'2016-08-11 14:40:42','CATEGORY'),(3,NULL,'cate3','Cate 3','cate-3','PRODUCT','/2.png\r\n/3.png\r\n/4.png\r\n/5.png\r\n/6.png\r\n/7.png\r\n/8.png\r\n/9.png',0,'',1,NULL,1,NULL,1,'2016-08-11 11:12:53','CATEGORY'),(11,NULL,'cate1.1.2','Cate 1.1.2','cate-1-1-2','PRODUCT','/6.png\r\n/1.png\r\n/2.png\r\n/3.png\r\n/4.png\r\n/5.png\r\n/7.png\r\n/8.png\r\n/9.png',0,'',1,NULL,1,NULL,1,'2016-08-11 15:23:08','CATEGORY'),(12,NULL,'TIN_TUC','Tin tức','tin-tuc','POST','/multi_columns_based_index.png\r\n/reundant_indexes.png\r\n/Workspace%201_022.png\r\n/Workspace%201_026.png',1234,'Danh mục tin tức chung (@author khanhdtp)',1,NULL,1,'2016-08-12 13:00:55',1,'2016-08-18 10:20:29','CATEGORY'),(13,NULL,'TUYEN_DUNG','Tuyển dụng','tuyen-dung','POST','\r\n/TuyenDung/Selection_001.png\r\n/TuyenDung/Selection_002.png\r\n/TuyenDung/Selection_003.png',0,'Tuyển dụng',1,NULL,1,'2016-08-12 13:10:19',NULL,NULL,'CATEGORY'),(14,NULL,'GIOI_THIEU','Giới thiệu','gioi-thieu','POST','\r\n/GioiThieu/Selection_004.png\r\n/GioiThieu/Selection_005.png\r\n/GioiThieu/Selection_006.png',0,'Giới thiệu',1,NULL,1,'2016-08-12 13:11:10',NULL,NULL,'CATEGORY'),(15,12,'TIN_TUC--THE_THAO','Thể thao','the-thao','POST','\r\n/TinTuc/TheThao/Selection_006.png\r\n/TinTuc/TheThao/Selection_007.png\r\n/TinTuc/TheThao/Selection_008.png',0,'Thể thao',1,NULL,1,'2016-08-12 13:13:46',NULL,NULL,'CATEGORY'),(16,12,'TIN_TUC--DU_LICH','Du lịch','du-lich','POST','\r\n/TinTuc/DuLich/Selection_010.png\r\n/TinTuc/DuLich/Selection_011.png\r\n/TinTuc/DuLich/Selection_012.png',0,'Du lịch',1,NULL,1,'2016-08-12 13:14:30',NULL,NULL,'CATEGORY');

/*Table structure for table `tbl_conf` */

DROP TABLE IF EXISTS `tbl_conf`;

CREATE TABLE `tbl_conf` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Primary key',
  `group` varchar(25) NOT NULL COMMENT 'Config group.',
  `code` varchar(55) NOT NULL DEFAULT '' COMMENT 'Config code',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT 'Config name',
  `value` longtext COMMENT 'Config value',
  `input` varchar(25) NOT NULL DEFAULT '' COMMENT 'Config input mode',
  `note` varchar(512) NOT NULL DEFAULT '' COMMENT 'Config''s note',
  `create_account_id` int(11) DEFAULT NULL COMMENT 'Creator id',
  `created_time` datetime DEFAULT NULL COMMENT 'Created time',
  `last_modified_account_id` int(11) DEFAULT NULL COMMENT 'Last modifier id',
  `last_modified_time` datetime DEFAULT NULL COMMENT 'Last modified time',
  `phrase` varchar(4) NOT NULL DEFAULT 'CONF' COMMENT 'Phrase''s context string',
  PRIMARY KEY (`id`),
  UNIQUE KEY `IDX_UNIQUE_01` (`group`,`code`),
  KEY `IDX_name` (`name`),
  KEY `IDX_created_time` (`created_time`),
  KEY `CONF__CREATE_ACCOUNT` (`create_account_id`),
  KEY `CONF__LAST_MODIFIED_ACCOUNT` (`last_modified_account_id`),
  KEY `IDX_last_modified_time` (`last_modified_time`),
  KEY `IDX_code` (`code`),
  KEY `IDX_input` (`input`),
  CONSTRAINT `CONF__CREATE_ACCOUNT` FOREIGN KEY (`create_account_id`) REFERENCES `tbl_account` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `CONF__LAST_MODIFIED_ACCOUNT` FOREIGN KEY (`last_modified_account_id`) REFERENCES `tbl_account` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='System, and module configs.';

/*Data for the table `tbl_conf` */

insert  into `tbl_conf`(`id`,`group`,`code`,`name`,`value`,`input`,`note`,`create_account_id`,`created_time`,`last_modified_account_id`,`last_modified_time`,`phrase`) values (5,'default','conf_001','Config 001','Value 001','plaintext','PlainText',1,'2016-09-20 13:58:02',NULL,NULL,'CONF'),(6,'default','conf_002','Config 002','<p>Value html</p>\r\n','html','Html',1,'2016-09-20 13:58:16',NULL,NULL,'CONF');

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

/*Table structure for table `tbl_payment` */

DROP TABLE IF EXISTS `tbl_payment`;

CREATE TABLE `tbl_payment` (
  `id` int(11) NOT NULL COMMENT 'Primary',
  `type` varchar(25) NOT NULL DEFAULT '' COMMENT 'Payment type',
  `provider` varchar(255) NOT NULL DEFAULT '' COMMENT 'Payment provider',
  `username` varchar(255) NOT NULL DEFAULT '' COMMENT 'Payment API username',
  `password` varchar(128) NOT NULL DEFAULT '' COMMENT 'Payment API password',
  `data` text COMMENT 'Payment extra data',
  `note` varchar(255) NOT NULL DEFAULT '' COMMENT 'Payment note',
  `create_account_id` int(11) DEFAULT NULL COMMENT 'Creator id',
  `created_time` datetime DEFAULT NULL COMMENT 'Created time',
  `last_modified_account_id` int(11) DEFAULT NULL COMMENT 'Last modifier id',
  `last_modified_time` datetime DEFAULT NULL COMMENT 'Last modified time',
  PRIMARY KEY (`id`),
  KEY `IDX_type` (`type`),
  KEY `IDX_provider` (`provider`),
  KEY `IDX_username__password` (`username`,`password`),
  KEY `IDX_created_time` (`created_time`),
  KEY `IDX_last_modified_time` (`last_modified_time`),
  KEY `PAYMENT__CREATE_ACCOUNT` (`create_account_id`),
  KEY `PAYMENT__LAST_MODIFIED_ACCOUNT` (`last_modified_account_id`),
  CONSTRAINT `PAYMENT__CREATE_ACCOUNT` FOREIGN KEY (`create_account_id`) REFERENCES `tbl_account` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `PAYMENT__LAST_MODIFIED_ACCOUNT` FOREIGN KEY (`last_modified_account_id`) REFERENCES `tbl_account` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Payment gateway info.';

/*Data for the table `tbl_payment` */

/*Table structure for table `tbl_phrase` */

DROP TABLE IF EXISTS `tbl_phrase`;

CREATE TABLE `tbl_phrase` (
  `phr_id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'Primary key',
  `phr_context` varchar(128) NOT NULL DEFAULT '' COMMENT 'Context string',
  `phr_rel_id` varchar(32) NOT NULL DEFAULT '' COMMENT 'Relative id (context''s primary key)',
  `phr_lang` varchar(3) NOT NULL DEFAULT '' COMMENT 'Language key (string)',
  `phr_column` varchar(128) NOT NULL DEFAULT '' COMMENT 'Column name',
  `phr_data` longtext COMMENT 'Column data',
  PRIMARY KEY (`phr_id`),
  UNIQUE KEY `UNIQUE_ROW` (`phr_context`,`phr_rel_id`,`phr_lang`,`phr_column`),
  KEY `IDX_column_n_data` (`phr_column`,`phr_data`(255))
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=utf8 COMMENT='Language''s phrases..!';

/*Data for the table `tbl_phrase` */

insert  into `tbl_phrase`(`phr_id`,`phr_context`,`phr_rel_id`,`phr_lang`,`phr_column`,`phr_data`) values (13,'CATEGORY','11','vi','seo_title',''),(14,'CATEGORY','11','vi','seo_meta_keywords',''),(15,'CATEGORY','11','vi','seo_meta_description',''),(16,'CATEGORY','11','vi','seo_html_meta',''),(17,'CATEGORY','2','en','name','Product category name 1'),(18,'CATEGORY','2','en','alias','product-category-name-1'),(19,'CATEGORY','2','en','seo_title','PC page\'s title'),(20,'CATEGORY','2','en','seo_meta_keywords','PC page\'s meta keywords'),(21,'CATEGORY','2','en','seo_meta_description','PC page\'s meta description'),(22,'CATEGORY','2','en','seo_html_meta','<meta />'),(23,'CATEGORY','2','jp','name','製品カテゴリ'),(24,'CATEGORY','2','jp','alias','製品カテゴリ'),(25,'CATEGORY','2','jp','seo_title','Page\'s title # 製品カテゴリ'),(26,'CATEGORY','2','jp','seo_meta_keywords','Page\'s meta keyword # 製品カテゴリ'),(27,'CATEGORY','2','jp','seo_meta_description','Page\'s meta description # 製品カテゴリ'),(28,'CATEGORY','2','jp','seo_html_meta','<meta data-html=\"製品カテゴリ\" />'),(29,'CATEGORY','12','vi','seo_title','Tin tức'),(30,'CATEGORY','12','vi','seo_meta_keywords','Tin tức'),(31,'CATEGORY','12','vi','seo_meta_description','Tin tức'),(32,'CATEGORY','12','vi','seo_html_meta','Tin tức'),(33,'CATEGORY','13','vi','seo_title','Tuyển dụng'),(34,'CATEGORY','13','vi','seo_meta_keywords','Tuyển dụng'),(35,'CATEGORY','13','vi','seo_meta_description','Tuyển dụng'),(36,'CATEGORY','13','vi','seo_html_meta','Tuyển dụng'),(37,'CATEGORY','14','vi','seo_title','Giới thiệu'),(38,'CATEGORY','14','vi','seo_meta_keywords','Giới thiệu'),(39,'CATEGORY','14','vi','seo_meta_description','Giới thiệu'),(40,'CATEGORY','14','vi','seo_html_meta','Giới thiệu'),(41,'CATEGORY','15','vi','seo_title','Thể thao'),(42,'CATEGORY','15','vi','seo_meta_keywords','Thể thao'),(43,'CATEGORY','15','vi','seo_meta_description','Thể thao'),(44,'CATEGORY','15','vi','seo_html_meta','Thể thao'),(45,'CATEGORY','16','vi','seo_title','Du lịch'),(46,'CATEGORY','16','vi','seo_meta_keywords','Du lịch'),(47,'CATEGORY','16','vi','seo_meta_description','Du lịch'),(48,'CATEGORY','16','vi','seo_html_meta','Du lịch'),(49,'PRODUCT','1','vi','tags_str','san pham, san pham 1'),(50,'PRODUCT','1','vi','seo_title','page\'s title : san pham 1'),(51,'PRODUCT','1','vi','seo_meta_keywords','page\'s meta keywords : san pham 1'),(52,'PRODUCT','1','vi','seo_meta_description','page\'s meta description : san pham 1'),(53,'PRODUCT','1','vi','seo_html_meta','Page\'s html meta : san pham 1'),(54,'PRODUCT','1','en','name','Product name 1'),(55,'PRODUCT','1','en','alias','product-name-1'),(56,'PRODUCT','1','en','content','<p>Product content 1</p>\r\n'),(57,'PRODUCT','1','en','tags_str','product name, product name 1'),(58,'PRODUCT','1','en','seo_title','PC page\'s title # product name 1'),(59,'PRODUCT','1','en','seo_meta_keywords','PC page\'s meta keywords # product name 1'),(60,'PRODUCT','1','en','seo_meta_description','PC page\'s meta description # product name 1'),(61,'PRODUCT','1','en','seo_html_meta','Page\'s html meta # product name 1'),(62,'PRODUCT','2','vi','tags_str','san-pham 02, san pham 02, san 02, pham 02'),(63,'PRODUCT','2','vi','seo_title','sp-02\'s page title'),(64,'PRODUCT','2','vi','seo_meta_keywords','sp-02\'s page meta keywords'),(65,'PRODUCT','2','vi','seo_meta_description','sp-02\'s page meta description'),(66,'PRODUCT','2','vi','seo_html_meta','<meta data=\"page html meta\" />');

/*Table structure for table `tbl_post` */

DROP TABLE IF EXISTS `tbl_post`;

CREATE TABLE `tbl_post` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'Primary key',
  `type` varchar(25) NOT NULL DEFAULT 'POST' COMMENT 'Post''s type',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT 'Post''s name',
  `alias` varchar(255) NOT NULL DEFAULT '' COMMENT 'Post''s name no mark',
  `imgs` text COMMENT 'Post''s images',
  `content_short` text COMMENT 'Post''s short content',
  `content_full` longtext COMMENT 'Post''s full content',
  `viewed` int(11) NOT NULL DEFAULT '0' COMMENT 'Viewed count',
  `note` varchar(512) NOT NULL DEFAULT '' COMMENT 'Post''s note',
  `active` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Flag: is active?',
  `draft` datetime DEFAULT NULL COMMENT 'Datetime: mark as data draft?',
  `create_account_id` int(11) DEFAULT NULL COMMENT 'Creator id',
  `created_time` datetime DEFAULT NULL COMMENT 'Created time',
  `last_modified_account_id` int(11) DEFAULT NULL COMMENT 'Last modifier id',
  `last_modified_time` datetime DEFAULT NULL COMMENT 'Last modified time',
  `phrase` varchar(4) NOT NULL DEFAULT 'POST' COMMENT 'Phrase''s context string',
  `tag` varchar(4) NOT NULL DEFAULT 'POST' COMMENT 'Tag''s context string',
  PRIMARY KEY (`id`),
  KEY `IDX_name` (`name`),
  KEY `IDX_type` (`type`),
  KEY `IDX_active` (`active`),
  KEY `IDX_created_time` (`created_time`),
  KEY `IDX_draft` (`draft`),
  KEY `POST__CREATE_ACCOUNT` (`create_account_id`),
  KEY `POST__LAST_MODIFIED_ACCOUNT` (`last_modified_account_id`),
  KEY `IDX_alias` (`alias`),
  CONSTRAINT `POST__CREATE_ACCOUNT` FOREIGN KEY (`create_account_id`) REFERENCES `tbl_account` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `POST__LAST_MODIFIED_ACCOUNT` FOREIGN KEY (`last_modified_account_id`) REFERENCES `tbl_account` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='Post object, hold many types of data (article, news, pages...)';

/*Data for the table `tbl_post` */

insert  into `tbl_post`(`id`,`type`,`name`,`alias`,`imgs`,`content_short`,`content_full`,`viewed`,`note`,`active`,`draft`,`create_account_id`,`created_time`,`last_modified_account_id`,`last_modified_time`,`phrase`,`tag`) values (1,'POST','Bài viết - Tin tức 01','bai-viet---tin-tuc-01','/Mysql-Joins.png','<p>Noi dung rut gon</p>\r\n','<p>Noi dung day du</p>\r\n',100,'Ghi chu bai viet',1,NULL,1,'2016-09-20 09:07:52',NULL,NULL,'POST','POST');

/*Table structure for table `tbl_post_category` */

DROP TABLE IF EXISTS `tbl_post_category`;

CREATE TABLE `tbl_post_category` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'Primary',
  `post_id` bigint(20) NOT NULL COMMENT 'Post''s id',
  `category_id` int(11) NOT NULL COMMENT 'Category''s id',
  `create_account_id` int(11) DEFAULT NULL COMMENT 'Creator id',
  `created_time` datetime DEFAULT NULL COMMENT 'Created time',
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQUE_IDX1` (`post_id`,`category_id`),
  KEY `POST_CATEGORY__CATEGORY` (`category_id`),
  KEY `POST_CATEGORY__CREATOR` (`create_account_id`),
  KEY `IDX_created_time` (`created_time`),
  CONSTRAINT `POST_CATEGORY__CATEGORY` FOREIGN KEY (`category_id`) REFERENCES `tbl_category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `POST_CATEGORY__CREATOR` FOREIGN KEY (`create_account_id`) REFERENCES `tbl_account` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `POST_CATEGORY__POST` FOREIGN KEY (`post_id`) REFERENCES `tbl_post` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='n - n table, post + category';

/*Data for the table `tbl_post_category` */

insert  into `tbl_post_category`(`id`,`post_id`,`category_id`,`create_account_id`,`created_time`) values (1,1,12,1,'2016-09-20 09:07:52');

/*Table structure for table `tbl_product` */

DROP TABLE IF EXISTS `tbl_product`;

CREATE TABLE `tbl_product` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'Primary key',
  `type` varchar(25) NOT NULL DEFAULT '' COMMENT 'Product''s type',
  `code` varchar(25) DEFAULT NULL COMMENT 'Product''s code',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT 'Product''s name',
  `alias` varchar(255) NOT NULL DEFAULT '' COMMENT 'Product''s name no mark',
  `sku` varchar(255) DEFAULT NULL COMMENT 'Product''s sku',
  `imgs` text COMMENT 'Product''s images',
  `content_short` text COMMENT 'Product''s short content',
  `content_full` longtext COMMENT 'Product''s full content',
  `price` double NOT NULL DEFAULT '0' COMMENT 'Product''s price',
  `price_dropped` double NOT NULL DEFAULT '0' COMMENT 'Product''s price dropped',
  `qty` double NOT NULL DEFAULT '0' COMMENT 'Product''s quantity',
  `viewed` int(11) NOT NULL DEFAULT '0' COMMENT 'Viewed count',
  `note` varchar(512) NOT NULL DEFAULT '' COMMENT 'Product''s note',
  `active` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Flag: is active?',
  `draft` datetime DEFAULT NULL COMMENT 'Datetime: mark as data draft?',
  `create_account_id` int(11) DEFAULT NULL COMMENT 'Creator id',
  `created_time` datetime DEFAULT NULL COMMENT 'Created time',
  `last_modified_account_id` int(11) DEFAULT NULL COMMENT 'Last modifier id',
  `last_modified_time` datetime DEFAULT NULL COMMENT 'Last modified time',
  `phrase` varchar(7) NOT NULL DEFAULT 'PRODUCT' COMMENT 'Phrase''s context string',
  `tag` varchar(7) NOT NULL DEFAULT 'PRODUCT' COMMENT 'Tag''s context string',
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQUE_IDX_code` (`code`),
  UNIQUE KEY `UNIQUE_IDX_sku` (`sku`),
  KEY `IDX_name` (`name`),
  KEY `IDX_type` (`type`),
  KEY `IDX_active` (`active`),
  KEY `IDX_created_time` (`created_time`),
  KEY `IDX_draft` (`draft`),
  KEY `PRODUCT__CREATE_ACCOUNT` (`create_account_id`),
  KEY `PRODUCT__LAST_MODIFIED_ACCOUNT` (`last_modified_account_id`),
  KEY `IDX_price` (`price`),
  KEY `IDX_alias` (`alias`),
  CONSTRAINT `PRODUCT__CREATE_ACCOUNT` FOREIGN KEY (`create_account_id`) REFERENCES `tbl_account` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `PRODUCT__LAST_MODIFIED_ACCOUNT` FOREIGN KEY (`last_modified_account_id`) REFERENCES `tbl_account` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='Product';

/*Data for the table `tbl_product` */

insert  into `tbl_product`(`id`,`type`,`code`,`name`,`alias`,`sku`,`imgs`,`content_short`,`content_full`,`price`,`price_dropped`,`qty`,`viewed`,`note`,`active`,`draft`,`create_account_id`,`created_time`,`last_modified_account_id`,`last_modified_time`,`phrase`,`tag`) values (1,'PRODUCT','san-pham-01','Sản phẩm 01','san-pham-01','sku-01','/2016-08/14.jpg\r\n/2016-08/10.jpg\r\n/2016-08/19.jpg\r\n/2016-08/5.jpg\r\n/2016-08/6.jpg\r\n/2016-08/7.jpg','<p>Thong tin san pham...</p>\r\n',NULL,128000,0,0,2345,'ghi chu san pham (khanhdtp)',1,NULL,1,'2016-08-18 10:11:52',1,'2016-08-18 10:26:57','PRODUCT','PRODUCT'),(2,'PRODUCT','sp_code_02','Tên sản phẩm 02','ten-san-pham-02','sp_sku_02','/Mysql-Joins.png','<p>Th&ocirc;ng tin sản phẩm, r&uacute;t gọn!</p>\r\n','<p>Th&ocirc;ng tin sản phảm đầy đủ!</p>\r\n',1199999,0,0,0,'',1,NULL,1,'2016-09-20 08:50:55',NULL,NULL,'PRODUCT','PRODUCT');

/*Table structure for table `tbl_product_category` */

DROP TABLE IF EXISTS `tbl_product_category`;

CREATE TABLE `tbl_product_category` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'Primary',
  `product_id` bigint(20) NOT NULL COMMENT 'Product''s id',
  `category_id` int(11) NOT NULL COMMENT 'Category''s id',
  `create_account_id` int(11) DEFAULT NULL COMMENT 'Creator id',
  `created_time` datetime DEFAULT NULL COMMENT 'Created time',
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQUE_IDX1` (`product_id`,`category_id`),
  KEY `PRODUCT_CATEGORY__CATEGORY` (`category_id`),
  KEY `PRODUCT_CATEGORY__CREATOR` (`create_account_id`),
  KEY `IDX_created_time` (`created_time`),
  CONSTRAINT `PRODUCT_CATEGORY__CATEGORY` FOREIGN KEY (`category_id`) REFERENCES `tbl_category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `PRODUCT_CATEGORY__CREATOR` FOREIGN KEY (`create_account_id`) REFERENCES `tbl_account` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `PRODUCT_CATEGORY__PRODUCT` FOREIGN KEY (`product_id`) REFERENCES `tbl_product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='n - n table, product + category';

/*Data for the table `tbl_product_category` */

insert  into `tbl_product_category`(`id`,`product_id`,`category_id`,`create_account_id`,`created_time`) values (1,2,2,1,'2016-09-20 08:50:55'),(2,2,11,1,'2016-09-20 08:50:55');

/*Table structure for table `tbl_product_rel` */

DROP TABLE IF EXISTS `tbl_product_rel`;

CREATE TABLE `tbl_product_rel` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'Primary',
  `type` varchar(25) NOT NULL DEFAULT '' COMMENT 'Relationship type',
  `product_id` bigint(20) NOT NULL COMMENT 'Product''s id',
  `product_rel_id` bigint(20) NOT NULL COMMENT 'Product relationship''s id',
  `create_account_id` int(11) DEFAULT NULL COMMENT 'Creator id',
  `created_time` datetime DEFAULT NULL COMMENT 'Created time',
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQUE_IDX1` (`type`,`product_id`,`product_rel_id`),
  KEY `PRODUCT_REL__PRODUCT` (`product_id`),
  KEY `PRODUCT_REL__PRODUCT_REL` (`product_rel_id`),
  KEY `PRODUCT_REL__CREATOR` (`create_account_id`),
  CONSTRAINT `PRODUCT_REL__CREATOR` FOREIGN KEY (`create_account_id`) REFERENCES `tbl_account` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `PRODUCT_REL__PRODUCT` FOREIGN KEY (`product_id`) REFERENCES `tbl_product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `PRODUCT_REL__PRODUCT_REL` FOREIGN KEY (`product_rel_id`) REFERENCES `tbl_product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='n - n table, product + product';

/*Data for the table `tbl_product_rel` */

/*Table structure for table `tbl_tag` */

DROP TABLE IF EXISTS `tbl_tag`;

CREATE TABLE `tbl_tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Primary key',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT 'Tag''s name',
  `alias` varchar(255) NOT NULL DEFAULT '' COMMENT 'Tag''s alias',
  `viewed` int(11) NOT NULL DEFAULT '0' COMMENT 'Viewed count',
  `created_time` datetime DEFAULT NULL COMMENT 'Created time',
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQUE_IDX_name` (`name`),
  KEY `IDX_alias` (`alias`),
  KEY `IDX_created_time` (`created_time`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COMMENT='tag, tagging';

/*Data for the table `tbl_tag` */

insert  into `tbl_tag`(`id`,`name`,`alias`,`viewed`,`created_time`) values (3,'tag 1','tag-1',0,'2016-08-16 13:22:04'),(4,'tag 2','tag-2',0,'2016-08-16 13:22:04'),(5,'tag 3','tag-3',0,'2016-08-16 13:22:05'),(6,'tag 4','tag-4',0,'2016-08-16 13:22:52'),(7,'bai viet 1','bai-viet-1',0,'2016-08-17 15:20:19'),(8,'bai viet so 1','bai-viet-so-1',0,'2016-08-17 15:20:19'),(9,'post title','post-title',0,'2016-08-17 15:26:40'),(10,'post title 1','post-title-1',0,'2016-08-17 15:26:40'),(11,'記事のタイトル','記事のタイトル',0,'2016-08-17 15:29:43'),(12,'記事のタイトル1','記事のタイトル1',0,'2016-08-17 15:29:44'),(13,'san pham','san-pham',0,'2016-08-18 10:11:52'),(14,'san pham 1','san-pham-1',0,'2016-08-18 10:11:52'),(15,'product name','product-name',0,'2016-08-18 10:36:59'),(16,'product name 1','product-name-1',0,'2016-08-18 10:36:59'),(17,'san-pham 02','san-pham-02',0,'2016-09-20 08:50:55'),(18,'san pham 02','san-pham-02',0,'2016-09-20 08:50:55'),(19,'san 02','san-02',0,'2016-09-20 08:50:55'),(20,'pham 02','pham-02',0,'2016-09-20 08:50:55');

/*Table structure for table `tbl_tag_item` */

DROP TABLE IF EXISTS `tbl_tag_item`;

CREATE TABLE `tbl_tag_item` (
  `tag_id` int(11) NOT NULL COMMENT 'Tag''s id',
  `item_id` varchar(32) NOT NULL DEFAULT '' COMMENT 'Item''s id',
  `context` varchar(128) NOT NULL DEFAULT '' COMMENT 'Context string',
  PRIMARY KEY (`tag_id`,`item_id`,`context`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='tag, tagging (items)';

/*Data for the table `tbl_tag_item` */

insert  into `tbl_tag_item`(`tag_id`,`item_id`,`context`) values (15,'1','PRODUCT'),(16,'1','PRODUCT'),(17,'2','PRODUCT'),(18,'2','PRODUCT'),(19,'2','PRODUCT'),(20,'2','PRODUCT');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
