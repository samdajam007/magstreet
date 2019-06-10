-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 26, 2016 at 06:28 PM
-- Server version: 10.1.9-MariaDB
-- PHP Version: 7.0.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jmshpro`
--

-- --------------------------------------------------------

--
-- Table structure for table `cn_info`
--

CREATE TABLE `cn_info` (
  `id` int(10) NOT NULL,
  `gn_info_id` int(10) NOT NULL,
  `add_one` varchar(100) NOT NULL,
  `add_two` varchar(100) NOT NULL,
  `country` varchar(20) NOT NULL,
  `phone` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Contact Info Table';

-- --------------------------------------------------------

--
-- Table structure for table `gn_info`
--

CREATE TABLE `gn_info` (
  `id` int(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `pass` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='General Info Table';

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cn_info`
--
ALTER TABLE `cn_info`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_gn_info_id` (`gn_info_id`) USING BTREE;

--
-- Indexes for table `gn_info`
--
ALTER TABLE `gn_info`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cn_info`
--
ALTER TABLE `cn_info`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `gn_info`
--
ALTER TABLE `gn_info`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `cn_info`
--
ALTER TABLE `cn_info`
  ADD CONSTRAINT `fk_gn_ingo_id` FOREIGN KEY (`gn_info_id`) REFERENCES `gn_info` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
