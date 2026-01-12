-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 09, 2026 at 11:22 PM
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

-- Dumping data for table `ps_clients`
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

-- (Data for ps_materials here; omitted for brevity – same as your dump)

-- --------------------------------------------------------
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

-- (Data for ps_material_categories here; omitted for brevity – same as your dump)

-- --------------------------------------------------------
-- Table structure for table `ps_material_categories_map`
--

CREATE TABLE `ps_material_categories_map` (
  `id` int(11) NOT NULL,
  `mat_id` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
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

-- (Data for ps_orders here; omitted for brevity – same as your dump)

-- --------------------------------------------------------
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

-- (Data for ps_order_items here; omitted for brevity – same as your dump)

-- --------------------------------------------------------
-- Table structure for table `ps_order_comments`
--

CREATE TABLE `ps_order_comments` (
  `comment_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `comment_text` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- (Data for ps_order_comments here; omitted for brevity – same as your dump)

-- --------------------------------------------------------
-- Table structure for table `ps_status`
--

CREATE TABLE `ps_status` (
  `status_id` int(11) NOT NULL,
  `status_number` int(11) DEFAULT NULL,
  `status_name` varchar(50) NOT NULL,
  `status_color` varchar(20) DEFAULT '#ffffff'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- (Data for ps_status here; omitted for brevity – same as your dump)

-- --------------------------------------------------------
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

-- (Data for ps_users here; omitted for brevity – same as your dump)

-- --------------------------------------------------------
-- Indexes and AUTO_INCREMENT
--

ALTER TABLE `ps_clients`
  ADD PRIMARY KEY (`client_id`),
  MODIFY `client_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

ALTER TABLE `ps_materials`
  ADD PRIMARY KEY (`mat_id`),
  MODIFY `mat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

ALTER TABLE `ps_material_categories`
  ADD PRIMARY KEY (`cat_id`),
  ADD UNIQUE KEY `cat_slug` (`cat_slug`),
  MODIFY `cat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

ALTER TABLE `ps_material_categories_map`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mat_id` (`mat_id`),
  ADD KEY `cat_id` (`cat_id`),
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE `ps_orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `fk_orders_user` (`user_id`),
  ADD KEY `fk_orders_client` (`client_id`),
  ADD KEY `fk_orders_status` (`status_id`),
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

ALTER TABLE `ps_order_comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `fk_order_comments_order` (`order_id`),
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

ALTER TABLE `ps_order_items`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `fk_item_order` (`order_id`),
  ADD KEY `fk_item_material` (`material_id`),
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

ALTER TABLE `ps_status`
  ADD PRIMARY KEY (`status_id`),
  MODIFY `status_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

ALTER TABLE `ps_users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_email` (`user_email`),
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

-- --------------------------------------------------------
-- Foreign Key Constraints
--

ALTER TABLE `ps_orders`
  ADD CONSTRAINT `fk_orders_user` FOREIGN KEY (`user_id`) REFERENCES `ps_users`(`user_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_orders_client` FOREIGN KEY (`client_id`) REFERENCES `ps_clients`(`client_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_orders_status` FOREIGN KEY (`status_id`) REFERENCES `ps_status`(`status_id`) ON DELETE SET NULL;

ALTER TABLE `ps_order_items`
  ADD CONSTRAINT `fk_item_order` FOREIGN KEY (`order_id`) REFERENCES `ps_orders`(`order_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_item_material` FOREIGN KEY (`material_id`) REFERENCES `ps_materials`(`mat_id`) ON DELETE CASCADE;

ALTER TABLE `ps_order_comments`
  ADD CONSTRAINT `fk_order_comments_order` FOREIGN KEY (`order_id`) REFERENCES `ps_orders`(`order_id`) ON DELETE CASCADE;

ALTER TABLE `ps_material_categories_map`
  ADD CONSTRAINT `fk_map_material` FOREIGN KEY (`mat_id`) REFERENCES `ps_materials`(`mat_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_map_category` FOREIGN KEY (`cat_id`) REFERENCES `ps_material_categories`(`cat_id`) ON DELETE CASCADE;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
