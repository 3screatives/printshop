-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 13, 2026 at 11:07 PM
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
(14, 'New Company LLC', 'here', 'Sajjad Ali', '1234567890', 'email@domain.com', '2025-11-12', 1231, 0, 0, 1, 0);

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
(1, 'Lexjet', 'Adhesive', 'large', '4WM66A - HP Prime Matte Air GP, 3.4 Mil', 54, 150, 1800, 217.070000, 3.00, 0.003400, '2026-01-12'),
(2, 'Lexjet', 'Backlit', 'large', 'KBLGS60 - Kodak glossy backlit film', 60, 100, 1200, 300.000000, 3.00, 0.003400, '2026-01-12'),
(3, 'Clampitt', 'Banner Matte', 'large', '8600537	Maxbanner Matte, 13oz	54\"x164\'', 54, 164, 1968, 124.200000, 3.00, 0.003400, '2026-01-12'),
(4, 'Clampitt', 'Banner Gloss', 'large', '86005371	Maxbanner Gloss, 13oz	54\"x164\'', 54, 164, 1968, 124.200000, 3.00, 0.003400, '2026-01-12'),
(5, 'Lexjet', 'Clear Adhesive', 'large', 'GF 206-54 - Clear Gloss Vinyl, Removeable', 54, 150, 1800, 230.000000, 3.00, 0.003400, '2026-01-12'),
(6, 'Clampitt', 'Coroplast', 'large', '58263908	Centrlplas 60x120-4mm	60\"x120\"', 60, 120, 120, 13.250000, 6.00, 0.003400, '2026-01-12'),
(7, 'Grimco', 'Floor Sticker', 'large', 'OLFL-30954, Briteline Floor Film Overlaminate - OLFL309 54 \" x 150 \'', 54, 150, 1800, 368.990000, 3.00, 0.003400, '2026-01-12'),
(8, 'Reece Supply', 'Foam Board', 'large', 'Pn 122718 - 3/16 White Foam Board', 48, 96, 96, 15.130000, 6.00, 0.003400, '2026-01-12'),
(9, 'Lexjet', 'Bond Paper', 'large', 'Canon Economy Bond Paper (75gsm)', 36, 200, 2400, 109.610000, 1.50, 0.003400, '2026-01-12'),
(10, 'Lexjet', 'Polypropylene', 'large', 'ERWP36200 - LexJet Heavyweight WR Polypropylene - 36in x 200ft', 36, 200, 2400, 106.250000, 3.00, 0.003400, '2026-01-12'),
(11, 'Grimco', 'Polystyrene 020', 'large', 'HIPS60XC0X020W, Duratex Polystyrene Sheets - Double White 60\" x 120\", .020\"', 60, 120, 120, 15.380000, 4.00, 0.003400, '2026-01-12'),
(12, 'Grimco', 'Polystyrene 040', 'large', 'HIPS60XC0X040W, Duratex Polystyrene Sheets - Double White 60\" x 120\", .040\"', 60, 96, 120, 30.750000, 4.00, 0.003400, '2026-01-12'),
(13, 'Lexjet', 'Static Cling', 'large', '207-5415 - GF-207 Clear', 54, 150, 1800, 260.090000, 3.00, 0.003400, '2026-01-12'),
(14, 'Reece Supply', 'Window Perforated', 'large', 'Pn 55599 - UltraVision Window Perf 60/40 UV 6.3 Mil', 54, 164, 1968, 326.830000, 3.00, 0.003400, '2026-01-12'),
(15, 'Grimco', 'Aluminum', 'large', 'MM843MWDP - MAXMETAL™ 4\' x 8\', White DP, EACH', 60, 120, 120, 86.320000, 3.00, 0.003400, '2026-01-12'),
(16, 'Grimco', 'Acrylic - Clear', 'large', 'CC4896316C - Duratex Cast Acrylic 48\" x 96\", Clear, 3/16\"', 60, 120, 120, 172.190000, 3.00, 0.003400, '2026-01-12'),
(17, 'Grimco', 'Acrylic - White', 'large', 'CC4896316W7328 - Duratex Cast Acrylic 48\" x 96\", White 7328, 3/16\"', 60, 120, 120, 184.370000, 3.00, 0.003400, '2026-01-12'),
(18, 'Lexjet', 'Polyester', 'large', '142SGC30\r - LexJet Clear Polyester SUV - 30in x 100ft', 30, 100, 1200, 229.000000, 3.00, 0.003400, '2026-01-12'),
(19, 'Clampitt', '60lb Matte Text', 'digital', 'Accent Opaque Smooth', 9, 0, 11, 0.016010, 1.00, 0.043000, '2026-01-12'),
(20, 'Clampitt', '100lb Matte Cover', 'digital', 'Accent Opaque Smooth', 9, 0, 11, 0.049830, 1.00, 0.043000, '2026-01-12'),
(21, 'Clampitt', '110lb Matte Cover', 'digital', 'Accent Opaque Smooth', 9, 0, 11, 0.185530, 1.00, 0.043000, '2026-01-12'),
(22, 'Clampitt', '80lb Gloss Text', 'digital', 'Billerud Sterling Digital', 9, 0, 11, 0.026340, 1.00, 0.043000, '2026-01-12'),
(23, 'Clampitt', '100lb Gloss Cover', 'digital', 'Billerud Sterling Digital', 9, 0, 11, 0.098000, 1.00, 0.043000, '2026-01-12'),
(24, 'Clampitt', '80lb Matte Text', 'digital', 'Accent Opaque Smooth', 12, 0, 18, 0.052480, 1.00, 0.043000, '2026-01-12'),
(25, 'Clampitt', '80lb Matte Cover', 'digital', 'Omnix Smooth', 12, 0, 18, 0.115561, 1.00, 0.043000, '2026-01-12'),
(26, 'Clampitt', '100lb Matte Text', 'digital', 'Accent Opaque Smooth', 12, 0, 18, 0.077500, 1.00, 0.043000, '2026-01-12'),
(27, 'Clampitt', '100lb Matte Cover', 'digital', 'Accent Opaque Smooth', 12, 0, 18, 0.114400, 1.00, 0.043000, '2026-01-12'),
(28, 'Clampitt', '80lb Gloss Text', 'digital', 'Billerud Sterling Digital', 12, 0, 18, 0.061690, 1.00, 0.043000, '2026-01-12'),
(29, 'Clampitt', '100lb Gloss Text', 'digital', 'Billerud Sterling Digital', 12, 0, 18, 0.077112, 1.00, 0.043000, '2026-01-12'),
(30, 'Clampitt', '100lb Gloss Cover', 'digital', 'Billerud Sterling Digital', 12, 0, 18, 0.241700, 1.00, 0.043000, '2026-01-12'),
(31, 'Clampitt', '87lb Gloss Cover', 'digital', '10pt White Tango Coated C2S Board', 13, 0, 19, 0.168730, 1.00, 0.043000, '2026-01-12'),
(32, 'Office Depot', 'A9 Envelopes', 'digital', '', 6, 0, 9, 0.170000, 1.00, 0.043000, '2026-01-12'),
(33, 'Lexjet', '4ups - Removeable', 'digital', '', 4, 0, 6, 0.400000, 1.00, 0.043000, '2026-01-12'),
(34, 'Desktop Supplies', '4ups - Permanent', 'digital', '', 4, 0, 6, 0.140000, 1.00, 0.043000, '2026-01-12'),
(35, 'Online Labels', 'Small Labels', 'digital', '', 1, 0, 2, 0.030000, 1.00, 0.043000, '2026-01-12'),
(36, 'Online Labels', 'Round Labels', 'digital', '', 2, 0, 2, 0.040000, 1.00, 0.043000, '2026-01-12'),
(37, '', 'Shelf Strips', 'digital', '', 9, 0, 11, 0.185530, 1.00, 0.043000, '2026-01-12'),
(38, 'Lexjet', 'Photo Paper', 'large', '', 9, 0, 11, 0.000000, 1.00, 0.043000, '2026-01-12'),
(39, '', '28lb Matte Text', 'digital', 'Hammermill', 11, 0, 17, 0.063034, 1.00, 0.043000, '2026-01-12');

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
(1, 20, 1),
(2, 21, 1),
(3, 23, 1),
(4, 32, 2),
(6, 22, 3),
(10, 20, 6),
(11, 21, 6),
(12, 23, 6),
(13, 25, 6),
(14, 27, 6),
(15, 30, 6),
(18, 33, 8),
(19, 34, 8),
(20, 35, 8),
(21, 36, 8),
(22, 20, 9),
(23, 21, 9),
(24, 23, 9),
(25, 25, 9),
(26, 27, 9),
(27, 30, 9),
(29, 24, 10),
(31, 28, 10),
(32, 29, 10),
(34, 22, 11),
(35, 24, 12),
(37, 28, 12),
(38, 29, 12),
(41, 22, 14),
(43, 22, 15),
(44, 20, 16),
(45, 21, 16),
(46, 23, 16),
(47, 20, 17),
(48, 21, 17),
(49, 23, 17),
(50, 22, 18),
(52, 20, 20),
(53, 21, 20),
(54, 23, 20),
(55, 37, 21),
(56, 16, 22),
(57, 17, 22),
(58, 11, 23),
(59, 12, 23),
(60, 16, 23),
(61, 17, 23),
(62, 2, 24),
(63, 16, 25),
(64, 17, 25),
(65, 10, 26),
(66, 3, 26),
(67, 4, 26),
(68, 3, 27),
(69, 4, 27),
(70, 3, 28),
(71, 4, 28),
(72, 3, 29),
(73, 4, 29),
(74, 10, 29),
(75, 8, 30),
(76, 8, 31),
(77, 11, 31),
(78, 7, 32),
(79, 38, 33),
(80, 10, 33),
(81, 10, 34),
(82, 1, 35),
(83, 6, 36),
(84, 15, 36),
(85, 11, 37),
(86, 12, 37),
(87, 6, 38),
(88, 12, 38),
(89, 15, 38),
(90, 6, 39),
(91, 1, 40),
(92, 5, 40),
(93, 14, 41),
(94, 9, 42),
(95, 1, 43),
(96, 5, 43),
(97, 6, 44),
(98, 15, 44),
(99, 1, 45),
(100, 5, 45),
(101, 13, 40),
(108, 26, 10),
(109, 26, 12),
(110, 26, 4),
(111, 19, 11),
(112, 19, 14),
(113, 19, 3),
(114, 19, 15),
(115, 19, 19),
(117, 31, 6),
(118, 31, 13),
(119, 31, 7),
(120, 31, 9),
(121, 39, 5);

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
(17, 42, 'test', '2025-12-17 17:38:32'),
(18, 31, 'hello new order', '2026-01-09 09:27:59');

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

-- --------------------------------------------------------

--
-- Table structure for table `ps_print_sizes`
--

CREATE TABLE `ps_print_sizes` (
  `s_id` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `labels` varchar(32) NOT NULL,
  `div_value` int(11) NOT NULL,
  `type` enum('digital','large') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ps_print_sizes`
--

INSERT INTO `ps_print_sizes` (`s_id`, `cat_id`, `labels`, `div_value`, `type`) VALUES
(1, 1, 'Standard (3.5 x 2)', 2, 'digital'),
(2, 2, 'A9 Envelopes (5.75 x 8.75)', 2, 'digital'),
(3, 3, 'Letter (8.5 x 11)', 2, 'digital'),
(4, 4, 'Letter (8.5 x 11)', 2, 'digital'),
(5, 5, 'Tabloid (11 x 17)', 2, 'digital'),
(6, 6, 'Standard (1.5 x 11)', 2, 'digital'),
(7, 7, 'Small (2 x 3.5)', 2, 'digital'),
(8, 7, 'Long (1.5 x 4)', 2, 'digital'),
(9, 8, 'Small (0.75 x 1.5)', 2, 'digital'),
(10, 8, 'Large (4 x 6)', 2, 'digital'),
(11, 9, 'Letter w/Tab (8.5 x 11)', 2, 'digital'),
(12, 10, 'Arch A (9 x 12)', 2, 'digital'),
(13, 10, 'Letter (8.5 x 11)', 2, 'digital'),
(14, 10, 'Half Letter (5.5 x 8.5)', 2, 'digital'),
(15, 11, 'Half Letter (5.5 x 8.5)', 2, 'digital'),
(16, 12, 'Wall Calendar (9 x 12)', 2, 'digital'),
(17, 12, 'Sheet Calendar (8.5 x 11)', 2, 'digital'),
(18, 13, 'Standard (4.25 x 11)', 2, 'digital'),
(19, 14, 'Letter (8.5 x 11)', 1, 'digital'),
(20, 14, 'Half Sheet (5.5 x 8.5)', 2, 'digital'),
(21, 14, 'Quarter Sheet (4.25 x 5.5)', 4, 'digital'),
(22, 15, 'Letter (8.5 x 11)', 2, 'digital'),
(23, 16, 'Half Page (5.5 x 8.5)', 2, 'digital'),
(24, 16, 'Letter (8.5 x 11)', 2, 'digital'),
(25, 17, 'Small (4 x 6)', 2, 'digital'),
(26, 17, 'Medium (5 x 7)', 2, 'digital'),
(27, 17, 'Large (6 x 9)', 2, 'digital'),
(28, 18, 'Letter (8.5 x 11)', 2, 'digital'),
(29, 18, 'Large (13 x 19)', 2, 'digital'),
(30, 19, 'Letter (8.5 x 11)', 2, 'digital'),
(31, 20, 'Small (2 x 3)', 2, 'digital'),
(32, 21, 'Standard (11 x 1.25)', 2, 'digital');

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
  MODIFY `client_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=122;

--
-- AUTO_INCREMENT for table `ps_orders`
--
ALTER TABLE `ps_orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `ps_order_comments`
--
ALTER TABLE `ps_order_comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `ps_order_items`
--
ALTER TABLE `ps_order_items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- AUTO_INCREMENT for table `ps_print_sizes`
--
ALTER TABLE `ps_print_sizes`
  MODIFY `s_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

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
