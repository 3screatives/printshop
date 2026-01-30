-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 30, 2026 at 09:15 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `stma_printing`
--

-- --------------------------------------------------------

--
-- Table structure for table `ps_clients`
--

CREATE TABLE `ps_clients` (
  `client_id` int(11) NOT NULL,
  `business_name` varchar(150) NOT NULL,
  `business_address` text DEFAULT NULL,
  `contact_name` varchar(150) NOT NULL,
  `contact_phone` varchar(20) DEFAULT NULL,
  `contact_email` varchar(100) DEFAULT NULL,
  `client_since` date NOT NULL DEFAULT current_timestamp(),
  `client_stma_id` int(11) DEFAULT NULL,
  `tax_exempt` tinyint(1) NOT NULL DEFAULT 0,
  `tax_exempt_id` int(11) DEFAULT NULL,
  `is_employee` tinyint(1) NOT NULL DEFAULT 0,
  `is_cost_price` tinyint(1) NOT NULL DEFAULT 0,
  `client_username` varchar(64) NOT NULL,
  `client_password` varchar(64) NOT NULL,
  `client_status` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ps_clients`
--

INSERT INTO `ps_clients` (`client_id`, `business_name`, `business_address`, `contact_name`, `contact_phone`, `contact_email`, `client_since`, `client_stma_id`, `tax_exempt`, `tax_exempt_id`, `is_employee`, `is_cost_price`, `client_username`, `client_password`, `client_status`, `user_id`) VALUES
(1, 'Sajjad Ali', '', 'Sajjad Ali', '9255249439', '', '0000-00-00', 0, 0, 0, 0, 1, '', '', 0, NULL),
(2, 'Xpress Burger', '10446 I-37, Corpus Christi, TX 78410', '', '6308632649', 'contact@xpressburgers.com', '0000-00-00', 2644, 0, 0, 0, 0, '', '', 0, NULL),
(3, 'Race Auto Sales - North Location', '12023 San Pedro Ave, San Antonio, TX 78216', '', '7133195692', 'darediasameer@yahoo.com', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(4, 'Culturingua', '', '', '4078739959', 'moath.alseid@gmail.com', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(5, 'Shipley Donuts', '7875 Kitty Hawk Rd, Converse, TX 78109', '', '2108402733', 'zakirmehmood2002@yahoo.com', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(6, 'Breaktime', '942 Kitty Hawk \nUniversal City 78148', 'Shakib Badarpura', '2109354704', '', '0000-00-00', 0, 0, 0, 1, 0, '', '', 0, NULL),
(7, 'Cedar Creek Country Store', '', '', '7133662725', '', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(8, 'Kwik Pantry', '101 TX-359, Mathis, TX 78368', '', '2102864171', 'kwikpantrymathis@gmail.com', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(9, 'Junction Travel Center', '', '', '2108654097', '', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(10, 'Nawaz Hudda', '', 'Nawaz Hudda', '7183007658', 'nawazhudda26@gmail.com', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(11, 'Selvagiri Arunagiri', '', 'Selvagiri Arunagiri', '2109045052', '', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(12, 'Fuel Port #4', '', '', '2103883092', '', '0000-00-00', 3425, 0, 0, 0, 0, '', '', 0, NULL),
(13, 'Buzz Liquor & Smoke', '', '', '7138849016', 'smokenshop6010@gmail.com', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(14, 'Sam Makani', '', 'Sam Makani', '2108879769', '', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(15, 'J Mini Mart', '6603 Connie Mack Street', '', '3463178396', '', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(16, 'Potranco Food Mart', '', '', '2819898044', 'affan18@gmail.com', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(17, 'Noordin', '', 'Noordin', '2104136557', '', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(18, 'Friends Food Mart', '', '', '2105892152', '', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(19, 'Carryon Vance Jackson', '2602 Northwest Loop 410\nSan Antonio, TX 78230', '', '2106128837', 'carryon2602@gmail.com', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(20, 'Breaktime 2', '11110 I-35N \nSan Antonio Tx 78233', 'Jesan Badarpura', '6103290851', 'breaktime2i35@gmail.com', '0000-00-00', 3402, 0, 0, 0, 0, '', '', 0, NULL),
(21, 'Oasis Market (Nacogdoches)', '11210 Nacogdoches Rd\nSan Antonio, TX 78217', '', '2109800907', '', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(22, 'Zippy Express', '', '', '2106853011', 'lineageoperatonsllc@gmail.com', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(23, 'Get N Go', '795 N INTERSTATE 35\nCOTULLA TX 78014', '', '2818719576', '', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(24, 'Rafik Momin', '', 'Rafik Momin', '2102046128', '', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(25, 'Barrett Food Mart', '-', '', '2107377017', '', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(26, 'Dilley Express', '17294 S Interstate Hwy 35, Dilley, TX 78017', '', '7133445526', '', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(27, 'Jessica Aguirre', 'Jessica.Aguirre@itgbrands.com', 'Jessica Aguirre', '', '', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(28, 'Amin Jiwani', '', 'Amin Jiwani', '2103914786', '', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(29, 'Ahmed Badarpura', '', 'Ahmed Badarpura', '2107250315', '', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(30, 'Bharat Gajera', '', 'Bharat Gajera', '2103810678', '', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(31, 'Earthly Green Essentials ', '', '', '8305497302', 'rhysknoll@gmail.com', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(32, 'Amerigo\'s Mart', '4105 Gardendale, San Antonio, TX 78229', '', '8326334108', '', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(33, 'Select Stop #7', '5175 Martinez Converse Rd, Converse, TX 78109', '', '5129626236', 'user@email.com', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(34, 'Akber', '', 'Akber', '2108850354', '', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(35, 'Kerrville Express Mart', '#1442', '', '5122990362', '', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(36, 'High Time', '5935 Rittman Rd', 'Jassad Momin', '8303578201', '', '0000-00-00', 2854, 0, 0, 0, 0, '', '', 0, NULL),
(37, 'Brandon Fickel', '', 'Brandon Fickel', '8304561522', '', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(38, 'Z Mart', '', '', '2106391906', '', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(39, 'Salim Momin', '', 'Salim Momin', '2105486483', 'smomin40@hotmail.com', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(40, 'Big Country', '5617 E Evans Road,\nSan Antonio, TX 78261', '', '', 'kmanbigs@gmail.com', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(41, 'San Antonio Tamil School', '', 'Goms', '2672397585', '', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(42, 'Riyaz Momin', '', 'Riyaz Momin', '5129058287', '', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(43, 'STMA Printing', '12054 Starcrest drive, San Antonio, Texas 78247', '', '2109076124', 'printing@mystma.com', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(44, 'Anthony Fish and Chicken', '2403 E Commerce St site 102, San Antonio, TX 78203', 'Nael Shadouh', '2106423450', 'naelshadouh@icloud.com', '0007-01-25', 0, 0, 0, 0, 0, '', '', 0, NULL),
(45, 'Quest Fuel', '12054 Starcrest drive, San Antonio, Texas 78247', '', '2106321894', '', '0007-01-25', 0, 0, 0, 0, 0, '', '', 0, NULL),
(46, 'Thuggizzle Water LLC.', '', '', '5129104998', 'thuggizzlewater@gmail.com', '0007-01-25', 0, 0, 0, 0, 0, '', '', 0, NULL),
(47, 'Good Stop', '', '', '', '', '0007-01-25', 0, 0, 0, 0, 0, '', '', 0, NULL),
(48, 'Ahad Aly', '', 'Ahad Aly', '8322876582', '786ahadal@gmail.com', '0007-01-25', 0, 0, 0, 0, 0, '', '', 0, NULL),
(49, 'Eisenhauer food mart', '', 'Ahad Aly', '8322876582', '786ahadal@gmail.com', '0007-01-25', 0, 0, 0, 0, 0, '', '', 0, NULL),
(50, 'Laundry R US', '', 'Nooru Lalani', '2105443209', '', '0007-10-25', 2720, 0, 0, 0, 0, '', '', 0, NULL),
(51, 'Sammy', '', 'Sammy', '2102517854', '', '0007-11-25', 0, 0, 0, 0, 0, '', '', 0, NULL),
(52, 'Double Up Novelty ', '', '', '', '', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(53, 'Pik N Pak', '', '', '', '', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(54, 'Ruiz Mart', '', '', '3055428076', '', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(55, 'Shell Food Mart', '', '', '4094661276', '', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(56, 'Bigs 408', '', '', '2104540220', '', '0000-00-00', 1223, 0, 0, 0, 0, '', '', 0, NULL),
(57, 'Saif Momin', '', 'Saif Momin', '2107979392', 'SaifSMomin@outlook.com', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(58, 'Rio Grande', '', '', '2108232908', '', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(59, 'San Antonio Tamil School', '', 'Sivakumar Veeramani', '6082166577', 'avsiva@gmail.com', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(60, 'Viva Life', '', '', '5598713639', '', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(61, 'Dragon Tacos ', '', 'Sam Makani', '', '', '0000-00-00', 1122, 0, 0, 0, 0, '', '', 0, NULL),
(62, 'Grill House Burgers', '', 'Karim Lalani', '2102844247', 'ghburgers150@gmail.com', '0008-04-25', 0, 0, 0, 0, 0, '', '', 0, NULL),
(63, 'Zins Liquor Smoke', '', 'Karim Lalani', '2102844247', '', '0008-04-25', 0, 0, 0, 0, 0, '', '', 0, NULL),
(64, 'Salti', '', 'Altaf Merchant', '2102367467', 'salti@sacstx.com', '0008-05-25', 0, 0, 0, 0, 0, '', '', 0, NULL),
(65, 'Airport Xpress', '', '', '8325204469', 'dhukaasif@yahoo.com', '0008-06-25', 0, 0, 0, 0, 0, '', '', 0, NULL),
(66, 'Converse Star Grocery', '', '', '5127921461', 'conversegrocery@gmail.com', '0008-08-25', 0, 0, 0, 0, 0, '', '', 0, NULL),
(67, 'Yumm #5', '', '', '2106397710', 'alex@yummmarkets.com', '0008-08-25', 1440, 0, 0, 0, 0, '', '', 0, NULL),
(68, 'Sam D', '', 'Sam D', '6823339373', '', '0008-08-25', 0, 0, 0, 0, 0, '', '', 0, NULL),
(69, 'Karim Lalani', '', 'Karim Lalani', '2102844247', '', '0008-08-25', 0, 0, 0, 0, 0, '', '', 0, NULL),
(70, 'Imran Momin', '', 'Imran Momin', '', '', '0008-11-25', 0, 0, 0, 1, 0, '', '', 0, NULL),
(71, 'Healthy Paws & Co', '', 'Jasmine Amlani', '2105692678', 'jasmineamlani@gmail.com', '0008-12-25', 0, 0, 0, 0, 0, '', '', 0, NULL),
(72, 'Minute Run', '', '', '7379008144', 'akif_prasla@yahoo.com', '0008-12-25', 0, 0, 0, 0, 0, '', '', 0, NULL),
(73, 'Shop N Save', '', '', '7858456643', 'mackamin2000@yahoo.com', '0008-12-25', 0, 0, 0, 0, 0, '', '', 0, NULL),
(74, 'Time Out', '', 'Amin Charania', '7858456643', 'mackamin2000@yahoo.com', '0008-12-25', 0, 0, 0, 0, 0, '', '', 0, NULL),
(75, 'SA Vape N Smoke', '', '', '2104647474', 'apumotijheel@sbcglobal.net', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(76, 'Smokin Aces', '', '', '2102575686', 'smokinaces623@gmail.com', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(77, 'Regal Pantry', '', 'Amin Jiwani', '2103914786', '', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(78, 'Andy\'s Ice House', '', '', '2107447866', 'bandeali23@gmail.com', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(79, 'The Laundry Depot', '', '', '', '', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(80, 'Suds-N-More', '', '', '5129930633', '', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(81, 'Sabiya Nizar', '', 'Sabiya Nizar', '2106495153', '', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(82, 'Texas Meat N Grocery', '', 'Amin Khan Surani', '7262200046', '', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(83, 'Greenway Grocery', '', '', '', '', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(84, 'A Cloud Life', '', '', '2107259536', 'ajfromny357@gmail.com', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(85, 'Remy Investment', '', '', '2107108993', 'aminvmohamed@gmail.com', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(86, 'Mariposa Groceries', '', '', '4015565468', '', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(87, 'Zapco #13', '', '', '4097180223', 'zapcotx13@gmail.com', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(88, 'Shop In Go', '', '', '2107101595', 'meheralipatel0@gmail.com', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(89, 'The Austinite Market', '', '', '', 'mosaicmueller1033@gmail.com', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(90, 'Texan Sizzle', '', '', '2106061727', 'lvotion@gmail.com', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(91, 'Pik Nik #3', '', '', '2106395078', 'akicharolia@yahoo.com', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(92, 'Rafiq Patel', '', 'Rafiq Patel', '8329647825', '', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(93, 'Vape Time', '', '', '9019308499', '', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(94, 'Roosevelt Convenience Store', '', '', '2102644490', '', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(95, 'Rodeo Travel Center #2', '109963 I-37\nPleasanton, TX 78064', '', '7262066086', '', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(96, 'Market Stand', '', 'Shafiq Pirani', '5629655716', '', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(97, 'Rafiq Walibhai', '', 'Rafiq Walibhai', '2103678603', 'walibhai71@gmail.com', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(98, 'Gordo\'s Travel Center', '', '', '4058125742', 'fvpatel1985@gmail.com', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(99, 'Bigs 103', '', '', '', 'bigs103786@gmail.com', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(100, 'The Creamery at South Park', '2310 SW Military Dr.\nSuite #532-A\nSan Antonio, TX 78224', 'Aslam Ramazanali', '2102744050', 'aram786@gmail.com', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(101, 'James Matthews', '', 'James Matthews', '2103238087', 'james.matthews2099@gmail.com', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(102, 'Rodeo Travel center # 5', '1631 Hwy 123 svc Road Seguin, TX 78155', '', '5127311941', 'rodeotc5@gmail.com', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(103, 'Hi-Way 87 Stop', '', '', '2103930333', '', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(104, 'Smoke Oasis', '', 'Zeeshan Momin', '8328771372', '', '0009-02-25', 0, 0, 0, 0, 0, '', '', 0, NULL),
(105, 'Short Stop #35', '', 'Robert Bou Daher', '2105779775', '', '0009-02-25', 0, 0, 0, 0, 0, '', '', 0, NULL),
(106, 'Naail Ali', '', 'Naail Ali', '2106836564', 'naailali2k@gmail.com', '0009-02-25', 0, 0, 0, 0, 1, '', '', 0, NULL),
(107, 'Firoza Dhalla', '', 'Firoza Dhalla', '2102748806', 'firoza.dhalla@gmail.com', '0009-02-25', 0, 0, 0, 0, 0, '', '', 0, NULL),
(108, 'A Max', '', '', '2107259033', '', '0009-03-25', 1321, 0, 0, 0, 0, '', '', 0, NULL),
(109, 'The Buzz Hive', '', '', '8159787512', 'nic.federico28@gmail.com', '0009-03-25', 0, 0, 0, 0, 0, '', '', 0, NULL),
(110, 'Orange Leaf Bandera 103', '', 'Mehru Lalani', '', 'orangeleafbandera103@gmail.com', '0009-04-25', 0, 0, 0, 0, 0, '', '', 0, NULL),
(111, 'Souvlaki Grill', '', '', '', 'moath.alseid@gmail.com', '0009-04-25', 0, 0, 0, 0, 0, '', '', 0, NULL),
(112, 'Saiyed Ali', '', 'Saiyed Ali', '2105894554', '', '0009-04-25', 0, 0, 0, 0, 0, '', '', 0, NULL),
(113, 'Bigs 108', '', '', '4047176578', '', '0009-04-25', 0, 0, 0, 0, 0, '', '', 0, NULL),
(114, 'Wicked Smoke & Vape', '', 'Shayan Amlani', '2103173397', 'jasmineamlani@gmail.com', '0009-05-25', 0, 0, 0, 0, 0, '', '', 0, NULL),
(115, 'Sabs Threading & Beauty', '', '', '2109006802', '', '0009-05-25', 0, 0, 0, 0, 0, '', '', 0, NULL),
(116, 'Food Basket #4', '4148 FM 725	NEW BRAUNFELS	TX	78130', '', '2819759206', '', '0009-08-25', 0, 0, 0, 0, 0, '', '', 0, NULL),
(117, 'Tex Mex Food Mart', '', '', '2103938889', 'agilani1406@yahoo.com', '0009-08-25', 0, 0, 0, 0, 0, '', '', 0, NULL),
(118, 'Countryside Ice', '', 'Shawn Barolia', '2107249739', 'shawnbarolia@yahoo.com', '0009-08-25', 0, 0, 0, 0, 0, '', '', 0, NULL),
(119, 'NYS', '', '', '2108726667', '', '0009-11-25', 0, 0, 0, 0, 0, '', '', 0, NULL),
(120, 'SA Food Mart', '', '', '2103782331', 'salti@sacstx.com', '0009-11-25', 0, 0, 0, 0, 0, '', '', 0, NULL),
(121, 'Goliad Express', '2709 Goliad Rd', '', '2107145239', '', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(122, 'Blue Lotus Smoke LLC', '', '', '2109154153', '', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(123, 'Thelma Food Store #3027', '', '', '2108469603', '', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(124, 'Prince Store', '', '', '2109800907', 'princegrocery@yahoo.com', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(125, 'Hussain Rajab', '', 'Hussain Rajab', '8323754161', '', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(126, 'Nihrir Kadiwal', '', 'Nihrir Kadiwal', '2107631263', '', '0000-00-00', 0, 0, 0, 1, 0, '', '', 0, NULL),
(127, 'Seguin Store LLC', '', '', '2817011295', '', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(128, 'Halftime', '', '', '2107250315', '', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(129, 'Hancock Minimart', '', 'Zeeshan Momin', '8328771372', '', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(130, 'Band of Brothers', '', '', '2109311101', 'kray@bandofbrotherscbd.com', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(131, 'Bigs #306/Halftime #14', '', '', '2107898358', 'saiyedali77@yahoo.com', '0000-00-00', 1422, 0, 0, 0, 0, '', '', 0, NULL),
(132, 'APlus Sani', '', 'James Herrera', '2103245777', 'aplussani@gmail.com', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(133, 'Zeeshan Virani', '', 'Zeeshan Virani', '2105896086', 'zvirani99@gmail.com', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(134, 'Roadster #23', '', '', '2817011295', 'roadsterstore23@gmail.com', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(135, 'Bigs #305/Halftime #11', '', '', '8329706872', 'adeelprasla@yahoo.com', '0000-00-00', 1375, 0, 0, 0, 0, '', '', 0, NULL),
(136, 'All Star Gaming', '', '', '6823339373', '', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(137, 'Chicken & Liquor', '', 'Shamshu Lakhani', '2106394252', 'lak09@yahoo.com', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(138, 'Nizar Maredia', '', 'Nizar Maredia', '2109959556', '', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(139, 'Palo Alto Express', '', '', '2105002296', '', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(140, 'Orange Leaf Rolling Oaks', '', 'Nazleen Bidiwala', '4053149738', '', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(141, 'On The Go', '', '', '3466422876', '', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(142, 'Perry\'s Food Mart', '', '', '7378774828', '', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(143, 'Nora Salon & Suites', '', '', '2109866011', 'connect@norasalonsuites.com', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(144, 'Roadster Travel Center & Truck Stop', '', '', '2107979392', 'roadsterlytle@gmail.com', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(145, 'Bell Express', '', '', '2107108993', 'jubilee2025@gmail.com', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(146, 'Mega Shop', '', '', '2106639739', '', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(147, 'Mathanasium', '', 'Reshma Maredia', '2106396687', 'reshmamaredia@gmail.com', '2010-01-25', 0, 0, 0, 0, 0, '', '', 0, NULL),
(148, 'Max Mart #2', '', '', '2106639739', '', '2010-01-25', 0, 0, 0, 0, 0, '', '', 0, NULL),
(149, 'Sol Hudda', '', 'Sol Hudda', '2106858875', 'shrealtor@gmail.com', '2010-01-25', 0, 0, 0, 0, 0, '', '', 0, NULL),
(150, 'Cotulla Brothers', '', '', '2103916844', 'cotullabrothers@gmail.com', '2010-02-25', 0, 0, 0, 0, 0, '', '', 0, NULL),
(151, 'Blanco Food Mart', '', '', '7139551533', 'blanco21887@gmail.com', '2010-03-25', 0, 0, 0, 0, 0, '', '', 0, NULL),
(152, 'Fluffy Haus Pet Grooming', '', 'Vivian Jones', '9562441921', 'vivianjones05@outlook.com', '2010-03-25', 0, 0, 0, 0, 0, '', '', 0, NULL),
(153, 'STMA Warehouse', '', '', '2106726006', '', '2010-06-25', 0, 0, 0, 0, 0, '', '', 0, NULL),
(154, 'Market @ Stone Oak', '', '', '2109541001', '2025busybee@gmail.com', '2010-07-25', 0, 0, 0, 0, 0, '', '', 0, NULL),
(155, 'Bigs #107/Halftime #13', '', '', '2104540220', '', '2010-08-25', 2309, 0, 0, 0, 0, '', '', 0, NULL),
(156, 'Halftime #3', '', '', '', '', '2010-08-25', 3289, 0, 0, 0, 0, '', '', 0, NULL),
(157, 'Bigs #211/Halftime #6', '', '', '', '', '2010-08-25', 2552, 0, 0, 0, 0, '', '', 0, NULL),
(158, 'Bigs #301/Halftime #7', '', '', '', '', '2010-08-25', 1188, 0, 0, 0, 0, '', '', 0, NULL),
(159, 'Bigs #304/Halftime #8', '', '', '', '', '2010-08-25', 2127, 0, 0, 0, 0, '', '', 0, NULL),
(160, 'Bigs #102/Halftime #9', '', '', '', '', '2010-08-25', 2364, 0, 0, 0, 0, '', '', 0, NULL),
(161, 'Bigs #101/Halftime #10', '', '', '', '', '2010-08-25', 2363, 0, 0, 0, 0, '', '', 0, NULL),
(162, 'Bigs #108/Halftime #12', '', '', '', '', '2010-08-25', 2027, 0, 0, 0, 0, '', '', 0, NULL),
(163, 'Coyote Express #2', '\n1602 W Commerce St, San Antonio, TX 78207', '', '', '', '2010-09-25', 0, 0, 0, 0, 0, '', '', 0, NULL),
(164, 'Nizari FCU', '', '', '', '', '2010-09-25', 0, 0, 0, 0, 0, '', '', 0, NULL),
(165, 'Jamatkhana', '', '', '', '', '2010-10-25', 0, 0, 0, 0, 1, '', '', 0, NULL),
(166, 'Smoke @ Canyon', '', '', '2105447059', '', '2010-10-25', 0, 0, 0, 0, 0, '', '', 0, NULL),
(167, 'Pipe creek market', '11696 State Highway 16 S\nPipe Creek, TX 78063-5351', '', '5406458813', 'Jparwana123@yahoo.com', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(168, 'India Association of San Antonio (IASA)', '9114 Summer Wind St, San Antonio, TX 78217', '', '2109006618', 'president@indiasa.org', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(169, 'Comal Food Mart', '', '', '7133445526', 'pearsallstorellc@gmail.com', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(170, 'Little Sam #2', '4802 Rittiman Rd', 'Hussain Datu', '7274886333', 'momeen2@hotmail.com', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(171, 'Select Stop #8', '', '', '9.77971E+12', '', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(172, 'SA Food Mart INC', '1902 Stedwick Dr. TX 78251', '', '2102860550', 'safoodmart2011@yahoo.com', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(173, 'Jays Way Food Mart', '', '', '2102862991', '', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(174, 'One Price Cleaners', '', 'Naail Barolia', '2104210093', 'naailbarolia@gmail.com', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(175, 'Neighbors Market', '', 'Waseem', '5128888738', 'snmarket758@gmail.com', '0000-00-00', 3483, 0, 0, 0, 0, '', '', 0, NULL),
(176, 'Race Auto Sales - WW White Location', '831 S WW White Rd, San Antonio, TX 78220', 'Sameer Daredia', '7133195692', 'darediasameer@yahoo.com', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(177, 'Shop N Shop', '', '', '2105443209', '', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(178, 'J&A Grocery', '', '', '2109952602', '', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(179, 'Exotic Greens', '', '', '2104640595', 'bgrayfm78@gmail.com', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(180, 'Quick Mart', '', '', '8329648619', '', '0000-00-00', 2807, 0, 0, 0, 0, '', '', 0, NULL),
(181, 'Tamasha', '', '', '4704487331', '', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(182, 'AJ\'s Liquor', '', 'Amin Jiwani', '2103914786', '', '2011-04-25', 3061, 0, 0, 0, 0, '', '', 0, NULL),
(183, 'Amazing Stop', '', 'Kahir Charolia', '2106395078', '', '2011-04-25', 2953, 0, 0, 0, 0, '', '', 0, NULL),
(184, 'Shaheen Fahim', '', 'Shaheen Fahim', '2108681075', '', '2011-04-25', 0, 0, 0, 0, 0, '', '', 0, NULL),
(185, 'SA Tamil Sangam', '', '', '4142499758', 'karthikeyanrd@gmail.com', '2011-05-25', 0, 0, 0, 0, 0, '', '', 0, NULL),
(186, 'Kwik Corner #2', '', '', '2109540431', 'quickcorner2@gmail.com', '2011-05-25', 0, 0, 0, 0, 0, '', '', 0, NULL),
(187, 'Smoke Zone', '6203 S Zarzamora St. SA 78211', '', '2108871140', '', '2011-06-25', 0, 0, 0, 0, 0, '', '', 0, NULL),
(188, 'West Avenue CK Services LLC', '', '', '2109540017', 'westavecheck@gmail.com', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(189, 'Madiha Qazi', '', 'Madiha Qazi', '2107399735', '', '0000-00-00', 0, 0, 0, 1, 0, '', '', 0, NULL),
(190, 'A Big Cloud Vape', '', '', '2102844247', 'zineeystexas@gmail.com', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(191, 'Step N Go', '', '', '2105002296', '', '0000-00-00', 3098, 0, 0, 0, 0, '', '', 0, NULL),
(192, 'Beautiful Angel Fitness LLC', '', 'Faizullah Kerai', '2104093844', 'faizullah.kerai@gmail.com', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(193, 'Shirdi Sai Baba Temple of San Antonio', '', 'KV', '8176577738', 'shirdisaitemplesa@gmail.com', '0000-00-00', 0, 1, 465305496, 0, 0, '', '', 0, NULL),
(194, 'Cotulla Corner Stop', '', '', '2088749401', 'cotullabrothers@gmail.com', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(195, 'Expressway', '', '', '2105447059', '', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(196, 'ARSLN', '', 'Mahek Arsalan', '8328552422', 'contact.arslnco@gmail.com', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(197, 'The Nest Boba', '6903 Blanco Rd, San Antonio, TX 78216', 'Mehru Lalani', '2107784193', 'info@thenestboba.com', '2012-01-25', 0, 0, 0, 0, 0, '', '', 0, NULL),
(198, 'Neighbors Market', '', '', '', 'militaryneighborsmarket@gmail.com', '2012-01-25', 0, 0, 0, 0, 0, '', '', 0, NULL),
(199, 'Mushis', '', 'Zeeshan Momin', '8328771372', '', '2012-01-25', 0, 0, 0, 0, 0, '', '', 0, NULL),
(200, 'Orion Wireless', '', 'Ali Bhojani', '2105487459', 'orionwireless22@gmail.com', '2012-02-25', 0, 0, 0, 0, 0, '', '', 0, NULL),
(201, 'High Roller Smoke & Play', '', '', '2107636546', '', '2012-02-25', 0, 0, 0, 0, 0, '', '', 0, NULL),
(202, 'Eatery', '', '', '5122933208', '4915foster@gmail.com', '2012-03-25', 0, 0, 0, 0, 0, '', '', 0, NULL),
(203, 'Easy Stop', '', '', '2107447866', 'bandeali23@gmail.com', '2012-03-25', 3490, 0, 0, 0, 0, '', '', 0, NULL),
(204, 'C Mart', 'Houston Tx', '', '', '', '2012-04-25', 0, 0, 0, 0, 0, '', '', 0, NULL),
(205, 'North Star Grocery', '', '', '2106438555', '', '2012-04-25', 0, 0, 0, 0, 0, '', '', 0, NULL),
(206, 'Fuel Port #1', '', '', '2107607286', '', '2012-05-25', 2992, 0, 0, 0, 0, '', '', 0, NULL),
(207, 'Spice Fine Indian Cuisine', '', '', '7134940006', 'spicefineindiancuisine@gmail.com', '2012-08-25', 0, 0, 0, 0, 0, '', '', 0, NULL),
(208, 'Central Laundromat', '', 'Ahmed Badarpura', '2107250315', 'abadarpura@gmail.com', '2012-08-25', 0, 0, 0, 0, 0, '', '', 0, NULL),
(209, 'Potranco Corner Store', '', '', '2103789894', 'ptcornerstore@gmail.com', '2012-08-25', 1315, 0, 0, 0, 0, '', '', 0, NULL),
(210, 'San Food Mart #1', '', 'Kahir Charolia', '2106395078', '', '2012-09-25', 0, 0, 0, 0, 0, '', '', 0, NULL),
(211, 'San Pedro Food Mart', '', '', '2105484146', 'sanpedro802llc@gmail.com', '2012-09-25', 0, 0, 0, 0, 0, '', '', 0, NULL),
(212, 'Mehaboob Karovalia', '19 Honor CV, Sugarland, TX 77498', 'Mehaboob Karovalia', '8327552749', 'bobkarovalia@gmail.com', '2012-10-25', 0, 0, 0, 0, 0, '', '', 0, NULL),
(213, 'Midtown Food Mart', '3201 S College Ave, Bryan, TX 77891', '', '9792556045', 'store65@yahoo.com', '2012-10-25', 0, 0, 0, 0, 0, '', '', 0, NULL),
(214, 'Fortune Amusement', '', '', '3477387685', 'aliubvani222@gmail.com', '2012-10-25', 0, 0, 0, 0, 0, '', '', 0, NULL),
(215, 'Noor Grocery', '', '', '2107444393', 'mohsin61288@gmail.com', '2012-11-25', 0, 0, 0, 0, 0, '', '', 0, NULL),
(216, 'Umqua Valley Financial', '', 'Faiez Farishta', '7185988020', 'faiez@oregoncpas.com', '2012-12-25', 0, 0, 0, 0, 0, '', '', 0, NULL),
(217, 'Southwest 786', '', '', '2102606781', 'soh1162@yahoo.com', '2012-12-25', 0, 0, 0, 0, 0, '', '', 0, NULL),
(218, 'Fast Trip', '', '', '9012750686', 'artusallc@gmail.com', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(219, 'Prompt Urgent Care', '', '', '7135607061', 'promptuc@gmail.com', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(220, 'Sam Food Mart', '', '', '3522176589', '', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(221, '83 Fuel Stop', '', '', '2108437867', '', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(222, 'Bigs Laundromat', '', '', '2104540220', '', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(223, 'Andhra Avenue', '', '', '', 'anjangoli@gmail.com', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(224, 'Zaara Kalwani', '', 'Zaara Kalwani', '3473001313', '', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(225, 'Brazos Food Mart', '', '', '2108879769', '', '0000-00-00', 1122, 0, 0, 0, 0, '', '', 0, NULL),
(226, 'Thousand Oak Food Mart', '', 'Amirali Momin', '8324952320', 'mominamirali@yahoo.com', '0000-00-00', 3640, 0, 0, 0, 0, '', '', 0, NULL),
(227, 'El Bocca', '', '', '2108612800', 'jeffsomani@gmail.com', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(228, 'Shree Swaminarayan Gurukul USA', ' ', '', '8702255713', '', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(229, 'Kwik Food Pantry', '', 'Riyaz Momin', '5129058287', 'riyazhmomin@hotmail.com', '0000-00-00', 1117, 0, 0, 0, 0, '', '', 0, NULL),
(230, 'Kachow Motors', '799 I 35 N Frontage Rd, New Braunfels, TX 78130', 'Sameer Daredia', '7133195692', '', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(231, 'Zeeshan Momin', '', 'Zeeshan Momin', '8328771372', '', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(232, 'Nourishment', '', '', '8302712003', 'nnvendingmachines@gmail.com', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(233, 'Mustakali Mahesaniya', '', 'Mustakali Mahesaniya', '2105447059', '', '0000-00-00', 0, 0, 0, 1, 0, '', '', 0, NULL),
(234, 'Viva Life', '', 'Dru Goulart', '2106271031', 'dru@myvivalifecare.com', '0001-02-26', 0, 0, 0, 0, 0, '', '', 0, NULL),
(235, 'Chital Travel Center', '2308 Ray Hubbard Way\nWylie, TX 75098', '', '4697733324', 'sabukandel@gmail.com', '0001-05-26', 0, 0, 0, 0, 0, '', '', 0, NULL),
(236, 'Chas Market & Kitchen', '', '', '2102271521', 'chasgrocery@yahoo.com', '0001-05-26', 0, 0, 0, 0, 0, '', '', 0, NULL),
(237, 'Simmon\'s Grocery', '3808 FM 1008\nDayton, TX 77535', '', '9362582623', 'zikhan56@yahoo.com', '0001-05-26', 0, 0, 0, 0, 0, '', '', 0, NULL),
(238, 'Caldwell Venture LLC', '', 'Sharif Badarpura', '5122990362', 'sharif1234@gmail.com', '0001-06-26', 0, 0, 0, 0, 0, '', '', 0, NULL),
(239, 'Hotbox Smoke Shop', '', 'Jawed Zulfiqar', '2104180157', '', '0001-08-26', 0, 0, 0, 0, 0, '', '', 0, NULL),
(240, 'Quick Stuff', '', '', '2819759206', '', '0001-12-26', 0, 0, 0, 0, 0, '', '', 0, NULL),
(241, '410 Corner Stop', '', 'Kahir Charolia', '2106395078', '', '0000-00-00', 1392, 0, 0, 0, 0, '', '', 0, NULL),
(242, 'Stop N Joy', '', 'Husseinali Esmail', '2104456072', '', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(243, 'Maharjan Subash', '824 Westerkirk Dr\nCelina, TX 75009', 'Maharjan Subash', '7139923795', 'Maharjansubash777@gmail.com', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(244, 'Doranda Sirjue', '', 'Doranda Sirjue', '', '', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(245, 'Camco Market Gas and Delivery Food', '', '', '5122937065', '', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(246, 'Greenlight Distribution', '', 'Emily Isenberg', '2107482402', 'emily.isenberg@greenlightdistribution.com', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(247, 'The Villager Grocery', '630 QUITMAN ST\nPITTSBURG, TX 75686', '', '7752214042', 'kamikapoor1984@gmail.com', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(248, 'Camco Market Gas and Delivery Food', '', '', '5122937065', '', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(249, 'Greenlight Distribution', '', '', '2107482402', '', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL),
(250, 'The Villager Grocery', '630 QUITMAN ST\nPITTSBURG, TX 75686', '', '7752214042', 'kamikapoor1984@gmail.com', '0000-00-00', 0, 0, 0, 0, 0, '', '', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ps_homepage_categories`
--

CREATE TABLE `ps_homepage_categories` (
  `cat_id` int(11) NOT NULL,
  `is_visible` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ps_homepage_categories`
--

INSERT INTO `ps_homepage_categories` (`cat_id`, `is_visible`) VALUES
(1, 1),
(8, 1),
(10, 1),
(14, 1),
(28, 1),
(39, 1),
(40, 1),
(41, 1);

-- --------------------------------------------------------

--
-- Table structure for table `ps_materials`
--

CREATE TABLE `ps_materials` (
  `mat_id` int(11) NOT NULL,
  `mat_vendor` varchar(64) DEFAULT NULL,
  `mat_name` varchar(255) NOT NULL,
  `mat_type` enum('large','digital') NOT NULL,
  `mat_details` text DEFAULT NULL,
  `mat_roll_size` int(11) NOT NULL,
  `mat_length` int(11) NOT NULL,
  `mat_size` int(11) NOT NULL,
  `mat_cost` decimal(10,6) NOT NULL,
  `mat_cost_multiplier` decimal(5,2) NOT NULL,
  `ink_cost` decimal(10,6) NOT NULL,
  `mat_added_on` date NOT NULL DEFAULT curdate()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ps_materials`
--

INSERT INTO `ps_materials` (`mat_id`, `mat_vendor`, `mat_name`, `mat_type`, `mat_details`, `mat_roll_size`, `mat_length`, `mat_size`, `mat_cost`, `mat_cost_multiplier`, `ink_cost`, `mat_added_on`) VALUES
(1, 'Grimco', 'Acrylic - Clear', 'large', 'CC4896316C - Duratex Cast Acrylic 48\" x 96\", Clear, 3/16\"', 60, 120, 120, 172.190000, 3.00, 0.003400, '2026-01-21'),
(2, 'Grimco', 'Acrylic - White', 'large', 'CC4896316W7328 - Duratex Cast Acrylic 48\" x 96\", White 7328, 3/16\"', 60, 120, 120, 184.370000, 3.25, 0.003400, '2026-01-21'),
(3, 'Lexjet', 'Adhesive', 'large', '4WM66A - HP Prime Matte Air GP, 3.4 Mil', 54, 150, 1800, 217.070000, 3.50, 0.003400, '2026-01-21'),
(4, 'Grimco', 'Aluminum', 'large', 'MM843MWDP - MAXMETAL™ 4\' x 8\', White DP, EACH', 60, 120, 120, 86.320000, 3.11, 0.003400, '2026-01-21'),
(5, 'Lexjet', 'Backlit', 'large', 'KBLGS60 - Kodak glossy backlit film', 60, 100, 1200, 300.000000, 3.45, 0.003400, '2026-01-21'),
(6, 'Clampitt', 'Banner Gloss', 'large', '86005371	Maxbanner Gloss, 13oz	54\"x164\'', 54, 164, 1968, 124.200000, 3.27, 0.003400, '2026-01-21'),
(7, 'Clampitt', 'Banner Matte', 'large', '8600537	Maxbanner Matte, 13oz	54\"x164\'', 54, 164, 1968, 124.200000, 3.27, 0.003400, '2026-01-21'),
(8, 'Lexjet', 'Bond Paper', 'large', 'Canon Economy Bond Paper (75gsm)', 36, 200, 2400, 109.610000, 1.50, 0.003400, '2026-01-21'),
(9, 'Lexjet', 'Clear Adhesive', 'large', 'GF 206-54 - Clear Gloss Vinyl, Removeable', 54, 150, 1800, 230.000000, 3.20, 0.003400, '2026-01-21'),
(10, 'Clampitt', 'Coroplast', 'large', '58263908	Centrlplas 60x120-4mm	60\"x120\"', 60, 120, 120, 13.250000, 5.62, 0.003400, '2026-01-21'),
(11, 'Grimco', 'Floor Sticker', 'large', 'OLFL-30954, Briteline Floor Film Overlaminate - OLFL309 54 \" x 150 \'', 54, 150, 1800, 368.990000, 3.00, 0.003400, '2026-01-21'),
(12, 'Reece Supply', 'Foam Board', 'large', 'Pn 122718 - 3/16 White Foam Board', 48, 96, 96, 15.130000, 4.45, 0.003400, '2026-01-21'),
(13, 'Lexjet', 'Polyester', 'large', '142SGC30\r\n - LexJet Clear Polyester SUV - 30in x 100ft', 30, 100, 1200, 229.000000, 3.00, 0.003400, '2026-01-21'),
(14, 'Lexjet', 'Polypropylene', 'large', 'ERWP36200 - LexJet Heavyweight WR Polypropylene - 36in x 200ft', 36, 200, 2400, 106.250000, 3.15, 0.003400, '2026-01-21'),
(15, 'Grimco', 'Polystyrene 020', 'large', 'HIPS60XC0X020W, Duratex Polystyrene Sheets - Double White 60\" x 120\", .020\"', 60, 120, 120, 15.380000, 4.10, 0.003400, '2026-01-21'),
(16, 'Grimco', 'Polystyrene 040', 'large', 'HIPS60XC0X040W, Duratex Polystyrene Sheets - Double White 60\" x 120\", .040\"', 60, 96, 120, 30.750000, 4.05, 0.003400, '2026-01-21'),
(17, 'Lexjet', 'Static Cling', 'large', '207-5415 - GF-207 Clear', 54, 150, 1800, 260.090000, 3.10, 0.003400, '2026-01-21'),
(18, 'Reece Supply', 'Window Perforated', 'large', 'Pn 55599 - UltraVision Window Perf 60/40 UV 6.3 Mil', 54, 164, 1968, 326.830000, 4.20, 0.003400, '2026-01-21'),
(19, 'Clampitt', 'Magnet', 'large', '860145 - Newlife Magnetics 48x50ft 15mil', 48, 50, 600, 177.000000, 3.00, 0.003400, '2026-01-21'),
(20, 'Clampitt', 'Matte - Paper - Thin', 'digital', 'Accent Opaque Smooth - 60lb Matte Text', 9, 0, 11, 0.016010, 1.00, 0.043000, '2026-01-21'),
(21, 'Clampitt', 'Matte - Paper - Standard', 'digital', 'Accent Opaque Smooth - 80lb Matte Text', 13, 0, 19, 0.070940, 1.00, 0.043000, '2026-01-21'),
(22, 'Clampitt', 'Matte - Paper - Thick', 'digital', 'Accent Opaque Smooth - 100lb Matte Text', 13, 0, 19, 0.088670, 1.00, 0.043000, '2026-01-21'),
(23, 'Clampitt', 'Matte - Cardstock - Thin', 'digital', 'Accent Opaque Smooth - 80lb Matte Cover', 13, 0, 19, 0.132150, 1.00, 0.043000, '2026-01-21'),
(24, 'Clampitt', 'Matte - Cardstock - Standard', 'digital', 'Accent Opaque Smooth - 100lb Matte Cover', 13, 0, 19, 0.154710, 1.00, 0.043000, '2026-01-21'),
(25, 'Clampitt', 'Matte - Cardstock - Thick', 'digital', 'Accent Opaque Smooth - 110lb Matte Cover', 9, 0, 11, 0.185530, 1.00, 0.043000, '2026-01-21'),
(26, 'Clampitt', 'Gloss - Paper - Standard', 'digital', 'Blazer - 80lb Gloss Text', 13, 0, 19, 0.071970, 1.00, 0.043000, '2026-01-21'),
(27, 'Clampitt', 'Gloss - Paper - Thick', 'digital', 'Blazer - 100lb Gloss Text', 13, 0, 19, 0.080440, 1.00, 0.043000, '2026-01-21'),
(28, 'Clampitt', 'Gloss - Cardstock - Thin', 'digital', 'Blazer - 80lb Gloss Cover', 13, 0, 19, 0.119290, 1.00, 0.043000, '2026-01-21'),
(29, 'Clampitt', 'Gloss - Cardstock - Standard', 'digital', 'Blazer - 100lb Gloss Cover', 13, 0, 19, 0.149080, 1.00, 0.043000, '2026-01-21'),
(30, 'Clampitt', 'Gloss - Cardstock - Thick', 'digital', 'Blazer - 110lb Gloss Cover', 13, 0, 19, 0.183460, 1.00, 0.043000, '2026-01-21'),
(31, 'Clampitt', 'Gloss - Cardstock - Regular', 'digital', '10pt White Tango Coated C2S Board - 87lb Gloss Cover', 13, 0, 19, 0.168730, 1.00, 0.043000, '2026-01-21'),
(32, 'Office Depot', 'A9 Envelopes', 'digital', '', 6, 0, 9, 0.170000, 1.00, 0.043000, '2026-01-21'),
(33, 'Office Depot', '#10 Envelopes', 'digital', '', 4, 0, 10, 0.070000, 1.00, 0.043000, '2026-01-21'),
(34, 'Uline', 'Catalog Envelope', 'digital', '', 10, 0, 13, 0.240000, 1.00, 0.043000, '2026-01-21'),
(35, 'Lexjet', '4ups - Removeable', 'digital', '', 4, 0, 6, 0.400000, 1.00, 0.043000, '2026-01-21'),
(36, 'Desktop Supplies', '4ups - Permanent', 'digital', '', 4, 0, 6, 0.140000, 1.00, 0.043000, '2026-01-21'),
(37, 'Online Labels', 'Small Labels', 'digital', '', 1, 0, 2, 0.030000, 1.00, 0.043000, '2026-01-21'),
(38, 'Online Labels', 'Round Labels', 'digital', '', 2, 0, 2, 0.040000, 1.00, 0.043000, '2026-01-21'),
(39, '', 'Shelf Strips', 'digital', '', 9, 0, 11, 0.185530, 1.00, 0.043000, '2026-01-21');

-- --------------------------------------------------------

--
-- Table structure for table `ps_material_categories`
--

CREATE TABLE `ps_material_categories` (
  `cat_id` int(11) NOT NULL,
  `cat_name` varchar(100) NOT NULL,
  `cat_description` text DEFAULT NULL,
  `cat_image` varchar(255) DEFAULT NULL,
  `cat_slug` varchar(255) NOT NULL,
  `cat_group` varchar(100) NOT NULL DEFAULT '',
  `cat_section` varchar(100) DEFAULT '',
  `cat_order` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ps_material_categories`
--

INSERT INTO `ps_material_categories` (`cat_id`, `cat_name`, `cat_description`, `cat_image`, `cat_slug`, `cat_group`, `cat_section`, `cat_order`) VALUES
(1, 'Business Cards', '', 'business-cards', 'business-cards', 'Digital Print', 'Business & Office', 1),
(2, 'Envelopes', '', 'envelopes', 'envelopes', 'Digital Print', 'Business & Office', 2),
(3, 'Handbooks', '', 'handbooks', 'handbooks', 'Digital Print', 'Business & Office', 3),
(4, 'Letterhead', '', 'letterhead', 'letterhead', 'Digital Print', 'Business & Office', 4),
(5, 'Presentation Sheets', '', 'presentation-sheets', 'presentation-sheets', 'Digital Print', 'Business & Office', 5),
(6, 'Binder Tags', '', 'binder-tags', 'binder-tags', 'Digital Print', 'Labels & Stickers', 1),
(7, 'Hang Tags', '', 'hang-tags', 'hang-tags', 'Digital Print', 'Labels & Stickers', 2),
(8, 'Product Labels', '', 'product-labels', 'product-labels', 'Digital Print', 'Labels & Stickers', 3),
(9, 'Tabs', '', 'tabs', 'tabs', 'Digital Print', 'Labels & Stickers', 4),
(10, 'Booklets', '', 'booklets', 'booklets', 'Digital Print', 'Marketing & Promotions', 1),
(11, 'Brochures', '', 'brochures', 'brochures', 'Digital Print', 'Marketing & Promotions', 2),
(12, 'Calendars', '', 'calendars', 'calendars', 'Digital Print', 'Marketing & Promotions', 3),
(13, 'Door Hangers', '', 'door-hangers', 'door-hangers', 'Digital Print', 'Marketing & Promotions', 4),
(14, 'Flyers', '', 'flyers', 'flyers', 'Digital Print', 'Marketing & Promotions', 5),
(15, 'Inserts', '', 'inserts', 'inserts', 'Digital Print', 'Marketing & Promotions', 6),
(16, 'Menu Cards', '', 'menu-cards', 'menu-cards', 'Digital Print', 'Marketing & Promotions', 7),
(17, 'Post Cards', '', 'post-cards', 'post-cards', 'Digital Print', 'Marketing & Promotions', 8),
(18, 'Photo Prints', '', 'photo-prints', 'photo-prints', 'Digital Print', 'Photo & Presentation', 1),
(19, 'Proof Prints', '', 'proof-prints', 'proof-prints', 'Digital Print', 'Photo & Presentation', 2),
(20, 'Price Tags', '', 'price-tags', 'price-tags', 'Digital Print', 'Retail Print', 1),
(21, 'Shelf Strips', '', 'shelf-strips', 'shelf-strips', 'Digital Print', 'Retail Print', 2),
(22, 'Lobby Signs', '', 'lobby-signs', 'lobby-signs', 'Large Format', 'Acrylic & Premium', 1),
(23, 'Point-of-Sale Displays', '', 'point-of-sale-displays', 'point-of-sale-displays', 'Large Format', 'Acrylic & Premium', 2),
(24, 'Lightbox Inserts', '', 'lightbox-inserts', 'lightbox-inserts', 'Large Format', 'Backlit & Illuminated', 1),
(25, 'Outdoor Large Lightboxes', '', 'outdoor-large-lightboxes', 'outdoor-large-lightboxes', 'Large Format', 'Backlit & Illuminated', 2),
(26, 'Event Displays', '', 'event-displays', 'event-displays', 'Large Format', 'Banners & Displays', 1),
(27, 'Indoor Banners', '', 'indoor-banners', 'indoor-banners', 'Large Format', 'Banners & Displays', 2),
(28, 'Outdoor Banners', '', 'outdoor-banners', 'outdoor-banners', 'Large Format', 'Banners & Displays', 3),
(29, 'Trade Show Graphics', '', 'trade-show-graphics', 'trade-show-graphics', 'Large Format', 'Banners & Displays', 4),
(30, 'Foam Board Signs', '', 'foam-board-signs', 'foam-board-signs', 'Large Format', 'Boards & Panels', 1),
(31, 'Presentation Boards', '', 'presentation-boards', 'presentation-boards', 'Large Format', 'Boards & Panels', 2),
(32, 'Retail Floor Graphics', '', 'retail-floor-graphics', 'retail-floor-graphics', 'Large Format', 'Floor Graphics', 1),
(33, 'Large Format Photos', '', 'large-format-photos', 'large-format-photos', 'Large Format', 'Posters & Large Paper', 1),
(34, 'Large Format Posters', '', 'large-format-posters', 'large-format-posters', 'Large Format', 'Posters & Large Paper', 2),
(35, 'Canopy Stickers', '', 'canopy-stickers', 'canopy-stickers', 'Large Format', 'Signs', 1),
(36, 'Parking & Directional Signs', '', 'parking-directional-signs', 'parking-directional-signs', 'Large Format', 'Signs', 2),
(37, 'Pump Toppers', '', 'pump-toppers', 'pump-toppers', 'Large Format', 'Signs', 3),
(38, 'Safety & Compliance Signs', '', 'safety-compliance-signs', 'safety-compliance-signs', 'Large Format', 'Signs', 4),
(39, 'Yard Signs', '', 'yard-signs', 'yard-signs', 'Large Format', 'Signs', 5),
(40, 'Window Decals', '', 'window-decals', 'window-decals', 'Large Format', 'Window & Glass', 1),
(41, 'Window Perf Graphics', '', 'window-perf-graphics', 'window-perf-graphics', 'Large Format', 'Window & Glass', 2),
(42, 'Floor Plans', '', 'floor-plans', 'floor-plans', 'Large Format', 'Posters & Large Paper', 3),
(43, 'Custom Cut Stickers', '', 'custom-cut-stickers', 'custom-cut-stickers', 'Large Format', 'Stickers', 1),
(44, 'Large Rigid Signage', '', 'large-rigid-signage', 'large-rigid-signage', 'Large Format', 'Signs', 6),
(45, 'Large Stickers', '', 'large-stickers', 'large-stickers', 'Large Format', 'Stickers', 2);

-- --------------------------------------------------------

--
-- Table structure for table `ps_material_categories_map`
--

CREATE TABLE `ps_material_categories_map` (
  `id` int(11) NOT NULL,
  `mat_id` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ps_material_categories_map`
--

INSERT INTO `ps_material_categories_map` (`id`, `mat_id`, `cat_id`) VALUES
(1, 25, 1),
(2, 30, 1),
(3, 32, 2),
(4, 33, 2),
(5, 34, 2),
(7, 21, 3),
(9, 26, 3),
(10, 27, 3),
(12, 21, 4),
(13, 26, 4),
(14, 23, 5),
(15, 24, 5),
(16, 25, 5),
(17, 28, 5),
(18, 29, 5),
(19, 30, 5),
(20, 24, 6),
(21, 29, 6),
(22, 31, 7),
(23, 35, 8),
(24, 36, 8),
(25, 37, 8),
(26, 38, 8),
(27, 24, 9),
(29, 21, 10),
(31, 23, 10),
(32, 24, 10),
(33, 25, 10),
(34, 26, 10),
(35, 27, 10),
(36, 28, 10),
(37, 29, 10),
(38, 30, 10),
(40, 21, 11),
(42, 26, 11),
(43, 27, 11),
(45, 21, 12),
(47, 23, 12),
(48, 24, 12),
(49, 25, 12),
(50, 26, 12),
(51, 27, 12),
(52, 28, 12),
(53, 29, 12),
(54, 30, 12),
(55, 31, 13),
(57, 21, 14),
(59, 26, 14),
(60, 27, 14),
(61, 23, 15),
(62, 24, 15),
(63, 25, 15),
(64, 28, 15),
(65, 29, 15),
(66, 30, 15),
(67, 23, 16),
(68, 24, 16),
(69, 25, 16),
(70, 28, 16),
(71, 29, 16),
(72, 30, 16),
(73, 25, 17),
(74, 30, 17),
(75, 28, 18),
(76, 29, 18),
(77, 30, 18),
(79, 21, 19),
(80, 31, 20),
(81, 39, 21),
(82, 1, 22),
(84, 1, 23),
(89, 1, 25),
(104, 11, 32),
(120, 8, 42),
(127, 2, 22),
(128, 2, 25),
(129, 2, 23),
(138, 3, 35),
(139, 3, 43),
(140, 3, 45),
(141, 3, 40),
(157, 4, 44),
(158, 4, 36),
(159, 4, 38),
(161, 5, 24),
(166, 6, 26),
(167, 6, 27),
(168, 6, 28),
(169, 6, 29),
(170, 7, 26),
(171, 7, 27),
(172, 7, 28),
(173, 7, 29),
(176, 9, 43),
(177, 9, 40),
(198, 10, 44),
(199, 10, 45),
(200, 10, 36),
(201, 10, 38),
(202, 10, 39),
(208, 12, 30),
(209, 14, 26),
(210, 14, 33),
(211, 14, 34),
(212, 14, 31),
(213, 14, 29),
(220, 15, 23),
(221, 15, 31),
(222, 15, 37),
(226, 16, 23),
(227, 16, 37),
(228, 16, 38),
(230, 17, 40),
(234, 18, 41),
(235, 20, 10),
(236, 20, 11),
(237, 20, 12),
(238, 20, 14),
(239, 20, 3),
(240, 20, 4),
(241, 20, 19),
(242, 22, 10),
(243, 22, 11),
(244, 22, 12),
(245, 22, 14),
(246, 22, 3);

-- --------------------------------------------------------

--
-- Table structure for table `ps_orders`
--

CREATE TABLE `ps_orders` (
  `order_id` int(11) NOT NULL,
  `order_date` date NOT NULL,
  `order_due` date DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `order_before_tax` decimal(10,2) DEFAULT NULL,
  `order_tax` decimal(10,2) DEFAULT NULL,
  `order_after_tax` decimal(10,2) DEFAULT NULL,
  `order_amount_paid` decimal(10,2) DEFAULT NULL,
  `order_amount_due` decimal(10,2) DEFAULT NULL,
  `order_discount` decimal(10,2) DEFAULT NULL,
  `order_credits` decimal(10,2) DEFAULT NULL,
  `order_production_time` int(11) DEFAULT NULL,
  `payment_type_id` int(11) DEFAULT NULL,
  `client_id` int(11) DEFAULT NULL,
  `status_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ps_orders`
--

INSERT INTO `ps_orders` (`order_id`, `order_date`, `order_due`, `user_id`, `order_before_tax`, `order_tax`, `order_after_tax`, `order_amount_paid`, `order_amount_due`, `order_discount`, `order_credits`, `order_production_time`, `payment_type_id`, `client_id`, `status_id`) VALUES
(1, '2026-01-26', '2026-02-02', 2, 225.00, 18.56, 243.56, 0.00, 243.56, 0.00, 0.00, 1, 1, 51, 3);

-- --------------------------------------------------------

--
-- Table structure for table `ps_order_comments`
--

CREATE TABLE `ps_order_comments` (
  `comment_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `comment_text` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ps_order_items`
--

CREATE TABLE `ps_order_items` (
  `item_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `material_id` int(11) NOT NULL,
  `item_details` text DEFAULT NULL,
  `item_quantity` int(11) NOT NULL,
  `item_size_width` decimal(10,2) DEFAULT NULL,
  `item_size_height` decimal(10,2) DEFAULT NULL,
  `item_grommets` tinyint(1) DEFAULT 0,
  `item_price` decimal(10,2) NOT NULL,
  `item_total` decimal(10,2) NOT NULL,
  `item_is_design` tinyint(1) NOT NULL DEFAULT 0,
  `item_is_printed` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ps_order_items`
--

INSERT INTO `ps_order_items` (`item_id`, `order_id`, `material_id`, `item_details`, `item_quantity`, `item_size_width`, `item_size_height`, `item_grommets`, `item_price`, `item_total`, `item_is_design`, `item_is_printed`) VALUES
(1, 1, 4, 'test', 1, 96.00, 48.00, 0, 225.00, 225.00, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `ps_print_sizes`
--

CREATE TABLE `ps_print_sizes` (
  `s_id` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `labels` varchar(32) NOT NULL,
  `div_value` decimal(5,3) NOT NULL,
  `type` enum('digital','large') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ps_print_sizes`
--

INSERT INTO `ps_print_sizes` (`s_id`, `cat_id`, `labels`, `div_value`, `type`) VALUES
(1, 1, 'Standard (3.5 x 2)', 0.120, 'digital'),
(2, 2, 'A9 Envelopes (5.75 x 8.75)', 1.000, 'digital'),
(3, 3, 'Letter (8.5 x 11)', 1.000, 'digital'),
(4, 4, 'Letter (8.5 x 11)', 1.000, 'digital'),
(5, 5, 'Tabloid (11 x 17)', 1.000, 'digital'),
(6, 6, 'Standard (1.5 x 11)', 0.200, 'digital'),
(7, 7, 'Small (2 x 3.5)', 0.083, 'digital'),
(8, 7, 'Long (1.5 x 4)', 0.050, 'digital'),
(9, 8, 'Small (0.75 x 1.5)', 0.025, 'digital'),
(10, 8, 'Large (4 x 6)', 0.500, 'digital'),
(11, 9, 'Letter w/Tab (8.5 x 11)', 1.000, 'digital'),
(12, 10, 'Arch A (9 x 12)', 1.000, 'digital'),
(13, 10, 'Letter (8.5 x 11)', 1.000, 'digital'),
(14, 10, 'Half Letter (5.5 x 8.5)', 0.650, 'digital'),
(15, 11, 'Half Letter (5.5 x 8.5)', 0.650, 'digital'),
(16, 12, 'Wall Calendar (9 x 12)', 1.000, 'digital'),
(17, 12, 'Sheet Calendar (8.5 x 11)', 1.000, 'digital'),
(18, 13, 'Standard (4.25 x 11)', 0.330, 'digital'),
(19, 14, 'Letter (8.5 x 11)', 1.000, 'digital'),
(20, 14, 'Half Sheet (5.5 x 8.5)', 0.650, 'digital'),
(21, 14, 'Quarter Sheet (4.25 x 5.5)', 0.400, 'digital'),
(22, 15, 'Letter (8.5 x 11)', 1.000, 'digital'),
(23, 16, 'Half Page (5.5 x 8.5)', 0.650, 'digital'),
(24, 16, 'Letter (8.5 x 11)', 1.000, 'digital'),
(25, 17, 'Small (4 x 6)', 0.500, 'digital'),
(26, 17, 'Medium (5 x 7)', 0.500, 'digital'),
(27, 17, 'Large (6 x 9)', 1.000, 'digital'),
(28, 18, 'Letter (8.5 x 11)', 1.000, 'digital'),
(29, 18, 'Large (13 x 19)', 1.000, 'digital'),
(30, 19, 'Letter (8.5 x 11)', 1.000, 'digital'),
(31, 20, 'Small (2 x 3)', 0.120, 'digital'),
(32, 21, 'Standard (11 x 1.25)', 0.200, 'digital');

-- --------------------------------------------------------

--
-- Table structure for table `ps_status`
--

CREATE TABLE `ps_status` (
  `status_id` int(11) NOT NULL,
  `status_number` int(11) DEFAULT NULL,
  `status_name` varchar(50) NOT NULL,
  `status_color` varchar(20) DEFAULT '#ffffff'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ps_status`
--

INSERT INTO `ps_status` (`status_id`, `status_number`, `status_name`, `status_color`) VALUES
(1, 1, 'Quote/Draft', '#ffffff'),
(2, 2, 'Order Confirmed', '#A8D5BA'),
(3, 3, 'Design Started', '#F9D5E5'),
(4, 4, 'Awaiting Approval', '#FFE5A1'),
(5, 5, 'Awaiting Material', '#BFD7EA'),
(6, 6, 'Ready to Print', '#FFD6BA'),
(7, 7, 'Ready for Pickup', '#C5BAFF'),
(8, 8, 'Payment Pending', '#FFC1C1'),
(9, 9, 'Order Completed', '#D0F0C0'),
(10, 10, 'No Response', '#E0E0E0'),
(11, 11, 'Canceled Orders', '#F4C7C3'),
(12, 12, 'Disputes', '#F7B7A3');

-- --------------------------------------------------------

--
-- Table structure for table `ps_users`
--

CREATE TABLE `ps_users` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_type` enum('admin','manager','viewer','client') NOT NULL,
  `user_creation_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ps_users`
--

INSERT INTO `ps_users` (`user_id`, `user_name`, `user_email`, `user_password`, `user_type`, `user_creation_date`) VALUES
(1, 'Admin', 'admin@stmaprinting.com', 'admin7861', 'admin', '2024-01-01 00:00:00'),
(2, 'Sajjad', 'sajjad@stmaprinting.com', 'user123', 'manager', '2024-02-10 00:00:00'),
(3, 'Naail', 'naail@stmaprinting.com', 'user123', 'manager', '2024-03-05 00:00:00'),
(4, 'John', 'client@stmaprinting.com', 'client123', 'client', '0000-00-00 00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ps_clients`
--
ALTER TABLE `ps_clients`
  ADD PRIMARY KEY (`client_id`);

--
-- Indexes for table `ps_materials`
--
ALTER TABLE `ps_materials`
  ADD PRIMARY KEY (`mat_id`);

--
-- Indexes for table `ps_material_categories`
--
ALTER TABLE `ps_material_categories`
  ADD PRIMARY KEY (`cat_id`),
  ADD UNIQUE KEY `cat_slug` (`cat_slug`),
  ADD UNIQUE KEY `cat_slug_2` (`cat_slug`);

--
-- Indexes for table `ps_material_categories_map`
--
ALTER TABLE `ps_material_categories_map`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mat_id` (`mat_id`),
  ADD KEY `cat_id` (`cat_id`);

--
-- Indexes for table `ps_orders`
--
ALTER TABLE `ps_orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `fk_orders_user` (`user_id`),
  ADD KEY `fk_orders_client` (`client_id`),
  ADD KEY `fk_orders_status` (`status_id`);

--
-- Indexes for table `ps_order_comments`
--
ALTER TABLE `ps_order_comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `fk_order_comments_order` (`order_id`);

--
-- Indexes for table `ps_order_items`
--
ALTER TABLE `ps_order_items`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `fk_item_order` (`order_id`),
  ADD KEY `fk_item_material` (`material_id`);

--
-- Indexes for table `ps_print_sizes`
--
ALTER TABLE `ps_print_sizes`
  ADD PRIMARY KEY (`s_id`);

--
-- Indexes for table `ps_status`
--
ALTER TABLE `ps_status`
  ADD PRIMARY KEY (`status_id`);

--
-- Indexes for table `ps_users`
--
ALTER TABLE `ps_users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_email` (`user_email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ps_clients`
--
ALTER TABLE `ps_clients`
  MODIFY `client_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=251;

--
-- AUTO_INCREMENT for table `ps_materials`
--
ALTER TABLE `ps_materials`
  MODIFY `mat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `ps_material_categories`
--
ALTER TABLE `ps_material_categories`
  MODIFY `cat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `ps_material_categories_map`
--
ALTER TABLE `ps_material_categories_map`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=247;

--
-- AUTO_INCREMENT for table `ps_orders`
--
ALTER TABLE `ps_orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ps_order_comments`
--
ALTER TABLE `ps_order_comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ps_order_items`
--
ALTER TABLE `ps_order_items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ps_print_sizes`
--
ALTER TABLE `ps_print_sizes`
  MODIFY `s_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `ps_status`
--
ALTER TABLE `ps_status`
  MODIFY `status_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `ps_users`
--
ALTER TABLE `ps_users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ps_material_categories_map`
--
ALTER TABLE `ps_material_categories_map`
  ADD CONSTRAINT `ps_material_categories_map_ibfk_1` FOREIGN KEY (`mat_id`) REFERENCES `ps_materials` (`mat_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ps_material_categories_map_ibfk_2` FOREIGN KEY (`cat_id`) REFERENCES `ps_material_categories` (`cat_id`) ON DELETE CASCADE;

--
-- Constraints for table `ps_orders`
--
ALTER TABLE `ps_orders`
  ADD CONSTRAINT `fk_orders_client` FOREIGN KEY (`client_id`) REFERENCES `ps_clients` (`client_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_orders_status` FOREIGN KEY (`status_id`) REFERENCES `ps_status` (`status_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_orders_user` FOREIGN KEY (`user_id`) REFERENCES `ps_users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `ps_order_comments`
--
ALTER TABLE `ps_order_comments`
  ADD CONSTRAINT `fk_order_comments_order` FOREIGN KEY (`order_id`) REFERENCES `ps_orders` (`order_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ps_order_items`
--
ALTER TABLE `ps_order_items`
  ADD CONSTRAINT `fk_item_material` FOREIGN KEY (`material_id`) REFERENCES `ps_materials` (`mat_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_item_order` FOREIGN KEY (`order_id`) REFERENCES `ps_orders` (`order_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
