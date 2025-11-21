-- ========================================================
-- STMA Printing Database - Full Optimized Dump
-- ========================================================

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- --------------------------------------------------------
-- Table: ps_clients
-- --------------------------------------------------------
CREATE TABLE `ps_clients` (
  `client_id` INT(11) NOT NULL AUTO_INCREMENT,
  `business_name` VARCHAR(150) NOT NULL,
  `business_address` TEXT DEFAULT NULL,
  `contact_name` VARCHAR(150) NOT NULL,
  `contact_phone` VARCHAR(20) DEFAULT NULL,
  `contact_email` VARCHAR(100) DEFAULT NULL,
  `client_since` DATE NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `client_stma_id` INT(11) DEFAULT NULL,
  PRIMARY KEY (`client_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
-- Table: ps_material_categories
-- --------------------------------------------------------
CREATE TABLE `ps_material_categories` (
  `cat_id` INT(11) NOT NULL AUTO_INCREMENT,
  `cat_name` VARCHAR(100) NOT NULL,
  `cat_description` TEXT DEFAULT NULL,
  `cat_image` VARCHAR(255) DEFAULT NULL,
  `cat_slug` VARCHAR(255) NOT NULL UNIQUE,
  `cat_group` VARCHAR(100) NOT NULL DEFAULT '',
  `cat_section` VARCHAR(100) DEFAULT '',
  `cat_order` INT(11) DEFAULT 0,
  PRIMARY KEY (`cat_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
(10, 'Backlit Sign', 'Film for lightbox or display backlit signs', 'backlit', 'backlit', 'Large Format', 'Banner Stands', 2);

-- --------------------------------------------------------
-- Table: ps_materials
-- --------------------------------------------------------
CREATE TABLE `ps_materials` (
  `mat_id` INT(11) NOT NULL AUTO_INCREMENT,
  `mat_vendor` VARCHAR(64) DEFAULT NULL,
  `mat_name` VARCHAR(255) NOT NULL,
  `mat_details` TEXT DEFAULT NULL,
  `mat_roll_size` INT(11) NOT NULL,
  `mat_length` INT(11) NOT NULL,
  `mat_size` INT(11) NOT NULL,
  `mat_cost` DECIMAL(10,6) NOT NULL,
  `ink_cost` DECIMAL(10,6) NOT NULL,
  `mat_added_on` DATE NOT NULL DEFAULT CURRENT_DATE,
  `cat_id` INT(11) DEFAULT NULL,
  PRIMARY KEY (`mat_id`),
  KEY `fk_material_category` (`cat_id`),
  CONSTRAINT `fk_material_category` FOREIGN KEY (`cat_id`) REFERENCES `ps_material_categories`(`cat_id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `ps_materials` (`mat_id`, `mat_vendor`, `mat_name`, `mat_details`, `mat_roll_size`, `mat_length`, `mat_size`, `mat_cost`, `ink_cost`, `mat_added_on`, `cat_id`) VALUES
(1, 'Lexjet', 'Adhesive', '4WM66A - HP Prime Matte Air GP, 3.4 Mil', 54, 150, 1800, 217.07, 0.0034, '2025-10-11', 6),
(2, 'Lexjet', 'Backlit', 'KBLGS60 - Kodak glossy backlit film', 60, 100, 1200, 300.00, 0.0034, '2025-10-11', 10),
(3, 'Grimco', 'Banner Matte', 'DTXB54164M - 13OZ DURATEX BANNER MATTE', 54, 164, 1968, 179.59, 0.0034, '2025-10-11', 1),
(4, 'Reece Supply', 'Banner Gloss', 'JFM160050 - SUPERPRINT PLUS GLOSS ULTRAFLEX 13OZ BRIGHT', 63, 164, 1968, 175.48, 0.0034, '2025-10-11', 1),
(5, '', 'Print Only', 'N/A', 0, 0, 0, 0, 0.0034, '2025-10-11', NULL),
(6, 'Lexjet', 'Clear Adhesive', 'GF 206-54 - Clear Gloss Vinyl, Removeable', 54, 150, 1800, 230.00, 0.0034, '2025-10-11', NULL),
(7, 'Grimco', 'Coroplast', 'CP84W - Corrugated Plastic Panels 48" x 96", White', 48, 96, 1152, 8.63, 0.0034, '2025-10-11', 3),
(8, 'Grimco', 'Floor Sticker', '', 54, 150, 1800, 0, 0.0034, '2025-10-11', NULL),
(9, 'Reece Supply', 'Foam Board', 'Pn 122718 - 3/16 White Foam Board', 48, 96, 1152, 15.13, 0.0034, '2025-10-11', 6),
(10, 'Lexjet', 'Regular Paper', '', 36, 200, 2400, 0, 0.0034, '2025-10-11', 2);

-- --------------------------------------------------------
-- Table: ps_users
-- --------------------------------------------------------
CREATE TABLE `ps_users` (
  `user_id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_name` VARCHAR(100) NOT NULL,
  `user_email` VARCHAR(100) NOT NULL UNIQUE,
  `user_password` VARCHAR(255) NOT NULL,
  `user_type` ENUM('admin','manager','viewer') NOT NULL,
  `user_creation_date` DATE NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `ps_users` (`user_id`, `user_name`, `user_email`, `user_password`, `user_type`, `user_creation_date`) VALUES
(1, 'Admin User', 'admin@stma.com', 'admin123', 'admin', '2024-01-01'),
(2, 'Manager One', 'manager1@stma.com', 'managerpass', 'manager', '2024-02-10'),
(3, 'Viewer One', 'viewer1@stma.com', 'viewerpass', 'viewer', '2024-03-05');

-- --------------------------------------------------------
-- Table: ps_status
-- --------------------------------------------------------
CREATE TABLE `ps_status` (
  `status_id` INT(11) NOT NULL AUTO_INCREMENT,
  `status_number` INT(11) DEFAULT NULL,
  `status_name` VARCHAR(50) NOT NULL,
  `status_color` VARCHAR(20) DEFAULT '#ffffff',
  PRIMARY KEY (`status_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
-- Table: ps_orders
-- --------------------------------------------------------
CREATE TABLE `ps_orders` (
  `order_id` INT(11) NOT NULL AUTO_INCREMENT,
  `order_date` DATE NOT NULL,
  `order_due` DATE DEFAULT NULL,
  `user_id` INT(11) NOT NULL,
  `order_before_tax` DECIMAL(10,2) DEFAULT NULL,
  `order_tax` DECIMAL(10,2) DEFAULT NULL,
  `order_after_tax` DECIMAL(10,2) DEFAULT NULL,
  `order_amount_paid` DECIMAL(10,2) DEFAULT NULL,
  `order_amount_due` DECIMAL(10,2) DEFAULT NULL,
  `order_discount` DECIMAL(10,2) DEFAULT NULL,
  `order_credits` DECIMAL(10,2) DEFAULT NULL,
  `order_production_time` INT(11) DEFAULT NULL,
  `payment_type_id` INT(11) DEFAULT NULL,
  `client_id` INT(11) DEFAULT NULL,
  `status_id` INT(11) DEFAULT NULL,
  `order_comment` TEXT NOT NULL,
  PRIMARY KEY (`order_id`),
  KEY `fk_orders_user` (`user_id`),
  KEY `fk_orders_client` (`client_id`),
  KEY `fk_orders_status` (`status_id`),
  CONSTRAINT `fk_orders_user` FOREIGN KEY (`user_id`) REFERENCES `ps_users`(`user_id`) ON DELETE CASCADE,
  CONSTRAINT `fk_orders_client` FOREIGN KEY (`client_id`) REFERENCES `ps_clients`(`client_id`) ON DELETE CASCADE,
  CONSTRAINT `fk_orders_status` FOREIGN KEY (`status_id`) REFERENCES `ps_status`(`status_id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Orders data
INSERT INTO `ps_orders` (`order_id`, `order_date`, `order_due`, `user_id`, `order_before_tax`, `order_tax`, `order_after_tax`, `order_amount_paid`, `order_amount_due`, `order_discount`, `order_credits`, `order_production_time`, `payment_type_id`, `client_id`, `status_id`, `order_comment`) VALUES
(1, '2024-06-01', '2024-06-03', 1, 120.00, 10.80, 130.80, 100.00, 30.80, NULL, NULL, 1, 1, 1, 9, 'Rush order'),
(2, '2024-06-05', '2024-06-07', 2, 300.00, 27.00, 327.00, 327.00, 0.00, NULL, NULL, 1, 2, 2, 10, 'Standard delivery'),
(3, '2024-06-10', '2024-06-12', 1, 450.00, 40.50, 490.50, 490.50, 0.00, NULL, NULL, 1, 1, 3, 11, 'Client requested proof'),
(24, '2025-11-12', '2025-11-17', 1, 33.00, 2.72, 35.72, 0.00, 35.72, NULL, NULL, 1, 1, 7, 12, 'Testing\nNew\nSomething'),
(25, '2025-11-12', '2025-11-17', 1, 29.00, 2.39, 31.39, 0.00, 31.39, NULL, NULL, 1, 3, 11, 11, 'Re-design/Fix sizes'),
(26, '2025-11-12', '2025-11-17', 1, 563.00, 46.45, 609.45, 0.00, 609.45, NULL, NULL, 1, 1, 12, 10, '- Designs have been made and sent to contact'),
(31, '2025-11-12', '2025-11-17', 1, 24.00, 1.98, 25.98, 25.98, 0.00, NULL, NULL, 1, 1, 14, 9, '- Designs have been sent');

-- --------------------------------------------------------
-- Table: ps_order_items
-- --------------------------------------------------------
CREATE TABLE `ps_order_items` (
  `item_id` INT(11) NOT NULL AUTO_INCREMENT,
  `order_id` INT(11) NOT NULL,
  `material_id` INT(11) NOT NULL,
  `item_details` TEXT DEFAULT NULL,
  `item_quantity` INT(11) NOT NULL,
  `item_size_width` DECIMAL(10,2) DEFAULT NULL,
  `item_size_height` DECIMAL(10,2) DEFAULT NULL,
  `item_grommets` TINYINT(1) DEFAULT 0,
  `item_price` DECIMAL(10,2) NOT NULL,
  `item_total` DECIMAL(10,2) NOT NULL,
  PRIMARY KEY (`item_id`),
  KEY `fk_item_order` (`order_id`),
  KEY `fk_item_material` (`material_id`),
  CONSTRAINT `fk_item_order` FOREIGN KEY (`order_id`) REFERENCES `ps_orders`(`order_id`) ON DELETE CASCADE,
  CONSTRAINT `fk_item_material` FOREIGN KEY (`material_id`) REFERENCES `ps_materials`(`mat_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Order items data
INSERT INTO `ps_order_items` (`item_id`, `order_id`, `material_id`, `item_details`, `item_quantity`, `item_size_width`, `item_size_height`, `item_grommets`, `item_price`, `item_total`) VALUES
(1, 1, 1, 'Poster Print 24x36', 2, 24.00, 36.00, 0, 60.00, 120.00),
(2, 2, 2, 'Banner 48x72 with grommets', 1, 48.00, 72.00, 1, 300.00, 300.00),
(3, 3, 3, 'Vinyl decal set', 3, 12.00, 12.00, 0, 150.00, 450.00),
(4, 24, 5, 'Test Item', 1, 8.00, 8.00, 0, 33.00, 33.00),
(5, 25, 7, 'Coroplast Yard Sign', 1, 24.00, 18.00, 0, 29.00, 29.00),
(6, 26, 6, 'Clear Adhesive Print', 5, 12.00, 24.00, 0, 112.60, 563.00),
(7, 31, 9, 'Foam Board Small', 1, 12.00, 12.00, 0, 24.00, 24.00);

COMMIT;
