-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 24, 2026 at 01:39 AM
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
-- Database: `pulilan`
--

-- --------------------------------------------------------

--
-- Table structure for table `achievement_tbl`
--

CREATE TABLE `achievement_tbl` (
  `achievement_id` int(11) NOT NULL,
  `project_name` text NOT NULL,
  `project_description` text NOT NULL,
  `picture` varchar(255) DEFAULT NULL,
  `date_submitted` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `achievement_tbl`
--

INSERT INTO `achievement_tbl` (`achievement_id`, `project_name`, `project_description`, `picture`, `date_submitted`) VALUES
(1, 'Barangay Education Program', 'Distribution of school supplies and learning materials for local students.', 'education_project.jpg', '2026-07-23 08:00:00'),
(2, 'Community Feeding Program', 'A nutritional support initiative targeting undernourished children in the barangay.', 'feeding_program.jpg', '2026-07-23 08:00:00'),
(3, 'Clean and Green Initiative', 'Tree planting and coastal/community cleanup drive.', 'clean_green.jpg', '2026-07-23 08:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `brgydetails_tbl`
--

CREATE TABLE `brgydetails_tbl` (
  `brgydetails_id` int(11) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `username` varchar(80) NOT NULL,
  `password` varchar(255) NOT NULL,
  `contact` varchar(20) NOT NULL,
  `brgy_location` varchar(100) NOT NULL,
  `no_purok` text NOT NULL,
  `major_sources` text NOT NULL,
  `brgy_classification` text NOT NULL,
  `char_brgy` text NOT NULL,
  `gender` varchar(50) NOT NULL,
  `position` varchar(100) NOT NULL,
  `male_tanod` int(11) NOT NULL DEFAULT 0,
  `female_tanod` int(11) NOT NULL DEFAULT 0,
  `male_health_worker` int(11) NOT NULL DEFAULT 0,
  `female_health_worker` int(11) NOT NULL DEFAULT 0,
  `male_nutrition_scholar` int(11) NOT NULL DEFAULT 0,
  `female_nutrition_scholar` int(11) NOT NULL DEFAULT 0,
  `male_purok_leaders` int(11) NOT NULL DEFAULT 0,
  `female_purok_leaders` int(11) NOT NULL DEFAULT 0,
  `male_librarian` int(11) NOT NULL DEFAULT 0,
  `female_librarian` int(11) NOT NULL DEFAULT 0,
  `male_day_care_worker` int(11) NOT NULL DEFAULT 0,
  `female_day_care_worker` int(11) NOT NULL DEFAULT 0,
  `male_utility_worker` int(11) NOT NULL DEFAULT 0,
  `female_utility_worker` int(11) NOT NULL DEFAULT 0,
  `type` varchar(80) NOT NULL,
  `date` date NOT NULL,
  `date_added` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `brgydetails_tbl`
--

INSERT INTO `brgydetails_tbl` (`brgydetails_id`, `fullname`, `email`, `username`, `password`, `contact`, `brgy_location`, `no_purok`, `major_sources`, `brgy_classification`, `char_brgy`, `gender`, `position`, `male_tanod`, `female_tanod`, `male_health_worker`, `female_health_worker`, `male_nutrition_scholar`, `female_nutrition_scholar`, `male_purok_leaders`, `female_purok_leaders`, `male_librarian`, `female_librarian`, `male_day_care_worker`, `female_day_care_worker`, `male_utility_worker`, `female_utility_worker`, `type`, `date`, `date_added`) VALUES
(1, 'Juan Dela Cruz', 'juandelacruz@gmail.com', 'brgy_official1', 'password123', '09123456789', 'Tibag', '7', 'Agriculture / Farming', 'Urban', 'Plain', 'Male', 'Barangay Captain', 4, 1, 2, 3, 1, 2, 4, 3, 0, 1, 1, 2, 2, 1, 'personnel', '2026-01-01', '2026-07-23 08:00:00'),
(2, 'Myra Santana', 'cino@mailinator.com', 'fadagapig', 'Pa$$w0rd!', 'Dicta elit suscipit', 'Et saepe ut sit in q', '57', 'Amet nesciunt quas', 'Urban', 'Coastal', 'Female', 'Chairman', 25, 95, 68, 21, 4, 66, 18, 10, 53, 13, 14, 24, 20, 1, 'official', '0000-00-00', '2026-07-23 23:07:07'),
(3, 'Camilla Luna', 'taxaz@mailinator.com', 'bididux', 'Pa$$w0rd!', 'Necessitatibus amet', 'Quae delectus elit', '91', 'Assumenda est esse ', 'Rural', 'Coastal', 'Male', 'Secretary', 80, 67, 66, 17, 74, 18, 78, 18, 18, 89, 22, 1, 98, 30, 'official', '0000-00-00', '2026-07-23 23:06:59');

-- --------------------------------------------------------

--
-- Table structure for table `brgy_q`
--

CREATE TABLE `brgy_q` (
  `question_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` text NOT NULL,
  `position` text NOT NULL,
  `brgy_classification` text NOT NULL,
  `brgy_location` text NOT NULL,
  `char_brgy` text NOT NULL,
  `total_land_area` text NOT NULL,
  `major_sources` text NOT NULL,
  `boundaries` text NOT NULL,
  `no_household` text NOT NULL,
  `no_families` text NOT NULL,
  `total_male_voters` int(11) NOT NULL,
  `total_female_voters` int(11) NOT NULL,
  `male_tanod` int(11) NOT NULL,
  `female_tanod` int(11) NOT NULL,
  `male_health_worker` int(11) NOT NULL,
  `female_health_worker` int(11) NOT NULL,
  `male_nutrition_scholar` int(11) NOT NULL,
  `female_nutrition_scholar` int(11) NOT NULL,
  `male_purok_leaders` int(11) NOT NULL,
  `female_purok_leaders` int(11) NOT NULL,
  `male_librarian` int(11) NOT NULL,
  `female_librarian` int(11) NOT NULL,
  `male_day_care_worker` int(11) NOT NULL,
  `female_day_care_worker` int(11) NOT NULL,
  `male_utility_worker` int(11) NOT NULL,
  `female_utility_worker` int(11) NOT NULL,
  `no_purok` text NOT NULL,
  `brgy_health_center` text NOT NULL,
  `hospital` text NOT NULL,
  `maternity_clinic` text NOT NULL,
  `child_clinic` text NOT NULL,
  `botika_brgy` text NOT NULL,
  `brgy_day_care_center` text NOT NULL,
  `preschool` text NOT NULL,
  `elementary` text NOT NULL,
  `secondary` text NOT NULL,
  `vocational` text NOT NULL,
  `college_university` text NOT NULL,
  `post_office` text NOT NULL,
  `market` text NOT NULL,
  `ricemill` text NOT NULL,
  `cornmill` text NOT NULL,
  `feedmill` text NOT NULL,
  `agricultural_market` text NOT NULL,
  `fertilizer` text NOT NULL,
  `pesticide` text NOT NULL,
  `seeds` text NOT NULL,
  `feeds` text NOT NULL,
  `type` varchar(50) NOT NULL,
  `date` date NOT NULL,
  `visibility` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `brgy_tbl`
--

CREATE TABLE `brgy_tbl` (
  `psgc` varchar(20) NOT NULL,
  `brgy_name` varchar(100) NOT NULL,
  `classification` varchar(50) NOT NULL,
  `brgy_alt_name` varchar(100) DEFAULT 'N/A',
  `density` varchar(50) NOT NULL,
  `land_area_per_square_meter` varchar(50) NOT NULL,
  `c_pop` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `brgy_tbl`
--

INSERT INTO `brgy_tbl` (`psgc`, `brgy_name`, `classification`, `brgy_alt_name`, `density`, `land_area_per_square_meter`, `c_pop`) VALUES
('031418001', 'Balatong A', 'Rural', 'South Munland', '1,577 /km²', '1,190,000 m²', '1.7%'),
('031418002', 'Balatong B', 'Rural', 'N/A', '2,146 /km²', '1,910,000 m²', '3.7%'),
('031418003', 'Cutcot', 'Urban', 'N/A', '2,583 /km²', '3,220,000 m²', '7.5%'),
('031418005', 'Dampol 1st', 'Urban', 'N/A', '2,850 /km²', '2,375,000 m²', '6.1%'),
('031418006', 'Dampol 2nd A', 'Urban', 'N/A', '3,115 /km²', '1,570,000 m²', '4.4%'),
('031418007', 'Dampol 2nd B', 'Urban', 'N/A', '2,685 /km²', '1,980,000 m²', '4.8%'),
('031418008', 'Dulong Malabon', 'Rural', 'N/A', '1,028 /km²', '4,000,000 m²', '3.7%'),
('031418009', 'Inaon', 'Urban', 'N/A', '3,376 /km²', '2,800,000 m²', '8.5%'),
('031418010', 'Longos', 'Urban', 'N/A', '2,770 /km²', '2,100,000 m²', '5.2%'),
('031418011', 'Lumbac', 'Rural', 'N/A', '2,166 /km²', '2,200,000 m²', '4.3%'),
('031418018', 'Paltao', 'Urban', 'N/A', '3,074 /km²', '2,100,000 m²', '5.8%'),
('031418020', 'Peñabatan', 'Rural', 'N/A', '1,980 /km²', '1,200,000 m²', '2.1%'),
('031418022', 'Poblacion', 'Urban', 'N/A', '5,341 /km²', '2,500,000 m²', '12.0%'),
('031418025', 'Santa Peregrina', 'Urban', 'N/A', '1,851 /km²', '900,000 m²', '1.5%'),
('031418026', 'Santo Cristo', 'Urban', 'N/A', '3,422 /km²', '2,250,000 m²', '6.9%'),
('031418033', 'Taal', 'Urban', 'N/A', '3,164 /km²', '2,500,000 m²', '7.1%'),
('031418034', 'Tabon', 'Rural', 'N/A', '2,143 /km²', '2,300,000 m²', '4.5%'),
('031418035', 'Tibag', 'Urban', 'N/A', '2,428 /km²', '2,000,000 m²', '4.5%'),
('031418037', 'Tinejero', 'Urban', 'Tenejeros', '2,185 /km²', '1,900,000 m²', '3.8%');

-- --------------------------------------------------------

--
-- Table structure for table `check_tbl`
--

CREATE TABLE `check_tbl` (
  `user_id` int(11) NOT NULL,
  `c` varchar(50) NOT NULL,
  `cc` varchar(50) NOT NULL,
  `php` varchar(50) NOT NULL,
  `java` varchar(50) NOT NULL,
  `visibility` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `check_tbl`
--

INSERT INTO `check_tbl` (`user_id`, `c`, `cc`, `php`, `java`, `visibility`) VALUES
(1, 'C', '', '', '', 1),
(2, '', 'C#', 'PHP', '', 1),
(3, '', '', '', 'Java', 1);

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `user_id` int(11) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `phoneno` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `cdate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`user_id`, `fullname`, `phoneno`, `email`, `cdate`) VALUES
(1, 'Maria Santos', '09191234567', 'mariasantos@yahoo.com', '2026-07-23'),
(2, 'Pedro Penduko', '09189876543', 'pedropenduko@gmail.com', '2026-07-23');

-- --------------------------------------------------------

--
-- Table structure for table `loghistory`
--

CREATE TABLE `loghistory` (
  `log_id` int(11) NOT NULL,
  `username` varchar(80) NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `loghistory`
--

INSERT INTO `loghistory` (`log_id`, `username`, `datetime`) VALUES
(1, 'admin', '2026-07-23 08:00:00'),
(2, 'tibag_official', '2026-07-23 08:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `mainuser_acc`
--

CREATE TABLE `mainuser_acc` (
  `user_id` int(11) NOT NULL,
  `brgy_location` varchar(225) NOT NULL,
  `name` varchar(80) NOT NULL,
  `position` varchar(50) NOT NULL,
  `gender` varchar(50) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `brgy_id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `contact` varchar(20) NOT NULL,
  `registered_voter` text NOT NULL,
  `no_son` int(11) NOT NULL,
  `no_daughter` int(11) NOT NULL,
  `no_nephew` int(11) NOT NULL,
  `no_niece` int(11) NOT NULL,
  `no_purok` text NOT NULL,
  `major_sources` text NOT NULL,
  `brgy_classification` text NOT NULL,
  `char_brgy` text NOT NULL,
  `male_tanod` int(11) NOT NULL DEFAULT 0,
  `female_tanod` int(11) NOT NULL DEFAULT 0,
  `male_health_worker` int(11) NOT NULL DEFAULT 0,
  `female_health_worker` int(11) NOT NULL DEFAULT 0,
  `male_nutrition_scholar` int(11) NOT NULL DEFAULT 0,
  `female_nutrition_scholar` int(11) NOT NULL DEFAULT 0,
  `male_purok_leaders` int(11) NOT NULL DEFAULT 0,
  `female_purok_leaders` int(11) NOT NULL DEFAULT 0,
  `male_librarian` int(11) NOT NULL DEFAULT 0,
  `female_librarian` int(11) NOT NULL DEFAULT 0,
  `male_day_care_worker` int(11) NOT NULL DEFAULT 0,
  `female_day_care_worker` int(11) NOT NULL DEFAULT 0,
  `male_utility_worker` int(11) NOT NULL DEFAULT 0,
  `female_utility_worker` int(11) NOT NULL DEFAULT 0,
  `province` text NOT NULL,
  `address` text NOT NULL,
  `city_municipality` text NOT NULL,
  `purok_district` text NOT NULL,
  `civil_status` text NOT NULL,
  `type` varchar(100) NOT NULL,
  `date` date NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `visibility` tinyint(1) DEFAULT 0,
  `logo` varchar(255) DEFAULT NULL,
  `edit_status` varchar(100) NOT NULL DEFAULT 'disabled',
  `edit_notif` varchar(100) NOT NULL DEFAULT 'UNSEEN',
  `activate` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mainuser_acc`
--

INSERT INTO `mainuser_acc` (`user_id`, `brgy_location`, `name`, `position`, `gender`, `username`, `password`, `brgy_id`, `email`, `contact`, `registered_voter`, `no_son`, `no_daughter`, `no_nephew`, `no_niece`, `no_purok`, `major_sources`, `brgy_classification`, `char_brgy`, `male_tanod`, `female_tanod`, `male_health_worker`, `female_health_worker`, `male_nutrition_scholar`, `female_nutrition_scholar`, `male_purok_leaders`, `female_purok_leaders`, `male_librarian`, `female_librarian`, `male_day_care_worker`, `female_day_care_worker`, `male_utility_worker`, `female_utility_worker`, `province`, `address`, `city_municipality`, `purok_district`, `civil_status`, `type`, `date`, `date_created`, `visibility`, `logo`, `edit_status`, `edit_notif`, `activate`) VALUES
(1, 'Admin Center', 'System Administrator', 'Admin', 'Male', 'admin', 'admin123', 0, 'admin@pulilan.gov.ph', '09171234567', 'Yes', 0, 0, 0, 0, '', '', '', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'Bulacan', 'Municipal Hall', 'Pulilan', 'District 1', 'Single', 'admin', '2026-01-01', '2026-01-01 00:00:00', 0, 'admin_logo.png', 'approve', 'UNSEEN', 1),
(2, 'Executive Office', 'Municipal Executive', 'Executive Officer', 'Male', 'executive', 'exec123', 0, 'executive@pulilan.gov.ph', '09181234567', 'Yes', 0, 0, 0, 0, '', '', '', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'Bulacan', 'Municipal Hall', 'Pulilan', 'District 1', 'Married', 'executive', '2026-01-01', '2026-01-01 00:00:00', 0, '', 'disabled', 'UNSEEN', 1),
(3, 'DILG Office', 'DILG Officer', 'Local Government Operations Officer', 'Female', 'dilg', 'dilg123', 0, 'dilg.pulilan@gmail.com', '09191234567', 'Yes', 0, 0, 0, 0, '', '', '', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'Bulacan', 'DILG Compound', 'Pulilan', 'District 1', 'Single', 'dilg', '2026-01-01', '2026-01-01 00:00:00', 0, '', 'disabled', 'UNSEEN', 1),
(4, 'Tibag', 'Barangay Captain Tibag', 'Chairman', 'Male', 'tibag_official', 'tibag123', 101, 'tibag.brgy@gmail.com', '09201234567', 'Yes', 1, 2, 0, 0, '7', 'Agriculture', 'Urban', 'Plain', 4, 1, 2, 2, 1, 1, 4, 3, 0, 1, 1, 2, 2, 1, 'Bulacan', 'Brgy Hall Tibag', 'Pulilan', 'Purok 3', 'Married', 'official', '2026-01-01', '2026-01-01 00:00:00', 0, 'tibag_logo.png', 'disabled', 'UNSEEN', 1),
(5, 'Unassigned', 'zejozeq', 'Resident', 'Not Specified', 'zejozeq', 'password1', 0, 'mahibopa@mailinator.com', '474', '', 0, 0, 0, 0, '', '', '', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', 'executive', '0000-00-00', '2026-07-23 14:16:15', 0, NULL, 'disabled', 'UNSEEN', 0),
(6, 'Pariatur Possimus ', 'Macon Gillespie', 'Ut velit aut quasi f', 'Sunt consectetur ull', '', '', 0, 'wujabesoj@mailinator.com', 'Molestias exercitati', '', 0, 0, 0, 0, '', '', '', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', 'executive', '0000-00-00', '2026-07-23 21:57:11', 0, NULL, 'disabled', 'UNSEEN', 0);

-- --------------------------------------------------------

--
-- Table structure for table `memo`
--

CREATE TABLE `memo` (
  `memo_id` int(11) NOT NULL,
  `project_name` text NOT NULL,
  `project_description` text NOT NULL,
  `picture` varchar(255) DEFAULT NULL,
  `memo_date` date NOT NULL,
  `receiver` text NOT NULL,
  `memo_status` varchar(100) NOT NULL DEFAULT 'PENDING',
  `notification_status` varchar(100) NOT NULL DEFAULT 'UNSEEN'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `memo`
--

INSERT INTO `memo` (`memo_id`, `project_name`, `project_description`, `picture`, `memo_date`, `receiver`, `memo_status`, `notification_status`) VALUES
(1, 'Barangay Household Survey Order', 'Mandatory survey rollout for all local residents to update community statistics.', 'survey_banner.jpg', '2026-07-25', 'All Barangays', 'APPROVED', 'UNSEEN'),
(2, 'Quarterly DILG Meeting', 'Synchronized report submission and operational briefing for all barangay heads.', 'meeting.jpg', '2026-07-30', 'dilg', 'PENDING', 'UNSEEN');

-- --------------------------------------------------------

--
-- Table structure for table `message_tbl`
--

CREATE TABLE `message_tbl` (
  `message_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `subject` text NOT NULL,
  `brgy_location` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `notification_status` varchar(100) NOT NULL DEFAULT 'UNSEEN',
  `date_created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `message_tbl`
--

INSERT INTO `message_tbl` (`message_id`, `name`, `email`, `message`, `subject`, `brgy_location`, `user_id`, `notification_status`, `date_created`) VALUES
(33, 'Ed Developer', 'ed@gmail.com', 'test only for once please.', '', '', 0, 'UNSEEN', '2026-07-23 13:26:49'),
(34, 'Gail Villarreal', 'mukev@mailinator.com', 'Omnis incidunt aute', '', '', 0, 'UNSEEN', '2026-07-23 13:27:21'),
(35, 'Walker Marquez', 'bama@mailinator.com', 'Voluptas veniam ius test 2', '', '', 0, 'UNSEEN', '2026-07-23 13:29:36');

-- --------------------------------------------------------

--
-- Table structure for table `residentdetails_tbl`
--

CREATE TABLE `residentdetails_tbl` (
  `user_id` int(11) NOT NULL,
  `name` varchar(80) NOT NULL,
  `position` varchar(80) NOT NULL,
  `email` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `gender` varchar(80) NOT NULL,
  `contact` varchar(20) NOT NULL,
  `brgy_location` varchar(80) NOT NULL,
  `province` varchar(80) NOT NULL,
  `address` varchar(80) NOT NULL,
  `city_municipality` varchar(80) NOT NULL,
  `purok_district` varchar(80) NOT NULL,
  `civil_status` varchar(80) NOT NULL,
  `date_added` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `activate` tinyint(1) NOT NULL DEFAULT 0,
  `type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `residentdetails_tbl`
--

INSERT INTO `residentdetails_tbl` (`user_id`, `name`, `position`, `email`, `username`, `password`, `gender`, `contact`, `brgy_location`, `province`, `address`, `city_municipality`, `purok_district`, `civil_status`, `date_added`, `activate`, `type`) VALUES
(1, 'Ana Reyes', 'Resident', 'anareyes@gmail.com', 'anareyes', 'ana123', 'Female', '09211234567', 'Tibag', 'Bulacan', 'Purok 2', 'Pulilan', 'District 1', 'Single', '2026-07-23 08:00:00', 1, 'resident');

-- --------------------------------------------------------

--
-- Table structure for table `resident_q`
--

CREATE TABLE `resident_q` (
  `question_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `type` varchar(50) NOT NULL,
  `name` text NOT NULL,
  `address` text NOT NULL,
  `position` varchar(80) NOT NULL,
  `brgy_id_num` text NOT NULL,
  `contact` text NOT NULL,
  `city_municipality` text NOT NULL,
  `brgy_location` text NOT NULL,
  `purok_district` text NOT NULL,
  `province` text NOT NULL,
  `indigenous` text NOT NULL,
  `kind_tribe` text NOT NULL,
  `former_residences` text NOT NULL,
  `howlong_residences` text NOT NULL,
  `gender` text NOT NULL,
  `civil_stat` text NOT NULL,
  `relation_whom` text NOT NULL,
  `name_partner` text NOT NULL,
  `religion` text NOT NULL,
  `registered_civil` text NOT NULL,
  `skills` text NOT NULL,
  `stat_house` text NOT NULL,
  `no_fam_house` int(11) NOT NULL,
  `no_household` int(11) NOT NULL,
  `have_electricity` text NOT NULL,
  `source_electricity` text NOT NULL,
  `educ_stat` text NOT NULL,
  `honors` text NOT NULL,
  `registered_voters` text NOT NULL,
  `latest_vote` date NOT NULL,
  `visibility` int(11) NOT NULL DEFAULT 0,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `achievement_tbl`
--
ALTER TABLE `achievement_tbl`
  ADD PRIMARY KEY (`achievement_id`);

--
-- Indexes for table `brgydetails_tbl`
--
ALTER TABLE `brgydetails_tbl`
  ADD PRIMARY KEY (`brgydetails_id`);

--
-- Indexes for table `brgy_q`
--
ALTER TABLE `brgy_q`
  ADD PRIMARY KEY (`question_id`);

--
-- Indexes for table `brgy_tbl`
--
ALTER TABLE `brgy_tbl`
  ADD PRIMARY KEY (`psgc`);

--
-- Indexes for table `check_tbl`
--
ALTER TABLE `check_tbl`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `loghistory`
--
ALTER TABLE `loghistory`
  ADD PRIMARY KEY (`log_id`);

--
-- Indexes for table `mainuser_acc`
--
ALTER TABLE `mainuser_acc`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `memo`
--
ALTER TABLE `memo`
  ADD PRIMARY KEY (`memo_id`);

--
-- Indexes for table `message_tbl`
--
ALTER TABLE `message_tbl`
  ADD PRIMARY KEY (`message_id`);

--
-- Indexes for table `residentdetails_tbl`
--
ALTER TABLE `residentdetails_tbl`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `resident_q`
--
ALTER TABLE `resident_q`
  ADD PRIMARY KEY (`question_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `achievement_tbl`
--
ALTER TABLE `achievement_tbl`
  MODIFY `achievement_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `brgydetails_tbl`
--
ALTER TABLE `brgydetails_tbl`
  MODIFY `brgydetails_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `brgy_q`
--
ALTER TABLE `brgy_q`
  MODIFY `question_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `check_tbl`
--
ALTER TABLE `check_tbl`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `loghistory`
--
ALTER TABLE `loghistory`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `mainuser_acc`
--
ALTER TABLE `mainuser_acc`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `memo`
--
ALTER TABLE `memo`
  MODIFY `memo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `message_tbl`
--
ALTER TABLE `message_tbl`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `residentdetails_tbl`
--
ALTER TABLE `residentdetails_tbl`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `resident_q`
--
ALTER TABLE `resident_q`
  MODIFY `question_id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
