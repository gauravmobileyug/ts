-- phpMyAdmin SQL Dump
-- version 4.3.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 18, 2016 at 05:00 PM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `versetal_ems`
--

-- --------------------------------------------------------

--
-- Table structure for table `ems_users`
--

CREATE TABLE IF NOT EXISTS `ems_users` (
  `id` int(44) NOT NULL,
  `username` varchar(44) NOT NULL,
  `password` varchar(44) NOT NULL,
  `firstname` varchar(44) NOT NULL,
  `lastname` varchar(44) DEFAULT NULL,
  `email` varchar(44) NOT NULL,
  `phone` varchar(44) DEFAULT NULL,
  `status` int(10) DEFAULT NULL,
  `user_type` varchar(10) DEFAULT NULL,
  `user_designation` varchar(10) DEFAULT NULL,
  `profile_pic` varchar(244) DEFAULT NULL,
  `current_status` varchar(44) DEFAULT NULL,
  `timestamp` int(11) DEFAULT NULL,
  `update_timestamp` int(11) DEFAULT NULL,
  `date_added` datetime DEFAULT NULL,
  `date_ended` datetime DEFAULT NULL,
  `date_ended_timestamp` int(11) DEFAULT NULL,
  `gender` varchar(44) DEFAULT NULL,
  `department` varchar(44) DEFAULT NULL,
  `official_email` varchar(44) DEFAULT NULL,
  `emergency_contact` varchar(44) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ems_users`
--

INSERT INTO `ems_users` (`id`, `username`, `password`, `firstname`, `lastname`, `email`, `phone`, `status`, `user_type`, `user_designation`, `profile_pic`, `current_status`, `timestamp`, `update_timestamp`, `date_added`, `date_ended`, `date_ended_timestamp`, `gender`, `department`, `official_email`, `emergency_contact`) VALUES
(3, 'hr', '5405c8c54b6c704f4e7d0fdd943c047d', 'Yashvi', 'Maniar', 'hr@gmail.com', '8881231233', 1, 'H', '3', 'uploads/employee/profile_pics/1469854123_3_hilary_duff_headshot-1789.jpg', 'M', 1468696330, 1469854124, '2016-07-17 00:41:46', NULL, NULL, 'male', '100', NULL, NULL),
(4, 'superadmin', '17c4520f6cfd1ab53d8745e84681eb49', 'Super Admin', '', 'superadmin@gmail.com', '8889999098', 1, 'S', '4', NULL, 'N', 1468696330, NULL, '2016-07-17 00:41:49', NULL, NULL, 'female', '3', NULL, NULL),
(5, '', '', 'Gaurav', 'Sharma', 'dummy@gmail.com', '08897676732', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'male', '1', NULL, NULL),
(6, '', '', 'Gaurav', 'Sharma', 'dummy@gmail.com', '08897676732', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'male', '3', NULL, NULL),
(7, 'gauravm0luc', 'f11cf2df6a2ef442bd10ff65e52be3dc', 'Gaurav', 'Sharma', 'dummy@gmail.com', '08897676732', 1, NULL, NULL, NULL, 'N', 1469814939, NULL, '2016-07-29 07:55:39', NULL, NULL, 'male', '2', NULL, NULL),
(8, 'divya5hy70', 'f11cf2df6a2ef442bd10ff65e52be3dc', 'Gaurav Kumar', 'Sharma', 'gaurav.gn90@gmail.com', '08897676732', 1, NULL, '5', NULL, 'N', 1469815958, 1470480185, '2016-07-29 11:42:38', NULL, NULL, 'male', '2', NULL, NULL),
(9, 'akshay96049', 'f11cf2df6a2ef442bd10ff65e52be3dc', 'Akshay', 'Sharma', 'akshay.kumar@gmail.com', '8826889912', 1, NULL, '5', NULL, 'N', 1470480414, 1470492312, '2016-08-06 04:16:54', NULL, NULL, 'male', '2', 'akshay.kumar@versetal.com', '9989898989'),
(10, 'tim.parker', '33ff20bae0a80ee0929226ee8dad931d', 'Tim', 'Parker', 'tim@gmail.com', '98101201901', 1, NULL, '5', 'uploads/employee/profile_pics/1470930460_10_Photo-0007.jpg', 'M', 1470492642, 1471021619, '2016-08-06 07:40:42', NULL, NULL, 'male', '2', 'tim.parker@versetal.com', '98101201901'),
(11, 'tomas39xg5', 'f11cf2df6a2ef442bd10ff65e52be3dc', 'Tomas', 'Jindal', 'tomas.jindal@personal.com', '08897676732', 1, NULL, '6', NULL, 'N', 1470846733, 1470853639, '2016-08-10 10:02:13', NULL, NULL, 'male', '3', 'tomas.jindal@vis.com', '98101201901'),
(12, 'shivi4i4p', 'f11cf2df6a2ef442bd10ff65e52be3dc', 'Shiv', 'Sharma', 'gaurav.gn90@gmail.com', '08826889912', 1, NULL, '6', NULL, 'M', 1470853809, 1470856615, '2016-08-11 12:00:09', NULL, NULL, 'male', '2', 'gaurav.kumar@onjection.com', '89012991029'),
(13, 'jhsadjahsks6ul', 'f11cf2df6a2ef442bd10ff65e52be3dc', 'jhsadjahs', 'hasjdh', 'ajay@gmail.com', '08897676732', 1, NULL, 'M', NULL, 'M', 1471357730, 1471502630, '2016-08-16 07:58:50', NULL, NULL, 'male', '1', 'ajay@versetal.com', '89012991029');

-- --------------------------------------------------------

--
-- Table structure for table `ems_users_department`
--

CREATE TABLE IF NOT EXISTS `ems_users_department` (
  `id` int(11) NOT NULL,
  `department_code` varchar(44) DEFAULT NULL,
  `department_name` varchar(44) DEFAULT NULL,
  `status` int(10) DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ems_users_department`
--

INSERT INTO `ems_users_department` (`id`, `department_code`, `department_name`, `status`) VALUES
(1, 'account', 'Account', 1),
(2, 'it', 'IT', 1),
(3, 'management', 'Management', 1),
(5, 'test', 'Test', 1),
(6, 'test2', 'Test2', 1),
(7, 'BDM', 'business de', 1);

-- --------------------------------------------------------

--
-- Table structure for table `ems_users_designation`
--

CREATE TABLE IF NOT EXISTS `ems_users_designation` (
  `id` int(10) NOT NULL,
  `user_designation` varchar(44) DEFAULT NULL,
  `user_designation_description` varchar(44) DEFAULT NULL,
  `status` int(10) DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ems_users_designation`
--

INSERT INTO `ems_users_designation` (`id`, `user_designation`, `user_designation_description`, `status`) VALUES
(1, 'A', 'Accountant', 1),
(2, 'AM', 'Account Manager', 1),
(3, 'HA', 'HR Admin', 1),
(4, 'SA', 'Super Admin', 1),
(5, 'SSD', 'Sr. Software Developer', 1),
(6, 'M', 'Manager', 1);

-- --------------------------------------------------------

--
-- Table structure for table `ems_users_extra_details`
--

CREATE TABLE IF NOT EXISTS `ems_users_extra_details` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `dob` varchar(44) DEFAULT NULL,
  `present_address` text,
  `permanent_address` text,
  `education` varchar(255) DEFAULT NULL,
  `comments` text,
  `state` varchar(44) DEFAULT NULL,
  `country` varchar(44) DEFAULT NULL,
  `zipcode` int(11) DEFAULT NULL,
  `bank_details` text,
  `documents` text,
  `pf` varchar(255) DEFAULT NULL,
  `pan` varchar(244) DEFAULT NULL,
  `city` varchar(44) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ems_users_extra_details`
--

INSERT INTO `ems_users_extra_details` (`id`, `user_id`, `dob`, `present_address`, `permanent_address`, `education`, `comments`, `state`, `country`, `zipcode`, `bank_details`, `documents`, `pf`, `pan`, `city`) VALUES
(1, 1, '07/03/2016', '#123 GGN', '#123 adkasjdkaj', 'B.Tech', 'Here is your breif description', 'Haryana', 'India', 122001, NULL, NULL, NULL, NULL, NULL),
(2, 3, '07/01/2016', '#1002 Onjection', '#815 Sec-31', 'M.B.A', 'Breif about myself', 'Delhi', 'India', 11001, NULL, NULL, NULL, NULL, NULL),
(3, NULL, '07/03/2016', 'guergaon', 'aslkdkajsdkj', 'B.Tech', NULL, 'kkaksdjklajsd', 'ajshdjhasjkd', 122001, NULL, NULL, NULL, NULL, NULL),
(4, NULL, '08/01/2016', '#123 Sector 10 Gurgaon', '#123 Sector 10 Gurgaon', 'B.Tech', NULL, 'Haryana', 'India', 122001, NULL, NULL, NULL, NULL, NULL),
(5, NULL, '07/26/2016', 'gurgaon', 'adkaksd', 'B.Tech', NULL, 'Haryana', 'India', 122001, NULL, NULL, NULL, NULL, NULL),
(7, 9, '08/30/1990', '#123 Sector 10 Gurgaon', '#123 Sector 10 Gurgaon', 'B.Tech, M.Tech', NULL, 'Haryana', 'India', 122001, 'a:5:{s:9:"bank_name";s:4:"HDFC";s:14:"account_number";s:23:"ACC-UUUU555612126716277";s:4:"ifsc";s:12:"IFSC-CODE123";s:11:"branch_code";s:12:"B-CODE-12121";s:14:"branch_address";s:12:"#123 Gurgaon";}', 'a:3:{s:10:"user_photo";s:91:"uploads/employee/documents/MTQ3MDQ4MzM2M185XzMyNmVkYjA4YzIyYjM1ODBlMzEyYTk5OWJiODZjOGQ3.jpg";s:11:"user_resume";s:75:"uploads/employee/documents/MTQ3MDQ4MzM2M185X2dhdXJhdl9rdW1hcl9zaGFybWE=.doc";s:10:"user_other";s:135:"uploads/employee/documents/MTQ3MDQ4MzM2M185X0dtYWlsIC0gSW4tUGVyc29uIE1lZXRpbmcgX18gR2F1cmF2IF9fIFBIUCBEZXZlbG9wZXItIEZyZWVsYW5jZXI=.pdf";}', 'PF-009999', 'PAN-121212', 'Gurgaon'),
(8, 10, '02/01/1992', '#123 Sector 10 Gurgaon', '#123 Sector 10 Gurgaon', 'B.Tech, M.Tech', NULL, 'Haryana', 'India', 122001, 'a:5:{s:9:"bank_name";s:3:"IOB";s:14:"account_number";s:18:"293819283912938982";s:4:"ifsc";s:12:"IFSC-CODE123";s:11:"branch_code";s:17:"#21l2kjlkasdjadsk";s:14:"branch_address";s:8:"#Gurgaon";}', 'a:3:{s:10:"user_photo";s:107:"uploads/employee/documents/MTQ3MDQ5Mjc2N18xMF84MjctaW5rZWRfdmVyc2lvbl9vZl9jb29sX2R1ZGVfYnlfY2luX2Npbi0x.jpg";s:11:"user_resume";s:75:"uploads/employee/documents/MTQ3MDQ5Mjc2N18xMF9nYXVyYXZfa3VtYXJfc2hhcm1h.doc";s:10:"user_other";s:135:"uploads/employee/documents/MTQ3MDQ5Mjc2N18xMF9HbWFpbCAtIEluLVBlcnNvbiBNZWV0aW5nIF9fIEdhdXJhdiBfXyBQSFAgRGV2ZWxvcGVyLSBGcmVlbGFuY2Vy.pdf";}', 'PF-009999', 'PAN-ajdkljas', 'Gurgaon'),
(9, 11, '01/08/1992', '#123 Sector 10 Gurgaon', '#123 Sector 10 Gurgaon', 'MBA,B.TECH', NULL, 'Haryana', 'India', 122001, 'a:5:{s:9:"bank_name";s:4:"HDFC";s:14:"account_number";s:17:"10000000788828386";s:4:"ifsc";s:19:"HDF-IFSC-B-C-901920";s:11:"branch_code";s:9:"HDFC09000";s:14:"branch_address";s:25:"#123 Gurgaon Pataudi Road";}', 'a:3:{s:10:"user_photo";s:61:"uploads/employee/documents/1470853639_11_scan_20160602(2).jpg";s:11:"user_resume";s:100:"uploads/employee/documents/1470853639_11_gmail-in-personmeeting__gaurav__phpdeveloper-freelancer.pdf";s:10:"user_other";s:64:"uploads/employee/documents/1470853639_11_gaurav_kumar_sharma.doc";}', 'PF-009999', 'PAN-121212', 'Gurgaon'),
(10, 12, '17/08/1990', '#123 Sector 10 Gurgaon', '#123 Sector 10 Gurgaon', 'MBA,B.TECH', NULL, 'Haryana', 'India', 122001, 'a:5:{s:9:"bank_name";s:4:"HDFC";s:14:"account_number";s:23:"ACC-UUUU555612126716277";s:4:"ifsc";s:12:"IFSC-CODE123";s:11:"branch_code";s:12:"B-CODE-12121";s:14:"branch_address";s:25:"#123 Gurgaon Pataudi Road";}', 'a:3:{s:10:"user_photo";s:55:"uploads/employee/documents/1470854148_12_photo-0007.jpg";s:11:"user_resume";s:64:"uploads/employee/documents/1470853965_12_gaurav_kumar_sharma.doc";s:10:"user_other";s:128:"uploads/employee/documents/1470853965_12_ifsccodeofindianoverseasbanknationalhorticultureboard,gurgaonbranch,haryana,gurgaon.pdf";}', 'PF-009999', 'PAN-121212', 'Gurgaon'),
(11, 13, '13/12/1990', 'guergaon', '#123 Sector 10 Gurgaon', 'B.Tech, M.Tech', NULL, 'Haryana', 'India', 122001, 'a:5:{s:9:"bank_name";s:4:"HDFC";s:14:"account_number";s:23:"ACC-UUUU555612126716277";s:4:"ifsc";s:12:"IFSC-CODE123";s:11:"branch_code";s:12:"B-CODE-12121";s:14:"branch_address";s:12:"#123 Gurgaon";}', 'a:3:{s:10:"user_photo";s:61:"uploads/employee/documents/1471357833_13_scan_20160602(2).jpg";s:11:"user_resume";s:64:"uploads/employee/documents/1471357834_13_gaurav_kumar_sharma.doc";s:10:"user_other";s:128:"uploads/employee/documents/1471357834_13_ifsccodeofindianoverseasbanknationalhorticultureboard,gurgaonbranch,haryana,gurgaon.pdf";}', 'PF-009999', 'PAN-121212', 'gurgaon');

-- --------------------------------------------------------

--
-- Table structure for table `ems_users_misc`
--

CREATE TABLE IF NOT EXISTS `ems_users_misc` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `short_description` varchar(255) DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `status` tinyint(10) DEFAULT '1',
  `date_added` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ems_users_misc`
--

INSERT INTO `ems_users_misc` (`id`, `title`, `short_description`, `file`, `status`, `date_added`) VALUES
(1, 'asdasd', 'asdasd', 'uploads/otheractivity/MTQ3MTI2MTU2M19QaG90by0wMDA3.jpg', 1, '2016-08-15 11:46:03'),
(2, 'Title X', 'Title X', 'uploads/otheractivity/MTQ3MTI2MTYyMl9HbWFpbCAtIEluLVBlcnNvbiBNZWV0aW5nIF9fIEdhdXJhdiBfXyBQSFAgRGV2ZWxvcGVyLSBGcmVlbGFuY2Vy.pdf', 1, '2016-08-15 11:47:02'),
(3, 'askjdklj', 'askjdklj', 'uploads/otheractivity/MTQ3MTUwMjc5M19JRlNDIGNvZGUgb2YgSW5kaWFuIE92ZXJzZWFzIEJhbmsgTmF0aW9uYWwgSG9ydGljdWx0dXJlIEJvYXJkLCBHdXJnYW9uIGJyYW5jaCwgSEFSWUFOQSwgR1VSR0FPTg==.pdf', 1, '2016-08-18 06:46:33');

-- --------------------------------------------------------

--
-- Table structure for table `ems_users_notification`
--

CREATE TABLE IF NOT EXISTS `ems_users_notification` (
  `id` int(44) NOT NULL,
  `user_id` int(44) DEFAULT NULL,
  `title` varchar(44) DEFAULT NULL,
  `body` text,
  `date_added` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` int(11) DEFAULT '0',
  `read` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ems_users_policies`
--

CREATE TABLE IF NOT EXISTS `ems_users_policies` (
  `id` int(11) NOT NULL,
  `title` varchar(244) DEFAULT NULL,
  `short_description` text,
  `long_description` text,
  `file` varchar(244) DEFAULT NULL,
  `save` tinyint(1) DEFAULT '1',
  `publish` tinyint(1) DEFAULT '0',
  `date_added` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `date_modified` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ems_users_policies`
--

INSERT INTO `ems_users_policies` (`id`, `title`, `short_description`, `long_description`, `file`, `save`, `publish`, `date_added`, `date_modified`) VALUES
(1, 'Versetal Information', 'Humar resource policy short information ', '<h1><b><u></u></b></h1>\r\n\r\n<b>How to use:</b><p>Exactly like the original bootstrap tabs except you should use the custom wrapper<code>.nav-tabs-custom</code>&nbsp;to achieve this style.</p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart. I am alone, and feel the charm of existence in this spot, which was created for the bliss of souls like mine. I am so happy, my dear friend, so absorbed in the exquisite sense of mere tranquil existence, that I neglect my talents. I should be incapable of drawing a single stroke at the present moment; and yet I feel that I never was a greater artist than now.\r\n\r\n<div></div><div><b><u><br></u></b></div>', 'uploads/hr/09-08-16/MTQ3MDc2MDg4MF9HbWFpbCAtIEluLVBlcnNvbiBNZWV0aW5nIF9fIEdhdXJhdiBfXyBQSFAgRGV2ZWxvcGVyLSBGcmVlbGFuY2Vy.pdf', 1, 1, '2016-08-12 14:36:07', '2016-08-12 14:36:07'),
(2, 'Policy Title Name', 'Employee Policy Short Description', '<h1><b><u>Hi This is gaurav</u></b></h1><div><b><u>\r\n\r\nHi This is gaurav\r\n\r\n<br></u></b></div><div>\r\n\r\nHi This is gaurav\r\n\r\n<br></div><div>\r\n\r\nHi This is gaurav\r\n\r\n<br></div><div>\r\n\r\nHi This is gaurav\r\n\r\n<br></div><div>\r\n\r\nHi This is gaurav\r\n\r\n<br></div><div>\r\n\r\nHi This is gaurav\r\n\r\n<br></div><div>\r\n\r\nHi This is gaurav\r\n\r\n<br></div><div>\r\n\r\nHi This is gaurav\r\n\r\n\r\n\r\nHi This is gaurav\r\n\r\n<br></div><div>\r\n\r\nHi This is gaurav\r\n\r\n<br></div><div>\r\n\r\nHi This is gaurav\r\n\r\n<br></div><div>\r\n\r\nHi This is gaurav\r\n\r\n<br></div><div>\r\n\r\nHi This is gaurav\r\n\r\n<br></div>', NULL, 1, 1, '2016-08-10 16:17:15', '2016-08-10 16:17:15'),
(3, 'Test title', 'test short description', '<p><b>test logn text description</b></p>', NULL, 1, 0, '2016-08-12 15:18:29', '2016-08-11 18:22:00');

-- --------------------------------------------------------

--
-- Table structure for table `ems_users_salary_settings`
--

CREATE TABLE IF NOT EXISTS `ems_users_salary_settings` (
  `id` int(11) NOT NULL,
  `key` varchar(44) DEFAULT NULL,
  `value` varchar(44) DEFAULT NULL,
  `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ems_users_salary_settings`
--

INSERT INTO `ems_users_salary_settings` (`id`, `key`, `value`, `timestamp`) VALUES
(1, 'hra', '40', '2016-08-02 16:08:27'),
(3, 'epf', '12', '2016-08-02 16:08:33');

-- --------------------------------------------------------

--
-- Table structure for table `ems_users_salary_slips`
--

CREATE TABLE IF NOT EXISTS `ems_users_salary_slips` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `month` int(10) DEFAULT NULL,
  `year` int(11) DEFAULT NULL,
  `salary_slip` varchar(244) DEFAULT NULL,
  `date_added` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ems_users_salary_slips`
--

INSERT INTO `ems_users_salary_slips` (`id`, `user_id`, `month`, `year`, `salary_slip`, `date_added`) VALUES
(1, 9, 1, 2017, 'uploads/employee/salary_slips/MTQ3MDQ5MDQwNl85X0dtYWlsIC0gSW4tUGVyc29uIE1lZXRpbmcgX18gR2F1cmF2IF9fIFBIUCBEZXZlbG9wZXItIEZyZWVsYW5jZXI=.pdf', '2016-08-06 13:33:26'),
(2, 9, 2, 2017, 'uploads/employee/salary_slips/MTQ3MDQ5MDQ1MV85X0dtYWlsIC0gSW4tUGVyc29uIE1lZXRpbmcgX18gR2F1cmF2IF9fIFBIUCBEZXZlbG9wZXItIEZyZWVsYW5jZXI=.pdf', '2016-08-06 13:34:11'),
(3, 9, 8, 2016, 'uploads/employee/salary_slips/MTQ3MDQ5MDkxNl85X0dtYWlsIC0gSW4tUGVyc29uIE1lZXRpbmcgX18gR2F1cmF2IF9fIFBIUCBEZXZlbG9wZXItIEZyZWVsYW5jZXI=.pdf', '2016-08-06 13:41:56'),
(4, 9, 1, 2016, 'uploads/employee/salary_slips/MTQ3MDQ5MTIzMF85X0dtYWlsIC0gSW4tUGVyc29uIE1lZXRpbmcgX18gR2F1cmF2IF9fIFBIUCBEZXZlbG9wZXItIEZyZWVsYW5jZXI=.pdf', '2016-08-06 13:47:10'),
(5, 10, 8, 2016, 'uploads/employee/salary_slips/MTQ3MTAyMjc3MF8xMF9HbWFpbC1Jbi1QZXJzb25NZWV0aW5nX19HYXVyYXZfX1BIUERldmVsb3Blci1GcmVlbGFuY2Vy.pdf', '2016-08-12 17:26:10');

-- --------------------------------------------------------

--
-- Table structure for table `ems_users_salary_structure`
--

CREATE TABLE IF NOT EXISTS `ems_users_salary_structure` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `salary_type` varchar(44) DEFAULT NULL,
  `basic` decimal(12,2) DEFAULT NULL,
  `hra` decimal(12,2) DEFAULT NULL,
  `special_allowance` decimal(12,2) DEFAULT NULL,
  `conveyance` decimal(12,2) DEFAULT NULL,
  `bonus` decimal(12,2) DEFAULT NULL,
  `misc_rewards` decimal(12,2) DEFAULT NULL,
  `income_tax` decimal(12,2) DEFAULT NULL,
  `epf` decimal(12,2) DEFAULT NULL,
  `total_earning` decimal(12,2) DEFAULT NULL,
  `total_tax` decimal(12,2) DEFAULT NULL,
  `total_deductions` decimal(12,2) DEFAULT NULL,
  `net_pay` decimal(12,2) DEFAULT NULL,
  `paid_days` int(11) DEFAULT NULL,
  `pay_period` varchar(44) DEFAULT NULL,
  `status` int(10) DEFAULT '1',
  `date_added` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `slip_sent` int(10) DEFAULT '0',
  `month` int(10) DEFAULT NULL,
  `paid` int(10) DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ems_users_salary_structure`
--

INSERT INTO `ems_users_salary_structure` (`id`, `user_id`, `salary_type`, `basic`, `hra`, `special_allowance`, `conveyance`, `bonus`, `misc_rewards`, `income_tax`, `epf`, `total_earning`, `total_tax`, `total_deductions`, `net_pay`, `paid_days`, `pay_period`, `status`, `date_added`, `slip_sent`, `month`, `paid`) VALUES
(1, 8, 'monthly', '25000.00', '10000.00', '0.00', '0.00', '0.00', '0.00', '2500.00', '3000.00', '35000.00', '2500.00', '3000.00', '29500.00', 30, '08/03/2016 - 08/31/2016', 1, '2016-08-03 18:30:17', 0, 8, 0),
(2, 8, 'monthly', '24000.00', '10000.00', '0.00', '0.00', '0.00', '0.00', '1200.00', '3000.00', '34000.00', '1200.00', '3000.00', '35000.00', 30, '09/03/2016 - 09/31/2016', 1, '2016-08-03 18:31:00', 0, 7, 0),
(3, 8, 'monthly', '30000.00', '12000.00', '0.00', '0.00', '0.00', '0.00', '1300.00', '4000.00', '4000.00', '3200.00', '4000.00', '45000.00', 31, '10/03/2016 - 10/31/2016', 1, '2016-08-03 18:31:03', 0, 9, 0),
(4, 10, 'monthly', '50000.00', '20000.00', '0.00', '0.00', '0.00', '0.00', '10000.00', '6000.00', '70000.00', '10000.00', '6000.00', '54000.00', 30, '08/12/2016 - 08/12/2016', 1, '2016-08-13 09:15:16', 0, 8, 1);

-- --------------------------------------------------------

--
-- Table structure for table `ems_users_status`
--

CREATE TABLE IF NOT EXISTS `ems_users_status` (
  `id` int(11) NOT NULL,
  `user_id` int(44) DEFAULT NULL,
  `from_status` varchar(44) DEFAULT NULL,
  `current_status` varchar(44) DEFAULT NULL,
  `comments` text,
  `timestamp` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ems_users_status`
--

INSERT INTO `ems_users_status` (`id`, `user_id`, `from_status`, `current_status`, `comments`, `timestamp`) VALUES
(1, 1, 'N', 'N', 'New Joining', NULL),
(2, 3, 'M', 'M', 'Permanent', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ems_users_status_description`
--

CREATE TABLE IF NOT EXISTS `ems_users_status_description` (
  `id` int(11) NOT NULL,
  `status` varchar(11) DEFAULT NULL,
  `status_description` varchar(44) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ems_users_status_description`
--

INSERT INTO `ems_users_status_description` (`id`, `status`, `status_description`) VALUES
(1, 'N', 'New Joining'),
(2, 'P', 'Probation'),
(3, 'M', 'Permanent '),
(4, 'R', 'Resigned '),
(5, 'T', 'Terminated ');

-- --------------------------------------------------------

--
-- Table structure for table `ems_users_timesheet`
--

CREATE TABLE IF NOT EXISTS `ems_users_timesheet` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `submit` int(11) DEFAULT '1',
  `date_added` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `date_updated` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ems_users_timesheet`
--

INSERT INTO `ems_users_timesheet` (`id`, `user_id`, `submit`, `date_added`, `date_updated`) VALUES
(1, 10, 2, '2016-08-14 15:54:43', '2016-08-14 15:54:43');

-- --------------------------------------------------------

--
-- Table structure for table `ems_users_timesheet_description`
--

CREATE TABLE IF NOT EXISTS `ems_users_timesheet_description` (
  `id` int(11) NOT NULL,
  `sheet_id` int(11) DEFAULT NULL,
  `ticket_number` varchar(44) DEFAULT NULL,
  `client_name` varchar(44) DEFAULT NULL,
  `time` varchar(44) DEFAULT NULL,
  `description` text
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ems_users_timesheet_description`
--

INSERT INTO `ems_users_timesheet_description` (`id`, `sheet_id`, `ticket_number`, `client_name`, `time`, `description`) VALUES
(57, 1, 'T900909123', 'USA', '08:30 PM', 'Complete'),
(58, 1, 'TJKL90099', 'JAPAN', '08:35 AM', 'Yet to be done'),
(59, 1, 'T566777', 'Australia', '07:15 AM', 'Here is description'),
(60, 1, 'JHJ89990', 'Canada', '06:20 PM', 'Here is descriptions 2');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ems_users`
--
ALTER TABLE `ems_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ems_users_department`
--
ALTER TABLE `ems_users_department`
  ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `department_code` (`department_code`);

--
-- Indexes for table `ems_users_designation`
--
ALTER TABLE `ems_users_designation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ems_users_extra_details`
--
ALTER TABLE `ems_users_extra_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ems_users_misc`
--
ALTER TABLE `ems_users_misc`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ems_users_notification`
--
ALTER TABLE `ems_users_notification`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ems_users_policies`
--
ALTER TABLE `ems_users_policies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ems_users_salary_settings`
--
ALTER TABLE `ems_users_salary_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ems_users_salary_slips`
--
ALTER TABLE `ems_users_salary_slips`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ems_users_salary_structure`
--
ALTER TABLE `ems_users_salary_structure`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ems_users_status`
--
ALTER TABLE `ems_users_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ems_users_status_description`
--
ALTER TABLE `ems_users_status_description`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ems_users_timesheet`
--
ALTER TABLE `ems_users_timesheet`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ems_users_timesheet_description`
--
ALTER TABLE `ems_users_timesheet_description`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ems_users`
--
ALTER TABLE `ems_users`
  MODIFY `id` int(44) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `ems_users_department`
--
ALTER TABLE `ems_users_department`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `ems_users_designation`
--
ALTER TABLE `ems_users_designation`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `ems_users_extra_details`
--
ALTER TABLE `ems_users_extra_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `ems_users_misc`
--
ALTER TABLE `ems_users_misc`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `ems_users_notification`
--
ALTER TABLE `ems_users_notification`
  MODIFY `id` int(44) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ems_users_policies`
--
ALTER TABLE `ems_users_policies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `ems_users_salary_settings`
--
ALTER TABLE `ems_users_salary_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `ems_users_salary_slips`
--
ALTER TABLE `ems_users_salary_slips`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `ems_users_salary_structure`
--
ALTER TABLE `ems_users_salary_structure`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `ems_users_status`
--
ALTER TABLE `ems_users_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `ems_users_status_description`
--
ALTER TABLE `ems_users_status_description`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `ems_users_timesheet`
--
ALTER TABLE `ems_users_timesheet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `ems_users_timesheet_description`
--
ALTER TABLE `ems_users_timesheet_description`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=61;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
