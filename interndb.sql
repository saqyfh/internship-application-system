-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 15, 2024 at 02:23 PM
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
-- Database: `interndb`
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
  `applicant_ic` char(12) NOT NULL,
  `applicant_email` varchar(255) NOT NULL,
  `applicant_phoneNum` varchar(15) NOT NULL,
  `applicant_start` date NOT NULL,
  `applicant_end` date NOT NULL,
  `applicant_resume` varchar(255) NOT NULL,
  `applicant_cv` varchar(255) DEFAULT NULL,
  `admin_id` varchar(50) NOT NULL,
  `uni_id` int(11) NOT NULL,
  `program_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `applicant`
--

INSERT INTO `applicant` (`applicant_id`, `applicant_name`, `applicant_ic`, `applicant_email`, `applicant_phoneNum`, `applicant_start`, `applicant_end`, `applicant_resume`, `applicant_cv`, `admin_id`, `uni_id`, `program_id`, `department_id`) VALUES
(4, 'NOOR HANA BINTI ISMAIL', '040917140328', 'hanaisma@gmail.com', '0192117903', '2020-08-01', '2021-01-10', 'uploads/GanttChart.pdf', 'uploads/GanttChart.pdf', 'admin_alain', 20, 1, 1),
(5, 'NUR NABILAH BINTI JOHARI', '040304138765', 'ksaqifah58@gmail.com', '01140345920', '2020-07-10', '2020-12-30', 'uploads/GanttChart.pdf', 'uploads/GanttChart.pdf', 'admin_alain', 1, 1, 3),
(6, 'AINA MATHILDA BINTI NORSHAM', '040513102564', 'ena@gmail.com', '0197357903', '2024-09-09', '2025-02-21', 'uploads/GanttChart.pdf', 'uploads/GanttChart.pdf', 'admin_alain', 12, 1, 2),
(7, 'NUR LISA BINTI ABD AZIZ', '040201114578', 'zulaikhanasir@gmail.com', '0192930298', '2024-09-09', '2025-02-21', 'uploads/GanttChart.pdf', 'uploads/front.pdf', 'admin_alain', 19, 1, 2),
(8, 'FARAH ASYURA BINTI ROZAINI', '040513102564', 'syuree@gmail.com', '0192345689', '2024-09-09', '2025-02-21', 'uploads/ittfront.pdf', 'uploads/GanttChart.pdf', 'admin_alain', 13, 1, 1),
(9, 'NURUL FIRZANAH BINTI MAZLAN', '040304138765', 'firzanahwaheeda@gmail.com', '01140345920', '2024-10-01', '2025-02-14', 'uploads/ittfront.pdf', 'uploads/front.pdf', 'admin_alain', 17, 1, 3),
(10, 'NUR INTAN SYAHIRAH BINTI AMRAN', '040513102564', 'intan54@gmail.com', '0187362890', '2024-12-09', '2024-12-09', 'uploads/GanttChart.pdf', 'uploads/FRONT PAGE 264.pdf', 'admin_alain', 17, 1, 1),
(11, 'SYAZA IZREEN BINTI ZULKIFLEE', '040513102564', 'cajaa@gmail.com', '0197357903', '2024-12-26', '2025-02-26', 'uploads/ittfront.pdf', 'uploads/GanttChart.pdf', 'admin_alain', 17, 1, 2),
(12, 'NORAINI BINTI RAZALI', '040201114578', 'noni@gmail.com', '0192930298', '2024-12-09', '2025-03-20', 'uploads/ittfront.pdf', 'uploads/GanttChart.pdf', 'admin_alain', 10, 1, 2),
(13, 'SALSABILLA BINTI SYAHED', '040513102564', 'bella@gmail.com', '01140345920', '2024-12-31', '2025-04-30', 'uploads/FRONT PAGE 264.pdf', 'uploads/front.pdf', 'admin_alain', 17, 1, 1),
(14, 'NUR HIDAYAH BINTI AHMAD', '040513102564', 'dayah32@gmail.com', '0192930298', '2022-07-15', '2022-12-22', 'uploads/ittfront.pdf', 'uploads/ittfront.pdf', 'admin_alain', 13, 1, 4),
(15, 'SITI HANNAN BINTI HAMDAN', '040513102564', 'hannan34@gmail.com', '0197357903', '2022-06-15', '2022-12-31', 'uploads/front.pdf', 'uploads/GanttChart.pdf', 'admin_alain', 14, 1, 1),
(16, 'SITI HANNAN BINTI HAMDAN', '040513102564', 'hannan34@gmail.com', '0197357903', '2022-06-15', '2022-12-31', 'uploads/front.pdf', 'uploads/GanttChart.pdf', 'admin_alain', 14, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `application`
--

CREATE TABLE `application` (
  `app_id` int(11) NOT NULL,
  `applicant_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  `app_date` date NOT NULL,
  `app_status` enum('Pending','Approved','Rejected') DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `application`
--

INSERT INTO `application` (`app_id`, `applicant_id`, `department_id`, `app_date`, `app_status`) VALUES
(1, 4, 1, '2020-09-17', 'Rejected'),
(2, 5, 3, '2020-12-09', 'Approved'),
(3, 6, 3, '2020-10-26', 'Pending'),
(4, 7, 3, '2020-02-16', 'Pending'),
(5, 8, 3, '2020-04-10', 'Pending'),
(6, 9, 3, '2020-05-09', 'Pending'),
(7, 10, 1, '2024-12-09', 'Pending'),
(8, 11, 2, '2024-12-09', 'Pending'),
(9, 12, 2, '2024-12-09', 'Pending'),
(10, 13, 1, '2024-12-09', 'Pending'),
(11, 14, 4, '2024-12-10', 'Pending'),
(12, 15, 1, '2024-12-10', 'Pending'),
(13, 16, 1, '2024-12-10', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `department_id` int(11) NOT NULL,
  `department_name` varchar(50) NOT NULL,
  `department_desc` varchar(1000) NOT NULL,
  `department_image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`department_id`, `department_name`, `department_desc`, `department_image`) VALUES
(1, 'Human Resources', 'officee', 'gambar'),
(2, 'Finance', 'kira kira', 'duit'),
(3, 'Testing', 'review document', 'laptop'),
(4, 'Development', 'coding je keje', 'PC');

-- --------------------------------------------------------

--
-- Table structure for table `program`
--

CREATE TABLE `program` (
  `program_id` int(11) NOT NULL,
  `program_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `program`
--

INSERT INTO `program` (`program_id`, `program_name`) VALUES
(1, 'Diploma'),
(2, 'Degree');

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
  ADD KEY `program_id` (`program_id`),
  ADD KEY `department_id` (`department_id`);

--
-- Indexes for table `application`
--
ALTER TABLE `application`
  ADD PRIMARY KEY (`app_id`),
  ADD KEY `applicant_id` (`applicant_id`),
  ADD KEY `department_id` (`department_id`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`department_id`);

--
-- Indexes for table `program`
--
ALTER TABLE `program`
  ADD PRIMARY KEY (`program_id`);

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
  MODIFY `applicant_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `application`
--
ALTER TABLE `application`
  MODIFY `app_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `department_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `program`
--
ALTER TABLE `program`
  MODIFY `program_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
  ADD CONSTRAINT `applicant_ibfk_3` FOREIGN KEY (`program_id`) REFERENCES `program` (`program_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `applicant_ibfk_4` FOREIGN KEY (`department_id`) REFERENCES `department` (`department_id`) ON DELETE CASCADE;

--
-- Constraints for table `application`
--
ALTER TABLE `application`
  ADD CONSTRAINT `application_ibfk_1` FOREIGN KEY (`applicant_id`) REFERENCES `applicant` (`applicant_id`),
  ADD CONSTRAINT `application_ibfk_2` FOREIGN KEY (`department_id`) REFERENCES `department` (`department_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
