-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 20, 2026 at 10:39 PM
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
(1, 'Grimco', 'Acrylic - Clear', 'large', 'CC4896316C - Duratex Cast Acrylic 48\" x 96\", Clear, 3/16\"', 60, 120, 120, 172.190000, 3.00, 0.003400, '0000-00-00'),
(2, 'Grimco', 'Acrylic - White', 'large', 'CC4896316W7328 - Duratex Cast Acrylic 48\" x 96\", White 7328, 3/16\"', 60, 120, 120, 184.370000, 3.00, 0.003400, '0000-00-00'),
(3, 'Lexjet', 'Adhesive', 'large', '4WM66A - HP Prime Matte Air GP, 3.4 Mil', 54, 150, 1800, 217.070000, 3.00, 0.003400, '0000-00-00'),
(4, 'Grimco', 'Aluminum', 'large', 'MM843MWDP - MAXMETAL™ 4\' x 8\', White DP, EACH', 60, 120, 120, 86.320000, 3.00, 0.003400, '0000-00-00'),
(5, 'Lexjet', 'Backlit', 'large', 'KBLGS60 - Kodak glossy backlit film', 60, 100, 1200, 300.000000, 3.00, 0.003400, '0000-00-00'),
(6, 'Clampitt', 'Banner Gloss', 'large', '86005371	Maxbanner Gloss, 13oz	54\"x164\'', 54, 164, 1968, 124.200000, 3.00, 0.003400, '0000-00-00'),
(7, 'Clampitt', 'Banner Matte', 'large', '8600537	Maxbanner Matte, 13oz	54\"x164\'', 54, 164, 1968, 124.200000, 3.00, 0.003400, '0000-00-00'),
(8, 'Lexjet', 'Bond Paper', 'large', 'Canon Economy Bond Paper (75gsm)', 36, 200, 2400, 109.610000, 1.50, 0.003400, '0000-00-00'),
(9, 'Lexjet', 'Clear Adhesive', 'large', 'GF 206-54 - Clear Gloss Vinyl, Removeable', 54, 150, 1800, 230.000000, 3.00, 0.003400, '0000-00-00'),
(10, 'Clampitt', 'Coroplast', 'large', '58263908	Centrlplas 60x120-4mm	60\"x120\"', 60, 120, 120, 13.250000, 6.00, 0.003400, '0000-00-00'),
(11, 'Grimco', 'Floor Sticker', 'large', 'OLFL-30954, Briteline Floor Film Overlaminate - OLFL309 54 \" x 150 \'', 54, 150, 1800, 368.990000, 3.00, 0.003400, '0000-00-00'),
(12, 'Reece Supply', 'Foam Board', 'large', 'Pn 122718 - 3/16 White Foam Board', 48, 96, 96, 15.130000, 6.00, 0.003400, '0000-00-00'),
(13, 'Lexjet', 'Polyester', 'large', '142SGC30\r - LexJet Clear Polyester SUV - 30in x 100ft', 30, 100, 1200, 229.000000, 3.00, 0.003400, '0000-00-00'),
(14, 'Lexjet', 'Polypropylene', 'large', 'ERWP36200 - LexJet Heavyweight WR Polypropylene - 36in x 200ft', 36, 200, 2400, 106.250000, 3.00, 0.003400, '0000-00-00'),
(15, 'Grimco', 'Polystyrene 020', 'large', 'HIPS60XC0X020W, Duratex Polystyrene Sheets - Double White 60\" x 120\", .020\"', 60, 120, 120, 15.380000, 4.00, 0.003400, '0000-00-00'),
(16, 'Grimco', 'Polystyrene 040', 'large', 'HIPS60XC0X040W, Duratex Polystyrene Sheets - Double White 60\" x 120\", .040\"', 60, 96, 120, 30.750000, 4.00, 0.003400, '0000-00-00'),
(17, 'Lexjet', 'Static Cling', 'large', '207-5415 - GF-207 Clear', 54, 150, 1800, 260.090000, 3.00, 0.003400, '0000-00-00'),
(18, 'Reece Supply', 'Window Perforated', 'large', 'Pn 55599 - UltraVision Window Perf 60/40 UV 6.3 Mil', 54, 164, 1968, 326.830000, 3.00, 0.003400, '0000-00-00'),
(19, 'Clampitt', 'Magnet', 'large', '860145 - Newlife Magnetics 48x50ft 15mil', 48, 50, 600, 177.000000, 3.00, 0.003400, '0000-00-00'),
(20, 'Clampitt', 'Matte - Paper - Light', 'digital', 'Accent Opaque Smooth - 60lb Matte Text', 9, 0, 11, 0.016010, 1.00, 0.043000, '0000-00-00'),
(21, 'Clampitt', 'Matte - Paper - Standard', 'digital', 'Accent Opaque Smooth - 80lb Matte Text', 13, 0, 19, 0.070940, 1.00, 0.043000, '0000-00-00'),
(22, 'Clampitt', 'Matte - Paper - Heavy', 'digital', 'Accent Opaque Smooth - 100lb Matte Text', 13, 0, 19, 0.088670, 1.00, 0.043000, '0000-00-00'),
(23, 'Clampitt', 'Matte - Cardstock - Thin', 'digital', 'Accent Opaque Smooth - 80lb Matte Cover', 13, 0, 19, 0.132150, 1.00, 0.043000, '0000-00-00'),
(24, 'Clampitt', 'Matte - Cardstock - Standard', 'digital', 'Accent Opaque Smooth - 100lb Matte Cover', 13, 0, 19, 0.154710, 1.00, 0.043000, '0000-00-00'),
(25, 'Clampitt', 'Matte - Cardstock - Thick', 'digital', 'Accent Opaque Smooth - 110lb Matte Cover', 9, 0, 11, 0.185530, 1.00, 0.043000, '0000-00-00'),
(26, 'Clampitt', 'Gloss - Paper - Standard', 'digital', 'Blazer - 80lb Gloss Text', 13, 0, 19, 0.071970, 1.00, 0.043000, '0000-00-00'),
(27, 'Clampitt', 'Gloss - Paper - Thick', 'digital', 'Blazer - 100lb Gloss Text', 13, 0, 19, 0.080440, 1.00, 0.043000, '0000-00-00'),
(28, 'Clampitt', 'Gloss - Cardstock - Thin', 'digital', 'Blazer - 80lb Gloss Cover', 13, 0, 19, 0.119290, 1.00, 0.043000, '0000-00-00'),
(29, 'Clampitt', 'Gloss - Cardstock - Standard', 'digital', 'Blazer - 100lb Gloss Cover', 13, 0, 19, 0.149080, 1.00, 0.043000, '0000-00-00'),
(30, 'Clampitt', 'Gloss - Cardstock - Thick', 'digital', 'Blazer - 110lb Gloss Cover', 13, 0, 19, 0.183460, 1.00, 0.043000, '0000-00-00'),
(31, 'Clampitt', 'Gloss - Cardstock - Regular', 'digital', '10pt White Tango Coated C2S Board - 87lb Gloss Cover', 13, 0, 19, 0.168730, 1.00, 0.043000, '0000-00-00'),
(32, 'Office Depot', 'A9 Envelopes', 'digital', '', 6, 0, 9, 0.170000, 1.00, 0.043000, '0000-00-00'),
(33, 'Office Depot', '#10 Envelopes', 'digital', '', 4, 0, 10, 0.070000, 1.00, 0.043000, '0000-00-00'),
(34, 'Uline', 'Catalog Envelope', 'digital', '', 10, 0, 13, 0.240000, 1.00, 0.043000, '0000-00-00'),
(35, 'Lexjet', '4ups - Removeable', 'digital', '', 4, 0, 6, 0.400000, 1.00, 0.043000, '0000-00-00'),
(36, 'Desktop Supplies', '4ups - Permanent', 'digital', '', 4, 0, 6, 0.140000, 1.00, 0.043000, '0000-00-00'),
(37, 'Online Labels', 'Small Labels', 'digital', '', 1, 0, 2, 0.030000, 1.00, 0.043000, '0000-00-00'),
(38, 'Online Labels', 'Round Labels', 'digital', '', 2, 0, 2, 0.040000, 1.00, 0.043000, '0000-00-00'),
(39, '', 'Shelf Strips', 'digital', '', 9, 0, 11, 0.185530, 1.00, 0.043000, '0000-00-00');

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
(6, 20, 3),
(7, 21, 3),
(8, 22, 3),
(9, 26, 3),
(10, 27, 3),
(11, 20, 4),
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
(28, 20, 10),
(29, 21, 10),
(30, 22, 10),
(31, 23, 10),
(32, 24, 10),
(33, 25, 10),
(34, 26, 10),
(35, 27, 10),
(36, 28, 10),
(37, 29, 10),
(38, 30, 10),
(39, 20, 11),
(40, 21, 11),
(41, 22, 11),
(42, 26, 11),
(43, 27, 11),
(44, 20, 12),
(45, 21, 12),
(46, 22, 12),
(47, 23, 12),
(48, 24, 12),
(49, 25, 12),
(50, 26, 12),
(51, 27, 12),
(52, 28, 12),
(53, 29, 12),
(54, 30, 12),
(55, 31, 13),
(56, 20, 14),
(57, 21, 14),
(58, 22, 14),
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
(78, 20, 19),
(79, 21, 19),
(80, 31, 20),
(81, 39, 21),
(82, 1, 22),
(83, 2, 22),
(84, 1, 23),
(85, 2, 23),
(86, 15, 23),
(87, 16, 23),
(88, 5, 24),
(89, 1, 25),
(90, 2, 25),
(91, 6, 26),
(92, 7, 26),
(93, 14, 26),
(94, 6, 27),
(95, 7, 27),
(96, 6, 28),
(97, 7, 28),
(98, 6, 29),
(99, 7, 29),
(100, 14, 29),
(101, 12, 30),
(102, 14, 31),
(103, 15, 31),
(104, 11, 32),
(105, 14, 33),
(106, 14, 34),
(107, 3, 35),
(108, 4, 36),
(109, 10, 36),
(110, 15, 37),
(111, 16, 37),
(112, 4, 38),
(113, 10, 38),
(114, 16, 38),
(115, 10, 39),
(116, 3, 40),
(117, 9, 40),
(118, 17, 40),
(119, 18, 41),
(120, 8, 42),
(121, 3, 43),
(122, 9, 43),
(123, 4, 44),
(124, 10, 44),
(125, 3, 45),
(126, 10, 45);

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
(45, '2025-12-17', '2025-12-22', 3, 475.00, 31.35, 411.35, 0.00, 411.35, 20.00, 0.00, 1, 1, 10, 12),
(46, '2026-01-20', '2026-01-26', 2, 0.31, 0.02, 0.27, 0.00, 0.27, 20.00, 0.00, 1, 1, 14, 1);

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
(18, 31, 'hello new order', '2026-01-09 09:27:59'),
(19, 45, 'new', '2026-01-20 10:55:15');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=127;

--
-- AUTO_INCREMENT for table `ps_orders`
--
ALTER TABLE `ps_orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `ps_order_comments`
--
ALTER TABLE `ps_order_comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `ps_order_items`
--
ALTER TABLE `ps_order_items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;

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
