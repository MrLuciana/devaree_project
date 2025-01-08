-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 08, 2025 at 12:08 PM
-- Server version: 8.0.17
-- PHP Version: 7.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_devaree`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `GenerateCustomers` (IN `total` INT)  BEGIN
    DECLARE i INT DEFAULT 0;
    
    WHILE i < total DO
        INSERT INTO customers (first_name, last_name, email, phone, address, city, country)
        VALUES (
            CONCAT('User', i),
            CONCAT('Last', i),
            CONCAT('user', i, '@example.com'),
            LPAD(FLOOR(RAND() * 10000000000), 10, '0'),
            CONCAT(FLOOR(RAND() * 999), ' Street'),
            'RandomCity',
            'RandomCountry'
        );
        SET i = i + 1;
    END WHILE;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `adm_id` int(2) NOT NULL,
  `adm_title` varchar(20) NOT NULL,
  `adm_fname` varchar(50) NOT NULL,
  `adm_lname` varchar(50) NOT NULL,
  `adm_username` varchar(20) NOT NULL,
  `adm_password` varchar(70) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `adm_avatar` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`adm_id`, `adm_title`, `adm_fname`, `adm_lname`, `adm_username`, `adm_password`, `adm_avatar`) VALUES
(1, 'นาย', 'ศุภกฤต', 'บรรจงดัด', 'admin', '$2y$10$zDH9Q70sjwTWEgSZMEWN4.unv5eOD7sh8R1ez7bPijbj6qiPQQAKy', '');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `course_id` int(11) NOT NULL,
  `course_name` varchar(100) NOT NULL,
  `course_description` text CHARACTER SET utf8 COLLATE utf8_general_ci,
  `course_duration_minutes` int(11) NOT NULL,
  `course_price` decimal(10,2) NOT NULL,
  `course_category` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `course_created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `course_updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`course_id`, `course_name`, `course_description`, `course_duration_minutes`, `course_price`, `course_category`, `course_created_at`, `course_updated_at`) VALUES
(1, 'Aroma Therapy', 'Relaxing full-body massage with essential oils.', 60, '1500.00', 'Massage', '2025-01-06 13:47:01', '2025-01-06 13:47:01'),
(2, 'Thai Traditional Massage', 'Ancient Thai massage technique for muscle relaxation.', 90, '1200.00', 'Massage', '2025-01-06 13:47:01', '2025-01-06 13:47:01'),
(3, 'Herbal Compress Therapy', 'Massage with heated herbal compress for pain relief.', 90, '1800.00', 'Therapy', '2025-01-06 13:47:01', '2025-01-06 13:47:01'),
(4, 'Facial Rejuvenation', 'Deep cleansing facial treatment for glowing skin.', 45, '1000.00', 'Facial', '2025-01-06 13:47:01', '2025-01-06 13:47:01'),
(5, 'Body Scrub & Wrap', 'Exfoliation and moisturizing treatment for smooth skin.', 60, '2000.00', 'Body Treatment', '2025-01-06 13:47:01', '2025-01-06 13:47:01'),
(6, 'Hot Stone Therapy', 'Therapeutic massage with heated stones for deep relaxation.', 75, '2200.00', 'Massage', '2025-01-06 13:47:01', '2025-01-06 13:47:01'),
(7, 'Foot Reflexology', 'Massage targeting pressure points in the feet.', 30, '800.00', 'Reflexology', '2025-01-06 13:47:01', '2025-01-06 13:47:01'),
(8, 'Couple’s Retreat', 'Special package for two with massage and aromatherapy.', 120, '4000.00', 'Package', '2025-01-06 13:47:01', '2025-01-06 13:47:01');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `cus_id` int(11) NOT NULL,
  `cus_fname` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `cus_lname` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `cus_email` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `cus_phone` varchar(15) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `cus_address` text CHARACTER SET utf8 COLLATE utf8_general_ci,
  `cus_city` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `cus_country` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `cus_created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`cus_id`, `cus_fname`, `cus_lname`, `cus_email`, `cus_phone`, `cus_address`, `cus_city`, `cus_country`, `cus_created_at`) VALUES
(1, 'User0', 'Last0', 'user0@example.com', '1357211984', '605 Street', 'RandomCity', 'RandomCountry', '2025-01-04 23:10:28'),
(2, 'User1', 'Last1', 'user1@example.com', '6231944650', '297 Street', 'RandomCity', 'RandomCountry', '2025-01-04 23:10:28'),
(3, 'User2', 'Last2', 'user2@example.com', '6192043271', '202 Street', 'RandomCity', 'RandomCountry', '2025-01-04 23:10:28'),
(4, 'User3', 'Last3', 'user3@example.com', '1561323061', '172 Street', 'RandomCity', 'RandomCountry', '2025-01-04 23:10:28'),
(5, 'User4', 'Last4', 'user4@example.com', '3936751488', '450 Street', 'RandomCity', 'RandomCountry', '2025-01-04 23:10:28'),
(6, 'User5', 'Last5', 'user5@example.com', '0746373497', '19 Street', 'RandomCity', 'RandomCountry', '2025-01-04 23:10:28'),
(7, 'User6', 'Last6', 'user6@example.com', '8750335824', '315 Street', 'RandomCity', 'RandomCountry', '2025-01-04 23:10:28'),
(8, 'User7', 'Last7', 'user7@example.com', '9539021951', '821 Street', 'RandomCity', 'RandomCountry', '2025-01-04 23:10:28'),
(9, 'User8', 'Last8', 'user8@example.com', '2488397427', '777 Street', 'RandomCity', 'RandomCountry', '2025-01-04 23:10:28'),
(10, 'User9', 'Last9', 'user9@example.com', '1428356320', '380 Street', 'RandomCity', 'RandomCountry', '2025-01-04 23:10:28'),
(11, 'User10', 'Last10', 'user10@example.com', '4743196018', '229 Street', 'RandomCity', 'RandomCountry', '2025-01-04 23:10:28'),
(12, 'User11', 'Last11', 'user11@example.com', '7265520232', '942 Street', 'RandomCity', 'RandomCountry', '2025-01-04 23:10:28'),
(13, 'User12', 'Last12', 'user12@example.com', '5356123023', '848 Street', 'RandomCity', 'RandomCountry', '2025-01-04 23:10:28'),
(14, 'User13', 'Last13', 'user13@example.com', '6376658125', '640 Street', 'RandomCity', 'RandomCountry', '2025-01-04 23:10:28'),
(15, 'User14', 'Last14', 'user14@example.com', '2951399928', '550 Street', 'RandomCity', 'RandomCountry', '2025-01-04 23:10:28'),
(16, 'User15', 'Last15', 'user15@example.com', '8686678287', '690 Street', 'RandomCity', 'RandomCountry', '2025-01-04 23:10:28'),
(17, 'User16', 'Last16', 'user16@example.com', '8484290864', '169 Street', 'RandomCity', 'RandomCountry', '2025-01-04 23:10:28'),
(18, 'User17', 'Last17', 'user17@example.com', '3021424611', '2 Street', 'RandomCity', 'RandomCountry', '2025-01-04 23:10:28'),
(19, 'User18', 'Last18', 'user18@example.com', '1048452594', '516 Street', 'RandomCity', 'RandomCountry', '2025-01-04 23:10:28'),
(20, 'User19', 'Last19', 'user19@example.com', '2727780558', '810 Street', 'RandomCity', 'RandomCountry', '2025-01-04 23:10:28'),
(21, 'User20', 'Last20', 'user20@example.com', '2391760034', '760 Street', 'RandomCity', 'RandomCountry', '2025-01-04 23:10:28'),
(22, 'User21', 'Last21', 'user21@example.com', '0893418398', '162 Street', 'RandomCity', 'RandomCountry', '2025-01-04 23:10:28'),
(23, 'User22', 'Last22', 'user22@example.com', '5449112025', '236 Street', 'RandomCity', 'RandomCountry', '2025-01-04 23:10:28'),
(24, 'User23', 'Last23', 'user23@example.com', '5492365663', '35 Street', 'RandomCity', 'RandomCountry', '2025-01-04 23:10:28'),
(25, 'User24', 'Last24', 'user24@example.com', '5312942141', '548 Street', 'RandomCity', 'RandomCountry', '2025-01-04 23:10:28'),
(26, 'User25', 'Last25', 'user25@example.com', '1514612474', '109 Street', 'RandomCity', 'RandomCountry', '2025-01-04 23:10:28'),
(27, 'User26', 'Last26', 'user26@example.com', '0961160520', '150 Street', 'RandomCity', 'RandomCountry', '2025-01-04 23:10:28'),
(28, 'User27', 'Last27', 'user27@example.com', '4630540390', '863 Street', 'RandomCity', 'RandomCountry', '2025-01-04 23:10:28'),
(29, 'User28', 'Last28', 'user28@example.com', '9329825490', '71 Street', 'RandomCity', 'RandomCountry', '2025-01-04 23:10:28'),
(30, 'User29', 'Last29', 'user29@example.com', '5591823566', '580 Street', 'RandomCity', 'RandomCountry', '2025-01-04 23:10:28'),
(31, 'User30', 'Last30', 'user30@example.com', '2276221115', '394 Street', 'RandomCity', 'RandomCountry', '2025-01-04 23:10:28'),
(32, 'User31', 'Last31', 'user31@example.com', '2921791861', '275 Street', 'RandomCity', 'RandomCountry', '2025-01-04 23:10:28'),
(33, 'User32', 'Last32', 'user32@example.com', '5028058099', '685 Street', 'RandomCity', 'RandomCountry', '2025-01-04 23:10:28'),
(34, 'User33', 'Last33', 'user33@example.com', '9236979902', '558 Street', 'RandomCity', 'RandomCountry', '2025-01-04 23:10:28'),
(35, 'User34', 'Last34', 'user34@example.com', '0250098025', '446 Street', 'RandomCity', 'RandomCountry', '2025-01-04 23:10:28'),
(36, 'User35', 'Last35', 'user35@example.com', '1619046127', '466 Street', 'RandomCity', 'RandomCountry', '2025-01-04 23:10:28'),
(37, 'User36', 'Last36', 'user36@example.com', '8510996949', '852 Street', 'RandomCity', 'RandomCountry', '2025-01-04 23:10:28'),
(38, 'User37', 'Last37', 'user37@example.com', '7137529661', '8 Street', 'RandomCity', 'RandomCountry', '2025-01-04 23:10:28'),
(39, 'User38', 'Last38', 'user38@example.com', '9014093781', '480 Street', 'RandomCity', 'RandomCountry', '2025-01-04 23:10:28'),
(40, 'User39', 'Last39', 'user39@example.com', '7030017671', '70 Street', 'RandomCity', 'RandomCountry', '2025-01-04 23:10:28'),
(41, 'User40', 'Last40', 'user40@example.com', '2443494482', '9 Street', 'RandomCity', 'RandomCountry', '2025-01-04 23:10:28'),
(42, 'User41', 'Last41', 'user41@example.com', '3156238890', '548 Street', 'RandomCity', 'RandomCountry', '2025-01-04 23:10:28'),
(43, 'User42', 'Last42', 'user42@example.com', '7977091342', '341 Street', 'RandomCity', 'RandomCountry', '2025-01-04 23:10:28'),
(44, 'User43', 'Last43', 'user43@example.com', '3158588254', '553 Street', 'RandomCity', 'RandomCountry', '2025-01-04 23:10:28'),
(45, 'User44', 'Last44', 'user44@example.com', '8219357513', '447 Street', 'RandomCity', 'RandomCountry', '2025-01-04 23:10:28'),
(46, 'User45', 'Last45', 'user45@example.com', '7740501228', '525 Street', 'RandomCity', 'RandomCountry', '2025-01-04 23:10:28'),
(47, 'User46', 'Last46', 'user46@example.com', '3095308489', '967 Street', 'RandomCity', 'RandomCountry', '2025-01-04 23:10:28'),
(48, 'User47', 'Last47', 'user47@example.com', '9146353005', '666 Street', 'RandomCity', 'RandomCountry', '2025-01-04 23:10:28'),
(49, 'User48', 'Last48', 'user48@example.com', '5922933468', '958 Street', 'RandomCity', 'RandomCountry', '2025-01-04 23:10:28'),
(50, 'User49', 'Last49', 'user49@example.com', '0218561617', '229 Street', 'RandomCity', 'RandomCountry', '2025-01-04 23:10:28'),
(51, 'User50', 'Last50', 'user50@example.com', '0846272288', '732 Street', 'RandomCity', 'RandomCountry', '2025-01-04 23:10:28'),
(52, 'User51', 'Last51', 'user51@example.com', '4112121690', '856 Street', 'RandomCity', 'RandomCountry', '2025-01-04 23:10:28'),
(53, 'User52', 'Last52', 'user52@example.com', '0513864281', '685 Street', 'RandomCity', 'RandomCountry', '2025-01-04 23:10:28'),
(54, 'User53', 'Last53', 'user53@example.com', '2754328896', '319 Street', 'RandomCity', 'RandomCountry', '2025-01-04 23:10:28'),
(55, 'User54', 'Last54', 'user54@example.com', '7707473261', '894 Street', 'RandomCity', 'RandomCountry', '2025-01-04 23:10:28'),
(56, 'User55', 'Last55', 'user55@example.com', '1653034660', '139 Street', 'RandomCity', 'RandomCountry', '2025-01-04 23:10:28'),
(57, 'User56', 'Last56', 'user56@example.com', '2040401969', '599 Street', 'RandomCity', 'RandomCountry', '2025-01-04 23:10:28'),
(58, 'User57', 'Last57', 'user57@example.com', '3890328233', '144 Street', 'RandomCity', 'RandomCountry', '2025-01-04 23:10:28'),
(59, 'User58', 'Last58', 'user58@example.com', '5552621488', '342 Street', 'RandomCity', 'RandomCountry', '2025-01-04 23:10:28'),
(60, 'User59', 'Last59', 'user59@example.com', '0486856950', '214 Street', 'RandomCity', 'RandomCountry', '2025-01-04 23:10:28'),
(61, 'User60', 'Last60', 'user60@example.com', '9276691432', '993 Street', 'RandomCity', 'RandomCountry', '2025-01-04 23:10:28'),
(62, 'User61', 'Last61', 'user61@example.com', '1875427422', '954 Street', 'RandomCity', 'RandomCountry', '2025-01-04 23:10:28'),
(63, 'User62', 'Last62', 'user62@example.com', '2142900910', '205 Street', 'RandomCity', 'RandomCountry', '2025-01-04 23:10:28'),
(64, 'User63', 'Last63', 'user63@example.com', '3836273256', '301 Street', 'RandomCity', 'RandomCountry', '2025-01-04 23:10:28'),
(65, 'User64', 'Last64', 'user64@example.com', '3603086446', '893 Street', 'RandomCity', 'RandomCountry', '2025-01-04 23:10:28'),
(66, 'User65', 'Last65', 'user65@example.com', '3932185949', '281 Street', 'RandomCity', 'RandomCountry', '2025-01-04 23:10:28'),
(67, 'User66', 'Last66', 'user66@example.com', '2283757787', '296 Street', 'RandomCity', 'RandomCountry', '2025-01-04 23:10:28'),
(68, 'User67', 'Last67', 'user67@example.com', '8001727180', '109 Street', 'RandomCity', 'RandomCountry', '2025-01-04 23:10:28'),
(69, 'User68', 'Last68', 'user68@example.com', '1478999109', '410 Street', 'RandomCity', 'RandomCountry', '2025-01-04 23:10:28'),
(70, 'User69', 'Last69', 'user69@example.com', '6085441220', '810 Street', 'RandomCity', 'RandomCountry', '2025-01-04 23:10:28'),
(71, 'User70', 'Last70', 'user70@example.com', '2312393972', '721 Street', 'RandomCity', 'RandomCountry', '2025-01-04 23:10:28'),
(72, 'User71', 'Last71', 'user71@example.com', '9166517266', '416 Street', 'RandomCity', 'RandomCountry', '2025-01-04 23:10:28'),
(73, 'User72', 'Last72', 'user72@example.com', '3352285067', '424 Street', 'RandomCity', 'RandomCountry', '2025-01-04 23:10:28'),
(74, 'User73', 'Last73', 'user73@example.com', '1194763659', '321 Street', 'RandomCity', 'RandomCountry', '2025-01-04 23:10:28'),
(75, 'User74', 'Last74', 'user74@example.com', '2529946689', '297 Street', 'RandomCity', 'RandomCountry', '2025-01-04 23:10:28'),
(76, 'User75', 'Last75', 'user75@example.com', '7316116920', '762 Street', 'RandomCity', 'RandomCountry', '2025-01-04 23:10:28'),
(77, 'User76', 'Last76', 'user76@example.com', '6236704062', '826 Street', 'RandomCity', 'RandomCountry', '2025-01-04 23:10:28'),
(78, 'User77', 'Last77', 'user77@example.com', '2652327672', '843 Street', 'RandomCity', 'RandomCountry', '2025-01-04 23:10:28'),
(79, 'User78', 'Last78', 'user78@example.com', '4263891972', '598 Street', 'RandomCity', 'RandomCountry', '2025-01-04 23:10:28'),
(80, 'User79', 'Last79', 'user79@example.com', '7143001199', '774 Street', 'RandomCity', 'RandomCountry', '2025-01-04 23:10:28'),
(81, 'User80', 'Last80', 'user80@example.com', '7341997807', '344 Street', 'RandomCity', 'RandomCountry', '2025-01-04 23:10:28'),
(82, 'User81', 'Last81', 'user81@example.com', '5210950304', '570 Street', 'RandomCity', 'RandomCountry', '2025-01-04 23:10:28'),
(83, 'User82', 'Last82', 'user82@example.com', '2930078294', '750 Street', 'RandomCity', 'RandomCountry', '2025-01-04 23:10:28'),
(84, 'User83', 'Last83', 'user83@example.com', '8772937626', '132 Street', 'RandomCity', 'RandomCountry', '2025-01-04 23:10:28'),
(85, 'User84', 'Last84', 'user84@example.com', '0315113012', '758 Street', 'RandomCity', 'RandomCountry', '2025-01-04 23:10:28'),
(86, 'User85', 'Last85', 'user85@example.com', '7030711357', '236 Street', 'RandomCity', 'RandomCountry', '2025-01-04 23:10:28'),
(87, 'User86', 'Last86', 'user86@example.com', '0747501450', '662 Street', 'RandomCity', 'RandomCountry', '2025-01-04 23:10:28'),
(88, 'User87', 'Last87', 'user87@example.com', '0926128105', '472 Street', 'RandomCity', 'RandomCountry', '2025-01-04 23:10:28'),
(89, 'User88', 'Last88', 'user88@example.com', '0868923711', '15 Street', 'RandomCity', 'RandomCountry', '2025-01-04 23:10:28'),
(90, 'User89', 'Last89', 'user89@example.com', '8174400337', '40 Street', 'RandomCity', 'RandomCountry', '2025-01-04 23:10:28'),
(91, 'User90', 'Last90', 'user90@example.com', '7493295769', '625 Street', 'RandomCity', 'RandomCountry', '2025-01-04 23:10:28'),
(92, 'User91', 'Last91', 'user91@example.com', '8803019354', '524 Street', 'RandomCity', 'RandomCountry', '2025-01-04 23:10:28'),
(93, 'User92', 'Last92', 'user92@example.com', '9817708581', '334 Street', 'RandomCity', 'RandomCountry', '2025-01-04 23:10:28'),
(94, 'User93', 'Last93', 'user93@example.com', '7309291621', '648 Street', 'RandomCity', 'RandomCountry', '2025-01-04 23:10:28'),
(95, 'User94', 'Last94', 'user94@example.com', '0517166331', '311 Street', 'RandomCity', 'RandomCountry', '2025-01-04 23:10:28'),
(96, 'User95', 'Last95', 'user95@example.com', '4042538482', '85 Street', 'RandomCity', 'RandomCountry', '2025-01-04 23:10:28'),
(97, 'User96', 'Last96', 'user96@example.com', '2153736950', '819 Street', 'RandomCity', 'RandomCountry', '2025-01-04 23:10:28'),
(98, 'User97', 'Last97', 'user97@example.com', '4538158489', '808 Street', 'RandomCity', 'RandomCountry', '2025-01-04 23:10:28'),
(99, 'User98', 'Last98', 'user98@example.com', '6841381515', '992 Street', 'RandomCity', 'RandomCountry', '2025-01-04 23:10:28'),
(100, 'User99', 'Last99', 'user99@example.com', '9142825146', '590 Street', 'RandomCity', 'RandomCountry', '2025-01-04 23:10:28'),
(101, 'ศุภกฤต', 'บรรจงดัด', 'test@gmail.com', '0930000000', 'testaddress', 'testcity', 'testcountry', '2025-01-04 23:20:44');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `service_id` int(11) NOT NULL,
  `service_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `service_description` text CHARACTER SET utf8 COLLATE utf8_general_ci,
  `service_price` decimal(10,2) DEFAULT NULL,
  `scat_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `service_status` enum('active','inactive') CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT 'active',
  `service_created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`service_id`, `service_name`, `service_description`, `service_price`, `scat_id`, `service_status`, `service_created_at`) VALUES
(1, 'นวดแผนไทย', 'นวดแผนไทยเพื่อผ่อนคลายและกระตุ้นการไหลเวียนโลหิต', '600.00', '1', 'active', '2025-01-06 02:57:23'),
(2, 'นวดน้ำมันอโรมา', 'นวดน้ำมันหอมระเหยเพื่อผ่อนคลายกล้ามเนื้อและบรรเทาความเครียด', '1200.00', '1', 'active', '2025-01-06 02:57:23'),
(3, 'นวดเท้า', 'นวดเท้าเพื่อกระตุ้นจุดสะท้อนและบรรเทาอาการเมื่อยล้า', '500.00', '1', 'active', '2025-01-06 02:57:23'),
(4, 'สปาหน้า', 'ทำทรีตเมนต์บำรุงผิวหน้าให้สดชื่นและกระจ่างใส', '1500.00', '1', 'active', '2025-01-06 02:57:23'),
(5, 'ขัดตัวและพอกผิว', 'สครับขัดผิวและพอกผิวด้วยสมุนไพรธรรมชาติ', '1800.00', '1', 'active', '2025-01-06 02:57:23'),
(6, 'sdf', 'sdf', '0.00', '1', 'active', '2025-01-07 16:30:24'),
(7, 'sdf', 'sdf', '0.00', '1', 'active', '2025-01-07 16:32:17'),
(8, 'sdf', 'sdf', '0.00', '1', 'active', '2025-01-07 16:35:44'),
(9, 'sdf', 'sdf', '0.00', '1', 'active', '2025-01-07 16:36:41'),
(10, 'asd', 'asd', '0.00', '1', 'active', '2025-01-08 12:01:22');

-- --------------------------------------------------------

--
-- Table structure for table `service_category`
--

CREATE TABLE `service_category` (
  `scat_id` int(10) NOT NULL,
  `scat_name` varchar(100) NOT NULL,
  `scat_status` enum('active','inactive') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `service_category`
--

INSERT INTO `service_category` (`scat_id`, `scat_name`, `scat_status`) VALUES
(1, 'สปา', 'active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`adm_id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`course_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`cus_id`),
  ADD UNIQUE KEY `email` (`cus_email`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`service_id`);

--
-- Indexes for table `service_category`
--
ALTER TABLE `service_category`
  ADD PRIMARY KEY (`scat_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `adm_id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `course_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `cus_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `service_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `service_category`
--
ALTER TABLE `service_category`
  MODIFY `scat_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
