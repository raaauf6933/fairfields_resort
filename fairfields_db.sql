-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 26, 2020 at 02:37 AM
-- Server version: 10.4.8-MariaDB
-- PHP Version: 7.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fairfields_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `additional_type`
--

CREATE TABLE `additional_type` (
  `additional_id` int(32) NOT NULL,
  `additional_type` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `additional_amount` float(10,2) NOT NULL,
  `status` int(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `additional_type`
--

INSERT INTO `additional_type` (`additional_id`, `additional_type`, `description`, `additional_amount`, `status`) VALUES
(1, 'Extra Bed', 'Extra Bed', 100.00, 1),
(2, 'Gym', 'Gym', 100.00, 1),
(3, 'Pool', 'Pool', 200.00, 1),
(4, 'Additional Guest', 'Additional Guest', 500.00, 1);

-- --------------------------------------------------------

--
-- Table structure for table `billing`
--

CREATE TABLE `billing` (
  `id` int(32) NOT NULL,
  `billing_id` int(32) NOT NULL,
  `original_capital` float(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `guest`
--

CREATE TABLE `guest` (
  `guest_id` int(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `gender` varchar(255) NOT NULL,
  `contact_number` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `addressline_1` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `zipcode` int(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `guest_additional`
--

CREATE TABLE `guest_additional` (
  `id` int(32) NOT NULL,
  `reservation_id` int(32) NOT NULL,
  `additional_id` int(32) NOT NULL,
  `additional_type` varchar(255) NOT NULL,
  `additional_amount` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `payment_id` int(32) NOT NULL,
  `billing_id` int(32) NOT NULL,
  `payed_capital` float(32,2) NOT NULL,
  `payment_date` datetime(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `receipt_photo`
--

CREATE TABLE `receipt_photo` (
  `receipt_photo_id` int(32) NOT NULL,
  `reservation_id` int(32) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `upload_date` datetime(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `reservation`
--

CREATE TABLE `reservation` (
  `reservation_id` int(32) NOT NULL,
  `guest_id` int(32) NOT NULL,
  `billing_id` int(32) NOT NULL,
  `reservation_date` datetime NOT NULL,
  `booking_reference` varchar(255) NOT NULL,
  `num_guest` int(32) NOT NULL,
  `checkin_date` date NOT NULL,
  `checkout_date` date NOT NULL,
  `expiration_date` datetime NOT NULL,
  `reservation_type` int(32) NOT NULL,
  `status` int(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `room_id` int(11) NOT NULL,
  `roomtype_id` int(32) NOT NULL,
  `room_num` varchar(255) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`room_id`, `roomtype_id`, `room_num`, `status`) VALUES
(1, 1, '1B1', 0),
(2, 1, '1B2', 0),
(3, 2, 'AC1', 0),
(4, 2, 'AC2', 0),
(5, 2, 'AC3', 0),
(6, 2, 'AC4', 0),
(7, 3, 'AF1', 0),
(8, 3, 'AF2', 0);

-- --------------------------------------------------------

--
-- Table structure for table `room_reservation`
--

CREATE TABLE `room_reservation` (
  `room_reservation_id` int(32) NOT NULL,
  `reservation_id` int(32) NOT NULL,
  `room_id` int(32) NOT NULL,
  `roomtype_name` varchar(255) NOT NULL,
  `room_price` float(32,2) NOT NULL,
  `room_num` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `room_type`
--

CREATE TABLE `room_type` (
  `roomtype_id` int(32) NOT NULL,
  `roomtype_name` varchar(255) NOT NULL,
  `roomtype_capacity` int(32) NOT NULL,
  `roomtype_price` int(32) NOT NULL,
  `description` varchar(255) NOT NULL,
  `roomtype_photo` varchar(255) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `room_type`
--

INSERT INTO `room_type` (`roomtype_id`, `roomtype_name`, `roomtype_capacity`, `roomtype_price`, `description`, `roomtype_photo`, `status`) VALUES
(1, 'Family Room', 2, 2000, 'Good for 3', 'sample room-4221-opa.jpg', 1),
(2, 'Vip Room', 4, 3000, 'Good for 4', 'sample room-4221-opa.jpg', 1),
(3, 'Ordinary Room', 6, 2500, 'good for 6', 'sample room-4221-opa.jpg', 1),
(37, 'sample room', 1, 4, 'sample room', 'sample room-3476-Dawn.jpg', 1),
(38, 'sample test', 10, 10, 'ffffff', 'sample test-6168-Ali.jpg', 1),
(39, 'demo', 1, 5000, '1', 'demo-6649-Untitled-1.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_accounts`
--

CREATE TABLE `user_accounts` (
  `user_id` int(32) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` int(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_accounts`
--

INSERT INTO `user_accounts` (`user_id`, `first_name`, `last_name`, `username`, `password`, `status`) VALUES
(202095974, 'Rauf', 'Dimaampao', 'raaauf6933', '123', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `additional_type`
--
ALTER TABLE `additional_type`
  ADD PRIMARY KEY (`additional_id`);

--
-- Indexes for table `billing`
--
ALTER TABLE `billing`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `guest`
--
ALTER TABLE `guest`
  ADD PRIMARY KEY (`guest_id`);

--
-- Indexes for table `guest_additional`
--
ALTER TABLE `guest_additional`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`payment_id`);

--
-- Indexes for table `receipt_photo`
--
ALTER TABLE `receipt_photo`
  ADD PRIMARY KEY (`receipt_photo_id`);

--
-- Indexes for table `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`reservation_id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`room_id`);

--
-- Indexes for table `room_reservation`
--
ALTER TABLE `room_reservation`
  ADD PRIMARY KEY (`room_reservation_id`);

--
-- Indexes for table `room_type`
--
ALTER TABLE `room_type`
  ADD PRIMARY KEY (`roomtype_id`);

--
-- Indexes for table `user_accounts`
--
ALTER TABLE `user_accounts`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `additional_type`
--
ALTER TABLE `additional_type`
  MODIFY `additional_id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `billing`
--
ALTER TABLE `billing`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `guest`
--
ALTER TABLE `guest`
  MODIFY `guest_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98404258;

--
-- AUTO_INCREMENT for table `guest_additional`
--
ALTER TABLE `guest_additional`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `payment_id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `receipt_photo`
--
ALTER TABLE `receipt_photo`
  MODIFY `receipt_photo_id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `reservation`
--
ALTER TABLE `reservation`
  MODIFY `reservation_id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59843652;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `room_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `room_reservation`
--
ALTER TABLE `room_reservation`
  MODIFY `room_reservation_id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `room_type`
--
ALTER TABLE `room_type`
  MODIFY `roomtype_id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
