-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 01, 2026 at 02:40 PM
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
-- Database: `gadget_store`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `status`) VALUES
(1, 'Phone', 'phn', 'Active'),
(2, 'Watch', 'smart watch', 'Active'),
(3, 'Laptops', 'laptop', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `customer_name` varchar(100) DEFAULT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `total_price` decimal(10,2) DEFAULT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `status` varchar(30) NOT NULL DEFAULT 'Pending',
  `order_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `customer_name`, `product_name`, `quantity`, `price`, `total_price`, `payment_method`, `status`, `order_date`) VALUES
(8, NULL, 'Dell Inspiron 15', 1, 85039.00, 85039.00, NULL, 'Delivered', '2026-08-26 17:27:34');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `price` int(11) NOT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `category` varchar(100) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_name`, `description`, `price`, `stock`, `category`, `image`, `status`) VALUES
(1, 'Dell Inspiron 15', '15.6 FHD, Intel i5 12th Gen, 8GB RAM, 512GB SSD', 85039, 0, '', NULL, 'Active'),
(2, 'Sony WH-CH520', 'Wireless On-Ear Headphones, Up to 50H Battery', 7287, 50, 'Laptops', 'uploads/product_6a8fe685cbed57.78950610.jpg', 'Active'),
(3, 'boAt Wave Flex', '1.83 Display, Bluetooth Calling, 100+ Sports Modes', 5000, 10, 'Watch', 'uploads/product_6a8fe03fc75824.89212989.png', 'Active'),
(4, 'Realme Buds T300', '30dB ANC, 360 Spatial Audio, 40H Total Playback', 6073, 50, 'Phone', 'uploads/product_6a8fdfeba0ab01.36360902.jpg', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `role`, `password`, `status`, `address`) VALUES
(3, 'AllFactOne', 'allfactone@gmail.com', '12345777', 'Customer', '$2y$10$ccyEQj9JlyxXyx4th/MF9e9DZedjdTlrGvFWBarHQRAkP7sm5RkCe', 'Active', ''),
(4, 'pallab', 'pallab@gmail.com', '0348752834', 'Delivery', '$2y$10$BpQ86h5Ip4sbW2Mid2eV4O8Mqw2D/Y7PxscYVdK9hUID32rW0Fma6', 'Inactive', ''),
(8, 'Amir Hamza', 'amirhamza0130078@gmail.com', '01611034934', 'Customer', '$2y$10$uWY3Bh9qygZTOCCe6Hjk0.kKO2WR19f5UxwH.xHBHeH5TFuaCVXR6', 'Active', 'Narsingdi Road, Monohardi.'),
(9, 'Amir Hamza', 'amirhamza@gmail.com', '01611034934', 'Customer', '$2y$10$mCR3Z0zZfi0.gUELmC/b/uBAa3GYEfaUY31bJp5JE7QnrDoocwbFG', 'Active', 'Narsingdi Road, Monohardi.'),
(10, 'Amir Hamza', 'amirhamza0@gmail.com', '01611034934', 'Admin', '$2y$10$mVO1.xEdheHuoMTNJIawIu5TirL7Xg5RqcJoBHadSQAgq7iGshpTC', 'Active', 'Narsingdi Road, Monohardi.'),
(11, 'Amir Hamza', 'pallab1@gmail.com', '01611034934', 'Customer', '$2y$10$EynxM104WwAAUEIk51sOwOTPlNcsXEqlAGzY9wyrhCx3XhYxDosFW', 'Active', 'Narsingdi Road, Monohardi.'),
(12, 'pallab', 'pallab100@gmail.com', '01611034934', 'Customer', '$2y$10$Hf42UIC7YiYlj4T09TuCVuUyt7A1wLhrj8GZc.x7ws9BxZUfAcN9S', 'Active', 'Khulna');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
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
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
