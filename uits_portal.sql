-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 04, 2026 at 08:01 AM
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
-- Database: `uits_portal`
--

-- --------------------------------------------------------

--
-- Table structure for table `registerrl`
--

CREATE TABLE `registerrl` (
  `register_id` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `registerrl`
--

INSERT INTO `registerrl` (`register_id`, `name`, `email`, `password`) VALUES
('0432410005101112', 'Jubair Jubu', 'jubu@gmail.com', '$2y$10$f2WgrgbCprc4Fs1/oMqTh.VCUkyPtLOyFm5.t5Rv6xzSi4mqXJzBS');

-- --------------------------------------------------------

--
-- Table structure for table `stdprofile`
--

CREATE TABLE `stdprofile` (
  `student_id` bigint(11) NOT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `blood_group` varchar(5) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `marital_status` varchar(150) DEFAULT NULL,
  `religion` varchar(50) DEFAULT NULL,
  `nationality` varchar(50) DEFAULT NULL,
  `identity_type` varchar(50) DEFAULT NULL,
  `identity_number` varchar(50) DEFAULT NULL,
  `visa_expiry_date` date DEFAULT NULL,
  `visa_number` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stdprofile`
--

INSERT INTO `stdprofile` (`student_id`, `full_name`, `dob`, `blood_group`, `gender`, `marital_status`, `religion`, `nationality`, `identity_type`, `identity_number`, `visa_expiry_date`, `visa_number`) VALUES
(432410005101112, 'Jubair Ahammed Jubu', '2001-09-24', 'AB+', 'Male', 'Cheka kheye beka hoye Single asi kintu valo patri khujtesi ', 'Islam', 'Bangladeshi', 'NID', '1234567890', '2030-12-31', 'VISA998877');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `student_id` varchar(20) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `program` varchar(100) DEFAULT NULL,
  `batch` varchar(100) DEFAULT NULL,
  `semester` varchar(50) DEFAULT NULL,
  `enrolled_courses` int(11) DEFAULT NULL,
  `cgpa` float DEFAULT NULL,
  `pending_fees` float DEFAULT NULL,
  `credits_earned` float DEFAULT NULL,
  `credits_attempted` float DEFAULT NULL,
  `total_required` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `student_id`, `name`, `email`, `password`, `program`, `batch`, `semester`, `enrolled_courses`, `cgpa`, `pending_fees`, `credits_earned`, `credits_attempted`, `total_required`) VALUES
(4, '0432410005101112', 'Jubair Ahammed Jubu', 'jubair@uits.edu', 'jubu123', 'CSE (Dual)', '[055] Jan - Jun 2024', 'Jul - Dec 2025', 9, 3.79, 18166, 56.5, 76.5, 144),
(5, '0432410005101223', 'Nusrat Jahan', 'nusrat@uits.edu', 'nusrat123', 'BBA', '[056] Jan - Jun 2024', 'Jul - Dec 2025', 8, 3.45, 15000, 48, 65, 130),
(7, '0432410005101077', 'rani', 'rani@gmail', '987654', 'CSE', '55', 'Jul - Dec 2025', 10, 3.95, 17000, 50, 70, 120),
(9, '0432410005101225', 'Himel', 'himel@gmail.com', 'nusrat123', 'English', '56', 'Jul - Dec 2025', 12, 3, 16000, 55, 65, 120);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `registerrl`
--
ALTER TABLE `registerrl`
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `stdprofile`
--
ALTER TABLE `stdprofile`
  ADD PRIMARY KEY (`student_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `stdprofile`
--
ALTER TABLE `stdprofile`
  MODIFY `student_id` bigint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=432410005101114;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
