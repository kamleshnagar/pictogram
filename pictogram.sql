-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 25, 2025 at 04:58 PM
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
-- Database: `pictogram`
--

-- --------------------------------------------------------

--
-- Table structure for table `follow_list`
--

CREATE TABLE `follow_list` (
  `id` int(11) NOT NULL,
  `follower_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_img` text NOT NULL,
  `post_text` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `user_id`, `post_img`, `post_text`, `created_at`) VALUES
(49, 4, '1753446999-profile2.jpg', '', '2025-07-25 12:36:39'),
(50, 4, '1753447005-1753197733god-lord-ganesha-wallpaper-preview.jpg', '', '2025-07-25 12:36:45'),
(51, 7, '1753447166-profile7.jpg', '', '2025-07-25 12:39:26'),
(52, 9, '1753452195-1753198905-HD-wallpaper-khatu-shyam-spiritual-krishna-devotional-god-lord-thumbnail.jpg', '', '2025-07-25 14:03:15'),
(53, 9, '1753452413-1753198905-HD-wallpaper-khatu-shyam-spiritual-krishna-devotional-god-lord-thumbnail.jpg', '', '2025-07-25 14:06:53'),
(54, 9, '1753452414-1753198905-HD-wallpaper-khatu-shyam-spiritual-krishna-devotional-god-lord-thumbnail.jpg', '', '2025-07-25 14:06:54'),
(55, 9, '1753453595-profile.jpg', '', '2025-07-25 14:26:35'),
(56, 9, '1753453698-1753199857-1753197733god-lord-ganesha-wallpaper-preview.jpg', '', '2025-07-25 14:28:18'),
(57, 9, '1753453749-1753199857-1753197733god-lord-ganesha-wallpaper-preview.jpg', '', '2025-07-25 14:29:09'),
(58, 9, '1753453841-profile6.jpg', '', '2025-07-25 14:30:41'),
(59, 9, '1753453853-profile4.jpg', '', '2025-07-25 14:30:53'),
(60, 9, '1753453890-profile4.jpg', '', '2025-07-25 14:31:30'),
(61, 9, '1753454009-1753198905-HD-wallpaper-khatu-shyam-spiritual-krishna-devotional-god-lord-thumbnail.jpg', '', '2025-07-25 14:33:29'),
(62, 9, '1753454085-profile3.jpg', '', '2025-07-25 14:34:45'),
(63, 9, '1753454150-1753199330-profile2.jpg', '', '2025-07-25 14:35:50'),
(64, 9, '1753454325-1753197733god-lord-ganesha-wallpaper-preview.jpg', '', '2025-07-25 14:38:45'),
(65, 9, '1753454393-profile4.jpg', '', '2025-07-25 14:39:53'),
(66, 9, '1753454564-profile3.jpg', '', '2025-07-25 14:42:44'),
(67, 9, '1753454672-1753199330-profile2.jpg', '', '2025-07-25 14:44:32'),
(68, 9, '1753454730-profile4.jpg', '', '2025-07-25 14:45:30'),
(69, 9, '1753454743-profile4.jpg', '', '2025-07-25 14:45:43'),
(70, 9, '1753454767-profile5.jpg', '', '2025-07-25 14:46:07'),
(71, 9, '1753454783-profile4.jpg', '', '2025-07-25 14:46:23'),
(72, 9, '1753454803-profile3.jpg', '', '2025-07-25 14:46:43'),
(73, 9, '1753454860-1753199857-1753197733god-lord-ganesha-wallpaper-preview.jpg', '', '2025-07-25 14:47:40'),
(74, 9, '1753454887-profile4.jpg', '', '2025-07-25 14:48:07'),
(75, 9, '1753455132-profile3.jpg', '', '2025-07-25 14:52:12'),
(76, 9, '1753455273-profile2.jpg', '', '2025-07-25 14:54:33'),
(77, 9, '1753455351-profile3.jpg', '', '2025-07-25 14:55:51'),
(78, 9, '1753455406-profile4.jpg', '', '2025-07-25 14:56:46');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `gender` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` text NOT NULL,
  `profile_pic` text NOT NULL DEFAULT 'default_profile.jpg',
  `create_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `ac_status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `gender`, `email`, `username`, `password`, `profile_pic`, `create_at`, `updated_at`, `ac_status`) VALUES
(2, 'Kaal', 'Music', 0, 'kaalmusicproduction@gmail.com', 'kaalmusic', 'e10adc3949ba59abbe56e057f20f883e', '1753282635-1753199318-profile.jpg', '2025-07-22 07:50:18', '2025-07-25 09:56:09', 1),
(4, 'Harsh', 'Vishwakarma', 0, 'harshv1142@gmail.com', 'harshv', 'e10adc3949ba59abbe56e057f20f883e', 'default_profile.jpg', '2025-07-22 13:18:11', '2025-07-24 06:30:42', 1),
(5, 'KAMLESH', 'NAGAR', 0, 'test@gmail.com', 'test', 'e10adc3949ba59abbe56e057f20f883e', '1753199693-profile.jpg', '2025-07-22 13:44:13', '2025-07-22 15:54:53', 1),
(6, 'KAMLESH', 'NAGAR', 0, 'test1@gmail.com', 'test1', 'e10adc3949ba59abbe56e057f20f883e', '1753199857-1753197733god-lord-ganesha-wallpaper-preview.jpg', '2025-07-22 15:57:02', '2025-07-22 15:57:37', 1),
(7, 'admin', 'admin', 0, 'admin@gmail.com', 'admin', '0192023a7bbd73250516f069df18b500', '1753436508-profile2.jpg', '2025-07-25 09:36:51', '2025-07-25 09:41:48', 1),
(8, 'Deepak', 'Nagar', 0, 'deepak@gmail.com', 'deepak', 'e10adc3949ba59abbe56e057f20f883e', 'default_profile.jpg', '2025-07-25 13:14:20', '2025-07-25 13:16:46', 1),
(9, 'khushboo', 'nagar', 0, 'khushboo@nagar.com', 'khushboo', 'e10adc3949ba59abbe56e057f20f883e', 'default_profile.jpg', '2025-07-25 13:17:27', '2025-07-25 13:18:08', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `follow_list`
--
ALTER TABLE `follow_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
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
-- AUTO_INCREMENT for table `follow_list`
--
ALTER TABLE `follow_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
