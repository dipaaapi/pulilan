-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 31, 2018 at 03:24 AM
-- Server version: 10.1.26-MariaDB
-- PHP Version: 7.1.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
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
  `picture` blob NOT NULL,
  `date_submitted` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `achievement_tbl`
--

INSERT INTO `achievement_tbl` (`achievement_id`, `project_name`, `project_description`, `picture`, `date_submitted`) VALUES
(8, 'For Education', 'Education', 0x526f626c6f7853637265656e53686f7432303137303730315f3133333532383632332e706e67, '2017-12-26 10:50:13'),
(9, 'feeding', 'feeding', 0x7369676e2075702e6a7067, '2017-12-29 05:55:19'),
(10, '', 'Project description', 0x7369676e2075702e6a7067, '2017-12-29 10:42:34');

-- --------------------------------------------------------

--
-- Table structure for table `brgydetails_tbl`
--

CREATE TABLE `brgydetails_tbl` (
  `brgydetails_id` int(2) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `email` varchar(80) NOT NULL,
  `username` varchar(80) NOT NULL,
  `password` varchar(80) NOT NULL,
  `contact` int(50) NOT NULL,
  `brgy_location` varchar(100) NOT NULL,
  `no_purok` text NOT NULL,
  `major_sources` text NOT NULL,
  `brgy_classification` text NOT NULL,
  `char_brgy` text NOT NULL,
  `gender` text NOT NULL,
  `position` text NOT NULL,
  `male_tanod` text NOT NULL,
  `female_tanod` text NOT NULL,
  `male_health_worker` text NOT NULL,
  `female_health_worker` text NOT NULL,
  `male_nutrition_scholar` text NOT NULL,
  `female_nutrition_scholar` text NOT NULL,
  `male_purok_leaders` text NOT NULL,
  `female_purok_leaders` text NOT NULL,
  `male_librarian` text NOT NULL,
  `female_librarian` text NOT NULL,
  `male_day_care_worker` text NOT NULL,
  `female_day_care_worker` text NOT NULL,
  `male_utility_worker` text NOT NULL,
  `female_utility_worker` text NOT NULL,
  `type` varchar(80) NOT NULL,
  `date` date NOT NULL,
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `brgydetails_tbl`
--

INSERT INTO `brgydetails_tbl` (`brgydetails_id`, `fullname`, `email`, `username`, `password`, `contact`, `brgy_location`, `no_purok`, `major_sources`, `brgy_classification`, `char_brgy`, `gender`, `position`, `male_tanod`, `female_tanod`, `male_health_worker`, `female_health_worker`, `male_nutrition_scholar`, `female_nutrition_scholar`, `male_purok_leaders`, `female_purok_leaders`, `male_librarian`, `female_librarian`, `male_day_care_worker`, `female_day_care_worker`, `male_utility_worker`, `female_utility_worker`, `type`, `date`, `date_added`) VALUES
(1, 'prince', 'prince@gmail.com', '', '', 922177521, 'dyosa', '', '', '', '', 'Male', 'Kagawad', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'personnel', '0000-00-00', '2018-01-23 00:52:31');

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
  `total_male_voters` int(100) NOT NULL,
  `total_female_voters` int(100) NOT NULL,
  `male_tanod` int(100) NOT NULL,
  `female_tanod` int(100) NOT NULL,
  `male_health_worker` int(100) NOT NULL,
  `female_health_worker` text NOT NULL,
  `male_nutrition_scholar` text NOT NULL,
  `female_nutrition_scholar` text NOT NULL,
  `male_purok_leaders` text NOT NULL,
  `female_purok_leaders` text NOT NULL,
  `male_librarian` text NOT NULL,
  `female_librarian` text NOT NULL,
  `male_day_care_worker` text NOT NULL,
  `female_day_care_worker` text NOT NULL,
  `male_utility_worker` text NOT NULL,
  `female_utility_worker` text NOT NULL,
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
  `visibility` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `visibility` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `check_tbl`
--

INSERT INTO `check_tbl` (`user_id`, `c`, `cc`, `php`, `java`, `visibility`) VALUES
(1, '', '', '', '', 0),
(2, '', '', '', '', 0),
(3, 'C', '', '', '', 0),
(4, '', 'C#', '', '', 0),
(5, '', 'C#', '', '', 1),
(6, 'C', 'C#', 'PHP', 'Java', 1),
(7, 'C', 'C#', '', '', 0),
(8, 'C', '', '', '', 0),
(9, '', '', 'PHP', 'Java', 0),
(10, 'C', 'C#', 'PHP', 'Java', 0),
(11, '', '', '', 'Java', 0),
(12, '', '', '', 'Java', 0);

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `user_id` int(10) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `phoneno` int(10) NOT NULL,
  `email` text NOT NULL,
  `cdate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`user_id`, `fullname`, `phoneno`, `email`, `cdate`) VALUES
(1, '', 2147483647, 'santoscarlo058@yahoo.com', '2017-12-20'),
(2, '', 2147483647, 'santoscarlo058@yahoo.com', '2017-12-20'),
(3, '', 2147483647, 'santoscarlo058@yahoo.com', '2017-12-20'),
(4, 'hahah', 2147483647, 'kj@yahoo.com', '2017-12-20');

-- --------------------------------------------------------

--
-- Table structure for table `loghistory`
--

CREATE TABLE `loghistory` (
  `log_id` int(20) NOT NULL,
  `username` varchar(80) NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `loghistory`
--

INSERT INTO `loghistory` (`log_id`, `username`, `datetime`) VALUES
(1, 'tibag', '2017-12-19 01:51:58'),
(2, 'balatonga', '2017-12-19 01:51:58');

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
  `password` varchar(100) NOT NULL,
  `brgy_id` int(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  `contact` int(20) NOT NULL,
  `registered_voter` text NOT NULL,
  `no_son` int(2) NOT NULL,
  `no_daughter` int(2) NOT NULL,
  `no_nephew` int(2) NOT NULL,
  `no_niece` int(2) NOT NULL,
  `no_purok` text NOT NULL,
  `major_sources` text NOT NULL,
  `brgy_classification` text NOT NULL,
  `char_brgy` text NOT NULL,
  `male_tanod` text NOT NULL,
  `female_tanod` text NOT NULL,
  `male_health_worker` text NOT NULL,
  `female_health_worker` text NOT NULL,
  `male_nutrition_scholar` text NOT NULL,
  `female_nutrition_scholar` text NOT NULL,
  `male_purok_leaders` text NOT NULL,
  `female_purok_leaders` text NOT NULL,
  `male_librarian` text NOT NULL,
  `female_librarian` text NOT NULL,
  `male_day_care_worker` text NOT NULL,
  `female_day_care_worker` text NOT NULL,
  `male_utility_worker` text NOT NULL,
  `female_utility_worker` text NOT NULL,
  `province` text NOT NULL,
  `address` text NOT NULL,
  `city_municipality` text NOT NULL,
  `purok_district` text NOT NULL,
  `civil_status` text NOT NULL,
  `type` varchar(100) NOT NULL,
  `date` date NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `visibility` tinyint(1) DEFAULT '0',
  `logo` blob NOT NULL,
  `edit_status` varchar(100) NOT NULL DEFAULT 'disabled',
  `edit_notif` varchar(100) NOT NULL DEFAULT 'UNSEEN',
  `activate` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mainuser_acc`
--

INSERT INTO `mainuser_acc` (`user_id`, `brgy_location`, `name`, `position`, `gender`, `username`, `password`, `brgy_id`, `email`, `contact`, `registered_voter`, `no_son`, `no_daughter`, `no_nephew`, `no_niece`, `no_purok`, `major_sources`, `brgy_classification`, `char_brgy`, `male_tanod`, `female_tanod`, `male_health_worker`, `female_health_worker`, `male_nutrition_scholar`, `female_nutrition_scholar`, `male_purok_leaders`, `female_purok_leaders`, `male_librarian`, `female_librarian`, `male_day_care_worker`, `female_day_care_worker`, `male_utility_worker`, `female_utility_worker`, `province`, `address`, `city_municipality`, `purok_district`, `civil_status`, `type`, `date`, `date_created`, `visibility`, `logo`, `edit_status`, `edit_notif`, `activate`) VALUES
(1, 'admin', 'admin', 'admin', 'Male', 'admin', 'admin', 0, 'dipaaapi8@gmail.com', 2147483647, '', 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'admin', '0000-00-00', '2017-11-02 19:48:16', 0, '', 'approve', 'UNSEEN', 0),
(2, 'executive', 'executive', 'executive', 'Male', 'executive', 'executive', 0, 'executive@gmail.com', 956789, '', 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'executive', '2017-12-19', '2017-12-28 03:57:16', 0, '', 'disabled', 'UNSEEN', 0),
(120, 'dilg', 'dilg', 'dilg', 'male', 'dilg', 'dilg', 0, 'dilg@gmail.com', 0, '', 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'dilg', '0000-00-00', '2018-01-02 08:36:19', 0, '', 'disabled', 'UNSEEN', 0),
(192, 'suka', 'suka', 'Chairman', 'Female', 'suka', 'suka', 0, 'suka@yahoo.com', 2147483647, '', 0, 0, 0, 0, '17', 'Taxes', 'Urban', 'Plain', '2', '1', '3', '2', '2', '1', '5', '3', '2', '4', '2', '5', '2', '4', '', '', '', '', '', 'official', '0000-00-00', '2018-01-03 01:54:29', 0, '', 'disabled', 'UNSEEN', 0);

-- --------------------------------------------------------

--
-- Table structure for table `memo`
--

CREATE TABLE `memo` (
  `memo_id` int(11) NOT NULL,
  `project_name` text NOT NULL,
  `project_description` text NOT NULL,
  `picture` blob NOT NULL,
  `memo_date` date NOT NULL,
  `receiver` text NOT NULL,
  `memo_status` varchar(100) NOT NULL DEFAULT 'PENDING',
  `notification_status` varchar(100) NOT NULL DEFAULT 'UNSEEN'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `memo`
--

INSERT INTO `memo` (`memo_id`, `project_name`, `project_description`, `picture`, `memo_date`, `receiver`, `memo_status`, `notification_status`) VALUES
(1, 'Barangay Household Survey order', 'Announcement for the local government to issue an project according to the needs of every resident', '', '0000-00-00', '0', 'APPROVED', 'UNSEEN'),
(2, 'memo sample', 'sample', 0x70696374757265, '2018-01-24', 'dilg', 'PENDING', 'UNSEEN');

-- --------------------------------------------------------

--
-- Table structure for table `message_tbl`
--

CREATE TABLE `message_tbl` (
  `message_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `subject` text NOT NULL,
  `brgy_location` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `notification_status` varchar(100) NOT NULL DEFAULT 'UNSEEN',
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `message_tbl`
--

INSERT INTO `message_tbl` (`message_id`, `message`, `subject`, `brgy_location`, `user_id`, `notification_status`, `date_created`) VALUES
(1, 'trial', 'trail', 'Balatong A', 42, 'SEEN', '2017-12-12 00:54:42'),
(2, 'sir paki check nga kung may message ako sayo', 'hello', 'DILG', 42, 'UNSEEN', '2017-12-12 22:44:50'),
(3, 'memo', 'meo', 'DILG', 42, 'SEEN', '2017-12-28 03:14:38'),
(4, 'hi', 'hi', 'Balatong A', 42, 'SEEN', '2017-12-13 03:59:49'),
(5, 'e', 'e', 'Balatong A', 42, 'SEEN', '2017-12-16 12:59:44'),
(6, 'hi', 'hi', 'Admin', 22, 'SEEN', '2017-12-16 19:47:33'),
(7, 'g', 'g', 'DILG', 42, 'UNSEEN', '2017-12-19 04:24:16'),
(8, 'g', 'g', 'Balatong A', 42, 'SEEN', '2017-12-19 04:24:45'),
(9, '', '', 'None', 42, 'UNSEEN', '2017-12-19 16:31:47'),
(10, 'hahahaha', 'huy ano?', 'Balatong A', 40, 'SEEN', '2017-12-19 23:44:51'),
(11, 'suntukan', 'hoy', 'Lumbac', 73, 'SEEN', '2017-12-20 07:00:55'),
(12, 'd', 'dddd', 'DILG', 42, 'UNSEEN', '2017-12-24 02:03:23'),
(13, 'hi', 'hi admin', 'Admin', 22, 'SEEN', '2017-12-26 10:56:05'),
(14, 'd', 'hi', 'Admin', 52, 'SEEN', '2017-12-26 23:10:56'),
(15, 'i will send you later the soft copy of reports', 'hi', 'executive', 42, 'UNSEEN', '2017-12-26 23:12:46'),
(16, 'd', 'dd', 'Balatong A', 42, 'SEEN', '2017-12-26 23:16:41'),
(17, 'hi chix', 'hi', 'Balatong A', 52, 'SEEN', '2017-12-26 23:16:26'),
(18, 'laro tayo lol?', 'g', 'Balatong A', 42, 'SEEN', '2017-12-27 01:47:48'),
(19, 's', 's', 'Taal', 22, 'SEEN', '2017-12-28 00:51:23'),
(20, 's', 's', 'Admin', 94, 'SEEN', '2017-12-28 03:47:28'),
(21, 'h', 'h', 'pu', 42, 'UNSEEN', '2017-12-28 12:17:10'),
(22, 'hi', 'hi', 'u', 42, 'SEEN', '2017-12-28 12:17:43'),
(23, 'hi', 'hi', 'rolan', 42, 'UNSEEN', '2017-12-28 12:19:09'),
(24, 'hihi', 'hi', 'u', 42, 'SEEN', '2017-12-28 12:19:49'),
(25, 'hi', 'hi', 'pagudpud', 42, 'SEEN', '2017-12-28 12:20:46'),
(26, 'hoy\r\n', 'hoy', 'u', 101, 'SEEN', '2017-12-28 12:22:25'),
(27, 'q', 'sample', 'admin', 98, 'SEEN', '2017-12-29 05:53:57'),
(28, 'say something?', 'hello', 'dilg', 106, 'UNSEEN', '2017-12-30 16:51:25'),
(29, 'la lang', 'try again', 'dilg', 106, 'UNSEEN', '2017-12-30 16:57:23'),
(30, 'another', '3rd times', 'dilg', 106, 'UNSEEN', '2017-12-30 17:00:22'),
(31, 'for good na to', 'last', 'dilg', 106, 'UNSEEN', '2017-12-30 17:07:43'),
(32, 'trial ko', 'try lng', 'admin', 106, 'SEEN', '2017-12-30 17:12:36'),
(33, 'baka gumana', 'try lng', 'lily', 42, 'SEEN', '2017-12-30 17:29:38'),
(34, 'tangina mo', 'gago', 'lily', 42, 'SEEN', '2018-01-01 13:53:41'),
(35, 'h', 'h', 'dilg', 42, 'UNSEEN', '2018-01-03 05:25:22'),
(36, 'hi', 'hi', 'admin', 201, 'SEEN', '2018-01-23 00:45:30');

-- --------------------------------------------------------

--
-- Table structure for table `residentdetails_tbl`
--

CREATE TABLE `residentdetails_tbl` (
  `user_id` int(11) NOT NULL,
  `name` varchar(80) NOT NULL,
  `position` varchar(80) NOT NULL,
  `email` varchar(80) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(59) NOT NULL,
  `gender` varchar(80) NOT NULL,
  `contact` int(20) NOT NULL,
  `brgy_location` varchar(80) NOT NULL,
  `province` varchar(80) NOT NULL,
  `address` varchar(80) NOT NULL,
  `city_municipality` varchar(80) NOT NULL,
  `purok_district` varchar(80) NOT NULL,
  `civil_status` varchar(80) NOT NULL,
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `activate` tinyint(1) NOT NULL DEFAULT '0',
  `type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `no_fam_house` int(100) NOT NULL,
  `no_household` int(100) NOT NULL,
  `have_electricity` text NOT NULL,
  `source_electricity` text NOT NULL,
  `educ_stat` text NOT NULL,
  `honors` text NOT NULL,
  `registered_voters` text NOT NULL,
  `latest_vote` date NOT NULL,
  `visibility` int(11) NOT NULL DEFAULT '0',
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  MODIFY `achievement_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `brgydetails_tbl`
--
ALTER TABLE `brgydetails_tbl`
  MODIFY `brgydetails_id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `brgy_q`
--
ALTER TABLE `brgy_q`
  MODIFY `question_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `check_tbl`
--
ALTER TABLE `check_tbl`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `user_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `loghistory`
--
ALTER TABLE `loghistory`
  MODIFY `log_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `mainuser_acc`
--
ALTER TABLE `mainuser_acc`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=193;
--
-- AUTO_INCREMENT for table `memo`
--
ALTER TABLE `memo`
  MODIFY `memo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `message_tbl`
--
ALTER TABLE `message_tbl`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;
--
-- AUTO_INCREMENT for table `residentdetails_tbl`
--
ALTER TABLE `residentdetails_tbl`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `resident_q`
--
ALTER TABLE `resident_q`
  MODIFY `question_id` int(11) NOT NULL AUTO_INCREMENT;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
