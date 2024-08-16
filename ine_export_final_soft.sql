-- MySQL dump 10.13  Distrib 8.0.33, for Linux (x86_64)
--
-- Host: localhost    Database: ine
-- ------------------------------------------------------
-- Server version	8.0.33

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `booking_moment_details`
--

DROP TABLE IF EXISTS `booking_moment_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `booking_moment_details` (
  `id` int NOT NULL AUTO_INCREMENT,
  `trans_booking_details_id` int DEFAULT '0',
  `user_id` int DEFAULT '0' COMMENT '												',
  `container_number` varchar(128) DEFAULT NULL,
  `custom_seal_no` varchar(128) DEFAULT NULL,
  `a_seal_no` varchar(128) DEFAULT NULL,
  `vehicle_no` varchar(128) DEFAULT NULL,
  `factory_in` datetime DEFAULT NULL,
  `factory_out` datetime DEFAULT NULL,
  `cfs_date` datetime DEFAULT NULL,
  `status` int DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `document_marks` varchar(255) DEFAULT NULL,
  `document_description` text,
  `document_update_user_id` int DEFAULT '0',
  `document_gross_weight` varchar(128) DEFAULT NULL,
  `document_vgm_weight` varchar(128) DEFAULT NULL,
  `document_no_of_package` varchar(128) DEFAULT NULL,
  `document_kind_of_package` varchar(128) DEFAULT NULL,
  `document_measurement` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `booking_moment_details`
--

LOCK TABLES `booking_moment_details` WRITE;
/*!40000 ALTER TABLE `booking_moment_details` DISABLE KEYS */;
/*!40000 ALTER TABLE `booking_moment_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `booking_transhipment_details`
--

DROP TABLE IF EXISTS `booking_transhipment_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `booking_transhipment_details` (
  `id` int NOT NULL AUTO_INCREMENT,
  `trans_booking_details_id` int DEFAULT '0',
  `transhipment_port` int DEFAULT '0',
  `transhipment_eta` datetime DEFAULT NULL,
  `transhipment_etd` datetime DEFAULT NULL,
  `transhipment_remark` text,
  `user_id` int DEFAULT '0',
  `status` int DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `booking_transhipment_details`
--

LOCK TABLES `booking_transhipment_details` WRITE;
/*!40000 ALTER TABLE `booking_transhipment_details` DISABLE KEYS */;
/*!40000 ALTER TABLE `booking_transhipment_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `booking_vessel_history`
--

DROP TABLE IF EXISTS `booking_vessel_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `booking_vessel_history` (
  `id` int NOT NULL AUTO_INCREMENT,
  `trans_booking_details_id` int DEFAULT '0',
  `ms_exporter_id` int DEFAULT '0',
  `ramp_cut_off_datetime` datetime DEFAULT NULL,
  `earlist_receiving_datetime` datetime DEFAULT NULL,
  `vgm_cut_off_datetime` datetime DEFAULT NULL,
  `terminal_datetime` datetime DEFAULT NULL,
  `eta_datetime` datetime DEFAULT NULL,
  `etd_datetime` datetime DEFAULT NULL,
  `booking_number` varchar(128) DEFAULT NULL,
  `document_cut_off_date_time` datetime DEFAULT NULL,
  `stuffing` int DEFAULT '0',
  `si_cut_off_date_time` datetime DEFAULT NULL,
  `eqp_available_datetime` datetime DEFAULT NULL,
  `booking_file_url` varchar(255) DEFAULT NULL,
  `booking_detail_remark` text,
  `user_id` int DEFAULT '0',
  `status` int DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `vessel_voy` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `booking_vessel_history`
--

LOCK TABLES `booking_vessel_history` WRITE;
/*!40000 ALTER TABLE `booking_vessel_history` DISABLE KEYS */;
/*!40000 ALTER TABLE `booking_vessel_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cities`
--

DROP TABLE IF EXISTS `cities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cities` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(128) DEFAULT NULL,
  `state_id` int DEFAULT '0',
  `created` datetime DEFAULT CURRENT_TIMESTAMP,
  `status` int DEFAULT '1',
  `user_id` int DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cities`
--

LOCK TABLES `cities` WRITE;
/*!40000 ALTER TABLE `cities` DISABLE KEYS */;
INSERT INTO `cities` VALUES (1,'Ahmedabad1',1,'2023-04-12 09:43:46',0,1),(2,'Vadodara',1,'2023-04-12 09:45:54',0,1),(3,'asdfsdf44',1,'2023-04-12 09:49:47',0,1),(4,'ahmedabad55',1,'2023-04-13 00:49:47',1,1),(5,'Mumbai',3,'2023-05-02 10:07:26',1,1),(6,'Mosco City',4,'2023-05-02 15:16:38',1,1);
/*!40000 ALTER TABLE `cities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `countries`
--

DROP TABLE IF EXISTS `countries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `countries` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(128) DEFAULT NULL,
  `created_by` int DEFAULT '0',
  `status` int DEFAULT '1',
  `created` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `countries`
--

LOCK TABLES `countries` WRITE;
/*!40000 ALTER TABLE `countries` DISABLE KEYS */;
INSERT INTO `countries` VALUES (1,'Chaina New',1,0,'2023-04-11 10:03:20'),(2,'fff',1,0,'2023-04-11 10:03:28'),(3,'India',1,1,'2023-04-12 00:16:59'),(4,'Russia',1,1,'2023-05-02 09:49:01');
/*!40000 ALTER TABLE `countries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `delivery_agent`
--

DROP TABLE IF EXISTS `delivery_agent`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `delivery_agent` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(128) DEFAULT NULL,
  `email` varchar(128) DEFAULT NULL,
  `mobile` varchar(45) DEFAULT NULL,
  `status` int DEFAULT '1',
  `user_id` int DEFAULT '0',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `delivery_agent`
--

LOCK TABLES `delivery_agent` WRITE;
/*!40000 ALTER TABLE `delivery_agent` DISABLE KEYS */;
/*!40000 ALTER TABLE `delivery_agent` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ms_consignee`
--

DROP TABLE IF EXISTS `ms_consignee`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ms_consignee` (
  `id` int NOT NULL AUTO_INCREMENT,
  `full_name` varchar(255) DEFAULT NULL,
  `email_address` varchar(255) DEFAULT NULL,
  `contact_number` varchar(45) DEFAULT NULL,
  `address` text,
  `address2` text,
  `address3` text,
  `country` int DEFAULT '0',
  `state_id` int DEFAULT '0',
  `city_id` int DEFAULT '0',
  `pincode` varchar(45) DEFAULT NULL,
  `tax_id` varchar(45) DEFAULT NULL,
  `created` datetime DEFAULT CURRENT_TIMESTAMP,
  `status` int DEFAULT '1',
  `created_by` int DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ms_consignee`
--

LOCK TABLES `ms_consignee` WRITE;
/*!40000 ALTER TABLE `ms_consignee` DISABLE KEYS */;
/*!40000 ALTER TABLE `ms_consignee` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ms_countries`
--

DROP TABLE IF EXISTS `ms_countries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ms_countries` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(128) DEFAULT NULL,
  `status` int DEFAULT '1',
  `created` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ms_countries`
--

LOCK TABLES `ms_countries` WRITE;
/*!40000 ALTER TABLE `ms_countries` DISABLE KEYS */;
/*!40000 ALTER TABLE `ms_countries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ms_currencies`
--

DROP TABLE IF EXISTS `ms_currencies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ms_currencies` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(45) DEFAULT NULL,
  `sign` varchar(45) DEFAULT NULL,
  `status` int DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ms_currencies`
--

LOCK TABLES `ms_currencies` WRITE;
/*!40000 ALTER TABLE `ms_currencies` DISABLE KEYS */;
/*!40000 ALTER TABLE `ms_currencies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ms_equipment_type`
--

DROP TABLE IF EXISTS `ms_equipment_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ms_equipment_type` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(128) DEFAULT NULL,
  `status` int DEFAULT '1',
  `created` datetime DEFAULT CURRENT_TIMESTAMP,
  `created_by` int DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ms_equipment_type`
--

LOCK TABLES `ms_equipment_type` WRITE;
/*!40000 ALTER TABLE `ms_equipment_type` DISABLE KEYS */;
/*!40000 ALTER TABLE `ms_equipment_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ms_exporter`
--

DROP TABLE IF EXISTS `ms_exporter`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ms_exporter` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(128) DEFAULT NULL,
  `email` varchar(128) DEFAULT NULL,
  `phone` varchar(45) DEFAULT NULL,
  `address` text,
  `address2` text,
  `address3` text,
  `country` int DEFAULT '0',
  `state_id` int DEFAULT '0',
  `city_id` int DEFAULT '0',
  `pincode` varchar(45) DEFAULT NULL,
  `gst_number` varchar(45) DEFAULT NULL,
  `gst_file` varchar(255) DEFAULT NULL,
  `gst_address` text,
  `iec_number` varchar(128) DEFAULT NULL,
  `iec_file` varchar(255) DEFAULT NULL,
  `pan_number` varchar(20) DEFAULT NULL,
  `pan_file` varchar(255) DEFAULT NULL,
  `aadhar_number` varchar(45) DEFAULT NULL,
  `aadhar_file` varchar(255) DEFAULT NULL,
  `electricity_bill_number` varchar(45) DEFAULT NULL,
  `electricity_bill_file` varchar(255) DEFAULT NULL,
  `telephone_number` varchar(45) DEFAULT NULL,
  `telephone_file` varchar(255) DEFAULT NULL,
  `status` int DEFAULT '1',
  `created_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `user_id` int DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ms_exporter`
--

LOCK TABLES `ms_exporter` WRITE;
/*!40000 ALTER TABLE `ms_exporter` DISABLE KEYS */;
/*!40000 ALTER TABLE `ms_exporter` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ms_incoterm`
--

DROP TABLE IF EXISTS `ms_incoterm`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ms_incoterm` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(128) DEFAULT NULL,
  `status` int DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ms_incoterm`
--

LOCK TABLES `ms_incoterm` WRITE;
/*!40000 ALTER TABLE `ms_incoterm` DISABLE KEYS */;
/*!40000 ALTER TABLE `ms_incoterm` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ms_port_of_destination`
--

DROP TABLE IF EXISTS `ms_port_of_destination`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ms_port_of_destination` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(128) DEFAULT NULL,
  `status` int DEFAULT '1',
  `created` datetime DEFAULT CURRENT_TIMESTAMP,
  `created_by` int DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ms_port_of_destination`
--

LOCK TABLES `ms_port_of_destination` WRITE;
/*!40000 ALTER TABLE `ms_port_of_destination` DISABLE KEYS */;
/*!40000 ALTER TABLE `ms_port_of_destination` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ms_port_of_loading`
--

DROP TABLE IF EXISTS `ms_port_of_loading`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ms_port_of_loading` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(128) DEFAULT NULL,
  `status` int DEFAULT '1',
  `created` datetime DEFAULT CURRENT_TIMESTAMP,
  `created_by` int DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ms_port_of_loading`
--

LOCK TABLES `ms_port_of_loading` WRITE;
/*!40000 ALTER TABLE `ms_port_of_loading` DISABLE KEYS */;
/*!40000 ALTER TABLE `ms_port_of_loading` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ms_shippingline`
--

DROP TABLE IF EXISTS `ms_shippingline`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ms_shippingline` (
  `id` int NOT NULL AUTO_INCREMENT,
  `full_name` varchar(100) DEFAULT NULL,
  `address` text,
  `status` int DEFAULT '1',
  `created_dt` datetime DEFAULT CURRENT_TIMESTAMP,
  `created_by` int DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ms_shippingline`
--

LOCK TABLES `ms_shippingline` WRITE;
/*!40000 ALTER TABLE `ms_shippingline` DISABLE KEYS */;
/*!40000 ALTER TABLE `ms_shippingline` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notify_users`
--

DROP TABLE IF EXISTS `notify_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `notify_users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(128) DEFAULT NULL,
  `email` varchar(128) DEFAULT NULL,
  `mobile` varchar(45) DEFAULT NULL,
  `status` int DEFAULT '1',
  `user_id` int DEFAULT '0',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notify_users`
--

LOCK TABLES `notify_users` WRITE;
/*!40000 ALTER TABLE `notify_users` DISABLE KEYS */;
/*!40000 ALTER TABLE `notify_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `id` int NOT NULL AUTO_INCREMENT,
  `role_name` varchar(45) DEFAULT NULL,
  `status` int DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'Admin',1,'2023-05-04 10:16:56'),(2,'Sales',1,'2023-05-04 10:16:56'),(3,'Customer service',1,'2023-05-04 10:16:56'),(4,'Documentation',1,'2023-05-04 10:16:56'),(5,'Account',1,'2023-05-04 10:16:56'),(6,'Dispatch',1,'2023-05-04 10:16:56');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `states`
--

DROP TABLE IF EXISTS `states`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `states` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(128) DEFAULT NULL,
  `countries_id` int DEFAULT '0',
  `created` datetime DEFAULT CURRENT_TIMESTAMP,
  `status` int DEFAULT '1',
  `user_id` int DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `states`
--

LOCK TABLES `states` WRITE;
/*!40000 ALTER TABLE `states` DISABLE KEYS */;
INSERT INTO `states` VALUES (1,'Gujarat',3,'2023-04-12 00:20:51',1,1),(2,'Maharastra',3,'2023-05-02 09:50:10',0,1),(3,'Maharastra',3,'2023-05-02 10:07:18',1,1),(4,'Mosco',4,'2023-05-02 14:46:16',1,1);
/*!40000 ALTER TABLE `states` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trans_booking_details`
--

DROP TABLE IF EXISTS `trans_booking_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `trans_booking_details` (
  `id` int NOT NULL AUTO_INCREMENT,
  `job_number` varchar(128) DEFAULT NULL,
  `shipper_name` varchar(128) DEFAULT NULL,
  `booking_received_from` varchar(128) DEFAULT NULL,
  `ms_incoterm_id` int DEFAULT '0',
  `selling_rate` float(10,2) DEFAULT '0.00',
  `ms_currencies_id` int DEFAULT '0',
  `other_charges` text,
  `shipping_line_rate` float(10,2) DEFAULT '0.00',
  `ms_equipment_type_id` int DEFAULT '0',
  `no_of_container` int DEFAULT '0',
  `ms_port_of_loading_id` int DEFAULT '0',
  `pickup_location` varchar(128) DEFAULT NULL,
  `ms_port_of_destination` int DEFAULT '0',
  `final_place_of_delivery` text,
  `user_id` int DEFAULT '0',
  `status` int DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `ramp_cut_off_datetime` datetime DEFAULT NULL,
  `earlist_receiving_datetime` datetime DEFAULT NULL,
  `vgm_cut_off_datetime` datetime DEFAULT NULL,
  `terminal_datetime` datetime DEFAULT NULL,
  `etd_datetime` datetime DEFAULT NULL,
  `eta_datetime` datetime DEFAULT NULL,
  `eqp_available_datetime` datetime DEFAULT NULL,
  `ms_exporter_id` int DEFAULT '0',
  `booking_number` varchar(128) DEFAULT NULL,
  `si_cut_off_date_time` datetime DEFAULT NULL,
  `document_cut_off_date_time` datetime DEFAULT NULL,
  `stuffing` int DEFAULT '0',
  `booking_file_url` varchar(255) DEFAULT NULL,
  `booking_detail_remark` text,
  `notify_user1` int DEFAULT '0',
  `notify_user2` int DEFAULT '0',
  `notify_user3` int DEFAULT '0',
  `delivery_agent_id` int DEFAULT '0',
  `document_remark` text,
  `shipping_bill_url` varchar(255) DEFAULT NULL,
  `gate_pass_url` varchar(255) DEFAULT NULL,
  `invoice_copy_url` varchar(255) DEFAULT NULL,
  `packing_list_url` varchar(255) DEFAULT NULL,
  `vgm_copy_url` varchar(255) DEFAULT NULL,
  `booking_copy_url` varchar(255) DEFAULT NULL,
  `other_file_url` varchar(255) DEFAULT NULL,
  `ms_consignee_id` int DEFAULT '0',
  `same_as_consignee` int DEFAULT '0',
  `no_of_original_bills_of_loading` int DEFAULT '0',
  `required_obl` int DEFAULT '0',
  `no_of_negotiable_copy` int DEFAULT '0',
  `express_bl` int DEFAULT '0',
  `no_of_express_obj` int DEFAULT '0',
  `no_of_express_negotiable_copy` int DEFAULT '0',
  `freight_payble_at` int DEFAULT '0',
  `document_hsc_code` varchar(128) DEFAULT NULL,
  `bl_number` varchar(128) DEFAULT NULL,
  `vessel_voy` varchar(255) DEFAULT NULL,
  `document_marks` text,
  `document_description` text,
  `document_gross_weight` text,
  `document_measurement` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `job_number_UNIQUE` (`job_number`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `trans_booking_details`
--

LOCK TABLES `trans_booking_details` WRITE;
/*!40000 ALTER TABLE `trans_booking_details` DISABLE KEYS */;
/*!40000 ALTER TABLE `trans_booking_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `unlock_line_seal_numbers`
--

DROP TABLE IF EXISTS `unlock_line_seal_numbers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `unlock_line_seal_numbers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `trans_booking_details_id` int DEFAULT '0',
  `booking_moment_details_id` int DEFAULT '0',
  `line_seal_number` varchar(128) DEFAULT NULL,
  `container_number` varchar(128) DEFAULT NULL,
  `custom_seal_number` varchar(128) DEFAULT NULL,
  `vehicle_number` varchar(128) DEFAULT NULL,
  `status` int DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `user_id` int DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `unlock_line_seal_numbers`
--

LOCK TABLES `unlock_line_seal_numbers` WRITE;
/*!40000 ALTER TABLE `unlock_line_seal_numbers` DISABLE KEYS */;
/*!40000 ALTER TABLE `unlock_line_seal_numbers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_files`
--

DROP TABLE IF EXISTS `user_files`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_files` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_name` varchar(100) DEFAULT NULL,
  `file_url` varchar(225) DEFAULT NULL,
  `user_id` int DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_files`
--

LOCK TABLES `user_files` WRITE;
/*!40000 ALTER TABLE `user_files` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_files` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(225) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `user_id` int DEFAULT '0',
  `status` int DEFAULT '1',
  `name` varchar(128) DEFAULT NULL,
  `roles_id` int DEFAULT '0',
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'nileshratangupta@gmail.com','$2y$10$viKBrjsy6MC9lvVfpdKgJegxcxwGgE4/ymcyA3iDtHTfSzxwAGjgK',0,1,'nilesh',1,'2023-04-01 11:47:23','2023-04-01 11:47:23');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-06-08 12:31:48
