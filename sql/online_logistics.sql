-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 01, 2024 at 07:01 AM
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
-- Database: `online_logistics`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `email`, `password`, `created_at`) VALUES
(1, 'admin', 'admin@gmail.com', '$2y$10$Fa4RdqWEe.N.t1d2QCCHteB3MLVna7xmSwNOaf6ntvabu71ZcoY.C', '2024-04-26 14:56:51');

-- --------------------------------------------------------

--
-- Table structure for table `drivers`
--

CREATE TABLE `drivers` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `license_number` varchar(50) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `drivers`
--

INSERT INTO `drivers` (`id`, `name`, `email`, `phone`, `license_number`, `address`, `created_at`, `updated_at`) VALUES
(4, 'Osama', 'osama@hotmail.com', '03215487965', 'KIDJ123484-4587', 'Sahiwal Region Sahiwal City Cantt Sahiwal', '2024-04-28 08:01:32', '2024-04-28 08:01:32'),
(6, 'imran shahid', 'imran@hotmail.pk', '03256547895', 'ALK125798', 'Multan City Multan', '2024-04-28 08:52:18', '2024-04-28 08:53:04');

-- --------------------------------------------------------

--
-- Table structure for table `expense_details`
--

CREATE TABLE `expense_details` (
  `id` int(11) NOT NULL,
  `expense_type_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `description` text DEFAULT NULL,
  `expense_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `expense_details`
--

INSERT INTO `expense_details` (`id`, `expense_type_id`, `amount`, `description`, `expense_date`, `created_at`, `updated_at`) VALUES
(2, 3, 125874.00, 'New amount expenses has been added.', '2022-04-05', '2024-04-29 08:44:39', '2024-04-29 08:44:39'),
(4, 6, 9888889.00, 'Salary paid to all driver for the month of aprils\r\n', '2024-04-29', '2024-04-29 08:50:09', '2024-04-29 09:08:13'),
(5, 7, 999999.00, 'Total fuel amount used for the month of april.', '2024-04-25', '2024-04-29 08:50:44', '2024-04-29 09:08:22'),
(6, 6, 1200.00, 'driver salary for the month of may has been paid', '2024-05-01', '2024-05-01 04:50:33', '2024-05-01 04:50:33');

-- --------------------------------------------------------

--
-- Table structure for table `expense_type`
--

CREATE TABLE `expense_type` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `expense_type`
--

INSERT INTO `expense_type` (`id`, `name`, `created_at`, `updated_at`) VALUES
(3, 'Maintenance', '2024-04-29 08:13:39', '2024-04-29 08:23:24'),
(6, 'Driver Salary', '2024-04-29 08:20:08', '2024-04-29 08:20:08'),
(7, 'Fuel', '2024-04-29 08:22:52', '2024-04-29 08:22:52');

-- --------------------------------------------------------

--
-- Table structure for table `income_details`
--

CREATE TABLE `income_details` (
  `id` int(11) NOT NULL,
  `income_type_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `description` text DEFAULT NULL,
  `income_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `income_details`
--

INSERT INTO `income_details` (`id`, `income_type_id`, `amount`, `description`, `income_date`, `created_at`, `updated_at`) VALUES
(1, 2, 125547.00, 'logistics income for the month of april', '2024-04-29', '2024-04-29 10:53:33', '2024-04-29 10:53:33'),
(2, 4, 9999987.00, 'Honda car was on rent and received as from company A to Copmany B', '2024-04-27', '2024-04-29 10:53:56', '2024-04-29 11:03:57'),
(3, 1, 12648745.00, 'for the april of month we have many sales ', '2024-04-24', '2024-04-29 10:58:54', '2024-04-29 11:05:03'),
(4, 2, 144544.00, 'income generated from logistics services for the month of march', '2024-03-14', '2024-04-29 10:59:31', '2024-04-29 10:59:31'),
(5, 2, 1000.00, 'earn profit from logistics service on 01st of may 2024', '2024-05-01', '2024-05-01 04:51:08', '2024-05-01 04:51:08');

-- --------------------------------------------------------

--
-- Table structure for table `income_type`
--

CREATE TABLE `income_type` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `income_type`
--

INSERT INTO `income_type` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Sales', '2024-04-29 10:47:42', '2024-04-29 11:09:55'),
(2, 'Logistic Services', '2024-04-29 10:47:59', '2024-04-29 10:47:59'),
(4, 'Rental', '2024-04-29 10:48:21', '2024-04-29 10:48:21'),
(5, 'Cargo', '2024-04-29 11:10:21', '2024-04-29 11:10:21');

-- --------------------------------------------------------

--
-- Table structure for table `logistics_booking`
--

CREATE TABLE `logistics_booking` (
  `booking_id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `logistics_rates_id` int(11) NOT NULL,
  `amount` decimal(10,0) NOT NULL,
  `trans_id` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `logistics_booking`
--

INSERT INTO `logistics_booking` (`booking_id`, `user_name`, `logistics_rates_id`, `amount`, `trans_id`, `created_at`, `updated_at`, `status`) VALUES
(1, 'dummy first user', 1, 659, 'ch_3PBL4yGCDpOhv9Km1BCBYJLV', '2024-04-30 18:07:02', '2024-05-01 04:16:56', 'Delivered'),
(3, 'dummy first user', 1, 65897, 'ch_3PBL6HGCDpOhv9Km1TgM2hyY', '2024-04-30 18:08:23', '2024-04-30 18:20:59', ''),
(4, 'dummy first user', 5, 569874, 'ch_3PBL6jGCDpOhv9Km0L9btqm7', '2024-04-30 18:08:51', '2024-04-30 18:21:05', ''),
(5, 'dummy first user', 5, 569874, 'ch_3PBL8GGCDpOhv9Km1MiLjplX', '2024-04-30 18:10:26', '2024-04-30 18:21:08', ''),
(6, 'dummy first user', 5, 569874, 'ch_3PBLATGCDpOhv9Km12kMmCaw', '2024-04-30 18:12:43', '2024-04-30 18:21:11', ''),
(7, 'dummy first user', 1, 65897, 'ch_3PBLIyGCDpOhv9Km1ET13iZc', '2024-04-30 18:21:30', '2024-04-30 18:21:30', ''),
(8, 'dummy second user', 5, 569874, 'ch_3PBUmLGCDpOhv9Km0TJMLMnC', '2024-05-01 04:28:26', '2024-05-01 04:28:26', '');

-- --------------------------------------------------------

--
-- Table structure for table `logistics_rates`
--

CREATE TABLE `logistics_rates` (
  `rate_id` int(11) NOT NULL,
  `origin` varchar(255) NOT NULL,
  `destination` varchar(255) NOT NULL,
  `weight_range_min` decimal(10,2) NOT NULL,
  `weight_range_max` decimal(10,2) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `logistics_rates`
--

INSERT INTO `logistics_rates` (`rate_id`, `origin`, `destination`, `weight_range_min`, `weight_range_max`, `amount`, `created_at`, `updated_at`) VALUES
(1, 'Lahore', 'Sahiwal', 12.00, 258.00, 65897.00, '2024-04-30 10:46:43', '2024-04-30 10:46:43'),
(5, 'Khanewal', 'R.Y.Khan', 85.00, 8500.00, 569874.00, '2024-04-30 11:31:08', '2024-04-30 11:31:37');

-- --------------------------------------------------------

--
-- Table structure for table `trips`
--

CREATE TABLE `trips` (
  `id` int(11) NOT NULL,
  `driver_id` int(11) NOT NULL,
  `vehicle_id` int(11) NOT NULL,
  `starting_point` varchar(255) NOT NULL,
  `destination` varchar(255) NOT NULL,
  `distance_covered` decimal(10,2) NOT NULL,
  `charges` decimal(10,2) NOT NULL,
  `trip_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `trips`
--

INSERT INTO `trips` (`id`, `driver_id`, `vehicle_id`, `starting_point`, `destination`, `distance_covered`, `charges`, `trip_date`, `created_at`, `updated_at`) VALUES
(3, 6, 4, 'Sheikhupura', 'Gujranwala', 150.00, 68541.00, '2024-04-20', '2024-04-28 09:22:18', '2024-04-28 09:22:18'),
(6, 4, 4, 'Lahore', 'Sheikhupura', 150.00, 1254.00, '2022-02-03', '2024-04-28 09:39:52', '2024-04-28 09:39:52'),
(7, 4, 4, 'Lahore City Main Cantt', 'Sheikhupura City Sheikhupra', 170.00, 1200.00, '2023-04-03', '2024-04-28 09:43:56', '2024-04-28 09:50:27');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `address`, `phone`, `username`, `email`, `password`, `created_at`) VALUES
(6, 'dummy names', 'dummy address lane no. 58', '03245487878', 'dummy first user', 'dummyfirstuser@bing.com', '$2y$10$/riY0U9Az7JPWF62OOUtAO4SMCcZj.opAAwdQkBNg8AdPy/rALEZq', '2024-04-26 14:01:47'),
(7, 'dummy name second', 'dummy address lane no. 03', '03245487896', 'dummy second user', 'dummyseconduser@gmail.com', '$2y$10$Fa4RdqWEe.N.t1d2QCCHteB3MLVna7xmSwNOaf6ntvabu71ZcoY.C', '2024-04-26 14:02:05');

-- --------------------------------------------------------

--
-- Table structure for table `vehicles`
--

CREATE TABLE `vehicles` (
  `id` int(11) NOT NULL,
  `model` varchar(50) NOT NULL,
  `year` int(11) NOT NULL,
  `registration_number` varchar(20) NOT NULL,
  `color` varchar(30) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vehicles`
--

INSERT INTO `vehicles` (`id`, `model`, `year`, `registration_number`, `color`, `created_at`, `updated_at`) VALUES
(4, '2021', 2021, 'IMG-15465', 'Blue', '2024-04-26 20:40:33', '2024-04-26 20:40:33'),
(5, '1997', 2008, 'IMG-15465-20', 'Navy Blue Navy', '2024-04-26 20:40:49', '2024-04-26 20:46:39');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `drivers`
--
ALTER TABLE `drivers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `phone` (`phone`),
  ADD UNIQUE KEY `license_number` (`license_number`);

--
-- Indexes for table `expense_details`
--
ALTER TABLE `expense_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `expense_type_id` (`expense_type_id`);

--
-- Indexes for table `expense_type`
--
ALTER TABLE `expense_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `income_details`
--
ALTER TABLE `income_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `income_type_id` (`income_type_id`);

--
-- Indexes for table `income_type`
--
ALTER TABLE `income_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logistics_booking`
--
ALTER TABLE `logistics_booking`
  ADD PRIMARY KEY (`booking_id`);

--
-- Indexes for table `logistics_rates`
--
ALTER TABLE `logistics_rates`
  ADD PRIMARY KEY (`rate_id`);

--
-- Indexes for table `trips`
--
ALTER TABLE `trips`
  ADD PRIMARY KEY (`id`),
  ADD KEY `driver_id` (`driver_id`),
  ADD KEY `vehicle_id` (`vehicle_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vehicles`
--
ALTER TABLE `vehicles`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `drivers`
--
ALTER TABLE `drivers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `expense_details`
--
ALTER TABLE `expense_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `expense_type`
--
ALTER TABLE `expense_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `income_details`
--
ALTER TABLE `income_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `income_type`
--
ALTER TABLE `income_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `logistics_booking`
--
ALTER TABLE `logistics_booking`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `logistics_rates`
--
ALTER TABLE `logistics_rates`
  MODIFY `rate_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `trips`
--
ALTER TABLE `trips`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `vehicles`
--
ALTER TABLE `vehicles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `expense_details`
--
ALTER TABLE `expense_details`
  ADD CONSTRAINT `expense_details_ibfk_1` FOREIGN KEY (`expense_type_id`) REFERENCES `expense_type` (`id`);

--
-- Constraints for table `income_details`
--
ALTER TABLE `income_details`
  ADD CONSTRAINT `income_details_ibfk_1` FOREIGN KEY (`income_type_id`) REFERENCES `income_type` (`id`);

--
-- Constraints for table `trips`
--
ALTER TABLE `trips`
  ADD CONSTRAINT `trips_ibfk_1` FOREIGN KEY (`driver_id`) REFERENCES `drivers` (`id`),
  ADD CONSTRAINT `trips_ibfk_2` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
