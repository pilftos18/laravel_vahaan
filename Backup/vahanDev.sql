/*
SQLyog Community v13.1.7 (64 bit)
MySQL - 5.7.42-log : Database - vahan_dev
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`vahan_dev` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `vahan_dev`;

/*Table structure for table `adhoc_setting` */

DROP TABLE IF EXISTS `adhoc_setting`;

CREATE TABLE `adhoc_setting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) DEFAULT NULL,
  `field` varchar(100) DEFAULT NULL,
  `values` varchar(250) DEFAULT NULL,
  `is_visible` tinyint(1) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1' COMMENT '1=> Active, 2 => Inactive',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `api_detail_log` */

DROP TABLE IF EXISTS `api_detail_log`;

CREATE TABLE `api_detail_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `input` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `primary_vendor` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `primary_response` text COLLATE utf8mb4_unicode_ci,
  `primary_status` varchar(20) CHARACTER SET latin1 DEFAULT '101',
  `secondary_vendor` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `secondary_response` text COLLATE utf8mb4_unicode_ci,
  `secondary_status` varchar(20) CHARACTER SET latin1 DEFAULT '101',
  `status` tinyint(1) DEFAULT '1' COMMENT '1 => Active, 2=> Inactive',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5694 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `api_detail_log_archive` */

DROP TABLE IF EXISTS `api_detail_log_archive`;

CREATE TABLE `api_detail_log_archive` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `input` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `primary_vendor` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `primary_response` text COLLATE utf8mb4_unicode_ci,
  `primary_status` varchar(20) CHARACTER SET latin1 DEFAULT '101',
  `secondary_vendor` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `secondary_response` text COLLATE utf8mb4_unicode_ci,
  `secondary_status` varchar(20) CHARACTER SET latin1 DEFAULT '101',
  `status` tinyint(1) DEFAULT '1' COMMENT '1 => Active, 2=> Inactive',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `api_list` */

DROP TABLE IF EXISTS `api_list`;

CREATE TABLE `api_list` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL,
  `apiname` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `view_filename` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `api_alias` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vendorname` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sec_vendor` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `apiurl` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `apitesturl` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `status` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `del_status` int(11) NOT NULL DEFAULT '1',
  `created_by` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `api_log` */

DROP TABLE IF EXISTS `api_log`;

CREATE TABLE `api_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `api_id` int(11) DEFAULT NULL,
  `api_name` varchar(250) CHARACTER SET latin1 DEFAULT NULL,
  `vender` varchar(250) CHARACTER SET latin1 DEFAULT NULL,
  `client_id` int(11) DEFAULT NULL,
  `client_name` varchar(250) CHARACTER SET latin1 DEFAULT NULL,
  `api_url` varchar(250) CHARACTER SET latin1 DEFAULT NULL,
  `method` varchar(250) CHARACTER SET latin1 DEFAULT NULL,
  `input` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `request` varchar(250) CHARACTER SET latin1 DEFAULT NULL,
  `response` text COLLATE utf8mb4_unicode_ci,
  `response_status_code` varchar(20) CHARACTER SET latin1 DEFAULT NULL,
  `response_message` varchar(250) CHARACTER SET latin1 DEFAULT NULL,
  `request_type` tinyint(1) DEFAULT '1' COMMENT '0,1 => Single API, 2=> Bulk',
  `bulk_id` int(11) DEFAULT '0',
  `bulk_dump_id` int(11) DEFAULT '0' COMMENT 'This is cron_bulk_dump id',
  `response_from` tinyint(1) DEFAULT '1' COMMENT '0,1 => Vendor''s API, 2=> History',
  `response_type` tinyint(1) DEFAULT '1' COMMENT '0,1 => Primary, 2 => Secondary',
  `api_detail_log_id` int(11) DEFAULT NULL,
  `remark` varchar(250) CHARACTER SET latin1 DEFAULT NULL,
  `status` tinyint(2) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `api_name` (`api_name`),
  KEY `vender` (`vender`),
  KEY `client_id` (`client_id`),
  KEY `created_at` (`created_at`),
  KEY `response_status_code` (`response_status_code`),
  KEY `STATUS` (`status`),
  KEY `client_name` (`client_name`)
) ENGINE=InnoDB AUTO_INCREMENT=96514 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `api_log_archive` */

DROP TABLE IF EXISTS `api_log_archive`;

CREATE TABLE `api_log_archive` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `api_id` int(11) DEFAULT NULL,
  `api_name` varchar(250) CHARACTER SET latin1 DEFAULT NULL,
  `vender` varchar(250) CHARACTER SET latin1 DEFAULT NULL,
  `client_id` int(11) DEFAULT NULL,
  `client_name` varchar(250) CHARACTER SET latin1 DEFAULT NULL,
  `api_url` varchar(250) CHARACTER SET latin1 DEFAULT NULL,
  `method` varchar(250) CHARACTER SET latin1 DEFAULT NULL,
  `input` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `request` varchar(250) CHARACTER SET latin1 DEFAULT NULL,
  `response` text COLLATE utf8mb4_unicode_ci,
  `response_status_code` varchar(20) CHARACTER SET latin1 DEFAULT NULL,
  `response_message` varchar(250) CHARACTER SET latin1 DEFAULT NULL,
  `request_type` tinyint(1) DEFAULT '1' COMMENT '0,1 => Single API, 2=> Bulk',
  `bulk_id` int(11) DEFAULT '0',
  `bulk_dump_id` int(11) DEFAULT '0' COMMENT 'This is cron_bulk_dump id',
  `response_from` tinyint(1) DEFAULT '1' COMMENT '0,1 => Vendor''s API, 2=> History',
  `response_type` tinyint(1) DEFAULT '1' COMMENT '0,1 => Primary, 2 => Secondary',
  `api_detail_log_id` int(11) DEFAULT NULL,
  `remark` varchar(250) CHARACTER SET latin1 DEFAULT NULL,
  `status` tinyint(2) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `api_name` (`api_name`),
  KEY `vender` (`vender`),
  KEY `client_id` (`client_id`),
  KEY `created_at` (`created_at`),
  KEY `response_status_code` (`response_status_code`),
  KEY `STATUS` (`status`),
  KEY `client_name` (`client_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `api_master` */

DROP TABLE IF EXISTS `api_master`;

CREATE TABLE `api_master` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vender` varchar(100) DEFAULT NULL,
  `api_name` varchar(100) DEFAULT NULL,
  `view_filename` varchar(50) DEFAULT NULL,
  `api_alias` varchar(100) DEFAULT NULL,
  `api_url` varchar(150) DEFAULT NULL,
  `api_endpint` varchar(100) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1' COMMENT '0,1 => Active, 2 => Inactive',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=latin1;

/*Table structure for table `bulkfile_log` */

DROP TABLE IF EXISTS `bulkfile_log`;

CREATE TABLE `bulkfile_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `client_id` int(11) DEFAULT NULL,
  `api_id` int(11) DEFAULT NULL,
  `vendor` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `filename` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `count` int(11) DEFAULT NULL,
  `processed_count` int(11) DEFAULT NULL,
  `duration` varchar(20) CHARACTER SET latin1 DEFAULT NULL,
  `upload_url` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `downloadurl` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `Remark` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `is_processed` tinyint(1) DEFAULT '1' COMMENT '1=> Not Process, Processed',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `request_type` enum('rc','rc_logic','challan','chassis') CHARACTER SET latin1 DEFAULT NULL,
  `retry_attempts` int(11) DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '1' COMMENT '1=> Active, 2=>Inactive',
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `api_name` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `client_id` (`client_id`),
  KEY `api_id` (`api_id`),
  KEY `vendor` (`vendor`),
  KEY `is_processed` (`is_processed`),
  KEY `created_at` (`created_at`)
) ENGINE=InnoDB AUTO_INCREMENT=1975 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `clients` */

DROP TABLE IF EXISTS `clients`;

CREATE TABLE `clients` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `website` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `status` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `del_status` int(11) NOT NULL DEFAULT '1',
  `created_by` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `max_count` int(11) DEFAULT NULL,
  `used_credit` int(11) DEFAULT NULL,
  `envtype` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expirydate` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `credits_log` */

DROP TABLE IF EXISTS `credits_log`;

CREATE TABLE `credits_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` varchar(255) DEFAULT NULL,
  `credits` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `status` varchar(45) DEFAULT '1',
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Table structure for table `cron_bulk_dump` */

DROP TABLE IF EXISTS `cron_bulk_dump`;

CREATE TABLE `cron_bulk_dump` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `bulk_id` int(11) DEFAULT NULL,
  `input` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `status` int(1) DEFAULT '1' COMMENT '0,1=> not processed, 2=> in progress, 3=> completed',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `bulk_id` (`bulk_id`),
  KEY `status` (`status`),
  KEY `created_at` (`created_at`)
) ENGINE=InnoDB AUTO_INCREMENT=1264587 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `cron_bulk_dump_archive` */

DROP TABLE IF EXISTS `cron_bulk_dump_archive`;

CREATE TABLE `cron_bulk_dump_archive` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bulk_id` int(11) DEFAULT NULL,
  `input` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `status` int(1) DEFAULT '1' COMMENT '0,1=> not processed, 2=> in progress, 3=> completed',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `bulk_id` (`bulk_id`),
  KEY `status` (`status`),
  KEY `created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `external_source_data` */

DROP TABLE IF EXISTS `external_source_data`;

CREATE TABLE `external_source_data` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `client_name` varchar(100) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `api_name` varchar(100) NOT NULL,
  `vendor_name` varchar(100) DEFAULT NULL,
  `input` varchar(55) NOT NULL,
  `response` text,
  `status_code` varchar(45) NOT NULL,
  `request_type` tinyint(1) DEFAULT '1' COMMENT '0,1=> individual, 2 => bulk',
  `remark` varchar(100) DEFAULT NULL,
  `is_history` tinyint(1) DEFAULT NULL COMMENT '1=> history, 2 => api',
  `is_score` tinyint(1) DEFAULT NULL COMMENT '0=> blank, 1 => score',
  `source_ip` varchar(50) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `transaction_id` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `external_source_data_archive` */

DROP TABLE IF EXISTS `external_source_data_archive`;

CREATE TABLE `external_source_data_archive` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_name` varchar(100) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `api_name` varchar(100) NOT NULL,
  `vendor_name` varchar(100) DEFAULT NULL,
  `input` varchar(55) NOT NULL,
  `response` text,
  `status_code` varchar(45) NOT NULL,
  `request_type` tinyint(1) DEFAULT '1' COMMENT '0,1=> individual, 2 => bulk',
  `remark` varchar(100) DEFAULT NULL,
  `is_history` tinyint(1) DEFAULT '1' COMMENT '0,1=> API Hit, 2 => History',
  `is_score` tinyint(1) DEFAULT '0' COMMENT '0=> blank, 1 => score',
  `source_ip` varchar(50) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `transaction_id` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `external_source_data_tata_autoclaims` */

DROP TABLE IF EXISTS `external_source_data_tata_autoclaims`;

CREATE TABLE `external_source_data_tata_autoclaims` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `client_name` varchar(100) NOT NULL,
  `request` varchar(100) NOT NULL,
  `status_code` varchar(45) NOT NULL,
  `module` varchar(45) NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `failed_jobs` */

DROP TABLE IF EXISTS `failed_jobs`;

CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `history_aadhar` */

DROP TABLE IF EXISTS `history_aadhar`;

CREATE TABLE `history_aadhar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `aadhar_no` varchar(45) DEFAULT NULL,
  `vendor` varchar(100) DEFAULT NULL,
  `request` text,
  `response` text,
  `status_code` varchar(45) DEFAULT NULL,
  `status` varchar(6) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Table structure for table `history_challan` */

DROP TABLE IF EXISTS `history_challan`;

CREATE TABLE `history_challan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vehicle_no` varchar(100) DEFAULT NULL,
  `vendor` varchar(100) DEFAULT NULL,
  `request` text,
  `response` text,
  `status_code` varchar(20) DEFAULT '200',
  `status` tinyint(1) DEFAULT '1' COMMENT '1=> Active, 2=> Inactive',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `history_challan_chassis` */

DROP TABLE IF EXISTS `history_challan_chassis`;

CREATE TABLE `history_challan_chassis` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vehicle_no` varchar(100) DEFAULT NULL,
  `chassis_no` int(5) DEFAULT NULL COMMENT 'last 5 digit only',
  `vendor` varchar(100) DEFAULT NULL,
  `request` text,
  `response` text,
  `status_code` varchar(20) DEFAULT '200',
  `status` tinyint(1) DEFAULT '1' COMMENT '1=> Active, 2=> Inactive',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `history_license` */

DROP TABLE IF EXISTS `history_license`;

CREATE TABLE `history_license` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `license_no` varchar(255) DEFAULT NULL,
  `vendor` varchar(255) DEFAULT NULL,
  `request` text,
  `response` longtext,
  `status_code` varchar(20) DEFAULT '200',
  `status` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `dob` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;

/*Table structure for table `history_pan` */

DROP TABLE IF EXISTS `history_pan`;

CREATE TABLE `history_pan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pan_no` varchar(45) DEFAULT NULL,
  `vendor` varchar(100) DEFAULT NULL,
  `request` text,
  `response` text,
  `status_code` varchar(45) DEFAULT NULL,
  `status` varchar(6) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

/*Table structure for table `history_panocr` */

DROP TABLE IF EXISTS `history_panocr`;

CREATE TABLE `history_panocr` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `filename` varchar(45) DEFAULT NULL,
  `vendor` varchar(100) DEFAULT NULL,
  `request` text,
  `response` text,
  `status_code` varchar(45) DEFAULT NULL,
  `status` varchar(6) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

/*Table structure for table `history_rc` */

DROP TABLE IF EXISTS `history_rc`;

CREATE TABLE `history_rc` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vehicle_no` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `vendor` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `request` text CHARACTER SET latin1,
  `response` text COLLATE utf8mb4_unicode_ci,
  `status_code` varchar(20) CHARACTER SET latin1 DEFAULT '200',
  `status` tinyint(1) DEFAULT '1' COMMENT '1=> Active, 2=> Inactive',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `vehicle_no` (`vehicle_no`),
  KEY `vendor` (`vendor`),
  KEY `status` (`status`),
  KEY `created_at` (`created_at`)
) ENGINE=InnoDB AUTO_INCREMENT=4139 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `history_rc_archive` */

DROP TABLE IF EXISTS `history_rc_archive`;

CREATE TABLE `history_rc_archive` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vehicle_no` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `vendor` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `request` text CHARACTER SET latin1,
  `response` text COLLATE utf8mb4_unicode_ci,
  `status_code` varchar(20) CHARACTER SET latin1 DEFAULT '200',
  `status` tinyint(1) DEFAULT '1' COMMENT '1=> Active, 2=> Inactive',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `vehicle_no` (`vehicle_no`),
  KEY `vendor` (`vendor`),
  KEY `status` (`status`),
  KEY `created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `history_rc_chassis` */

DROP TABLE IF EXISTS `history_rc_chassis`;

CREATE TABLE `history_rc_chassis` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `chassis_no` varchar(100) DEFAULT NULL,
  `vendor` varchar(100) DEFAULT NULL,
  `request` text,
  `response` text,
  `status_code` varchar(20) DEFAULT '200',
  `status` tinyint(1) DEFAULT '1' COMMENT '1=> Active, 2=> Inactive',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Table structure for table `jobs` */

DROP TABLE IF EXISTS `jobs`;

CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `migrations` */

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `module_master` */

DROP TABLE IF EXISTS `module_master`;

CREATE TABLE `module_master` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `alias` varchar(50) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1' COMMENT '1=>active, 2 => Inactive',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `notification` */

DROP TABLE IF EXISTS `notification`;

CREATE TABLE `notification` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `client_id` int(11) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `body` varchar(255) DEFAULT NULL,
  `read_status` tinyint(1) DEFAULT '1' COMMENT '1 => Unread, 2 => Read',
  `status` tinyint(1) DEFAULT '1' COMMENT '1 => Active, 2 => Inactive',
  `created_by` int(11) DEFAULT '0' COMMENT '0 => System Entry',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1938 DEFAULT CHARSET=latin1;

/*Table structure for table `ocrdetails` */

DROP TABLE IF EXISTS `ocrdetails`;

CREATE TABLE `ocrdetails` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file1` text,
  `file2` text,
  `api_logid` int(11) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `status` tinyint(2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

/*Table structure for table `otp_log` */

DROP TABLE IF EXISTS `otp_log`;

CREATE TABLE `otp_log` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `otp` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `sent_status` tinyint(2) NOT NULL,
  `status` tinyint(2) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `password_resets` */

DROP TABLE IF EXISTS `password_resets`;

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `personal_access_tokens` */

DROP TABLE IF EXISTS `personal_access_tokens`;

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `role` */

DROP TABLE IF EXISTS `role`;

CREATE TABLE `role` (
  `id` int(11) NOT NULL,
  `role` varchar(250) NOT NULL,
  `status` varchar(250) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `session_log` */

DROP TABLE IF EXISTS `session_log`;

CREATE TABLE `session_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `session_id` varchar(100) NOT NULL,
  `ip_address` varchar(50) NOT NULL,
  `login_status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '1=login, 2=logout',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '1=active, 2=inactive',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=359 DEFAULT CHARSET=latin1;

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role` enum('user','super_admin','admin','mis') DEFAULT NULL,
  `client_id` int(11) DEFAULT NULL,
  `name` varchar(250) DEFAULT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(250) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `mobile` varchar(15) DEFAULT NULL,
  `gender` enum('male','female') DEFAULT 'male',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '1=''Active'', 2=''Inactive'', 3=''Deleted''',
  `series_id` varchar(250) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(250) DEFAULT NULL,
  `session_id` varchar(250) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=112 DEFAULT CHARSET=latin1;

/*Table structure for table `users_1` */

DROP TABLE IF EXISTS `users_1`;

CREATE TABLE `users_1` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `vendor_master` */

DROP TABLE IF EXISTS `vendor_master`;

CREATE TABLE `vendor_master` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `alias` varchar(50) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1' COMMENT '1 => Active, 2=> Inactive',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
