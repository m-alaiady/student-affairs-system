/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

DROP TABLE IF EXISTS `change_exam_location`;
CREATE TABLE `change_exam_location` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `course` varchar(255) NOT NULL,
  `branch` varchar(255) NOT NULL,
  `center` varchar(255) DEFAULT '',
  `status` varchar(255) DEFAULT 'Processing',
  `feedback` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `exam_certificate`;
CREATE TABLE `exam_certificate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `course_code` varchar(255) NOT NULL,
  `course` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  `time` varchar(255) DEFAULT '',
  `status` varchar(255) DEFAULT 'Processing',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `exam_objection`;
CREATE TABLE `exam_objection` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `course` varchar(255) NOT NULL,
  `details` varchar(255) NOT NULL,
  `feedback` varchar(255) DEFAULT '',
  `status` varchar(255) DEFAULT 'Processing',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `exam_postpone`;
CREATE TABLE `exam_postpone` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `course` varchar(255) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `status` varchar(255) DEFAULT 'Processing',
  `feedback` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `exam_schedule`;
CREATE TABLE `exam_schedule` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `course_code` varchar(255) NOT NULL,
  `course` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  `time` varchar(255) DEFAULT '',
  `status` varchar(255) DEFAULT 'Processing',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `change_exam_location` (`id`, `student_id`, `course`, `branch`, `center`, `status`, `feedback`) VALUES
(1, 3, 'Java Programming', 'kuwait', 'kuwait', 'Processing', NULL);
INSERT INTO `change_exam_location` (`id`, `student_id`, `course`, `branch`, `center`, `status`, `feedback`) VALUES
(2, 3, 'Data Science', 'lebanon', 'lebanon', 'Processing', NULL);




INSERT INTO `exam_objection` (`id`, `student_id`, `course`, `details`, `feedback`, `status`) VALUES
(1, 3, 'Java Programming', 'aa', '', 'Processing');


INSERT INTO `exam_postpone` (`id`, `student_id`, `course`, `file_name`, `status`, `feedback`) VALUES
(1, 3, 'Java Programming', '625392fed671b2.63590532.png', 'Processing', NULL);





/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;