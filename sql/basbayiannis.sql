-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 17, 2022 at 06:28 PM
-- Server version: 5.1.36
-- PHP Version: 5.3.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `basbayiannis`
--

-- --------------------------------------------------------

--
-- Table structure for table `center`
--

CREATE TABLE IF NOT EXISTS `center` (
  `center_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `address` varchar(100) NOT NULL,
  `tk` int(11) NOT NULL,
  `phone` varchar(20) NOT NULL,
  PRIMARY KEY (`center_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `center`
--

INSERT INTO `center` (`center_id`, `name`, `address`, `tk`, `phone`) VALUES
(1, 'Εμβολιαστικό κέντρο Αθήνας', 'Λεωφόρος Κηφισίας 39, Μαρούσι', 15122, '213 2161000'),
(2, 'Εμβολιαστικό κέντρο Θεσσαλονίκης', 'Περίπτερο 13 ΔΕΘ-Θεσσαλονίκης, Θεσσαλονίκη', 54621, '2310 291512');

-- --------------------------------------------------------

--
-- Table structure for table `center_doctor`
--

CREATE TABLE IF NOT EXISTS `center_doctor` (
  `center_doctor_id` int(11) NOT NULL AUTO_INCREMENT,
  `doctor_id` int(11) DEFAULT NULL,
  `center_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`center_doctor_id`),
  KEY `doctor_id` (`doctor_id`),
  KEY `center_id` (`center_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `center_doctor`
--

INSERT INTO `center_doctor` (`center_doctor_id`, `doctor_id`, `center_id`) VALUES
(2, 6, 2);

-- --------------------------------------------------------

--
-- Table structure for table `rendezvous`
--

CREATE TABLE IF NOT EXISTS `rendezvous` (
  `rendezvous_id` int(11) NOT NULL AUTO_INCREMENT,
  `center_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `rendezvous_date` date NOT NULL,
  `rendezvous_time` time NOT NULL,
  `status` enum('ελεύθερο','προγραμματισμένο','ολοκληρωμένο') NOT NULL,
  PRIMARY KEY (`rendezvous_id`),
  KEY `center_id` (`center_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `rendezvous`
--

INSERT INTO `rendezvous` (`rendezvous_id`, `center_id`, `user_id`, `rendezvous_date`, `rendezvous_time`, `status`) VALUES
(1, 1, 1, '2022-04-01', '08:00:00', 'ολοκληρωμένο'),
(2, 1, NULL, '2022-04-01', '09:00:00', 'ελεύθερο'),
(3, 1, NULL, '2022-04-01', '10:00:00', 'ελεύθερο'),
(4, 1, NULL, '2022-04-02', '08:00:00', 'ελεύθερο'),
(5, 1, NULL, '2022-04-02', '09:00:00', 'ελεύθερο'),
(6, 1, 3, '2022-04-02', '10:00:00', 'ολοκληρωμένο'),
(7, 2, NULL, '2022-04-01', '08:00:00', 'ελεύθερο'),
(8, 2, NULL, '2022-04-01', '09:00:00', 'ελεύθερο'),
(9, 2, NULL, '2022-04-01', '10:00:00', 'ελεύθερο'),
(10, 2, NULL, '2022-04-02', '08:00:00', 'ελεύθερο'),
(11, 2, NULL, '2022-04-02', '09:00:00', 'ελεύθερο'),
(12, 2, 7, '2022-04-02', '10:00:00', 'ολοκληρωμένο');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `role` enum('ΠΟΛΙΤΗΣ','ΓΙΑΤΡΟΣ') NOT NULL,
  `name` varchar(50) NOT NULL,
  `surname` varchar(50) NOT NULL,
  `amka` varchar(11) NOT NULL,
  `afm` varchar(9) NOT NULL,
  `adt` varchar(20) NOT NULL,
  `age` int(11) NOT NULL,
  `sex` enum('ΑΡΡΕΝ','ΘΗΛΥ') DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `mobile` varchar(20) NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `afm` (`afm`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `role`, `name`, `surname`, `amka`, `afm`, `adt`, `age`, `sex`, `email`, `mobile`) VALUES
(1, 'ΠΟΛΙΤΗΣ', 'ΜΑΡΙΟΣ', 'ΜΑΡΚΟΥ', '10000000005', '100000005', 'ΒΥ 568974', 50, '', 'markou@gmail.com', '6896 022022'),
(3, 'ΠΟΛΙΤΗΣ', 'ΓΙΩΡΓΟΣ', 'ΓΕΩΡΓΙΟΥ', '10000000006', '100000006', 'ΔΟ 789654', 49, 'ΑΡΡΕΝ', '', '6934500560'),
(4, 'ΠΟΛΙΤΗΣ', 'ΠΑΝΟΣ', 'ΙΩΑΝΝΟΥ', '01234567890', '012345678', 'ΥΤ 898978', 30, '', 'mymai@gmail.com', '693875986'),
(6, 'ΓΙΑΤΡΟΣ', 'ΜΑΡΚΟΣ', 'ΜΑΡΙΟΠΟΥΛΟΣ', '10000000004', '100000004', 'ΚΛ 989898', 49, 'ΑΡΡΕΝ', '', '6932 058965'),
(7, 'ΠΟΛΙΤΗΣ', 'ΕΛΕΝΗ', 'ΙΩΑΝΝΟΥ', '11000000004', '110000004', 'ΟΟ 583600', 65, 'ΘΗΛΥ', '', '6932 558899');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `center_doctor`
--
ALTER TABLE `center_doctor`
  ADD CONSTRAINT `center_doctor_ibfk_1` FOREIGN KEY (`doctor_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `center_doctor_ibfk_2` FOREIGN KEY (`center_id`) REFERENCES `center` (`center_id`);

--
-- Constraints for table `rendezvous`
--
ALTER TABLE `rendezvous`
  ADD CONSTRAINT `rendezvous_ibfk_1` FOREIGN KEY (`center_id`) REFERENCES `center` (`center_id`),
  ADD CONSTRAINT `rendezvous_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);
