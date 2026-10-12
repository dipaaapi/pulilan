-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for pulilan
CREATE DATABASE IF NOT EXISTS `pulilan` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `pulilan`;

-- Dumping structure for table pulilan.achievement_tbl
CREATE TABLE IF NOT EXISTS `achievement_tbl` (
  `achievement_id` int NOT NULL AUTO_INCREMENT,
  `project_name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `project_description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `picture` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_submitted` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`achievement_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table pulilan.achievement_tbl: ~3 rows (approximately)
-- Private seed records omitted from the repository.

-- Dumping structure for table pulilan.brgydetails_tbl
CREATE TABLE IF NOT EXISTS `brgydetails_tbl` (
  `brgydetails_id` int NOT NULL AUTO_INCREMENT,
  `fullname` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `brgy_location` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_purok` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `major_sources` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `brgy_classification` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `char_brgy` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `position` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `male_tanod` int NOT NULL DEFAULT '0',
  `female_tanod` int NOT NULL DEFAULT '0',
  `male_health_worker` int NOT NULL DEFAULT '0',
  `female_health_worker` int NOT NULL DEFAULT '0',
  `male_nutrition_scholar` int NOT NULL DEFAULT '0',
  `female_nutrition_scholar` int NOT NULL DEFAULT '0',
  `male_purok_leaders` int NOT NULL DEFAULT '0',
  `female_purok_leaders` int NOT NULL DEFAULT '0',
  `male_librarian` int NOT NULL DEFAULT '0',
  `female_librarian` int NOT NULL DEFAULT '0',
  `male_day_care_worker` int NOT NULL DEFAULT '0',
  `female_day_care_worker` int NOT NULL DEFAULT '0',
  `male_utility_worker` int NOT NULL DEFAULT '0',
  `female_utility_worker` int NOT NULL DEFAULT '0',
  `type` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`brgydetails_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table pulilan.brgydetails_tbl: ~3 rows (approximately)
-- Private seed records omitted from the repository.

-- Dumping structure for table pulilan.brgy_q
CREATE TABLE IF NOT EXISTS `brgy_q` (
  `question_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `position` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `brgy_classification` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `brgy_location` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `char_brgy` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_land_area` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `major_sources` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `boundaries` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_household` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_families` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_male_voters` int NOT NULL,
  `total_female_voters` int NOT NULL,
  `male_tanod` int NOT NULL,
  `female_tanod` int NOT NULL,
  `male_health_worker` int NOT NULL,
  `female_health_worker` int NOT NULL,
  `male_nutrition_scholar` int NOT NULL,
  `female_nutrition_scholar` int NOT NULL,
  `male_purok_leaders` int NOT NULL,
  `female_purok_leaders` int NOT NULL,
  `male_librarian` int NOT NULL,
  `female_librarian` int NOT NULL,
  `male_day_care_worker` int NOT NULL,
  `female_day_care_worker` int NOT NULL,
  `male_utility_worker` int NOT NULL,
  `female_utility_worker` int NOT NULL,
  `no_purok` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `brgy_health_center` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `hospital` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `maternity_clinic` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `child_clinic` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `botika_brgy` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `brgy_day_care_center` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `preschool` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `elementary` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `secondary` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `vocational` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `college_university` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_office` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `market` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `ricemill` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `cornmill` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `feedmill` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `agricultural_market` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `fertilizer` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `pesticide` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `seeds` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `feeds` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `visibility` tinyint NOT NULL DEFAULT '0',
  PRIMARY KEY (`question_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table pulilan.brgy_q: ~0 rows (approximately)

-- Dumping structure for table pulilan.brgy_tbl
CREATE TABLE IF NOT EXISTS `brgy_tbl` (
  `psgc` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `brgy_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `classification` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `brgy_alt_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT 'N/A',
  `density` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `land_area_per_square_meter` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `c_pop` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`psgc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table pulilan.brgy_tbl: ~19 rows (approximately)
INSERT IGNORE INTO `brgy_tbl` (`psgc`, `brgy_name`, `classification`, `brgy_alt_name`, `density`, `land_area_per_square_meter`, `c_pop`) VALUES
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

-- Dumping structure for table pulilan.check_tbl
CREATE TABLE IF NOT EXISTS `check_tbl` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `c` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cc` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `php` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `java` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `visibility` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table pulilan.check_tbl: ~3 rows (approximately)
-- Private seed records omitted from the repository.

-- Dumping structure for table pulilan.contact
CREATE TABLE IF NOT EXISTS `contact` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `fullname` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phoneno` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cdate` date NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table pulilan.contact: ~2 rows (approximately)
-- Private seed records omitted from the repository.

-- Dumping structure for table pulilan.loghistory
CREATE TABLE IF NOT EXISTS `loghistory` (
  `log_id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table pulilan.loghistory: ~2 rows (approximately)
-- Private seed records omitted from the repository.

-- Dumping structure for table pulilan.mainuser_acc
CREATE TABLE IF NOT EXISTS `mainuser_acc` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `brgy_location` varchar(225) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `position` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `brgy_id` int NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `registered_voter` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_son` int NOT NULL,
  `no_daughter` int NOT NULL,
  `no_nephew` int NOT NULL,
  `no_niece` int NOT NULL,
  `no_purok` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `major_sources` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `brgy_classification` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `char_brgy` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `male_tanod` int NOT NULL DEFAULT '0',
  `female_tanod` int NOT NULL DEFAULT '0',
  `male_health_worker` int NOT NULL DEFAULT '0',
  `female_health_worker` int NOT NULL DEFAULT '0',
  `male_nutrition_scholar` int NOT NULL DEFAULT '0',
  `female_nutrition_scholar` int NOT NULL DEFAULT '0',
  `male_purok_leaders` int NOT NULL DEFAULT '0',
  `female_purok_leaders` int NOT NULL DEFAULT '0',
  `male_librarian` int NOT NULL DEFAULT '0',
  `female_librarian` int NOT NULL DEFAULT '0',
  `male_day_care_worker` int NOT NULL DEFAULT '0',
  `female_day_care_worker` int NOT NULL DEFAULT '0',
  `male_utility_worker` int NOT NULL DEFAULT '0',
  `female_utility_worker` int NOT NULL DEFAULT '0',
  `province` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `city_municipality` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `purok_district` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `civil_status` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `visibility` tinyint(1) DEFAULT '0',
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `edit_status` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'disabled',
  `edit_notif` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'UNSEEN',
  `activate` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table pulilan.mainuser_acc: ~6 rows (approximately)
-- Private seed records omitted from the repository.

-- Dumping structure for table pulilan.memo
CREATE TABLE IF NOT EXISTS `memo` (
  `memo_id` int NOT NULL AUTO_INCREMENT,
  `project_name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `project_description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `picture` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `memo_date` date NOT NULL,
  `receiver` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `memo_status` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'PENDING',
  `notification_status` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'UNSEEN',
  PRIMARY KEY (`memo_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table pulilan.memo: ~4 rows (approximately)
-- Private seed records omitted from the repository.

-- Dumping structure for table pulilan.message_tbl
CREATE TABLE IF NOT EXISTS `message_tbl` (
  `message_id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `brgy_location` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int NOT NULL,
  `notification_status` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'UNSEEN',
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`message_id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table pulilan.message_tbl: ~3 rows (approximately)
-- Private seed records omitted from the repository.

-- Dumping structure for table pulilan.residentdetails_tbl
CREATE TABLE IF NOT EXISTS `residentdetails_tbl` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `position` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `brgy_location` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `province` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city_municipality` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `purok_district` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `civil_status` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `activate` tinyint(1) NOT NULL DEFAULT '0',
  `type` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table pulilan.residentdetails_tbl: ~1 rows (approximately)
-- Private seed records omitted from the repository.

-- Dumping structure for table pulilan.resident_q
CREATE TABLE IF NOT EXISTS `resident_q` (
  `question_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `type` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `position` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `brgy_id_num` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `city_municipality` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `brgy_location` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `purok_district` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `province` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `indigenous` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `kind_tribe` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `former_residences` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `howlong_residences` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `civil_stat` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `relation_whom` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_partner` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `religion` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `registered_civil` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `skills` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `stat_house` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_fam_house` int NOT NULL,
  `no_household` int NOT NULL,
  `have_electricity` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `source_electricity` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `educ_stat` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `honors` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `registered_voters` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `latest_vote` date NOT NULL,
  `visibility` int NOT NULL DEFAULT '0',
  `date` date NOT NULL,
  PRIMARY KEY (`question_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table pulilan.resident_q: ~0 rows (approximately)

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
