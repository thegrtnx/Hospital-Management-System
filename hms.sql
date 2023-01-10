-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 10, 2023 at 09:07 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hms`
--

-- --------------------------------------------------------

--
-- Table structure for table `book`
--

CREATE TABLE `book` (
  `id` int(11) NOT NULL,
  `bkid` text NOT NULL,
  `email` text NOT NULL,
  `date` date NOT NULL,
  `msg` text NOT NULL,
  `status` text NOT NULL,
  `category` text NOT NULL,
  `doctor_assigned` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pharma`
--

CREATE TABLE `pharma` (
  `id` int(11) NOT NULL,
  `dname` text NOT NULL,
  `dpix` text NOT NULL,
  `amt` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `this`
--

CREATE TABLE `this` (
  `id` int(11) NOT NULL,
  `tid` text NOT NULL,
  `amt` text NOT NULL,
  `status` text NOT NULL,
  `pdate` date NOT NULL,
  `email` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `sn` int(11) NOT NULL,
  `email` text NOT NULL,
  `fullname` text NOT NULL,
  `role` text NOT NULL,
  `password` text NOT NULL,
  `date_reg` text NOT NULL,
  `activator` text NOT NULL,
  `tel` text NOT NULL,
  `address` text NOT NULL,
  `state` text NOT NULL,
  `genotype` text NOT NULL,
  `bloodgroup` text NOT NULL,
  `gender` text NOT NULL,
  `language` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`sn`, `email`, `fullname`, `role`, `password`, `date_reg`, `activator`, `tel`, `address`, `state`, `genotype`, `bloodgroup`, `gender`, `language`) VALUES
(7, 'greatnessabolade@gmail.com', 'Abolade Greatness', 'I am a Doctor', '53c1df01e11ec01bcf9ced4ccae8c667', '2023-01-09 10:47:08', 'activated', '08135291769', 'Egbeda', 'Lagos', '102213', 'O+', 'Male', 'Yoruba');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `book`
--
ALTER TABLE `book`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pharma`
--
ALTER TABLE `pharma`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `this`
--
ALTER TABLE `this`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`sn`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `book`
--
ALTER TABLE `book`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pharma`
--
ALTER TABLE `pharma`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `this`
--
ALTER TABLE `this`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `sn` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
