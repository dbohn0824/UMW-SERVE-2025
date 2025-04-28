-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 28, 2025 at 05:11 PM
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
-- Database: `servedb`
--

-- --------------------------------------------------------

--
-- Table structure for table `dblog`
--

CREATE TABLE `dblog` (
  `id` varchar(256) NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `message` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dbmessages`
--

CREATE TABLE `dbmessages` (
  `id` int(11) NOT NULL,
  `senderID` varchar(256) NOT NULL,
  `recipientID` varchar(256) NOT NULL,
  `title` varchar(256) NOT NULL,
  `body` text NOT NULL,
  `time` varchar(16) NOT NULL,
  `wasRead` tinyint(1) NOT NULL DEFAULT 0,
  `prioritylevel` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dbmessages`
--

INSERT INTO `dbmessages` (`id`, `senderID`, `recipientID`, `title`, `body`, `time`, `wasRead`, `prioritylevel`) VALUES
(225, 'vmsroot', 'aaa', 'Community Service Letter Request Successful', 'Hello!\nYou have officially requested a community service letter as of 04 06, 2025. \r\n        A notice has been sent to staff, and you should expect a reply within the next two business days.', '2025-04-06-12:39', 1, 0),
(227, 'vmsroot', 'aaa', 'Community Service Letter Request Successful', 'Hello!\nYou have officially requested a community service letter as of 04 06, 2025. \r\n        A notice has been sent to staff, and you should expect a reply within the next two business days.', '2025-04-06-20:07', 1, 0),
(229, 'vmsroot', 'aaa', 'Community Service Letter Request Successful', 'Hello!\nYou have officially requested a community service letter as of 04 06, 2025. \r\n    A notice has been sent to staff, and you should expect a reply within the next two business days.', '2025-04-06-20:15', 1, 0),
(231, 'vmsroot', 'aaa', 'Community Service Letter Request Successful', 'Hello!\nYou have officially requested a community service letter as of 04 06, 2025. \r\n    A notice has been sent to staff, and you should expect a reply within the next two business days.', '2025-04-06-20:15', 1, 0),
(233, 'vmsroot', 'aaa', 'Community Service Letter Request Successful', 'Hello!\nYou have officially requested a community service letter as of 04 06, 2025. \r\n    A notice has been sent to staff, and you should expect a reply within the next two business days.', '2025-04-06-20:15', 1, 0),
(235, 'vmsroot', 'aaa', 'Community Service Letter Request Successful', 'Hello!\nYou have officially requested a community service letter as of 04 06, 2025. \r\n    A notice has been sent to staff, and you should expect a reply within the next two business days.', '2025-04-06-20:16', 1, 0),
(237, 'vmsroot', 'aaa', 'Community Service Letter Request Successful', 'Hello!\nYou have officially requested a community service letter as of 04 06, 2025. \r\n    A notice has been sent to staff, and you should expect a reply within the next two business days.', '2025-04-06-20:16', 1, 0),
(239, 'vmsroot', 'aaa', 'Community Service Letter Request Successful', 'Hello!\nYou have officially requested a community service letter as of 04 06, 2025. \r\n    A notice has been sent to staff, and you should expect a reply within the next two business days.', '2025-04-06-20:16', 1, 0),
(241, 'vmsroot', 'aaa', 'Community Service Letter Request Successful', 'Hello!\nYou have officially requested a community service letter as of 04 06, 2025. \r\n    A notice has been sent to staff, and you should expect a reply within the next two business days.', '2025-04-06-20:16', 1, 0),
(243, 'vmsroot', 'aaa', 'Community Service Letter Request Successful', 'Hello!\nYou have officially requested a community service letter as of 04 06, 2025. \r\n    A notice has been sent to staff, and you should expect a reply within the next two business days.', '2025-04-06-20:16', 1, 0),
(245, 'vmsroot', 'aaa', 'Community Service Letter Request Successful', 'Hello!\nYou have officially requested a community service letter as of 04 06, 2025. \r\n    A notice has been sent to staff, and you should expect a reply within the next two business days.', '2025-04-06-20:16', 1, 0),
(247, 'vmsroot', 'aaa', 'Community Service Letter Request Successful', 'Hello!\nYou have officially requested a community service letter as of 04 06, 2025. \r\n    A notice has been sent to staff, and you should expect a reply within the next two business days.', '2025-04-06-20:16', 1, 0),
(249, 'vmsroot', 'aaa', 'Community Service Letter Request Successful', 'Hello!\nYou have officially requested a community service letter as of 04 06, 2025. \r\n    A notice has been sent to staff, and you should expect a reply within the next two business days.', '2025-04-06-20:16', 1, 0),
(251, 'vmsroot', 'aaa', 'Community Service Letter Request Successful', 'Hello!\nYou have officially requested a community service letter as of 04 06, 2025. \r\n    A notice has been sent to staff, and you should expect a reply within the next two business days.', '2025-04-06-20:18', 1, 0),
(253, 'vmsroot', 'aaa', 'Community Service Letter Request Successful', 'Hello!\nYou have officially requested a community service letter as of 04 06, 2025. \r\n    A notice has been sent to staff, and you should expect a reply within the next two business days.', '2025-04-06-21:07', 1, 0),
(297, 'vmsroot', 'vmsroot', 'New Community Service Letter Request - Avi Lewers (User ID: tester)', 'A community service letter has been requested by Avi Lewers (User ID: tester).\nView their profile here: ', '2025-04-13-11:38', 1, 0),
(301, 'vmsroot', 'vmsroot', 'New Community Service Letter Request - Avi Lewers (User ID: tester)', 'A community service letter has been requested by Avi Lewers (User ID: tester).\nView their profile here:\r\n                <a href=\'viewProfile.php?id=tester\'></a>', '2025-04-13-11:41', 1, 0),
(303, 'vmsroot', 'vmsroot', 'New Community Service Letter Request - Avi Lewers (User ID: tester)', 'A community service letter has been requested by Avi Lewers (User ID: tester).\nView their profile here:\r\n                <a href=\'viewProfile.php?id=tester\'>link</a>.', '2025-04-13-11:43', 1, 0),
(305, 'vmsroot', 'vmsroot', 'New Community Service Letter Request - Avi Lewers (User ID: tester)', 'A community service letter has been requested by Avi Lewers (User ID: tester).\nView their profile here:\r\n                viewProfile.php?id=tester', '2025-04-13-11:54', 1, 0),
(307, 'vmsroot', 'vmsroot', 'New Community Service Letter Request - Avi Lewers (User ID: tester)', 'A community service letter has been requested by Avi Lewers (User ID: tester).\nView their profile here:\r\n                /viewProfile.php?id=tester', '2025-04-13-11:55', 1, 0),
(310, 'vmsroot', 'tester', 'Community Service Letter Request Successful', 'Hello!\nYou have officially requested a community service letter as of Apr 13, 2025. \r\n    A notice has been sent to staff, and you should expect a reply within the next two business days.', '2025-04-13-12:00', 0, 0),
(311, 'vmsroot', 'vmsroot', 'New Community Service Letter Request - Avi Lewers (User ID: tester)', 'A community service letter has been requested by Avi Lewers (User ID: tester).\nView their profile\r\n                viewProfile.php?id=tester', '2025-04-13-12:02', 1, 0),
(312, 'vmsroot', 'tester', 'Community Service Letter Request Successful', 'Hello!\nYou have officially requested a community service letter as of Apr 13, 2025. \r\n    A notice has been sent to staff, and you should expect a reply within the next two business days.', '2025-04-13-12:02', 0, 0),
(313, 'vmsroot', 'vmsroot', 'New Community Service Letter Request - Solivan Brugmansia (User ID: soly)', 'A community service letter has been requested by Solivan Brugmansia (User ID: soly).\nView their profile\r\n                viewProfile.php?id=soly', '2025-04-13-18:39', 0, 0),
(321, 'vmsroot', 'vmsroot', 'New Community Service Letter Request - Alicia Lewers (User ID: alewers)', 'A community service letter has been requested by Alicia Lewers (User ID: alewers).\nView their profile\r\n                viewProfile.php?id=alewers', '2025-04-20-22:43', 1, 0),
(322, 'vmsroot', 'alewers', 'Community Service Letter Request Successful', 'Hello!\nYou have officially requested a community service letter as of Apr 20, 2025. \r\n    A notice has been sent to staff, and you should expect a reply within the next two business days.', '2025-04-20-22:43', 0, 0),
(323, 'vmsroot', 'vmsroot', 'New Community Service Letter Request - Alicia Lewers (User ID: alewers)', 'A community service letter has been requested by Alicia Lewers (User ID: alewers).\nView their profile\r\n                viewProfile.php?id=alewers', '2025-04-20-22:44', 1, 0),
(324, 'vmsroot', 'alewers', 'Community Service Letter Request Successful', 'Hello!\nYou have officially requested a community service letter as of Apr 20, 2025. \r\n    A notice has been sent to staff, and you should expect a reply within the next two business days.', '2025-04-20-22:44', 0, 0),
(325, 'vmsroot', 'vmsroot', 'New Community Service Letter Request - Charles Wilt (User ID: charles)', 'A community service letter has been requested by Charles Wilt (User ID: charles).\nView their profile\r\n                viewProfile.php?id=charles', '2025-04-24-13:28', 1, 0),
(326, 'vmsroot', 'charles', 'Community Service Letter Request Successful', 'Hello!\nYou have officially requested a community service letter as of Apr 24, 2025. \r\n    A notice has been sent to staff, and you should expect a reply within the next two business days.', '2025-04-24-13:28', 0, 0),
(327, 'vmsroot', 'vmsroot', 'New Community Service Letter Request - Abby Griffin (User ID: AbbyGriff)', 'A community service letter has been requested by Abby Griffin (User ID: AbbyGriff).\nView their profile\r\n                viewProfile.php?id=AbbyGriff', '2025-04-24-16:48', 1, 0),
(328, 'vmsroot', 'AbbyGriff', 'Community Service Letter Request Successful', 'Hello!\nYou have officially requested a community service letter as of Apr 24, 2025. \r\n    A notice has been sent to staff, and you should expect a reply within the next two business days.', '2025-04-24-16:48', 0, 0),
(329, 'vmsroot', 'vmsroot', 'New Community Service Letter Request - Abby Griffin (User ID: AbbyGriff)', 'A community service letter has been requested by Abby Griffin (User ID: AbbyGriff).\nView their profile\r\n                viewProfile.php?id=AbbyGriff', '2025-04-24-16:54', 1, 0),
(330, 'vmsroot', 'AbbyGriff', 'Community Service Letter Request Successful', 'Hello!\nYou have officially requested a community service letter as of Apr 24, 2025. \r\n    A notice has been sent to staff, and you should expect a reply within the next two business days.', '2025-04-24-16:54', 0, 0),
(331, 'vmsroot', 'vmsroot', 'New Community Service Letter Request - Abby Griffin (User ID: AbbyGriff)', 'A community service letter has been requested by Abby Griffin (User ID: AbbyGriff).\nView their profile\r\n                viewProfile.php?id=AbbyGriff', '2025-04-24-16:54', 1, 0),
(332, 'vmsroot', 'AbbyGriff', 'Community Service Letter Request Successful', 'Hello!\nYou have officially requested a community service letter as of Apr 24, 2025. \r\n    A notice has been sent to staff, and you should expect a reply within the next two business days.', '2025-04-24-16:54', 0, 0),
(333, 'vmsroot', 'vmsroot', 'New Community Service Letter Request - Emma Brennan (User ID: ebrenna2)', 'A community service letter has been requested by Emma Brennan (User ID: ebrenna2).\nView their profile\r\n                viewProfile.php?id=ebrenna2', '2025-04-25-23:14', 1, 0),
(334, 'vmsroot', 'ebrenna2', 'Community Service Letter Request Successful', 'Hello!\nYou have officially requested a community service letter as of Apr 25, 2025. \r\n    A notice has been sent to staff, and you should expect a reply within the next two business days.', '2025-04-25-23:14', 0, 0),
(335, 'vmsroot', 'vmsroot', 'New Community Service Letter Request - Teresa Hall (User ID: Thall1)', 'A community service letter has been requested by Teresa Hall (User ID: Thall1).\nView their profile\r\n                viewProfile.php?id=Thall1', '2025-04-27-18:19', 1, 0),
(336, 'vmsroot', 'Thall1', 'Community Service Letter Request Successful', 'Hello!\nYou have officially requested a community service letter as of Apr 27, 2025. \r\n    A notice has been sent to staff, and you should expect a reply within the next two business days.', '2025-04-27-18:19', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `dbpersonhours`
--

CREATE TABLE `dbpersonhours` (
  `personID` varchar(256) NOT NULL,
  `date` date NOT NULL,
  `Time_in` time NOT NULL DEFAULT current_timestamp(),
  `Time_out` time DEFAULT NULL,
  `Total_hours` decimal(65,0) GENERATED ALWAYS AS (timestampdiff(SECOND,`Time_in`,`Time_out`) / 3600) STORED,
  `STT` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dbpersonhours`
--

INSERT INTO `dbpersonhours` (`personID`, `date`, `Time_in`, `Time_out`, `STT`) VALUES
('aaa', '2025-03-30', '10:29:33', '17:30:11', 0),
('aaa', '2025-03-30', '12:57:38', '17:30:11', 0),
('aaa', '2025-03-30', '16:54:04', '17:30:11', 0),
('aaa', '2025-03-30', '17:08:44', '17:30:11', 0),
('aaa', '2025-03-30', '17:08:46', '17:30:11', 0),
('aaa', '2025-03-30', '17:19:30', '17:30:11', 0),
('aaa', '2025-03-30', '17:21:23', '17:30:11', 0),
('aaa', '2025-04-01', '10:00:00', '04:01:00', 0),
('aaa', '2025-04-01', '15:03:57', '20:12:40', 0),
('aaa', '2025-04-20', '10:22:00', '22:22:00', 0),
('aaa', '2025-04-21', '08:00:00', '10:00:00', 0),
('Abby Floyd', '2025-01-06', '09:43:31', '13:43:31', 0),
('AbbyGriff', '2025-02-01', '08:18:21', '13:18:21', 1),
('AbbyGriff', '2025-02-05', '09:00:00', '12:00:00', 0),
('AbbyGriff', '2025-03-24', '07:55:26', '08:00:00', 0),
('AbbyGriff', '2025-03-30', '10:08:33', '17:34:16', 0),
('AbbyGriff', '2025-03-30', '10:15:26', '17:34:16', 0),
('AbbyGriff', '2025-03-30', '17:27:48', '17:34:16', 0),
('AbbyGriff', '2025-03-30', '17:27:50', '17:34:16', 0),
('AbbyGriff', '2025-03-30', '17:27:51', '17:34:16', 0),
('AbbyGriff', '2025-03-30', '17:31:57', '17:34:16', 0),
('AbbyGriff', '2025-03-30', '17:34:12', '17:34:16', 0),
('AbbyGriff', '2025-03-30', '17:34:14', '17:34:16', 0),
('AbbyGriff', '2025-03-30', '17:34:15', '17:34:16', 0),
('addison_fiore', '2025-01-15', '09:00:00', '13:43:31', 0),
('addison_fiore', '2025-01-20', '09:00:00', '13:43:31', 0),
('addison_fiore', '2025-04-07', '09:30:56', '09:30:58', 0),
('alewers', '2025-04-07', '08:00:00', '12:00:00', 0),
('Amwages13', '2024-12-09', '09:00:00', '13:49:12', 0),
('Amwages13', '2024-12-12', '09:00:00', '13:49:12', 0),
('Amwages13', '2025-02-19', '09:00:00', '13:00:00', 0),
('Amwages13', '2025-02-27', '10:20:29', '16:20:29', 1),
('brianna@gmail.com', '2025-03-30', '17:22:18', '17:22:20', 0),
('charles', '2025-04-01', '10:00:00', '12:00:00', 0),
('charles', '2025-04-20', '04:20:00', '16:20:00', 0),
('soly', '2025-04-13', '04:37:53', '18:37:59', 0),
('soly', '2025-04-14', '09:41:13', '09:41:19', 0),
('thimble', '2025-04-20', '04:20:00', '16:20:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `dbpersons`
--

CREATE TABLE `dbpersons` (
  `id` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` text NOT NULL,
  `last_name` text DEFAULT NULL,
  `minor` tinyint(1) NOT NULL,
  `total_hours` int(11) NOT NULL,
  `mandated_hours` int(11) NOT NULL,
  `remaining_mandated_hours` int(11) NOT NULL,
  `checked_in` tinyint(1) NOT NULL,
  `phone1` varchar(12) NOT NULL,
  `email` text DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `type` text DEFAULT NULL,
  `password` text DEFAULT NULL,
  `street_address` text DEFAULT NULL,
  `city` text DEFAULT NULL,
  `state` varchar(2) DEFAULT NULL,
  `zip_code` text DEFAULT NULL,
  `emergency_contact_first_name` text NOT NULL,
  `emergency_contact_last_name` text NOT NULL,
  `emergency_contact_phone` varchar(12) DEFAULT NULL,
  `emergency_contact_relation` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `dbpersons`
--

INSERT INTO `dbpersons` (`id`, `first_name`, `last_name`, `minor`, `total_hours`, `mandated_hours`, `remaining_mandated_hours`, `checked_in`, `phone1`, `email`, `notes`, `type`, `password`, `street_address`, `city`, `state`, `zip_code`, `emergency_contact_first_name`, `emergency_contact_last_name`, `emergency_contact_phone`, `emergency_contact_relation`) VALUES
('aaa', 'aaa', 'aaa', 0, 26, 0, 0, 0, '1231231233', 'a@a.a', 'n/a', 'volunteer', '$2y$10$5s8HaYX98.3Wlsr7hpiVH.UGtxt0YqSGCrcWFsV5McmiN9wjUZNBu', 'a', 'a', 'VA', '33333', 'a', 'a', '2342342344', 'a'),
('Abby Floyd', 'Abigail', 'Floyd', 0, 0, 0, 0, 0, '5403226396', 'amfloyd14@icloud.com', 'n/a', 'v', '$2y$10$OreonRBUiYTXffapXDSzN.lt04IVsOrOiQ27UsT1XBZj5IctrXetG', '5425 Rainwood Dr', 'Fredericksburg', 'VA', '22407', 'Melissa', 'Floyd', '5404290350', 'Mother'),
('AbbyGriff', 'Abby', 'Griffin', 0, 22, 40, 18, 0, '5406612606', 'abigailfgriff@gmail.com', 'n/a', 'volunteer', '$2y$10$c901gH6WuN9DgxmwodzOKeOgpdu87OlTTXEvj2/Ejt/SIIZpSc9si', '5417, Holley Oak Lane', 'Fredericksburg', 'VA', '22407', 'Pam', 'Griffin', '5408348825', 'Mother'),
('addison_fiore', 'Addison', 'Fiore', 0, 10, 0, 0, 0, '5403720591', 'addisonfiore8@gmail.com', 'n/a', 'volunteer', '$2y$10$0QK4ippSoaT/e2VZ3NaG7OcqFJDps2uFz22.1NjJ.iuD7sbuyLUYW', '10804 Cinnamon Teal Drive', 'Spotsylvania', 'VA', '22553', 'Jennifer', 'Fiore', '5409031781', 'Mother'),
('alewers', 'Alicia', 'Lewers', 0, 4, 30, 26, 0, '1234567890', 'bnuuy@gmail.com', 'n/a', 'v', '', '123 Hops St', 'Burning', 'TN', '12345', 'Bunny', 'Hops', '0987654321', 'Friend'),
('Amwages13', 'Lexi', 'Wages', 0, 0, 0, 0, 0, '5403599086', 'leximariewages@gmail.com', 'n/a', 'volunteer', '$2y$10$PD0TAmsArH3AF79GeiPKuu/t3b2KwoKnixcU2OvDqA/6IjMxEsra.', '3 Rodeo Ct', 'Fredericksburg', 'VA', '22407', 'Laurie', 'Wages', '5402875446', 'Mother'),
('ascrivani3', 'Amelia', 'Scrivani', 0, 0, 0, 0, 0, '7185141845', 'ascrivani3@gmail.com', 'n/a', 'volunteer', '$2y$10$RfIm4IswPvtW656I6h2cR.czd4uCKldaSsKB5zCiw8642lfimAFj.', '12565 Spotswood Furnace Rd', 'Fredericksburg', 'VA', '22407', 'Michele', 'Scrivani', '7183546470', 'Mother'),
('brianna@gmail.com', 'Brianna', 'Wahl', 0, 0, 0, 0, 0, '1234567890', 'brianna@gmail.com', '', 'admin', '$2y$10$jNbMmZwq.1r/5/oy61IRkOSX4PY6sxpYEdWfu9tLRZA6m1NgsxD6m', '212 Latham Road', 'Mineola', 'VA', '11501', 'Mom', '', '', 'Mother'),
('charles', 'Charles', 'Wilt', 0, 14, 100, 86, 0, '1231231234', 'charles@gmail.com', 'n/a', 'volunteer', '$2y$10$BhurBvyEs9hTa7sIeZEqHeuE0aAXSGX/CcwMw7y/4dHt0ztL1MjMO', 'Street Address', 'Fredericksburg', 'VA', '22405', 'Michael', 'Wilt', '1231231234', 'Father'),
('christitowle', 'Christi', 'Towle', 0, 0, 0, 0, 0, '8044415060', 'towlefamily@yahoo.com', 'n/a', 'volunteer', '$2y$10$QKAHn4eKKL8qgF2gDGjNiektJolio9YlhMByUyLXE.GfJVSygOAli', '201 New Hope Church Road', 'Fredericksburg', 'VA', '22405', 'Jason', 'Towle', '8044415060', 'Spouse'),
('dbohn', 'Dylan', 'Bohn', 0, 0, 0, 0, 0, '6666666666', 'bobbarker@aol.com', 'n/a', 'v', '', '123 Sesame Street', 'Fredericksburg', 'VA', '12345', 'Easter', 'Bunny', '5555555555', 'Friend'),
('ebrenna2', 'Emma', 'Brennan', 0, 0, 0, 0, 0, '7035099647', 'em.brenn@yahoo.com', 'n/a', 'volunteer', '$2y$10$3hIpyIl79iyRTb.edM.uEuV8aT9t5v4juO3vXmpcIYULPokjpftKK', '212 Willis St', 'Fredericksburg', 'VA', '22401', 'Laura', 'Brennan', '7032965189', 'Mother'),
('fredastaire', 'Fred', 'Astaire', 0, 0, 0, 0, 0, '1234567890', 'fredastaire@myemail.com', 'n/a', 'v', '$2y$10$VUZObvA3Cy69ykkohegJYevjJU3DFlZbgmfTSPzee7TMPRSMMg9fG', '11 Dance Avenue', 'Stafford', 'VA', '12345', 'Fred Jr.', 'Astaire', '2222222221', 'Son'),
('jake_demo', 'Jake', 'Furman', 0, 0, 0, 0, 0, '5555555555', 'jake@gmail.com', 'n/a', 'volunteer', '$2y$10$UNhNSABqTedXO.fWLy7eduhDVsdNp9GbkdnkR05oyjZnYPe9XjExu', '1234 Street', 'Fredericksburg', 'VA', '10001', 'Mom', 'Furman', '4444444444', 'Mom'),
('lucy', 'Lucy', 'Pevensie', 0, 0, 0, 0, 0, '1234567890', 'lucy@narnia.com', 'n/a', 'volunteer', '$2y$10$VQ5Za13gNAn/DoAJzwG.j.zMhL1YBjOpsJclMJqfSF1XKxMp2eS9S', '10 London Avenue', 'Stafford', 'VA', '12345', 'Peter', 'Pevensie', '0987654321', 'Brother'),
('mom@gmail.com', 'Lorraine', 'Egan', 0, 0, 0, 0, 0, '5167423832', 'mom@gmail.com', '', 'admin', '$2y$10$of1CkoNXZwyhAMS5GQ.aYuAW1SHptF6z31ONahnF2qK4Y/W9Ty2h2', '212 Latham Road', 'Mineola', 'NY', '11501', 'Mom', '', '', 'Dead'),
('morgan', 'Morgan', 'Harper', 0, 0, 0, 0, 0, '5555555555', 'morgan@gmail.com', 'n/a', 'v', '$2y$10$klnM0EjO78i3ifPFMU3YQe6YXq14W3RpmSUsP1.IP0f6wVE6ExYoe', '123 Street', 'Fredericksburg', 'VA', '10001', 'Christine', 'Harper', '5555555555', 'Mom'),
('oliver@gmail.com', 'Oliver', 'Wahl', 0, 0, 0, 0, 0, '1234567890', 'oliver@gmail.com', '', 'admin', '$2y$10$tgIjMkXhPzdmgGhUgbfPRuXLJVZHLiC0pWQQwOYKx8p8H8XY3eHw6', '1345 Strattford St.', 'Fredericksburg', 'VA', '22401', 'Mom', '', '', 'Mother'),
('peter@gmail.com', 'Peter', 'Polack', 0, 0, 0, 0, 0, '1234567890', 'peter@gmail.com', '', 'admin', '$2y$10$j5xJ6GWaBhnb45aktS.kruk05u./TsAhEoCI3VRlNs0SRGrIqz.B6', '1345 Strattford St.', 'Mineola', 'VA', '12345', 'Mom', '', '', 'Mom'),
('polack@um.edu', 'Jennifer', 'Polack', 0, 0, 0, 0, 0, '1234567890', 'polack@um.edu', '', 'admin', '$2y$10$mp18j4WqhlQo7MTeS/9kt.i08n7nbt0YMuRoAxtAy52BlinqPUE4C', '15 Wallace Farms Lane', 'Fredericksburg', 'VA', '22406', 'Mom', '', '', 'Mom'),
('polack@umw.edu', 'Jennifer', 'ADMIN', 0, 0, 0, 0, 0, '5402959700', 'polack@umw.edu', 'n/a', 'volunteer', '$2y$10$CxMpQDWPyURnla9pb8FvveQSRrMBU7.zAB.ZbdHwK1P/suPuwcy0O', '15 Wallace Farms Lane', 'Fredericksburg', 'VA', '22406', 'Jennifer', 'Polack', '5402959700', 'Me'),
('SaraDowd', 'Sara', 'Dowd', 0, 0, 0, 0, 0, '8582549611', 'sarazonadowd@gmail.com', 'n/a', 'volunteer', '$2y$10$BQ4n2HGpgxfaFnBf0HexveU8I0ppdINNXvhZdynQyOiaitOnP6dw6', '11 Barlow House Court', 'Stafford', 'VA', '22554', 'Daniel', 'Dowd', '8582548568', 'Spouse'),
('soly', 'Solivan', 'Brugmansia', 0, 14, 10, 0, 0, '1231231234', 'obscureref@gmail.com', 'n/a', 'v', '', '123 Itch IO', 'Itch.IO', 'AL', '12345', 'Y', 'N', '1231231234', 'Yes'),
('stepvainc@gmail.com', 'Jan', 'Monroe', 0, 0, 0, 0, 0, '7575351963', 'stepvainc@gmail.com', 'n/a', 'volunteer', '$2y$10$mOC.B5elQp8HZhdkNhR/V.jjNBwcsTzQdjG14Aia1jP.8XkNSWj0u', '12419 Toll House Rd.', 'SPOTSYLVANIA', 'VA', '22551', 'Mike', 'Monroe', '7575351967', 'spouse'),
('StrawberryJade', 'Jade', 'Sergi', 0, 0, 0, 0, 0, '5406994590', 'jtsergi42@gmail.com', 'n/a', 'volunteer', '$2y$10$Q3bVGR6B6E4Ibz7k9vryMO5mFJvtkLO418iADpEonhKdt7vzb5R22', '2449 Harpoon Drive', 'Stafford', 'VA', '22554', 'Carol', 'Yeh', '3014120327', 'Mother'),
('test', 'Harry', 'Potter', 0, 0, 0, 0, 0, '1231231234', 'test@gmail.com', 'n/a', 'v', '$2y$10$3qNoA1RwCbO9/1eHev.T0OCdhfBwaS9cmzGVFdCD4CFqmyEPjgkbm', '123 Apple St.', 'Fredericksburg', 'VA', '22003', 'Ron', 'Weasley', '4324324321', 'Friend'),
('testuser', 'Jane', 'Doe', 0, 0, 0, 0, 0, '5555555555', 'test@mail.com', 'n/a', 'v', '$2y$10$kfaLBXEYKBmdzaO6x7KtBuQeXu5o8Wof2MaR5vwJ44aoqPwMsgkIa', '123 Main Street', 'Fredericksburg', 'VA', '22401', 'Ron', 'Swanson', '6666666666', 'Friend'),
('Thall1', 'Teresa', 'Hall', 0, 0, 0, 0, 0, '5405977489', 'tlomeara3@gmail.com', 'n/a', 'volunteer', '$2y$10$.Er980h41trC1NRObt4U5.S8YKbORWhwC2.44tHoLLBnmSmMa8hKK', '119 Garfield Avenue', 'Colonial Beach', 'VA', '22443', 'Tim', 'Hall', '5407608128', 'Spouse'),
('thimble', 'Thimble', 'Joe', 0, 12, 0, 0, 0, '1112223344', 'star@gmail.co', 'n/a', 'admin', 'Thimble11', '111 e st', 'tall', 'TN', '11122', 'Thumb', 'Tack', '1113335557', 'Mom'),
('tom@gmail.com', 'tom', 'tom', 0, 0, 0, 0, 0, '1234567890', 'tom@gmail.com', '', 'admin', '$2y$10$1Zcj7n/prdkNxZjxTK1zUOF7391byZvsXkJcN8S8aZL57sz/OfxP.', '1345 Strattford St.', 'Mineola', 'NY', '12345', 'Dad', '', '', 'Father'),
('usernameusername', 'Noah', 'Stafford', 0, 0, 0, 0, 0, '1231231234', 'email@gmail.com', 'n/a', 'volunteer', '$2y$10$uGbO0uD4CFwN0ewoqGG8T.9PT.1F8pOBSJVOKXkvNSlRSjAANMhOK', 'My address', 'City', 'VA', '22405', 'Contact', 'Lastname', '1231231234', 'Mom'),
('vmsroot', 'vmsroot', '', 0, 0, 0, 0, 0, '', 'vmsroot', 'N/A', '', '$2y$10$.3p8xvmUqmxNztEzMJQRBesLDwdiRU3xnt/HOcJtsglwsbUk88VTO', 'N/A', 'N/A', 'VA', 'N/A', 'N/A', '', 'N/A', 'N/A');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dblog`
--
ALTER TABLE `dblog`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dbmessages`
--
ALTER TABLE `dbmessages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dbpersonhours`
--
ALTER TABLE `dbpersonhours`
  ADD PRIMARY KEY (`personID`,`date`,`Time_in`);

--
-- Indexes for table `dbpersons`
--
ALTER TABLE `dbpersons`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dbmessages`
--
ALTER TABLE `dbmessages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=337;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `dbpersonhours`
--
ALTER TABLE `dbpersonhours`
  ADD CONSTRAINT `FkpersonID2` FOREIGN KEY (`personID`) REFERENCES `dbpersons` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
