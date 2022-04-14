/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

DROP TABLE IF EXISTS `aid_request`;
CREATE TABLE `aid_request` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `semester` varchar(255) NOT NULL,
  `details` varchar(255) DEFAULT '0',
  `status` varchar(255) DEFAULT 'Processing',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `change_branch`;
CREATE TABLE `change_branch` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `branch` varchar(255) NOT NULL,
  `center` varchar(255) DEFAULT '0',
  `status` varchar(255) DEFAULT 'Processing',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `change_track`;
CREATE TABLE `change_track` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `faculty` varchar(255) NOT NULL,
  `track` varchar(255) DEFAULT '0',
  `status` varchar(255) DEFAULT 'Processing',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `courses_equalize`;
CREATE TABLE `courses_equalize` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `status` varchar(255) DEFAULT 'Processing',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `english_equalize`;
CREATE TABLE `english_equalize` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `status` varchar(255) DEFAULT 'Processing',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `id_reissuing`;
CREATE TABLE `id_reissuing` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `reason` varchar(255) NOT NULL,
  `status` varchar(255) DEFAULT 'Processing',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `semester_excuse`;
CREATE TABLE `semester_excuse` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `semester` varchar(255) NOT NULL,
  `confirmation` varchar(255) DEFAULT '0',
  `status` varchar(255) DEFAULT 'Processing',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `semester_postponing`;
CREATE TABLE `semester_postponing` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `semester` varchar(255) NOT NULL,
  `confirmation` varchar(255) DEFAULT '0',
  `status` varchar(255) DEFAULT 'Processing',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `social_reward`;
CREATE TABLE `social_reward` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `semester` varchar(255) NOT NULL,
  `details` varchar(255) DEFAULT '0',
  `status` varchar(255) DEFAULT 'Processing',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `withdraw_from_university`;
CREATE TABLE `withdraw_from_university` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `semester` varchar(255) NOT NULL,
  `confirmation` varchar(255) DEFAULT '0',
  `status` varchar(255) DEFAULT 'Processing',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

INSERT INTO `aid_request` (`id`, `student_id`, `semester`, `details`, `status`) VALUES
(1, 3, 'Spring term 21-22', 'asdsdsadsa', 'Processing');
INSERT INTO `aid_request` (`id`, `student_id`, `semester`, `details`, `status`) VALUES
(2, 3, 'Spring term 21-22', 'a', 'Processing');


INSERT INTO `change_branch` (`id`, `student_id`, `branch`, `center`, `status`) VALUES
(1, 3, 'saudi_arabia', 'madina', 'Processing');


INSERT INTO `change_track` (`id`, `student_id`, `faculty`, `track`, `status`) VALUES
(3, 3, 'business_studies', 'accounting', 'Processing');
INSERT INTO `change_track` (`id`, `student_id`, `faculty`, `track`, `status`) VALUES
(4, 3, 'business_studies', 'accounting_in_arabic', 'Processing');


INSERT INTO `courses_equalize` (`id`, `student_id`, `file_name`, `status`) VALUES
(1, 3, '6251fc625fbd86.40022772.jpg', 'Processing');
INSERT INTO `courses_equalize` (`id`, `student_id`, `file_name`, `status`) VALUES
(2, 3, '6251fcbe3edca7.56663314.pdf', 'Processing');
INSERT INTO `courses_equalize` (`id`, `student_id`, `file_name`, `status`) VALUES
(3, 3, '625204084a18b3.89382819.png', 'Processing');

INSERT INTO `english_equalize` (`id`, `student_id`, `file_name`, `status`) VALUES
(1, 3, '6251fbca712084.75057088.png', 'Processing');
INSERT INTO `english_equalize` (`id`, `student_id`, `file_name`, `status`) VALUES
(2, 3, '6251fbed1e3a83.40562399.png', 'Processing');
INSERT INTO `english_equalize` (`id`, `student_id`, `file_name`, `status`) VALUES
(3, 3, '6251fc9f9847a9.44886638.png', 'Processing');
INSERT INTO `english_equalize` (`id`, `student_id`, `file_name`, `status`) VALUES
(4, 3, '625203f3b076e3.88890935.png', 'Processing');

INSERT INTO `id_reissuing` (`id`, `student_id`, `file_name`, `reason`, `status`) VALUES
(1, 3, '625203ae7f4ba1.46557479.png', 'lost', 'Processing');
INSERT INTO `id_reissuing` (`id`, `student_id`, `file_name`, `reason`, `status`) VALUES
(2, 3, '625203e8933162.11652160.png', 'defective', 'Processing');
INSERT INTO `id_reissuing` (`id`, `student_id`, `file_name`, `reason`, `status`) VALUES
(3, 3, '62536ca35f5393.94597139.png', 'defective', 'Processing');

INSERT INTO `semester_excuse` (`id`, `student_id`, `semester`, `confirmation`, `status`) VALUES
(1, 3, 'Spring term 21-22', '', 'Processing');
INSERT INTO `semester_excuse` (`id`, `student_id`, `semester`, `confirmation`, `status`) VALUES
(2, 3, 'Spring term 21-22', 'on', 'Processing');
INSERT INTO `semester_excuse` (`id`, `student_id`, `semester`, `confirmation`, `status`) VALUES
(3, 3, 'Spring term 21-22', '', 'Processing');
INSERT INTO `semester_excuse` (`id`, `student_id`, `semester`, `confirmation`, `status`) VALUES
(4, 3, 'Spring term 21-22', '', 'Processing'),
(5, 3, 'Spring term 21-22', 'on', 'Processing');

INSERT INTO `semester_postponing` (`id`, `student_id`, `semester`, `confirmation`, `status`) VALUES
(2, 3, 'Spring term 21-22', 'on', 'Processing');
INSERT INTO `semester_postponing` (`id`, `student_id`, `semester`, `confirmation`, `status`) VALUES
(3, 3, 'Spring term 21-22', 'on', 'Processing');
INSERT INTO `semester_postponing` (`id`, `student_id`, `semester`, `confirmation`, `status`) VALUES
(4, 3, 'Spring term 21-22', 'on', 'Processing');

INSERT INTO `social_reward` (`id`, `student_id`, `semester`, `details`, `status`) VALUES
(1, 3, 'Spring term 21-22', 'aaa', 'Processing');


INSERT INTO `withdraw_from_university` (`id`, `student_id`, `semester`, `confirmation`, `status`) VALUES
(1, 3, 'Spring term 21-22', 'on', 'Processing');



/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;