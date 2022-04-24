/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


CREATE DATABASE `sis project`;

USE `sis project`;

DROP TABLE IF EXISTS `absence_excuses`;
CREATE TABLE `absence_excuses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file_name` varchar(255) NOT NULL,
  `student_id` int(11) NOT NULL,
  `request_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `course_id` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `student_id` (`student_id`)
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `complaints`;
CREATE TABLE `complaints` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `details` varchar(255) NOT NULL,
  `status` varchar(255) DEFAULT 'Processing',
  `feedback` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `courses`;
CREATE TABLE `courses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `course_id` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `course_name` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `credits` int(128) DEFAULT NULL,
  `course_price` decimal(10,2) DEFAULT NULL,
  `allowed_absences` int(128) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `courses_time`;
CREATE TABLE `courses_time` (
  `id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL,
  `time` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `enrolled`;
CREATE TABLE `enrolled` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL,
  `absences` int(11) DEFAULT 0,
  `grade` int(11) DEFAULT NULL,
  `notes` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `student_id` (`student_id`),
  KEY `section_id` (`section_id`),
  CONSTRAINT `enrolled_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE,
  CONSTRAINT `enrolled_ibfk_2` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=179 DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `faculties`;
CREATE TABLE `faculties` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `branch` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `offered_courses`;
CREATE TABLE `offered_courses` (
  `id` int(11) NOT NULL DEFAULT 0,
  `course_id` varchar(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `course_name` varchar(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `credits` int(128) DEFAULT NULL,
  `course_price` decimal(10,2) DEFAULT NULL,
  `allowed_absences` int(128) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `payment_support`;
CREATE TABLE `payment_support` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `details` varchar(255) NOT NULL,
  `status` varchar(255) DEFAULT 'Processing',
  `feedback` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `registration_assistant`;
CREATE TABLE `registration_assistant` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `details` varchar(255) NOT NULL,
  `status` varchar(255) DEFAULT 'Processing',
  `feedback` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `sections`;
CREATE TABLE `sections` (
  `id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `tutor_id` int(11) NOT NULL,
  `time_id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `exam_date` date DEFAULT NULL,
  `exam_time` time DEFAULT NULL,
  `room` varchar(255) DEFAULT NULL,
  `lecture_type` varchar(255) DEFAULT NULL,
  `lab_type` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tutor_id` (`tutor_id`),
  KEY `time_id` (`time_id`),
  KEY `course_id` (`course_id`) USING BTREE,
  CONSTRAINT `sections_ibfk_2` FOREIGN KEY (`tutor_id`) REFERENCES `teachers` (`id`),
  CONSTRAINT `sections_ibfk_3` FOREIGN KEY (`time_id`) REFERENCES `courses_time` (`id`),
  CONSTRAINT `sections_ibfk_4` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `students`;
CREATE TABLE `students` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(128) NOT NULL,
  `national_id` int(16) NOT NULL,
  `s_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mobile2` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mobile` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `blood` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `GPA` float(3,2) NOT NULL,
  `term_credits` smallint(6) DEFAULT 0,
  `status` tinyint(1) NOT NULL,
  `acceptance_term` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `major` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `faculty_id` int(11) NOT NULL DEFAULT 0,
  `birth_date` date DEFAULT NULL,
  `nationality` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `degree` varchar(255) COLLATE utf8_unicode_ci DEFAULT 'None',
  `level` varchar(255) COLLATE utf8_unicode_ci DEFAULT 'One',
  `gender` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mother` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `birth_place` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `student_id` (`student_id`),
  KEY `faculty_id` (`faculty_id`),
  CONSTRAINT `students_ibfk_1` FOREIGN KEY (`faculty_id`) REFERENCES `faculties` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `teachers`;
CREATE TABLE `teachers` (
  `id` int(11) NOT NULL,
  `teacher_name` varchar(255) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `teachers_courses`;
CREATE TABLE `teachers_courses` (
  `id` int(11) NOT NULL,
  `tutor_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `tutor_id` (`tutor_id`),
  KEY `course_id` (`course_id`),
  CONSTRAINT `teachers_courses_ibfk_1` FOREIGN KEY (`tutor_id`) REFERENCES `teachers` (`id`),
  CONSTRAINT `teachers_courses_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `tuition_fees_exemption`;
CREATE TABLE `tuition_fees_exemption` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `request_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `semester` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT 'Processing',
  `feedback` text DEFAULT NULL,
  `account_file` varchar(255) DEFAULT NULL,
  `electricity_file` varchar(255) DEFAULT NULL,
  `salary_file` varchar(255) DEFAULT NULL,
  `social_file` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `student_id` (`student_id`),
  CONSTRAINT `tuition_fees_exemption_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=latin1;

INSERT INTO `absence_excuses` (`id`, `file_name`, `student_id`, `request_date`, `course_id`) VALUES
(55, '6260beb864a2c2.88221040.jpg', 3, '2022-04-21 05:17:28', 'TM111');




INSERT INTO `courses` (`id`, `course_id`, `course_name`, `credits`, `course_price`, `allowed_absences`) VALUES
(31, 'TM111', 'Introduction to computing and information Technology (I)', 8, 2400.00, 5);
INSERT INTO `courses` (`id`, `course_id`, `course_name`, `credits`, `course_price`, `allowed_absences`) VALUES
(32, 'TM112', 'Introduction to computing and information Technology (II)', 8, 2400.00, 5);
INSERT INTO `courses` (`id`, `course_id`, `course_name`, `credits`, `course_price`, `allowed_absences`) VALUES
(33, 'MT131', 'Discrete Mathematics', 4, 1250.00, 5);
INSERT INTO `courses` (`id`, `course_id`, `course_name`, `credits`, `course_price`, `allowed_absences`) VALUES
(34, 'MT132', 'Linear Algebra', 4, 1250.00, 5),
(35, 'RM115', 'Some course', 8, 2400.00, 5),
(36, 'RM116', 'Some course 2', 8, 2400.00, 5);

INSERT INTO `courses_time` (`id`, `section_id`, `time`) VALUES
(1, 1, 'Mon 18:30 Wed 18:00');
INSERT INTO `courses_time` (`id`, `section_id`, `time`) VALUES
(2, 2, 'Mon 20:00 Wed  20:00 ');
INSERT INTO `courses_time` (`id`, `section_id`, `time`) VALUES
(3, 3, 'Sun 17:00 Tue 17:30');
INSERT INTO `courses_time` (`id`, `section_id`, `time`) VALUES
(4, 4, 'Thr 15:00 Mon 15:30'),
(5, 6, 'Mon 18:30 Wed 18:00'),
(6, 5, 'Thr 15:00 Mon 15:30'),
(7, 6, 'Thr 15:00 Mon 15:30'),
(8, 7, 'Thr 15:00 Mon 15:30');

INSERT INTO `enrolled` (`id`, `student_id`, `section_id`, `absences`, `grade`, `notes`) VALUES
(147, 3, 3, 0, NULL, NULL);
INSERT INTO `enrolled` (`id`, `student_id`, `section_id`, `absences`, `grade`, `notes`) VALUES
(148, 3, 1, 0, NULL, NULL);


INSERT INTO `faculties` (`id`, `name`, `branch`) VALUES
(1, 'computer', 'Riyadh');
INSERT INTO `faculties` (`id`, `name`, `branch`) VALUES
(2, 'computer', 'Jeddah');
INSERT INTO `faculties` (`id`, `name`, `branch`) VALUES
(3, 'Mechanical Engineering', 'Bahrain');

INSERT INTO `offered_courses` (`id`, `course_id`, `course_name`, `credits`, `course_price`, `allowed_absences`) VALUES
(4, 'ACC300', 'Accounting Information system', 4, 1622.40, 4);
INSERT INTO `offered_courses` (`id`, `course_id`, `course_name`, `credits`, `course_price`, `allowed_absences`) VALUES
(5, 'ACC302', 'auditing theory and practice', 4, 1622.40, 4);
INSERT INTO `offered_courses` (`id`, `course_id`, `course_name`, `credits`, `course_price`, `allowed_absences`) VALUES
(6, 'ACCT201', 'principles of accounting (1)', 4, 2340.00, 4);
INSERT INTO `offered_courses` (`id`, `course_id`, `course_name`, `credits`, `course_price`, `allowed_absences`) VALUES
(7, 'ACCT202', 'principles of accounting (2)', 3, 2340.00, 4),
(8, 'ACCT250', 'computer applications in accounting', 3, 2340.00, 4),
(9, 'ACCT301', 'Accounting Information Systems', 3, 2340.00, 4),
(10, 'ACCT305', 'Cost accounting', 3, 2340.00, 4),
(11, 'ACCT306', 'Managerial accounting', 3, 2340.00, 4),
(12, 'ACCT307', 'Govermental accounting', 3, 2340.00, 4),
(13, 'ACCT311', 'Audit of accounting information systems', 3, 2340.00, 4),
(14, 'ACCT320', 'Intermediate Accounting (1)', 3, 2340.00, 4),
(15, 'ACCT322', 'Intermediate Accounting (2)', 3, 2340.00, 4),
(16, 'ACCT330', 'Financial Statement analysis', 3, 2340.00, 4),
(17, 'ACCT340', 'Tax accounting and zakat', 3, 2340.00, 4),
(18, 'ACCT345', 'Corporate accounting', 3, 2340.00, 4),
(19, 'ACCT350', 'Banking and insurance accounting', 3, 2340.00, 4),
(20, 'ACCT401', 'Accounting Theory', 3, 2340.00, 4),
(21, 'ACCT402', 'Auditing', 3, 2340.00, 4),
(22, 'ACCT403', 'Advanced financial accounting', 3, 2340.00, 4),
(23, 'ACCT412', 'International Auditing standards', 3, 2340.00, 4),
(24, 'ACCT413', 'International Accounting standards', 3, 2340.00, 4),
(25, 'ACCT420', 'Contemporary Issues in international accounting', 3, 2340.00, 4),
(26, 'B124', 'Fundamentals of accounting', 8, 3244.80, 4),
(27, 'B291', 'Financial Accounting', 8, 3244.80, 4),
(28, 'B292', 'certificate in accounting (cost and management accounting)', 8, 3244.80, 4),
(29, 'B326', 'Advanced financial accounting', 8, 3244.80, 4),
(30, 'B392', 'Advanced management accounting', 8, 3244.80, 4);





INSERT INTO `sections` (`id`, `course_id`, `tutor_id`, `time_id`, `status`, `exam_date`, `exam_time`, `room`, `lecture_type`, `lab_type`) VALUES
(1, 31, 1, 1, 1, '2022-05-01', '12:35:00', 'RF011', 'Class', 'Virtual');
INSERT INTO `sections` (`id`, `course_id`, `tutor_id`, `time_id`, `status`, `exam_date`, `exam_time`, `room`, `lecture_type`, `lab_type`) VALUES
(2, 32, 2, 2, 1, '2022-05-27', '08:00:00', 'RF021', 'Class', 'Class');
INSERT INTO `sections` (`id`, `course_id`, `tutor_id`, `time_id`, `status`, `exam_date`, `exam_time`, `room`, `lecture_type`, `lab_type`) VALUES
(3, 33, 3, 3, 1, '2022-06-11', '10:00:00', 'RF031', 'Class', 'Virtual');
INSERT INTO `sections` (`id`, `course_id`, `tutor_id`, `time_id`, `status`, `exam_date`, `exam_time`, `room`, `lecture_type`, `lab_type`) VALUES
(4, 34, 3, 4, 0, '2022-06-11', '10:00:00', 'RF032', 'Class', 'Class'),
(5, 35, 3, 4, 1, '2022-06-11', '10:00:00', 'RF032', 'Class', 'Class'),
(6, 36, 2, 5, 1, '2022-06-11', '10:00:00', 'RF032', 'Class', 'Class'),
(7, 36, 3, 2, 1, '2022-06-11', '10:00:00', 'RF032', 'Class', 'Class');

INSERT INTO `students` (`id`, `student_id`, `national_id`, `s_name`, `email`, `mobile2`, `mobile`, `blood`, `password`, `GPA`, `term_credits`, `status`, `acceptance_term`, `major`, `faculty_id`, `birth_date`, `nationality`, `degree`, `level`, `gender`, `mother`, `birth_place`) VALUES
(3, 123456789, 987654321, 'Zaiad Falah Hassan Alharbi', 's@a.c22', '0553401234', '0553409834', 'O+', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 2.41, 0, 1, 'First Semester 2017-2018', 'Computer Science', 1, '1990-01-01', 'Saudi', 'Bachelors', 'One', 'male', '', '');
INSERT INTO `students` (`id`, `student_id`, `national_id`, `s_name`, `email`, `mobile2`, `mobile`, `blood`, `password`, `GPA`, `term_credits`, `status`, `acceptance_term`, `major`, `faculty_id`, `birth_date`, `nationality`, `degree`, `level`, `gender`, `mother`, `birth_place`) VALUES
(4, 987654321, 123456789, 'ahmed', 'a@b.c', '0', '0', '', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 0.00, 0, 0, '', '', 1, '2004-05-27', 'Saudi', 'Master', 'One', 'male', NULL, NULL);
INSERT INTO `students` (`id`, `student_id`, `national_id`, `s_name`, `email`, `mobile2`, `mobile`, `blood`, `password`, `GPA`, `term_credits`, `status`, `acceptance_term`, `major`, `faculty_id`, `birth_date`, `nationality`, `degree`, `level`, `gender`, `mother`, `birth_place`) VALUES
(5, 123654897, 987412563, 'Ali', 'z@y.x', '0', '0', '', '96cae35ce8a9b0244178bf28e4966c2ce1b8385723a96a6b838858cdd6ca0a1e', 0.00, 0, 0, '', '', 1, '1984-07-30', 'Jordanian', 'PhD', 'One', 'male', NULL, NULL);

INSERT INTO `teachers` (`id`, `teacher_name`) VALUES
(1, 'شيخان');
INSERT INTO `teachers` (`id`, `teacher_name`) VALUES
(2, 'Areej Alqhtani');
INSERT INTO `teachers` (`id`, `teacher_name`) VALUES
(3, 'Lamia');

INSERT INTO `teachers_courses` (`id`, `tutor_id`, `course_id`) VALUES
(1, 1, 31);
INSERT INTO `teachers_courses` (`id`, `tutor_id`, `course_id`) VALUES
(3, 2, 32);
INSERT INTO `teachers_courses` (`id`, `tutor_id`, `course_id`) VALUES
(4, 3, 33);
INSERT INTO `teachers_courses` (`id`, `tutor_id`, `course_id`) VALUES
(5, 3, 34);




/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;