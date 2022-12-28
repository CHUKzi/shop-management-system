-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 28, 2022 at 07:26 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lal`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `cart_by` int(11) NOT NULL,
  `ProductID` int(11) NOT NULL,
  `PayORDelivery` varchar(40) DEFAULT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `cart_by`, `ProductID`, `PayORDelivery`, `time`) VALUES
(597, 32, 11, 'Card Payment', '2022-06-17 12:36:49'),
(598, 32, 10, 'Card Payment', '2022-06-17 12:36:57'),
(599, 32, 9, 'Card Payment', '2022-06-17 12:37:00'),
(600, 32, 8, 'Card Payment', '2022-06-17 12:37:08'),
(604, 32, 11, 'Card Payment', '2022-06-18 07:46:04'),
(605, 32, 10, 'Card Payment', '2022-06-18 07:46:10');

-- --------------------------------------------------------

--
-- Table structure for table `contact_us`
--

CREATE TABLE `contact_us` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `email` varchar(40) NOT NULL,
  `message` varchar(500) NOT NULL,
  `is_deleted` int(11) DEFAULT NULL,
  `time` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `favorite`
--

CREATE TABLE `favorite` (
  `id` int(11) NOT NULL,
  `fav_by` int(11) NOT NULL,
  `ProductID` int(11) NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `OrderBy` int(11) NOT NULL,
  `PayType` varchar(50) NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `OrderBy`, `PayType`, `time`) VALUES
(588, 32, 'Card Payment', '2022-06-17 12:37:39'),
(589, 32, 'Card Payment', '2022-06-18 07:46:50');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(60) NOT NULL,
  `product_image` varchar(40) NOT NULL,
  `product_category` varchar(40) NOT NULL,
  `product_price` int(11) NOT NULL,
  `product_disc` varchar(500) DEFAULT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `product_image`, `product_category`, `product_price`, `product_disc`, `time`) VALUES
(4, 'Hand Tools', '62ac70597645c-1655468121.png', 'Agricultural-tools', 1250, 'A simple random sample is a randomly selected subset of a population. In this sampling method, each member of the population has an exactly equal chance of being selected.', '2022-06-17 12:15:21'),
(5, 'Simple Hand Tools', '62ac709873471-1655468184.jpg', 'Agricultural-tools', 950, 'A simple random sample is a randomly selected subset of a population. In this sampling method, each member of the population has an exactly equal chance of being selected.', '2022-06-17 12:16:24'),
(6, 'Dual Tool Kit', '62ac713f8960e-1655468351.jpg', 'Agricultural-tools', 1300, 'A simple random sample is a randomly selected subset of a population. In this sampling method, each member of the population has an exactly equal chance of being selected', '2022-06-17 12:19:11'),
(7, 'Black Plastic Flower Pot', '62ac7200aea96-1655468544.jpg', 'flower-pot', 450, 'A simple random sample is a randomly selected subset of a population. In this sampling method, each member of the population has an exactly equal chance of being selected', '2022-06-17 12:22:24'),
(8, '9cm Square Plant Pots (18 Pack)', '62ac7275982f4-1655468661.jpg', 'flower-pot', 1150, 'A simple random sample is a randomly selected subset of a population. In this sampling method, each member of the population has an exactly equal chance of being selected', '2022-06-17 12:24:21'),
(9, 'Carrot normal seeds (Hybrid)', '62ac73db290ec-1655469019.jpg', 'normal-seeds', 870, 'A simple random sample is a randomly selected subset of a population. In this sampling method, each member of the population has an exactly equal chance of being selected', '2022-06-17 12:30:19'),
(10, 'TrustBasket Enriched Organic', '62ac744e2017b-1655469134.jpg', 'normal-seeds', 750, 'A simple random sample is a randomly selected subset of a population. In this sampling method, each member of the population has an exactly equal chance of being selected', '2022-06-17 12:32:14'),
(11, 'TrustBasket Vermicompost for Plants', '62ac74c3e9097-1655469251.jpg', 'normal-seeds', 580, 'A simple random sample is a randomly selected subset of a population. In this sampling method, each member of the population has an exactly equal chance of being selected', '2022-06-17 12:34:11');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `contact_number` int(12) DEFAULT NULL,
  `password` varchar(40) NOT NULL,
  `email` varchar(75) NOT NULL,
  `province` varchar(30) DEFAULT NULL,
  `district` varchar(50) DEFAULT NULL,
  `address` varchar(50) DEFAULT NULL,
  `is_deleted` tinyint(4) DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `acountType` varchar(15) NOT NULL,
  `regi_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `contact_number`, `password`, `email`, `province`, `district`, `address`, `is_deleted`, `last_login`, `acountType`, `regi_date`) VALUES
(32, 'Royan', 'Harsha', 771234567, '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'royanharsha6@gmail.com', 'Southern', 'Galle', 'Hiyare ', NULL, '2022-06-18 13:15:42', 'user', '2022-06-18 07:45:42'),
(33, 'Aswanna', 'admin', 763456789, 'f865b53623b121fd34ee5426c792e5c33af8c227', 'admin@gmail.com', 'Southern', 'Galle', '257/23 Wakwalla Rode', NULL, '2022-06-18 13:13:38', 'admin', '2022-06-18 07:43:38');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_us`
--
ALTER TABLE `contact_us`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `favorite`
--
ALTER TABLE `favorite`
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
  ADD PRIMARY KEY (`product_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=606;

--
-- AUTO_INCREMENT for table `contact_us`
--
ALTER TABLE `contact_us`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `favorite`
--
ALTER TABLE `favorite`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=590;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=590;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
