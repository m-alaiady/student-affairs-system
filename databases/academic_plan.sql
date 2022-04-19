/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

CREATE DATABASE `academic_plan`;

USE `academic_plan`;

DROP TABLE IF EXISTS `faculty_requirement_electives`;
CREATE TABLE `faculty_requirement_electives` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `course_id` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `course_name` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `credits` int(128) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `faculty_requirement_in_major`;
CREATE TABLE `faculty_requirement_in_major` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `course_id` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `course_name` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `credits` int(128) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `faculty_requirement_mandatory`;
CREATE TABLE `faculty_requirement_mandatory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `course_id` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `course_name` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `credits` int(128) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `foundation_program`;
CREATE TABLE `foundation_program` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `course_id` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `course_name` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `credits` int(128) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `general_requirement`;
CREATE TABLE `general_requirement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `course_id` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `course_name` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `credits` int(128) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `spec_faculty`;
CREATE TABLE `spec_faculty` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `course_id` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `course_name` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `credits` int(128) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `university_requirement`;
CREATE TABLE `university_requirement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `course_id` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `course_name` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `credits` int(128) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `faculty_requirement_electives` (`id`, `course_id`, `course_name`, `credits`) VALUES
(1, 'M109', '.NET programming', 3);
INSERT INTO `faculty_requirement_electives` (`id`, `course_id`, `course_name`, `credits`) VALUES
(2, 'MS102', 'Physics', 3);
INSERT INTO `faculty_requirement_electives` (`id`, `course_id`, `course_name`, `credits`) VALUES
(3, 'MT101', 'General Mathematics', 3);
INSERT INTO `faculty_requirement_electives` (`id`, `course_id`, `course_name`, `credits`) VALUES
(4, 'MT372', 'Parallel Computing', 3),
(5, 'TM295', 'System Modelling', 3);

INSERT INTO `faculty_requirement_in_major` (`id`, `course_id`, `course_name`, `credits`) VALUES
(10, 'CAS400', 'Applied Studies for Computing Students', 4);


INSERT INTO `faculty_requirement_mandatory` (`id`, `course_id`, `course_name`, `credits`) VALUES
(10, 'MT129', 'Calculus and Probability', 4);


INSERT INTO `foundation_program` (`id`, `course_id`, `course_name`, `credits`) VALUES
(1, 'EL097', 'English Oritentation Programme (Level 1)', 0);
INSERT INTO `foundation_program` (`id`, `course_id`, `course_name`, `credits`) VALUES
(2, 'EL098', 'English Oritentation Programme (Level 2)', 0);
INSERT INTO `foundation_program` (`id`, `course_id`, `course_name`, `credits`) VALUES
(3, 'EL099', 'English Oritentation Programme (Level 3)', 0);

INSERT INTO `general_requirement` (`id`, `course_id`, `course_name`, `credits`) VALUES
(4, 'AR111', 'Arabic Communication Skills (I) ', 3);
INSERT INTO `general_requirement` (`id`, `course_id`, `course_name`, `credits`) VALUES
(5, 'AR112', 'Arabic Communication Skills (II) ', 3);
INSERT INTO `general_requirement` (`id`, `course_id`, `course_name`, `credits`) VALUES
(6, 'EL111', 'English Communication Skills (I) ', 3);
INSERT INTO `general_requirement` (`id`, `course_id`, `course_name`, `credits`) VALUES
(7, 'EL112', 'English Communication Skills (II) ', 3),
(8, 'GR101', 'Self-Learning Skills', 3),
(9, 'TU170', 'Computing Essentials', 3);

INSERT INTO `spec_faculty` (`id`, `course_id`, `course_name`, `credits`) VALUES
(1, 'M251', 'Object-Oriented Programming using Java', 8);
INSERT INTO `spec_faculty` (`id`, `course_id`, `course_name`, `credits`) VALUES
(2, 'M269', 'Algorithms, Data Structures and Computability', 8);
INSERT INTO `spec_faculty` (`id`, `course_id`, `course_name`, `credits`) VALUES
(3, 'MT131', 'Discrete Mathematics', 4);
INSERT INTO `spec_faculty` (`id`, `course_id`, `course_name`, `credits`) VALUES
(4, 'MT132', 'Linear Algebra', 4),
(5, 'T227', 'Change, Strategy and Project at Work', 8),
(6, 'TM103', 'Computer Organization and Architecture', 4),
(7, 'TM105', 'Introduction to Programming', 4),
(8, 'TM111', 'Introduction to computing and information Technology (I)', 8),
(9, 'TM112', 'Introduction to computing and information Technology (II)', 8),
(10, 'TM240', 'Computer Graphics and Multimedia', 4),
(11, 'TM298', 'Operating Systems', 4),
(12, 'TM351', 'Data Management and Analysis', 8),
(13, 'TM354', 'Software Engineering', 8),
(14, 'TM366', 'Artifical Intelligence', 8),
(15, 'TM471', 'Graduation project', 8);

INSERT INTO `university_requirement` (`id`, `course_id`, `course_name`, `credits`) VALUES
(1, 'BE322/4', 'Entrepreneneuship and Small Business Manager', 4);
INSERT INTO `university_requirement` (`id`, `course_id`, `course_name`, `credits`) VALUES
(11, 'CH101', 'Chinese for Beginners (I)', 3);
INSERT INTO `university_requirement` (`id`, `course_id`, `course_name`, `credits`) VALUES
(12, 'CH102', 'Chinese for Beginners (II)', 3);
INSERT INTO `university_requirement` (`id`, `course_id`, `course_name`, `credits`) VALUES
(13, 'EL118', 'Reading', 4),
(14, 'FR101', 'French for Beginners (I)', 3),
(15, 'FR102', 'French for Beginners (II)', 3),
(16, 'GR111', 'Arab Islamic Civilization', 3),
(17, 'GR112', 'Issues and Problems of Development in the Arab World', 3),
(18, 'GR115', 'Current International Issues and Problems', 3),
(19, 'GR116', 'Youth Empowerment', 3),
(20, 'GR118', 'Life Skills', 3),
(21, 'GR121', 'Environment and Health', 3),
(22, 'GR131', 'History and Civilization of KSA', 3),
(23, 'SL101', 'Spanish for Beginners (I)', 3),
(24, 'SL102', 'Spanish for Beginners (II)', 3);


/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;