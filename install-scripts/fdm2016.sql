-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 30, 2016 at 04:02 AM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 7.0.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fdm2016`
--

-- --------------------------------------------------------

--
-- Table structure for table `runners`
--

CREATE TABLE `runners` (
  `runner_id` int(11) NOT NULL,
  `school_id` int(11) DEFAULT NULL,
  `first_name` varchar(25) DEFAULT NULL,
  `last_name` varchar(25) DEFAULT NULL,
  `grade` tinyint(4) DEFAULT NULL,
  `sex` varchar(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `schools`
--

CREATE TABLE `schools` (
  `school_id` int(11) NOT NULL,
  `school_name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `schools`
--

INSERT INTO `schools` (`school_id`, `school_name`) VALUES
(0, '-- admin account --'),
(1, 'ST. PETER, ARLINGTON HEIGHTS');

-- --------------------------------------------------------

--
-- Table structure for table `shirts`
--

CREATE TABLE `shirts` (
  `school_id` int(11) NOT NULL,
  `num_youth_medium` int(11) DEFAULT NULL,
  `num_youth_large` int(11) DEFAULT NULL,
  `num_adult_small` int(11) DEFAULT NULL,
  `num_adult_medium` int(11) DEFAULT NULL,
  `num_adult_large` int(11) DEFAULT NULL,
  `num_adult_xl` int(11) DEFAULT NULL,
  `num_adult_xxl` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) DEFAULT NULL,
  `role` varchar(10) NOT NULL,
  `status` varchar(10) DEFAULT NULL,
  `school_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `email`, `password`, `role`, `status`, `school_id`) VALUES
(0, 'admin@stpeterxc.org', '$2y$10$56B0OlyPrfeSjcaSRmMcl.ZaBd/9/fKU8Lq8jHidBKW/2g0Txn57S', 'admin', 'open', 0),
(1, 'purduetom90@gmail.com', '$2y$10$AYcnpwa4v2zNpQgBx5gzXeGzl2YbqCJkUyHhoSM7z6hBia3co9cG.', 'user', 'open', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `runners`
--
ALTER TABLE `runners`
  ADD PRIMARY KEY (`runner_id`),
  ADD UNIQUE KEY `school_id` (`school_id`,`first_name`,`last_name`);

--
-- Indexes for table `schools`
--
ALTER TABLE `schools`
  ADD PRIMARY KEY (`school_id`),
  ADD UNIQUE KEY `school_name` (`school_name`);

--
-- Indexes for table `shirts`
--
ALTER TABLE `shirts`
  ADD PRIMARY KEY (`school_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
