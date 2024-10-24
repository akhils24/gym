-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 03, 2024 at 07:36 PM
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
-- Database: `gym`
--

-- --------------------------------------------------------

--
-- Table structure for table `card`
--

CREATE TABLE `card` (
  `card_id` int(5) NOT NULL,
  `customer_id` int(5) DEFAULT NULL,
  `card_no` bigint(20) NOT NULL,
  `card_holder` varchar(30) NOT NULL,
  `exp_date` date NOT NULL,
  `cvv` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cart_child`
--

CREATE TABLE `cart_child` (
  `cart_child_id` int(5) NOT NULL,
  `cart_master_id` int(5) DEFAULT NULL,
  `item_id` int(5) DEFAULT NULL,
  `cart_qty` decimal(10,0) NOT NULL,
  `item_rate` decimal(8,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cart_master`
--

CREATE TABLE `cart_master` (
  `cart_master_id` int(5) NOT NULL,
  `customer_id` int(5) DEFAULT NULL,
  `cart_status` varchar(10) NOT NULL,
  `cart_tot_amt` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `cat_id` int(5) NOT NULL,
  `cat_name` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `courier`
--

CREATE TABLE `courier` (
  `courier_id` int(5) NOT NULL,
  `username` varchar(20) DEFAULT NULL,
  `staff_id` int(5) DEFAULT NULL,
  `co_name` varchar(15) NOT NULL,
  `co_city` varchar(20) NOT NULL,
  `co_dist` varchar(20) NOT NULL,
  `co_pin` varchar(20) NOT NULL,
  `co_street` varchar(20) NOT NULL,
  `co_phone` decimal(10,0) NOT NULL,
  `co_status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `customer_id` int(5) NOT NULL,
  `username` varchar(20) DEFAULT NULL,
  `c_fname` varchar(10) NOT NULL,
  `c_lname` varchar(10) NOT NULL,
  `c_phno` decimal(10,0) NOT NULL,
  `c_street` varchar(10) NOT NULL,
  `c_dist` varchar(20) NOT NULL,
  `c_gender` varchar(1) NOT NULL,
  `c_dob` date NOT NULL,
  `c_status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `c_assign`
--

CREATE TABLE `c_assign` (
  `cassign_id` int(5) NOT NULL,
  `cart_master_id` int(5) DEFAULT NULL,
  `courier_id` int(5) DEFAULT NULL,
  `cassign_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `delivery`
--

CREATE TABLE `delivery` (
  `delivery_id` int(5) NOT NULL,
  `cassign_id` int(5) DEFAULT NULL,
  `del_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

CREATE TABLE `item` (
  `item_id` int(5) NOT NULL,
  `subcat_id` int(5) DEFAULT NULL,
  `item_name` varchar(15) NOT NULL,
  `item_desc` varchar(20) NOT NULL,
  `item_image` longblob DEFAULT NULL,
  `item_price` decimal(10,2) NOT NULL,
  `item_profit` int(5) NOT NULL,
  `item_status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `username` varchar(20) NOT NULL,
  `password` varchar(7) NOT NULL,
  `user_type` varchar(2) NOT NULL,
  `login_status` bit(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `pay_id` int(5) NOT NULL,
  `cart_master_id` int(5) DEFAULT NULL,
  `card_id` int(5) DEFAULT NULL,
  `pay_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_child`
--

CREATE TABLE `purchase_child` (
  `pur_child_id` int(5) NOT NULL,
  `pur_master_id` int(5) DEFAULT NULL,
  `item_id` int(5) DEFAULT NULL,
  `pur_qty` int(5) NOT NULL,
  `unit_price` decimal(10,0) NOT NULL,
  `tot_price` decimal(10,2) NOT NULL,
  `stock` int(5) NOT NULL,
  `sell_price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_master`
--

CREATE TABLE `purchase_master` (
  `pur_master_id` int(5) NOT NULL,
  `staff_id` int(5) DEFAULT NULL,
  `vendor_id` int(5) DEFAULT NULL,
  `pur_date` date NOT NULL,
  `pur_tot_amt` decimal(5,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `staff_id` int(5) NOT NULL,
  `username` varchar(20) DEFAULT NULL,
  `s_fname` varchar(10) NOT NULL,
  `s_lname` varchar(10) NOT NULL,
  `s_phno` decimal(10,0) NOT NULL,
  `s_street` varchar(10) NOT NULL,
  `s_dist` varchar(20) NOT NULL,
  `s_gender` varchar(1) NOT NULL,
  `s_dob` date NOT NULL,
  `s_status` bit(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subcategory`
--

CREATE TABLE `subcategory` (
  `subcat_id` int(5) NOT NULL,
  `cat_id` int(5) DEFAULT NULL,
  `subcat_name` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vendor`
--

CREATE TABLE `vendor` (
  `vendor_id` int(5) NOT NULL,
  `username` varchar(20) DEFAULT NULL,
  `staff_id` int(5) DEFAULT NULL,
  `v_fname` varchar(10) NOT NULL,
  `v_phno` decimal(10,0) NOT NULL,
  `v_street` varchar(10) NOT NULL,
  `v_dist` varchar(20) NOT NULL,
  `v_state` varchar(20) NOT NULL,
  `v_status` bit(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `card`
--
ALTER TABLE `card`
  ADD PRIMARY KEY (`card_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `cart_child`
--
ALTER TABLE `cart_child`
  ADD PRIMARY KEY (`cart_child_id`),
  ADD KEY `cart_master_id` (`cart_master_id`),
  ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `cart_master`
--
ALTER TABLE `cart_master`
  ADD PRIMARY KEY (`cart_master_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`cat_id`);

--
-- Indexes for table `courier`
--
ALTER TABLE `courier`
  ADD PRIMARY KEY (`courier_id`),
  ADD UNIQUE KEY `co_phone` (`co_phone`),
  ADD KEY `username` (`username`),
  ADD KEY `staff_id` (`staff_id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customer_id`),
  ADD KEY `username` (`username`);

--
-- Indexes for table `c_assign`
--
ALTER TABLE `c_assign`
  ADD PRIMARY KEY (`cassign_id`),
  ADD KEY `cart_master_id` (`cart_master_id`),
  ADD KEY `courier_id` (`courier_id`);

--
-- Indexes for table `delivery`
--
ALTER TABLE `delivery`
  ADD PRIMARY KEY (`delivery_id`),
  ADD KEY `cassign_id` (`cassign_id`);

--
-- Indexes for table `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`item_id`),
  ADD UNIQUE KEY `item_image` (`item_image`) USING HASH,
  ADD KEY `subcat_id` (`subcat_id`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`pay_id`),
  ADD KEY `cart_master_id` (`cart_master_id`),
  ADD KEY `card_id` (`card_id`);

--
-- Indexes for table `purchase_child`
--
ALTER TABLE `purchase_child`
  ADD PRIMARY KEY (`pur_child_id`),
  ADD KEY `pur_master_id` (`pur_master_id`),
  ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `purchase_master`
--
ALTER TABLE `purchase_master`
  ADD PRIMARY KEY (`pur_master_id`),
  ADD KEY `staff_id` (`staff_id`),
  ADD KEY `vendor_id` (`vendor_id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`staff_id`),
  ADD KEY `username` (`username`);

--
-- Indexes for table `subcategory`
--
ALTER TABLE `subcategory`
  ADD PRIMARY KEY (`subcat_id`),
  ADD KEY `cat_id` (`cat_id`);

--
-- Indexes for table `vendor`
--
ALTER TABLE `vendor`
  ADD PRIMARY KEY (`vendor_id`),
  ADD KEY `username` (`username`),
  ADD KEY `staff_id` (`staff_id`);

--
-- Constraints for dumped tables
--
ALTER TABLE `card` MODIFY `card_id` INT AUTO_INCREMENT PRIMARY KEY;
ALTER TABLE `cart_child` MODIFY `cart_child_id` INT AUTO_INCREMENT PRIMARY KEY;
ALTER TABLE `cart_master` MODIFY `cart_master_id` INT AUTO_INCREMENT PRIMARY KEY;
ALTER TABLE `category` MODIFY `cat_id` INT AUTO_INCREMENT PRIMARY KEY;
ALTER TABLE `courier` MODIFY `courier_id` INT AUTO_INCREMENT PRIMARY KEY;
ALTER TABLE `customer` MODIFY `customer_id` INT AUTO_INCREMENT PRIMARY KEY;
ALTER TABLE `c_assign` MODIFY `cassign_id` INT AUTO_INCREMENT PRIMARY KEY;
ALTER TABLE `delivery` MODIFY `delivery_id` INT AUTO_INCREMENT PRIMARY KEY;
ALTER TABLE `item` MODIFY `item_id` INT AUTO_INCREMENT PRIMARY KEY;
ALTER TABLE `purchase_child` MODIFY `pur_child_id` INT AUTO_INCREMENT PRIMARY KEY;
ALTER TABLE `purchase_master` MODIFY `pur_master_id` INT AUTO_INCREMENT PRIMARY KEY;
ALTER TABLE `staff` MODIFY `staff_id` INT AUTO_INCREMENT PRIMARY KEY;
ALTER TABLE `subcategory` MODIFY `subcat_id` INT AUTO_INCREMENT PRIMARY KEY;
ALTER TABLE `vendor` MODIFY `vendor_id` INT AUTO_INCREMENT PRIMARY KEY;

--
-- Constraints for table `card`
--
ALTER TABLE `card`
  ADD CONSTRAINT `card_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`);

--
-- Constraints for table `cart_child`
--
ALTER TABLE `cart_child`
  ADD CONSTRAINT `cart_child_ibfk_1` FOREIGN KEY (`cart_master_id`) REFERENCES `cart_master` (`cart_master_id`),
  ADD CONSTRAINT `cart_child_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `item` (`item_id`);

--
-- Constraints for table `cart_master`
--
ALTER TABLE `cart_master`
  ADD CONSTRAINT `cart_master_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`);

--
-- Constraints for table `courier`
--
ALTER TABLE `courier`
  ADD CONSTRAINT `courier_ibfk_1` FOREIGN KEY (`username`) REFERENCES `login` (`username`),
  ADD CONSTRAINT `courier_ibfk_2` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`staff_id`);

--
-- Constraints for table `customer`
--
ALTER TABLE `customer`
  ADD CONSTRAINT `customer_ibfk_1` FOREIGN KEY (`username`) REFERENCES `login` (`username`);

--
-- Constraints for table `c_assign`
--
ALTER TABLE `c_assign`
  ADD CONSTRAINT `c_assign_ibfk_1` FOREIGN KEY (`cart_master_id`) REFERENCES `cart_master` (`cart_master_id`),
  ADD CONSTRAINT `c_assign_ibfk_2` FOREIGN KEY (`courier_id`) REFERENCES `courier` (`courier_id`);

--
-- Constraints for table `delivery`
--
ALTER TABLE `delivery`
  ADD CONSTRAINT `delivery_ibfk_1` FOREIGN KEY (`cassign_id`) REFERENCES `c_assign` (`cassign_id`);

--
-- Constraints for table `item`
--
ALTER TABLE `item`
  ADD CONSTRAINT `item_ibfk_1` FOREIGN KEY (`subcat_id`) REFERENCES `subcategory` (`subcat_id`);

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`cart_master_id`) REFERENCES `cart_master` (`cart_master_id`),
  ADD CONSTRAINT `payment_ibfk_2` FOREIGN KEY (`card_id`) REFERENCES `card` (`card_id`);

--
-- Constraints for table `purchase_child`
--
ALTER TABLE `purchase_child`
  ADD CONSTRAINT `purchase_child_ibfk_1` FOREIGN KEY (`pur_master_id`) REFERENCES `purchase_master` (`pur_master_id`),
  ADD CONSTRAINT `purchase_child_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `item` (`item_id`);

--
-- Constraints for table `purchase_master`
--
ALTER TABLE `purchase_master`
  ADD CONSTRAINT `purchase_master_ibfk_1` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`staff_id`),
  ADD CONSTRAINT `purchase_master_ibfk_2` FOREIGN KEY (`vendor_id`) REFERENCES `vendor` (`vendor_id`);

--
-- Constraints for table `staff`
--
ALTER TABLE `staff`
  ADD CONSTRAINT `staff_ibfk_1` FOREIGN KEY (`username`) REFERENCES `login` (`username`);

--
-- Constraints for table `subcategory`
--
ALTER TABLE `subcategory`
  ADD CONSTRAINT `subcategory_ibfk_1` FOREIGN KEY (`cat_id`) REFERENCES `category` (`cat_id`);

--
-- Constraints for table `vendor`
--
ALTER TABLE `vendor`
  ADD CONSTRAINT `vendor_ibfk_1` FOREIGN KEY (`username`) REFERENCES `login` (`username`),
  ADD CONSTRAINT `vendor_ibfk_2` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`staff_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
