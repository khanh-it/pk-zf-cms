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

insert  into `tbl_account`(`id`,`group_id_json`,`group_id`,`username`,`password`,`avatar`,`fullname`,`last_login_time`,`settings`,`active`,`draft`,`note`,`create_account_id`,`created_time`,`last_modified_account_id`,`last_modified_time`) values (1,'',9,'admin','e10adc3949ba59abbe56e057f20f883e','/khanh-avatar.jpg','khanhdtp',NULL,NULL,1,NULL,'',NULL,'2016-07-26 11:10:36',NULL,NULL);

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

insert  into `tbl_category`(`id`,`parent_id`,`code`,`name`,`alias`,`type`,`imgs`,`note`,`active`,`draft`,`create_account_id`,`created_time`,`last_modified_account_id`,`last_modified_time`,`phrase`) values (2,NULL,'dm_san_pham_1','Danh mục sản phẩm 1','danh-muc-san-pham-1','PRODUCT','/9.png\r\n/8.png\r\n/4.png\r\n/1.png\r\n/2.png\r\n/3.png\r\n/5.png\r\n/6.png\r\n/7.png','@author khanhdtp',1,NULL,1,NULL,1,'2016-08-11 14:40:42','CATEGORY'),(3,NULL,'cate3','Cate 3','cate-3','PRODUCT','/2.png\r\n/3.png\r\n/4.png\r\n/5.png\r\n/6.png\r\n/7.png\r\n/8.png\r\n/9.png','',1,NULL,1,NULL,1,'2016-08-11 11:12:53','CATEGORY'),(11,NULL,'cate1.1.2','Cate 1.1.2','cate-1-1-2','PRODUCT','/6.png\r\n/1.png\r\n/2.png\r\n/3.png\r\n/4.png\r\n/5.png\r\n/7.png\r\n/8.png\r\n/9.png','',1,NULL,1,NULL,1,'2016-08-11 15:23:08','CATEGORY'),(12,NULL,'TIN_TUC','Tin tức','tin-tuc','POST','\r\n/multi_columns_based_index.png\r\n/reundant_indexes.png\r\n/Workspace%201_022.png\r\n/Workspace%201_026.png','Danh mục tin tức chung (@author khanhdtp)',1,NULL,1,'2016-08-12 13:00:55',NULL,NULL,'CATEGORY'),(13,NULL,'TUYEN_DUNG','Tuyển dụng','tuyen-dung','POST','\r\n/TuyenDung/Selection_001.png\r\n/TuyenDung/Selection_002.png\r\n/TuyenDung/Selection_003.png','Tuyển dụng',1,NULL,1,'2016-08-12 13:10:19',NULL,NULL,'CATEGORY'),(14,NULL,'GIOI_THIEU','Giới thiệu','gioi-thieu','POST','\r\n/GioiThieu/Selection_004.png\r\n/GioiThieu/Selection_005.png\r\n/GioiThieu/Selection_006.png','Giới thiệu',1,NULL,1,'2016-08-12 13:11:10',NULL,NULL,'CATEGORY'),(15,12,'TIN_TUC--THE_THAO','Thể thao','the-thao','POST','\r\n/TinTuc/TheThao/Selection_006.png\r\n/TinTuc/TheThao/Selection_007.png\r\n/TinTuc/TheThao/Selection_008.png','Thể thao',1,NULL,1,'2016-08-12 13:13:46',NULL,NULL,'CATEGORY'),(16,12,'TIN_TUC--DU_LICH','Du lịch','du-lich','POST','\r\n/TinTuc/DuLich/Selection_010.png\r\n/TinTuc/DuLich/Selection_011.png\r\n/TinTuc/DuLich/Selection_012.png','Du lịch',1,NULL,1,'2016-08-12 13:14:30',NULL,NULL,'CATEGORY');

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
) ENGINE=InnoDB AUTO_INCREMENT=72 DEFAULT CHARSET=utf8 COMMENT='Language''s phrases..!';

/*Data for the table `tbl_phrase` */

insert  into `tbl_phrase`(`phr_id`,`phr_context`,`phr_rel_id`,`phr_lang`,`phr_column`,`phr_data`) values (13,'CATEGORY','11','vi','seo_title',''),(14,'CATEGORY','11','vi','seo_meta_keywords',''),(15,'CATEGORY','11','vi','seo_meta_description',''),(16,'CATEGORY','11','vi','seo_html_meta',''),(17,'CATEGORY','2','en','name','Product category name 1'),(18,'CATEGORY','2','en','alias','product-category-name-1'),(19,'CATEGORY','2','en','seo_title','PC page\'s title'),(20,'CATEGORY','2','en','seo_meta_keywords','PC page\'s meta keywords'),(21,'CATEGORY','2','en','seo_meta_description','PC page\'s meta description'),(22,'CATEGORY','2','en','seo_html_meta','<meta />'),(23,'CATEGORY','2','jp','name','製品カテゴリ'),(24,'CATEGORY','2','jp','alias','製品カテゴリ'),(25,'CATEGORY','2','jp','seo_title','Page\'s title # 製品カテゴリ'),(26,'CATEGORY','2','jp','seo_meta_keywords','Page\'s meta keyword # 製品カテゴリ'),(27,'CATEGORY','2','jp','seo_meta_description','Page\'s meta description # 製品カテゴリ'),(28,'CATEGORY','2','jp','seo_html_meta','<meta data-html=\"製品カテゴリ\" />'),(29,'CATEGORY','12','vi','seo_title','Tin tức'),(30,'CATEGORY','12','vi','seo_meta_keywords','Tin tức'),(31,'CATEGORY','12','vi','seo_meta_description','Tin tức'),(32,'CATEGORY','12','vi','seo_html_meta','Tin tức'),(33,'CATEGORY','13','vi','seo_title','Tuyển dụng'),(34,'CATEGORY','13','vi','seo_meta_keywords','Tuyển dụng'),(35,'CATEGORY','13','vi','seo_meta_description','Tuyển dụng'),(36,'CATEGORY','13','vi','seo_html_meta','Tuyển dụng'),(37,'CATEGORY','14','vi','seo_title','Giới thiệu'),(38,'CATEGORY','14','vi','seo_meta_keywords','Giới thiệu'),(39,'CATEGORY','14','vi','seo_meta_description','Giới thiệu'),(40,'CATEGORY','14','vi','seo_html_meta','Giới thiệu'),(41,'CATEGORY','15','vi','seo_title','Thể thao'),(42,'CATEGORY','15','vi','seo_meta_keywords','Thể thao'),(43,'CATEGORY','15','vi','seo_meta_description','Thể thao'),(44,'CATEGORY','15','vi','seo_html_meta','Thể thao'),(45,'CATEGORY','16','vi','seo_title','Du lịch'),(46,'CATEGORY','16','vi','seo_meta_keywords','Du lịch'),(47,'CATEGORY','16','vi','seo_meta_description','Du lịch'),(48,'CATEGORY','16','vi','seo_html_meta','Du lịch');

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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='Post object, hold many types of data (article, news, pages...)';

/*Data for the table `tbl_post` */

/*Table structure for table `tbl_post_category` */

DROP TABLE IF EXISTS `tbl_post_category`;

CREATE TABLE `tbl_post_category` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `post_id` bigint(20) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `create_account_id` int(11) DEFAULT NULL COMMENT 'Creator id',
  `created_time` datetime DEFAULT NULL COMMENT 'Created time',
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQUE_IDX1` (`post_id`,`category_id`),
  KEY `POST_CATEGORY__CATEGORY` (`category_id`),
  KEY `POST_CATEGORY__CREATOR` (`create_account_id`),
  CONSTRAINT `POST_CATEGORY__CATEGORY` FOREIGN KEY (`category_id`) REFERENCES `tbl_category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `POST_CATEGORY__CREATOR` FOREIGN KEY (`create_account_id`) REFERENCES `tbl_account` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `POST_CATEGORY__POST` FOREIGN KEY (`post_id`) REFERENCES `tbl_post` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8 COMMENT='n - n table, post + category';

/*Data for the table `tbl_post_category` */

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
  `content` text COMMENT 'Product''s content',
  `price` double NOT NULL DEFAULT '0' COMMENT 'Product''s price',
  `price_dropped` double NOT NULL DEFAULT '0' COMMENT 'Product''s price dropped',
  `viewed` int(11) NOT NULL DEFAULT '0' COMMENT 'Product''s viewed count',
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Product';

/*Data for the table `tbl_product` */

/*Table structure for table `tbl_product_category` */

DROP TABLE IF EXISTS `tbl_product_category`;

CREATE TABLE `tbl_product_category` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `product_id` bigint(20) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `create_account_id` int(11) DEFAULT NULL COMMENT 'Creator id',
  `created_time` datetime DEFAULT NULL COMMENT 'Created time',
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQUE_IDX1` (`product_id`,`category_id`),
  KEY `PRODUCT_CATEGORY__CATEGORY` (`category_id`),
  KEY `PRODUCT_CATEGORY__CREATOR` (`create_account_id`),
  CONSTRAINT `PRODUCT_CATEGORY__PRODUCT` FOREIGN KEY (`product_id`) REFERENCES `tbl_product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `PRODUCT_CATEGORY__CATEGORY` FOREIGN KEY (`category_id`) REFERENCES `tbl_category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='n - n table, product + category';

/*Data for the table `tbl_product_category` */

/*Table structure for table `tbl_tag` */

DROP TABLE IF EXISTS `tbl_tag`;

CREATE TABLE `tbl_tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Primary key',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT 'Tag''s name',
  `alias` varchar(255) NOT NULL DEFAULT '' COMMENT 'Tag''s alias',
  `created_time` datetime DEFAULT NULL COMMENT 'Created time',
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQUE_IDX_name` (`name`),
  KEY `IDX_alias` (`alias`),
  KEY `IDX_created_time` (`created_time`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COMMENT='tag, tagging';

/*Data for the table `tbl_tag` */

insert  into `tbl_tag`(`id`,`name`,`alias`,`created_time`) values (3,'tag 1','tag-1','2016-08-16 13:22:04'),(4,'tag 2','tag-2','2016-08-16 13:22:04'),(5,'tag 3','tag-3','2016-08-16 13:22:05'),(6,'tag 4','tag-4','2016-08-16 13:22:52'),(7,'bai viet 1','bai-viet-1','2016-08-17 15:20:19'),(8,'bai viet so 1','bai-viet-so-1','2016-08-17 15:20:19'),(9,'post title','post-title','2016-08-17 15:26:40'),(10,'post title 1','post-title-1','2016-08-17 15:26:40'),(11,'記事のタイトル','記事のタイトル','2016-08-17 15:29:43'),(12,'記事のタイトル1','記事のタイトル1','2016-08-17 15:29:44');

/*Table structure for table `tbl_tag_item` */

DROP TABLE IF EXISTS `tbl_tag_item`;

CREATE TABLE `tbl_tag_item` (
  `tag_id` int(11) NOT NULL COMMENT 'Tag''s id',
  `item_id` varchar(32) NOT NULL DEFAULT '' COMMENT 'Item''s id',
  `context` varchar(128) NOT NULL DEFAULT '' COMMENT 'Context string',
  PRIMARY KEY (`tag_id`,`item_id`,`context`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='tag, tagging (items)';

/*Data for the table `tbl_tag_item` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
