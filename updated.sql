-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 23, 2023 at 08:03 PM
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
-- Database: `userform`
--

-- --------------------------------------------------------

--
-- Table structure for table `actions`
--

CREATE TABLE `actions` (
  `ID` int(11) NOT NULL,
  `video_id` int(11) DEFAULT NULL,
  `action_type` enum('like','dislike') DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `actions`
--

INSERT INTO `actions` (`ID`, `video_id`, `action_type`, `created_at`, `user_email`) VALUES
(21, 14, 'like', '2023-06-19 05:10:59', 'bishokpaudel54@gmail.com'),
(25, 13, 'dislike', '2023-06-19 11:59:14', 'bishokpaudel54@gmail.com'),
(26, 15, 'like', '2023-06-21 20:37:25', 'bishokpaudel54@gmail.com'),
(27, 12, 'dislike', '2023-06-21 22:51:43', 'bishokpaudel54@gmail.com'),
(30, 15, 'like', '2023-06-22 18:43:34', 'tejehef296@akoption.com'),
(33, 14, 'like', '2023-06-23 13:24:29', 'tejehef296@akoption.com');

-- --------------------------------------------------------

--
-- Table structure for table `chat_messages`
--

CREATE TABLE `chat_messages` (
  `ID` int(11) NOT NULL,
  `video_id` int(11) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chat_messages`
--

INSERT INTO `chat_messages` (`ID`, `video_id`, `username`, `message`, `timestamp`) VALUES
(21, 23, 'Bishok', 'hello', '2023-06-21 19:08:17'),
(22, 21, 'Bishok', 'hi', '2023-06-21 19:13:25'),
(23, 21, 'Bishok', 'hi', '2023-06-21 19:13:27'),
(24, 21, 'Bishok', 'hi', '2023-06-21 19:13:27'),
(25, 21, 'Bishok', 'hi', '2023-06-21 19:13:30'),
(26, 21, 'Bishok', 'hi', '2023-06-21 19:13:31'),
(27, 21, 'Bishok', 'helo123', '2023-06-21 19:14:04'),
(28, 21, 'Bishok', 'heyy', '2023-06-21 20:09:26'),
(29, 21, 'Bishok', 'heyy', '2023-06-21 20:09:28'),
(30, 21, 'Bishok', 'heyy', '2023-06-21 20:09:29'),
(31, 21, 'Bishok', 'heyy', '2023-06-21 20:09:31'),
(32, 21, 'Bishok', 'wwo nice', '2023-06-21 20:27:26'),
(33, 21, 'Bishok', 'wwo nice', '2023-06-21 20:27:28'),
(34, 23, 'Bishok', 'hwllo', '2023-06-21 21:14:34'),
(35, 23, 'Bishok', 'hwllo', '2023-06-21 21:14:36'),
(38, 1, 'binod', 'wow', '2023-06-23 10:25:46'),
(39, 1, 'binod', 'wow', '2023-06-23 10:25:47'),
(40, 1, 'binod', 'wow', '2023-06-23 10:25:49'),
(41, 0, 'binod', 'wew', '2023-06-23 11:48:09'),
(42, 0, 'binod', 'ghhgh', '2023-06-23 11:48:18'),
(43, 7, 'binod', 'helllo', '2023-06-23 13:22:50'),
(44, 7, 'binod', 'helllo', '2023-06-23 13:22:50'),
(45, 7, 'binod', 'hello  bishok', '2023-06-23 13:23:31'),
(46, 7, 'binod', 'hello  bishok', '2023-06-23 13:23:32'),
(47, 7, 'binod', 'hello  bishok', '2023-06-23 13:23:40');

-- --------------------------------------------------------

--
-- Table structure for table `highlights`
--

CREATE TABLE `highlights` (
  `ID` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `filename` blob NOT NULL,
  `upload_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `highlights`
--

INSERT INTO `highlights` (`ID`, `title`, `description`, `filename`, `upload_date`) VALUES
(12, 'SemiFinals Main Event of Swimming', 'Olympics 2023', 0x5377696d6d696e672e6d7034, '2023-06-17 02:48:44'),
(14, 'Finals Main Event of Swimming	', 'Olympics 2022', 0x5377696d6d696e672e6d7034, '2023-06-17 03:17:46'),
(15, 'Qualifier round', 'Olympic 2023', 0x5377696d6d696e672e6d7034, '2023-06-18 12:11:06');

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `ID` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `image` blob DEFAULT NULL,
  `description` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`ID`, `name`, `image`, `description`) VALUES
(2, 'wow', 0x6963652e6a7067, 'Christopher Tietz heads down the slopes in the Alpine Super G in the 2023 Special Olympics Winter Games at Mountain Creek in Vernon.Steve Hockstein'),
(4, 'Olympics 2023', 0x6f6c796d70696320323032332e6a7067, 'The Olympic Winter Games Beijing 2022 reached a global broadcast audience of more than 2 billion people, according to independent research conducted on behalf of the International Olympic Committee (IOC).');

-- --------------------------------------------------------

--
-- Table structure for table `live`
--

CREATE TABLE `live` (
  `ID` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `filename` longblob NOT NULL,
  `upload_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `live`
--

INSERT INTO `live` (`ID`, `title`, `description`, `filename`, `upload_date`) VALUES
(7, 'SWIMMING', 'Final match between India and China', 0x78797a2e6d7034, '2023-06-23 11:57:31');

-- --------------------------------------------------------

--
-- Table structure for table `lives`
--

CREATE TABLE `lives` (
  `ID` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `points`
--

CREATE TABLE `points` (
  `ID` int(11) NOT NULL,
  `team_name` varchar(255) DEFAULT NULL,
  `points` int(11) DEFAULT NULL,
  `game` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `points`
--

INSERT INTO `points` (`ID`, `team_name`, `points`, `game`) VALUES
(1, 'India', 5, 'Hockey'),
(2, 'India', 5, 'Hockey'),
(3, 'hello', 25, 'polo'),
(4, 'Nepal', 45, 'Hockey');

-- --------------------------------------------------------

--
-- Table structure for table `register`
--

CREATE TABLE `register` (
  `ID` int(11) NOT NULL,
  `Username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `CodeV` varchar(255) NOT NULL,
  `verification` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `register`
--

INSERT INTO `register` (`ID`, `Username`, `email`, `Password`, `CodeV`, `verification`) VALUES
(1, 'Bishok', 'bishokpaudel54@gmail.com', 'd00f5d5217896fb7fd601412cb890830', 'da5e05583f0e40f7b567a4b0ac9f157c', 1),
(29, 'binod', 'tejehef296@akoption.com', '0f1ba603c1a843a3d02d6c5038d8e959', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE `schedule` (
  `ID` int(11) NOT NULL,
  `event_name` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `time` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `schedule`
--

INSERT INTO `schedule` (`ID`, `event_name`, `date`, `time`) VALUES
(1, 'hhe', '2023-06-27', '01:15:00'),
(2, 'POLO', '2023-06-26', '03:30:00'),
(3, 'Hockey', '2023-06-13', '04:15:00'),
(4, 'Hockey', '2023-06-13', '04:15:00'),
(5, 'Hockey', '2023-06-13', '04:15:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`) VALUES
(1, 'bishok', '$2y$10$MqMFTRRMlxNHbrAbswMizevnZgHN17pNh2bqmS.fvYc5Uu09s87wq', 'bishokpaudel54@gmail.com'),
(3, 'binod', '$2y$10$LfBST40osGRMZuofZKXEAOYNpdjLZmzGVpevJt2JT6DBtY9GYz.hW', 'binod43@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `video_comments`
--

CREATE TABLE `video_comments` (
  `ID` int(11) NOT NULL,
  `video_id` int(11) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `comment` text NOT NULL,
  `comment_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `UserName` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `video_comments`
--

INSERT INTO `video_comments` (`ID`, `video_id`, `user_email`, `comment`, `comment_date`, `UserName`) VALUES
(22, 14, 'tejehef296@akoption.com', 'hi', '2023-06-18 13:45:50', 'Bishok2'),
(23, 14, 'tejehef296@akoption.com', 'hello', '2023-06-18 13:47:21', 'Bishok2'),
(24, 14, 'tejehef296@akoption.com', 'hi', '2023-06-18 13:56:10', 'Bishok2'),
(25, 14, 'tejehef296@akoption.com', 'haha', '2023-06-18 14:34:28', 'Bishok2'),
(26, 14, 'tejehef296@akoption.com', 'wow', '2023-06-18 14:39:33', 'Bishok2'),
(27, 14, 'tejehef296@akoption.com', 'wow', '2023-06-18 14:39:46', 'Bishok2'),
(28, 14, 'tejehef296@akoption.com', '', '2023-06-18 14:40:04', 'Bishok2'),
(29, 14, 'tejehef296@akoption.com', '', '2023-06-18 14:41:20', 'Bishok2'),
(30, 14, 'tejehef296@akoption.com', '', '2023-06-18 14:42:17', 'Bishok2'),
(31, 14, 'tejehef296@akoption.com', 'ww', '2023-06-18 14:42:43', 'Bishok2'),
(32, 14, 'tejehef296@akoption.com', 'ww', '2023-06-18 14:48:35', 'Bishok2'),
(33, 13, 'tejehef296@akoption.com', 'hi', '2023-06-18 14:48:53', 'Bishok2'),
(34, 13, 'tejehef296@akoption.com', 'hi', '2023-06-18 14:51:51', 'Bishok2'),
(35, 14, 'tejehef296@akoption.com', 'hello', '2023-06-18 14:51:58', 'Bishok2'),
(36, 14, 'tejehef296@akoption.com', 'hello', '2023-06-18 14:52:41', 'Bishok2'),
(37, 14, 'tejehef296@akoption.com', 'hello', '2023-06-18 14:55:12', 'Bishok2'),
(38, 14, 'tejehef296@akoption.com', 'wow', '2023-06-18 15:21:29', 'Bishok2'),
(39, 12, 'tejehef296@akoption.com', 'hello', '2023-06-18 20:10:01', 'Bishok2'),
(40, 13, 'bishokpaudel54@gmail.com', 'hi', '2023-06-18 22:55:06', 'bishok'),
(41, 12, 'bishokpaudel54@gmail.com', 'nice game', '2023-06-18 23:03:35', 'bishok'),
(42, 14, 'bishokpaudel54@gmail.com', 'wow1221', '2023-06-19 04:02:32', 'bishok'),
(43, 13, 'bishokpaudel54@gmail.com', 'wow', '2023-06-19 04:51:28', 'bishok'),
(44, 15, 'bishokpaudel54@gmail.com', 'hi', '2023-06-21 20:15:43', 'Bishok'),
(45, 15, 'bishokpaudel54@gmail.com', 'wow', '2023-06-21 20:28:44', 'Bishok'),
(46, 15, 'bishokpaudel54@gmail.com', 'wow you are beautiful', '2023-06-21 20:36:39', 'Bishok'),
(47, 15, 'bishokpaudel54@gmail.com', 'goodnight begins soon', '2023-06-21 20:37:12', 'Bishok'),
(48, 12, 'bishokpaudel54@gmail.com', '', '2023-06-21 22:51:14', 'Bishok');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `actions`
--
ALTER TABLE `actions`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `chat_messages`
--
ALTER TABLE `chat_messages`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `highlights`
--
ALTER TABLE `highlights`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `live`
--
ALTER TABLE `live`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `lives`
--
ALTER TABLE `lives`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `points`
--
ALTER TABLE `points`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `register`
--
ALTER TABLE `register`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `video_comments`
--
ALTER TABLE `video_comments`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `actions`
--
ALTER TABLE `actions`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `chat_messages`
--
ALTER TABLE `chat_messages`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `highlights`
--
ALTER TABLE `highlights`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `live`
--
ALTER TABLE `live`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `lives`
--
ALTER TABLE `lives`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `points`
--
ALTER TABLE `points`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `register`
--
ALTER TABLE `register`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `schedule`
--
ALTER TABLE `schedule`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `video_comments`
--
ALTER TABLE `video_comments`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
