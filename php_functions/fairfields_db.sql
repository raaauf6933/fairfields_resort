-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 31, 2020 at 08:16 AM
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

--
-- Dumping data for table `billing`
--

INSERT INTO `billing` (`id`, `billing_id`, `original_capital`) VALUES
(70, 84106703, 2000.00),
(71, 84521175, 2000.00),
(72, 86067692, 4000.00),
(73, 86712701, 9000.00),
(74, 86715440, 5000.00),
(75, 86715440, 12000.00),
(76, 86715440, 4000.00),
(77, 86811714, 4000.00),
(78, 87769247, 4000.00),
(79, 87777395, 9000.00),
(80, 87774630, 4000.00),
(81, 87774630, 3000.00),
(82, 87779554, 4000.00),
(83, 87791599, 4000.00);

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

--
-- Dumping data for table `guest`
--

INSERT INTO `guest` (`guest_id`, `first_name`, `last_name`, `gender`, `contact_number`, `email`, `addressline_1`, `city`, `zipcode`) VALUES
(987764, 'dfgsdgf', 'asdf', 'Male', '5200448', 'dsfgsdg@gmail.com', 'asdfasd', 'fsadfasdf', 124124),
(9877866, 'Rauf', 'Dimaampao', 'Male', '125125125', 'raaauf6933@gmail.com', '215125', '125125', 2147483647),
(98419077, 'Rauf', 'Dimaampao', 'Male', '09472454073', '6933rauf@gmail.com', 'asdfsd', 'asdfasdf', 12412),
(98451938, 'Taka', 'Moriuchi', 'Male', '09472454073', 'raaauf6933@gmail.com', 'Marawi', '124124', 124124),
(98605737, 'Rauf', 'Dimaampao', 'Male', '57676786', 'raaauf6933@gmail.com', '7867867', '86786786', 786786),
(98671267, 'Rauf', 'dimaampao', 'Male', '124124', 'raaauf6933@gmail.com', '124124', '124124', 1241241),
(98674015, 'Rauf', 'Dimaampao', 'Male', '512512', 'sdfasdf@gmail.com', '125125', '125125', 12512),
(98686253, 'Rauf', 'Dimaampao', 'Male', '09472454073', '6933rauf@gmail.com', 'Espana', 'Manila', 10001),
(98772006, 'asdfasd', 'fsadfasdf', 'Male', '124124124', 'asdf@gmail.com', 'asdfsdf', 'asdfasdf', 12412),
(98773735, 'Rauf', 'Dimaampao', 'Male', '1241', '6933rauf@gmail.com', '14212', '412412', 4124),
(98776295, 'fff', 'ffff', 'Male', '124124124', 'ff@gmail.com', 'fff', 'ff', 12412);

-- --------------------------------------------------------

--
-- Table structure for table `guest_additional`
--

CREATE TABLE `guest_additional` (
  `id` int(32) NOT NULL,
  `reservation_id` int(32) NOT NULL,
  `additional_id` int(32) NOT NULL,
  `additional_type` varchar(255) NOT NULL,
  `additional_amount` float(32,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `guest_additional`
--

INSERT INTO `guest_additional` (`id`, `reservation_id`, `additional_id`, `additional_type`, `additional_amount`) VALUES
(19, 59877360, 1, 'Extra Bed', 100.00),
(20, 5987145, 3, 'Pool', 200.00),
(21, 5987145, 3, 'Pool', 200.00),
(22, 59877360, 4, 'Additional Guest', 500.00),
(23, 59877360, 4, 'Additional Guest', 500.00),
(24, 59877360, 3, 'Pool', 300.00),
(25, 59877360, 3, 'Pool', 300.00),
(26, 59877360, 3, 'Pool', 300.00),
(27, 59877360, 3, 'Pool', 300.00),
(28, 59877360, 3, 'Pool', 300.00),
(29, 59877360, 3, 'Pool', 200.00);

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

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`payment_id`, `billing_id`, `payed_capital`, `payment_date`) VALUES
(29, 84106703, 1000.00, '2020-08-28 12:01:50.000000'),
(30, 84106703, 1000.00, '2020-08-28 12:02:01.000000'),
(31, 84106703, 1200.00, '2020-08-28 16:49:16.000000'),
(32, 86067692, 4000.00, '2020-08-28 22:08:59.000000'),
(33, 86712701, 9000.00, '2020-08-29 11:17:42.000000'),
(34, 86712701, 0.00, '2020-08-29 11:17:48.000000'),
(35, 86715440, 10500.00, '2020-08-29 12:00:00.000000'),
(36, 86715440, 10500.00, '2020-08-29 12:03:32.000000'),
(37, 86811714, 2000.00, '2020-08-30 14:28:11.000000'),
(38, 86811714, 2000.00, '2020-08-30 14:28:13.000000'),
(39, 86067692, 0.00, '2020-08-30 15:47:13.000000'),
(40, 86715440, 0.00, '2020-08-30 15:47:22.000000'),
(41, 86712701, 0.00, '2020-08-30 15:47:29.000000'),
(42, 86811714, 0.00, '2020-08-30 15:47:45.000000'),
(43, 86811714, 0.00, '2020-08-30 15:48:01.000000'),
(44, 87769247, 4000.00, '2020-08-30 16:43:27.000000'),
(45, 87774630, 3500.00, '2020-08-30 16:47:38.000000'),
(46, 87777395, 9000.00, '2020-08-30 16:51:03.000000'),
(47, 87779554, 2000.00, '2020-08-30 16:54:27.000000'),
(48, 87791599, 2000.00, '2020-08-30 17:25:59.000000'),
(49, 87774630, 3500.00, '2020-08-30 17:26:07.000000'),
(50, 87774630, 2800.00, '2020-08-31 12:15:10.000000'),
(51, 87777395, 400.00, '2020-08-31 13:12:35.000000');

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

--
-- Dumping data for table `receipt_photo`
--

INSERT INTO `receipt_photo` (`receipt_photo_id`, `reservation_id`, `photo`, `upload_date`) VALUES
(7, 59867298, '5748-Chrysanthemum.jpg', '2020-08-28 19:33:30.00000');

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

--
-- Dumping data for table `reservation`
--

INSERT INTO `reservation` (`reservation_id`, `guest_id`, `billing_id`, `reservation_date`, `booking_reference`, `num_guest`, `checkin_date`, `checkout_date`, `expiration_date`, `reservation_type`, `status`) VALUES
(5986377, 98686253, 86811714, '2020-08-29 14:09:07', 'B32784', 3, '2020-09-14', '2020-09-15', '2020-08-30 14:09:07', 0, 7),
(5987145, 9877866, 87777395, '2020-08-30 16:45:43', 'A84FCD', 11, '2020-08-31', '2020-11-03', '2020-08-30 23:59:59', 1, 7),
(59848867, 98451938, 84521175, '2020-08-26 22:39:16', '2E4E29', 2, '2020-08-27', '2020-08-28', '2020-08-26 23:59:59', 0, 3),
(59849141, 98419077, 84106703, '2020-08-26 11:00:22', '6AB7C9', 1, '2020-08-27', '2020-08-28', '2020-08-26 23:59:59', 0, 7),
(59862225, 98671267, 86712701, '2020-08-29 11:17:32', 'DA4329', 9, '2020-08-30', '2020-08-31', '2020-08-29 23:59:59', 0, 7),
(59866988, 98674015, 86715440, '2020-08-29 11:23:08', '33A780', 3, '2020-10-12', '2020-10-31', '2020-08-30 11:23:08', 0, 7),
(59867298, 98605737, 86067692, '2020-08-28 17:26:28', '34A1F4', 2, '2020-08-29', '2020-08-30', '2020-08-28 23:59:59', 1, 7),
(59875207, 98776295, 87779554, '2020-08-30 16:54:11', '912E71', 3, '2020-09-27', '2020-09-28', '2020-08-31 16:54:11', 0, 4),
(59876949, 98772006, 87791599, '2020-08-30 17:25:41', '8C8B07', 2, '2020-10-07', '2020-10-10', '2020-08-31 17:25:41', 0, 4),
(59877360, 987764, 87774630, '2020-08-30 16:46:30', 'E69996', 5, '2020-09-13', '2020-09-15', '2020-08-31 16:46:30', 0, 7),
(59878826, 98773735, 87769247, '2020-08-30 16:42:49', '667433', 3, '2020-08-31', '2020-09-09', '2020-08-30 23:59:59', 0, 4);

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
(6, 2, 'AC4', 0);

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

--
-- Dumping data for table `room_reservation`
--

INSERT INTO `room_reservation` (`room_reservation_id`, `reservation_id`, `room_id`, `roomtype_name`, `room_price`, `room_num`) VALUES
(57, 59849141, 1, 'Family Room', 2000.00, '1B1'),
(58, 59848867, 2, 'Family Room', 2000.00, '1B2'),
(59, 59867298, 1, 'Family Room', 2000.00, '1B1'),
(60, 59867298, 2, 'Family Room', 2000.00, '1B2'),
(61, 59862225, 3, 'Vip Room', 3000.00, 'AC1'),
(62, 59862225, 4, 'Vip Room', 3000.00, 'AC2'),
(63, 59862225, 5, 'Vip Room', 3000.00, 'AC3'),
(64, 59866988, 7, 'Ordinary Room', 2500.00, 'AF1'),
(65, 59866988, 8, 'Ordinary Room', 2500.00, 'AF2'),
(66, 59866988, 3, 'Vip Room', 3000.00, 'AC1'),
(67, 59866988, 4, 'Vip Room', 3000.00, 'AC2'),
(68, 59866988, 5, 'Vip Room', 3000.00, 'AC3'),
(69, 59866988, 6, 'Vip Room', 3000.00, 'AC4'),
(70, 59866988, 1, 'Family Room', 2000.00, '1B1'),
(71, 59866988, 2, 'Family Room', 2000.00, '1B2'),
(72, 5986377, 1, 'Family Room', 2000.00, '1B1'),
(73, 5986377, 2, 'Family Room', 2000.00, '1B2'),
(74, 59878826, 1, 'Family Room', 2000.00, '1B1'),
(75, 59878826, 2, 'Family Room', 2000.00, '1B2'),
(76, 5987145, 3, 'Vip Room', 3000.00, 'AC1'),
(77, 5987145, 4, 'Vip Room', 3000.00, 'AC2'),
(78, 5987145, 5, 'Vip Room', 3000.00, 'AC3'),
(79, 59877360, 1, 'Family Room', 2000.00, '1B1'),
(80, 59877360, 2, 'Family Room', 2000.00, '1B2'),
(81, 59877360, 6, 'Vip Room', 3000.00, 'AC4'),
(82, 59875207, 1, 'Family Room', 2000.00, '1B1'),
(83, 59875207, 2, 'Family Room', 2000.00, '1B2'),
(84, 59876949, 1, 'Family Room', 2000.00, '1B1'),
(85, 59876949, 2, 'Family Room', 2000.00, '1B2');

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
(37, 'sample room', 1, 4, 'sample room', 'sample room-3476-Dawn.jpg', 1),
(38, 'sample test', 10, 10, 'ffffff', 'sample test-6168-Ali.jpg', 1);

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
(202095974, 'Rauf', 'Dimaampao', 'raaauf6933', '123', 1),
(202096718, 'test', 'account', 'test', '123', 1);

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
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT for table `guest`
--
ALTER TABLE `guest`
  MODIFY `guest_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98776296;

--
-- AUTO_INCREMENT for table `guest_additional`
--
ALTER TABLE `guest_additional`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `payment_id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `receipt_photo`
--
ALTER TABLE `receipt_photo`
  MODIFY `receipt_photo_id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `reservation`
--
ALTER TABLE `reservation`
  MODIFY `reservation_id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59878827;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `room_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `room_reservation`
--
ALTER TABLE `room_reservation`
  MODIFY `room_reservation_id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT for table `room_type`
--
ALTER TABLE `room_type`
  MODIFY `roomtype_id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
