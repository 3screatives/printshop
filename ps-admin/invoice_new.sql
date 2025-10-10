-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 24, 2025 at 03:57 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `invoice_new`
--

-- --------------------------------------------------------

--
-- Table structure for table `ps_clients`
--

CREATE TABLE `ps_clients` (
  `client_id` int(11) NOT NULL,
  `client_name` varchar(150) NOT NULL,
  `client_address` text DEFAULT NULL,
  `client_phone` varchar(20) DEFAULT NULL,
  `client_email` varchar(100) DEFAULT NULL,
  `client_since` date NOT NULL,
  `client_stma_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ps_clients`
--

INSERT INTO `ps_clients` (`client_id`, `client_name`, `client_address`, `client_phone`, `client_email`, `client_since`, `client_stma_id`) VALUES
(1, 'Sunshine Print Co.', '123 Main St, Houston, TX', '123-456-7890', 'contact@sunshineprint.com', '2023-05-01', NULL),
(2, 'Vision Signs', '456 Elm Rd, Austin, TX', '987-654-3210', 'hello@visionsigns.com', '2022-11-20', 4054);

-- --------------------------------------------------------

--
-- Table structure for table `ps_ink`
--

CREATE TABLE `ps_ink` (
  `ink_id` int(11) NOT NULL,
  `ink_type` varchar(50) NOT NULL,
  `ink_cost` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ps_ink`
--

INSERT INTO `ps_ink` (`ink_id`, `ink_type`, `ink_cost`) VALUES
(1, 'EFI', 2.50),
(2, 'Canon', 1.80);

-- --------------------------------------------------------

--
-- Table structure for table `ps_materials`
--

CREATE TABLE `ps_materials` (
  `material_id` int(11) NOT NULL,
  `material_code` varchar(20) NOT NULL,
  `material_name` varchar(100) NOT NULL,
  `material_type` enum('roll','sheet') NOT NULL,
  `material_roll_size` varchar(50) DEFAULT NULL,
  `material_cost` decimal(10,2) NOT NULL,
  `material_size` varchar(50) DEFAULT NULL,
  `ink_cost` int(11) DEFAULT NULL,
  `material_stock` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ps_materials`
--

INSERT INTO `ps_materials` (`material_id`, `material_code`, `material_name`, `material_type`, `material_roll_size`, `material_cost`, `material_size`, `ink_cost`, `material_stock`) VALUES
(1, '101', 'Poster', 'roll', '36.00', 95.95, '2400', 1, 1),
(2, '102', 'Banner', 'roll', '54.00', 143.67, '1968', 1, 1),
(3, '103', 'Corrugated Plastic', 'roll', '48.00', 30.00, '96', 1, 1),
(12, '104', 'Foam Board', 'roll', '48.00', 38.00, '96', 1, 1),
(13, '105', 'Adhesive', 'roll', '54.00', 179.42, '1200', 1, 1),
(14, '106', 'Adhesive Clear', 'roll', '54.00', 230.00, '1800', 1, 1),
(15, '107', 'Window Perforated', 'roll', '54.00', 558.71, '1200', 1, 1),
(16, '108', 'Regular Paper 8.5x11', 'sheet', '0.00', 0.02, '0', 2, 1),
(17, '109', 'Backlit', 'roll', '54.00', 238.50, '1800', 1, 1),
(18, '110', 'Glossy 12x18', 'sheet', '0.00', 0.09, '0', 2, 1),
(19, '111', 'Card Stock 8.5x11', 'sheet', '0.00', 0.10, '0', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `ps_orders`
--

CREATE TABLE `ps_orders` (
  `order_id` int(11) NOT NULL,
  `order_date` datetime NOT NULL,
  `order_due` datetime DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `order_before_tax` decimal(10,2) DEFAULT NULL,
  `order_tax` decimal(10,2) DEFAULT NULL,
  `order_after_tax` decimal(10,2) DEFAULT NULL,
  `order_amount_paid` decimal(10,2) DEFAULT NULL,
  `order_amount_due` decimal(10,2) DEFAULT NULL,
  `order_production_time` int(11) DEFAULT NULL,
  `payment_type_id` int(11) DEFAULT NULL,
  `client_id` int(11) DEFAULT NULL,
  `status_id` int(11) DEFAULT NULL,
  `order_comment` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ps_orders`
--

INSERT INTO `ps_orders` (`order_id`, `order_date`, `order_due`, `user_id`, `order_before_tax`, `order_tax`, `order_after_tax`, `order_amount_paid`, `order_amount_due`, `order_production_time`, `payment_type_id`, `client_id`, `status_id`, `order_comment`) VALUES
(1, '2025-07-01 10:00:00', '2025-07-03 15:00:00', 1, 100.00, 8.25, 108.25, 50.00, 58.25, 48, 2, 1, 2, 'test 1'),
(2, '2025-07-01 11:00:00', '2025-07-05 12:00:00', 2, 75.00, 6.19, 81.19, 81.19, 0.00, 24, 1, 2, 3, 'test 2');

-- --------------------------------------------------------

--
-- Table structure for table `ps_order_designs`
--

CREATE TABLE `ps_order_designs` (
  `o_design_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `o_design_json` longtext NOT NULL,
  `o_created_at` datetime DEFAULT current_timestamp(),
  `o_updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
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
  `item_total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ps_order_items`
--

INSERT INTO `ps_order_items` (`item_id`, `order_id`, `material_id`, `item_details`, `item_quantity`, `item_size_width`, `item_size_height`, `item_grommets`, `item_price`, `item_total`) VALUES
(1, 1, 1, 'Outdoor Vinyl Banner for summer sale', 2, 4.00, 2.00, 1, 25.00, 50.00),
(2, 1, 2, 'Yard Sign Coroplast for real estate', 4, 2.00, 1.50, 1, 12.00, 48.00),
(3, 2, 3, 'Poster prints on photo paper', 5, 2.00, 3.00, 0, 15.00, 75.00);

-- --------------------------------------------------------

--
-- Table structure for table `ps_payment_type`
--

CREATE TABLE `ps_payment_type` (
  `payment_type_id` int(11) NOT NULL,
  `payment_type` varchar(50) NOT NULL,
  `payment_type_allowed` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ps_payment_type`
--

INSERT INTO `ps_payment_type` (`payment_type_id`, `payment_type`, `payment_type_allowed`) VALUES
(1, 'Cash', 1),
(2, 'Credit Card', 1),
(3, 'PayPal', 1),
(4, 'Invoice Billing', 0);

-- --------------------------------------------------------

--
-- Table structure for table `ps_status`
--

CREATE TABLE `ps_status` (
  `status_id` int(11) NOT NULL,
  `status_number` int(11) DEFAULT NULL CHECK (`status_number` between 0 and 6),
  `status_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ps_status`
--

INSERT INTO `ps_status` (`status_id`, `status_number`, `status_name`) VALUES
(1, 0, 'All'),
(2, 1, 'New'),
(3, 2, 'Designing'),
(4, 3, 'Printing'),
(5, 4, 'Ready for Pickup'),
(6, 5, 'Completed'),
(7, 6, 'Canceled');

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
(1, 'Alice Smith', 'alice@example.com', '482c811da5d5b4bc6d497ffa98491e38', 'admin', '2024-01-10'),
(2, 'Bob Jones', 'bob@example.com', 'c25846bdbf27696caa5541a474e9521b', 'manager', '2024-02-15'),
(3, 'Charlie Brown', 'charlie@example.com', '49e5e739ea41d635246cd9cd21af17c4', 'viewer', '2024-03-01');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ps_clients`
--
ALTER TABLE `ps_clients`
  ADD PRIMARY KEY (`client_id`);

--
-- Indexes for table `ps_ink`
--
ALTER TABLE `ps_ink`
  ADD PRIMARY KEY (`ink_id`);

--
-- Indexes for table `ps_materials`
--
ALTER TABLE `ps_materials`
  ADD PRIMARY KEY (`material_id`),
  ADD UNIQUE KEY `material_code` (`material_code`),
  ADD KEY `ink_cost` (`ink_cost`);

--
-- Indexes for table `ps_orders`
--
ALTER TABLE `ps_orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `payment_type_id` (`payment_type_id`),
  ADD KEY `client_id` (`client_id`),
  ADD KEY `status_id` (`status_id`);

--
-- Indexes for table `ps_order_designs`
--
ALTER TABLE `ps_order_designs`
  ADD PRIMARY KEY (`o_design_id`),
  ADD UNIQUE KEY `order_id` (`order_id`);

--
-- Indexes for table `ps_order_items`
--
ALTER TABLE `ps_order_items`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `material_id` (`material_id`);

--
-- Indexes for table `ps_payment_type`
--
ALTER TABLE `ps_payment_type`
  ADD PRIMARY KEY (`payment_type_id`);

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
  MODIFY `client_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `ps_ink`
--
ALTER TABLE `ps_ink`
  MODIFY `ink_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `ps_materials`
--
ALTER TABLE `ps_materials`
  MODIFY `material_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `ps_orders`
--
ALTER TABLE `ps_orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=302;

--
-- AUTO_INCREMENT for table `ps_order_designs`
--
ALTER TABLE `ps_order_designs`
  MODIFY `o_design_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ps_order_items`
--
ALTER TABLE `ps_order_items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ps_payment_type`
--
ALTER TABLE `ps_payment_type`
  MODIFY `payment_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `ps_status`
--
ALTER TABLE `ps_status`
  MODIFY `status_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

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
  ADD CONSTRAINT `ps_materials_ibfk_1` FOREIGN KEY (`ink_cost`) REFERENCES `ps_ink` (`ink_id`);

--
-- Constraints for table `ps_orders`
--
ALTER TABLE `ps_orders`
  ADD CONSTRAINT `ps_orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `ps_users` (`user_id`),
  ADD CONSTRAINT `ps_orders_ibfk_2` FOREIGN KEY (`payment_type_id`) REFERENCES `ps_payment_type` (`payment_type_id`),
  ADD CONSTRAINT `ps_orders_ibfk_3` FOREIGN KEY (`client_id`) REFERENCES `ps_clients` (`client_id`),
  ADD CONSTRAINT `ps_orders_ibfk_4` FOREIGN KEY (`status_id`) REFERENCES `ps_status` (`status_id`);

--
-- Constraints for table `ps_order_items`
--
ALTER TABLE `ps_order_items`
  ADD CONSTRAINT `ps_order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `ps_orders` (`order_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ps_order_items_ibfk_2` FOREIGN KEY (`material_id`) REFERENCES `ps_materials` (`material_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
