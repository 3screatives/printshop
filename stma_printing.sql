-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 18, 2025 at 11:20 PM
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
  `client_stma_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ps_clients`
--

INSERT INTO `ps_clients` (`client_id`, `business_name`, `business_address`, `contact_name`, `contact_phone`, `contact_email`, `client_since`, `client_stma_id`) VALUES
(1, 'Alpha Print Co', '123 Main St, Chicago, IL', 'John Doe', '312-555-1212', 'john@alpha.com', '2022-01-10', 1001),
(2, 'Beta Signs LLC', '42 Market Ave, Dallas, TX', 'Sarah Lee', '214-555-8787', 'sarah@betasigns.com', '2023-03-15', 1002),
(3, 'Gamma Media', '77 Poster Ln, Miami, FL', 'Carlos Ruiz', '305-555-4321', 'carlos@gamma.com', '2021-07-05', 1003),
(4, 'Delta Prints', '890 Banner Rd, New York, NY', 'Ava Brown', '917-555-5678', 'ava@delta.com', '2020-10-22', 1004),
(5, 'Epsilon Visuals', '22 Wall St, Los Angeles, CA', 'Mike Green', '213-555-9988', 'mike@epsilon.com', '2024-01-05', 1005),
(7, 'New Company LLC', 'Somewhere here...', 'Sajjad Ali', '1234567890', 'abc@xyz.com', '2025-11-03', 1324),
(9, 'Kwik Corner', '2730 Hillcrest Dr, Balcones Heights TX 78228', 'Srikanth', '', 'quickcorner2@gmail.com', '2025-11-10', 2730),
(10, 'New Company LLC', 'here', 'Naail Ali', '7373812357', 'printing@mystma.com', '2025-11-12', 0),
(11, 'Hightime Smoke & Vape', '5935 Rittman Rd', 'Jasad', '8303578201', 'jassadmomin@hotmail.com', '2025-11-12', 0),
(12, 'Amazing Stop', '-', 'Kahir Charolia', '2106395078', '', '2025-11-12', 0),
(14, 'Shipley Donuts', '7875 Kitty Hawk Rd, Converse, TX 78109', 'Zakir Mehmood', '210-840-2733', 'zakirmehmood2002@yahoo.com', '2025-11-12', 0);

-- --------------------------------------------------------

--
-- Table structure for table `ps_materials`
--

CREATE TABLE `ps_materials` (
  `mat_id` int(11) NOT NULL,
  `mat_vendor` varchar(64) DEFAULT NULL,
  `mat_name` varchar(255) NOT NULL,
  `mat_details` text DEFAULT NULL,
  `mat_roll_size` int(11) NOT NULL,
  `mat_length` int(11) NOT NULL,
  `mat_size` int(11) NOT NULL,
  `mat_cost` decimal(10,6) NOT NULL,
  `ink_cost` decimal(10,6) NOT NULL,
  `mat_added_on` date NOT NULL DEFAULT curdate(),
  `cat_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ps_materials`
--

INSERT INTO `ps_materials` (`mat_id`, `mat_vendor`, `mat_name`, `mat_details`, `mat_roll_size`, `mat_length`, `mat_size`, `mat_cost`, `ink_cost`, `mat_added_on`, `cat_id`) VALUES
(1, 'Lexjet', 'Adhesive', '4WM66A - HP Prime Matte Air GP, 3.4 Mil', 54, 150, 1800, 217.070000, 0.003400, '2025-10-11', 4),
(2, 'Lexjet', 'Backlit', 'KBLGS60 - Kodak glossy backlit film', 60, 100, 1200, 300.000000, 0.003400, '2025-10-11', 10),
(3, 'Grimco', 'Banner Matte', 'DTXB54164M - 13OZ DURATEX BANNER MATTE', 54, 164, 1968, 179.590000, 0.003400, '2025-10-11', 1),
(4, 'Reece Supply', 'Banner Gloss', 'JFM160050 - SUPERPRINT PLUS GLOSS ULTRAFLEX 13OZ BRIGHT', 63, 164, 1968, 175.480000, 0.003400, '2025-10-11', 1),
(5, '', 'Print Only', 'N/A', 0, 0, 0, 0.000000, 0.003400, '2025-10-11', NULL),
(6, 'Lexjet', 'Clear Adhesive', 'GF 206-54 - Clear Gloss Vinyl, Removeable', 54, 150, 1800, 230.000000, 0.003400, '2025-10-11', NULL),
(7, 'Grimco', 'Coroplast', 'CP84W - Corrugated Plastic Panels 48\" x 96\", White', 48, 96, 1152, 8.630000, 0.003400, '2025-10-11', 3),
(8, 'Grimco', 'Floor Sticker', '', 54, 150, 1800, 0.000000, 0.003400, '2025-10-11', NULL),
(9, 'Reece Supply', 'Foam Board', 'Pn 122718 - 3/16 White Foam Board', 48, 96, 1152, 15.130000, 0.003400, '2025-10-11', 6),
(10, 'Lexjet', 'Regular Paper', '', 36, 200, 2400, 0.000000, 0.003400, '2025-10-11', 2),
(11, 'Lexjet', 'Polypropylene', 'ERWP36200 - LexJet Heavyweight WR Polypropylene - 36in x 200ft', 36, 200, 2400, 106.250000, 0.003400, '2025-10-11', 2),
(12, 'Grimco', 'Polystyrene 020', 'UH020W4896A - White Styrene Matte 020 Thick', 48, 96, 1152, 8.840000, 0.003400, '2025-10-11', 6),
(13, 'Grimco', 'Polystyrene 040', 'HIPS48X96X040W - Duratex Polystyrene Sheets - Double White', 48, 96, 1152, 18.840000, 0.003400, '2025-10-11', 6),
(14, 'Lexjet', 'Static Cling', '207-5415 - GF-207 Clear', 54, 150, 1800, 260.090000, 0.003400, '2025-10-11', NULL),
(15, 'Reece Supply', 'Window Perforated', 'Pn 55599 - UltraVision Window Perf 60/40 UV 6.3 Mil', 54, 164, 1968, 326.830000, 0.003400, '2025-10-11', 5),
(16, 'Grimco', 'Aluminum', 'MM843MWDP - MAXMETAL™ 4\' x 8\', White DP, EACH', 48, 96, 1152, 48.910000, 0.003400, '2025-10-11', 8),
(17, 'Grimco', 'Acrylic - Clear', 'CC4896316C - Duratex Cast Acrylic 48\" x 96\", Clear, 3/16\"', 48, 96, 1152, 106.970000, 0.003400, '2025-10-11', 9),
(18, 'Grimco', 'Acrylic - White', 'CC4896316W7328 - Duratex Cast Acrylic 48\" x 96\", White 7328, 3/16\"', 48, 96, 1152, 113.680000, 0.003400, '2025-10-11', 9),
(19, 'Lexjet', 'Polyester', '142SGC30\r - LexJet Clear Polyester SUV - 30in x 100ft', 30, 100, 1200, 229.000000, 0.003400, '2025-10-11', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ps_material_categories`
--

CREATE TABLE `ps_material_categories` (
  `cat_id` int(11) NOT NULL,
  `cat_name` varchar(100) NOT NULL,
  `cat_description` text DEFAULT NULL,
  `cat_image` varchar(255) DEFAULT NULL,
  `cat_slug` varchar(255) DEFAULT NULL,
  `cat_group` varchar(100) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ps_material_categories`
--

INSERT INTO `ps_material_categories` (`cat_id`, `cat_name`, `cat_description`, `cat_image`, `cat_slug`, `cat_group`) VALUES
(1, 'Banner', 'Vinyl and mesh banners for indoor or outdoor use', 'banner', 'banner', 'Large Format'),
(2, 'Poster', 'Posters and photo paper prints', 'poster', 'poster', 'Large Format'),
(3, 'Yard Sign', 'Corrugated plastic yard signs', 'yard', 'yard', 'Large Format'),
(4, 'Window Sticker', 'Adhesive vinyl stickers for windows', 'window-sticker', 'window-sticker', 'Large Format'),
(5, 'Window Perforated', 'Perforated see-through window film', 'window-perforated', 'window-perforated', 'Large Format'),
(6, 'Indoor Sign', 'Foam board or styrene indoor signs', 'indoor', 'indoor', 'Large Format'),
(7, 'Pump Topper', 'Signs used on gas pump displays', 'pump-topper', 'pump-topper', 'Large Format'),
(8, 'Metal Sign', 'Durable aluminum signage', 'metal', 'metal', 'Large Format'),
(9, 'Acrylic Sign', 'Acrylic signs, clear or white', 'acrylic', 'acrylic', 'Large Format'),
(10, 'Backlit Sign', 'Film for lightbox or display backlit signs', 'backlit', 'backlit', 'Large Format');

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
  `status_id` int(11) DEFAULT NULL,
  `order_comment` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ps_orders`
--

INSERT INTO `ps_orders` (`order_id`, `order_date`, `order_due`, `user_id`, `order_before_tax`, `order_tax`, `order_after_tax`, `order_amount_paid`, `order_amount_due`, `order_discount`, `order_credits`, `order_production_time`, `payment_type_id`, `client_id`, `status_id`, `order_comment`) VALUES
(1, '2024-06-01', '2024-06-03', 1, 120.00, 10.80, 130.80, 100.00, 30.80, NULL, NULL, 1, 1, 1, 9, 'Rush order'),
(2, '2024-06-05', '2024-06-07', 2, 300.00, 27.00, 327.00, 327.00, 0.00, NULL, NULL, 1, 2, 2, 10, 'Standard delivery'),
(3, '2024-06-10', '2024-06-12', 1, 450.00, 40.50, 490.50, 490.50, 0.00, NULL, NULL, 1, 1, 3, 11, 'Client requested proof'),
(24, '2025-11-12', '2025-11-17', 1, 33.00, 2.72, 35.72, 0.00, 35.72, NULL, NULL, 1, 1, 7, 12, 'Testing\nNew\nSomething'),
(25, '2025-11-12', '2025-11-17', 1, 29.00, 2.39, 31.39, 0.00, 31.39, NULL, NULL, 1, 3, 11, 11, 'Re-design/Fix sizes'),
(26, '2025-11-12', '2025-11-17', 1, 563.00, 46.45, 609.45, 0.00, 609.45, NULL, NULL, 1, 1, 12, 10, '- Designs have been made and sent to contact'),
(31, '2025-11-12', '2025-11-17', 1, 24.00, 1.98, 25.98, 25.98, 0.00, NULL, NULL, 1, 1, 14, 9, '- Designs have been sent');

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
  `item_total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ps_order_items`
--

INSERT INTO `ps_order_items` (`item_id`, `order_id`, `material_id`, `item_details`, `item_quantity`, `item_size_width`, `item_size_height`, `item_grommets`, `item_price`, `item_total`) VALUES
(1, 1, 1, 'Poster Print 24x36', 2, 24.00, 36.00, 0, 60.00, 120.00),
(2, 2, 2, 'Banner 48x72 with grommets', 1, 48.00, 72.00, 1, 300.00, 300.00),
(3, 3, 3, 'Vinyl decal set', 3, 12.00, 12.00, 0, 150.00, 450.00),
(39, 24, 16, 'Sign', 1, 24.00, 36.00, 0, 14.00, 14.00),
(40, 24, 1, 'Sticker', 1, 24.00, 36.00, 0, 19.00, 19.00),
(41, 25, 1, 'Labels/Stickers', 1, 54.00, 54.00, 0, 29.00, 29.00),
(42, 26, 1, 'Pizza Slice, Fountain Drink, $4.99', 1, 24.00, 36.00, 0, 19.00, 19.00),
(43, 26, 1, 'Wings, Fries, Fountain Drink, $9.99', 1, 24.00, 36.00, 0, 19.00, 19.00),
(44, 26, 1, 'Hunt Brothers Whole Cheese Pizza, $8.99', 1, 55.00, 45.00, 0, 47.00, 47.00),
(45, 26, 1, 'Hunt Brothers Whole Pepperoni Pizza, $11.99', 1, 56.00, 45.00, 0, 48.00, 48.00),
(46, 26, 1, 'Corn Dog, Burrito, Egg Roll, Fries (2 pieces, 5 ft each)', 1, 120.00, 18.00, 0, 67.00, 67.00),
(47, 26, 1, 'Egg & Cheese Sandwich, Hashbrowns, Coffee, $5.99 (2 pieces, 5 ft each)', 1, 120.00, 18.00, 0, 67.00, 67.00),
(48, 26, 1, 'Text, 1 sign per item: Beer, Wine, Soda, Lotto, Snack, Fountain Drinks, Coffee, Slushy', 8, 55.00, 10.00, 0, 27.00, 216.00),
(49, 26, 1, 'No Back Pack Signs', 10, 8.00, 11.00, 0, 6.00, 60.00),
(50, 26, 6, '1 Per Combo', 4, 6.00, 24.00, 0, 5.00, 20.00),
(51, 31, 16, 'Drive Thru Sign', 1, 18.00, 18.00, 0, 6.00, 24.00);

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
(1, 'Admin User', 'admin@stma.com', 'admin123', 'admin', '2024-01-01'),
(2, 'Manager One', 'manager1@stma.com', 'managerpass', 'manager', '2024-02-10'),
(3, 'Viewer One', 'viewer1@stma.com', 'viewerpass', 'viewer', '2024-03-05');

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
  ADD PRIMARY KEY (`mat_id`),
  ADD KEY `fk_material_category` (`cat_id`);

--
-- Indexes for table `ps_material_categories`
--
ALTER TABLE `ps_material_categories`
  ADD PRIMARY KEY (`cat_id`);

--
-- Indexes for table `ps_orders`
--
ALTER TABLE `ps_orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `fk_orders_user` (`user_id`),
  ADD KEY `fk_orders_client` (`client_id`),
  ADD KEY `fk_orders_status` (`status_id`);

--
-- Indexes for table `ps_order_items`
--
ALTER TABLE `ps_order_items`
  ADD PRIMARY KEY (`item_id`);

--
-- Indexes for table `ps_status`
--
ALTER TABLE `ps_status`
  ADD PRIMARY KEY (`status_id`);

--
-- Indexes for table `ps_users`
--
ALTER TABLE `ps_users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ps_clients`
--
ALTER TABLE `ps_clients`
  MODIFY `client_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `ps_materials`
--
ALTER TABLE `ps_materials`
  MODIFY `mat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `ps_material_categories`
--
ALTER TABLE `ps_material_categories`
  MODIFY `cat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `ps_orders`
--
ALTER TABLE `ps_orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `ps_order_items`
--
ALTER TABLE `ps_order_items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

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
-- Constraints for table `ps_materials`
--
ALTER TABLE `ps_materials`
  ADD CONSTRAINT `fk_material_category` FOREIGN KEY (`cat_id`) REFERENCES `ps_material_categories` (`cat_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `ps_orders`
--
ALTER TABLE `ps_orders`
  ADD CONSTRAINT `fk_orders_client` FOREIGN KEY (`client_id`) REFERENCES `ps_clients` (`client_id`),
  ADD CONSTRAINT `fk_orders_status` FOREIGN KEY (`status_id`) REFERENCES `ps_status` (`status_id`),
  ADD CONSTRAINT `fk_orders_user` FOREIGN KEY (`user_id`) REFERENCES `ps_users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
