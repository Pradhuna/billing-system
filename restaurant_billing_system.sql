-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 19, 2024 at 05:08 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `restaurant_billing_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `billproducts`
--

CREATE TABLE `billproducts` (
  `id` int(11) NOT NULL,
  `bill_no` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `billproducts`
--

INSERT INTO `billproducts` (`id`, `bill_no`, `product_id`, `price`, `qty`) VALUES
(3, 159424, 34, '547.00', 3),
(4, 848065, 102, '180.00', 2),
(5, 483659, 106, '250.00', 1),
(6, 781201, 34, '547.00', 3),
(7, 486172, 107, '25.00', 7),
(9, 486172, 106, '250.00', 1),
(10, 486172, 104, '260.00', 4),
(11, 486172, 34, '547.00', 3),
(12, 486172, 234, '234.00', 2),
(13, 212383, 107, '25.00', 2),
(14, 212383, 106, '250.00', 1),
(15, 212383, 102, '180.00', 1),
(16, 870485, 106, '250.00', 1),
(17, 695255, 103, '60.00', 961);

-- --------------------------------------------------------

--
-- Table structure for table `bills`
--

CREATE TABLE `bills` (
  `id` int(11) NOT NULL,
  `bill_no` int(11) NOT NULL,
  `table_no` int(11) NOT NULL,
  `status` varchar(50) DEFAULT NULL,
  `sub_total` decimal(10,2) DEFAULT NULL,
  `discount` decimal(10,2) DEFAULT NULL,
  `tax` decimal(10,2) DEFAULT NULL,
  `vat` decimal(10,2) DEFAULT NULL,
  `grand_total` decimal(10,2) DEFAULT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bills`
--

INSERT INTO `bills` (`id`, `bill_no`, `table_no`, `status`, `sub_total`, `discount`, `tax`, `vat`, `grand_total`, `created_date`, `updated_date`) VALUES
(7, 870485, 51, 'paid', '250.00', '5.00', '0.00', '0.00', '237.50', '2024-06-17 16:48:55', '2024-06-18 14:43:01'),
(8, 159424, 12, 'pending', '1094.00', '0.00', '0.00', '0.00', '1094.00', '2024-06-17 16:53:14', '2024-06-17 16:53:14'),
(9, 848065, 121, 'pending', '360.00', '0.00', '0.00', '0.00', '360.00', '2024-06-17 16:53:38', '2024-06-17 16:53:38'),
(10, 483659, 1211, 'pending', '750.00', '0.00', '0.00', '0.00', '750.00', '2024-06-17 16:54:38', '2024-06-17 16:54:38'),
(11, 781201, 1, 'pending', '1094.00', '0.00', '0.00', '0.00', '1094.00', '2024-06-17 17:08:37', '2024-06-17 17:08:37'),
(12, 486172, 5, 'pending', '468.00', '0.00', '0.00', '0.00', '468.00', '2024-06-18 01:16:16', '2024-06-18 02:06:19'),
(13, 212383, 13, 'pending', '730.00', '0.00', '0.00', '0.00', '730.00', '2024-06-18 02:16:24', '2024-06-18 02:19:04'),
(14, 695255, 52, 'pending', '57660.00', '0.00', '0.00', '0.00', '57660.00', '2024-06-18 16:37:33', '2024-06-18 16:37:33');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` int(11) NOT NULL,
  `pid` int(11) DEFAULT NULL,
  `pname` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `pid`, `pname`, `price`, `qty`) VALUES
(1, 0, 'Burger', '0.00', 0),
(2, 0, 'Burger', '0.00', 0),
(3, 0, 'Burger', '0.00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`) VALUES
(102, 'Chicken Burger', '180.00'),
(103, 'Chowmein', '60.00'),
(104, 'Pizza', '260.00'),
(106, 'Sandwich', '250.00'),
(107, 'Water', '25.00'),
(108, 'Cold Drink', '80.00'),
(234, 'Chicken Wings', '234.00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `gender` enum('Male','Female','Other') DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `confirm_password` varchar(255) DEFAULT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `username`, `gender`, `password`, `confirm_password`, `role`) VALUES
(1, 'Gavin Arnold', 'sypetis@mailinator.com', '+1 (348) 788-72', 'vezyfeb', 'Male', '$2y$10$TG0ENQC.W4Xlm2PfV2zB/.DUwLLZo24ZiIN1eZSiv.xGGz3sDDgSG', NULL, 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `billproducts`
--
ALTER TABLE `billproducts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bill_no` (`bill_no`);

--
-- Indexes for table `bills`
--
ALTER TABLE `bills`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `bill_no` (`bill_no`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `billproducts`
--
ALTER TABLE `billproducts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `bills`
--
ALTER TABLE `bills`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=235;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `billproducts`
--
ALTER TABLE `billproducts`
  ADD CONSTRAINT `billproducts_ibfk_1` FOREIGN KEY (`bill_no`) REFERENCES `bills` (`bill_no`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
