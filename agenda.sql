-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 22, 2024 at 07:25 AM
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
-- Database: `agenda`
--

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `event_name` varchar(255) NOT NULL,
  `author` varchar(50) NOT NULL,
  `date` date NOT NULL,
  `progress` enum('In Progress','Finished','Past Deadline') NOT NULL DEFAULT 'In Progress'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `event_name`, `author`, `date`, `progress`) VALUES
(1, 'Make this!', 'meowmere', '2024-05-24', 'Finished'),
(4, 'creet php', 'meowmere', '2024-05-25', 'In Progress'),
(5, 'shitanohidari', 'yuppi', '2024-05-30', 'In Progress'),
(7, 'sdafsefewf', 'reza', '2024-05-10', 'In Progress'),
(8, 'an event! nvm', 'miru', '2024-05-24', 'Finished');

-- --------------------------------------------------------

--
-- Table structure for table `login_attempts`
--

CREATE TABLE `login_attempts` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `attempt_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login_attempts`
--

INSERT INTO `login_attempts` (`id`, `username`, `attempt_time`) VALUES
(1, 'syegfysegf', '2024-05-22 07:20:13'),
(2, 'meow', '2024-05-22 07:20:29'),
(3, 'meowmere', '2024-05-22 07:20:32'),
(4, 'yupi', '2024-05-22 08:09:37'),
(5, 'awdawd', '2024-05-22 08:30:03'),
(6, 'awdawd', '2024-05-22 08:30:34'),
(7, 'rferg', '2024-05-22 08:30:37'),
(8, 'rferg', '2024-05-22 08:32:50'),
(9, 'sefsef', '2024-05-22 08:32:59'),
(10, 'drgreg', '2024-05-22 08:33:03'),
(11, 'sefsef', '2024-05-22 08:37:35'),
(12, 'sefsef', '2024-05-22 08:42:39'),
(13, 'sefsef', '2024-05-22 08:46:12'),
(14, 'sefse', '2024-05-22 08:46:15'),
(15, 'reza', '2024-05-22 08:48:20');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES
(1, 'admin', '$2y$10$RcVHRrxFaZ2Pky.xuUd.XuoxdyUhdsl9JH/PzmgSvnQgRqD6uRDnS', 'admin'),
(2, 'meowmere', '$2y$10$55VD76V68LnosVlkv.JGo.ff1ztENKB24St8NtdilMYiXz1RCusG6', 'user'),
(3, 'yuppi', '$2y$10$j78A9ViTXqLQxwu4AEaAOeMdulGQCkLNseNQiZWFZa2f/T636mrAm', 'user'),
(4, 'srgrg', '$2y$10$hq/aQ7lTakoSV7kDVvZDue9zizqyjAEfH5QKlFuvVWPziK.LBpuPG', 'user'),
(5, 'reza', '$2y$10$4/OjfjwePloaSfyAxPtRUOlaYU7AOhsJ34LWGillzn5/g7P8ts5wO', 'user'),
(6, 'miru', '$2y$10$k8u4VaTNc8qTw28e/VCWJuYdvkn9LEHlqD4Pla2zhOMhy4QGmtQhu', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login_attempts`
--
ALTER TABLE `login_attempts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `login_attempts`
--
ALTER TABLE `login_attempts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
