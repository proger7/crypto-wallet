-- MySQL dump 10.13  Distrib 5.7.23, for Linux (x86_64)
--
-- Host: localhost    Database: anspot
-- ------------------------------------------------------
-- Server version	5.7.23-0ubuntu0.16.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `btc_blockio_licenses`
--

DROP TABLE IF EXISTS `btc_blockio_licenses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `btc_blockio_licenses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account` varchar(255) DEFAULT NULL,
  `license` varchar(255) DEFAULT NULL,
  `secret_pin` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `addresses` int(11) DEFAULT NULL,
  `default_license` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `btc_blockio_licenses`
--

LOCK TABLES `btc_blockio_licenses` WRITE;
/*!40000 ALTER TABLE `btc_blockio_licenses` DISABLE KEYS */;
/*!40000 ALTER TABLE `btc_blockio_licenses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `btc_faq`
--

DROP TABLE IF EXISTS `btc_faq`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `btc_faq` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question` varchar(255) DEFAULT NULL,
  `answer` text,
  `created` int(11) DEFAULT NULL,
  `updated` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `btc_faq`
--

LOCK TABLES `btc_faq` WRITE;
/*!40000 ALTER TABLE `btc_faq` DISABLE KEYS */;
/*!40000 ALTER TABLE `btc_faq` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `btc_gateways`
--

DROP TABLE IF EXISTS `btc_gateways`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `btc_gateways` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `currency` varchar(255) DEFAULT NULL,
  `allow_send` int(11) DEFAULT NULL,
  `allow_receive` int(11) DEFAULT NULL,
  `a_field_1` varchar(255) DEFAULT NULL,
  `a_field_2` varchar(255) DEFAULT NULL,
  `a_field_3` varchar(255) DEFAULT NULL,
  `a_field_4` varchar(255) DEFAULT NULL,
  `a_field_5` varchar(255) DEFAULT NULL,
  `a_field_6` varchar(255) DEFAULT NULL,
  `a_field_7` varchar(255) DEFAULT NULL,
  `a_field_8` varchar(255) DEFAULT NULL,
  `a_field_9` varchar(255) DEFAULT NULL,
  `a_field_10` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `btc_gateways`
--

LOCK TABLES `btc_gateways` WRITE;
/*!40000 ALTER TABLE `btc_gateways` DISABLE KEYS */;
INSERT INTO `btc_gateways` VALUES (1,'Credit Card','USD',1,1,'creditcard','','','','',NULL,NULL,NULL,NULL,NULL,1),(2,'Wire Transfer','USD',1,1,'mybankname','bankcity','holdername','ibanbanknumber','12344',NULL,NULL,NULL,NULL,NULL,1);
/*!40000 ALTER TABLE `btc_gateways` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `btc_orders`
--

DROP TABLE IF EXISTS `btc_orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `btc_orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `order_type` enum('market','limit','stop') NOT NULL DEFAULT 'market',
  `transaction_type` enum('sell_btc','buy_btc') DEFAULT NULL,
  `status` tinyint(2) NOT NULL DEFAULT '0',
  `amount` decimal(20,8) DEFAULT NULL,
  `target_price` decimal(20,8) DEFAULT NULL,
  `time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `btc_orders`
--

LOCK TABLES `btc_orders` WRITE;
/*!40000 ALTER TABLE `btc_orders` DISABLE KEYS */;
INSERT INTO `btc_orders` VALUES (1,5,'limit','buy_btc',0,100.00000000,5000.00000000,1517797030),(4,5,'limit','sell_btc',0,0.01500000,4000.00000000,1517800134),(3,5,'stop','buy_btc',0,50.00000000,8000.00000000,1517797146),(5,5,'stop','sell_btc',0,0.01500000,3000.00000000,1517800183);
/*!40000 ALTER TABLE `btc_orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `btc_pages`
--

DROP TABLE IF EXISTS `btc_pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `btc_pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `prefix` varchar(255) DEFAULT NULL,
  `content` text,
  `created` int(11) DEFAULT NULL,
  `updated` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `btc_pages`
--

LOCK TABLES `btc_pages` WRITE;
/*!40000 ALTER TABLE `btc_pages` DISABLE KEYS */;
INSERT INTO `btc_pages` VALUES (1,'Terms of service','terms-of-services','Edit from WebAdmin.',NULL,NULL),(2,'Privacy Policy','privacy-policy','Edit from WebAdmin.',NULL,NULL);
/*!40000 ALTER TABLE `btc_pages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `btc_prices`
--

DROP TABLE IF EXISTS `btc_prices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `btc_prices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `source` varchar(255) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `currency` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `btc_prices`
--

LOCK TABLES `btc_prices` WRITE;
/*!40000 ALTER TABLE `btc_prices` DISABLE KEYS */;
/*!40000 ALTER TABLE `btc_prices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `btc_requests`
--

DROP TABLE IF EXISTS `btc_requests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `btc_requests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `type` int(11) DEFAULT NULL,
  `btc_amount` varchar(255) DEFAULT NULL,
  `amount` varchar(255) DEFAULT NULL,
  `gateway_id` int(11) DEFAULT NULL,
  `from_address` int(11) DEFAULT NULL,
  `bitcoins_released` int(11) NOT NULL DEFAULT '0',
  `status` int(11) DEFAULT NULL,
  `time` int(11) DEFAULT NULL,
  `u_field_1` varchar(255) DEFAULT NULL,
  `u_field_2` varchar(255) DEFAULT NULL,
  `u_field_3` varchar(255) DEFAULT NULL,
  `u_field_4` varchar(255) DEFAULT NULL,
  `u_field_5` varchar(255) DEFAULT NULL,
  `u_field_6` varchar(255) DEFAULT NULL,
  `u_field_7` varchar(255) DEFAULT NULL,
  `u_field_8` varchar(255) DEFAULT NULL,
  `u_field_9` varchar(255) DEFAULT NULL,
  `u_field_10` varchar(255) DEFAULT NULL,
  `attachment` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `btc_requests`
--

LOCK TABLES `btc_requests` WRITE;
/*!40000 ALTER TABLE `btc_requests` DISABLE KEYS */;
INSERT INTO `btc_requests` VALUES (1,5,1,'0.001453','12',1,1,1,2,1517606577,'','','','','',NULL,NULL,NULL,NULL,NULL,'uploads/attachments/5_1517606577_attachment.jpg'),(2,5,1,'0.000674','21',2,1,1,2,1517612318,'','','','','',NULL,NULL,NULL,NULL,NULL,'uploads/attachments/5_1517612318_attachment.jpg'),(3,5,1,'0.001221','10',1,1,1,1,1517767154,'','','','','',NULL,NULL,NULL,NULL,NULL,'uploads/attachments/5_1517767154_attachment.jpg'),(4,5,1,'0.013861','111',1,1,1,1,1517786693,'','','','','',NULL,NULL,NULL,NULL,NULL,'uploads/attachments/5_1517786693_attachment.jpg'),(5,5,1,'0.013861','111',1,1,1,1,1517786762,'','','','','',NULL,NULL,NULL,NULL,NULL,'uploads/attachments/5_1517786762_attachment.jpg');
/*!40000 ALTER TABLE `btc_requests` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `btc_settings`
--

DROP TABLE IF EXISTS `btc_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `btc_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `keywords` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `infoemail` varchar(255) DEFAULT NULL,
  `supportemail` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `withdrawal_comission` varchar(255) DEFAULT NULL,
  `max_addresses_per_account` int(11) DEFAULT NULL,
  `profits` varchar(255) DEFAULT NULL,
  `document_verification` int(11) DEFAULT NULL,
  `email_verification` int(11) DEFAULT NULL,
  `phone_verification` int(11) DEFAULT NULL,
  `recaptcha_verification` int(11) DEFAULT NULL,
  `recaptcha_publickey` varchar(255) DEFAULT NULL,
  `recaptcha_privatekey` varchar(255) DEFAULT NULL,
  `nexmo_api_key` varchar(255) DEFAULT NULL,
  `nexmo_api_secret` varchar(255) DEFAULT NULL,
  `autoupdate_bitcoin_price` int(11) DEFAULT NULL,
  `bitcoin_sell_fee` int(11) DEFAULT NULL,
  `bitcoin_buy_fee` int(11) DEFAULT NULL,
  `bitcoin_fixed_price` varchar(255) DEFAULT NULL,
  `plugin_buy_bitcoins` int(11) DEFAULT NULL,
  `plugin_sell_bitcoins` int(11) DEFAULT NULL,
  `plugin_transfer_bitcoins` int(11) DEFAULT NULL,
  `plugin_request_bitcoins` int(11) DEFAULT NULL,
  `process_time_to_buy` int(11) DEFAULT NULL,
  `process_time_to_sell` int(11) DEFAULT NULL,
  `default_language` varchar(255) DEFAULT NULL,
  `default_currency` varchar(255) DEFAULT NULL,
  `fb_link` text,
  `tw_link` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `btc_settings`
--

LOCK TABLES `btc_settings` WRITE;
/*!40000 ALTER TABLE `btc_settings` DISABLE KEYS */;
INSERT INTO `btc_settings` VALUES (1,'Anspot','Anspot desc','Anspot kw','Anspot','info@anspot.com','support@anspot.com','http://www.anspot.com/','0.001',10,NULL,0,0,0,NULL,NULL,NULL,'','',1,5,3,'',1,1,1,1,1,1,'English','USD','','');
/*!40000 ALTER TABLE `btc_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `btc_sms_codes`
--

DROP TABLE IF EXISTS `btc_sms_codes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `btc_sms_codes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `sms_code` varchar(255) DEFAULT NULL,
  `verified` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `btc_sms_codes`
--

LOCK TABLES `btc_sms_codes` WRITE;
/*!40000 ALTER TABLE `btc_sms_codes` DISABLE KEYS */;
/*!40000 ALTER TABLE `btc_sms_codes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `btc_transfers`
--

DROP TABLE IF EXISTS `btc_transfers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `btc_transfers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `status` tinyint(2) DEFAULT '0',
  `recipient_address` varchar(255) DEFAULT NULL,
  `btc_amount` decimal(14,8) DEFAULT NULL,
  `time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `btc_transfers`
--

LOCK TABLES `btc_transfers` WRITE;
/*!40000 ALTER TABLE `btc_transfers` DISABLE KEYS */;
INSERT INTO `btc_transfers` VALUES (1,5,0,'rgwbrwthtrh',0.01000000,1517804611),(2,5,0,'ergtrgtrgtrg',0.01000000,1517805673),(3,5,0,'ergtrgtrgtrg',0.01000000,1517805698),(4,5,2,'ergtrgtrgtrg',0.01000000,1517805753);
/*!40000 ALTER TABLE `btc_transfers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `btc_users`
--

DROP TABLE IF EXISTS `btc_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `btc_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `secret_pin` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `email_verified` int(11) DEFAULT NULL,
  `email_hash` text,
  `status` varchar(255) DEFAULT NULL,
  `btc_balance` decimal(14,8) unsigned NOT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `time_signup` int(11) DEFAULT NULL,
  `time_signin` int(11) DEFAULT NULL,
  `time_activity` int(11) DEFAULT NULL,
  `document_verified` int(11) DEFAULT NULL,
  `document_1` text,
  `document_2` text,
  `mobile_verified` int(11) DEFAULT NULL,
  `mobile_number` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `btc_users`
--

LOCK TABLES `btc_users` WRITE;
/*!40000 ALTER TABLE `btc_users` DISABLE KEYS */;
INSERT INTO `btc_users` VALUES (1,'anspotadmin','b102cd6467688cda31b12090e6352811',NULL,'lukadukic@gmail.com',NULL,NULL,'666',0.00000000,NULL,NULL,1533324587,1517409310,NULL,NULL,NULL,NULL,NULL),(2,'mulighet@gmail.com','7799904719af9e711348bd5a7360543e',NULL,'mulighet@gmail.com',0,'1dba9e9241','3',0.00000000,NULL,1517335775,1537298961,1522948882,NULL,NULL,NULL,NULL,NULL),(3,'l.ukadukic@gmail.com','a3bb80420aab08b8519fec466da146eb',NULL,'l.ukadukic@gmail.com',0,'100b0cfa6c','3',0.00000000,NULL,1517340567,1517491059,1517492002,NULL,NULL,NULL,NULL,NULL),(4,'mm@mm.com','5d793fc5b00a2348c3fb9ab59e5ca98a',NULL,'mm@mm.com',0,'acc580db66','1',0.00000000,NULL,1517573174,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(5,'aa@aa.com','5d793fc5b00a2348c3fb9ab59e5ca98a',NULL,'aa@aa.com',0,'d7b07bc8b4','3',0.01511700,NULL,1517573279,1517860613,1517866512,NULL,NULL,NULL,NULL,'123');
/*!40000 ALTER TABLE `btc_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `btc_users_addresses`
--

DROP TABLE IF EXISTS `btc_users_addresses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `btc_users_addresses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `label` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `lid` int(11) DEFAULT NULL,
  `available_balance` varchar(255) DEFAULT NULL,
  `pending_received_balance` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `created` int(11) DEFAULT NULL,
  `updated` int(11) DEFAULT NULL,
  `archived` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `btc_users_addresses`
--

LOCK TABLES `btc_users_addresses` WRITE;
/*!40000 ALTER TABLE `btc_users_addresses` DISABLE KEYS */;
/*!40000 ALTER TABLE `btc_users_addresses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `btc_users_bank_account`
--

DROP TABLE IF EXISTS `btc_users_bank_account`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `btc_users_bank_account` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `time` int(11) DEFAULT NULL,
  `u_field_1` varchar(255) DEFAULT NULL,
  `u_field_2` varchar(255) DEFAULT NULL,
  `u_field_3` varchar(255) DEFAULT NULL,
  `u_field_4` varchar(255) DEFAULT NULL,
  `u_field_5` varchar(255) DEFAULT NULL,
  `u_field_6` varchar(255) DEFAULT NULL,
  `u_field_7` varchar(255) DEFAULT NULL,
  `u_field_8` varchar(255) DEFAULT NULL,
  `u_field_9` varchar(255) DEFAULT NULL,
  `u_field_10` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `btc_users_bank_account`
--

LOCK TABLES `btc_users_bank_account` WRITE;
/*!40000 ALTER TABLE `btc_users_bank_account` DISABLE KEYS */;
INSERT INTO `btc_users_bank_account` VALUES (1,5,1517850891,'aaaa','bff','cggg','dtyjtuyjutj',NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `btc_users_bank_account` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `btc_users_credit_cards`
--

DROP TABLE IF EXISTS `btc_users_credit_cards`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `btc_users_credit_cards` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `card_number` varchar(255) DEFAULT NULL,
  `card_expire_date` varchar(255) DEFAULT NULL,
  `card_cvv` varchar(11) DEFAULT NULL,
  `card_name` varchar(255) DEFAULT NULL,
  `added` int(11) DEFAULT NULL,
  `verified` int(11) DEFAULT NULL,
  `frontend_image` text,
  `backend_image` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `btc_users_credit_cards`
--

LOCK TABLES `btc_users_credit_cards` WRITE;
/*!40000 ALTER TABLE `btc_users_credit_cards` DISABLE KEYS */;
/*!40000 ALTER TABLE `btc_users_credit_cards` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `btc_users_data`
--

DROP TABLE IF EXISTS `btc_users_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `btc_users_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `time` int(11) DEFAULT NULL,
  `gateway` int(11) DEFAULT NULL,
  `u_field_1` varchar(255) DEFAULT NULL,
  `u_field_2` varchar(255) DEFAULT NULL,
  `u_field_3` varchar(255) DEFAULT NULL,
  `u_field_4` varchar(255) DEFAULT NULL,
  `u_field_5` varchar(255) DEFAULT NULL,
  `u_field_6` varchar(255) DEFAULT NULL,
  `u_field_7` varchar(255) DEFAULT NULL,
  `u_field_8` varchar(255) DEFAULT NULL,
  `u_field_9` varchar(255) DEFAULT NULL,
  `u_field_10` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `btc_users_data`
--

LOCK TABLES `btc_users_data` WRITE;
/*!40000 ALTER TABLE `btc_users_data` DISABLE KEYS */;
/*!40000 ALTER TABLE `btc_users_data` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `btc_users_money`
--

DROP TABLE IF EXISTS `btc_users_money`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `btc_users_money` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `transaction_type` enum('deposit','sell_btc','buy_btc','withdraw') DEFAULT NULL,
  `status` tinyint(2) NOT NULL DEFAULT '1',
  `amount` decimal(12,2) DEFAULT NULL,
  `gateway_id` int(11) DEFAULT NULL,
  `time` int(11) DEFAULT NULL,
  `u_field_1` varchar(255) DEFAULT NULL,
  `u_field_2` varchar(255) DEFAULT NULL,
  `u_field_3` varchar(255) DEFAULT NULL,
  `u_field_4` varchar(255) DEFAULT NULL,
  `u_field_5` varchar(255) DEFAULT NULL,
  `u_field_6` varchar(255) DEFAULT NULL,
  `u_field_7` varchar(255) DEFAULT NULL,
  `u_field_8` varchar(255) DEFAULT NULL,
  `u_field_9` varchar(255) DEFAULT NULL,
  `u_field_10` varchar(255) DEFAULT NULL,
  `attachment` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=32 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `btc_users_money`
--

LOCK TABLES `btc_users_money` WRITE;
/*!40000 ALTER TABLE `btc_users_money` DISABLE KEYS */;
INSERT INTO `btc_users_money` VALUES (1,5,'deposit',0,50.00,1,1517705366,'','','','','',NULL,NULL,NULL,NULL,NULL,'uploads/attachments/5_1517705366_attachment.jpg'),(2,5,'buy_btc',1,-50.00,1,1517705479,'','','','','',NULL,NULL,NULL,NULL,NULL,'/uploads/attachments/5_1517705479_attachment.jpg'),(3,5,'deposit',1,50.00,1,1517705485,'','','','','',NULL,NULL,NULL,NULL,NULL,'/uploads/attachments/5_1517705485_attachment.jpg'),(4,5,'deposit',2,50.00,1,1517705522,'','','','','',NULL,NULL,NULL,NULL,NULL,'/uploads/attachments/5_1517705522_money.jpg'),(5,5,'deposit',1,50.00,1,1517706662,'','','','','',NULL,NULL,NULL,NULL,NULL,'/uploads/attachments/5_1517706662_money.jpg'),(6,5,'deposit',1,50.00,1,1517706696,'','','','','',NULL,NULL,NULL,NULL,NULL,'/uploads/attachments/5_1517706696_money.jpg'),(7,5,'deposit',1,50.00,1,1517706710,'','','','','',NULL,NULL,NULL,NULL,NULL,'/uploads/attachments/5_1517706710_money.jpg'),(8,5,'deposit',1,50.00,1,1517706944,'','','','','',NULL,NULL,NULL,NULL,NULL,'/uploads/attachments/5_1517706944_money.jpg'),(9,5,'deposit',1,50.00,1,1517706978,'','','','','',NULL,NULL,NULL,NULL,NULL,'/uploads/attachments/5_1517706978_money.jpg'),(10,5,'deposit',1,50.00,1,1517707205,'','','','','',NULL,NULL,NULL,NULL,NULL,'/uploads/attachments/5_1517707205_money.jpg'),(11,5,'deposit',1,50.00,1,1517707293,'','','','','',NULL,NULL,NULL,NULL,NULL,'/uploads/attachments/5_1517707293_money.jpg'),(12,5,'deposit',1,50.00,1,1517707332,'','','','','',NULL,NULL,NULL,NULL,NULL,'uploads/attachments/5_1517707332_money.jpg'),(13,5,'deposit',1,13.00,1,1517768688,'','','','','',NULL,NULL,NULL,NULL,NULL,'uploads/attachments/5_1517768688_money.jpg'),(14,5,'deposit',1,13.00,1,1517768740,'','','','','',NULL,NULL,NULL,NULL,NULL,'uploads/attachments/5_1517768740_money.jpg'),(15,5,'deposit',2,10.00,1,1517783088,'','','','','',NULL,NULL,NULL,NULL,NULL,'uploads/attachments/5_1517783088_money.jpg'),(21,5,'buy_btc',1,-100.00,NULL,1517788488,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(20,5,'buy_btc',1,-100.00,NULL,1517788478,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(22,5,'sell_btc',1,78.90,NULL,1517789901,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(23,5,'withdraw',0,-10.00,NULL,1517849820,'a','b','c','d',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(24,5,'withdraw',0,-10.00,NULL,1517849960,'a','b','c','d',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(25,5,'withdraw',0,-10.00,NULL,1517850196,'a','b','c','d',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(26,5,'withdraw',0,-10.00,NULL,1517850272,'a','b','c','d',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(27,5,'withdraw',0,-300.00,NULL,1517850320,'a','b','c','d',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(28,5,'withdraw',1,-10.00,NULL,1517850364,'a','b','c','d',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(29,5,'withdraw',1,-10.00,NULL,1517850746,'a','b','c','d',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(30,5,'withdraw',2,-21.00,NULL,1517850879,'a','b','c','d',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(31,5,'withdraw',1,-12.00,NULL,1517850891,'aaaa','bff','cggg','dtyjtuyjutj',NULL,NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `btc_users_money` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `btc_users_transactions`
--

DROP TABLE IF EXISTS `btc_users_transactions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `btc_users_transactions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `recipient` varchar(255) DEFAULT NULL,
  `sender` varchar(255) DEFAULT NULL,
  `amount` varchar(255) DEFAULT NULL,
  `time` int(11) DEFAULT NULL,
  `confirmations` int(11) DEFAULT NULL,
  `txid` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `btc_users_transactions`
--

LOCK TABLES `btc_users_transactions` WRITE;
/*!40000 ALTER TABLE `btc_users_transactions` DISABLE KEYS */;
/*!40000 ALTER TABLE `btc_users_transactions` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-09-21 13:02:24
