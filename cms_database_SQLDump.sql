-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 07, 2024 at 10:30 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cms_database`
--

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `POST_ID` int(11) NOT NULL,
  `USER_ID` int(11) DEFAULT NULL,
  `TITLE` varchar(255) NOT NULL,
  `CONTENT` text NOT NULL,
  `IMAGE` varchar(255) DEFAULT NULL,
  `CREATED_AT` timestamp NOT NULL DEFAULT current_timestamp(),
  `UPDATED_AT` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`POST_ID`, `USER_ID`, `TITLE`, `CONTENT`, `IMAGE`, `CREATED_AT`, `UPDATED_AT`) VALUES
(1, 1, 'Introduction to CMS', 'This post introduces the concept of a content management system and its key components.', 'https://via.placeholder.com/1920x1080', '2024-12-07 15:59:44', '2024-12-07 16:05:37'),
(2, 2, 'How to Build a Website', 'Learn how to build a website from scratch using HTML, CSS, and JavaScript.', 'https://via.placeholder.com/1920x1080', '2024-12-07 15:59:44', '2024-12-07 16:06:18'),
(3, 2, 'Best Practices for SEO', 'This post covers the best practices for improving search engine optimization (SEO) for websites.', 'https://via.placeholder.com/1920x1080', '2024-12-07 15:59:44', '2024-12-07 16:06:33'),
(4, 2, 'The Future of Web Development', 'This post discusses the latest trends and technologies shaping the future of web development, including AI integration, progressive web apps, and more.', 'https://via.placeholder.com/1920x1080', '2024-12-07 16:08:21', '2024-12-07 16:08:21'),
(6, 2, 'Understanding Cloud Computing', 'This post explores the basics of cloud computing, its benefits, and how businesses can leverage it to improve scalability and cost-efficiency.', 'https://via.placeholder.com/1920x1080', '2024-12-07 16:08:21', '2024-12-07 16:08:21'),
(7, 2, 'Creating Effective User Interfaces', 'Learn how to design user interfaces that are both functional and visually appealing, with tips on usability, accessibility, and responsive design.', 'https://via.placeholder.com/1920x1080', '2024-12-07 16:08:21', '2024-12-07 16:08:21');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `USER_ID` int(11) NOT NULL,
  `USERNAME` varchar(255) NOT NULL,
  `PASSWORD` varchar(255) NOT NULL,
  `ROLE` enum('user','admin') DEFAULT 'user',
  `CREATED_AT` timestamp NOT NULL DEFAULT current_timestamp(),
  `UPDATED_AT` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`USER_ID`, `USERNAME`, `PASSWORD`, `ROLE`, `CREATED_AT`, `UPDATED_AT`) VALUES
(1, 'Admin', 'adminpassword', 'admin', '2024-12-07 15:59:15', '2024-12-07 17:41:36'),
(2, 'Minh', 'minhpassword', 'user', '2024-12-07 15:59:15', '2024-12-07 17:41:15'),
(3, 'Test', 'testpassword', 'user', '2024-12-07 16:59:41', '2024-12-07 17:41:46');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`POST_ID`),
  ADD KEY `USER_ID` (`USER_ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`USER_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `POST_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `USER_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`USER_ID`) REFERENCES `users` (`USER_ID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
