-- ==========================================
-- ✅ 1. TABLE DEFINITIONS WITH PRIMARY KEYS
-- ==========================================

DROP TABLE IF EXISTS ps_order_items, ps_orders, ps_clients, ps_users, ps_status;

CREATE TABLE `ps_clients` (
  `client_id` int(11) NOT NULL AUTO_INCREMENT,
  `business_name` varchar(150) NOT NULL,
  `business_address` text DEFAULT NULL,
  `contact_name` varchar(150) NOT NULL,
  `contact_phone` varchar(20) DEFAULT NULL,
  `contact_email` varchar(100) DEFAULT NULL,
  `client_since` date NOT NULL,
  `client_stma_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`client_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `ps_materials` (
  `mat_id` int(11) NOT NULL AUTO_INCREMENT,
  `mat_vendor` varchar(64) DEFAULT NULL,
  `mat_name` varchar(255) NOT NULL,
  `mat_details` text DEFAULT NULL,
  `mat_roll_size` int(11) NOT NULL,
  `mat_length` int(11) NOT NULL,
  `mat_size` int(11) NOT NULL,
  `mat_cost` decimal(10,6) NOT NULL,
  `ink_cost` decimal(10,6) NOT NULL,
  `mat_added_on` date NOT NULL DEFAULT curdate(),
  PRIMARY KEY (`mat_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `ps_users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(100) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_type` enum('admin','manager','viewer') NOT NULL,
  `user_creation_date` date NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `ps_status` (
  `status_id` int(11) NOT NULL AUTO_INCREMENT,
  `status_number` int(11) DEFAULT NULL,
  `status_name` varchar(50) NOT NULL,
  PRIMARY KEY (`status_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `ps_orders` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
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
  `order_comment` text NOT NULL,
  PRIMARY KEY (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `ps_order_items` (
  `item_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `material_id` int(11) NOT NULL,
  `item_details` text DEFAULT NULL,
  `item_quantity` int(11) NOT NULL,
  `item_size_width` decimal(10,2) DEFAULT NULL,
  `item_size_height` decimal(10,2) DEFAULT NULL,
  `item_grommets` tinyint(1) DEFAULT 0,
  `item_price` decimal(10,2) NOT NULL,
  `item_total` decimal(10,2) NOT NULL,
  PRIMARY KEY (`item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ==========================================
-- ✅ 2. DUMMY DATA
-- ==========================================

-- ps_clients
INSERT INTO `ps_clients` (`business_name`, `business_address`, `contact_name`, `contact_phone`, `contact_email`, `client_since`, `client_stma_id`) VALUES
('Alpha Print Co', '123 Main St, Chicago, IL', 'John Doe', '312-555-1212', 'john@alpha.com', '2022-01-10', 1001),
('Beta Signs LLC', '42 Market Ave, Dallas, TX', 'Sarah Lee', '214-555-8787', 'sarah@betasigns.com', '2023-03-15', 1002),
('Gamma Media', '77 Poster Ln, Miami, FL', 'Carlos Ruiz', '305-555-4321', 'carlos@gamma.com', '2021-07-05', 1003),
('Delta Prints', '890 Banner Rd, New York, NY', 'Ava Brown', '917-555-5678', 'ava@delta.com', '2020-10-22', 1004),
('Epsilon Visuals', '22 Wall St, Los Angeles, CA', 'Mike Green', '213-555-9988', 'mike@epsilon.com', '2024-01-05', 1005);

-- ps_users
INSERT INTO `ps_users` (`user_name`, `user_email`, `user_password`, `user_type`, `user_creation_date`) VALUES
('Admin User', 'admin@stma.com', 'admin123', 'admin', '2024-01-01'),
('Manager One', 'manager1@stma.com', 'managerpass', 'manager', '2024-02-10'),
('Viewer One', 'viewer1@stma.com', 'viewerpass', 'viewer', '2024-03-05');

-- ps_status
INSERT INTO `ps_status` (`status_number`, `status_name`) VALUES
(1, 'Quote/Draft'),
(2, 'Order Confirmed'),
(3, 'Design Started'),
(4, 'Awaiting Approval'),
(5, 'Awaiting Material'),
(6, 'Ready to Print'),
(7, 'Ready for Pickup'),
(8, 'Payment Pending'),
(9, 'Order Completed'),
(10, 'No Response'),
(11, 'Canceled Orders');

-- ps_orders
INSERT INTO `ps_orders` (`order_date`, `order_due`, `user_id`, `order_before_tax`, `order_tax`, `order_after_tax`, `order_amount_paid`, `order_amount_due`, `order_production_time`, `payment_type_id`, `client_id`, `status_id`, `order_comment`) VALUES
('2024-06-01 10:00:00', '2024-06-03 17:00:00', 1, 120.00, 10.80, 130.80, 100.00, 30.80, 3, 1, 1, 2, 'Rush order'),
('2024-06-05 09:30:00', '2024-06-07 15:00:00', 2, 300.00, 27.00, 327.00, 327.00, 0.00, 5, 2, 2, 3, 'Standard delivery'),
('2024-06-10 12:00:00', '2024-06-12 17:00:00', 1, 450.00, 40.50, 490.50, 490.50, 0.00, 4, 1, 3, 4, 'Client requested proof'),
('2024-06-12 11:00:00', '2024-06-15 17:00:00', 2, 800.00, 72.00, 872.00, 600.00, 272.00, 6, 2, 4, 6, 'Large format print job');

-- ps_order_items (assuming material_id 1–5 exist)
INSERT INTO `ps_order_items` (`order_id`, `material_id`, `item_details`, `item_quantity`, `item_size_width`, `item_size_height`, `item_grommets`, `item_price`, `item_total`) VALUES
(1, 1, 'Poster Print 24x36', 2, 24.00, 36.00, 0, 60.00, 120.00),
(2, 2, 'Banner 48x72 with grommets', 1, 48.00, 72.00, 1, 300.00, 300.00),
(3, 3, 'Vinyl decal set', 3, 12.00, 12.00, 0, 150.00, 450.00),
(4, 4, 'Large wall print', 1, 96.00, 48.00, 0, 800.00, 800.00);

-- ==========================================
-- ✅ 3. FOREIGN KEYS (AFTER DUMP)
-- ==========================================
ALTER TABLE `ps_orders`
  ADD CONSTRAINT `fk_orders_user` FOREIGN KEY (`user_id`) REFERENCES `ps_users` (`user_id`),
  ADD CONSTRAINT `fk_orders_client` FOREIGN KEY (`client_id`) REFERENCES `ps_clients` (`client_id`),
  ADD CONSTRAINT `fk_orders_status` FOREIGN KEY (`status_id`) REFERENCES `ps_status` (`status_id`);

ALTER TABLE `ps_order_items`
  ADD CONSTRAINT `fk_items_order` FOREIGN KEY (`order_id`) REFERENCES `ps_orders` (`order_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_items_material` FOREIGN KEY (`material_id`) REFERENCES `ps_materials` (`mat_id`);
