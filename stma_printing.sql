-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 08, 2026 at 11:24 PM
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
  `is_cost_price` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ps_clients`
--

INSERT INTO `ps_clients` (`client_id`, `business_name`, `business_address`, `contact_name`, `contact_phone`, `contact_email`, `client_since`, `client_stma_id`, `tax_exempt`, `tax_exempt_id`, `is_employee`, `is_cost_price`) VALUES
(1, 'Alpha Print Co', '123 Main St, Chicago, IL', 'John Doe', '3125551212', 'john@alpha.com', '2022-01-10', 1001, 0, 0, 0, 0),
(2, 'Beta Signs LLC', '42 Market Ave, Dallas, TX', 'Sarah Lee', '2145558787', 'sarah@betasigns.com', '2023-03-15', 1002, 0, 0, 0, 0),
(3, 'Gamma Media', '77 Poster Ln, Miami, FL', 'Carlos Ruiz', '3055554321', 'carlos@gamma.com', '2021-07-05', 1003, 0, 0, 0, 0),
(4, 'Delta Prints', '890 Banner Rd, New York, NY', 'Ava Brown', '9175555678', 'ava@delta.com', '2020-10-22', 1004, 0, 0, 0, 0),
(5, 'Epsilon Visuals', '22 Wall St, Los Angeles, CA', 'Mike Green', '2135559988', 'mike@epsilon.com', '2024-01-05', 1005, 0, 0, 0, 0),
(7, 'New Company LLC', 'Somewhere here...', 'Sajjad Ali', '1234567890', 'abc@xyz.com', '2025-11-03', 1324, 1, 321654987, 1, 0),
(9, 'Kwik Corner', '2730 Hillcrest Dr, Balcones Heights TX 78228', 'Srikanth', '1234567890', 'quickcorner2@gmail.com', '2025-11-10', 2730, 0, 0, 0, 0),
(10, 'New Company LLC', 'here', 'Naail Ali', '7373812357', 'printing@mystma.com', '2025-11-12', 1231, 0, 0, 1, 0),
(11, 'Hightime Smoke & Vape', '5935 Rittman Rd', 'Jasad', '8303578201', 'jassadmomin@hotmail.com', '2025-11-12', 0, 0, 0, 0, 0),
(12, 'Amazing Stop', '-', 'Kahir Charolia', '2106395078', '', '2025-11-12', 0, 1, 123456789, 0, 0),
(14, 'Shipley Donuts', '7875 Kitty Hawk Rd, Converse, TX 78109', 'Zakir Mehmood', '2108402733', 'zakirmehmood2002@yahoo.com', '2025-11-12', 0, 0, 0, 0, 0);

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
(1, 'Lexjet', 'Adhesive', 'large', '4WM66A - HP Prime Matte Air GP, 3.4 Mil', 54, 150, 1800, 217.070000, 3.00, 0.003400, '2025-10-11'),
(2, 'Lexjet', 'Backlit', 'large', 'KBLGS60 - Kodak glossy backlit film', 60, 100, 1200, 300.000000, 3.00, 0.003400, '2025-10-11'),
(3, 'Clampitt', 'Banner Matte', 'large', '8600537	Maxbanner Matte, 13oz	54\"x164\'', 54, 164, 1968, 124.200000, 3.00, 0.003400, '2025-10-11'),
(4, 'Clampitt', 'Banner Gloss', 'large', '86005371	Maxbanner Gloss, 13oz	54\"x164\'', 54, 164, 1968, 124.200000, 3.00, 0.003400, '2025-10-11'),
(5, '', 'Print Only', 'large', 'N/A', 0, 0, 0, 1.000000, 3.00, 0.003400, '2025-10-11'),
(6, 'Lexjet', 'Clear Adhesive', 'large', 'GF 206-54 - Clear Gloss Vinyl, Removeable', 54, 150, 1800, 230.000000, 3.00, 0.003400, '2025-10-11'),
(7, 'Clampitt', 'Coroplast', 'large', '58263908	Centrlplas 60x120-4mm	60\"x120\"', 60, 120, 120, 13.250000, 6.00, 0.003400, '2025-10-11'),
(8, 'Grimco', 'Floor Sticker', 'large', 'OLFL-30954, Briteline Floor Film Overlaminate - OLFL309 54 \" x 150 \'', 54, 150, 1800, 368.990000, 3.00, 0.003400, '2025-10-11'),
(9, 'Reece Supply', 'Foam Board', 'large', 'Pn 122718 - 3/16 White Foam Board', 48, 96, 96, 15.130000, 6.00, 0.003400, '2025-10-11'),
(10, 'Lexjet', 'Bond Paper', 'large', 'Canon Economy Bond Paper (75gsm)', 36, 200, 2400, 109.610000, 1.50, 0.003400, '2025-10-11'),
(11, 'Lexjet', 'Polypropylene', 'large', 'ERWP36200 - LexJet Heavyweight WR Polypropylene - 36in x 200ft', 36, 200, 2400, 106.250000, 3.00, 0.003400, '2025-10-11'),
(12, 'Grimco', 'Polystyrene 020', 'large', 'HIPS60XC0X020W, Duratex Polystyrene Sheets - Double White 60\" x 120\", .020\"', 60, 120, 120, 15.380000, 4.00, 0.003400, '2025-10-11'),
(13, 'Grimco', 'Polystyrene 040', 'large', 'HIPS60XC0X040W, Duratex Polystyrene Sheets - Double White 60\" x 120\", .040\"', 60, 96, 120, 30.750000, 4.00, 0.003400, '2025-10-11'),
(14, 'Lexjet', 'Static Cling', 'large', '207-5415 - GF-207 Clear', 54, 150, 1800, 260.090000, 3.00, 0.003400, '2025-10-11'),
(15, 'Reece Supply', 'Window Perforated', 'large', 'Pn 55599 - UltraVision Window Perf 60/40 UV 6.3 Mil', 54, 164, 1968, 326.830000, 3.00, 0.003400, '2025-10-11'),
(16, 'Grimco', 'Aluminum', 'large', 'MM843MWDP - MAXMETAL™ 4\' x 8\', White DP, EACH', 60, 120, 120, 86.320000, 3.00, 0.003400, '2025-10-11'),
(17, 'Grimco', 'Acrylic - Clear', 'large', 'CC4896316C - Duratex Cast Acrylic 48\" x 96\", Clear, 3/16\"', 60, 120, 120, 172.190000, 3.00, 0.003400, '2025-10-11'),
(18, 'Grimco', 'Acrylic - White', 'large', 'CC4896316W7328 - Duratex Cast Acrylic 48\" x 96\", White 7328, 3/16\"', 60, 120, 120, 184.370000, 3.00, 0.003400, '2025-10-11'),
(19, 'Lexjet', 'Polyester', 'large', '142SGC30\r - LexJet Clear Polyester SUV - 30in x 100ft', 30, 100, 1200, 229.000000, 3.00, 0.003400, '2025-10-11'),
(22, 'Test', 'Regular Paper', 'digital', 'None', 12, 18, 18, 0.001800, 1.00, 0.043000, '2025-12-29'),
(24, 'Paper', 'Cardstock', 'digital', '', 9, 11, 11, 0.040000, 1.00, 0.043000, '2025-12-30');

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
(1, 'Banner', 'Vinyl and mesh banners for indoor or outdoor use', 'banner', 'banner', 'Large Format', 'Signs & Banners', 1),
(2, 'Poster', 'Posters and photo paper prints', 'poster', 'poster', 'Large Format', 'Signs & Banners', 2),
(3, 'Yard Sign', 'Corrugated plastic yard signs', 'yard', 'yard', 'Large Format', 'Signs & Banners', 3),
(4, 'Window Sticker', 'Adhesive vinyl stickers for windows', 'window-sticker', 'window-sticker', 'Large Format', 'Signs & Banners', 4),
(5, 'Window Perforated', 'Perforated see-through window film', 'window-perforated', 'window-perforated', 'Large Format', 'Signs & Banners', 5),
(6, 'Indoor Sign', 'Foam board or styrene indoor signs', 'indoor', 'indoor', 'Large Format', 'Window Graphics', 1),
(7, 'Pump Topper', 'Signs used on gas pump displays', 'pump-topper', 'pump-topper', 'Large Format', 'Window Graphics', 2),
(8, 'Metal Sign', 'Durable aluminum signage', 'metal', 'metal', 'Large Format', 'Window Graphics', 3),
(9, 'Acrylic Sign', 'Acrylic signs, clear or white', 'acrylic', 'acrylic', 'Large Format', 'Banner Stands', 1),
(10, 'Backlit Sign', 'Film for lightbox or display backlit signs', 'backlit', 'backlit', 'Large Format', 'Banner Stands', 2),
(11, 'Business Cards', '', 'businesscards', 'business-cards', 'Digital Format', 'Marketing Material', 1),
(12, 'Flyers', '', 'flyers', 'flyers', 'Digital Format', 'Marketing Material', 2),
(13, 'Brochures', '', 'brochures', 'brochures', 'Digital Format', 'Marketing Material', 3),
(14, 'Postcards', '', 'postcards', 'postcards', 'Digital Format', 'Marketing Material', 4),
(15, 'Door Hanger', '', 'door-hanger', 'door-hanger', 'Digital Format', 'Marketing Material', 5),
(16, 'Menu Cards', '', 'menu-cards', 'menu-cards', 'Digital Format', 'Marketing Material', 7),
(17, 'Event Tickets', '', 'event-tickets', 'event-tickets', 'Digital Format', 'Marketing Material', 6),
(18, 'Saddle Booklet', '', 'saddle-booklet', 'saddle-booklet', 'Digital Format', 'Booklet', 1),
(19, '4\"x6\" 4up Labels', '', '', '4x6-4up-label', 'Digital Format', 'Stickers & Labels', 1),
(20, 'Custom Cut Stickers', '', 'custom-cut-stickers', 'custom-cut-stickers', 'Digital Format', 'Stickers & Labels', 3),
(21, '.75\"x1.5\" Labels', '', '', '0.75x1.5-labels', 'Digital Format', 'Stickers & Labels', 2);

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
(1, 1, 4),
(2, 2, 10),
(5, 6, 4),
(10, 11, 2),
(13, 14, 4),
(14, 15, 5),
(18, 19, 2),
(28, 16, 8),
(44, 17, 9),
(45, 18, 9),
(52, 13, 6),
(53, 13, 7),
(54, 12, 6),
(55, 12, 7),
(62, 8, 6),
(63, 4, 1),
(64, 3, 1),
(69, 7, 3),
(70, 9, 6),
(71, 10, 2),
(76, 24, 11),
(77, 22, 12);

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
(1, '2024-06-01', '2024-06-03', 1, 120.00, 10.80, 130.80, 100.00, 30.80, NULL, NULL, 1, 1, 1, 10),
(2, '2024-06-05', '2024-06-07', 2, 300.00, 27.00, 327.00, 327.00, 0.00, NULL, NULL, 1, 2, 2, 9),
(3, '2024-06-10', '2024-06-12', 1, 450.00, 40.50, 490.50, 490.50, 0.00, NULL, NULL, 1, 1, 3, 9),
(24, '2025-11-12', '2025-11-17', 1, 33.00, 2.72, 35.72, 0.00, 35.72, NULL, NULL, 1, 1, 7, 9),
(25, '2025-11-12', '2025-11-17', 1, 29.00, 2.39, 31.39, 0.00, 31.39, 0.00, 0.00, 1, 3, 11, 5),
(26, '2025-11-12', '2025-11-17', 1, 563.00, 46.45, 609.45, 0.00, 609.45, 0.00, 0.00, 1, 1, 12, 4),
(31, '2025-11-12', '2025-11-17', 1, 24.00, 1.98, 25.98, 25.98, 0.00, 0.00, 0.00, 1, 1, 14, 3),
(35, '2025-11-28', '2025-12-03', 1, 83.00, 0.00, 83.00, 0.00, 83.00, 0.00, 0.00, 1, 1, 7, 2),
(36, '2025-12-01', '2025-12-08', 1, 14.00, 2.39, 31.39, 0.00, 31.39, 0.00, 0.00, 2, 1, 10, 1),
(37, '2025-12-09', '2025-12-15', 3, 144.00, 11.88, 155.88, 0.00, 155.88, 0.00, 0.00, 1, 1, 10, 1),
(39, '2025-12-10', '2025-12-15', 3, 1039.00, 85.72, 1124.72, 0.00, 1124.72, 0.00, 0.00, 1, 1, 10, 1),
(40, '2025-12-11', '2025-12-16', 3, 475.00, 43.83, 575.08, 250.00, 325.08, 15.00, 15.00, 2, 2, 10, 7),
(41, '2025-12-12', '2025-12-17', 2, 82.00, 0.00, 82.00, 0.00, 82.00, 0.00, 0.00, 1, 1, 7, 1),
(42, '2025-12-15', '2025-12-22', 2, 67.00, 5.53, 72.53, 0.00, 72.53, 0.00, 0.00, 1, 3, 10, 1),
(45, '2025-12-17', '2025-12-22', 3, 475.00, 31.35, 411.35, 0.00, 411.35, 20.00, 0.00, 1, 1, 10, 12);

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

--
-- Dumping data for table `ps_order_comments`
--

INSERT INTO `ps_order_comments` (`comment_id`, `order_id`, `comment_text`, `created_at`) VALUES
(14, 42, 'hello new order', '2025-12-16 08:58:12'),
(15, 42, 'Check comments', '2025-12-16 08:58:18'),
(16, 42, 'test', '2025-12-17 17:38:30'),
(17, 42, 'test', '2025-12-17 17:38:32');

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
(1, 1, 1, 'Poster Print 24x36', 2, 24.00, 36.00, 0, 60.00, 120.00, 0, 0),
(2, 2, 2, 'Banner 48x72 with grommets', 1, 48.00, 72.00, 1, 300.00, 300.00, 0, 0),
(3, 3, 3, 'Vinyl decal set', 3, 12.00, 12.00, 0, 150.00, 450.00, 0, 0),
(39, 24, 16, 'Sign', 1, 24.00, 36.00, 0, 14.00, 14.00, 1, 0),
(40, 24, 1, 'Sticker', 1, 24.00, 36.00, 0, 19.00, 19.00, 0, 0),
(41, 25, 1, 'Labels/Stickers', 1, 54.00, 54.00, 0, 29.00, 29.00, 0, 0),
(42, 26, 1, 'Pizza Slice, Fountain Drink, $4.99', 1, 24.00, 36.00, 0, 19.00, 19.00, 1, 1),
(43, 26, 1, 'Wings, Fries, Fountain Drink, $9.99', 1, 24.00, 36.00, 0, 19.00, 19.00, 1, 1),
(44, 26, 1, 'Hunt Brothers Whole Cheese Pizza, $8.99', 1, 55.00, 45.00, 0, 47.00, 47.00, 1, 1),
(45, 26, 1, 'Hunt Brothers Whole Pepperoni Pizza, $11.99', 1, 56.00, 45.00, 0, 48.00, 48.00, 1, 1),
(46, 26, 1, 'Corn Dog, Burrito, Egg Roll, Fries (2 pieces, 5 ft each)', 1, 120.00, 18.00, 0, 67.00, 67.00, 0, 0),
(47, 26, 1, 'Egg & Cheese Sandwich, Hashbrowns, Coffee, $5.99 (2 pieces, 5 ft each)', 1, 120.00, 18.00, 0, 67.00, 67.00, 1, 0),
(48, 26, 1, 'Text, 1 sign per item: Beer, Wine, Soda, Lotto, Snack, Fountain Drinks, Coffee, Slushy', 8, 55.00, 10.00, 0, 27.00, 216.00, 0, 0),
(49, 26, 1, 'No Back Pack Signs', 10, 8.00, 11.00, 0, 6.00, 60.00, 1, 0),
(50, 26, 6, '1 Per Combo', 4, 6.00, 24.00, 0, 5.00, 20.00, 1, 1),
(51, 31, 16, 'Drive Thru Sign', 1, 18.00, 18.00, 0, 6.00, 24.00, 0, 0),
(52, 35, 1, '', 1, 96.00, 48.00, 0, 83.00, 83.00, 1, 1),
(53, 36, 17, '', 1, 24.00, 24.00, 0, 14.00, 14.00, 0, 0),
(54, 37, 7, '', 1, 96.00, 48.00, 0, 144.00, 144.00, 1, 0),
(55, 39, 17, '', 1, 1.00, 60.00, 0, 261.00, 261.00, 0, 0),
(56, 39, 18, '', 1, 1.00, 60.00, 0, 279.00, 279.00, 0, 0),
(57, 39, 1, '', 1, 1.00, 54.00, 0, 22.00, 22.00, 0, 0),
(58, 39, 16, '', 1, 1.00, 60.00, 0, 132.00, 132.00, 0, 0),
(59, 39, 2, '', 1, 1.00, 60.00, 0, 47.00, 47.00, 0, 0),
(60, 39, 4, '', 1, 1.00, 54.00, 0, 17.00, 17.00, 0, 0),
(61, 39, 3, '', 1, 1.00, 54.00, 0, 17.00, 17.00, 0, 0),
(62, 39, 6, '', 1, 1.00, 54.00, 0, 23.00, 23.00, 0, 0),
(63, 39, 7, '', 1, 1.00, 60.00, 0, 62.00, 62.00, 0, 0),
(64, 39, 8, '', 1, 1.00, 54.00, 0, 2.00, 2.00, 0, 0),
(65, 39, 9, '', 1, 1.00, 48.00, 0, 25.00, 25.00, 0, 0),
(66, 39, 19, '', 1, 1.00, 30.00, 0, 19.00, 19.00, 0, 0),
(67, 39, 11, '', 1, 1.00, 36.00, 0, 7.00, 7.00, 0, 0),
(68, 39, 12, '', 1, 1.00, 48.00, 0, 39.00, 39.00, 0, 0),
(69, 39, 13, '', 1, 1.00, 48.00, 0, 30.00, 30.00, 0, 0),
(70, 39, 10, '', 1, 1.00, 36.00, 0, 2.00, 2.00, 0, 0),
(71, 39, 14, '', 1, 1.00, 54.00, 0, 26.00, 26.00, 0, 0),
(72, 39, 15, '', 1, 1.00, 54.00, 0, 29.00, 29.00, 0, 0),
(73, 40, 17, 'TEST', 1, 24.00, 36.00, 0, 72.00, 72.00, 0, 0),
(74, 40, 18, 'test', 1, 24.00, 36.00, 0, 76.00, 76.00, 0, 0),
(75, 40, 1, 'TEST', 1, 24.00, 36.00, 0, 16.00, 16.00, 0, 0),
(76, 40, 16, 'test', 1, 24.00, 36.00, 0, 41.00, 41.00, 0, 0),
(77, 40, 2, 'TEST', 1, 24.00, 36.00, 0, 21.00, 21.00, 0, 0),
(78, 40, 4, 'test', 1, 24.00, 36.00, 0, 13.00, 13.00, 0, 0),
(79, 40, 3, 'TEST', 1, 24.00, 36.00, 0, 13.00, 13.00, 0, 0),
(80, 40, 6, 'test', 1, 24.00, 36.00, 0, 16.00, 16.00, 0, 0),
(81, 40, 7, 'TEST', 1, 24.00, 36.00, 0, 20.00, 20.00, 0, 0),
(82, 40, 8, 'test', 1, 24.00, 36.00, 0, 20.00, 20.00, 0, 0),
(83, 40, 9, 'TEST', 1, 24.00, 36.00, 0, 27.00, 27.00, 0, 0),
(84, 40, 19, 'test', 1, 24.00, 36.00, 0, 27.00, 27.00, 0, 0),
(85, 40, 11, 'TEST', 1, 24.00, 36.00, 0, 13.00, 13.00, 0, 0),
(86, 40, 12, 'test', 1, 24.00, 36.00, 0, 21.00, 21.00, 0, 0),
(87, 40, 13, 'TEST', 1, 24.00, 36.00, 0, 32.00, 32.00, 0, 0),
(88, 40, 10, 'test', 1, 24.00, 36.00, 0, 12.00, 12.00, 0, 0),
(89, 40, 14, 'TEST', 1, 24.00, 36.00, 0, 17.00, 17.00, 0, 0),
(90, 40, 15, 'test', 1, 24.00, 36.00, 0, 18.00, 18.00, 0, 0),
(91, 41, 1, '', 1, 96.00, 48.00, 0, 82.00, 82.00, 0, 0),
(92, 42, 4, '', 1, 96.00, 48.00, 0, 67.00, 67.00, 0, 0),
(93, 45, 17, '', 1, 24.00, 36.00, 0, 72.00, 72.00, 0, 0),
(94, 45, 18, '', 1, 24.00, 36.00, 0, 76.00, 76.00, 0, 0),
(95, 45, 1, '', 1, 24.00, 36.00, 0, 16.00, 16.00, 0, 0),
(96, 45, 16, '', 1, 24.00, 36.00, 0, 41.00, 41.00, 0, 0),
(97, 45, 2, '', 1, 24.00, 36.00, 0, 21.00, 21.00, 0, 0),
(98, 45, 4, '', 1, 24.00, 36.00, 0, 13.00, 13.00, 0, 0),
(99, 45, 3, '', 1, 24.00, 36.00, 0, 13.00, 13.00, 0, 0),
(100, 45, 6, '', 1, 24.00, 36.00, 0, 16.00, 16.00, 0, 0),
(101, 45, 7, '', 1, 24.00, 36.00, 0, 20.00, 20.00, 0, 0),
(102, 45, 8, '', 1, 24.00, 36.00, 0, 20.00, 20.00, 0, 0),
(103, 45, 9, '', 1, 24.00, 36.00, 0, 27.00, 27.00, 0, 0),
(104, 45, 19, '', 1, 24.00, 36.00, 0, 27.00, 27.00, 0, 0),
(105, 45, 11, '', 1, 24.00, 36.00, 0, 13.00, 13.00, 0, 0),
(106, 45, 12, '', 1, 24.00, 36.00, 0, 21.00, 21.00, 0, 0),
(107, 45, 13, '', 1, 24.00, 36.00, 0, 32.00, 32.00, 0, 0),
(108, 45, 10, '', 1, 24.00, 36.00, 0, 12.00, 12.00, 0, 0),
(109, 45, 14, '', 1, 24.00, 36.00, 0, 17.00, 17.00, 0, 0),
(110, 45, 15, '', 1, 24.00, 36.00, 0, 18.00, 18.00, 0, 0);

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
  `user_type` enum('admin','manager','viewer') NOT NULL,
  `user_creation_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ps_users`
--

INSERT INTO `ps_users` (`user_id`, `user_name`, `user_email`, `user_password`, `user_type`, `user_creation_date`) VALUES
(1, 'Admin', 'admin@stmaprinting.com', 'admin7861', 'admin', '2024-01-01'),
(2, 'Sajjad', 'sajjad@stmaprinting.com', 'user123', 'manager', '2024-02-10'),
(3, 'Naail', 'naail@stmaprinting.com', 'user123', 'manager', '2024-03-05');

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
  ADD UNIQUE KEY `cat_slug` (`cat_slug`);

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
  MODIFY `client_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `ps_materials`
--
ALTER TABLE `ps_materials`
  MODIFY `mat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `ps_material_categories`
--
ALTER TABLE `ps_material_categories`
  MODIFY `cat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `ps_material_categories_map`
--
ALTER TABLE `ps_material_categories_map`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT for table `ps_orders`
--
ALTER TABLE `ps_orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `ps_order_comments`
--
ALTER TABLE `ps_order_comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `ps_order_items`
--
ALTER TABLE `ps_order_items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- AUTO_INCREMENT for table `ps_status`
--
ALTER TABLE `ps_status`
  MODIFY `status_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `ps_users`
--
ALTER TABLE `ps_users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
