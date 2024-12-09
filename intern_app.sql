-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 01, 2024 at 03:15 PM
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
-- Database: `intern_app`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` varchar(50) NOT NULL,
  `admin_password` varchar(50) NOT NULL,
  `admin_name` varchar(50) NOT NULL,
  `admin_phoneNum` varchar(50) NOT NULL,
  `admin_email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `admin_password`, `admin_name`, `admin_phoneNum`, `admin_email`) VALUES
('admin_alain', 'adminalain02', 'Khadijah Saqifah', '0199507903', 'ain02@alaintesting');

-- --------------------------------------------------------

--
-- Table structure for table `applicant`
--

CREATE TABLE `applicant` (
  `applicant_id` int(11) NOT NULL,
  `applicant_name` varchar(255) NOT NULL,
  `applicant_email` varchar(255) NOT NULL,
  `applicant_phoneNum` varchar(15) NOT NULL,
  `applicant_start` date NOT NULL,
  `applicant_end` date NOT NULL,
  `applicant_resume` varchar(255) NOT NULL,
  `applicant_cv` varchar(255) DEFAULT NULL,
  `admin_id` varchar(50) DEFAULT NULL,
  `uni_id` int(11) NOT NULL,
  `position_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `applicant`
--

INSERT INTO `applicant` (`applicant_id`, `applicant_name`, `applicant_email`, `applicant_phoneNum`, `applicant_start`, `applicant_end`, `applicant_resume`, `applicant_cv`, `admin_id`, `uni_id`, `position_id`) VALUES
(4, 'NURUL JANNAH', 'jannah@gmail.com', '0192117903', '2024-09-09', '2025-02-21', 'uploads/FRONT PAGE 264.pdf', 'uploads/ittfront.pdf', NULL, 17, 4),
(5, 'NURIN SYAZWANI ', 'nurin23@gmail.com', '0187324598', '2024-11-29', '2024-11-29', 'uploads/FINAL REPORT CSC305.pdf', 'uploads/GanttChart.pdf', NULL, 17, 2),
(6, 'amirul', 'mfiq3142@gmail.com', '0197357903', '2024-11-28', '2024-11-30', 'uploads/8 - KHADIJAH SAQIFAH BINTI ZAKIR HAMDI.pdf', 'uploads/8 - KHADIJAH SAQIFAH BINTI ZAKIR HAMDI.pdf', NULL, 1, 1),
(7, 'NOOR HANA BINTI ISMAIL', 'hanaisma5@gmail.com', '0187324598', '2024-11-29', '2024-11-29', 'uploads/FINAL REPORT CSC305.pdf', 'uploads/FINAL REPORT CSC264.pdf', NULL, 20, 1),
(8, 'AISHAH', 'aishah@gmail.com', '0192930298', '2024-12-01', '2024-12-01', 'uploads/GanttChart.pdf', 'uploads/GanttChart.pdf', NULL, 17, 2);

-- --------------------------------------------------------

--
-- Table structure for table `application`
--

CREATE TABLE `application` (
  `app_id` int(11) NOT NULL,
  `applicant_id` int(11) NOT NULL,
  `position_id` int(11) NOT NULL,
  `app_date` date NOT NULL,
  `app_status` enum('Pending','Approved','Rejected') DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `application`
--

INSERT INTO `application` (`app_id`, `applicant_id`, `position_id`, `app_date`, `app_status`) VALUES
(3, 4, 4, '2024-11-29', 'Rejected'),
(4, 5, 2, '2024-11-29', 'Approved'),
(5, 6, 1, '2024-11-29', 'Approved'),
(6, 7, 1, '2024-11-29', 'Rejected'),
(7, 8, 2, '2024-12-01', 'Rejected');

-- --------------------------------------------------------

--
-- Table structure for table `position`
--

CREATE TABLE `position` (
  `position_id` int(11) NOT NULL,
  `position_name` varchar(50) NOT NULL,
  `position_desc` varchar(1000) NOT NULL,
  `position_image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `position`
--

INSERT INTO `position` (`position_id`, `position_name`, `position_desc`, `position_image`) VALUES
(1, 'Human Resources', 'office', 'gambar'),
(2, 'Finance', 'kira kira', 'duit'),
(3, 'Testing', 'review document', 'laptop'),
(4, 'Development', 'coding je keje', 'PC'),
(5, 'pusaka', 'harta', 'image/photo_2024-11-04_16-41-24.jpg'),
(6, 'bahasa', 'baca', 'image/photo_2023-12-28_18-42-27.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `university`
--

CREATE TABLE `university` (
  `uni_id` int(11) NOT NULL,
  `uni_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `university`
--

INSERT INTO `university` (`uni_id`, `uni_name`) VALUES
(1, 'International Islamic University Malaysia (IIUM)'),
(2, 'Islamic Science University of Malaysia (USIM)'),
(3, 'Universiti Kebangsaan Malaysia (UKM)'),
(4, 'Universiti Malaysia Kelantan (UMK)'),
(5, 'Universiti Malaysia Pahang (UMP)'),
(6, 'Universiti Malaysia Perlis (UniMAP)'),
(7, 'Universiti Malaysia Sabah (UMS)'),
(8, 'Universiti Malaysia Sarawak (UNIMAS)'),
(9, 'Universiti Malaysia Terengganu (UMT) '),
(10, 'Universiti Pendidikan Sultan Idris (UPSI)'),
(11, 'Universiti Pertahanan Nasional Malaysia'),
(12, 'Universiti Putra Malaysia (UPM)'),
(13, 'Universiti Sains Malaysia (USM)'),
(14, 'Universiti Sultan Zainal Abidin (UNiSZA)'),
(15, 'Universiti Teknikal Malaysia Melaka (UTEM)'),
(16, 'Universiti Teknologi Malaysia (UTM)'),
(17, 'Universiti Teknologi MARA (UiTM)'),
(18, 'Universiti Tun Hussein Onn Malaysia (UTHM)'),
(19, 'Universiti Utara Malaysia (UUM)'),
(20, 'University of Malaya (UM)');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `applicant`
--
ALTER TABLE `applicant`
  ADD PRIMARY KEY (`applicant_id`),
  ADD KEY `admin_id` (`admin_id`),
  ADD KEY `uni_id` (`uni_id`),
  ADD KEY `position_id` (`position_id`);

--
-- Indexes for table `application`
--
ALTER TABLE `application`
  ADD PRIMARY KEY (`app_id`),
  ADD KEY `applicant_id` (`applicant_id`),
  ADD KEY `position_id` (`position_id`);

--
-- Indexes for table `position`
--
ALTER TABLE `position`
  ADD PRIMARY KEY (`position_id`);

--
-- Indexes for table `university`
--
ALTER TABLE `university`
  ADD PRIMARY KEY (`uni_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `applicant`
--
ALTER TABLE `applicant`
  MODIFY `applicant_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `application`
--
ALTER TABLE `application`
  MODIFY `app_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `position`
--
ALTER TABLE `position`
  MODIFY `position_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `university`
--
ALTER TABLE `university`
  MODIFY `uni_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `applicant`
--
ALTER TABLE `applicant`
  ADD CONSTRAINT `applicant_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `admin` (`admin_id`),
  ADD CONSTRAINT `applicant_ibfk_2` FOREIGN KEY (`uni_id`) REFERENCES `university` (`uni_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `applicant_ibfk_3` FOREIGN KEY (`position_id`) REFERENCES `position` (`position_id`) ON DELETE CASCADE;

--
-- Constraints for table `application`
--
ALTER TABLE `application`
  ADD CONSTRAINT `application_ibfk_1` FOREIGN KEY (`applicant_id`) REFERENCES `applicant` (`applicant_id`),
  ADD CONSTRAINT `application_ibfk_2` FOREIGN KEY (`position_id`) REFERENCES `position` (`position_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
