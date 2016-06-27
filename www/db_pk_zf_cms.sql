/*
SQLyog Ultimate v12.09 (64 bit)
MySQL - 10.1.13-MariaDB : Database - db_pk_zf_cms
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
  `username` varchar(255) NOT NULL DEFAULT '' COMMENT 'Account''s username',
  `password` varchar(55) NOT NULL DEFAULT '' COMMENT 'Account''s password',
  `avatar` varchar(255) NOT NULL DEFAULT '' COMMENT 'Account''s avatar',
  `fullname` varchar(255) NOT NULL DEFAULT '' COMMENT 'Account''s fullname',
  `last_login_time` datetime DEFAULT NULL COMMENT 'Account''s last login time',
  `active` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Flag: is active?',
  `draft` datetime DEFAULT NULL COMMENT 'Datetime: mark as data draft?',
  `create_account_id` int(11) DEFAULT NULL COMMENT 'Creator id',
  `created_time` datetime DEFAULT NULL COMMENT 'Created time',
  `last_modified_account_id` int(11) DEFAULT NULL COMMENT 'Last modifier id',
  `last_modified_time` datetime DEFAULT NULL COMMENT 'Last modified time',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='Tbl, manage accounts!';

/*Data for the table `tbl_account` */

insert  into `tbl_account`(`id`,`group_id_json`,`username`,`password`,`avatar`,`fullname`,`last_login_time`,`active`,`draft`,`create_account_id`,`created_time`,`last_modified_account_id`,`last_modified_time`) values (1,'','admin','e10adc3949ba59abbe56e057f20f883e','','Administrator',NULL,1,NULL,NULL,NULL,NULL,NULL);

/*Table structure for table `tbl_group` */

DROP TABLE IF EXISTS `tbl_group`;

CREATE TABLE `tbl_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Primary key',
  `code` varchar(55) NOT NULL DEFAULT '' COMMENT 'Group''s code',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT 'Group''s name',
  `note` varchar(255) NOT NULL DEFAULT '' COMMENT 'Group''s note',
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
  CONSTRAINT `GROUP__CREATE_ACCOUNT` FOREIGN KEY (`create_account_id`) REFERENCES `tbl_account` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `GROUP__LAST_MODIFIED_ACCOUNT` FOREIGN KEY (`last_modified_account_id`) REFERENCES `tbl_account` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='Tbl, manage account''s groups!';

/*Data for the table `tbl_group` */

insert  into `tbl_group`(`id`,`code`,`name`,`note`,`acl`,`active`,`draft`,`create_account_id`,`created_time`,`last_modified_account_id`,`last_modified_time`) values (1,'ADMIN','Administrator','Built-in group',NULL,1,NULL,1,'2016-06-27 10:19:24',NULL,'0000-00-00 00:00:00');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
