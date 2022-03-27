/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

DROP TABLE IF EXISTS `courses`;
CREATE TABLE `courses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `course_id` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `course_name` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `credits` int(128) DEFAULT NULL,
  `course_price` int(128) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
  PRIMARY KEY (`id`),
  KEY `student_id` (`student_id`),
  KEY `section_id` (`section_id`),
  CONSTRAINT `enrolled_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE,
  CONSTRAINT `enrolled_ibfk_2` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `sections`;
CREATE TABLE `sections` (
  `id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `tutor_id` int(11) NOT NULL,
  `time_id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `tutor_id` (`tutor_id`),
  KEY `time_id` (`time_id`),
  KEY `course_id` (`course_id`) USING BTREE,
  CONSTRAINT `sections_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`),
  CONSTRAINT `sections_ibfk_2` FOREIGN KEY (`tutor_id`) REFERENCES `teachers` (`id`),
  CONSTRAINT `sections_ibfk_3` FOREIGN KEY (`time_id`) REFERENCES `courses_time` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `students`;
CREATE TABLE `students` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(128) NOT NULL,
  `national_id` int(16) NOT NULL,
  `s_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `term_credits` smallint(6) DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `student_id` (`student_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `teachers`;
CREATE TABLE `teachers` (
  `id` int(11) NOT NULL,
  `teacher_name` varchar(255) NOT NULL,
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

INSERT INTO `courses` (`id`, `course_id`, `course_name`, `credits`, `course_price`) VALUES
(1, 'CS423', 'System Programming', 4, 2500);
INSERT INTO `courses` (`id`, `course_id`, `course_name`, `credits`, `course_price`) VALUES
(2, 'IT352', 'Data Science', 8, 3750);
INSERT INTO `courses` (`id`, `course_id`, `course_name`, `credits`, `course_price`) VALUES
(3, 'CS101', 'Java Programming', 10, 1580);

INSERT INTO `courses_time` (`id`, `section_id`, `time`) VALUES
(1, 1, 'Mon 13:30 Wed 13:30');
INSERT INTO `courses_time` (`id`, `section_id`, `time`) VALUES
(2, 1, 'Mon 08:00 Wed  08:00 ');
INSERT INTO `courses_time` (`id`, `section_id`, `time`) VALUES
(3, 2, 'Sun 15:00 Tue 15:00');
INSERT INTO `courses_time` (`id`, `section_id`, `time`) VALUES
(4, 2, 'Tue 01:00 Thu 11:00'),
(5, 3, 'Sun 08:00 Mon 09:30'),
(6, 3, 'Sun 11:00 Wed 12:30');

INSERT INTO `enrolled` (`id`, `student_id`, `section_id`) VALUES
(3, 4, 3);
INSERT INTO `enrolled` (`id`, `student_id`, `section_id`) VALUES
(4, 5, 1);
INSERT INTO `enrolled` (`id`, `student_id`, `section_id`) VALUES
(5, 5, 3);
INSERT INTO `enrolled` (`id`, `student_id`, `section_id`) VALUES
(46, 3, 1),
(47, 3, 2),
(48, 3, 5);

INSERT INTO `sections` (`id`, `course_id`, `tutor_id`, `time_id`, `status`) VALUES
(1, 1, 1, 1, 1);
INSERT INTO `sections` (`id`, `course_id`, `tutor_id`, `time_id`, `status`) VALUES
(2, 1, 2, 2, 1);
INSERT INTO `sections` (`id`, `course_id`, `tutor_id`, `time_id`, `status`) VALUES
(3, 2, 3, 3, 0);
INSERT INTO `sections` (`id`, `course_id`, `tutor_id`, `time_id`, `status`) VALUES
(4, 2, 2, 4, 1),
(5, 3, 2, 6, 1);

INSERT INTO `students` (`id`, `student_id`, `national_id`, `s_name`, `email`, `password`, `term_credits`) VALUES
(3, 123456789, 987654321, 'mohammed', 's@a.c22', '701fd6f18a46f7c72397c91b9cb1a6353744b9cca3aa329af5e5e1124b6b8c5a', 0);
INSERT INTO `students` (`id`, `student_id`, `national_id`, `s_name`, `email`, `password`, `term_credits`) VALUES
(4, 987654321, 123456789, 'ahmed', 'a@b.c', '481f6cc0511143ccdd7e2d1b1b94faf0a700a8b49cd13922a70b5ae28acaa8c5', 0);
INSERT INTO `students` (`id`, `student_id`, `national_id`, `s_name`, `email`, `password`, `term_credits`) VALUES
(5, 123654897, 987412563, 'Ali', 'z@y.x', '96cae35ce8a9b0244178bf28e4966c2ce1b8385723a96a6b838858cdd6ca0a1e', 0);

INSERT INTO `teachers` (`id`, `teacher_name`) VALUES
(1, 'Ali Khan');
INSERT INTO `teachers` (`id`, `teacher_name`) VALUES
(2, 'Othman Mohammed');
INSERT INTO `teachers` (`id`, `teacher_name`) VALUES
(3, 'Mustafa Qamar');

INSERT INTO `teachers_courses` (`id`, `tutor_id`, `course_id`) VALUES
(1, 1, 1);
INSERT INTO `teachers_courses` (`id`, `tutor_id`, `course_id`) VALUES
(2, 1, 2);
INSERT INTO `teachers_courses` (`id`, `tutor_id`, `course_id`) VALUES
(3, 2, 3);
INSERT INTO `teachers_courses` (`id`, `tutor_id`, `course_id`) VALUES
(4, 3, 2),
(5, 3, 3);


/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;