-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 18, 2022 at 05:29 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `letooth`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `ID` int(11) NOT NULL,
  `UserName` varchar(255) NOT NULL,
  `PassWord` varchar(255) NOT NULL,
  `FirstName` varchar(255) NOT NULL,
  `MiddleName` varchar(255) NOT NULL,
  `LastName` varchar(255) NOT NULL,
  `EmailAddress` varchar(255) NOT NULL,
  `ContactNumber` varchar(255) NOT NULL,
  `PermanentAddress` text NOT NULL,
  `user_age` varchar(255) NOT NULL,
  `bday` text NOT NULL,
  `sex` varchar(255) NOT NULL,
  `civil_status` varchar(255) NOT NULL,
  `occupation` varchar(255) NOT NULL,
  `UserPhoto` varchar(255) NOT NULL,
  `UserRole` int(11) NOT NULL COMMENT '0 = admin, 1= doctor, 2 = client',
  `UserStatus` int(11) NOT NULL,
  `surgical_type` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`ID`, `UserName`, `PassWord`, `FirstName`, `MiddleName`, `LastName`, `EmailAddress`, `ContactNumber`, `PermanentAddress`, `user_age`, `bday`, `sex`, `civil_status`, `occupation`, `UserPhoto`, `UserRole`, `UserStatus`, `surgical_type`) VALUES
(1, 'letooth@gmail.com', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918', 'Juan', 'Cruz', 'Dela Cruz', 'jancen@gmail.com', '09999637981', 'none', '', '1991-07-06', 'Male', 'Single', '', 'Admin.png', 0, 1, 0),
(23, 'JFontanos@gmail.com', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918', 'Judie', '', 'Fontanos', 'JFontanos@gmail.com', '09564090548', 'Blk. 225 L-7 St. Anne Deca Homes Loma De gato', '', '2001-01-08', 'Female', '', '', 'avatar.png', 2, 1, 0),
(22, 'raymund@gmail.com', '240be518fabd2724ddb6f04eeb1da5967448d7e831c08c8fa822809f74c720a9', 'Raymund', '', 'Almazan', 'raymund@gmail.com', '099040234324', 'ssdasd', '', '', '', '', '', '', 0, 1, 0),
(20, 'KevDebelen1499@gmail.com', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918', 'Devin', 'Tandoc', 'Booker', 'KevDebelen1499@gmail.com', '09169916530', '629, Benita St., Gagalangin, Tondo, Manila', '', '1999-12-14', 'Male', 'Single', '', 'DB.png', 2, 1, 0),
(19, 'Staff1@gmail.com', '80e724da359553161415f27a313bb66d91cac0b0f9627993c6eb0730894aa1b8', 'Staff', 'Staff', 'Sample', 'Staff1@gmail.com', '09564090548', 'Manila, Manila', '', '', '', '', '', 'staff-icon-clipart-2.jpg', 0, 1, 0),
(18, 'GBQuililan@gmail.com', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918', 'Gil Buddy', '', 'Quililan', 'GBQuililan@gmail.com', '09275411012', 'Angeles, Pampanga', '', '', '', '', '', 'angel.jpg', 1, 1, 2),
(17, 'yvesrandolffontanos@gmail.com', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918', 'Client', 'Cortez', 'Sample', 'yvesrandolffontanos@gmail.com', '09564090548', 'Blk. 225 L-7 St. Anne Deca Homes Loma De Gato Marilao, Bulacan.', '', '1998-11-16', 'Male', 'Single', 'IT', 'avatar.png', 2, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `doctor_schedule`
--

CREATE TABLE `doctor_schedule` (
  `ds_id` int(11) NOT NULL,
  `ID` int(11) NOT NULL,
  `invoice_num` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `available_date` text NOT NULL,
  `start_time` varchar(255) NOT NULL,
  `end_time` varchar(255) NOT NULL,
  `sched_status` int(11) NOT NULL COMMENT '0=draft, 1= pending, 2=approved 3= done',
  `doc_rec` text NOT NULL,
  `sched_desc` text NOT NULL,
  `cancel_reason` text NOT NULL,
  `paypal_status` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `doctor_schedule`
--

INSERT INTO `doctor_schedule` (`ds_id`, `ID`, `invoice_num`, `customer_id`, `service_id`, `available_date`, `start_time`, `end_time`, `sched_status`, `doc_rec`, `sched_desc`, `cancel_reason`, `paypal_status`) VALUES
(8, 18, 9552, 17, 25, '2022-07-08', '09:00', '10:00', 3, 'testing for done transaction', 'testing ulit ', '', 1),
(7, 18, 5251, 23, 27, '2022-07-08', '08:00', '09:00', 3, 'jsadjkasdasd', 'testing lang', '', 0),
(6, 18, 7473, 20, 30, '2022-07-07', '08:00', '09:00', 2, 'asdasdasdasdasd', 'sample test only', '', 1),
(9, 18, 183, 23, 31, '2022-07-15', '08:00', '09:00', 3, '', '', '', 0),
(10, 18, 1505, 23, 30, '2022-07-22', '09:00', '10:00', 3, 'Balik ka dito next week at aayusin ko ung ngipin. \r\nbumili ka ng amoxicillin', '', '', 1),
(11, 18, 9738, 23, 31, '2022-07-08', '08:00', '09:00', 2, '', '', '', 0),
(12, 18, 6124, 23, 31, '2022-07-09', '08:00', '09:00', 3, 'testing recommendation for cash', '', '', 0),
(13, 18, 5609, 17, 27, '2022-07-11', '08:00', '09:00', 3, 'testing for recommendations', 'testing ulit', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `inquiries`
--

CREATE TABLE `inquiries` (
  `i_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `inquiry_desc` varchar(255) NOT NULL,
  `available_date` varchar(255) NOT NULL,
  `service_name` varchar(255) NOT NULL,
  `date_created` varchar(255) NOT NULL,
  `inquiry_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `inquiries`
--

INSERT INTO `inquiries` (`i_id`, `client_id`, `doctor_id`, `inquiry_desc`, `available_date`, `service_name`, `date_created`, `inquiry_status`) VALUES
(1, 17, 18, 'Test123', '', '', '2020-03-09 03:17 pm', 1);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `notif_id` int(11) NOT NULL,
  `ds_id` int(11) NOT NULL,
  `notif_status` int(11) NOT NULL,
  `notif_type` int(11) NOT NULL COMMENT 'for 0 = admin, 1= doctor 2=client',
  `notif_user` int(11) NOT NULL,
  `notif_desc` text NOT NULL,
  `notif_date` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`notif_id`, `ds_id`, `notif_status`, `notif_type`, `notif_user`, `notif_desc`, `notif_date`) VALUES
(1, 1, 1, 0, 0, 'Please be informed that there is a client book appointment to this date: 2020-03-09: From: 12:00 pm - 05:00 pm', '2020-03-09 03:19 pm'),
(2, 1, 0, 2, 17, 'Please be informed that your appointment to this date: 2020-03-09: From: 12:00 pm - 03:00 pm already approved by our staff.', '2020-03-09 03:20 pm'),
(3, 1, 0, 1, 18, 'Please be informed that you have an appointment set by our staff on  this date: 2020-03-09: From: 12:00 pm - 03:00 pm', '2020-03-09 03:20 pm'),
(4, 1, 0, 1, 18, 'Please be informed that the customer already paid worth: 5100', '2020-03-09 03:21 pm'),
(5, 1, 1, 2, 17, 'PAYMENT DONE: Please be informed that you have successfully paid the service of your appointment.', '2020-03-09 03:21 pm'),
(6, 2, 0, 0, 0, 'Please be informed that there is a client book appointment to this date: 2022-04-04: From: 01:00 pm - 02:51 pm', '2022-04-02 07:52 pm'),
(7, 2, 1, 2, 23, 'Please be informed that your appointment to this date: 2022-04-04: From: 05:00 pm - 06:51 pm already approved by our staff.', '2022-04-02 07:56 pm'),
(8, 2, 0, 1, 18, 'Please be informed that you have an appointment set by our staff on  this date: 2022-04-04: From: 05:00 pm - 06:51 pm', '2022-04-02 07:56 pm'),
(9, 3, 0, 0, 0, 'Please be informed that there is a client book appointment to this date: 2022-04-18: From: 08:17 am - 09:18 am', '2022-04-18 02:18 pm'),
(10, 3, 0, 2, 23, 'Please be informed that your appointment to this date: 2022-04-18: From: 08:17 am - 09:18 am already approved by our staff.', '2022-04-18 02:21 pm'),
(11, 3, 0, 1, 18, 'Please be informed that you have an appointment set by our staff on  this date: 2022-04-18: From: 08:17 am - 09:18 am', '2022-04-18 02:21 pm'),
(12, 3, 1, 1, 18, 'Please be informed that the customer already paid worth: 890', '2022-04-18 02:22 pm'),
(13, 3, 0, 2, 23, 'PAYMENT DONE: Please be informed that you have successfully paid the service of your appointment.', '2022-04-18 02:22 pm'),
(14, 4, 0, 0, 0, 'Please be informed that there is a client book appointment to this date: 2022-07-07: From: 08:00 am - 09:00 am', '2022-07-06 09:30 am'),
(15, 4, 0, 2, 23, 'Doctor has already set a recommendations / actions required for this service: Done na po bilhin nyo lang po ung mga nirecommend kong gamot', '2022-07-06 09:39 am'),
(16, 4, 0, 0, 0, 'PAYMENT REQUIRED: Please be informed that the doctor set a recommendations and actions required on the service. Please ask the customer regarding the payment.', '2022-07-06 09:39 am'),
(17, 5, 0, 0, 0, 'Please be informed that there is a client book appointment to this date: 2022-07-08: From: 08:00 am - 09:00 am', '2022-07-06 09:42 am'),
(18, 5, 0, 2, 23, 'Please be informed that your appointment to this date: 2022-07-08: From: 08:00 am - 09:00 am already approved by our staff.', '2022-07-06 09:44 am'),
(19, 5, 0, 1, 18, 'Please be informed that you have an appointment set by our staff on  this date: 2022-07-08: From: 08:00 am - 09:00 am', '2022-07-06 09:44 am'),
(20, 6, 1, 0, 0, 'Please be informed that there is a client book appointment to this date: 2022-07-07: From: 08:00 am - 09:00 am', '2022-07-06 12:49 pm'),
(21, 6, 1, 2, 20, 'Please be informed that your appointment to this date: 2022-07-07: From: 08:00 am - 09:00 am already approved by our staff.', '2022-07-06 12:49 pm'),
(22, 6, 0, 1, 18, 'Please be informed that you have an appointment set by our staff on  this date: 2022-07-07: From: 08:00 am - 09:00 am', '2022-07-06 12:49 pm'),
(25, 6, 1, 0, 0, 'Please be informed that Devin Booker was already pay via paypal with the amount of .', '2022-07-06 01:21 pm'),
(26, 6, 1, 0, 0, 'Please be informed that Devin Booker was already pay via paypal with the amount of .', '2022-07-06 01:24 pm'),
(27, 6, 0, 2, 20, 'Doctor has already set a recommendations / actions required for this service: asdasdasdasdasd', '2022-07-06 01:34 pm'),
(28, 6, 0, 0, 0, 'PAYMENT REQUIRED: Please be informed that the doctor set a recommendations and actions required on the service. Please ask the customer regarding the payment.', '2022-07-06 01:34 pm'),
(29, 7, 1, 0, 0, 'Please be informed that there is a client book appointment to this date: 2022-07-08: From: 08:00 am - 09:00 am', '2022-07-07 10:39 am'),
(30, 7, 1, 2, 23, 'Please be informed that your appointment to this date: 2022-07-08: From: 08:00 am - 09:00 am already approved by our staff.', '2022-07-07 10:40 am'),
(31, 7, 0, 1, 18, 'Please be informed that you have an appointment set by our staff on  this date: 2022-07-08: From: 08:00 am - 09:00 am', '2022-07-07 10:40 am'),
(32, 7, 0, 2, 23, 'Doctor has already set a recommendations / actions required for this service: jsadjkasdasd', '2022-07-07 10:47 am'),
(33, 7, 0, 0, 0, 'PAYMENT REQUIRED: Please be informed that the doctor set a recommendations and actions required on the service. Please ask the customer regarding the payment.', '2022-07-07 10:47 am'),
(34, 7, 0, 1, 18, 'Please be informed that the customer already paid worth: 500', '2022-07-07 10:47 am'),
(35, 7, 0, 2, 23, 'PAYMENT DONE: Please be informed that you have successfully paid the service of your appointment.', '2022-07-07 10:47 am'),
(36, 8, 0, 0, 0, 'Please be informed that there is a client book appointment to this date: 2022-07-08: From: 09:00 am - 10:00 am', '2022-07-07 10:54 am'),
(37, 8, 0, 2, 17, 'Please be informed that your appointment to this date: 2022-07-08: From: 09:00 am - 10:00 am already approved by our staff.', '2022-07-07 10:55 am'),
(38, 8, 0, 1, 18, 'Please be informed that you have an appointment set by our staff on  this date: 2022-07-08: From: 09:00 am - 10:00 am', '2022-07-07 10:55 am'),
(39, 8, 0, 0, 0, 'Please be informed that Client Sample was already pay via paypal with the amount of .', '2022-07-07 10:57 am'),
(40, 8, 0, 2, 17, 'Doctor has already set a recommendations / actions required for this service: testing for done transaction', '2022-07-07 11:11 am'),
(41, 8, 0, 0, 0, 'PAYMENT REQUIRED: Please be informed that the doctor set a recommendations and actions required on the service. Please ask the customer regarding the payment.', '2022-07-07 11:11 am'),
(42, 9, 0, 0, 0, 'Please be informed that there is a client book appointment to this date: 2022-07-15: From: 08:00 am - 09:00 am', '2022-07-07 01:24 pm'),
(43, 9, 0, 2, 23, 'Please be informed that your appointment to this date: 2022-07-15: From: 08:00 am - 09:00 am already approved by our staff.', '2022-07-07 01:26 pm'),
(44, 9, 0, 1, 18, 'Please be informed that you have an appointment set by our staff on  this date: 2022-07-15: From: 08:00 am - 09:00 am', '2022-07-07 01:26 pm'),
(45, 10, 0, 0, 0, 'Please be informed that there is a client book appointment to this date: 2022-07-22: From: 09:00 am - 10:00 am', '2022-07-07 01:36 pm'),
(46, 10, 0, 2, 23, 'Please be informed that your appointment to this date: 2022-07-22: From: 09:00 am - 10:00 am already approved by our staff.', '2022-07-07 01:37 pm'),
(47, 10, 0, 1, 18, 'Please be informed that you have an appointment set by our staff on  this date: 2022-07-22: From: 09:00 am - 10:00 am', '2022-07-07 01:37 pm'),
(48, 10, 0, 0, 0, 'Please be informed that Judie Fontanos was already pay via paypal with the amount of .', '2022-07-07 01:38 pm'),
(49, 10, 1, 2, 23, 'Doctor has already set a recommendations / actions required for this service: Balik ka dito next week at aayusin ko ung ngipin. \r\nbumili ka ng amoxicillin', '2022-07-07 01:42 pm'),
(50, 10, 0, 0, 0, 'PAYMENT REQUIRED: Please be informed that the doctor set a recommendations and actions required on the service. Please ask the customer regarding the payment.', '2022-07-07 01:42 pm'),
(51, 11, 0, 0, 0, 'Please be informed that there is a client book appointment to this date: 2022-07-08: From: 08:00 am - 09:00 am', '2022-07-07 04:39 pm'),
(52, 12, 0, 0, 0, 'Please be informed that there is a client book appointment to this date: 2022-07-09: From: 08:00 am - 09:00 am', '2022-07-07 04:40 pm'),
(53, 13, 0, 0, 0, 'Please be informed that there is a client book appointment to this date: 2022-07-11: From: 08:00 am - 09:00 am', '2022-07-08 07:51 pm'),
(54, 13, 0, 2, 17, 'Please be informed that your appointment to this date: 2022-07-11: From: 08:00 am - 09:00 am already approved by our staff.', '2022-07-08 07:55 pm'),
(55, 13, 0, 1, 18, 'Please be informed that you have an appointment set by our staff on  this date: 2022-07-11: From: 08:00 am - 09:00 am', '2022-07-08 07:55 pm'),
(56, 13, 0, 2, 17, 'Doctor has already set a recommendations / actions required for this service: testing for recommendations', '2022-07-08 08:05 pm'),
(57, 13, 0, 0, 0, 'PAYMENT REQUIRED: Please be informed that the doctor set a recommendations and actions required on the service. Please ask the customer regarding the payment.', '2022-07-08 08:05 pm'),
(58, 11, 0, 2, 23, 'Please be informed that your appointment to this date: 2022-07-08: From: 08:00 am - 09:00 am already approved by our staff.', '2022-07-08 08:06 pm'),
(59, 11, 0, 1, 18, 'Please be informed that you have an appointment set by our staff on  this date: 2022-07-08: From: 08:00 am - 09:00 am', '2022-07-08 08:06 pm'),
(60, 12, 0, 2, 23, 'Please be informed that your appointment to this date: 2022-07-09: From: 08:00 am - 09:00 am already approved by our staff.', '2022-07-08 08:06 pm'),
(61, 12, 0, 1, 18, 'Please be informed that you have an appointment set by our staff on  this date: 2022-07-09: From: 08:00 am - 09:00 am', '2022-07-08 08:06 pm'),
(62, 12, 0, 2, 23, 'Doctor has already set a recommendations / actions required for this service: testing recommendation for cash', '2022-07-08 08:08 pm'),
(63, 12, 0, 0, 0, 'PAYMENT REQUIRED: Please be informed that the doctor set a recommendations and actions required on the service. Please ask the customer regarding the payment.', '2022-07-08 08:08 pm'),
(64, 12, 0, 1, 18, 'Please be informed that the customer already paid worth: 890', '2022-07-08 08:10 pm'),
(65, 12, 0, 2, 23, 'PAYMENT DONE: Please be informed that you have successfully paid the service of your appointment.', '2022-07-08 08:10 pm');

-- --------------------------------------------------------

--
-- Table structure for table `payment_transaction`
--

CREATE TABLE `payment_transaction` (
  `pt_id` int(11) NOT NULL,
  `invoice_num` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `transaction_amount` float(10,2) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `oic_id` int(11) NOT NULL,
  `date_created` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment_transaction`
--

INSERT INTO `payment_transaction` (`pt_id`, `invoice_num`, `transaction_amount`, `doctor_id`, `customer_id`, `oic_id`, `date_created`) VALUES
(2, '8882', 890.00, 18, 23, 0, '2022-04-18 02:22 pm'),
(3, '5251', 500.00, 18, 23, 0, '2022-07-07 10:47 am'),
(4, '183', 890.00, 18, 23, 0, '2022-07-07 01:29 pm'),
(5, '6124', 890.00, 18, 23, 0, '2022-07-08 08:10 pm');

-- --------------------------------------------------------

--
-- Table structure for table `reply`
--

CREATE TABLE `reply` (
  `reply_id` int(11) NOT NULL,
  `i_id` int(11) NOT NULL,
  `reply_user` int(11) NOT NULL,
  `inquiry_msg` varchar(255) NOT NULL,
  `date_created` varchar(244) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `reservation`
--

CREATE TABLE `reservation` (
  `reservation_id` int(11) NOT NULL,
  `ds_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `reserve_status` int(11) NOT NULL,
  `service_type` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `reservation_description`
--

CREATE TABLE `reservation_description` (
  `rd_id` int(11) NOT NULL,
  `ds_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `reserve_desc` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `service_id` int(11) NOT NULL,
  `service_photo` varchar(255) NOT NULL,
  `service_name` varchar(255) NOT NULL,
  `category_name` int(11) NOT NULL COMMENT '0surgical 1= none surgical',
  `service_price` float(10,2) NOT NULL,
  `service_desc` text NOT NULL,
  `date_created` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`service_id`, `service_photo`, `service_name`, `category_name`, `service_price`, `service_desc`, `date_created`) VALUES
(31, '', 'ROOT CANAL', 3, 890.00, ' Root canal is a treatment to repair and save badly infected teeth instead of extraction. This treatment is done by removing the infected pulp and nerve in the root of the teeth cleans and shapes the inside of the root canal then fills and seals the space. ', '2022-04-18 09:38 am'),
(32, '', 'IMPACTED TOOTH', 3, 299.00, 'A procedure wherein the dentist will remove the tooth by separating and opening the gums. There are times where it is necessary to remove bone around the tooth. This procedure is common to third molar teeth due to the fact that most of the third molars are embedded under the jaw bone. ', '2022-04-18 09:41 am'),
(30, '', 'TOOTH EXTRACTION', 3, 2000.00, 'Removal of teeth caused by damage, decay or from trauma. Permanent teeth were meant to last a lifetime but there are a number of reasons why tooth extraction may be needed. ', '2022-04-18 09:38 am'),
(29, '', 'Orthodontic Braces Adjustment', 2, 1000.00, 'We only adjust braces of our existing patients', '2022-04-18 09:37 am'),
(28, '', 'Metal Braces', 2, 600.00, 'Known for its durability, this treatment provides fast results with complex cases like over/underbites, crowded, gapped teeth or crooked.  ', '2022-04-18 09:37 am'),
(27, '', 'Orthodontic Braces Installation', 2, 500.00, 'This is for new patients who want to avail our Orthodontic Braces Package. Consultation is FREE if you avail the braces packag', '2022-04-18 09:36 am'),
(26, '', 'Ceramic Braces', 2, 400.00, 'Looking for unnoticeable braces never too late to get those teeth straighten ceramic braces are perfect for you with its high quality material it wouldn’t hurt your gums once you get used to it.  ', '2022-04-18 09:36 am'),
(25, '', 'Dental Restoration', 1, 1000.00, 'Dental restoration is a treatment used to restore the function, integrity and the appearance of your teeth. Prevents tooth movement and improves your oral and overall health. Thanks to a variety of options for dental restoration you have many choices for repairing, worn, decayed, damaged or missing teeth and restoring a healthy and beautiful smile.', '2022-04-12 01:30 pm');

-- --------------------------------------------------------

--
-- Table structure for table `service_category`
--

CREATE TABLE `service_category` (
  `cs_id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `cat_details` varchar(255) NOT NULL,
  `date_created` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `service_category`
--

INSERT INTO `service_category` (`cs_id`, `category_name`, `cat_details`, `date_created`) VALUES
(1, 'Dental Restoration', '', '2022-04-12'),
(2, 'Braces', '', '2022-04-12'),
(3, 'Tooth Ace', '', '2022-04-12'),
(4, 'Teeth Whitening', '', '2022-04-12'),
(5, 'Teeth Cleaning', '', '2022-04-12'),
(6, 'Veneers', '', '2022-04-12'),
(7, 'Consultation', '', '2022-04-12');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `doctor_schedule`
--
ALTER TABLE `doctor_schedule`
  ADD PRIMARY KEY (`ds_id`);

--
-- Indexes for table `inquiries`
--
ALTER TABLE `inquiries`
  ADD PRIMARY KEY (`i_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`notif_id`);

--
-- Indexes for table `payment_transaction`
--
ALTER TABLE `payment_transaction`
  ADD PRIMARY KEY (`pt_id`);

--
-- Indexes for table `reply`
--
ALTER TABLE `reply`
  ADD PRIMARY KEY (`reply_id`);

--
-- Indexes for table `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`reservation_id`);

--
-- Indexes for table `reservation_description`
--
ALTER TABLE `reservation_description`
  ADD PRIMARY KEY (`rd_id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`service_id`);

--
-- Indexes for table `service_category`
--
ALTER TABLE `service_category`
  ADD PRIMARY KEY (`cs_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `doctor_schedule`
--
ALTER TABLE `doctor_schedule`
  MODIFY `ds_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `inquiries`
--
ALTER TABLE `inquiries`
  MODIFY `i_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notif_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `payment_transaction`
--
ALTER TABLE `payment_transaction`
  MODIFY `pt_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `reply`
--
ALTER TABLE `reply`
  MODIFY `reply_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reservation`
--
ALTER TABLE `reservation`
  MODIFY `reservation_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reservation_description`
--
ALTER TABLE `reservation_description`
  MODIFY `rd_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `service_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `service_category`
--
ALTER TABLE `service_category`
  MODIFY `cs_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
