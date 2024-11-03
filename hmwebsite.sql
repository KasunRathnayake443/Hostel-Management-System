-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 03, 2024 at 05:35 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hmwebsite`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_cred`
--

CREATE TABLE `admin_cred` (
  `sr_no` int(11) NOT NULL,
  `admin_name` varchar(150) NOT NULL,
  `admin_pass` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_cred`
--

INSERT INTO `admin_cred` (`sr_no`, `admin_name`, `admin_pass`) VALUES
(1, 'tjwebdev', '12345');

-- --------------------------------------------------------

--
-- Table structure for table `carousel`
--

CREATE TABLE `carousel` (
  `sr_no` int(11) NOT NULL,
  `image` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `carousel`
--

INSERT INTO `carousel` (`sr_no`, `image`) VALUES
(3, '2.jpg'),
(4, 'main4.jpg'),
(8, 'pexels-gautam-2407455.jpg'),
(10, '1.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `contact_details`
--

CREATE TABLE `contact_details` (
  `sr_no` int(11) NOT NULL,
  `address` varchar(50) NOT NULL,
  `gmap` varchar(100) NOT NULL,
  `pn1` bigint(20) NOT NULL,
  `pn2` bigint(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `fb` varchar(100) NOT NULL,
  `insta` varchar(100) NOT NULL,
  `tw` varchar(100) NOT NULL,
  `iframe` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_details`
--

INSERT INTO `contact_details` (`sr_no`, `address`, `gmap`, `pn1`, `pn2`, `email`, `fb`, `insta`, `tw`, `iframe`) VALUES
(1, 'South Eastern University , Oluvil', 'https://maps.app.goo.gl/JMWbyuiqBJ3sMMvj7', 9467225506294, 946722550444, 'seu.ac@gmail.lk', 'https://www.facebook.com/', 'https://www.facebook.com/', 'https://www.facebook.com/', 'https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d7915.0108822067305!2d81.850033!3d7.296968!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ae514c808d5bd3f:0x5bec23683f71d705!2sSouth Eastern University!5e0!3m2!1sen!2slk!4v1725806039352!5m2!1sen!2slk');

-- --------------------------------------------------------

--
-- Table structure for table `facilities`
--

CREATE TABLE `facilities` (
  `id` int(11) NOT NULL,
  `icon` varchar(100) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `facilities`
--

INSERT INTO `facilities` (`id`, `icon`, `name`, `description`) VALUES
(1, '1727617308_food.png', 'test 1', 'test test test test test test tets tets tstse ssts'),
(2, '1727617485_health.png', 'test 2', '	test test test test test test tets tets tstse ssts'),
(3, '1727617503_library.png', 'test 3', '	test test test test test test tets tets tstse ssts'),
(4, '1727617521_wifi.png', 'test 4', '	test test test test test test tets tets tstse ssts');

-- --------------------------------------------------------

--
-- Table structure for table `features`
--

CREATE TABLE `features` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `features`
--

INSERT INTO `features` (`id`, `name`) VALUES
(24, 'Test 1'),
(25, 'Test 2'),
(26, 'Test 3'),
(27, 'Test 4');

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `area` varchar(50) NOT NULL,
  `fees` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `students` int(11) NOT NULL,
  `picture` varchar(100) NOT NULL,
  `facilities` varchar(100) NOT NULL,
  `features` varchar(100) NOT NULL,
  `description` varchar(100) NOT NULL,
  `table_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `name`, `area`, `fees`, `quantity`, `students`, `picture`, `facilities`, `features`, `description`, `table_name`) VALUES
(13, 'Rooms for Two', 'Villa 1', 1000, 30, 2, 'main-qimg-6f16fe8e063bfbbedf69d8fdc368dc2a.webp', 'test 2, test 3', 'Test 1, Test 2', 'Villa 1 rooms for two students', 'room_13'),
(14, 'Rooms for Four', 'Villa 2', 3000, 20, 4, '5a7458c54f34370001330055__MG_8845.jpg', 'test 2, test 5', 'Test 1', 'Villa 2 rooms for four students', 'room_14'),
(15, 'Rooms for Two', 'Villa 2', 1500, 40, 2, 'hostel-bureau.jpg', 'test 1, test 2, test 5', 'Test 1', 'Villa 2 rooms for two students', 'room_15'),
(17, 'Room for Four', 'villa 1', 2000, 50, 4, 'AtlasDormDSC_8778301220.jpg', 'test 1, test 5', 'Test 1, Test 2', 'Villa 1 rooms for four students', 'room_17');

-- --------------------------------------------------------

--
-- Table structure for table `room_13`
--

CREATE TABLE `room_13` (
  `id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `booked_date` date DEFAULT NULL,
  `from` date DEFAULT NULL,
  `to` date DEFAULT NULL,
  `availability` int(11) DEFAULT 1,
  `fee` int(11) NOT NULL,
  `fee_status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `room_13`
--

INSERT INTO `room_13` (`id`, `student_id`, `booked_date`, `from`, `to`, `availability`, `fee`, `fee_status`) VALUES
(1, 12, '2024-11-03', '2024-11-05', '2024-11-29', 0, 416, 'Pending'),
(2, 12, '2024-11-03', '2024-11-04', '2024-12-07', 0, 566, 'Pending'),
(3, 12, '2024-11-03', '2024-11-04', '2024-12-07', 0, 0, 'Pending'),
(4, 12, '2024-11-03', '2024-11-07', '2024-11-23', 0, 0, ''),
(5, 0, '0000-00-00', '0000-00-00', '0000-00-00', 1, 0, ''),
(6, NULL, NULL, NULL, NULL, 1, 0, ''),
(7, NULL, NULL, NULL, NULL, 1, 0, ''),
(8, NULL, NULL, NULL, NULL, 1, 0, ''),
(9, NULL, NULL, NULL, NULL, 1, 0, ''),
(10, NULL, NULL, NULL, NULL, 1, 0, ''),
(11, NULL, NULL, NULL, NULL, 1, 0, ''),
(12, NULL, NULL, NULL, NULL, 1, 0, ''),
(13, NULL, NULL, NULL, NULL, 1, 0, ''),
(14, NULL, NULL, NULL, NULL, 1, 0, ''),
(15, NULL, NULL, NULL, NULL, 1, 0, ''),
(16, NULL, NULL, NULL, NULL, 1, 0, ''),
(17, NULL, NULL, NULL, NULL, 1, 0, ''),
(18, NULL, NULL, NULL, NULL, 1, 0, ''),
(19, NULL, NULL, NULL, NULL, 1, 0, ''),
(20, NULL, NULL, NULL, NULL, 1, 0, ''),
(21, NULL, NULL, NULL, NULL, 1, 0, ''),
(22, NULL, NULL, NULL, NULL, 1, 0, ''),
(23, NULL, NULL, NULL, NULL, 1, 0, ''),
(24, NULL, NULL, NULL, NULL, 1, 0, ''),
(25, NULL, NULL, NULL, NULL, 1, 0, ''),
(26, NULL, NULL, NULL, NULL, 1, 0, ''),
(27, NULL, NULL, NULL, NULL, 1, 0, ''),
(28, NULL, NULL, NULL, NULL, 1, 0, ''),
(29, NULL, NULL, NULL, NULL, 1, 0, ''),
(30, NULL, NULL, NULL, NULL, 1, 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `room_14`
--

CREATE TABLE `room_14` (
  `id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `booked_date` date DEFAULT NULL,
  `from` date DEFAULT NULL,
  `to` date DEFAULT NULL,
  `availability` int(11) DEFAULT 1,
  `fee` int(11) NOT NULL,
  `fee_status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `room_14`
--

INSERT INTO `room_14` (`id`, `student_id`, `booked_date`, `from`, `to`, `availability`, `fee`, `fee_status`) VALUES
(1, 12, '2024-11-03', '2024-11-03', '2024-12-03', 0, 516, 'Pending'),
(2, 12, '2024-11-03', '2024-11-07', '2024-11-30', 0, 0, 'Pending'),
(3, 12, '2024-11-03', '2024-11-07', '2024-11-30', 0, 0, ''),
(4, NULL, NULL, NULL, NULL, 1, 0, ''),
(5, NULL, NULL, NULL, NULL, 1, 0, ''),
(6, NULL, NULL, NULL, NULL, 1, 0, ''),
(7, NULL, NULL, NULL, NULL, 1, 0, ''),
(8, NULL, NULL, NULL, NULL, 1, 0, ''),
(9, NULL, NULL, NULL, NULL, 1, 0, ''),
(10, NULL, NULL, NULL, NULL, 1, 0, ''),
(11, NULL, NULL, NULL, NULL, 1, 0, ''),
(12, NULL, NULL, NULL, NULL, 1, 0, ''),
(13, NULL, NULL, NULL, NULL, 1, 0, ''),
(14, NULL, NULL, NULL, NULL, 1, 0, ''),
(15, NULL, NULL, NULL, NULL, 1, 0, ''),
(16, NULL, NULL, NULL, NULL, 1, 0, ''),
(17, NULL, NULL, NULL, NULL, 1, 0, ''),
(18, NULL, NULL, NULL, NULL, 1, 0, ''),
(19, NULL, NULL, NULL, NULL, 1, 0, ''),
(20, NULL, NULL, NULL, NULL, 1, 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `room_15`
--

CREATE TABLE `room_15` (
  `id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `booked_date` date DEFAULT NULL,
  `from` date DEFAULT NULL,
  `to` date DEFAULT NULL,
  `availability` int(11) DEFAULT 1,
  `fee` int(11) NOT NULL,
  `fee_status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `room_15`
--

INSERT INTO `room_15` (`id`, `student_id`, `booked_date`, `from`, `to`, `availability`, `fee`, `fee_status`) VALUES
(1, NULL, NULL, NULL, NULL, 1, 0, ''),
(2, NULL, NULL, NULL, NULL, 1, 0, ''),
(3, NULL, NULL, NULL, NULL, 1, 0, ''),
(4, NULL, NULL, NULL, NULL, 1, 0, ''),
(5, NULL, NULL, NULL, NULL, 1, 0, ''),
(6, NULL, NULL, NULL, NULL, 1, 0, ''),
(7, NULL, NULL, NULL, NULL, 1, 0, ''),
(8, NULL, NULL, NULL, NULL, 1, 0, ''),
(9, NULL, NULL, NULL, NULL, 1, 0, ''),
(10, NULL, NULL, NULL, NULL, 1, 0, ''),
(11, NULL, NULL, NULL, NULL, 1, 0, ''),
(12, NULL, NULL, NULL, NULL, 1, 0, ''),
(13, NULL, NULL, NULL, NULL, 1, 0, ''),
(14, NULL, NULL, NULL, NULL, 1, 0, ''),
(15, NULL, NULL, NULL, NULL, 1, 0, ''),
(16, NULL, NULL, NULL, NULL, 1, 0, ''),
(17, NULL, NULL, NULL, NULL, 1, 0, ''),
(18, NULL, NULL, NULL, NULL, 1, 0, ''),
(19, NULL, NULL, NULL, NULL, 1, 0, ''),
(20, NULL, NULL, NULL, NULL, 1, 0, ''),
(21, NULL, NULL, NULL, NULL, 1, 0, ''),
(22, NULL, NULL, NULL, NULL, 1, 0, ''),
(23, NULL, NULL, NULL, NULL, 1, 0, ''),
(24, NULL, NULL, NULL, NULL, 1, 0, ''),
(25, NULL, NULL, NULL, NULL, 1, 0, ''),
(26, NULL, NULL, NULL, NULL, 1, 0, ''),
(27, NULL, NULL, NULL, NULL, 1, 0, ''),
(28, NULL, NULL, NULL, NULL, 1, 0, ''),
(29, NULL, NULL, NULL, NULL, 1, 0, ''),
(30, NULL, NULL, NULL, NULL, 1, 0, ''),
(31, NULL, NULL, NULL, NULL, 1, 0, ''),
(32, NULL, NULL, NULL, NULL, 1, 0, ''),
(33, NULL, NULL, NULL, NULL, 1, 0, ''),
(34, NULL, NULL, NULL, NULL, 1, 0, ''),
(35, NULL, NULL, NULL, NULL, 1, 0, ''),
(36, NULL, NULL, NULL, NULL, 1, 0, ''),
(37, NULL, NULL, NULL, NULL, 1, 0, ''),
(38, NULL, NULL, NULL, NULL, 1, 0, ''),
(39, NULL, NULL, NULL, NULL, 1, 0, ''),
(40, NULL, NULL, NULL, NULL, 1, 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `room_17`
--

CREATE TABLE `room_17` (
  `id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `booked_date` date DEFAULT NULL,
  `from` date DEFAULT NULL,
  `to` date DEFAULT NULL,
  `availability` int(11) DEFAULT 1,
  `fee` int(11) NOT NULL,
  `fee_status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `room_17`
--

INSERT INTO `room_17` (`id`, `student_id`, `booked_date`, `from`, `to`, `availability`, `fee`, `fee_status`) VALUES
(0, 0, '2024-11-03', '2024-11-03', '2024-11-07', 1, 0, ''),
(2, NULL, NULL, NULL, NULL, 1, 0, ''),
(3, NULL, NULL, NULL, NULL, 1, 0, ''),
(4, NULL, NULL, NULL, NULL, 1, 0, ''),
(5, NULL, NULL, NULL, NULL, 1, 0, ''),
(6, NULL, NULL, NULL, NULL, 1, 0, ''),
(7, NULL, NULL, NULL, NULL, 1, 0, ''),
(8, NULL, NULL, NULL, NULL, 1, 0, ''),
(9, NULL, NULL, NULL, NULL, 1, 0, ''),
(10, NULL, NULL, NULL, NULL, 1, 0, ''),
(11, NULL, NULL, NULL, NULL, 1, 0, ''),
(12, NULL, NULL, NULL, NULL, 1, 0, ''),
(13, NULL, NULL, NULL, NULL, 1, 0, ''),
(14, NULL, NULL, NULL, NULL, 1, 0, ''),
(15, NULL, NULL, NULL, NULL, 1, 0, ''),
(16, NULL, NULL, NULL, NULL, 1, 0, ''),
(17, NULL, NULL, NULL, NULL, 1, 0, ''),
(18, NULL, NULL, NULL, NULL, 1, 0, ''),
(19, NULL, NULL, NULL, NULL, 1, 0, ''),
(20, NULL, NULL, NULL, NULL, 1, 0, ''),
(21, NULL, NULL, NULL, NULL, 1, 0, ''),
(22, NULL, NULL, NULL, NULL, 1, 0, ''),
(23, NULL, NULL, NULL, NULL, 1, 0, ''),
(24, NULL, NULL, NULL, NULL, 1, 0, ''),
(25, NULL, NULL, NULL, NULL, 1, 0, ''),
(26, NULL, NULL, NULL, NULL, 1, 0, ''),
(27, NULL, NULL, NULL, NULL, 1, 0, ''),
(28, NULL, NULL, NULL, NULL, 1, 0, ''),
(29, NULL, NULL, NULL, NULL, 1, 0, ''),
(30, NULL, NULL, NULL, NULL, 1, 0, ''),
(31, NULL, NULL, NULL, NULL, 1, 0, ''),
(32, NULL, NULL, NULL, NULL, 1, 0, ''),
(33, NULL, NULL, NULL, NULL, 1, 0, ''),
(34, NULL, NULL, NULL, NULL, 1, 0, ''),
(35, NULL, NULL, NULL, NULL, 1, 0, ''),
(36, NULL, NULL, NULL, NULL, 1, 0, ''),
(37, NULL, NULL, NULL, NULL, 1, 0, ''),
(38, NULL, NULL, NULL, NULL, 1, 0, ''),
(39, NULL, NULL, NULL, NULL, 1, 0, ''),
(40, NULL, NULL, NULL, NULL, 1, 0, ''),
(41, NULL, NULL, NULL, NULL, 1, 0, ''),
(42, NULL, NULL, NULL, NULL, 1, 0, ''),
(43, NULL, NULL, NULL, NULL, 1, 0, ''),
(44, NULL, NULL, NULL, NULL, 1, 0, ''),
(45, NULL, NULL, NULL, NULL, 1, 0, ''),
(46, NULL, NULL, NULL, NULL, 1, 0, ''),
(47, NULL, NULL, NULL, NULL, 1, 0, ''),
(48, NULL, NULL, NULL, NULL, 1, 0, ''),
(49, NULL, NULL, NULL, NULL, 1, 0, ''),
(50, NULL, NULL, NULL, NULL, 1, 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `sr_no` int(11) NOT NULL,
  `site_title` varchar(50) NOT NULL,
  `site_about` varchar(250) NOT NULL,
  `shutdown` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`sr_no`, `site_title`, `site_about`, `shutdown`) VALUES
(1, 'SEUSL ', 'SEUSL Lorem ipsum dolor sit amet consectetur adipisicing elit. Consequatur nisi voluptatem asperiores cum quibusdam, pariatur perferendis molestiae earum incidunt laborum, distinctio ullam dolores, quisquam explicabo eligendi maiores ratione cupidita', 0);

-- --------------------------------------------------------

--
-- Table structure for table `team_details`
--

CREATE TABLE `team_details` (
  `sr_no` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `picture` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `team_details`
--

INSERT INTO `team_details` (`sr_no`, `name`, `picture`) VALUES
(1, 'Test', 'IMG_11121.png'),
(10, 'new ', '867-8678512_doctor-icon-physician.png'),
(11, 'test', 'gvcc-staff-icon-ezgif.com-webp-to-png-converter.png'),
(12, 'john', 'm1.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL,
  `phone_no` int(11) NOT NULL,
  `password` varchar(100) NOT NULL,
  `date_of_birth` date NOT NULL,
  `profile_pic` varchar(100) NOT NULL,
  `book_status` int(11) NOT NULL,
  `table_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `address`, `phone_no`, `password`, `date_of_birth`, `profile_pic`, `book_status`, `table_name`) VALUES
(1, 'test1', 'test@gmail.com', 'test', 1254224, '', '0000-00-00', 'whatsapp.jpg.jpeg', 0, ''),
(12, 'Kasun', 'madkasunmax@gmail.com', '550', 718948284, '123', '2024-10-10', 'WhatsApp Image 2024-06-03 at 11.59.24 AM.jpeg', 0, ''),
(13, 'lakna', 'kl@gmail.com', 'South Eastern University , Oluvil', 672255062, '12345', '2024-10-26', 'whatsapp.jpg.jpeg', 0, ''),
(14, 'lakna', 'kl@gmail.com', 'South Eastern University , Oluvil', 672255062, '1234', '2024-10-24', 'whatsapp.jpg.jpeg', 0, ''),
(15, 'lakna', 'kl@gmail.com', 'South Eastern University , Oluvil', 672255062, '12345', '2024-10-19', 'whatsapp.jpg.jpeg', 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `user_queries`
--

CREATE TABLE `user_queries` (
  `sr_no` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(150) NOT NULL,
  `subject` varchar(200) NOT NULL,
  `message` varchar(500) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `seen` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_cred`
--
ALTER TABLE `admin_cred`
  ADD PRIMARY KEY (`sr_no`);

--
-- Indexes for table `carousel`
--
ALTER TABLE `carousel`
  ADD PRIMARY KEY (`sr_no`);

--
-- Indexes for table `contact_details`
--
ALTER TABLE `contact_details`
  ADD PRIMARY KEY (`sr_no`);

--
-- Indexes for table `facilities`
--
ALTER TABLE `facilities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `features`
--
ALTER TABLE `features`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `room_13`
--
ALTER TABLE `room_13`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `room_14`
--
ALTER TABLE `room_14`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `room_15`
--
ALTER TABLE `room_15`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `room_17`
--
ALTER TABLE `room_17`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`sr_no`);

--
-- Indexes for table `team_details`
--
ALTER TABLE `team_details`
  ADD PRIMARY KEY (`sr_no`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_queries`
--
ALTER TABLE `user_queries`
  ADD PRIMARY KEY (`sr_no`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_cred`
--
ALTER TABLE `admin_cred`
  MODIFY `sr_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `carousel`
--
ALTER TABLE `carousel`
  MODIFY `sr_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `contact_details`
--
ALTER TABLE `contact_details`
  MODIFY `sr_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `facilities`
--
ALTER TABLE `facilities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `features`
--
ALTER TABLE `features`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `room_13`
--
ALTER TABLE `room_13`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `room_14`
--
ALTER TABLE `room_14`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `room_15`
--
ALTER TABLE `room_15`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `room_17`
--
ALTER TABLE `room_17`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `sr_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `team_details`
--
ALTER TABLE `team_details`
  MODIFY `sr_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `user_queries`
--
ALTER TABLE `user_queries`
  MODIFY `sr_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
