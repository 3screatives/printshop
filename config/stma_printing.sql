-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 09, 2025 at 11:59 PM
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
-- Table structure for table `materials`
--

CREATE TABLE `materials` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `cost_per_sq_in` decimal(10,6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `materials`
--

INSERT INTO `materials` (`id`, `name`, `cost_per_sq_in`) VALUES
(1, 'Adhesive', 195.000000),
(2, 'Canvas', 0.080000),
(3, 'Paper', 0.040000);

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
  `mat_added_on` date NOT NULL DEFAULT curdate()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ps_materials`
--

INSERT INTO `ps_materials` (`mat_id`, `mat_vendor`, `mat_name`, `mat_details`, `mat_roll_size`, `mat_length`, `mat_size`, `mat_cost`, `ink_cost`, `mat_added_on`) VALUES
(2, 'Lexjet', 'Adhesive', '4WM66A - HP Prime Matte Air GP, 3.4 Mil', 54, 150, 1800, 217.070000, 0.003400, '0000-00-00'),
(3, 'Lexjet', 'Backlit', 'KBLGS60 - Kodak glossy backlit film', 60, 100, 1200, 300.000000, 0.003400, '0000-00-00'),
(4, 'Grimco', 'Banner Matte', 'DTXB54164M - 13OZ DURATEX BANNER MATTE', 54, 164, 1968, 179.590000, 0.003400, '0000-00-00'),
(5, 'Reece Supply', 'Banner Gloss', 'JFM160050 - SUPERPRINT PLUS GLOSS ULTRAFLEX 13OZ BRIGHT', 63, 164, 1968, 175.480000, 0.003400, '0000-00-00'),
(6, '', 'Print Only', 'N/A', 0, 0, 0, 0.000000, 0.003400, '0000-00-00'),
(7, 'Lexjet', 'Clear Adhesive', 'GF 206-54 - Clear Gloss Vinyl, Removeable', 54, 150, 1800, 230.000000, 0.003400, '0000-00-00'),
(8, 'Grimco', 'Coroplast', 'CP84W - Corrugated Plastic Panels 48\" x 96\", White', 48, 96, 1152, 8.630000, 0.003400, '0000-00-00'),
(9, 'Grimco', 'Floor Sticker', '', 54, 150, 1800, 0.000000, 0.003400, '0000-00-00'),
(10, 'Reece Supply', 'Foam Board', 'Pn 122718 - 3/16 White Foam Board', 48, 96, 1152, 15.130000, 0.003400, '0000-00-00'),
(11, 'Lexjet', 'Regular Paper', '', 36, 200, 2400, 0.000000, 0.003400, '0000-00-00'),
(12, 'Lexjet', 'Polypropylene', 'ERWP36200 - LexJet Heavyweight WR Polypropylene - 36in x 200ft', 36, 200, 2400, 106.250000, 0.003400, '0000-00-00'),
(13, 'Grimco', 'Polystyrene 020', 'UH020W4896A - White Styrene Matte 020 Thick', 48, 96, 1152, 8.840000, 0.003400, '0000-00-00'),
(14, 'Grimco', 'Polystyrene 040', 'HIPS48X96X040W - Duratex Polystyrene Sheets - Double White', 48, 96, 1152, 18.840000, 0.003400, '0000-00-00'),
(15, 'Lexjet', 'Static Cling', '207-5415 - GF-207 Clear', 54, 150, 1800, 260.090000, 0.003400, '0000-00-00'),
(16, 'Reece Supply', 'Window Perforated', 'Pn 55599 - UltraVision Window Perf 60/40 UV 6.3 Mil', 54, 164, 1968, 326.830000, 0.003400, '0000-00-00'),
(17, 'Grimco', 'Aluminum', 'MM843MWDP - MAXMETAL™ 4\' x 8\', White DP, EACH', 48, 96, 1152, 48.910000, 0.003400, '0000-00-00'),
(18, 'Grimco', 'Acrylic - Clear', 'CC4896316C - Duratex Cast Acrylic 48\" x 96\", Clear, 3/16\"', 48, 96, 1152, 106.970000, 0.003400, '0000-00-00'),
(19, 'Grimco', 'Acrylic - White', 'CC4896316W7328 - Duratex Cast Acrylic 48\" x 96\", White 7328, 3/16\"', 48, 96, 1152, 113.680000, 0.003400, '0000-00-00'),
(20, 'Lexjet', 'Polyester', '142SGC30\r - LexJet Clear Polyester SUV - 30in x 100ft', 30, 100, 1200, 229.000000, 0.003400, '0000-00-00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `materials`
--
ALTER TABLE `materials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ps_materials`
--
ALTER TABLE `ps_materials`
  ADD PRIMARY KEY (`mat_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `materials`
--
ALTER TABLE `materials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ps_materials`
--
ALTER TABLE `ps_materials`
  MODIFY `mat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
