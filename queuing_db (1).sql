-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 09, 2023 at 03:24 PM
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
-- Database: `queuing_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `file_uploads`
--

CREATE TABLE `file_uploads` (
  `id` int(30) NOT NULL,
  `file_path` text NOT NULL,
  `date_uploaded` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `file_uploads`
--

INSERT INTO `file_uploads` (`id`, `file_path`, `date_uploaded`) VALUES
(25, '1667291400_black_veil_brides_fallen_angels_h264_37487.mp4', '2022-11-01 16:30:57'),
(26, '1667292960_black_veil_brides_fallen_angels_h264_37487.mp4', '2022-11-01 16:56:45'),
(27, '1667293020_black_veil_brides_fallen_angels_h264_37487.mp4', '2022-11-01 16:57:37'),
(28, '1667293020_black_veil_brides_fallen_angels_h264_37487.mp4', '2022-11-01 16:57:58'),
(29, '1667293080_black_veil_brides_fallen_angels_h264_37487.mp4', '2022-11-01 16:58:21'),
(30, '1667293080_black_veil_brides_fallen_angels_h264_37487.mp4', '2022-11-01 16:58:40'),
(31, '1667293200_black_veil_brides_fallen_angels_h264_37487.mp4', '2022-11-01 17:00:19'),
(32, '1667293200_black_veil_brides_fallen_angels_h264_37487.mp4', '2022-11-01 17:00:52'),
(33, '1667293260_black_veil_brides_fallen_angels_h264_37487.mp4', '2022-11-01 17:01:39'),
(34, '1667903880_VID_20220911_173834.mp4', '2022-11-08 18:38:46');

-- --------------------------------------------------------

--
-- Table structure for table `notif`
--

CREATE TABLE `notif` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `notif_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notif`
--

INSERT INTO `notif` (`id`, `name`, `notif_created`) VALUES
(51, 'I\'m arriving soon', '2023-04-04 10:58:39'),
(53, 'add', '2023-06-21 17:01:11');

-- --------------------------------------------------------

--
-- Table structure for table `queue_list`
--

CREATE TABLE `queue_list` (
  `id` int(30) NOT NULL,
  `name` text NOT NULL,
  `transaction_id` int(30) NOT NULL,
  `window_id` int(30) NOT NULL,
  `queue_no` varchar(50) NOT NULL,
  `requirements` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `pending` int(11) NOT NULL,
  `date_created` date NOT NULL DEFAULT current_timestamp(),
  `created_timestamp` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `queue_list`
--

INSERT INTO `queue_list` (`id`, `name`, `transaction_id`, `window_id`, `queue_no`, `requirements`, `status`, `pending`, `date_created`, `created_timestamp`) VALUES
(67, 'number 1', 12, 0, '1', '', 0, 0, '2023-04-02', '2023-07-10 22:57:20');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(30) NOT NULL,
  `name` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '0=Inactive,=1 Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `name`, `status`) VALUES
(9, 'ENROLLMENT', 1),
(12, 'ADVISING', 1);

-- --------------------------------------------------------

--
-- Table structure for table `transaction_windows`
--

CREATE TABLE `transaction_windows` (
  `id` int(30) NOT NULL,
  `transaction_id` int(30) NOT NULL,
  `name` varchar(100) NOT NULL,
  `status` tinyint(100) DEFAULT 1 COMMENT '0=Inactive,1=Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaction_windows`
--

INSERT INTO `transaction_windows` (`id`, `transaction_id`, `name`, `status`) VALUES
(5, 9, 'WINDOW 1', 1),
(8, 12, 'WINDOW 2', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(30) NOT NULL,
  `name` text NOT NULL,
  `status` varchar(50) NOT NULL,
  `window_id` int(30) NOT NULL,
  `type` tinyint(4) NOT NULL DEFAULT 2 COMMENT '1 = Admin, 2= staff',
  `username` varchar(100) NOT NULL,
  `password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `status`, `window_id`, `type`, `username`, `password`) VALUES
(1, 'Administrator', '1', 0, 1, 'admin', '21232f297a57a5a743894a0e4a801fc3'),
(32, 'user', '1', 5, 2, 'user', 'ee11cbb19052e40b07aac0ca060c23ee');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `file_uploads`
--
ALTER TABLE `file_uploads`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notif`
--
ALTER TABLE `notif`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `queue_list`
--
ALTER TABLE `queue_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaction_windows`
--
ALTER TABLE `transaction_windows`
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
-- AUTO_INCREMENT for table `file_uploads`
--
ALTER TABLE `file_uploads`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `notif`
--
ALTER TABLE `notif`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `queue_list`
--
ALTER TABLE `queue_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `transaction_windows`
--
ALTER TABLE `transaction_windows`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
