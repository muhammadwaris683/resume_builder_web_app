-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 10, 2024 at 01:24 PM
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
-- Database: `resume_builder`
--

-- --------------------------------------------------------

--
-- Table structure for table `education`
--

CREATE TABLE `education` (
  `id` int(11) NOT NULL,
  `resume_id` int(11) NOT NULL,
  `school_name` varchar(255) NOT NULL,
  `degree` varchar(255) NOT NULL,
  `start_year` year(4) NOT NULL,
  `end_year` year(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `experience`
--

CREATE TABLE `experience` (
  `id` int(11) NOT NULL,
  `resume_id` int(11) NOT NULL,
  `job_title` varchar(255) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `job_description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `resumes`
--

CREATE TABLE `resumes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `bio` text NOT NULL,
  `skills` text NOT NULL,
  `education` text NOT NULL,
  `experience` text NOT NULL,
  `profile_picture` varchar(255) NOT NULL,
  `hobbies` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `resumes`
--

INSERT INTO `resumes` (`id`, `user_id`, `name`, `email`, `phone`, `bio`, `skills`, `education`, `experience`, `profile_picture`, `hobbies`, `created_at`) VALUES
(12, 3, 'Muhammad Noman', 'nomankhan@gmail.com', '03490061719', 'Motivated and results-oriented educator with a strong background in secondary education, holding a Metric Pass certification. With a proven ability to create engaging and inclusive learning environments, I am dedicated to helping students achieve their academic goals and develop a love for learning. Experienced in teaching [Subject, e.g., Mathematics, Science, English] and well-versed in modern teaching methodologies that cater to diverse student needs.', '[\"Communication\",\"Classroom Mangament\",\"Lesson Planning\",\"Criculum Development\",\"Time Management\"]', '[\"Metric(Science) in GHS Haji Mora, Dera Ismail Khan, Pakistan\"]', '[\"Fresh\"]', '', 'Cricket, Vollyball', '2024-09-02 05:20:14'),
(21, 4, 'Muhammad Waris', 'wariali4204@gmail.com', '03058574204', 'this is', '[\"HTML\"]', '[\"MCS in Gomal University\"]', '[\"Web development\"]', 'uploads/147027645_753597505530172_6313950796417268487_n.jpg', 'cricket', '2024-09-04 05:56:27'),
(22, 4, 'Muhammad Waris', 'wariali4204@gmail.com', '03058574204', 'kjhgyug', '[\"HTML\"]', '[\"Metric(Science) in GHS Haji Mora, Dera Ismail Khan, Pakistan\"]', '[\"Fresh\"]', 'uploads/147027645_753597505530172_6313950796417268487_n.jpg', 'cricket', '2024-09-04 05:56:59'),
(23, 4, 'Muhammad Waris', 'wariali4204@gmail.com', '03058574204', 'kjdieu', '[\"HTML\"]', '[\"MCS in Gomal University\"]', '[\"Web development\"]', 'uploads/092ec951-92d8-4a9d-8471-bb75f2ea1a67.jpg', 'cricket', '2024-09-04 05:57:25'),
(25, 1, 'Muhammad Waris', 'wariali4204@gmail.com', '03058574204', 'As a recent graduate with a degree in [Your Degree, e.g., Computer Science], I am an enthusiastic and dedicated web developer with a strong foundation in both front-end and back-end development. During my academic journey, I developed a passion for crafting user-centric websites and applications. My technical skills include proficiency in HTML, CSS, JavaScript, and PHP, with hands-on experience in developing and maintaining web applications. I am particularly interested in creating innovative solutions that enhance user experience and functionality.\r\n\r\nThroughout my studies, I worked on several projects that involved designing and building responsive websites, integrating APIs, and optimizing performance. I recently completed a project where I developed a resume builder application using PHP and jQuery, which allowed users to create and manage their resumes effectively. This project showcased my ability to handle both the design and implementation aspects of web development.\r\n\r\nI am eager to contribute my skills to a dynamic team and continue learning and growing in the field of web development. My goal is to leverage my technical knowledge and creative problem-solving abilities to deliver high-quality web solutions that meet and exceed client expectations.', '[\"HTML\",\"CSS\",\"JavaScript\",\"PHP\",\"jQuery\",\"Bootstrap\",\"MySQL\"]', '[\"Metric(Science), GHS Haji Mora, Dera Ismail Khan, Pakistan\",\"ICS(Computer Science), GHSS Muryali, Dera Ismail Khan, Pakistan\",\"BCS(Computer Science), Governament Degree Collage NO2, Dera Ismail Khan, Pakistan\",\"MCS(Computer Science), Gomal University, Dera Ismail Khan, Pakistan\"]', '[\"Web development\"]', 'uploads/147027645_753597505530172_6313950796417268487_n.jpg', 'Cricket, Vollyball, football', '2024-09-04 07:47:14'),
(26, 5, 'Muhammad Attiq Ur Rehman', 'attiqurrehman57b@gmail.cpm', '03077325291', 'Recent Elelctrical engineer looking for the role of trainee engineer', '[\"Proteus\",\"Electrical Circuits\",\"Instrumentation\",\"\"]', '[\"BE Electrical Engineering\",\"Pre-Engineering\",\"Science\"]', '[\"4 years of experience in leading projects\"]', 'uploads/092ec951-92d8-4a9d-8471-bb75f2ea1a67.jpg', 'Hiking, Travelling', '2024-09-07 03:48:11');

-- --------------------------------------------------------

--
-- Table structure for table `skills`
--

CREATE TABLE `skills` (
  `id` int(11) NOT NULL,
  `resume_id` int(11) NOT NULL,
  `skill_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `package_type` enum('basic','premium') NOT NULL DEFAULT 'basic',
  `resume_count` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `package_type`, `resume_count`, `created_at`) VALUES
(1, 'Muhammad Ali', 'wariali4204@gmail.com', '$2y$10$cwr3ZDlgxNqg5JMWPV29xex9IQrf85l2TcnNkvkjth3dtb25Md/fy', 'basic', -4, '2024-08-25 05:12:40'),
(2, 'Usama Ahamd', 'usama342@gmail.com', '$2y$10$Igth40i0aAKjvITsOMFM.Og53xoyHN9u9W8ZIa5QpFEzD/rXYMfMm', 'basic', -4, '2024-09-01 05:59:46'),
(3, 'Noman', 'nomankhan@gmail.com', '$2y$10$ixHe8MCd3uxrNVjpP2UsB.FP9Q8KgJuRJfINHgM/3e1RJsISMppeG', 'basic', 0, '2024-09-02 05:15:55'),
(4, 'Muhammad Waris', 'wariali4205@gmail.com', '$2y$10$8xEFBrmdchPU6paehVuuWe2Rc/XNTRpFooHxiuCyZZlzsXWLIXW2C', 'premium', 3, '2024-09-04 05:55:29'),
(5, 'Muhammad Attiq Ur Rehman', 'attiqurrehman57b@gmail.cpm', '$2y$10$BQsRjY8EguK/jfBvKMu7AOgfqFi9Jq.kXNvuBExrM8ytaATxEagPa', 'basic', 1, '2024-09-07 03:27:49');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `education`
--
ALTER TABLE `education`
  ADD PRIMARY KEY (`id`),
  ADD KEY `resume_id` (`resume_id`);

--
-- Indexes for table `experience`
--
ALTER TABLE `experience`
  ADD PRIMARY KEY (`id`),
  ADD KEY `resume_id` (`resume_id`);

--
-- Indexes for table `resumes`
--
ALTER TABLE `resumes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `skills`
--
ALTER TABLE `skills`
  ADD PRIMARY KEY (`id`),
  ADD KEY `resume_id` (`resume_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `emai` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `education`
--
ALTER TABLE `education`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `experience`
--
ALTER TABLE `experience`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `resumes`
--
ALTER TABLE `resumes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `skills`
--
ALTER TABLE `skills`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `education`
--
ALTER TABLE `education`
  ADD CONSTRAINT `education_ibfk_1` FOREIGN KEY (`resume_id`) REFERENCES `resumes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `experience`
--
ALTER TABLE `experience`
  ADD CONSTRAINT `experience_ibfk_1` FOREIGN KEY (`resume_id`) REFERENCES `resumes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `resumes`
--
ALTER TABLE `resumes`
  ADD CONSTRAINT `resumes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `skills`
--
ALTER TABLE `skills`
  ADD CONSTRAINT `skills_ibfk_1` FOREIGN KEY (`resume_id`) REFERENCES `resumes` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
