-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 25, 2026 at 08:37 AM
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
-- Database: `coret2_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `audit_trail`
--

CREATE TABLE `audit_trail` (
  `audit_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `action_type` varchar(100) DEFAULT NULL,
  `module_name` varchar(100) DEFAULT NULL,
  `record_id` int(11) DEFAULT NULL,
  `action_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `ip_address` varchar(45) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `compliance_status` varchar(50) DEFAULT 'Compliant',
  `review_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `audit_trail`
--

INSERT INTO `audit_trail` (`audit_id`, `user_id`, `action_type`, `module_name`, `record_id`, `action_time`, `ip_address`, `remarks`, `compliance_status`, `review_date`) VALUES
(1, 1, 'Create', 'Members', NULL, '2025-10-22 07:05:27', NULL, 'Added new member John Doe', 'Compliant', '2025-10-20 10:00:00'),
(2, 1, 'Update', 'Loans', NULL, '2025-10-22 07:05:27', NULL, 'Reviewed loan application #102', 'Non-Compliant', '2025-10-21 09:30:00'),
(3, 1, 'Review', 'Compliance', NULL, '2025-10-22 07:05:27', NULL, 'Started compliance audit', 'Pending', '2025-10-22 08:45:00'),
(4, 1, 'Edit', 'Savings', NULL, '2025-10-22 07:05:27', NULL, 'Updated savings record for ID 5', 'Non-Compliant', '2025-10-22 11:15:00'),
(5, 1, 'Verify', 'Disbursement', NULL, '2025-10-22 07:05:27', NULL, 'Approved disbursement ₱15,000', 'Compliant', '2025-10-22 14:00:00'),
(6, 5, 'Logout', 'Authentication', NULL, '2025-10-22 07:05:51', '::1', 'User Fernando M. Gonzales Jr. logged out.', 'Compliant', '2025-10-22 15:05:51'),
(7, 5, 'Login Failed - Wrong Password', 'Authentication', NULL, '2025-10-22 07:06:02', '::1', 'Incorrect password', 'Compliant', '2025-10-22 15:06:02'),
(8, 5, 'Login', 'Authentication', NULL, '2025-10-22 07:06:10', '::1', 'User logged in successfully', 'Compliant', '2025-10-22 15:06:10'),
(9, 1, 'Access Denied', 'Compliance & Audit Trail', NULL, '2026-01-16 17:19:15', '::1', 'User \'Unknown\' tried to view Compliance & Audit Trail without permission.', 'Compliant', NULL),
(10, 1, 'Access Denied', 'Compliance & Audit Trail', NULL, '2026-01-16 17:19:21', '::1', 'User \'Unknown\' tried to view Compliance & Audit Trail without permission.', 'Compliant', NULL),
(11, 1, 'Logout', 'Authentication', NULL, '2026-01-16 17:19:45', '::1', 'User Compliance Auditor logged out.', 'Compliant', '2026-01-17 01:19:45'),
(12, 7, 'Login Failed - Wrong Password', 'Authentication', NULL, '2026-01-16 17:19:53', '::1', 'Incorrect password', 'Compliant', '2026-01-17 01:19:53'),
(13, 5, 'Login Failed - Wrong Password', 'Authentication', NULL, '2026-01-16 17:20:00', '::1', 'Incorrect password', 'Compliant', '2026-01-17 01:20:00'),
(14, 6, 'Login Failed - Wrong Password', 'Authentication', NULL, '2026-01-16 17:20:10', '::1', 'Incorrect password', 'Compliant', '2026-01-17 01:20:10'),
(15, 6, 'Login Failed - Wrong Password', 'Authentication', NULL, '2026-01-16 17:20:20', '::1', 'Incorrect password', 'Compliant', '2026-01-17 01:20:20'),
(16, 5, 'Login Failed - Wrong Password', 'Authentication', NULL, '2026-01-16 17:20:54', '::1', 'Incorrect password', 'Compliant', '2026-01-17 01:20:54'),
(17, 5, 'Login Failed - Wrong Password', 'Authentication', NULL, '2026-01-16 17:21:00', '::1', 'Incorrect password', 'Compliant', '2026-01-17 01:21:00'),
(18, 1, 'Login', 'Authentication', NULL, '2026-01-16 17:21:36', '::1', 'User logged in successfully', 'Compliant', '2026-01-17 01:21:36'),
(19, 1, 'Logout', 'Authentication', NULL, '2026-01-16 17:21:44', '::1', 'User Compliance Auditor logged out.', 'Compliant', '2026-01-17 01:21:44'),
(20, 7, 'Login', 'Authentication', NULL, '2026-01-16 17:21:52', '::1', 'User logged in successfully', 'Compliant', '2026-01-17 01:21:52'),
(21, 7, 'Access Denied', 'Compliance & Audit Trail', NULL, '2026-01-16 17:21:54', '::1', 'User \'Unknown\' tried to view Compliance & Audit Trail without permission.', 'Compliant', NULL),
(22, 7, 'Access Denied', 'Savings Monitoring', NULL, '2026-01-16 17:22:07', '::1', 'User \'Unknown\' tried to view Savings Monitoring without permission.', 'Compliant', NULL),
(23, 7, 'Access Denied', 'Savings Monitoring', NULL, '2026-01-16 17:22:10', '::1', 'User \'Unknown\' tried to view Savings Monitoring without permission.', 'Compliant', NULL),
(24, 7, 'Access Denied', 'Savings Monitoring', NULL, '2026-01-16 17:22:12', '::1', 'User \'Unknown\' tried to view Savings Monitoring without permission.', 'Compliant', NULL),
(25, 7, 'Access Denied', 'Compliance & Audit Trail', NULL, '2026-01-16 17:22:15', '::1', 'User \'Unknown\' tried to view Compliance & Audit Trail without permission.', 'Compliant', NULL),
(26, 7, 'Access Denied', 'Savings Monitoring', NULL, '2026-01-16 17:22:27', '::1', 'User \'Unknown\' tried to view Savings Monitoring without permission.', 'Compliant', NULL),
(27, 7, 'Logout', 'Authentication', NULL, '2026-01-16 17:22:57', '::1', 'User Noby Gonzales logged out.', 'Compliant', '2026-01-17 01:22:57'),
(28, 5, 'Login Failed - Wrong Password', 'Authentication', NULL, '2026-01-16 17:23:04', '::1', 'Incorrect password', 'Compliant', '2026-01-17 01:23:04'),
(29, 5, 'Login Failed - Wrong Password', 'Authentication', NULL, '2026-01-16 17:23:10', '::1', 'Incorrect password', 'Compliant', '2026-01-17 01:23:10'),
(30, 5, 'Login Failed - Wrong Password', 'Authentication', NULL, '2026-01-16 17:23:16', '::1', 'Incorrect password', 'Compliant', '2026-01-17 01:23:16'),
(31, 5, 'Login Failed - Wrong Password', 'Authentication', NULL, '2026-01-16 17:23:27', '::1', 'Incorrect password', 'Compliant', '2026-01-17 01:23:27'),
(32, 5, 'Login Failed - Wrong Password', 'Authentication', NULL, '2026-01-16 17:23:38', '::1', 'Incorrect password', 'Compliant', '2026-01-17 01:23:38'),
(33, 1, 'Login', 'Authentication', NULL, '2026-01-16 17:23:44', '::1', 'User logged in successfully', 'Compliant', '2026-01-17 01:23:44'),
(34, 1, 'Access Denied', 'Compliance & Audit Trail', NULL, '2026-01-16 17:24:25', '::1', 'User \'Unknown\' tried to view Compliance & Audit Trail without permission.', 'Compliant', NULL),
(35, 1, 'Access Denied', 'Compliance & Audit Trail', NULL, '2026-01-16 17:25:47', '::1', 'User \'Unknown\' tried to view Compliance & Audit Trail without permission.', 'Compliant', NULL),
(36, 1, 'Logout', 'Authentication', NULL, '2026-01-16 17:25:52', '::1', 'User Compliance Auditor logged out.', 'Compliant', '2026-01-17 01:25:52'),
(37, 1, 'Login', 'Authentication', NULL, '2026-01-16 17:25:57', '::1', 'User logged in successfully', 'Compliant', '2026-01-17 01:25:57'),
(38, 1, 'Logout', 'Authentication', NULL, '2026-01-16 17:46:19', '::1', 'User Compliance Auditor logged out.', 'Compliant', '2026-01-17 01:46:19'),
(39, 1, 'Login', 'Authentication', NULL, '2026-01-16 17:46:24', '::1', 'User logged in successfully', 'Compliant', '2026-01-17 01:46:24'),
(40, 1, 'Logout', 'Authentication', NULL, '2026-01-16 17:57:58', '::1', 'User Compliance Auditor logged out.', 'Compliant', '2026-01-17 01:57:58'),
(41, 1, 'Login', 'Authentication', NULL, '2026-01-16 17:58:03', '::1', 'User logged in successfully', 'Compliant', '2026-01-17 01:58:03'),
(42, 1, 'Access Denied', 'Compliance & Audit Trail', NULL, '2026-01-16 17:58:06', '::1', 'User \'Unknown\' tried to view Compliance & Audit Trail without permission.', 'Compliant', NULL),
(43, 1, 'Access Denied', 'Savings Monitoring', NULL, '2026-01-16 17:58:09', '::1', 'User \'Unknown\' tried to view Savings Monitoring without permission.', 'Compliant', NULL),
(44, 1, 'Access Denied', 'Permission Logs', NULL, '2026-01-16 17:58:18', '::1', 'User \'Unknown\' tried to view Permission Logs without permission.', 'Compliant', NULL),
(45, 1, 'Access Denied', 'Permission Logs', NULL, '2026-01-16 17:59:32', '::1', 'User \'Unknown\' tried to view Permission Logs without permission.', 'Compliant', NULL),
(46, 1, 'Access Denied', 'Compliance & Audit Trail', NULL, '2026-01-16 18:00:57', '::1', 'User \'Unknown\' tried to view Compliance & Audit Trail without permission.', 'Compliant', NULL),
(47, 1, 'Access Denied', 'Compliance & Audit Trail', NULL, '2026-01-16 18:03:50', '::1', 'User \'Unknown\' tried to view Compliance & Audit Trail without permission.', 'Compliant', NULL),
(48, 1, 'Access Denied', 'Permission Logs', NULL, '2026-01-16 18:03:53', '::1', 'User \'Unknown\' tried to view Permission Logs without permission.', 'Compliant', NULL),
(49, 1, 'Logout', 'Authentication', NULL, '2026-01-16 18:06:31', '::1', 'User Compliance Auditor logged out.', 'Compliant', '2026-01-17 02:06:31'),
(50, 1, 'Login', 'Authentication', NULL, '2026-01-16 18:06:36', '::1', 'User logged in successfully', 'Compliant', '2026-01-17 02:06:36'),
(51, 1, 'Logout', 'Authentication', NULL, '2026-01-16 18:08:01', '::1', 'User Compliance Auditor logged out.', 'Compliant', '2026-01-17 02:08:01'),
(52, 1, 'Login', 'Authentication', NULL, '2026-01-16 18:08:10', '::1', 'User logged in successfully', 'Compliant', '2026-01-17 02:08:10'),
(53, 1, 'Logout', 'Authentication', NULL, '2026-01-16 18:28:34', '::1', 'User Fernando Jr. logged out.', 'Compliant', '2026-01-17 02:28:34'),
(54, 5, 'Login Failed - Wrong Password', 'Authentication', NULL, '2026-01-17 09:53:14', '::1', 'Incorrect password', 'Compliant', '2026-01-17 17:53:14'),
(55, 1, 'Login', 'Authentication', NULL, '2026-01-17 09:53:18', '::1', 'User logged in successfully', 'Compliant', '2026-01-17 17:53:18'),
(56, 1, 'Logout', 'Authentication', NULL, '2026-01-17 10:07:35', '::1', 'User Fernando Jr. logged out.', 'Compliant', '2026-01-17 18:07:35'),
(57, 6, 'Login Failed - Wrong Password', 'Authentication', NULL, '2026-01-17 10:07:40', '::1', 'Incorrect password', 'Compliant', '2026-01-17 18:07:40'),
(58, 6, 'Login Failed - Wrong Password', 'Authentication', NULL, '2026-01-17 10:07:48', '::1', 'Incorrect password', 'Compliant', '2026-01-17 18:07:48'),
(59, 1, 'Login', 'Authentication', NULL, '2026-01-17 10:12:03', '::1', 'User logged in successfully', 'Compliant', '2026-01-17 18:12:03'),
(60, 1, 'Login', 'Authentication', NULL, '2026-01-18 03:18:35', '::1', 'User logged in successfully', 'Compliant', '2026-01-18 11:18:35'),
(61, 1, 'Logout', 'Authentication', NULL, '2026-01-18 03:18:56', '::1', 'User Fernando Jr. logged out.', 'Compliant', '2026-01-18 11:18:56'),
(62, 1, 'Login', 'Authentication', NULL, '2026-01-18 03:51:12', '::1', 'User logged in successfully', 'Compliant', '2026-01-18 11:51:12'),
(63, 1, 'Logout', 'Authentication', NULL, '2026-01-18 03:57:56', '::1', 'User Fernando Jr. logged out.', 'Compliant', '2026-01-18 11:57:56'),
(64, 1, 'Login', 'Authentication', NULL, '2026-01-18 03:59:00', '::1', 'User logged in successfully', 'Compliant', '2026-01-18 11:59:00'),
(65, 1, 'Logout', 'Authentication', NULL, '2026-01-18 06:46:17', '::1', 'User Fernando Jr. logged out.', 'Compliant', '2026-01-18 14:46:17'),
(66, 5, 'Login', 'Authentication', NULL, '2026-01-18 06:46:26', '::1', 'User logged in successfully', 'Compliant', '2026-01-18 14:46:26'),
(67, 5, 'Access Denied', 'Compliance & Audit Trail', NULL, '2026-01-18 06:54:22', '::1', 'User \'Unknown\' tried to view Compliance & Audit Trail without permission.', 'Compliant', NULL),
(68, 5, 'Access Denied', 'Compliance & Audit Trail', NULL, '2026-01-18 06:54:25', '::1', 'User \'Unknown\' tried to view Compliance & Audit Trail without permission.', 'Compliant', NULL),
(69, 5, 'Access Denied', 'Compliance & Audit Trail', NULL, '2026-01-18 06:54:51', '::1', 'User \'Unknown\' tried to view Compliance & Audit Trail without permission.', 'Compliant', NULL),
(70, 5, 'Access Denied', 'Compliance & Audit Trail', NULL, '2026-01-18 06:56:05', '::1', 'User \'Unknown\' tried to view Compliance & Audit Trail without permission.', 'Compliant', NULL),
(71, 5, 'Access Denied', 'Savings Monitoring', NULL, '2026-01-18 06:57:09', '::1', 'User \'Unknown\' tried to view Savings Monitoring without permission.', 'Compliant', NULL),
(72, 5, 'Access Denied', 'Compliance & Audit Trail', NULL, '2026-01-18 06:57:50', '::1', 'User \'Unknown\' tried to view Compliance & Audit Trail without permission.', 'Compliant', NULL),
(73, 5, 'Logout', 'Authentication', NULL, '2026-01-18 06:58:45', '::1', 'User Fernando M. Gonzales Jr. logged out.', 'Compliant', '2026-01-18 14:58:45'),
(74, 1, 'Login', 'Authentication', NULL, '2026-01-18 06:58:56', '::1', 'User logged in successfully', 'Compliant', '2026-01-18 14:58:56'),
(75, 1, 'Logout', 'Authentication', NULL, '2026-01-18 07:02:36', '::1', 'User Fernando Jr. logged out.', 'Compliant', '2026-01-18 15:02:36'),
(76, 6, 'Login Failed - Inactive', 'Authentication', NULL, '2026-01-18 07:02:49', '::1', 'Inactive user tried login', 'Compliant', '2026-01-18 15:02:49'),
(77, 1, 'Login', 'Authentication', NULL, '2026-01-18 07:02:58', '::1', 'User logged in successfully', 'Compliant', '2026-01-18 15:02:58'),
(78, 1, 'Login', 'Authentication', NULL, '2026-01-18 10:53:57', '::1', 'User logged in successfully', 'Compliant', '2026-01-18 18:53:57'),
(79, 1, 'Logout', 'Authentication', NULL, '2026-01-18 11:02:15', '::1', 'User Fernando Jr. logged out.', 'Compliant', '2026-01-18 19:02:15'),
(80, 6, 'Login', 'Authentication', NULL, '2026-01-18 11:02:40', '::1', 'User logged in successfully', 'Compliant', '2026-01-18 19:02:40'),
(81, 6, 'Access Denied', 'Compliance & Audit Trail', NULL, '2026-01-18 11:03:39', '::1', 'User \'Unknown\' tried to view Compliance & Audit Trail without permission.', 'Compliant', NULL),
(82, 6, 'Access Denied', 'Compliance & Audit Trail', NULL, '2026-01-18 11:03:44', '::1', 'User \'Unknown\' tried to view Compliance & Audit Trail without permission.', 'Compliant', NULL),
(83, 6, 'Access Denied', 'Compliance & Audit Trail', NULL, '2026-01-18 11:05:42', '::1', 'User \'Unknown\' tried to view Compliance & Audit Trail without permission.', 'Compliant', NULL),
(84, 6, 'Access Denied', 'Savings Monitoring', NULL, '2026-01-18 11:06:04', '::1', 'User \'Unknown\' tried to view Savings Monitoring without permission.', 'Compliant', NULL),
(85, 6, 'Access Denied', 'Savings Monitoring', NULL, '2026-01-18 11:07:32', '::1', 'User \'Unknown\' tried to view Savings Monitoring without permission.', 'Compliant', NULL),
(86, 6, 'Access Denied', 'Compliance & Audit Trail', NULL, '2026-01-18 11:07:34', '::1', 'User \'Unknown\' tried to view Compliance & Audit Trail without permission.', 'Compliant', NULL),
(87, 6, 'Logout', 'Authentication', NULL, '2026-01-18 11:09:07', '::1', 'User Noby logged out.', 'Compliant', '2026-01-18 19:09:07'),
(90, 1, 'Login', 'Authentication', NULL, '2026-01-18 11:10:23', '::1', 'User logged in successfully', 'Compliant', '2026-01-18 19:10:23'),
(91, 1, 'Login', 'Authentication', NULL, '2026-01-18 11:10:23', '::1', 'User logged in successfully', 'Compliant', '2026-01-18 19:10:23'),
(92, 1, 'Logout', 'Authentication', NULL, '2026-01-18 11:35:17', '::1', 'User Fernando Jr. logged out.', 'Compliant', '2026-01-18 19:35:17'),
(93, 1, 'Login', 'Authentication', NULL, '2026-01-18 11:37:12', '::1', 'User logged in successfully', 'Compliant', '2026-01-18 19:37:12'),
(94, 1, 'Logout', 'Authentication', NULL, '2026-01-18 11:55:41', '::1', 'User Fernando Jr. logged out.', 'Compliant', '2026-01-18 19:55:41'),
(95, 1, 'Login Failed - Wrong Password', 'Authentication', NULL, '2026-01-19 17:18:44', '::1', 'Incorrect password', 'Compliant', '2026-01-20 01:18:44'),
(96, 1, 'Login', 'Authentication', NULL, '2026-01-19 17:18:54', '::1', 'User logged in successfully', 'Compliant', '2026-01-20 01:18:54'),
(97, 1, 'Logout', 'Authentication', NULL, '2026-01-19 17:19:45', '::1', 'User Fernando Jr. logged out.', 'Compliant', '2026-01-20 01:19:45'),
(98, 1, 'Login', 'Authentication', NULL, '2026-01-19 17:19:50', '::1', 'User logged in successfully', 'Compliant', '2026-01-20 01:19:50'),
(99, 1, 'Logout', 'Authentication', NULL, '2026-01-19 17:20:07', '::1', 'User Fernando Jr. logged out.', 'Compliant', '2026-01-20 01:20:07'),
(103, 1, 'Login Failed - Wrong Password', 'Authentication', NULL, '2026-01-19 17:20:57', '::1', 'Incorrect password', 'Compliant', '2026-01-20 01:20:57'),
(104, 1, 'Login', 'Authentication', NULL, '2026-01-19 17:21:03', '::1', 'User logged in successfully', 'Compliant', '2026-01-20 01:21:03'),
(105, 1, 'Logout', 'Authentication', NULL, '2026-01-19 17:40:56', '::1', 'User Fernando Jr. logged out.', 'Compliant', '2026-01-20 01:40:56'),
(106, 1, 'Login', 'Authentication', NULL, '2026-01-19 17:41:21', '::1', 'User logged in successfully', 'Compliant', '2026-01-20 01:41:21'),
(107, 1, 'Logout', 'Authentication', NULL, '2026-01-19 17:42:52', '::1', 'User Fernando Jr. logged out.', 'Compliant', '2026-01-20 01:42:52'),
(108, 1, 'Login Failed - Wrong Password', 'Authentication', NULL, '2026-01-19 17:52:28', '::1', 'Incorrect password', 'Compliant', '2026-01-20 01:52:28'),
(109, 1, 'Login', 'Authentication', NULL, '2026-01-19 17:52:35', '::1', 'User logged in successfully', 'Compliant', '2026-01-20 01:52:35'),
(110, 1, 'Logout', 'Authentication', NULL, '2026-01-19 18:27:45', '::1', 'User Fernando Jr. logged out.', 'Compliant', '2026-01-20 02:27:45'),
(111, 1, 'Login Failed - Wrong Password', 'Authentication', NULL, '2026-01-19 18:35:22', '::1', 'Incorrect password', 'Compliant', '2026-01-20 02:35:22'),
(112, 1, 'Login', 'Authentication', NULL, '2026-01-19 18:35:28', '::1', 'User logged in successfully', 'Compliant', '2026-01-20 02:35:28'),
(113, 1, 'Logout', 'Authentication', NULL, '2026-01-19 18:35:56', '::1', 'User Fernando Jr. logged out.', 'Compliant', '2026-01-20 02:35:56'),
(114, 1, 'Login', 'Authentication', NULL, '2026-01-19 18:38:36', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-20 02:38:36'),
(115, 1, 'Logout', 'Authentication', NULL, '2026-01-19 18:40:18', '::1', 'User Fernando Jr. logged out.', 'Compliant', '2026-01-20 02:40:18'),
(116, 1, 'Login', 'Authentication', NULL, '2026-01-19 18:41:08', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-20 02:41:08'),
(117, 1, 'Logout', 'Authentication', NULL, '2026-01-19 18:42:39', '::1', 'User Fernando Jr. logged out from IP: ::1', 'Compliant', '2026-01-20 02:42:39'),
(118, 1, 'Login Failed - Wrong Password', 'Authentication', NULL, '2026-01-19 18:42:44', '::1', 'Incorrect password', 'Compliant', '2026-01-20 02:42:44'),
(119, 1, 'Login', 'Authentication', NULL, '2026-01-19 18:42:50', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-20 02:42:50'),
(120, 1, 'Login', 'Authentication', NULL, '2026-01-19 18:45:47', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-20 02:45:47'),
(121, 1, 'Logout', 'Authentication', NULL, '2026-01-19 18:52:39', '::1', 'User Fernando Jr. logged out from IP: ::1', 'Compliant', '2026-01-20 02:52:39'),
(122, 1, 'Login', 'Authentication', NULL, '2026-01-19 18:52:43', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-20 02:52:43'),
(123, 1, 'Login', 'Authentication', NULL, '2026-01-19 18:55:49', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-20 02:55:49'),
(124, 1, 'Login', 'Authentication', NULL, '2026-01-19 18:58:15', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-20 02:58:15'),
(125, 1, 'Login', 'Authentication', NULL, '2026-01-19 19:02:44', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-20 03:02:44'),
(126, 1, 'Login', 'Authentication', NULL, '2026-01-19 19:07:25', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-20 03:07:25'),
(127, 1, 'Login', 'Authentication', NULL, '2026-01-19 19:10:03', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-20 03:10:03'),
(128, 1, 'Login', 'Authentication', NULL, '2026-01-19 19:22:18', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-20 03:22:18'),
(129, 1, 'Login', 'Authentication', NULL, '2026-01-19 19:28:48', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-20 03:28:48'),
(130, 1, 'Login', 'Authentication', NULL, '2026-01-19 19:31:23', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-20 03:31:23'),
(131, 1, 'Login', 'Authentication', NULL, '2026-01-19 19:39:48', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-20 03:39:48'),
(132, 1, 'Login', 'Authentication', NULL, '2026-01-19 19:44:04', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-20 03:44:04'),
(133, 1, 'Login', 'Authentication', NULL, '2026-01-19 19:47:21', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-20 03:47:21'),
(134, 1, 'Login', 'Authentication', NULL, '2026-01-19 19:55:22', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-20 03:55:22'),
(135, 1, 'Login', 'Authentication', NULL, '2026-01-19 20:06:47', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-20 04:06:47'),
(136, 6, 'Login', 'Authentication', NULL, '2026-01-19 20:19:36', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-20 04:19:36'),
(137, 6, 'Access Denied', 'Compliance & Audit Trail', NULL, '2026-01-19 20:19:47', '::1', 'User \'Unknown\' tried to view Compliance & Audit Trail without permission.', 'Compliant', NULL),
(138, 6, 'Access Denied', 'Compliance & Audit Trail', NULL, '2026-01-19 20:19:53', '::1', 'User \'Unknown\' tried to view Compliance & Audit Trail without permission.', 'Compliant', NULL),
(139, 6, 'Access Denied', 'Savings Monitoring', NULL, '2026-01-19 20:20:11', '::1', 'User \'Unknown\' tried to view Savings Monitoring without permission.', 'Compliant', NULL),
(140, 6, 'Access Denied', 'Savings Monitoring', NULL, '2026-01-19 20:20:15', '::1', 'User \'Unknown\' tried to view Savings Monitoring without permission.', 'Compliant', NULL),
(141, 6, 'Access Denied', 'Savings Monitoring', NULL, '2026-01-19 20:20:37', '::1', 'User \'Unknown\' tried to view Savings Monitoring without permission.', 'Compliant', NULL),
(142, 6, 'Access Denied', 'Compliance & Audit Trail', NULL, '2026-01-19 20:20:52', '::1', 'User \'Unknown\' tried to view Compliance & Audit Trail without permission.', 'Compliant', NULL),
(143, 6, 'Access Denied', 'Savings Monitoring', NULL, '2026-01-19 20:21:21', '::1', 'User \'Unknown\' tried to view Savings Monitoring without permission.', 'Compliant', NULL),
(144, 6, 'Access Denied', 'Savings Monitoring', NULL, '2026-01-19 20:22:09', '::1', 'User \'Unknown\' tried to view Savings Monitoring without permission.', 'Compliant', NULL),
(145, 6, 'Access Denied', 'Savings Monitoring', NULL, '2026-01-19 20:22:11', '::1', 'User \'Unknown\' tried to view Savings Monitoring without permission.', 'Compliant', NULL),
(146, 6, 'Access Denied', 'Disbursement Tracker', NULL, '2026-01-19 20:23:34', '::1', 'User \'Unknown\' tried to view Disbursement Tracker without permission.', 'Compliant', NULL),
(147, 6, 'Access Denied', 'Disbursement Tracker', NULL, '2026-01-19 20:23:36', '::1', 'User \'Unknown\' tried to view Disbursement Tracker without permission.', 'Compliant', NULL),
(148, 6, 'Access Denied', 'Disbursement Tracker', NULL, '2026-01-19 20:23:38', '::1', 'User \'Unknown\' tried to view Disbursement Tracker without permission.', 'Compliant', NULL),
(149, 6, 'Access Denied', 'Savings Monitoring', NULL, '2026-01-19 20:23:40', '::1', 'User \'Unknown\' tried to view Savings Monitoring without permission.', 'Compliant', NULL),
(150, 6, 'Access Denied', 'Disbursement Tracker', NULL, '2026-01-19 20:23:42', '::1', 'User \'Unknown\' tried to view Disbursement Tracker without permission.', 'Compliant', NULL),
(151, 6, 'Access Denied', 'Disbursement Tracker', NULL, '2026-01-19 20:24:56', '::1', 'User \'Unknown\' tried to view Disbursement Tracker without permission.', 'Compliant', NULL),
(152, 6, 'Access Denied', 'Savings Monitoring', NULL, '2026-01-19 20:24:58', '::1', 'User \'Unknown\' tried to view Savings Monitoring without permission.', 'Compliant', NULL),
(153, 6, 'Access Denied', 'Disbursement Tracker', NULL, '2026-01-19 20:25:02', '::1', 'User \'Unknown\' tried to view Disbursement Tracker without permission.', 'Compliant', NULL),
(154, 6, 'Access Denied', 'Disbursement Tracker', NULL, '2026-01-19 20:25:37', '::1', 'User \'Unknown\' tried to view Disbursement Tracker without permission.', 'Compliant', NULL),
(155, 6, 'Access Denied', 'Savings Monitoring', NULL, '2026-01-19 20:25:39', '::1', 'User \'Unknown\' tried to view Savings Monitoring without permission.', 'Compliant', NULL),
(156, 6, 'Access Denied', 'Savings Monitoring', NULL, '2026-01-19 20:25:42', '::1', 'User \'Unknown\' tried to view Savings Monitoring without permission.', 'Compliant', NULL),
(157, 1, 'Login Failed - Wrong Password', 'Authentication', NULL, '2026-01-19 20:28:23', '::1', 'Incorrect password', 'Compliant', '2026-01-20 04:28:23'),
(158, 6, 'Login', 'Authentication', NULL, '2026-01-19 20:28:34', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-20 04:28:34'),
(159, 6, 'Access Denied', 'Disbursement Tracker', NULL, '2026-01-19 20:28:35', '::1', 'User \'Unknown\' tried to view Disbursement Tracker without permission.', 'Compliant', NULL),
(160, 6, 'Access Denied', 'Savings Monitoring', NULL, '2026-01-19 20:29:02', '::1', 'User \'Unknown\' tried to view Savings Monitoring without permission.', 'Compliant', NULL),
(161, 6, 'Access Denied', 'Savings Monitoring', NULL, '2026-01-19 20:29:31', '::1', 'User \'Unknown\' tried to view Savings Monitoring without permission.', 'Compliant', NULL),
(162, 6, 'Access Denied', 'Disbursement Tracker', NULL, '2026-01-19 20:29:37', '::1', 'User \'Unknown\' tried to view Disbursement Tracker without permission.', 'Compliant', NULL),
(163, 6, 'Access Denied', 'Savings Monitoring', NULL, '2026-01-19 20:29:41', '::1', 'User \'Unknown\' tried to view Savings Monitoring without permission.', 'Compliant', NULL),
(164, 6, 'Logout', 'Authentication', NULL, '2026-01-19 20:30:00', '::1', 'User Noby logged out from IP: ::1', 'Compliant', '2026-01-20 04:30:00'),
(165, 1, 'Login', 'Authentication', NULL, '2026-01-19 20:30:05', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-20 04:30:05'),
(166, 1, 'Login', 'Authentication', NULL, '2026-01-19 20:40:30', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-20 04:40:30'),
(167, 1, 'Login', 'Authentication', NULL, '2026-01-19 20:45:27', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-20 04:45:27'),
(168, 1, 'Login', 'Authentication', NULL, '2026-01-19 20:56:58', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-20 04:56:58'),
(169, 1, 'Login', 'Authentication', NULL, '2026-01-19 21:02:09', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-20 05:02:09'),
(170, 1, 'Login', 'Authentication', NULL, '2026-01-20 17:52:28', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-21 01:52:27'),
(171, 1, 'Login Failed - Wrong Password', 'Authentication', NULL, '2026-01-20 18:00:01', '::1', 'Incorrect password', 'Compliant', '2026-01-21 02:00:01'),
(172, 1, 'Login', 'Authentication', NULL, '2026-01-20 18:00:08', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-21 02:00:08'),
(173, 1, 'Login', 'Authentication', NULL, '2026-01-20 18:03:14', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-21 02:03:14'),
(174, 1, 'Login Failed - Wrong Password', 'Authentication', NULL, '2026-01-20 18:10:59', '::1', 'Incorrect password', 'Compliant', '2026-01-21 02:10:59'),
(175, 1, 'Login Failed - Wrong Password', 'Authentication', NULL, '2026-01-20 18:18:35', '::1', 'Incorrect password', 'Compliant', '2026-01-21 02:18:35'),
(176, 1, 'Login', 'Authentication', NULL, '2026-01-20 18:18:41', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-21 02:18:41'),
(177, 1, 'Login', 'Authentication', NULL, '2026-01-20 18:33:35', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-21 02:33:35'),
(178, 1, 'Auto Logout (Inactivity)', 'Authentication', NULL, '2026-01-20 18:35:55', '::1', 'User Fernando Jr. logged out from IP: ::1', 'Compliant', '2026-01-21 02:35:55'),
(179, 1, 'Login', 'Authentication', NULL, '2026-01-20 18:36:12', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-21 02:36:12'),
(180, 1, 'Login', 'Authentication', NULL, '2026-01-20 18:40:44', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-21 02:40:44'),
(181, 1, 'Manual Logout', 'Authentication', NULL, '2026-01-20 18:43:08', '::1', 'User Fernando Jr. logged out from IP: ::1', 'Compliant', '2026-01-21 02:43:08'),
(182, 1, 'Login', 'Authentication', NULL, '2026-01-20 18:43:15', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-21 02:43:15'),
(183, 1, 'Login', 'Authentication', NULL, '2026-01-20 18:46:30', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-21 02:46:30'),
(184, 1, 'Login', 'Authentication', NULL, '2026-01-20 19:03:33', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-21 03:03:33'),
(185, 1, 'Login', 'Authentication', NULL, '2026-01-20 19:08:01', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-21 03:08:01'),
(186, 1, 'Login', 'Authentication', NULL, '2026-01-21 11:33:21', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-21 19:33:21'),
(187, 1, 'Manual Logout', 'Authentication', NULL, '2026-01-21 11:37:47', '::1', 'User Fernando Jr. logged out from IP: ::1', 'Compliant', '2026-01-21 19:37:47'),
(188, 1, 'Login', 'Authentication', NULL, '2026-01-22 13:50:22', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-22 21:50:22'),
(189, 1, 'Login', 'Authentication', NULL, '2026-01-22 14:18:38', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-22 22:18:38'),
(190, 1, 'Login', 'Authentication', NULL, '2026-01-22 14:24:52', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-22 22:24:52'),
(191, 1, 'Login', 'Authentication', NULL, '2026-01-22 14:30:00', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-22 22:30:00'),
(192, 1, 'Login', 'Authentication', NULL, '2026-01-22 15:06:02', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-22 23:06:02'),
(193, 1, 'Login', 'Authentication', NULL, '2026-01-22 15:11:46', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-22 23:11:46'),
(194, 1, 'Login', 'Authentication', NULL, '2026-01-22 15:25:01', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-22 23:25:01'),
(195, 1, 'Login Failed - Wrong Password', 'Authentication', NULL, '2026-01-24 09:19:34', '::1', 'Incorrect password', 'Compliant', '2026-01-24 17:19:34'),
(198, 1, 'Login', 'Authentication', NULL, '2026-01-24 09:19:59', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-24 17:19:59'),
(199, 1, 'Login', 'Authentication', NULL, '2026-01-24 09:34:02', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-24 17:34:02'),
(200, 1, 'Login', 'Authentication', NULL, '2026-01-24 09:36:39', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-24 17:36:39'),
(201, 1, 'Login', 'Authentication', NULL, '2026-01-24 09:41:02', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-24 17:41:02'),
(202, 1, 'Login', 'Authentication', NULL, '2026-01-24 09:50:38', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-24 17:50:38'),
(203, 1, 'Login', 'Authentication', NULL, '2026-01-24 10:06:08', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-24 18:06:08'),
(204, 1, 'Login', 'Authentication', NULL, '2026-01-24 10:09:34', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-24 18:09:34'),
(205, 1, 'Login', 'Authentication', NULL, '2026-01-24 10:13:28', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-24 18:13:28'),
(206, 1, 'Login', 'Authentication', NULL, '2026-01-24 10:15:50', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-24 18:15:50'),
(207, 1, 'Login', 'Authentication', NULL, '2026-01-24 10:21:32', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-24 18:21:32'),
(208, 1, 'Manual Logout', 'Authentication', NULL, '2026-01-24 10:24:48', '::1', 'User Fernando Jr. logged out from IP: ::1', 'Compliant', '2026-01-24 18:24:48'),
(209, 1, 'Login', 'Authentication', NULL, '2026-01-24 10:31:58', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-24 18:31:58'),
(210, 1, 'Login', 'Authentication', NULL, '2026-01-24 10:34:42', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-24 18:34:42'),
(211, 1, 'Login', 'Authentication', NULL, '2026-01-24 10:45:58', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-24 18:45:58'),
(212, 1, 'Login', 'Authentication', NULL, '2026-01-24 10:57:15', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-24 18:57:15'),
(213, 1, 'Login', 'Authentication', NULL, '2026-01-24 11:09:20', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-24 19:09:20'),
(214, 1, 'Login', 'Authentication', NULL, '2026-01-24 11:20:31', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-24 19:20:31'),
(215, 1, 'Login', 'Authentication', NULL, '2026-01-24 11:24:10', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-24 19:24:10'),
(216, 1, 'Login', 'Authentication', NULL, '2026-01-24 11:34:01', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-24 19:34:01'),
(217, 1, 'Login', 'Authentication', NULL, '2026-01-24 11:43:40', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-24 19:43:40'),
(218, 1, 'Login', 'Authentication', NULL, '2026-01-24 11:50:34', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-24 19:50:34'),
(219, 1, 'Login', 'Authentication', NULL, '2026-01-24 11:57:22', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-24 19:57:22'),
(220, 1, 'Manual Logout', 'Authentication', NULL, '2026-01-24 11:57:45', '::1', 'User Fernando Jr. logged out from IP: ::1', 'Compliant', '2026-01-24 19:57:45'),
(221, 1, 'Login', 'Authentication', NULL, '2026-01-24 14:37:50', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-24 22:37:50'),
(222, 1, 'Login', 'Authentication', NULL, '2026-01-24 14:43:23', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-24 22:43:23'),
(223, 1, 'Login', 'Authentication', NULL, '2026-01-24 14:47:10', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-24 22:47:10'),
(224, 1, 'Login', 'Authentication', NULL, '2026-01-24 14:50:12', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-24 22:50:12'),
(225, 1, 'Login', 'Authentication', NULL, '2026-01-24 14:55:25', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-24 22:55:25'),
(226, 1, 'Login', 'Authentication', NULL, '2026-01-24 15:01:48', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-24 23:01:48'),
(227, 1, 'Login', 'Authentication', NULL, '2026-01-24 15:05:43', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-24 23:05:43'),
(228, 1, 'Login', 'Authentication', NULL, '2026-01-24 15:13:27', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-24 23:13:27'),
(229, 1, 'Login', 'Authentication', NULL, '2026-01-24 15:26:54', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-24 23:26:54'),
(230, 1, 'Login', 'Authentication', NULL, '2026-01-24 15:33:13', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-24 23:33:13'),
(231, 1, 'Login', 'Authentication', NULL, '2026-01-24 15:40:40', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-24 23:40:40'),
(232, 1, 'Login', 'Authentication', NULL, '2026-01-24 15:44:26', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-24 23:44:26'),
(233, 1, 'Login', 'Authentication', NULL, '2026-01-24 15:48:56', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-24 23:48:56'),
(234, 1, 'Login', 'Authentication', NULL, '2026-01-24 15:52:13', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-24 23:52:13'),
(235, 1, 'Login', 'Authentication', NULL, '2026-01-24 16:01:19', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-25 00:01:19'),
(236, 1, 'Login', 'Authentication', NULL, '2026-01-24 16:02:10', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-25 00:02:10'),
(237, 1, 'Login', 'Authentication', NULL, '2026-01-24 16:09:25', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-25 00:09:25'),
(238, 1, 'Login', 'Authentication', NULL, '2026-01-24 16:14:38', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-25 00:14:38'),
(239, 1, 'Login', 'Authentication', NULL, '2026-01-24 16:17:49', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-25 00:17:49'),
(240, 1, 'Login', 'Authentication', NULL, '2026-01-24 16:32:04', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-25 00:32:04'),
(241, 1, 'Login', 'Authentication', NULL, '2026-01-24 16:50:01', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-25 00:50:01'),
(242, 1, 'Manual Logout', 'Authentication', NULL, '2026-01-24 16:56:44', '::1', 'User Fernando Jr. logged out from IP: ::1', 'Compliant', '2026-01-25 00:56:44'),
(243, 6, 'Login', 'Authentication', NULL, '2026-01-24 16:56:55', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-25 00:56:55'),
(244, 6, 'Access Denied', 'Savings Monitoring', NULL, '2026-01-24 16:57:12', '::1', 'User \'Unknown\' tried to view Savings Monitoring without permission.', 'Compliant', NULL),
(245, 6, 'Access Denied', 'Savings Monitoring', NULL, '2026-01-24 16:57:18', '::1', 'User \'Unknown\' tried to view Savings Monitoring without permission.', 'Compliant', NULL),
(246, 6, 'Access Denied', 'Savings Monitoring', NULL, '2026-01-24 16:57:22', '::1', 'User \'Unknown\' tried to view Savings Monitoring without permission.', 'Compliant', NULL),
(247, 6, 'Manual Logout', 'Authentication', NULL, '2026-01-24 16:57:26', '::1', 'User Noby logged out from IP: ::1', 'Compliant', '2026-01-25 00:57:26'),
(248, 1, 'Login', 'Authentication', NULL, '2026-01-24 16:57:43', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-25 00:57:43'),
(249, 1, 'Manual Logout', 'Authentication', NULL, '2026-01-24 16:58:25', '::1', 'User Fernando Jr. logged out from IP: ::1', 'Compliant', '2026-01-25 00:58:25'),
(250, 1, 'Login', 'Authentication', NULL, '2026-01-24 19:09:24', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-25 03:09:24'),
(251, 1, 'Manual Logout', 'Authentication', NULL, '2026-01-24 19:12:07', '::1', 'User Fernando Jr. logged out from IP: ::1', 'Compliant', '2026-01-25 03:12:07'),
(252, 1, 'Login', 'Authentication', NULL, '2026-01-24 19:51:41', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-25 03:51:41'),
(253, 1, 'Login', 'Authentication', NULL, '2026-01-24 20:04:40', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-25 04:04:40'),
(254, 1, 'Login', 'Authentication', NULL, '2026-01-24 20:11:29', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-25 04:11:29'),
(255, 1, 'Login', 'Authentication', NULL, '2026-01-24 20:24:17', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-25 04:24:17'),
(256, 1, 'Login', 'Authentication', NULL, '2026-01-24 20:28:23', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-25 04:28:23'),
(257, 1, 'Login Success', 'Authentication', NULL, '2026-01-24 20:33:55', '::1', '✅ User \'Fernando Jr.\' logged in successfully from IP: ::1 🎉', 'Compliant', '2026-01-25 04:33:55'),
(258, 1, 'Logout', 'Authentication', NULL, '2026-01-24 20:37:08', '::1', '👋 User \'Fernando Jr.\' logged out successfully after 00:03:13 session time. Have a great day! 🌟', 'Compliant', '2026-01-25 04:37:08'),
(259, 1, 'Login', 'Authentication', NULL, '2026-01-24 20:38:21', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-25 04:38:21'),
(260, 1, 'Login', 'Authentication', NULL, '2026-01-24 20:43:32', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-25 04:43:32'),
(261, 1, 'Login', 'Authentication', NULL, '2026-01-24 20:46:20', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-25 04:46:20'),
(262, 1, 'Login', 'Authentication', NULL, '2026-01-24 20:51:22', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-25 04:51:22'),
(263, 1, 'Manual Logout', 'Authentication', NULL, '2026-01-24 20:51:40', '::1', 'User Fernando Jr. logged out from IP: ::1', 'Compliant', '2026-01-25 04:51:40'),
(264, 1, 'Login', 'Authentication', NULL, '2026-01-24 20:51:46', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-25 04:51:46'),
(265, 1, 'Login Failed - Wrong Password', 'Authentication', NULL, '2026-01-24 20:55:32', '::1', 'Incorrect password', 'Compliant', '2026-01-25 04:55:32'),
(266, 1, 'Login', 'Authentication', NULL, '2026-01-24 20:55:39', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-25 04:55:39'),
(267, 1, 'Manual Logout', 'Authentication', NULL, '2026-01-24 20:55:46', '::1', 'User Fernando Jr. logged out from IP: ::1', 'Compliant', '2026-01-25 04:55:46'),
(270, 1, 'Login Failed - Wrong Password', 'Authentication', NULL, '2026-01-24 20:56:16', '::1', 'Incorrect password', 'Compliant', '2026-01-25 04:56:16'),
(271, 1, 'Login', 'Authentication', NULL, '2026-01-24 20:56:21', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-25 04:56:21'),
(272, 1, 'Manual Logout', 'Authentication', NULL, '2026-01-24 20:56:29', '::1', 'User Fernando Jr. logged out from IP: ::1', 'Compliant', '2026-01-25 04:56:29'),
(274, 1, 'Login', 'Authentication', NULL, '2026-01-25 03:54:50', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-25 11:54:50'),
(275, 1, 'Login', 'Authentication', NULL, '2026-01-25 03:57:40', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-25 11:57:40'),
(276, 1, 'Login', 'Authentication', NULL, '2026-01-25 04:01:14', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-25 12:01:14'),
(277, 1, 'Login', 'Authentication', NULL, '2026-01-25 04:04:12', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-25 12:04:12'),
(278, 1, 'Login', 'Authentication', NULL, '2026-01-25 04:10:33', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-25 12:10:33'),
(279, 1, 'Login', 'Authentication', NULL, '2026-01-25 04:15:32', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-25 12:15:32'),
(280, 1, 'Login', 'Authentication', NULL, '2026-01-25 04:26:17', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-25 12:26:17'),
(281, 1, 'Login', 'Authentication', NULL, '2026-01-25 04:35:21', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-25 12:35:21'),
(282, 1, 'Login', 'Authentication', NULL, '2026-01-25 04:42:49', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-25 12:42:49'),
(283, 1, 'Login', 'Authentication', NULL, '2026-01-25 04:49:27', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-25 12:49:27'),
(284, 1, 'Manual Logout', 'Authentication', NULL, '2026-01-25 04:50:48', '::1', 'User Fernando Jr. logged out from IP: ::1', 'Compliant', '2026-01-25 12:50:48'),
(285, 5, 'Login', 'Authentication', NULL, '2026-01-25 04:50:52', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-25 12:50:52'),
(286, 5, 'Access Denied', 'Savings Monitoring', NULL, '2026-01-25 04:50:57', '::1', 'User \'Unknown\' tried to view Savings Monitoring without permission.', 'Compliant', NULL),
(287, 5, 'Manual Logout', 'Authentication', NULL, '2026-01-25 04:51:12', '::1', 'User Fernando M. Gonzales Jr. logged out from IP: ::1', 'Compliant', '2026-01-25 12:51:12'),
(288, 1, 'Login', 'Authentication', NULL, '2026-01-25 04:51:25', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-25 12:51:25'),
(289, 1, 'Manual Logout', 'Authentication', NULL, '2026-01-25 04:54:25', '::1', 'User Fernando Jr. logged out from IP: ::1', 'Compliant', '2026-01-25 12:54:25'),
(292, 6, 'Login Failed - Inactive', 'Authentication', NULL, '2026-01-25 04:54:47', '::1', 'Inactive user tried login', 'Compliant', '2026-01-25 12:54:47'),
(293, 6, 'Login Failed - Inactive', 'Authentication', NULL, '2026-01-25 04:54:57', '::1', 'Inactive user tried login', 'Compliant', '2026-01-25 12:54:57'),
(294, 1, 'Login', 'Authentication', NULL, '2026-01-25 04:55:03', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-25 12:55:03'),
(295, 1, 'Manual Logout', 'Authentication', NULL, '2026-01-25 04:55:23', '::1', 'User Fernando Jr. logged out from IP: ::1', 'Compliant', '2026-01-25 12:55:23'),
(296, 6, 'Login Failed - Inactive', 'Authentication', NULL, '2026-01-25 04:55:28', '::1', 'Inactive user tried login', 'Compliant', '2026-01-25 12:55:28'),
(297, 1, 'Login', 'Authentication', NULL, '2026-01-25 04:55:36', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-25 12:55:36'),
(298, 1, 'Login', 'Authentication', NULL, '2026-01-25 05:09:02', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-25 13:09:02'),
(299, 1, 'Edit', 'Role Permissions', NULL, '2026-01-25 05:11:41', '::1', 'Updated permission for module: Compliance & Audit Trail', 'Compliant', NULL),
(300, 1, 'Edit', 'Role Permissions', NULL, '2026-01-25 05:11:45', '::1', 'Updated permission for module: Compliance & Audit Trail', 'Compliant', NULL),
(301, 1, 'Login', 'Authentication', NULL, '2026-01-25 05:27:29', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-25 13:27:29'),
(302, 1, 'Login', 'Authentication', NULL, '2026-01-25 05:30:52', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-25 13:30:52'),
(303, 1, 'Login Failed - Wrong Password', 'Authentication', NULL, '2026-01-25 05:34:15', '::1', 'Incorrect password', 'Compliant', '2026-01-25 13:34:15'),
(304, 1, 'Login', 'Authentication', NULL, '2026-01-25 05:34:21', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-25 13:34:21'),
(305, 1, 'Login', 'Authentication', NULL, '2026-01-25 05:54:00', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-25 13:54:00'),
(306, 1, 'Login', 'Authentication', NULL, '2026-01-25 06:00:53', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-25 14:00:53'),
(307, 1, 'Login', 'Authentication', NULL, '2026-01-25 06:06:36', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-25 14:06:36'),
(308, 1, 'Login Failed - Wrong Password', 'Authentication', NULL, '2026-01-25 06:33:01', '::1', 'Incorrect password', 'Compliant', '2026-01-25 14:33:01'),
(310, NULL, 'Login Failed - Unknown User', 'Authentication', NULL, '2026-01-25 06:34:54', '::1', 'Unknown username: 123', 'Compliant', '2026-01-25 14:34:54'),
(311, NULL, 'Login Failed - Unknown User', 'Authentication', NULL, '2026-01-25 06:34:58', '::1', 'Unknown username: 13223', 'Compliant', '2026-01-25 14:34:58'),
(312, 1, 'Login Failed - Wrong Password', 'Authentication', NULL, '2026-01-25 06:35:02', '::1', 'Incorrect password', 'Compliant', '2026-01-25 14:35:02'),
(313, NULL, 'Login Failed - Unknown User', 'Authentication', NULL, '2026-01-25 06:35:33', '::1', 'Unknown username: 123123', 'Compliant', '2026-01-25 14:35:33'),
(314, 1, 'Login', 'Authentication', NULL, '2026-01-25 06:35:41', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-25 14:35:41'),
(315, 1, 'Manual Logout', 'Authentication', NULL, '2026-01-25 06:36:57', '::1', 'User Fernando Jr. logged out from IP: ::1', 'Compliant', '2026-01-25 14:36:57'),
(316, 1, 'Login Failed - Wrong Password', 'Authentication', NULL, '2026-01-25 06:37:02', '::1', 'Incorrect password', 'Compliant', '2026-01-25 14:37:02'),
(317, NULL, 'Login Failed - Unknown User', 'Authentication', NULL, '2026-01-25 06:37:05', '::1', 'Unknown username: 123', 'Compliant', '2026-01-25 14:37:05'),
(318, NULL, 'Login Failed - Unknown User', 'Authentication', NULL, '2026-01-25 06:37:12', '::1', 'Unknown username: 123', 'Compliant', '2026-01-25 14:37:12'),
(319, 1, 'Login', 'Authentication', NULL, '2026-01-25 06:37:16', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-25 14:37:16'),
(320, 1, 'Login', 'Authentication', NULL, '2026-01-25 06:47:44', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-25 14:47:44'),
(321, 1, 'Manual Logout', 'Authentication', NULL, '2026-01-25 06:48:04', '::1', 'User Fernando Jr. logged out from IP: ::1', 'Compliant', '2026-01-25 14:48:04'),
(322, 6, 'Login', 'Authentication', NULL, '2026-01-25 06:48:17', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-25 14:48:17'),
(323, 6, 'Access Denied', 'Savings Monitoring', NULL, '2026-01-25 06:48:55', '::1', 'User \'Unknown\' tried to view Savings Monitoring without permission.', 'Compliant', NULL),
(324, 6, 'Access Denied', 'Savings Monitoring', NULL, '2026-01-25 06:50:06', '::1', 'User \'Unknown\' tried to view Savings Monitoring without permission.', 'Compliant', NULL),
(325, 1, 'Login', 'Authentication', NULL, '2026-01-25 06:56:32', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-25 14:56:32'),
(326, 1, 'Manual Logout', 'Authentication', NULL, '2026-01-25 06:57:21', '::1', 'User Fernando Jr. logged out from IP: ::1', 'Compliant', '2026-01-25 14:57:21'),
(327, 5, 'Login', 'Authentication', NULL, '2026-01-25 06:57:27', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-25 14:57:27'),
(328, 5, 'Access Denied', 'Savings Monitoring', NULL, '2026-01-25 06:58:25', '::1', 'User \'Unknown\' tried to view Savings Monitoring without permission.', 'Compliant', NULL),
(329, 5, 'Manual Logout', 'Authentication', NULL, '2026-01-25 06:58:29', '::1', 'User Fernando M. Gonzales Jr. logged out from IP: ::1', 'Compliant', '2026-01-25 14:58:29'),
(330, 6, 'Login', 'Authentication', NULL, '2026-01-25 06:58:35', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-25 14:58:35'),
(331, 6, 'Access Denied', 'Savings Monitoring', NULL, '2026-01-25 06:58:47', '::1', 'User \'Unknown\' tried to view Savings Monitoring without permission.', 'Compliant', NULL),
(332, 6, 'Access Denied', 'Savings Monitoring', NULL, '2026-01-25 07:00:09', '::1', 'User \'Unknown\' tried to view Savings Monitoring without permission.', 'Compliant', NULL),
(333, 6, 'Access Denied', 'Savings Monitoring', NULL, '2026-01-25 07:00:29', '::1', 'User \'Unknown\' tried to view Savings Monitoring without permission.', 'Compliant', NULL);
INSERT INTO `audit_trail` (`audit_id`, `user_id`, `action_type`, `module_name`, `record_id`, `action_time`, `ip_address`, `remarks`, `compliance_status`, `review_date`) VALUES
(334, 6, 'Login Failed - Wrong Password', 'Authentication', NULL, '2026-01-25 07:02:48', '::1', 'Incorrect password', 'Compliant', '2026-01-25 15:02:48'),
(335, 6, 'Login', 'Authentication', NULL, '2026-01-25 07:02:54', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-25 15:02:54'),
(336, 6, 'Access Denied', 'Savings Monitoring', NULL, '2026-01-25 07:03:07', '::1', 'User \'Unknown\' tried to view Savings Monitoring without permission.', 'Compliant', NULL),
(337, 6, 'Access Denied', 'Savings Monitoring', NULL, '2026-01-25 07:03:14', '::1', 'User \'Unknown\' tried to view Savings Monitoring without permission.', 'Compliant', NULL),
(338, 6, 'Manual Logout', 'Authentication', NULL, '2026-01-25 07:06:08', '::1', 'User Noby logged out from IP: ::1', 'Compliant', '2026-01-25 15:06:08'),
(339, 5, 'Login', 'Authentication', NULL, '2026-01-25 07:06:14', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-25 15:06:14'),
(340, 5, 'Access Denied', 'Savings Monitoring', NULL, '2026-01-25 07:06:25', '::1', 'User \'Unknown\' tried to view Savings Monitoring without permission.', 'Compliant', NULL),
(341, 5, 'Access Denied', 'Savings Monitoring', NULL, '2026-01-25 07:06:27', '::1', 'User \'Unknown\' tried to view Savings Monitoring without permission.', 'Compliant', NULL),
(342, 5, 'Access Denied', 'Savings Monitoring', NULL, '2026-01-25 07:06:29', '::1', 'User \'Unknown\' tried to view Savings Monitoring without permission.', 'Compliant', NULL),
(343, 5, 'Access Denied', 'Savings Monitoring', NULL, '2026-01-25 07:06:36', '::1', 'User \'Unknown\' tried to view Savings Monitoring without permission.', 'Compliant', NULL),
(344, 5, 'Access Denied', 'Savings Monitoring', NULL, '2026-01-25 07:06:38', '::1', 'User \'Unknown\' tried to view Savings Monitoring without permission.', 'Compliant', NULL),
(345, 1, 'Login', 'Authentication', NULL, '2026-01-25 07:10:07', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-25 15:10:07'),
(346, 1, 'Login', 'Authentication', NULL, '2026-01-25 07:16:43', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-25 15:16:43'),
(347, 1, 'Login', 'Authentication', NULL, '2026-01-25 07:21:38', '::1', 'User logged in successfully from IP: ::1', 'Compliant', '2026-01-25 15:21:38');

-- --------------------------------------------------------

--
-- Table structure for table `collections`
--

CREATE TABLE `collections` (
  `collection_id` int(11) NOT NULL,
  `loan_id` int(11) DEFAULT NULL,
  `member_id` int(11) NOT NULL,
  `collection_date` date NOT NULL,
  `amount_collected` decimal(12,2) NOT NULL,
  `collector_id` int(11) DEFAULT NULL,
  `status` enum('Full','Partial','Missed') DEFAULT 'Full',
  `remarks` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `compliance_logs`
--

CREATE TABLE `compliance_logs` (
  `compliance_id` int(11) NOT NULL,
  `audit_id` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `compliance_status` enum('Compliant','Non-Compliant','Under Review') DEFAULT 'Under Review',
  `review_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `compliance_logs`
--

INSERT INTO `compliance_logs` (`compliance_id`, `audit_id`, `description`, `compliance_status`, `review_date`) VALUES
(26, 1, 'Member KYC documents verified', 'Compliant', '2025-10-20'),
(27, 2, 'Loan contract missing signature', 'Non-Compliant', '2025-10-21'),
(28, 3, 'Pending background verification', '', '2025-10-22'),
(29, 4, 'Savings account update delayed', 'Non-Compliant', '2025-10-22'),
(30, 5, 'Audit trail records matched successfully', 'Compliant', '2025-10-22');

-- --------------------------------------------------------

--
-- Table structure for table `disbursements`
--

CREATE TABLE `disbursements` (
  `disbursement_id` int(11) NOT NULL,
  `loan_id` int(11) DEFAULT NULL,
  `member_id` int(11) DEFAULT NULL,
  `disbursement_date` date DEFAULT NULL,
  `amount` decimal(12,2) DEFAULT 0.00,
  `fund_source` varchar(100) DEFAULT NULL,
  `approved_by` int(11) DEFAULT NULL,
  `status` enum('Pending','Released','Cancelled') DEFAULT 'Pending',
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `disbursements`
--

INSERT INTO `disbursements` (`disbursement_id`, `loan_id`, `member_id`, `disbursement_date`, `amount`, `fund_source`, `approved_by`, `status`, `remarks`, `created_at`) VALUES
(1, 1, 1, '2025-10-20', 5000.00, 'Central Fund', 1, 'Released', 'Initial release', '2025-10-20 11:16:33'),
(2, 2, 2, '2025-10-20', 10000.00, 'External Partner', 5, 'Released', 'Awaiting docs', '2025-10-20 11:16:33'),
(3, 101, 1, '2025-10-01', 5000.00, 'Main Fund', NULL, 'Pending', 'First disbursement', '2025-10-21 18:13:26'),
(4, 102, 2, '2025-10-02', 7500.00, 'Special Fund', 3, 'Released', 'Approved by Manager', '2025-10-21 18:13:26'),
(5, 103, 3, '2025-10-05', 3000.00, 'Main Fund', 1, 'Released', 'Pending approval', '2025-10-21 18:13:26'),
(6, 104, 4, '2025-10-08', 12000.00, 'Emergency Fund', 2, 'Released', 'Loan for equipment', '2025-10-21 18:13:26'),
(7, 105, 5, '2025-10-10', 4500.00, 'Main Fund', 5, 'Released', 'Monthly disbursement', '2025-10-21 18:13:26');

-- --------------------------------------------------------

--
-- Table structure for table `disbursement_logs`
--

CREATE TABLE `disbursement_logs` (
  `log_id` int(11) NOT NULL,
  `disbursement_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `action_type` enum('Request','Approve','Cancel','Status Change') NOT NULL,
  `old_status` enum('Pending','Released','Cancelled') DEFAULT NULL,
  `new_status` enum('Pending','Released','Cancelled') DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `loan_portfolio`
--

CREATE TABLE `loan_portfolio` (
  `loan_id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `loan_type` varchar(50) DEFAULT NULL,
  `principal_amount` decimal(12,2) NOT NULL,
  `interest_rate` decimal(5,2) DEFAULT NULL,
  `loan_term` int(11) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `status` enum('Pending','Approved','Active','Completed','Defaulted') DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `loan_portfolio`
--

INSERT INTO `loan_portfolio` (`loan_id`, `member_id`, `loan_type`, `principal_amount`, `interest_rate`, `loan_term`, `start_date`, `end_date`, `status`) VALUES
(19, 2, 'Personal', 35000.00, 1.50, 12, '2025-10-15', '2026-10-15', 'Defaulted'),
(20, 1, 'Personal', 50000.00, 1.50, 12, '2025-10-15', '2026-10-15', 'Approved'),
(25, 1, 'Personal', 50000.00, 1.80, 12, '2025-10-15', '2026-10-15', 'Approved'),
(26, 1, 'Personal', 50000.00, 1.80, 12, '2025-10-15', '2026-10-15', 'Defaulted'),
(27, 1, 'Personal', 50000.00, 2.80, 12, '2025-10-15', '2026-10-15', 'Defaulted'),
(28, 3, 'Personal', 42000.00, 0.50, 36, '2025-10-18', '2028-10-18', 'Approved'),
(35, 3, 'Education Loan', 30000.00, 4.00, 6, '2025-03-01', '2025-09-01', 'Defaulted'),
(36, 5, 'Emergency Loan', 9000.00, 5.00, 9, '2025-10-22', '2026-07-22', 'Active'),
(37, 5, 'Emergency Loan', 9000.00, 5.00, 9, '2025-10-22', '2026-07-22', 'Active'),
(38, 5, 'Emergency Loan', 9000.00, 5.00, 9, '2025-01-15', '2025-10-15', 'Active'),
(39, 5, 'Emergency Loan', 9000.00, 5.00, 9, '2025-01-15', '2025-10-15', 'Active'),
(40, 5, 'Emergency Loan', 9000.00, 5.00, 9, '2025-01-15', '2025-10-15', 'Active'),
(41, 1, 'Personal Loan', 10000.00, 5.00, 12, '2025-01-01', '2026-01-01', 'Active'),
(42, 1, 'Personal Loan', 10000.00, 5.00, 12, '2025-01-01', '2026-01-01', 'Active'),
(54, 2, 'Personal', 2.00, 1.00, 2, '2026-01-20', '2026-03-20', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `loan_schedule`
--

CREATE TABLE `loan_schedule` (
  `schedule_id` int(11) NOT NULL,
  `loan_id` int(11) NOT NULL,
  `due_date` date DEFAULT NULL,
  `amount_due` decimal(12,2) DEFAULT NULL,
  `amount_paid` decimal(12,2) DEFAULT 0.00,
  `payment_date` date DEFAULT NULL,
  `status` enum('Pending','Paid','Overdue') DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `loan_schedule`
--

INSERT INTO `loan_schedule` (`schedule_id`, `loan_id`, `due_date`, `amount_due`, `amount_paid`, `payment_date`, `status`) VALUES
(103, 19, '2025-11-15', 2960.42, 0.00, NULL, 'Pending'),
(104, 19, '2025-12-15', 2960.42, 0.00, NULL, 'Pending'),
(105, 19, '2026-01-15', 2960.42, 0.00, NULL, 'Pending'),
(106, 19, '2026-02-15', 2960.42, 0.00, NULL, 'Pending'),
(107, 19, '2026-03-15', 2960.42, 0.00, NULL, 'Pending'),
(108, 19, '2026-04-15', 2960.42, 0.00, NULL, 'Pending'),
(109, 19, '2026-05-15', 2960.42, 0.00, NULL, 'Pending'),
(110, 19, '2026-06-15', 2960.42, 0.00, NULL, 'Pending'),
(111, 19, '2026-07-15', 2960.42, 0.00, NULL, 'Pending'),
(112, 19, '2026-08-15', 2960.42, 0.00, NULL, 'Pending'),
(113, 19, '2026-09-15', 2960.42, 0.00, NULL, 'Pending'),
(114, 19, '2026-10-15', 2960.42, 0.00, NULL, 'Pending'),
(115, 20, '2025-11-15', 4229.17, 0.00, NULL, 'Pending'),
(116, 20, '2025-12-15', 4229.17, 0.00, NULL, 'Pending'),
(117, 20, '2026-01-15', 4229.17, 0.00, NULL, 'Pending'),
(118, 20, '2026-02-15', 4229.17, 0.00, NULL, 'Pending'),
(119, 20, '2026-03-15', 4229.17, 0.00, NULL, 'Pending'),
(120, 20, '2026-04-15', 4229.17, 0.00, NULL, 'Pending'),
(121, 20, '2026-05-15', 4229.17, 0.00, NULL, 'Pending'),
(122, 20, '2026-06-15', 4229.17, 0.00, NULL, 'Pending'),
(123, 20, '2026-07-15', 4229.17, 0.00, NULL, 'Pending'),
(124, 20, '2026-08-15', 4229.17, 0.00, NULL, 'Pending'),
(125, 20, '2026-09-15', 4229.17, 0.00, NULL, 'Pending'),
(126, 20, '2026-10-15', 4229.17, 0.00, NULL, 'Pending'),
(148, 25, '2025-11-15', 4241.67, 0.00, NULL, 'Pending'),
(149, 25, '2025-12-15', 4241.67, 0.00, NULL, 'Pending'),
(150, 25, '2026-01-15', 4241.67, 0.00, NULL, 'Pending'),
(151, 25, '2026-02-15', 4241.67, 0.00, NULL, 'Pending'),
(152, 25, '2026-03-15', 4241.67, 0.00, NULL, 'Pending'),
(153, 25, '2026-04-15', 4241.67, 0.00, NULL, 'Pending'),
(154, 25, '2026-05-15', 4241.67, 0.00, NULL, 'Pending'),
(155, 25, '2026-06-15', 4241.67, 0.00, NULL, 'Pending'),
(156, 25, '2026-07-15', 4241.67, 0.00, NULL, 'Pending'),
(157, 25, '2026-08-15', 4241.67, 0.00, NULL, 'Pending'),
(158, 25, '2026-09-15', 4241.67, 0.00, NULL, 'Pending'),
(159, 25, '2026-10-15', 4241.67, 0.00, NULL, 'Pending'),
(160, 26, '2025-11-15', 4241.67, 0.00, NULL, 'Pending'),
(161, 26, '2025-12-15', 4241.67, 0.00, NULL, 'Pending'),
(162, 26, '2026-01-15', 4241.67, 0.00, NULL, 'Pending'),
(163, 26, '2026-02-15', 4241.67, 0.00, NULL, 'Pending'),
(164, 26, '2026-03-15', 4241.67, 0.00, NULL, 'Pending'),
(165, 26, '2026-04-15', 4241.67, 0.00, NULL, 'Pending'),
(166, 26, '2026-05-15', 4241.67, 0.00, NULL, 'Pending'),
(167, 26, '2026-06-15', 4241.67, 0.00, NULL, 'Pending'),
(168, 26, '2026-07-15', 4241.67, 0.00, NULL, 'Pending'),
(169, 26, '2026-08-15', 4241.67, 0.00, NULL, 'Pending'),
(170, 26, '2026-09-15', 4241.67, 0.00, NULL, 'Pending'),
(171, 26, '2026-10-15', 4241.67, 0.00, NULL, 'Pending'),
(172, 27, '2025-11-15', 4283.33, 0.00, NULL, 'Pending'),
(173, 27, '2025-12-15', 4283.33, 0.00, NULL, 'Pending'),
(174, 27, '2026-01-15', 4283.33, 0.00, NULL, 'Pending'),
(175, 27, '2026-02-15', 4283.33, 0.00, NULL, 'Pending'),
(176, 27, '2026-03-15', 4283.33, 0.00, NULL, 'Pending'),
(177, 27, '2026-04-15', 4283.33, 0.00, NULL, 'Pending'),
(178, 27, '2026-05-15', 4283.33, 0.00, NULL, 'Pending'),
(179, 27, '2026-06-15', 4283.33, 0.00, NULL, 'Pending'),
(180, 27, '2026-07-15', 4283.33, 0.00, NULL, 'Pending'),
(181, 27, '2026-08-15', 4283.33, 0.00, NULL, 'Pending'),
(182, 27, '2026-09-15', 4283.33, 0.00, NULL, 'Pending'),
(183, 27, '2026-10-15', 4283.33, 0.00, NULL, 'Pending'),
(184, 28, '2025-11-18', 1172.50, 0.00, NULL, 'Pending'),
(185, 28, '2025-12-18', 1172.50, 0.00, NULL, 'Pending'),
(186, 28, '2026-01-18', 1172.50, 0.00, NULL, 'Pending'),
(187, 28, '2026-02-18', 1172.50, 0.00, NULL, 'Pending'),
(188, 28, '2026-03-18', 1172.50, 0.00, NULL, 'Pending'),
(189, 28, '2026-04-18', 1172.50, 0.00, NULL, 'Pending'),
(190, 28, '2026-05-18', 1172.50, 0.00, NULL, 'Pending'),
(191, 28, '2026-06-18', 1172.50, 0.00, NULL, 'Pending'),
(192, 28, '2026-07-18', 1172.50, 0.00, NULL, 'Pending'),
(193, 28, '2026-08-18', 1172.50, 0.00, NULL, 'Pending'),
(194, 28, '2026-09-18', 1172.50, 0.00, NULL, 'Pending'),
(195, 28, '2026-10-18', 1172.50, 0.00, NULL, 'Pending'),
(196, 28, '2026-11-18', 1172.50, 0.00, NULL, 'Pending'),
(197, 28, '2026-12-18', 1172.50, 0.00, NULL, 'Pending'),
(198, 28, '2027-01-18', 1172.50, 0.00, NULL, 'Pending'),
(199, 28, '2027-02-18', 1172.50, 0.00, NULL, 'Pending'),
(200, 28, '2027-03-18', 1172.50, 0.00, NULL, 'Pending'),
(201, 28, '2027-04-18', 1172.50, 0.00, NULL, 'Pending'),
(202, 28, '2027-05-18', 1172.50, 0.00, NULL, 'Pending'),
(203, 28, '2027-06-18', 1172.50, 0.00, NULL, 'Pending'),
(204, 28, '2027-07-18', 1172.50, 0.00, NULL, 'Pending'),
(205, 28, '2027-08-18', 1172.50, 0.00, NULL, 'Pending'),
(206, 28, '2027-09-18', 1172.50, 0.00, NULL, 'Pending'),
(207, 28, '2027-10-18', 1172.50, 0.00, NULL, 'Pending'),
(208, 28, '2027-11-18', 1172.50, 0.00, NULL, 'Pending'),
(209, 28, '2027-12-18', 1172.50, 0.00, NULL, 'Pending'),
(210, 28, '2028-01-18', 1172.50, 0.00, NULL, 'Pending'),
(211, 28, '2028-02-18', 1172.50, 0.00, NULL, 'Pending'),
(212, 28, '2028-03-18', 1172.50, 0.00, NULL, 'Pending'),
(213, 28, '2028-04-18', 1172.50, 0.00, NULL, 'Pending'),
(214, 28, '2028-05-18', 1172.50, 0.00, NULL, 'Pending'),
(215, 28, '2028-06-18', 1172.50, 0.00, NULL, 'Pending'),
(216, 28, '2028-07-18', 1172.50, 0.00, NULL, 'Pending'),
(217, 28, '2028-08-18', 1172.50, 0.00, NULL, 'Pending'),
(218, 28, '2028-09-18', 1172.50, 0.00, NULL, 'Pending'),
(219, 28, '2028-10-18', 1172.50, 0.00, NULL, 'Pending'),
(232, 35, '2025-04-01', 5200.00, 0.00, NULL, 'Pending'),
(233, 35, '2025-05-01', 5200.00, 0.00, NULL, 'Pending'),
(234, 35, '2025-06-01', 5200.00, 0.00, NULL, 'Pending'),
(235, 35, '2025-07-01', 5200.00, 0.00, NULL, 'Pending'),
(236, 35, '2025-08-01', 5200.00, 0.00, NULL, 'Pending'),
(237, 35, '2025-09-01', 5200.00, 0.00, NULL, 'Pending'),
(238, 36, '2025-11-22', 1050.00, 0.00, NULL, 'Pending'),
(239, 36, '2025-12-22', 1050.00, 0.00, NULL, 'Pending'),
(240, 36, '2026-01-22', 1050.00, 0.00, NULL, 'Pending'),
(241, 36, '2026-02-22', 1050.00, 0.00, NULL, 'Pending'),
(242, 36, '2026-03-22', 1050.00, 0.00, NULL, 'Pending'),
(243, 36, '2026-04-22', 1050.00, 0.00, NULL, 'Pending'),
(244, 36, '2026-05-22', 1050.00, 0.00, NULL, 'Pending'),
(245, 36, '2026-06-22', 1050.00, 0.00, NULL, 'Pending'),
(246, 36, '2026-07-22', 1050.00, 0.00, NULL, 'Pending'),
(247, 37, '2025-11-22', 1050.00, 0.00, NULL, 'Pending'),
(248, 37, '2025-12-22', 1050.00, 0.00, NULL, 'Pending'),
(249, 37, '2026-01-22', 1050.00, 0.00, NULL, 'Pending'),
(250, 37, '2026-02-22', 1050.00, 0.00, NULL, 'Pending'),
(251, 37, '2026-03-22', 1050.00, 0.00, NULL, 'Pending'),
(252, 37, '2026-04-22', 1050.00, 0.00, NULL, 'Pending'),
(253, 37, '2026-05-22', 1050.00, 0.00, NULL, 'Pending'),
(254, 37, '2026-06-22', 1050.00, 0.00, NULL, 'Pending'),
(255, 37, '2026-07-22', 1050.00, 0.00, NULL, 'Pending'),
(256, 38, '2025-02-15', 1050.00, 0.00, NULL, 'Pending'),
(257, 38, '2025-03-15', 1050.00, 0.00, NULL, 'Pending'),
(258, 38, '2025-04-15', 1050.00, 0.00, NULL, 'Pending'),
(259, 38, '2025-05-15', 1050.00, 0.00, NULL, 'Pending'),
(260, 38, '2025-06-15', 1050.00, 0.00, NULL, 'Pending'),
(261, 38, '2025-07-15', 1050.00, 0.00, NULL, 'Pending'),
(262, 38, '2025-08-15', 1050.00, 0.00, NULL, 'Pending'),
(263, 38, '2025-09-15', 1050.00, 0.00, NULL, 'Pending'),
(264, 38, '2025-10-15', 1050.00, 0.00, NULL, 'Pending'),
(265, 39, '2025-02-15', 1050.00, 0.00, NULL, 'Pending'),
(266, 39, '2025-03-15', 1050.00, 0.00, NULL, 'Pending'),
(267, 39, '2025-04-15', 1050.00, 0.00, NULL, 'Pending'),
(268, 39, '2025-05-15', 1050.00, 0.00, NULL, 'Pending'),
(269, 39, '2025-06-15', 1050.00, 0.00, NULL, 'Pending'),
(270, 39, '2025-07-15', 1050.00, 0.00, NULL, 'Pending'),
(271, 39, '2025-08-15', 1050.00, 0.00, NULL, 'Pending'),
(272, 39, '2025-09-15', 1050.00, 0.00, NULL, 'Pending'),
(273, 39, '2025-10-15', 1050.00, 0.00, NULL, 'Pending'),
(274, 40, '2025-02-15', 1050.00, 0.00, NULL, 'Pending'),
(275, 40, '2025-03-15', 1050.00, 0.00, NULL, 'Pending'),
(276, 40, '2025-04-15', 1050.00, 0.00, NULL, 'Pending'),
(277, 40, '2025-05-15', 1050.00, 0.00, NULL, 'Pending'),
(278, 40, '2025-06-15', 1050.00, 0.00, NULL, 'Pending'),
(279, 40, '2025-07-15', 1050.00, 0.00, NULL, 'Pending'),
(280, 40, '2025-08-15', 1050.00, 0.00, NULL, 'Pending'),
(281, 40, '2025-09-15', 1050.00, 0.00, NULL, 'Pending'),
(282, 40, '2025-10-15', 1050.00, 0.00, NULL, 'Pending'),
(283, 41, '2025-02-01', 875.00, 0.00, NULL, 'Pending'),
(284, 41, '2025-03-01', 875.00, 0.00, NULL, 'Pending'),
(285, 41, '2025-04-01', 875.00, 0.00, NULL, 'Pending'),
(286, 41, '2025-05-01', 875.00, 0.00, NULL, 'Pending'),
(287, 41, '2025-06-01', 875.00, 0.00, NULL, 'Pending'),
(288, 41, '2025-07-01', 875.00, 0.00, NULL, 'Pending'),
(289, 41, '2025-08-01', 875.00, 0.00, NULL, 'Pending'),
(290, 41, '2025-09-01', 875.00, 0.00, NULL, 'Pending'),
(291, 41, '2025-10-01', 875.00, 0.00, NULL, 'Pending'),
(292, 41, '2025-11-01', 875.00, 0.00, NULL, 'Pending'),
(293, 41, '2025-12-01', 875.00, 0.00, NULL, 'Pending'),
(294, 41, '2026-01-01', 875.00, 0.00, NULL, 'Pending'),
(295, 42, '2025-02-01', 875.00, 0.00, NULL, 'Pending'),
(296, 42, '2025-03-01', 875.00, 0.00, NULL, 'Pending'),
(297, 42, '2025-04-01', 875.00, 0.00, NULL, 'Pending'),
(298, 42, '2025-05-01', 875.00, 0.00, NULL, 'Pending'),
(299, 42, '2025-06-01', 875.00, 0.00, NULL, 'Pending'),
(300, 42, '2025-07-01', 875.00, 0.00, NULL, 'Pending'),
(301, 42, '2025-08-01', 875.00, 0.00, NULL, 'Pending'),
(302, 42, '2025-09-01', 875.00, 0.00, NULL, 'Pending'),
(303, 42, '2025-10-01', 875.00, 0.00, NULL, 'Pending'),
(304, 42, '2025-11-01', 875.00, 0.00, NULL, 'Pending'),
(305, 42, '2025-12-01', 875.00, 0.00, NULL, 'Pending'),
(306, 42, '2026-01-01', 875.00, 0.00, NULL, 'Pending'),
(319, 54, '2026-02-20', 1.01, 0.00, NULL, 'Pending'),
(320, 54, '2026-03-20', 1.01, 0.00, NULL, 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `member_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `member_code` varchar(50) DEFAULT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `gender` enum('Male','Female','Other') DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `contact_no` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `membership_date` date DEFAULT NULL,
  `status` enum('Active','Inactive') DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`member_id`, `user_id`, `member_code`, `full_name`, `gender`, `birth_date`, `contact_no`, `address`, `membership_date`, `status`) VALUES
(1, 1, 'MBR001', 'Juan Dela Cruz', 'Male', '1990-01-01', '09123456789', 'Manila', '2025-01-10', 'Active'),
(2, 1, 'MBR002', 'Maria Santos', 'Female', '1988-02-15', '09223334444', 'Quezon City', '2025-02-12', 'Active'),
(3, 1, 'MBR003', 'Jose Ramos', 'Male', '1995-03-20', '09334445555', 'Cebu City', '2025-03-05', 'Active'),
(4, 1, 'MBR004', 'Ana Villanueva', 'Female', '1995-03-09', '09191234567', 'Taguig City', '2022-04-25', 'Active'),
(5, 1, 'MBR005', 'Rico Fernandez', 'Male', '1991-08-14', '09201234567', 'Cavite City', '2022-05-11', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `permission_logs`
--

CREATE TABLE `permission_logs` (
  `log_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `module_name` varchar(100) NOT NULL,
  `action_name` varchar(50) NOT NULL,
  `action_status` enum('Success','Failed') DEFAULT 'Success',
  `action_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `permission_logs`
--

INSERT INTO `permission_logs` (`log_id`, `user_id`, `module_name`, `action_name`, `action_status`, `action_time`) VALUES
(1, 5, 'permission_logs', 'Access', 'Success', '2025-10-19 05:01:57'),
(2, 5, 'permission_logs', 'Access', 'Success', '2025-10-19 05:02:01'),
(3, 5, 'permission_logs', 'Access', 'Success', '2025-10-19 05:03:57'),
(4, 5, 'compliance_audit', 'Access', 'Success', '2025-10-19 05:03:59'),
(5, 5, 'permission_logs', 'Access', 'Success', '2025-10-19 05:04:01'),
(6, 5, 'permission_logs', 'Access', 'Success', '2025-10-19 05:04:16'),
(7, 5, 'permission_logs', 'Access', 'Success', '2025-10-19 05:04:37'),
(8, 5, 'permission_logs', 'Access', 'Success', '2025-10-19 05:04:46'),
(9, 5, 'permission_logs', 'Access', 'Success', '2025-10-19 05:11:18'),
(10, 5, 'permission_logs', 'Access', 'Success', '2025-10-19 05:11:20'),
(11, 5, 'compliance_audit', 'Access', 'Success', '2025-10-19 05:11:22'),
(12, 5, 'compliance_audit', 'Access', 'Success', '2025-10-19 05:14:11'),
(13, 5, 'permission_logs', 'Access', 'Success', '2025-10-19 05:14:13'),
(14, 5, 'compliance_audit', 'Access', 'Success', '2025-10-19 05:14:18'),
(15, 5, 'compliance_audit', 'Access', 'Success', '2025-10-19 05:27:56'),
(16, 5, 'permission_logs', 'Access', 'Success', '2025-10-19 05:27:58'),
(17, 6, 'permission_logs', 'Access', '', '2025-10-19 05:30:15'),
(18, 6, 'permission_logs', 'Access', '', '2025-10-19 05:30:19'),
(19, 6, 'permission_logs', 'Access', '', '2025-10-19 05:30:24'),
(20, 6, 'permission_logs', 'Access', '', '2025-10-19 05:34:56'),
(21, 6, 'permission_logs', 'Access', '', '2025-10-19 05:35:00'),
(22, 6, 'compliance_audit', 'Access', '', '2025-10-19 05:35:07'),
(23, 6, 'permission_logs', 'Access', '', '2025-10-19 05:35:11'),
(24, 6, 'permission_logs', 'Access', '', '2025-10-19 05:40:52'),
(25, 6, 'permission_logs', 'Access', '', '2025-10-19 05:40:57'),
(26, 6, 'compliance_audit', 'Access', '', '2025-10-19 05:41:06'),
(27, 6, 'permission_logs', 'Access', '', '2025-10-19 05:41:10'),
(28, 6, 'permission_logs', 'Access', '', '2025-10-19 05:41:14'),
(29, 6, 'permission_logs', 'Access', '', '2025-10-19 05:44:50'),
(30, 6, 'permission_logs', 'Access', '', '2025-10-19 05:44:54'),
(31, 6, 'permission_logs', 'Access', '', '2025-10-19 05:45:30'),
(32, 6, 'compliance_audit', 'Access', '', '2025-10-19 05:45:35'),
(33, 6, 'permission_logs', 'Access', '', '2025-10-19 05:46:32'),
(34, 6, 'permission_logs', 'Access', '', '2025-10-19 06:00:07'),
(35, 6, 'compliance_audit', 'Access', '', '2025-10-19 06:00:33'),
(36, 6, 'permission_logs', 'Access', '', '2025-10-19 06:01:40'),
(37, 6, 'permission_logs', 'Access', '', '2025-10-19 06:05:03'),
(38, 6, 'permission_logs', 'Access', '', '2025-10-19 06:05:06'),
(39, 6, 'permission_logs', 'Access', '', '2025-10-19 06:12:51'),
(40, 6, 'permission_logs', 'Access', '', '2025-10-19 06:13:01'),
(41, 6, 'compliance_audit', 'Access', '', '2025-10-19 06:15:08'),
(42, 6, 'compliance_audit', 'Access', '', '2025-10-19 06:15:13'),
(43, 6, 'compliance_audit', 'Access', '', '2025-10-19 06:15:18'),
(44, 6, 'compliance_audit', 'Access', '', '2025-10-19 06:15:24'),
(45, 6, 'compliance_audit', 'Access', '', '2025-10-19 06:23:46'),
(46, 6, 'compliance_audit', 'Access', '', '2025-10-19 06:23:50'),
(47, 6, 'compliance_audit', 'Access', '', '2025-10-19 06:28:57'),
(48, 6, 'compliance_audit', 'Access', '', '2025-10-19 06:29:00'),
(49, 6, 'permission_logs', 'Access', '', '2025-10-19 06:29:04'),
(50, 6, 'compliance_audit', 'Access', '', '2025-10-19 06:29:11'),
(51, 6, 'compliance_audit', 'Access', '', '2025-10-19 06:34:14'),
(52, 6, 'compliance_audit', 'Access', '', '2025-10-19 06:34:15'),
(53, 6, 'compliance_audit', 'Access', '', '2025-10-19 06:34:16'),
(54, 6, 'compliance_audit', 'Access', '', '2025-10-19 06:34:16'),
(55, 6, 'compliance_audit', 'Access', '', '2025-10-19 06:34:16'),
(56, 6, 'compliance_audit', 'Access', '', '2025-10-19 06:35:50'),
(57, 6, 'compliance_audit', 'Access', '', '2025-10-19 06:35:54'),
(58, 6, 'compliance_logs', 'Access', '', '2025-10-19 06:38:44'),
(59, 6, 'compliance_logs', 'Access', '', '2025-10-19 06:38:45'),
(60, 6, 'compliance_logs', 'Access', '', '2025-10-19 06:38:45'),
(61, 6, 'compliance_logs', 'Access', '', '2025-10-19 06:38:45'),
(62, 6, 'compliance_logs', 'Access', '', '2025-10-19 06:38:45'),
(63, 6, 'compliance_logs', 'Access', '', '2025-10-19 06:38:45'),
(64, 6, 'compliance_logs', 'Access', '', '2025-10-19 06:38:45'),
(65, 6, 'compliance_logs', 'Access', '', '2025-10-19 06:38:49'),
(66, 6, 'compliance_logs', 'Access', '', '2025-10-19 06:40:12'),
(67, 6, 'compliance_logs', 'Access', '', '2025-10-19 06:40:18'),
(68, 6, 'compliance_logs', 'Access', '', '2025-10-19 06:41:36'),
(69, 6, 'compliance_logs', 'Access', '', '2025-10-19 06:46:56'),
(70, 6, 'permission_logs', 'Access', '', '2025-10-19 06:46:59'),
(71, 5, 'permission_logs', 'Access', 'Success', '2025-10-19 06:47:25'),
(72, 5, 'compliance_logs', 'Access', 'Success', '2025-10-19 06:47:33'),
(73, 5, 'role_permissions', 'Access', 'Success', '2025-10-19 06:52:07'),
(74, 5, 'role_permissions', 'Access', 'Success', '2025-10-19 06:52:10'),
(75, 5, 'role_permissions', 'Access', 'Success', '2025-10-19 06:52:12'),
(76, 5, 'permission_logs', 'Access', 'Success', '2025-10-19 06:52:13'),
(77, 5, 'role_permissions', 'Access', 'Success', '2025-10-19 06:52:14'),
(78, 5, 'role_permissions', 'Access', 'Success', '2025-10-19 06:53:38'),
(79, 5, 'role_permissions', 'Access', 'Success', '2025-10-19 06:53:41'),
(80, 5, 'permission_logs', 'Access', 'Success', '2025-10-19 06:53:42'),
(81, 5, 'role_permissions', 'Access', 'Success', '2025-10-19 06:53:43'),
(82, 5, 'compliance_logs', 'Access', 'Success', '2025-10-19 06:53:48'),
(83, 5, 'compliance_logs', 'Access', 'Success', '2025-10-19 06:55:27'),
(84, 5, 'role_permissions', 'Access', 'Success', '2025-10-19 06:55:33'),
(85, 5, 'permission_logs', 'Access', 'Success', '2025-10-19 06:55:34'),
(86, 5, 'role_permissions', 'Access', 'Success', '2025-10-19 06:55:35'),
(87, 5, 'role_permissions', 'Access', 'Success', '2025-10-19 07:04:34'),
(88, 5, 'permission_logs', 'Access', 'Success', '2025-10-19 07:04:37'),
(89, 5, 'role_permissions', 'Access', 'Success', '2025-10-19 07:04:38'),
(90, 5, 'compliance_logs', 'Access', 'Success', '2025-10-19 10:19:13'),
(91, 5, 'permission_logs', 'Access', 'Success', '2025-10-19 10:19:16'),
(92, 5, 'role_permissions', 'Access', 'Success', '2025-10-19 10:19:17'),
(93, 5, 'compliance_logs', 'Access', 'Success', '2025-10-19 10:21:10'),
(94, 5, 'role_permissions', 'Access', 'Success', '2025-10-19 10:21:21'),
(95, 5, 'permission_logs', 'Access', 'Success', '2025-10-19 10:21:22'),
(96, 5, 'permission_logs', 'Access', 'Success', '2025-10-19 10:25:25'),
(97, 5, 'permission_logs', 'Access', 'Success', '2025-10-19 10:25:28'),
(98, 5, 'role_permissions', 'Access', 'Success', '2025-10-19 10:25:29'),
(99, 5, 'compliance_logs', 'Access', 'Success', '2025-10-19 10:25:31'),
(100, 5, 'savings_monitoring', 'Access', 'Success', '2025-10-19 10:25:32'),
(101, 5, 'permission_logs', 'Access', 'Success', '2025-10-19 10:26:11'),
(102, 5, 'compliance_logs', 'Access', 'Success', '2025-10-19 10:26:24'),
(103, 5, 'permission_logs', 'Access', 'Success', '2025-10-19 10:26:35'),
(104, 5, 'savings_monitoring', 'Access', 'Success', '2025-10-19 10:26:42'),
(105, 5, 'savings_monitoring', 'Access', 'Success', '2025-10-19 10:26:58'),
(106, 5, 'savings_monitoring', 'Access', 'Success', '2025-10-19 10:44:57'),
(107, 5, 'savings_monitoring', 'Access', 'Success', '2025-10-19 10:48:00'),
(108, 5, 'savings_monitoring', 'Access', 'Success', '2025-10-19 10:48:00'),
(109, 5, 'savings_monitoring', 'Access', 'Success', '2025-10-20 08:21:32'),
(110, 5, 'savings_monitoring', 'Access', 'Success', '2025-10-20 08:21:34'),
(111, 5, 'savings_monitoring', 'Access', 'Success', '2025-10-20 09:21:59'),
(112, 5, 'savings_monitoring', 'Access', 'Success', '2025-10-20 09:25:28'),
(113, 5, 'savings_monitoring', 'Access', 'Success', '2025-10-20 09:25:28'),
(114, 5, 'savings_monitoring', 'Access', 'Success', '2025-10-20 09:25:32'),
(115, 5, 'savings_monitoring', 'Access', 'Success', '2025-10-20 09:25:33'),
(116, 5, 'savings_monitoring', 'Access', 'Success', '2025-10-20 09:25:35'),
(117, 5, 'savings_monitoring', 'Access', 'Success', '2025-10-20 09:25:36'),
(118, 5, 'savings_monitoring', 'Access', 'Success', '2025-10-20 09:25:38'),
(119, 5, 'savings_monitoring', 'Access', 'Success', '2025-10-20 09:25:39'),
(120, 5, 'savings_monitoring', 'Access', 'Success', '2025-10-20 09:25:48'),
(121, 5, 'savings_monitoring', 'Access', 'Success', '2025-10-20 09:25:53'),
(122, 5, 'savings_monitoring', 'Access', 'Success', '2025-10-20 09:25:55'),
(123, 5, 'savings_monitoring', 'Access', 'Success', '2025-10-20 09:26:04'),
(124, 5, 'savings_monitoring', 'Access', 'Success', '2025-10-20 09:30:15'),
(125, 5, 'savings_monitoring', 'Access', 'Success', '2025-10-20 09:30:17'),
(126, 5, 'savings_monitoring', 'Access', 'Success', '2025-10-20 09:30:56'),
(127, 5, 'savings_monitoring', 'Access', 'Success', '2025-10-20 09:30:57'),
(128, 5, 'savings_monitoring', 'Access', 'Success', '2025-10-20 09:30:58'),
(129, 5, 'savings_monitoring', 'Access', 'Success', '2025-10-20 09:31:01'),
(130, 5, 'savings_monitoring', 'Access', 'Success', '2025-10-20 09:51:08'),
(131, 5, 'savings_monitoring', 'Access', 'Success', '2025-10-20 09:51:11'),
(132, 5, 'savings_monitoring', 'Access', 'Success', '2025-10-20 09:54:39'),
(133, 5, 'savings_monitoring', 'Access', 'Success', '2025-10-20 09:54:40'),
(134, 5, 'savings_monitoring', 'Access', 'Success', '2025-10-20 10:00:09'),
(135, 5, 'savings_monitoring', 'Access', 'Success', '2025-10-20 10:00:13'),
(136, 5, 'permission_logs', 'Access', 'Success', '2025-10-20 10:00:45'),
(137, 5, 'role_permissions', 'Access', 'Success', '2025-10-20 10:00:45'),
(138, 5, 'permission_logs', 'Access', 'Success', '2025-10-20 10:00:46'),
(139, 5, 'role_permissions', 'Access', 'Success', '2025-10-20 10:00:47'),
(140, 5, 'compliance_logs', 'Access', 'Success', '2025-10-20 10:00:48'),
(141, 5, 'savings_monitoring', 'Access', 'Success', '2025-10-20 10:00:50'),
(142, 5, 'savings_monitoring', 'Access', 'Success', '2025-10-20 10:00:51'),
(143, 5, 'savings_monitoring', 'Access', 'Success', '2025-10-20 10:02:36'),
(144, 5, 'savings_monitoring', 'Access', 'Success', '2025-10-20 10:02:47'),
(145, 5, 'savings_monitoring', 'Access', 'Success', '2025-10-20 10:03:11'),
(146, 5, 'savings_monitoring', 'Access', 'Success', '2025-10-20 10:03:34'),
(147, 5, 'savings_monitoring', 'Access', 'Success', '2025-10-20 10:03:34'),
(148, 5, 'savings_monitoring', 'Access', 'Success', '2025-10-20 10:06:53'),
(149, 5, 'Savings Monitoring', 'Delete', 'Success', '2025-10-20 10:07:43'),
(150, 5, 'savings_monitoring', 'Access', 'Success', '2025-10-20 10:20:55'),
(151, 5, 'savings_monitoring', 'Access', 'Success', '2025-10-20 10:25:47'),
(152, 5, 'savings_monitoring', 'Access', 'Success', '2025-10-20 10:25:49'),
(153, 5, 'savings_monitoring', 'Access', 'Success', '2025-10-20 10:26:09'),
(154, 5, 'savings_monitoring', 'Access', 'Success', '2025-10-20 10:29:50'),
(155, 5, 'permission_logs', 'Access', 'Success', '2025-10-20 10:30:00'),
(156, 5, 'role_permissions', 'Access', 'Success', '2025-10-20 10:30:00'),
(157, 5, 'role_permissions', 'Access', 'Success', '2025-10-20 10:30:02'),
(158, 5, 'savings_monitoring', 'Access', 'Success', '2025-10-20 10:32:20'),
(159, 5, 'savings_monitoring', 'Access', 'Success', '2025-10-20 10:32:59'),
(160, 5, 'Savings Monitoring', 'Add', 'Success', '2025-10-20 10:33:13'),
(161, 5, 'savings_monitoring', 'Access', 'Success', '2025-10-20 10:33:42'),
(162, 5, 'savings_monitoring', 'Access', 'Success', '2025-10-20 10:50:13'),
(163, 5, 'savings_monitoring', 'Access', 'Success', '2025-10-20 10:52:00'),
(164, 5, 'savings_monitoring', 'Access', 'Success', '2025-10-20 10:52:01'),
(165, 5, 'disbursement_tracker', 'Access', 'Success', '2025-10-20 10:52:02'),
(166, 5, 'savings_monitoring', 'Access', 'Success', '2025-10-20 10:52:04'),
(167, 5, 'disbursement_tracker', 'Access', 'Success', '2025-10-20 10:52:05'),
(168, 5, 'disbursement_tracker', 'Access', 'Success', '2025-10-20 10:52:40'),
(169, 5, 'disbursement_tracker', 'Access', 'Success', '2025-10-20 10:54:27'),
(170, 5, 'disbursement_tracker', 'Access', 'Success', '2025-10-20 10:54:47'),
(171, 5, 'disbursement_tracker', 'Access', 'Success', '2025-10-20 11:01:13'),
(172, 5, 'disbursement_tracker', 'Access', 'Success', '2025-10-20 11:16:41'),
(173, 5, 'disbursement_tracker', 'Access', 'Success', '2025-10-20 11:17:10'),
(174, 5, 'disbursement_tracker', 'Access', 'Success', '2025-10-20 11:17:14'),
(175, 5, 'disbursement_tracker', 'Access', 'Success', '2025-10-20 11:24:22'),
(176, 5, 'disbursement_tracker', 'Access', 'Success', '2025-10-20 11:24:41'),
(177, 5, 'disbursement_tracker', 'Access', 'Success', '2025-10-20 11:24:54'),
(178, 5, 'disbursement_tracker', 'Access', 'Success', '2025-10-20 12:18:07'),
(179, 5, 'disbursement_tracker', 'Access', 'Success', '2025-10-20 12:18:10'),
(180, 5, 'disbursement_tracker', 'Access', 'Success', '2025-10-20 12:18:18'),
(181, 5, 'disbursement_tracker', 'Access', 'Success', '2025-10-20 12:18:23'),
(182, 5, 'disbursement_tracker', 'Access', 'Success', '2025-10-20 12:24:03'),
(183, 5, 'savings_monitoring', 'Access', 'Success', '2025-10-20 12:24:39'),
(184, 5, 'disbursement_tracker', 'Access', 'Success', '2025-10-20 12:25:10'),
(185, 5, 'savings_monitoring', 'Access', 'Success', '2025-10-20 12:25:16'),
(186, 5, 'disbursement_tracker', 'Access', 'Success', '2025-10-20 12:25:17'),
(187, 5, 'disbursement_tracker', 'Access', 'Success', '2025-10-20 12:25:27'),
(188, 5, 'disbursement_tracker', 'Access', 'Success', '2025-10-20 12:26:07'),
(189, 5, 'disbursement_tracker', 'Access', 'Success', '2025-10-20 12:27:39'),
(190, 5, 'disbursement_tracker', 'Access', 'Success', '2025-10-20 12:28:00'),
(191, 5, 'savings_monitoring', 'Access', 'Success', '2025-10-20 12:38:38'),
(192, 5, 'Savings Monitoring', 'Edit', 'Success', '2025-10-20 12:38:57'),
(193, 5, 'Savings Monitoring', 'Edit', 'Success', '2025-10-20 12:39:03'),
(194, 5, 'savings_monitoring', 'Access', 'Success', '2025-10-20 12:39:07'),
(195, 5, 'Savings Monitoring', 'Edit', 'Success', '2025-10-20 12:39:12'),
(196, 5, 'Savings Monitoring', 'Edit', 'Success', '2025-10-20 12:39:16'),
(197, 5, 'Savings Monitoring', 'Edit', 'Success', '2025-10-20 12:39:19'),
(198, 5, 'Savings Monitoring', 'Delete', 'Success', '2025-10-20 12:39:32'),
(199, 6, 'permission_logs', 'Access', '', '2025-10-20 12:40:07'),
(200, 6, 'compliance_logs', 'Access', '', '2025-10-20 12:40:12'),
(201, 6, 'disbursement_tracker', 'Access', '', '2025-10-20 12:40:14'),
(202, 6, 'savings_monitoring', 'Access', '', '2025-10-20 12:40:16'),
(203, 1, 'savings_monitoring', 'Access', 'Success', '2025-10-20 12:40:33'),
(204, 1, 'disbursement_tracker', 'Access', 'Success', '2025-10-20 12:40:33'),
(205, 1, 'compliance_logs', 'Access', 'Success', '2025-10-20 12:40:36'),
(206, 1, 'disbursement_tracker', 'Access', 'Success', '2025-10-20 12:40:37'),
(207, 1, 'role_permissions', 'Access', 'Success', '2025-10-20 12:40:41'),
(208, 1, 'permission_logs', 'Access', 'Success', '2025-10-20 12:40:55'),
(209, 1, 'compliance_logs', 'Access', 'Success', '2025-10-20 12:40:57'),
(210, 1, 'disbursement_tracker', 'Access', 'Success', '2025-10-20 12:41:08'),
(211, 1, 'savings_monitoring', 'Access', 'Success', '2025-10-20 12:41:12'),
(212, 1, 'Savings Monitoring', 'Edit', 'Success', '2025-10-20 12:41:15'),
(213, 1, 'disbursement_tracker', 'Access', 'Success', '2025-10-20 12:41:41'),
(214, 1, 'savings_monitoring', 'Access', 'Success', '2025-10-20 12:41:44'),
(215, 1, 'savings_monitoring', 'Access', 'Success', '2025-10-20 12:41:45'),
(216, 1, 'disbursement_tracker', 'Access', 'Success', '2025-10-20 12:41:45'),
(217, 5, 'compliance_logs', 'Access', 'Success', '2025-10-20 12:42:30'),
(218, 5, 'disbursement_tracker', 'Access', 'Success', '2025-10-20 12:42:31'),
(219, 5, 'savings_monitoring', 'Access', 'Success', '2025-10-20 12:42:32'),
(220, 5, 'disbursement_tracker', 'Access', 'Success', '2025-10-20 12:42:34'),
(221, 5, 'disbursement_tracker', 'Access', 'Success', '2025-10-20 12:43:00'),
(222, 5, 'disbursement_tracker', 'Access', 'Success', '2025-10-20 12:43:03'),
(223, 5, 'disbursement_tracker', 'Access', 'Success', '2025-10-20 12:43:35'),
(224, 5, 'disbursement_tracker', 'Access', 'Success', '2025-10-20 12:43:54'),
(225, 5, 'disbursement_tracker', 'Access', 'Success', '2025-10-20 12:44:20'),
(226, 5, 'disbursement_tracker', 'Access', 'Success', '2025-10-20 12:44:50'),
(227, 5, 'disbursement_tracker', 'Access', 'Success', '2025-10-20 12:46:17'),
(228, 5, 'compliance_logs', 'Access', 'Success', '2025-10-20 12:46:18'),
(229, 5, 'disbursement_tracker', 'Access', 'Success', '2025-10-20 12:46:19'),
(230, 5, 'compliance_logs', 'Access', 'Success', '2025-10-20 12:46:21'),
(231, 5, 'disbursement_tracker', 'Access', 'Success', '2025-10-20 12:46:24'),
(232, 5, 'savings_monitoring', 'Access', 'Success', '2025-10-20 12:46:25'),
(233, 5, 'disbursement_tracker', 'Access', 'Success', '2025-10-20 12:46:28'),
(234, 5, 'disbursement_tracker', 'Access', 'Success', '2025-10-20 12:54:51'),
(235, 5, 'disbursement_tracker', 'Access', 'Success', '2025-10-20 12:55:04'),
(236, 5, 'disbursement_tracker', 'Access', 'Success', '2025-10-20 12:55:34'),
(237, 5, 'disbursement_tracker', 'Access', 'Success', '2025-10-20 13:02:20'),
(238, 5, 'disbursement_tracker', 'Access', 'Success', '2025-10-20 13:03:35'),
(239, 5, 'disbursement_tracker', 'Access', 'Success', '2025-10-20 13:06:44'),
(240, 5, 'permission_logs', 'Access', 'Success', '2025-10-20 13:33:19'),
(241, 5, 'role_permissions', 'Access', 'Success', '2025-10-20 13:33:21'),
(242, 5, 'compliance_logs', 'Access', 'Success', '2025-10-20 13:33:21'),
(243, 5, 'savings_monitoring', 'Access', 'Success', '2025-10-20 13:33:22'),
(244, 5, 'disbursement_tracker', 'Access', 'Success', '2025-10-20 13:47:15'),
(245, 5, 'savings_monitoring', 'Access', 'Success', '2025-10-20 13:47:28'),
(246, 5, 'disbursement_tracker', 'Access', 'Success', '2025-10-20 13:47:29'),
(247, 5, 'disbursement_tracker', 'Access', 'Success', '2025-10-20 13:52:19'),
(248, 5, 'disbursement_tracker', 'Access', 'Success', '2025-10-20 13:52:23'),
(249, 5, 'disbursement_tracker', 'Access', 'Success', '2025-10-20 13:52:26'),
(250, 5, 'disbursement_tracker', 'Access', 'Success', '2025-10-20 13:52:29'),
(251, 5, 'disbursement_tracker', 'Access', 'Success', '2025-10-20 13:59:09'),
(252, 5, 'disbursement_tracker', 'Access', 'Success', '2025-10-20 14:04:20'),
(253, 5, 'disbursement_tracker', 'Access', 'Success', '2025-10-20 14:04:22'),
(254, 5, 'compliance_logs', 'Access', 'Success', '2025-10-20 14:04:24'),
(255, 5, 'disbursement_tracker', 'Access', 'Success', '2025-10-20 14:04:24'),
(256, 5, 'disbursement_tracker', 'Access', 'Success', '2025-10-20 14:06:17'),
(257, 5, 'savings_monitoring', 'Access', 'Success', '2025-10-20 14:06:28'),
(258, 5, 'disbursement_tracker', 'Access', 'Success', '2025-10-20 14:06:29'),
(259, 5, 'Disbursement Tracker', 'Edit', 'Success', '2025-10-20 15:04:45'),
(260, 5, 'Disbursement Tracker', 'Edit', 'Success', '2025-10-20 15:04:54'),
(261, 5, 'Disbursement Tracker', 'Edit', 'Success', '2025-10-20 15:05:03'),
(262, 5, 'savings_monitoring', 'Access', 'Success', '2025-10-20 15:05:44'),
(263, 5, 'Savings Monitoring', 'Edit', 'Success', '2025-10-20 15:05:56'),
(264, 5, 'Disbursement Tracker', 'Edit', 'Success', '2025-10-20 15:09:50'),
(265, 5, 'Disbursement Tracker', 'Edit', 'Success', '2025-10-20 15:16:46'),
(266, 5, 'Disbursement Tracker', 'Edit', 'Success', '2025-10-20 15:16:54'),
(267, 5, 'Repayment_Tracker', 'Access', 'Success', '2025-10-21 07:20:39'),
(268, 5, 'savings_monitoring', 'Access', 'Success', '2025-10-21 07:20:44'),
(269, 5, 'role_permissions', 'Access', 'Success', '2025-10-21 07:20:46'),
(270, 5, 'Repayment_Tracker', 'Access', 'Success', '2025-10-21 07:22:26'),
(271, 5, 'Repayment_Tracker', 'Access', 'Success', '2025-10-21 07:22:52'),
(272, 5, 'savings_monitoring', 'Access', 'Success', '2025-10-21 07:23:36'),
(273, 5, 'Repayment_Tracker', 'Access', 'Success', '2025-10-21 07:23:52'),
(274, 5, 'compliance_logs', 'Access', 'Success', '2025-10-21 07:24:26'),
(275, 5, 'compliance_logs', 'Access', 'Success', '2025-10-21 07:24:42'),
(276, 5, 'compliance_logs', 'Access', 'Success', '2025-10-21 07:24:58'),
(277, 5, 'savings_monitoring', 'Access', 'Success', '2025-10-21 07:25:26'),
(278, 5, 'role_permissions', 'Access', 'Success', '2025-10-21 07:25:51'),
(279, 5, 'role_permissions', 'Access', 'Success', '2025-10-21 07:25:57'),
(280, 5, 'role_permissions', 'Access', 'Success', '2025-10-21 07:26:04'),
(281, 5, 'permission_logs', 'Access', 'Success', '2025-10-21 07:26:40'),
(282, 5, 'permission_logs', 'Access', 'Success', '2025-10-21 07:27:32'),
(283, 5, 'permission_logs', 'Access', 'Success', '2025-10-21 07:27:44'),
(284, 5, 'Repayment_Tracker', 'Access', 'Success', '2025-10-21 07:27:48'),
(285, 5, 'savings_monitoring', 'Access', 'Success', '2025-10-21 07:27:49'),
(286, 5, 'compliance_logs', 'Access', 'Success', '2025-10-21 07:27:51'),
(287, 5, 'Repayment_Tracker', 'Access', 'Success', '2025-10-21 07:27:52'),
(288, 5, 'savings_monitoring', 'Access', 'Success', '2025-10-21 07:27:55'),
(289, 5, 'Repayment_Tracker', 'Access', 'Success', '2025-10-21 07:27:59'),
(290, 5, 'Repayment_Tracker', 'Access', 'Success', '2025-10-21 07:28:16'),
(291, 5, 'Repayment_Tracker', 'Access', 'Success', '2025-10-21 07:28:47'),
(292, 5, 'Repayment_Tracker', 'Access', 'Success', '2025-10-21 07:29:06'),
(293, 5, 'Repayment_Tracker', 'Access', 'Success', '2025-10-21 07:29:57'),
(294, 5, 'Repayment_Tracker', 'Access', 'Success', '2025-10-21 07:30:30'),
(295, 6, 'Repayment_Tracker', 'Access', '', '2025-10-21 07:31:15'),
(296, 6, 'savings_monitoring', 'Access', '', '2025-10-21 07:31:20'),
(297, 6, 'Disbursement Tracker', 'Access', '', '2025-10-21 07:31:24'),
(298, 6, 'permission_logs', 'Access', '', '2025-10-21 07:31:36'),
(299, 5, 'Repayment_Tracker', 'Access', 'Success', '2025-10-21 09:12:43'),
(300, 5, 'savings_monitoring', 'Access', 'Success', '2025-10-21 09:12:52'),
(301, 5, 'compliance_logs', 'Access', 'Success', '2025-10-21 09:12:54'),
(302, 5, 'Repayment_Tracker', 'Access', 'Success', '2025-10-21 09:12:58'),
(303, 5, 'compliance_logs', 'Access', 'Success', '2025-10-21 09:14:17'),
(304, 5, 'Repayment_Tracker', 'Access', 'Success', '2025-10-21 09:15:08'),
(305, 5, 'savings_monitoring', 'Access', 'Success', '2025-10-21 09:15:36'),
(306, 5, 'Repayment_Tracker', 'Access', 'Success', '2025-10-21 09:15:37'),
(307, 5, 'Repayment_Tracker', 'Access', 'Success', '2025-10-21 09:16:44'),
(308, 5, 'Repayment_Tracker', 'Access', 'Success', '2025-10-21 09:17:00'),
(309, 5, 'savings_monitoring', 'Access', 'Success', '2025-10-21 09:17:04'),
(310, 6, 'Repayment_Tracker', 'Access', '', '2025-10-21 09:17:58'),
(311, 5, 'Repayment_Tracker', 'Access', 'Success', '2025-10-21 15:04:12'),
(312, 5, 'savings_monitoring', 'Access', 'Success', '2025-10-21 15:08:07'),
(313, 5, 'Savings Monitoring', 'Edit', 'Success', '2025-10-21 15:08:11'),
(314, 5, 'savings_monitoring', 'Access', 'Success', '2025-10-21 15:12:55'),
(315, 5, 'Disbursement Tracker', 'Edit', 'Success', '2025-10-21 15:13:16'),
(316, 5, 'Disbursement Tracker', 'Edit', 'Success', '2025-10-21 15:13:20'),
(317, 5, 'Repayment_Tracker', 'Access', 'Success', '2025-10-21 15:14:08'),
(318, 5, 'Repayment_Tracker', 'Access', 'Success', '2025-10-21 15:21:32'),
(319, 5, 'permission_logs', 'Access', 'Success', '2025-10-21 15:23:55'),
(320, 5, 'role_permissions', 'Access', 'Success', '2025-10-21 15:23:56'),
(321, 5, 'compliance_logs', 'Access', 'Success', '2025-10-21 15:23:57'),
(322, 5, 'savings_monitoring', 'Access', 'Success', '2025-10-21 15:24:23'),
(323, 5, 'Repayment_Tracker', 'Access', 'Success', '2025-10-21 15:28:27'),
(324, 5, 'savings_monitoring', 'Access', 'Success', '2025-10-21 15:31:25'),
(325, 5, 'Repayment_Tracker', 'Access', 'Success', '2025-10-21 15:34:08'),
(326, 5, 'Repayment_Tracker', 'Access', 'Success', '2025-10-21 15:41:19'),
(327, 5, 'Repayment_Tracker', 'Access', 'Success', '2025-10-21 15:43:51'),
(328, 5, 'Repayment_Tracker', 'Access', 'Success', '2025-10-21 15:47:30'),
(329, 5, 'Repayment_Tracker', 'Access', 'Success', '2025-10-21 15:49:32'),
(330, 5, 'savings_monitoring', 'Access', 'Success', '2025-10-21 15:57:45'),
(331, 5, 'Repayment_Tracker', 'Access', 'Success', '2025-10-21 16:04:05'),
(332, 5, 'Repayment_Tracker', 'Access', 'Success', '2025-10-21 16:04:38'),
(333, 5, 'savings_monitoring', 'Access', 'Success', '2025-10-21 16:04:40'),
(334, 5, 'Repayment_Tracker', 'Access', 'Success', '2025-10-21 16:05:35'),
(335, 5, 'Repayment_Tracker', 'Access', 'Success', '2025-10-21 16:05:42'),
(336, 5, 'Repayment_Tracker', 'Access', 'Success', '2025-10-21 16:08:05'),
(337, 5, 'Repayment_Tracker', 'Access', 'Success', '2025-10-21 16:09:17'),
(338, 5, 'Repayment_Tracker', 'Access', 'Success', '2025-10-21 16:10:13'),
(339, 5, 'Repayment_Tracker', 'Access', 'Success', '2025-10-21 16:10:28'),
(340, 5, 'Repayment_Tracker', 'Access', 'Success', '2025-10-21 16:11:26'),
(341, 5, 'Repayment_Tracker', 'Access', 'Success', '2025-10-21 16:12:59'),
(342, 5, 'Repayment_Tracker', 'Access', 'Success', '2025-10-21 16:13:09'),
(343, 5, 'Repayment_Tracker', 'Access', 'Success', '2025-10-21 16:14:58'),
(344, 5, 'Repayment_Tracker', 'Access', 'Success', '2025-10-21 16:17:45'),
(345, 5, 'Repayment_Tracker', 'Access', 'Success', '2025-10-21 16:19:27'),
(346, 5, 'Repayment_Tracker', 'Access', 'Success', '2025-10-21 16:22:59'),
(347, 5, 'Repayment_Tracker', 'Access', 'Success', '2025-10-21 16:25:46'),
(348, 5, 'Repayment_Tracker', 'Access', 'Success', '2025-10-21 16:27:38'),
(349, 5, 'Repayment_Tracker', 'Access', 'Success', '2025-10-21 16:27:56'),
(350, 5, 'Repayment_Tracker', 'Access', 'Success', '2025-10-21 16:29:05'),
(351, 5, 'savings_monitoring', 'Access', 'Success', '2025-10-21 16:29:06'),
(352, 5, 'Repayment_Tracker', 'Access', 'Success', '2025-10-21 16:30:10'),
(353, 5, 'Repayment_Tracker', 'Access', 'Success', '2025-10-21 16:31:03'),
(354, 5, 'Repayment_Tracker', 'Access', 'Success', '2025-10-21 16:31:18'),
(355, 5, 'Repayment_Tracker', 'Access', 'Success', '2025-10-21 16:33:44'),
(356, 5, 'Repayment_Tracker', 'Access', 'Success', '2025-10-21 16:34:13'),
(357, 5, 'Repayment_Tracker', 'Access', 'Success', '2025-10-21 16:34:30'),
(358, 5, 'Repayment_Tracker', 'Access', 'Success', '2025-10-21 16:37:11'),
(359, 5, 'Repayment_Tracker', 'Access', 'Success', '2025-10-21 16:38:03'),
(360, 5, 'savings_monitoring', 'Access', 'Success', '2025-10-21 16:38:20'),
(361, 5, 'savings_monitoring', 'Access', 'Success', '2025-10-21 16:44:42'),
(362, 5, 'Disbursement Tracker', 'Edit', 'Success', '2025-10-21 16:44:59'),
(363, 5, 'savings_monitoring', 'Access', 'Success', '2025-10-21 16:45:54'),
(364, 5, 'savings_monitoring', 'Access', 'Success', '2025-10-21 16:46:03'),
(365, 5, 'savings_monitoring', 'Access', 'Success', '2025-10-21 16:52:14'),
(366, 5, 'Savings Monitoring', 'Add', 'Success', '2025-10-21 16:52:34'),
(367, 5, 'Disbursement Tracker', 'Edit', 'Success', '2025-10-21 16:58:14'),
(368, 5, 'Repayment_Tracker', 'Access', 'Success', '2025-10-21 17:03:47'),
(369, 5, 'Repayment_Tracker', 'Access', 'Success', '2025-10-21 17:03:48'),
(370, 5, 'Repayment_Tracker', 'Access', 'Success', '2025-10-21 17:06:33'),
(371, 5, 'Repayment_Tracker', 'Access', 'Success', '2025-10-21 17:07:48'),
(372, 5, 'compliance_logs', 'Access', 'Success', '2025-10-21 17:13:19'),
(373, 5, 'Repayment_Tracker', 'Access', 'Success', '2025-10-21 17:13:36'),
(374, 5, 'savings_monitoring', 'Access', 'Success', '2025-10-21 17:13:37'),
(375, 5, 'Repayment_Tracker', 'Access', 'Success', '2025-10-21 17:14:09'),
(376, 5, 'savings_monitoring', 'Access', 'Success', '2025-10-21 17:14:10'),
(377, 5, 'Repayment_Tracker', 'Access', 'Success', '2025-10-21 17:14:11'),
(378, 5, 'compliance_logs', 'Access', 'Success', '2025-10-21 17:14:26'),
(379, 5, 'role_permissions', 'Access', 'Success', '2025-10-21 17:14:31'),
(380, 5, 'role_permissions', 'Access', 'Success', '2025-10-21 17:14:32'),
(381, 5, 'role_permissions', 'Access', 'Success', '2025-10-21 17:15:25'),
(382, 5, 'role_permissions', 'Access', 'Success', '2025-10-21 17:15:49'),
(383, 5, 'permission_logs', 'Access', 'Success', '2025-10-21 17:16:01'),
(384, 5, 'compliance_logs', 'Access', 'Success', '2025-10-21 17:16:07'),
(385, 5, 'compliance_logs', 'Access', 'Success', '2025-10-21 17:17:52'),
(386, 5, 'compliance_logs', 'Access', 'Success', '2025-10-21 17:18:41'),
(387, 5, 'Repayment_Tracker', 'Access', 'Success', '2025-10-21 17:18:52'),
(388, 5, 'compliance_logs', 'Access', 'Success', '2025-10-21 17:20:39'),
(389, 5, 'Repayment_Tracker', 'Access', 'Success', '2025-10-21 17:21:42'),
(390, 5, 'savings_monitoring', 'Access', 'Success', '2025-10-21 17:21:42'),
(391, 5, 'Repayment_Tracker', 'Access', 'Success', '2025-10-21 17:21:43'),
(392, 5, 'permission_logs', 'Access', 'Success', '2025-10-21 17:26:25'),
(393, 5, 'role_permissions', 'Access', 'Success', '2025-10-21 17:26:25'),
(394, 5, 'permission_logs', 'Access', 'Success', '2025-10-21 17:26:26'),
(395, 5, 'compliance_logs', 'Access', 'Success', '2025-10-21 17:26:36'),
(396, 5, 'compliance_logs', 'Access', 'Success', '2025-10-21 17:26:39'),
(397, 5, 'compliance_logs', 'Access', 'Success', '2025-10-21 17:26:54'),
(398, 5, 'compliance_logs', 'Access', 'Success', '2025-10-21 17:26:55'),
(399, 5, 'compliance_logs', 'Access', 'Success', '2025-10-21 17:26:56'),
(400, 5, 'compliance_logs', 'Access', 'Success', '2025-10-21 17:26:57'),
(401, 5, 'compliance_logs', 'Access', 'Success', '2025-10-21 17:26:59'),
(402, 5, 'compliance_logs', 'Access', 'Success', '2025-10-21 17:27:33'),
(403, 5, 'compliance_logs', 'Access', 'Success', '2025-10-21 17:27:38'),
(404, 5, 'savings_monitoring', 'Access', 'Success', '2025-10-21 17:27:39'),
(405, 5, 'compliance_logs', 'Access', 'Success', '2025-10-21 17:27:40'),
(406, 5, 'Disbursement Tracker', 'Approve', 'Success', '2025-10-21 18:10:53'),
(407, 5, 'compliance_logs', 'Access', 'Success', '2025-10-21 18:11:01'),
(408, 5, 'Repayment_Tracker', 'Access', 'Success', '2025-10-21 22:19:47'),
(409, 5, 'savings_monitoring', 'Access', 'Success', '2025-10-21 22:19:48'),
(410, 5, 'savings_monitoring', 'Access', 'Success', '2025-10-21 22:19:49'),
(411, 5, 'compliance_logs', 'Access', 'Success', '2025-10-21 22:20:01'),
(412, 5, 'savings_monitoring', 'Access', 'Success', '2025-10-21 22:20:03'),
(413, 5, 'Repayment_Tracker', 'Access', 'Success', '2025-10-21 22:20:05'),
(414, 5, 'Repayment_Tracker', 'Access', 'Success', '2025-10-21 22:28:22'),
(415, 5, 'Repayment_Tracker', 'Access', 'Success', '2025-10-21 22:35:59'),
(416, 5, 'Repayment_Tracker', 'Access', 'Success', '2025-10-21 22:41:55'),
(417, 5, 'savings_monitoring', 'Access', 'Success', '2025-10-21 22:49:49'),
(418, 5, 'Repayment_Tracker', 'Access', 'Success', '2025-10-21 22:52:13'),
(419, 5, 'Repayment_Tracker', 'Access', 'Success', '2025-10-21 23:00:44'),
(420, 5, 'savings_monitoring', 'Access', 'Success', '2025-10-21 23:00:51'),
(421, 5, 'savings_monitoring', 'Access', 'Success', '2025-10-21 23:01:31'),
(422, 5, 'savings_monitoring', 'Access', 'Success', '2025-10-21 23:05:13'),
(423, 5, 'savings_monitoring', 'Access', 'Success', '2025-10-21 23:05:15'),
(424, 5, 'savings_monitoring', 'Access', 'Success', '2025-10-21 23:05:28'),
(425, 5, 'savings_monitoring', 'Access', 'Success', '2025-10-21 23:07:45'),
(426, 5, 'savings_monitoring', 'Access', 'Success', '2025-10-21 23:08:17'),
(427, 5, 'savings_monitoring', 'Access', 'Success', '2025-10-21 23:10:29'),
(428, 5, 'savings_monitoring', 'Access', 'Success', '2025-10-21 23:10:38'),
(429, 5, 'savings_monitoring', 'Access', 'Success', '2025-10-21 23:10:45'),
(430, 5, 'savings_monitoring', 'Access', 'Success', '2025-10-21 23:13:05'),
(431, 5, 'Savings Monitoring', 'Add', 'Success', '2025-10-21 23:15:17'),
(432, 5, 'savings_monitoring', 'Access', 'Success', '2025-10-21 23:24:20'),
(433, 5, 'savings_monitoring', 'Access', 'Success', '2025-10-21 23:24:37'),
(434, 5, 'savings_monitoring', 'Access', 'Success', '2025-10-21 23:28:12'),
(435, 5, 'savings_monitoring', 'Access', 'Success', '2025-10-21 23:28:13'),
(436, 5, 'savings_monitoring', 'Access', 'Success', '2025-10-21 23:28:30'),
(437, 5, 'savings_monitoring', 'Access', 'Success', '2025-10-21 23:31:39'),
(438, 5, 'savings_monitoring', 'Access', 'Success', '2025-10-21 23:33:04'),
(439, 5, 'savings_monitoring', 'Access', 'Success', '2025-10-22 03:26:35'),
(440, 5, 'compliance_logs', 'Access', 'Success', '2025-10-22 03:27:03'),
(441, 5, 'savings_monitoring', 'Access', 'Success', '2025-10-22 03:27:05'),
(442, 5, 'Disbursement Tracker', 'Approve', 'Success', '2025-10-22 03:27:17'),
(443, 5, 'savings_monitoring', 'Access', 'Success', '2025-10-22 03:27:45'),
(444, 5, 'Repayment_Tracker', 'Access', 'Success', '2025-10-22 03:27:52'),
(445, 5, 'savings_monitoring', 'Access', 'Success', '2025-10-22 03:29:04'),
(446, 5, 'Savings Monitoring', 'Add', 'Success', '2025-10-22 03:29:23'),
(447, 5, 'savings_monitoring', 'Access', 'Success', '2025-10-22 03:31:19'),
(448, 5, 'savings_monitoring', 'Access', 'Success', '2025-10-22 03:33:07'),
(449, 5, 'savings_monitoring', 'Access', 'Success', '2025-10-22 03:33:43'),
(450, 5, 'savings_monitoring', 'Access', 'Success', '2025-10-22 03:34:28'),
(451, 5, 'savings_monitoring', 'Access', 'Success', '2025-10-22 03:34:46'),
(452, 5, 'Repayment_Tracker', 'Access', 'Success', '2025-10-22 03:35:19'),
(453, 5, 'Repayment_Tracker', 'Access', 'Success', '2025-10-22 03:38:27'),
(454, 5, 'Repayment_Tracker', 'Access', 'Success', '2025-10-22 03:39:23'),
(455, 5, 'Repayment_Tracker', 'Access', 'Success', '2025-10-22 03:39:32'),
(456, 5, 'Repayment_Tracker', 'Access', 'Success', '2025-10-22 03:39:59'),
(457, 5, 'Repayment_Tracker', 'Access', 'Success', '2025-10-22 03:40:53'),
(458, 5, 'savings_monitoring', 'Access', 'Success', '2025-10-22 03:40:56'),
(459, 5, 'Repayment_Tracker', 'Access', 'Success', '2025-10-22 03:42:28'),
(460, 5, 'Repayment_Tracker', 'Access', 'Success', '2025-10-22 03:43:52'),
(461, 5, 'Repayment_Tracker', 'Access', 'Success', '2025-10-22 03:44:05'),
(462, 5, 'Repayment_Tracker', 'Access', 'Success', '2025-10-22 03:46:43'),
(463, 5, 'Repayment_Tracker', 'Access', 'Success', '2025-10-22 03:48:46'),
(464, 5, 'Repayment_Tracker', 'Access', 'Success', '2025-10-22 03:52:22'),
(465, 5, 'Repayment_Tracker', 'Access', 'Success', '2025-10-22 03:53:18'),
(466, 5, 'Repayment_Tracker', 'Access', 'Success', '2025-10-22 03:56:27'),
(467, 5, 'Repayment_Tracker', 'Access', 'Success', '2025-10-22 03:58:43'),
(468, 5, 'Repayment_Tracker', 'Access', 'Success', '2025-10-22 04:03:26'),
(469, 5, 'Repayment_Tracker', 'Access', 'Success', '2025-10-22 04:04:14'),
(470, 5, 'Repayment_Tracker', 'Access', 'Success', '2025-10-22 04:07:05'),
(471, 5, 'Repayment_Tracker', 'Access', 'Success', '2025-10-22 04:39:58'),
(472, 5, 'savings_monitoring', 'Access', 'Success', '2025-10-22 04:40:39'),
(473, 5, 'Repayment_Tracker', 'Access', 'Success', '2025-10-22 04:41:42'),
(474, 5, 'Repayment_Tracker', 'Access', 'Success', '2025-10-22 04:44:35'),
(475, 5, 'Repayment_Tracker', 'Access', 'Success', '2025-10-22 04:46:14'),
(476, 5, 'Repayment_Tracker', 'Access', 'Success', '2025-10-22 04:46:41'),
(477, 5, 'compliance_logs', 'Access', 'Success', '2025-10-22 04:47:15'),
(478, 5, 'compliance_logs', 'Access', 'Success', '2025-10-22 04:47:17'),
(479, 5, 'Repayment_Tracker', 'Access', 'Success', '2025-10-22 04:48:07'),
(480, 5, 'savings_monitoring', 'Access', 'Success', '2025-10-22 04:49:26'),
(481, 5, 'compliance_logs', 'Access', 'Success', '2025-10-22 04:56:06'),
(482, 5, 'savings_monitoring', 'Access', 'Success', '2025-10-22 04:56:08'),
(483, 5, 'Repayment_Tracker', 'Access', 'Success', '2025-10-22 04:56:09'),
(484, 5, 'compliance_logs', 'Access', 'Success', '2025-10-22 04:56:46'),
(485, 5, 'Repayment_Tracker', 'Access', 'Success', '2025-10-22 05:04:56'),
(486, 5, 'compliance_logs', 'Access', 'Success', '2025-10-22 05:05:03'),
(487, 5, 'savings_monitoring', 'Access', 'Success', '2025-10-22 05:05:06'),
(488, 5, 'Repayment_Tracker', 'Access', 'Success', '2025-10-22 05:05:08'),
(489, 5, 'role_permissions', 'Access', 'Success', '2025-10-22 05:12:14'),
(490, 5, 'permission_logs', 'Access', 'Success', '2025-10-22 05:12:15'),
(491, 5, 'Repayment_Tracker', 'Access', 'Success', '2025-10-22 05:36:35'),
(492, 5, 'savings_monitoring', 'Access', 'Success', '2025-10-22 05:36:36'),
(493, 5, 'compliance_logs', 'Access', 'Success', '2025-10-22 05:36:37'),
(494, 5, 'Repayment_Tracker', 'Access', 'Success', '2025-10-22 06:09:28'),
(495, 5, 'savings_monitoring', 'Access', 'Success', '2025-10-22 06:09:29'),
(496, 5, 'savings_monitoring', 'Access', 'Success', '2025-10-22 06:09:48'),
(497, 5, 'Repayment_Tracker', 'Access', 'Success', '2025-10-22 06:09:50'),
(498, 5, 'Repayment_Tracker', 'Access', 'Success', '2025-10-22 07:10:33'),
(499, 5, 'savings_monitoring', 'Access', 'Success', '2025-10-22 07:10:45'),
(500, 5, 'compliance_logs', 'Access', 'Success', '2025-10-22 07:10:46'),
(501, 1, 'compliance_logs', 'Access', 'Success', '2026-01-16 17:19:15'),
(502, 1, 'Disbursement Tracker', 'Access', '', '2026-01-16 17:19:18'),
(503, 1, 'compliance_logs', 'Access', 'Success', '2026-01-16 17:19:21'),
(504, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-16 17:19:25'),
(505, 1, 'Repayment_Tracker', 'Access', 'Success', '2026-01-16 17:19:26'),
(506, 1, 'permission_logs', 'Access', '', '2026-01-16 17:19:37'),
(507, 1, 'permission_logs', 'Access', '', '2026-01-16 17:21:40'),
(508, 7, 'compliance_logs', 'Access', 'Success', '2026-01-16 17:21:54'),
(509, 7, 'Disbursement Tracker', 'Access', '', '2026-01-16 17:22:02'),
(510, 7, 'Repayment_Tracker', 'Access', 'Success', '2026-01-16 17:22:05'),
(511, 7, 'savings_monitoring', 'Access', 'Success', '2026-01-16 17:22:07'),
(512, 7, 'savings_monitoring', 'Access', 'Success', '2026-01-16 17:22:10'),
(513, 7, 'savings_monitoring', 'Access', 'Success', '2026-01-16 17:22:12'),
(514, 7, 'compliance_logs', 'Access', 'Success', '2026-01-16 17:22:15'),
(515, 7, 'Disbursement Tracker', 'Access', '', '2026-01-16 17:22:16'),
(516, 7, 'Disbursement Tracker', 'Access', '', '2026-01-16 17:22:25'),
(517, 7, 'savings_monitoring', 'Access', 'Success', '2026-01-16 17:22:27'),
(518, 7, 'Repayment_Tracker', 'Access', 'Success', '2026-01-16 17:22:29'),
(519, 7, 'permission_logs', 'Access', 'Success', '2026-01-16 17:22:35'),
(520, 1, 'permission_logs', 'Access', '', '2026-01-16 17:24:19'),
(521, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-16 17:24:20'),
(522, 1, 'Disbursement Tracker', 'Access', '', '2026-01-16 17:24:22'),
(523, 1, 'compliance_logs', 'Access', 'Success', '2026-01-16 17:24:24'),
(524, 1, 'compliance_logs', 'Access', 'Success', '2026-01-16 17:25:47'),
(525, 1, 'Disbursement Tracker', 'Access', '', '2026-01-16 17:25:48'),
(526, 1, 'compliance_logs', 'Access', 'Success', '2026-01-16 17:26:00'),
(527, 1, 'role_permissions', 'Access', 'Success', '2026-01-16 17:26:11'),
(528, 1, 'role_permissions', 'Access', 'Success', '2026-01-16 17:26:18'),
(529, 1, 'permission_logs', 'Access', 'Success', '2026-01-16 17:46:05'),
(530, 1, 'permission_logs', 'Access', '', '2026-01-16 17:46:27'),
(531, 1, 'compliance_logs', 'Access', '', '2026-01-16 17:47:41'),
(532, 1, 'Disbursement Tracker', 'Access', '', '2026-01-16 17:47:43'),
(533, 1, 'savings_monitoring', 'Access', '', '2026-01-16 17:47:45'),
(534, 1, 'compliance_logs', 'Access', '', '2026-01-16 17:49:36'),
(535, 1, 'compliance_logs', 'Access', '', '2026-01-16 17:49:40'),
(536, 1, 'compliance_logs', 'Access', '', '2026-01-16 17:52:36'),
(537, 1, 'Disbursement Tracker', 'Access', '', '2026-01-16 17:52:38'),
(538, 1, 'savings_monitoring', 'Access', '', '2026-01-16 17:52:41'),
(539, 1, 'Repayment_Tracker', 'Access', '', '2026-01-16 17:52:42'),
(540, 1, 'permission_logs', 'Access', '', '2026-01-16 17:52:50'),
(541, 1, 'permission_logs', 'Access', '', '2026-01-16 17:57:45'),
(542, 1, 'compliance_logs', 'Access', '', '2026-01-16 17:57:46'),
(543, 1, 'Disbursement Tracker', 'Access', '', '2026-01-16 17:57:48'),
(544, 1, 'savings_monitoring', 'Access', '', '2026-01-16 17:57:50'),
(545, 1, 'Repayment_Tracker', 'Access', '', '2026-01-16 17:57:52'),
(546, 1, 'Repayment_Tracker', 'Access', '', '2026-01-16 17:57:54'),
(547, 1, 'compliance_logs', 'Access', 'Success', '2026-01-16 17:58:06'),
(548, 1, 'Disbursement Tracker', 'Access', '', '2026-01-16 17:58:07'),
(549, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-16 17:58:09'),
(550, 1, 'Repayment_Tracker', 'Access', 'Success', '2026-01-16 17:58:11'),
(551, 1, 'permission_logs', 'Access', 'Success', '2026-01-16 17:58:18'),
(552, 1, 'permission_logs', 'Access', 'Success', '2026-01-16 17:59:31'),
(553, 1, 'compliance_logs', 'Access', 'Success', '2026-01-16 18:00:57'),
(554, 1, 'Disbursement Tracker', 'Access', '', '2026-01-16 18:00:59'),
(555, 1, 'Repayment_Tracker', 'Access', 'Success', '2026-01-16 18:03:45'),
(556, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-16 18:03:47'),
(557, 1, 'Disbursement Tracker', 'Access', '', '2026-01-16 18:03:47'),
(558, 1, 'compliance_logs', 'Access', 'Success', '2026-01-16 18:03:50'),
(559, 1, 'permission_logs', 'Access', 'Success', '2026-01-16 18:03:52'),
(560, 1, 'Repayment_Tracker', 'Access', 'Success', '2026-01-16 18:05:52'),
(561, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-16 18:05:53'),
(562, 1, 'Disbursement Tracker', 'Access', '', '2026-01-16 18:05:54'),
(563, 1, 'Disbursement Tracker', 'Access', '', '2026-01-16 18:06:26'),
(564, 1, 'Disbursement Tracker', 'Access', '', '2026-01-16 18:06:28'),
(565, 1, 'Disbursement Tracker', 'Access', '', '2026-01-16 18:06:38'),
(566, 1, 'Disbursement Tracker', 'Access', '', '2026-01-16 18:08:21'),
(567, 1, 'disbursement Tracker', 'Access', '', '2026-01-16 18:09:19'),
(568, 1, 'disbursement Tracker', 'Access', '', '2026-01-16 18:09:23'),
(569, 1, 'Disbursement Tracker', 'Access', '', '2026-01-16 18:10:09'),
(570, 1, 'Disbursement Tracker', 'Access', '', '2026-01-16 18:10:45'),
(571, 1, 'compliance_logs', 'Access', 'Success', '2026-01-16 18:10:46'),
(572, 1, 'compliance_logs', 'Access', 'Success', '2026-01-16 18:11:53'),
(573, 1, 'Disbursement Tracker', 'Access', '', '2026-01-16 18:11:54'),
(574, 1, 'compliance_logs', 'Access', '', '2026-01-16 18:13:06'),
(575, 1, 'Disbursement Tracker', 'Access', '', '2026-01-16 18:13:08'),
(576, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-16 18:14:00'),
(577, 1, 'compliance_logs', 'Access', 'Success', '2026-01-16 18:14:01'),
(578, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-16 18:14:03'),
(579, 1, 'permission_logs', 'Access', 'Success', '2026-01-16 18:14:07'),
(580, 1, 'permission_logs', 'Access', 'Success', '2026-01-16 18:14:54'),
(581, 1, 'permission_logs', 'Access', 'Success', '2026-01-16 18:16:34'),
(582, 1, 'role_permissions', 'Access', 'Success', '2026-01-16 18:16:35'),
(583, 1, 'role_permissions', 'Access', 'Success', '2026-01-16 18:16:36'),
(584, 1, 'role_permissions', 'Access', 'Success', '2026-01-16 18:16:38'),
(585, 1, 'role_permissions', 'Access', 'Success', '2026-01-16 18:16:39'),
(586, 1, 'role_permissions', 'Access', 'Success', '2026-01-16 18:16:41'),
(587, 1, 'role_permissions', 'Access', 'Success', '2026-01-16 18:17:03'),
(588, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-16 18:18:03'),
(589, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-16 18:18:27'),
(590, 1, 'role_permissions', 'Access', 'Success', '2026-01-16 18:18:29'),
(591, 1, 'permission_logs', 'Access', 'Success', '2026-01-16 18:18:30'),
(592, 1, 'role_permissions', 'Access', 'Success', '2026-01-16 18:18:31'),
(593, 1, 'compliance_logs', 'Access', 'Success', '2026-01-16 18:18:32'),
(594, 1, 'compliance_logs', 'Access', 'Success', '2026-01-16 18:18:33'),
(595, 1, 'role_permissions', 'Access', 'Success', '2026-01-16 18:18:38'),
(596, 1, 'role_permissions', 'Access', 'Success', '2026-01-16 18:19:28'),
(597, 1, 'role_permissions', 'Access', 'Success', '2026-01-16 18:20:10'),
(598, 1, 'compliance_logs', 'Access', 'Success', '2026-01-16 18:20:18'),
(599, 1, 'role_permissions', 'Access', 'Success', '2026-01-16 18:20:19'),
(600, 1, 'role_permissions', 'Access', 'Success', '2026-01-16 18:20:20'),
(601, 1, 'compliance_logs', 'Access', 'Success', '2026-01-16 18:20:21'),
(602, 1, 'compliance_logs', 'Access', 'Success', '2026-01-16 18:20:52'),
(603, 1, 'compliance_logs', 'Access', 'Success', '2026-01-16 18:22:20'),
(604, 1, 'permission_logs', 'Access', 'Success', '2026-01-16 18:23:32'),
(605, 1, 'role_permissions', 'Access', 'Success', '2026-01-16 18:23:32'),
(606, 1, 'role_permissions', 'Access', 'Success', '2026-01-16 18:23:33'),
(607, 1, 'compliance_logs', 'Access', 'Success', '2026-01-16 18:23:35'),
(608, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-16 18:23:36'),
(609, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-16 18:23:38'),
(610, 1, 'Repayment_Tracker', 'Access', 'Success', '2026-01-16 18:23:39'),
(611, 1, 'compliance_logs', 'Access', 'Success', '2026-01-16 18:24:59'),
(612, 1, 'compliance_logs', 'Access', 'Success', '2026-01-16 18:25:18'),
(613, 1, 'compliance_logs', 'Access', 'Success', '2026-01-16 18:25:54'),
(614, 1, 'compliance_logs', 'Access', 'Success', '2026-01-16 18:25:56'),
(615, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-16 18:25:57'),
(616, 1, 'Repayment_Tracker', 'Access', 'Success', '2026-01-16 18:25:57'),
(617, 1, 'compliance_logs', 'Access', 'Success', '2026-01-16 18:25:59'),
(618, 1, 'compliance_logs', 'Access', 'Success', '2026-01-16 18:27:37'),
(619, 1, 'compliance_logs', 'Access', 'Success', '2026-01-16 18:28:17'),
(620, 1, 'role_permissions', 'Access', 'Success', '2026-01-16 18:28:22'),
(621, 1, 'permission_logs', 'Access', 'Success', '2026-01-16 18:28:25'),
(622, 1, 'Repayment_Tracker', 'Access', 'Success', '2026-01-17 09:53:49'),
(623, 1, 'Repayment_Tracker', 'Access', 'Success', '2026-01-17 09:56:24'),
(624, 1, 'Repayment_Tracker', 'Access', 'Success', '2026-01-17 09:56:27'),
(625, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-17 09:56:32'),
(626, 1, 'Repayment_Tracker', 'Access', 'Success', '2026-01-17 09:56:36'),
(627, 1, 'role_permissions', 'Access', 'Success', '2026-01-17 09:57:31'),
(628, 1, 'permission_logs', 'Access', 'Success', '2026-01-17 09:57:36'),
(629, 1, 'role_permissions', 'Access', 'Success', '2026-01-17 09:57:55'),
(630, 1, 'permission_logs', 'Access', 'Success', '2026-01-17 09:57:58'),
(631, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-17 09:58:49'),
(632, 1, 'Repayment_Tracker', 'Access', 'Success', '2026-01-17 09:59:18'),
(633, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-17 10:00:05'),
(634, 1, 'Repayment_Tracker', 'Access', 'Success', '2026-01-17 10:00:05'),
(635, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-17 10:00:06'),
(636, 1, 'Repayment_Tracker', 'Access', 'Success', '2026-01-17 10:00:12'),
(637, 1, 'compliance_logs', 'Access', 'Success', '2026-01-17 10:00:20'),
(638, 1, 'permission_logs', 'Access', 'Success', '2026-01-17 10:03:30'),
(639, 1, 'role_permissions', 'Access', 'Success', '2026-01-17 10:06:04'),
(640, 1, 'Repayment_Tracker', 'Access', 'Success', '2026-01-17 10:12:20'),
(641, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-17 10:12:26'),
(642, 1, 'Repayment_Tracker', 'Access', 'Success', '2026-01-18 03:18:38'),
(643, 1, 'role_permissions', 'Access', 'Success', '2026-01-18 03:18:43'),
(644, 1, 'permission_logs', 'Access', 'Success', '2026-01-18 03:18:44'),
(645, 1, 'compliance_logs', 'Access', 'Success', '2026-01-18 03:18:47'),
(646, 1, 'role_permissions', 'Access', 'Success', '2026-01-18 03:51:14'),
(647, 1, 'role_permissions', 'Access', 'Success', '2026-01-18 03:51:19'),
(648, 1, 'permission_logs', 'Access', 'Success', '2026-01-18 03:51:21'),
(649, 1, 'permission_logs', 'Access', 'Success', '2026-01-18 03:52:07'),
(650, 1, 'role_permissions', 'Access', 'Success', '2026-01-18 03:54:32'),
(651, 1, 'permission_logs', 'Access', 'Success', '2026-01-18 03:54:33'),
(652, 1, 'Repayment_Tracker', 'Access', 'Success', '2026-01-18 03:54:38'),
(653, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-18 03:54:38'),
(654, 1, 'permission_logs', 'Access', 'Success', '2026-01-18 03:54:45'),
(655, 1, 'permission_logs', 'Access', 'Success', '2026-01-18 03:55:07'),
(656, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-18 03:55:14'),
(657, 1, 'Repayment_Tracker', 'Access', 'Success', '2026-01-18 03:55:15'),
(658, 1, 'Repayment_Tracker', 'Access', 'Success', '2026-01-18 03:55:30'),
(659, 1, 'Repayment_Tracker', 'Access', 'Success', '2026-01-18 03:55:46'),
(660, 1, 'Repayment_Tracker', 'Access', 'Success', '2026-01-18 03:56:04'),
(661, 1, 'role_permissions', 'Access', 'Success', '2026-01-18 03:56:18'),
(662, 1, 'role_permissions', 'Access', 'Success', '2026-01-18 03:56:33'),
(663, 1, 'role_permissions', 'Access', 'Success', '2026-01-18 03:57:43'),
(664, 1, 'permission_logs', 'Access', 'Success', '2026-01-18 03:57:43'),
(665, 1, 'permission_logs', 'Access', 'Success', '2026-01-18 03:59:20'),
(666, 1, 'Repayment_Tracker', 'Access', 'Success', '2026-01-18 04:00:31'),
(667, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-18 04:00:32'),
(668, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-18 04:00:33'),
(669, 1, 'compliance_logs', 'Access', 'Success', '2026-01-18 04:00:35'),
(670, 1, 'permission_logs', 'Access', 'Success', '2026-01-18 04:00:36'),
(671, 1, 'role_permissions', 'Access', 'Success', '2026-01-18 04:00:37'),
(672, 1, 'permission_logs', 'Access', 'Success', '2026-01-18 04:08:06'),
(673, 1, 'Repayment_Tracker', 'Access', 'Success', '2026-01-18 04:08:32'),
(674, 1, 'role_permissions', 'Access', 'Success', '2026-01-18 04:08:47'),
(675, 1, 'compliance_logs', 'Access', 'Success', '2026-01-18 04:24:33'),
(676, 1, 'role_permissions', 'Access', 'Success', '2026-01-18 04:34:09'),
(677, 1, 'permission_logs', 'Access', 'Success', '2026-01-18 04:34:23'),
(678, 1, 'compliance_logs', 'Access', 'Success', '2026-01-18 04:34:28'),
(679, 1, 'compliance_logs', 'Access', 'Success', '2026-01-18 04:34:54'),
(680, 1, 'compliance_logs', 'Access', 'Success', '2026-01-18 04:34:56'),
(681, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-18 04:34:58'),
(682, 1, 'Repayment_Tracker', 'Access', 'Success', '2026-01-18 04:35:01'),
(683, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-18 04:35:02'),
(684, 1, 'Repayment_Tracker', 'Access', 'Success', '2026-01-18 04:35:05'),
(685, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-18 04:35:16'),
(686, 1, 'Repayment_Tracker', 'Access', 'Success', '2026-01-18 04:35:23'),
(687, 1, 'Repayment_Tracker', 'Access', 'Success', '2026-01-18 04:36:16'),
(688, 1, 'role_permissions', 'Access', 'Success', '2026-01-18 04:36:17'),
(689, 1, 'permission_logs', 'Access', 'Success', '2026-01-18 04:36:20'),
(690, 1, 'compliance_logs', 'Access', 'Success', '2026-01-18 04:36:21'),
(691, 1, 'role_permissions', 'Access', 'Success', '2026-01-18 04:36:25'),
(692, 1, 'role_permissions', 'Access', 'Success', '2026-01-18 04:36:30'),
(693, 1, 'compliance_logs', 'Access', 'Success', '2026-01-18 04:38:22'),
(694, 1, 'role_permissions', 'Access', 'Success', '2026-01-18 05:22:57'),
(695, 1, 'Repayment_Tracker', 'Access', 'Success', '2026-01-18 05:37:21');
INSERT INTO `permission_logs` (`log_id`, `user_id`, `module_name`, `action_name`, `action_status`, `action_time`) VALUES
(696, 1, 'role_permissions', 'Access', 'Success', '2026-01-18 05:37:22'),
(697, 1, 'permission_logs', 'Access', 'Success', '2026-01-18 06:45:23'),
(698, 1, 'role_permissions', 'Access', 'Success', '2026-01-18 06:45:25'),
(699, 1, 'role_permissions', 'Access', 'Success', '2026-01-18 06:45:26'),
(700, 1, 'compliance_logs', 'Access', 'Success', '2026-01-18 06:45:32'),
(701, 1, 'permission_logs', 'Access', 'Success', '2026-01-18 06:45:42'),
(702, 5, 'permission_logs', 'Access', '', '2026-01-18 06:46:37'),
(703, 5, 'compliance_logs', 'Access', 'Success', '2026-01-18 06:54:22'),
(704, 5, 'compliance_logs', 'Access', 'Success', '2026-01-18 06:54:25'),
(705, 5, 'Disbursement Tracker', 'Access', '', '2026-01-18 06:54:26'),
(706, 5, 'Disbursement Tracker', 'Access', '', '2026-01-18 06:54:30'),
(707, 5, 'Disbursement Tracker', 'Access', '', '2026-01-18 06:54:37'),
(708, 5, 'compliance_logs', 'Access', 'Success', '2026-01-18 06:54:51'),
(709, 5, 'Disbursement Tracker', 'Access', '', '2026-01-18 06:54:53'),
(710, 5, 'compliance_logs', 'Access', 'Success', '2026-01-18 06:56:05'),
(711, 5, 'Disbursement Tracker', 'Access', '', '2026-01-18 06:57:03'),
(712, 5, 'Repayment_Tracker', 'Access', 'Success', '2026-01-18 06:57:08'),
(713, 5, 'savings_monitoring', 'Access', 'Success', '2026-01-18 06:57:09'),
(714, 5, 'Disbursement Tracker', 'Access', '', '2026-01-18 06:57:10'),
(715, 5, 'Disbursement Tracker', 'Access', '', '2026-01-18 06:57:47'),
(716, 5, 'compliance_logs', 'Access', 'Success', '2026-01-18 06:57:50'),
(717, 5, 'Disbursement Tracker', 'Access', '', '2026-01-18 06:57:51'),
(718, 5, 'permission_logs', 'Access', '', '2026-01-18 06:58:31'),
(719, 1, 'compliance_logs', 'Access', 'Success', '2026-01-18 06:59:35'),
(720, 1, 'permission_logs', 'Access', 'Success', '2026-01-18 06:59:49'),
(721, 1, 'role_permissions', 'Access', 'Success', '2026-01-18 06:59:53'),
(722, 1, 'role_permissions', 'Access', 'Success', '2026-01-18 07:00:02'),
(723, 1, 'compliance_logs', 'Access', 'Success', '2026-01-18 07:00:05'),
(724, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-18 07:00:09'),
(725, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-18 07:00:16'),
(726, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-18 07:01:40'),
(727, 1, 'role_permissions', 'Access', 'Success', '2026-01-18 07:03:08'),
(728, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-18 07:11:10'),
(729, 1, 'Repayment_Tracker', 'Access', 'Success', '2026-01-18 07:11:27'),
(730, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-18 07:11:30'),
(731, 1, 'Repayment_Tracker', 'Access', 'Success', '2026-01-18 07:11:32'),
(732, 1, 'compliance_logs', 'Access', 'Success', '2026-01-18 07:12:10'),
(733, 1, 'role_permissions', 'Access', 'Success', '2026-01-18 07:12:54'),
(734, 1, 'permission_logs', 'Access', 'Success', '2026-01-18 07:13:17'),
(735, 1, 'compliance_logs', 'Access', 'Success', '2026-01-18 07:13:39'),
(736, 1, 'permission_logs', 'Access', 'Success', '2026-01-18 07:14:24'),
(737, 1, 'compliance_logs', 'Access', 'Success', '2026-01-18 07:14:25'),
(738, 1, 'Repayment_Tracker', 'Access', 'Success', '2026-01-18 07:15:18'),
(739, 1, 'Repayment_Tracker', 'Access', 'Success', '2026-01-18 07:16:22'),
(740, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-18 07:16:24'),
(741, 1, 'compliance_logs', 'Access', 'Success', '2026-01-18 07:16:28'),
(742, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-18 07:16:34'),
(743, 1, 'Repayment_Tracker', 'Access', 'Success', '2026-01-18 10:54:30'),
(744, 1, 'role_permissions', 'Access', 'Success', '2026-01-18 10:55:27'),
(745, 1, 'Repayment_Tracker', 'Access', 'Success', '2026-01-18 11:00:54'),
(746, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-18 11:00:54'),
(747, 1, 'compliance_logs', 'Access', 'Success', '2026-01-18 11:01:07'),
(748, 6, 'permission_logs', 'Access', '', '2026-01-18 11:03:08'),
(749, 6, 'permission_logs', 'Access', '', '2026-01-18 11:03:31'),
(750, 6, 'compliance_logs', 'Access', 'Success', '2026-01-18 11:03:39'),
(751, 6, 'Disbursement Tracker', 'Access', '', '2026-01-18 11:03:42'),
(752, 6, 'compliance_logs', 'Access', 'Success', '2026-01-18 11:03:44'),
(753, 6, 'Disbursement Tracker', 'Access', '', '2026-01-18 11:03:45'),
(754, 6, 'Disbursement Tracker', 'Access', '', '2026-01-18 11:03:58'),
(755, 6, 'Disbursement Tracker', 'Access', '', '2026-01-18 11:04:02'),
(756, 6, 'Disbursement Tracker', 'Access', '', '2026-01-18 11:04:47'),
(757, 6, 'Disbursement Tracker', 'Access', '', '2026-01-18 11:04:56'),
(758, 6, 'compliance_logs', 'Access', 'Success', '2026-01-18 11:05:42'),
(759, 6, 'Disbursement Tracker', 'Access', '', '2026-01-18 11:05:42'),
(760, 6, 'Disbursement Tracker', 'Access', '', '2026-01-18 11:05:50'),
(761, 6, 'savings_monitoring', 'Access', 'Success', '2026-01-18 11:06:04'),
(762, 6, 'Disbursement Tracker', 'Access', '', '2026-01-18 11:06:09'),
(763, 6, 'Repayment_Tracker', 'Access', 'Success', '2026-01-18 11:06:34'),
(764, 6, 'Repayment_Tracker', 'Access', 'Success', '2026-01-18 11:06:35'),
(765, 6, 'Repayment_Tracker', 'Access', 'Success', '2026-01-18 11:06:42'),
(766, 6, 'savings_monitoring', 'Access', 'Success', '2026-01-18 11:07:32'),
(767, 6, 'compliance_logs', 'Access', 'Success', '2026-01-18 11:07:34'),
(768, 6, 'Disbursement Tracker', 'Access', '', '2026-01-18 11:07:34'),
(769, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-18 11:12:15'),
(770, 1, 'compliance_logs', 'Access', 'Success', '2026-01-18 11:12:24'),
(771, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-18 11:12:25'),
(772, 1, 'permission_logs', 'Access', 'Success', '2026-01-18 11:13:27'),
(773, 1, 'role_permissions', 'Access', 'Success', '2026-01-18 11:13:53'),
(774, 1, 'compliance_logs', 'Access', 'Success', '2026-01-18 11:13:56'),
(775, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-18 11:13:57'),
(776, 1, 'Repayment_Tracker', 'Access', 'Success', '2026-01-18 11:14:05'),
(777, 1, 'compliance_logs', 'Access', 'Success', '2026-01-18 11:14:06'),
(778, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-18 11:14:07'),
(779, 1, 'compliance_logs', 'Access', 'Success', '2026-01-18 11:14:07'),
(780, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-18 11:14:25'),
(781, 1, 'Repayment_Tracker', 'Access', 'Success', '2026-01-18 11:17:47'),
(782, 1, 'Repayment_Tracker', 'Access', 'Success', '2026-01-18 11:17:47'),
(783, 1, 'Repayment_Tracker', 'Access', 'Success', '2026-01-18 11:20:17'),
(784, 1, 'Repayment_Tracker', 'Access', 'Success', '2026-01-18 11:38:20'),
(785, 1, 'permission_logs', 'Access', 'Success', '2026-01-18 11:40:31'),
(786, 1, 'role_permissions', 'Access', 'Success', '2026-01-18 11:40:32'),
(787, 1, 'compliance_logs', 'Access', 'Success', '2026-01-18 11:40:36'),
(788, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-18 11:40:41'),
(789, 1, 'Repayment_Tracker', 'Access', 'Success', '2026-01-18 11:40:42'),
(790, 1, 'Repayment_Tracker', 'Access', 'Success', '2026-01-18 11:43:44'),
(791, 1, 'role_permissions', 'Access', 'Success', '2026-01-18 11:45:50'),
(792, 1, 'role_permissions', 'Access', 'Success', '2026-01-18 11:45:52'),
(793, 1, 'permission_logs', 'Access', 'Success', '2026-01-18 11:46:34'),
(794, 1, 'compliance_logs', 'Access', 'Success', '2026-01-18 11:50:27'),
(795, 1, 'Repayment_Tracker', 'Access', 'Success', '2026-01-18 11:51:26'),
(796, 1, 'Repayment_Tracker', 'Access', 'Success', '2026-01-18 11:53:08'),
(797, 1, 'compliance_logs', 'Access', 'Success', '2026-01-18 11:54:19'),
(798, 1, 'compliance_logs', 'Access', 'Success', '2026-01-18 11:54:31'),
(799, 1, 'role_permissions', 'Access', 'Success', '2026-01-18 11:54:32'),
(800, 1, 'permission_logs', 'Access', 'Success', '2026-01-18 11:54:32'),
(801, 1, 'compliance_logs', 'Access', 'Success', '2026-01-18 11:54:35'),
(802, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-18 11:54:36'),
(803, 1, 'Repayment_Tracker', 'Access', 'Success', '2026-01-18 11:54:36'),
(804, 1, 'compliance_logs', 'Access', 'Success', '2026-01-18 11:54:39'),
(805, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-18 11:54:48'),
(806, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-19 17:21:06'),
(807, 1, 'Repayment_Tracker', 'Access', 'Success', '2026-01-19 17:21:06'),
(808, 1, 'Repayment_Tracker', 'Access', 'Success', '2026-01-19 17:35:58'),
(809, 1, 'Repayment_Tracker', 'Access', 'Success', '2026-01-19 17:36:07'),
(810, 1, 'Repayment_Tracker', 'Access', 'Success', '2026-01-19 17:36:51'),
(811, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-19 17:37:35'),
(812, 1, 'compliance_logs', 'Access', 'Success', '2026-01-19 17:37:41'),
(813, 1, 'compliance_logs', 'Access', 'Success', '2026-01-19 17:37:42'),
(814, 1, 'compliance_logs', 'Access', 'Success', '2026-01-19 17:37:43'),
(815, 1, 'role_permissions', 'Access', 'Success', '2026-01-19 17:37:51'),
(816, 1, 'permission_logs', 'Access', 'Success', '2026-01-19 17:37:52'),
(817, 1, 'compliance_logs', 'Access', 'Success', '2026-01-19 17:37:55'),
(818, 1, 'Repayment_Tracker', 'Access', 'Success', '2026-01-19 17:37:56'),
(819, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-19 17:37:57'),
(820, 1, 'Repayment_Tracker', 'Access', 'Success', '2026-01-19 17:37:59'),
(821, 1, 'Repayment_Tracker', 'Access', 'Success', '2026-01-19 17:39:40'),
(822, 1, 'Repayment_Tracker', 'Access', 'Success', '2026-01-19 17:39:44'),
(823, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-19 17:40:04'),
(824, 1, 'compliance_logs', 'Access', 'Success', '2026-01-19 17:40:06'),
(825, 1, 'compliance_logs', 'Access', 'Success', '2026-01-19 17:40:43'),
(826, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-19 17:40:44'),
(827, 1, 'Repayment_Tracker', 'Access', 'Success', '2026-01-19 17:40:44'),
(828, 1, 'Repayment_Tracker', 'Access', 'Success', '2026-01-19 17:40:44'),
(829, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-19 17:40:44'),
(830, 1, 'Repayment_Tracker', 'Access', 'Success', '2026-01-19 17:40:45'),
(831, 1, 'compliance_logs', 'Access', 'Success', '2026-01-19 17:40:45'),
(832, 1, 'permission_logs', 'Access', 'Success', '2026-01-19 17:40:45'),
(833, 1, 'role_permissions', 'Access', 'Success', '2026-01-19 17:40:45'),
(834, 1, 'compliance_logs', 'Access', 'Success', '2026-01-19 17:40:46'),
(835, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-19 17:40:46'),
(836, 1, 'Repayment_Tracker', 'Access', 'Success', '2026-01-19 17:40:46'),
(837, 1, 'Repayment_Tracker', 'Access', 'Success', '2026-01-19 17:40:47'),
(838, 1, 'Repayment_Tracker', 'Access', 'Success', '2026-01-19 17:40:47'),
(839, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-19 17:40:47'),
(840, 1, 'compliance_logs', 'Access', 'Success', '2026-01-19 17:41:44'),
(841, 1, 'permission_logs', 'Access', 'Success', '2026-01-19 17:41:48'),
(842, 1, 'compliance_logs', 'Access', 'Success', '2026-01-19 17:42:36'),
(843, 1, 'role_permissions', 'Access', 'Success', '2026-01-19 17:42:38'),
(844, 1, 'permission_logs', 'Access', 'Success', '2026-01-19 17:42:39'),
(845, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-19 17:42:43'),
(846, 1, 'Repayment_Tracker', 'Access', 'Success', '2026-01-19 17:42:43'),
(847, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-19 17:52:42'),
(848, 1, 'Repayment_Tracker', 'Access', 'Success', '2026-01-19 17:52:42'),
(849, 1, 'Repayment_Tracker', 'Access', 'Success', '2026-01-19 18:05:29'),
(850, 1, 'Repayment_Tracker', 'Access', 'Success', '2026-01-19 18:05:31'),
(851, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-19 18:05:44'),
(852, 1, 'Repayment_Tracker', 'Access', 'Success', '2026-01-19 18:05:45'),
(853, 1, 'Repayment_Tracker', 'Access', 'Success', '2026-01-19 18:05:52'),
(854, 1, 'Repayment_Tracker', 'Access', 'Success', '2026-01-19 18:06:30'),
(855, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-19 18:06:33'),
(856, 1, 'Repayment_Tracker', 'Access', 'Success', '2026-01-19 18:06:33'),
(857, 1, 'compliance_logs', 'Access', 'Success', '2026-01-19 18:06:36'),
(858, 1, 'compliance_logs', 'Access', 'Success', '2026-01-19 18:27:38'),
(859, 1, 'permission_logs', 'Access', 'Success', '2026-01-19 18:27:42'),
(860, 1, 'compliance_logs', 'Access', 'Success', '2026-01-19 18:45:50'),
(861, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-19 18:45:55'),
(862, 1, 'Repayment_Tracker', 'Access', 'Success', '2026-01-19 18:45:56'),
(863, 1, 'Repayment_Tracker', 'Access', 'Success', '2026-01-19 18:45:58'),
(864, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-19 18:45:58'),
(865, 1, 'compliance_logs', 'Access', 'Success', '2026-01-19 18:46:02'),
(866, 1, 'permission_logs', 'Access', 'Success', '2026-01-19 18:46:05'),
(867, 1, 'Repayment_Tracker', 'Access', 'Success', '2026-01-19 18:46:09'),
(868, 1, 'Repayment_Tracker', 'Access', 'Success', '2026-01-19 18:46:51'),
(869, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-19 18:46:53'),
(870, 1, 'compliance_logs', 'Access', 'Success', '2026-01-19 18:46:56'),
(871, 1, 'role_permissions', 'Access', 'Success', '2026-01-19 18:46:58'),
(872, 1, 'permission_logs', 'Access', 'Success', '2026-01-19 18:46:59'),
(873, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-19 18:47:15'),
(874, 1, 'Repayment_Tracker', 'Access', 'Success', '2026-01-19 18:47:16'),
(875, 1, 'compliance_logs', 'Access', 'Success', '2026-01-19 18:47:17'),
(876, 1, 'compliance_logs', 'Access', 'Success', '2026-01-19 18:47:27'),
(877, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-19 18:47:28'),
(878, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-19 18:47:28'),
(879, 1, 'role_permissions', 'Access', 'Success', '2026-01-19 18:58:17'),
(880, 1, 'compliance_logs', 'Access', 'Success', '2026-01-19 18:58:23'),
(881, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-19 18:58:26'),
(882, 1, 'Repayment_Tracker', 'Access', 'Success', '2026-01-19 18:58:27'),
(883, 1, 'Repayment_Tracker', 'Access', 'Success', '2026-01-19 19:00:18'),
(884, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-19 19:00:20'),
(885, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-19 19:00:22'),
(886, 1, 'role_permissions', 'Access', 'Success', '2026-01-19 19:00:23'),
(887, 1, 'permission_logs', 'Access', 'Success', '2026-01-19 19:00:23'),
(888, 1, 'permission_logs', 'Access', 'Success', '2026-01-19 19:00:24'),
(889, 1, 'Repayment_Tracker', 'Access', 'Success', '2026-01-19 19:02:48'),
(890, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-19 19:02:48'),
(891, 1, 'compliance_logs', 'Access', 'Success', '2026-01-19 19:02:50'),
(892, 1, 'role_permissions', 'Access', 'Success', '2026-01-19 19:02:51'),
(893, 1, 'permission_logs', 'Access', 'Success', '2026-01-19 19:02:52'),
(894, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-19 19:23:56'),
(895, 1, 'Repayment_Tracker', 'Access', 'Success', '2026-01-19 19:23:57'),
(896, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-19 19:23:57'),
(897, 1, 'compliance_logs', 'Access', 'Success', '2026-01-19 19:23:58'),
(898, 1, 'permission_logs', 'Access', 'Success', '2026-01-19 19:23:59'),
(899, 1, 'permission_logs', 'Access', 'Success', '2026-01-19 19:24:00'),
(900, 1, 'role_permissions', 'Access', 'Success', '2026-01-19 19:24:00'),
(901, 1, 'Repayment_Tracker', 'Access', 'Success', '2026-01-19 19:40:41'),
(902, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-19 19:40:42'),
(903, 1, 'Repayment_Tracker', 'Access', 'Success', '2026-01-19 19:40:43'),
(904, 1, 'Repayment_Tracker', 'Access', 'Success', '2026-01-19 19:44:07'),
(905, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-19 19:44:07'),
(906, 1, 'compliance_logs', 'Access', 'Success', '2026-01-19 19:44:08'),
(907, 1, 'role_permissions', 'Access', 'Success', '2026-01-19 19:44:09'),
(908, 1, 'permission_logs', 'Access', 'Success', '2026-01-19 19:44:10'),
(909, 1, 'role_permissions', 'Access', 'Success', '2026-01-19 19:55:24'),
(910, 1, 'permission_logs', 'Access', 'Success', '2026-01-19 19:55:26'),
(911, 1, 'compliance_logs', 'Access', 'Success', '2026-01-19 19:55:28'),
(912, 1, 'permission_logs', 'Access', 'Success', '2026-01-19 19:56:57'),
(913, 1, 'role_permissions', 'Access', 'Success', '2026-01-19 19:56:58'),
(914, 1, 'permission_logs', 'Access', 'Success', '2026-01-19 19:57:00'),
(915, 1, 'role_permissions', 'Access', 'Success', '2026-01-19 19:57:01'),
(916, 1, 'Repayment_Tracker', 'Access', 'Success', '2026-01-19 19:58:46'),
(917, 1, 'compliance_logs', 'Access', 'Success', '2026-01-19 20:10:14'),
(918, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-19 20:10:43'),
(919, 1, 'compliance_logs', 'Access', 'Success', '2026-01-19 20:10:45'),
(920, 1, 'user_management', 'Access', 'Success', '2026-01-19 20:11:36'),
(921, 1, 'role_permissions', 'Access', 'Success', '2026-01-19 20:12:11'),
(922, 1, 'user_management', 'Access', 'Success', '2026-01-19 20:12:12'),
(923, 1, 'role_permissions', 'Access', 'Success', '2026-01-19 20:12:12'),
(924, 1, 'permission_logs', 'Access', 'Success', '2026-01-19 20:12:13'),
(925, 1, 'role_permissions', 'Access', 'Success', '2026-01-19 20:12:15'),
(926, 6, 'user_management', 'Access', '', '2026-01-19 20:19:37'),
(927, 6, 'user_management', 'Access', '', '2026-01-19 20:19:41'),
(928, 6, 'permission_logs', 'Access', '', '2026-01-19 20:19:45'),
(929, 6, 'compliance_logs', 'Access', 'Success', '2026-01-19 20:19:47'),
(930, 6, 'compliance_logs', 'Access', 'Success', '2026-01-19 20:19:53'),
(931, 6, 'Disbursement Tracker', 'Access', '', '2026-01-19 20:19:54'),
(932, 6, 'savings_monitoring', 'Access', 'Success', '2026-01-19 20:20:11'),
(933, 6, 'savings_monitoring', 'Access', 'Success', '2026-01-19 20:20:15'),
(934, 6, 'Repayment_Tracker', 'Access', 'Success', '2026-01-19 20:20:35'),
(935, 6, 'savings_monitoring', 'Access', 'Success', '2026-01-19 20:20:37'),
(936, 6, 'compliance_logs', 'Access', 'Success', '2026-01-19 20:20:52'),
(937, 6, 'compliance_logs', 'Access', '', '2026-01-19 20:21:06'),
(938, 6, 'compliance_logs', 'Access', '', '2026-01-19 20:21:09'),
(939, 6, 'Disbursement Tracker', 'Access', '', '2026-01-19 20:21:10'),
(940, 6, 'Repayment_Tracker', 'Access', 'Success', '2026-01-19 20:21:20'),
(941, 6, 'savings_monitoring', 'Access', 'Success', '2026-01-19 20:21:21'),
(942, 6, 'savings_monitoring', 'Access', 'Success', '2026-01-19 20:22:09'),
(943, 6, 'savings_monitoring', 'Access', 'Success', '2026-01-19 20:22:11'),
(944, 6, 'Repayment_Tracker', 'Access', 'Success', '2026-01-19 20:22:29'),
(945, 6, 'compliance_logs', 'Access', '', '2026-01-19 20:22:53'),
(946, 6, 'Disbursement Tracker', 'Access', '', '2026-01-19 20:22:55'),
(947, 6, 'Disbursement Tracker', 'Access', '', '2026-01-19 20:23:00'),
(948, 6, 'disbursement_tracker', 'Access', 'Success', '2026-01-19 20:23:34'),
(949, 6, 'disbursement_tracker', 'Access', 'Success', '2026-01-19 20:23:36'),
(950, 6, 'disbursement_tracker', 'Access', 'Success', '2026-01-19 20:23:37'),
(951, 6, 'savings_monitoring', 'Access', 'Success', '2026-01-19 20:23:40'),
(952, 6, 'disbursement_tracker', 'Access', 'Success', '2026-01-19 20:23:42'),
(953, 6, 'disbursement_tracker', 'Access', 'Success', '2026-01-19 20:24:56'),
(954, 6, 'savings_monitoring', 'Access', 'Success', '2026-01-19 20:24:58'),
(955, 6, 'compliance_logs', 'Access', '', '2026-01-19 20:25:00'),
(956, 6, 'disbursement_tracker', 'Access', 'Success', '2026-01-19 20:25:02'),
(957, 6, 'disbursement_tracker', 'Access', 'Success', '2026-01-19 20:25:37'),
(958, 6, 'savings_monitoring', 'Access', 'Success', '2026-01-19 20:25:38'),
(959, 6, 'savings_monitoring', 'Access', 'Success', '2026-01-19 20:25:42'),
(960, 6, 'Repayment_Tracker', 'Access', 'Success', '2026-01-19 20:26:09'),
(961, 6, 'disbursement_tracker', 'Access', 'Success', '2026-01-19 20:28:35'),
(962, 6, 'Repayment_Tracker', 'Access', 'Success', '2026-01-19 20:28:38'),
(963, 6, 'savings_monitoring', 'Access', 'Success', '2026-01-19 20:29:01'),
(964, 6, 'Repayment_Tracker', 'Access', 'Success', '2026-01-19 20:29:30'),
(965, 6, 'savings_monitoring', 'Access', 'Success', '2026-01-19 20:29:31'),
(966, 6, 'disbursement_tracker', 'Access', 'Success', '2026-01-19 20:29:37'),
(967, 6, 'savings_monitoring', 'Access', 'Success', '2026-01-19 20:29:41'),
(968, 6, 'Repayment_Tracker', 'Access', 'Success', '2026-01-19 20:29:47'),
(969, 6, 'user_management', 'Access', '', '2026-01-19 20:29:47'),
(970, 6, 'permission_logs', 'Access', '', '2026-01-19 20:29:52'),
(971, 1, 'Repayment_Tracker', 'Access', 'Success', '2026-01-19 20:30:07'),
(972, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-19 20:30:08'),
(973, 1, 'disbursement_tracker', 'Access', 'Success', '2026-01-19 20:30:08'),
(974, 1, 'compliance_logs', 'Access', 'Success', '2026-01-19 20:30:08'),
(975, 1, 'user_management', 'Access', 'Success', '2026-01-19 20:30:09'),
(976, 1, 'user_management', 'Access', 'Success', '2026-01-19 20:30:10'),
(977, 1, 'user_management', 'Access', 'Success', '2026-01-19 20:30:11'),
(978, 1, 'compliance_logs', 'Access', 'Success', '2026-01-19 20:30:12'),
(979, 1, 'user_management', 'Access', 'Success', '2026-01-19 20:30:15'),
(980, 1, 'user_management', 'Access', 'Success', '2026-01-19 20:30:17'),
(981, 1, 'role_permissions', 'Access', 'Success', '2026-01-19 20:30:18'),
(982, 1, 'permission_logs', 'Access', 'Success', '2026-01-19 20:30:19'),
(983, 1, 'role_permissions', 'Access', 'Success', '2026-01-19 20:30:33'),
(984, 1, 'role_permissions', 'Access', 'Success', '2026-01-19 20:31:03'),
(985, 1, 'role_permissions', 'Access', 'Success', '2026-01-19 20:31:06'),
(986, 1, 'role_permissions', 'Access', 'Success', '2026-01-19 20:31:06'),
(987, 1, 'user_management', 'Access', 'Success', '2026-01-19 20:31:08'),
(988, 1, 'role_permissions', 'Access', 'Success', '2026-01-19 20:31:08'),
(989, 1, 'role_permissions', 'Access', 'Success', '2026-01-19 20:31:24'),
(990, 1, 'disbursement_tracker', 'Access', 'Success', '2026-01-19 20:31:26'),
(991, 1, 'role_permissions', 'Access', 'Success', '2026-01-19 20:31:30'),
(992, 1, 'role_permissions', 'Access', 'Success', '2026-01-19 20:31:59'),
(993, 1, 'role_permissions', 'Access', 'Success', '2026-01-19 20:32:02'),
(994, 1, 'role_permissions', 'Access', 'Success', '2026-01-19 20:32:04'),
(995, 1, 'permission_logs', 'Access', 'Success', '2026-01-19 20:32:14'),
(996, 1, 'permission_logs', 'Access', 'Success', '2026-01-19 20:32:30'),
(997, 1, 'permission_logs', 'Access', 'Success', '2026-01-19 20:32:31'),
(998, 1, 'role_permissions', 'Access', 'Success', '2026-01-19 20:32:32'),
(999, 1, 'Repayment_Tracker', 'Access', 'Success', '2026-01-19 20:34:24'),
(1000, 1, 'role_permissions', 'Access', 'Success', '2026-01-19 20:35:26'),
(1001, 1, 'role_permissions', 'Access', 'Success', '2026-01-19 20:35:44'),
(1002, 1, 'compliance_logs', 'Access', 'Success', '2026-01-19 20:35:57'),
(1003, 1, 'user_management', 'Access', 'Success', '2026-01-19 20:35:58'),
(1004, 1, 'role_permissions', 'Access', 'Success', '2026-01-19 20:35:59'),
(1005, 1, 'role_permissions', 'Access', 'Success', '2026-01-19 20:36:15'),
(1006, 1, 'role_permissions', 'Access', 'Success', '2026-01-19 20:36:32'),
(1007, 1, 'role_permissions', 'Access', 'Success', '2026-01-19 20:36:37'),
(1008, 1, 'role_permissions', 'Access', 'Success', '2026-01-19 20:36:38'),
(1009, 1, 'Repayment_Tracker', 'Access', 'Success', '2026-01-19 20:42:13'),
(1010, 1, 'Repayment_Tracker', 'Access', 'Success', '2026-01-19 20:47:26'),
(1011, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-19 20:47:29'),
(1012, 1, 'disbursement_tracker', 'Access', 'Success', '2026-01-19 20:47:30'),
(1013, 1, 'compliance_logs', 'Access', 'Success', '2026-01-19 20:47:30'),
(1014, 1, 'user_management', 'Access', 'Success', '2026-01-19 20:47:31'),
(1015, 1, 'role_permissions', 'Access', 'Success', '2026-01-19 20:47:32'),
(1016, 1, 'permission_logs', 'Access', 'Success', '2026-01-19 20:47:32'),
(1017, 1, 'Repayment_Tracker', 'Access', 'Success', '2026-01-19 20:47:35'),
(1018, 1, 'Repayment_Tracker', 'Access', 'Success', '2026-01-20 17:52:31'),
(1019, 1, 'disbursement_tracker', 'Access', 'Success', '2026-01-20 17:52:32'),
(1020, 1, 'compliance_logs', 'Access', 'Success', '2026-01-20 17:52:32'),
(1021, 1, 'user_management', 'Access', 'Success', '2026-01-20 17:52:33'),
(1022, 1, 'permission_logs', 'Access', 'Success', '2026-01-20 17:52:33'),
(1023, 1, 'role_permissions', 'Access', 'Success', '2026-01-20 17:52:34'),
(1024, 1, 'permission_logs', 'Access', 'Success', '2026-01-20 17:52:38'),
(1025, 1, 'compliance_logs', 'Access', 'Success', '2026-01-20 17:52:50'),
(1026, 1, 'compliance_logs', 'Access', 'Success', '2026-01-20 18:04:59'),
(1027, 1, 'disbursement_tracker', 'Access', 'Success', '2026-01-20 18:05:01'),
(1028, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-20 18:05:02'),
(1029, 1, 'Repayment_Tracker', 'Access', 'Success', '2026-01-20 18:05:03'),
(1030, 1, 'user_management', 'Access', 'Success', '2026-01-20 18:19:35'),
(1031, 1, 'role_permissions', 'Access', 'Success', '2026-01-20 18:19:36'),
(1032, 1, 'permission_logs', 'Access', 'Success', '2026-01-20 18:19:36'),
(1033, 1, 'compliance_logs', 'Access', 'Success', '2026-01-20 18:19:38'),
(1034, 1, 'disbursement_tracker', 'Access', 'Success', '2026-01-20 18:19:39'),
(1035, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-20 18:19:39'),
(1036, 1, 'Repayment_Tracker', 'Access', 'Success', '2026-01-20 18:19:40'),
(1037, 1, 'Repayment_Tracker', 'Access', 'Success', '2026-01-20 18:21:21'),
(1038, 1, 'permission_logs', 'Access', 'Success', '2026-01-20 18:36:14'),
(1039, 1, 'role_permissions', 'Access', 'Success', '2026-01-20 18:36:16'),
(1040, 1, 'user_management', 'Access', 'Success', '2026-01-20 18:36:17'),
(1041, 1, 'compliance_logs', 'Access', 'Success', '2026-01-20 18:36:18'),
(1042, 1, 'disbursement_tracker', 'Access', 'Success', '2026-01-20 18:36:19'),
(1043, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-20 18:36:20'),
(1044, 1, 'Repayment_Tracker', 'Access', 'Success', '2026-01-20 18:36:21'),
(1045, 1, 'disbursement_tracker', 'Access', 'Success', '2026-01-20 18:36:31'),
(1046, 1, 'disbursement_tracker', 'Access', 'Success', '2026-01-20 18:36:39'),
(1047, 1, 'disbursement_tracker', 'Access', 'Success', '2026-01-20 18:36:40'),
(1048, 1, 'user_management', 'Access', 'Success', '2026-01-20 18:36:42'),
(1049, 1, 'compliance_logs', 'Access', 'Success', '2026-01-20 18:36:42'),
(1050, 1, 'compliance_logs', 'Access', 'Success', '2026-01-20 18:40:47'),
(1051, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-20 18:40:47'),
(1052, 1, 'compliance_logs', 'Access', 'Success', '2026-01-20 18:40:48'),
(1053, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-20 18:40:50'),
(1054, 1, 'Repayment_Tracker', 'Access', 'Success', '2026-01-20 18:40:51'),
(1055, 1, 'permission_logs', 'Access', 'Success', '2026-01-20 18:40:52'),
(1056, 1, 'role_permissions', 'Access', 'Success', '2026-01-20 18:40:52'),
(1057, 1, 'user_management', 'Access', 'Success', '2026-01-20 18:40:53'),
(1058, 1, 'role_permissions', 'Access', 'Success', '2026-01-20 18:40:54'),
(1059, 1, 'permission_logs', 'Access', 'Success', '2026-01-20 18:40:54'),
(1060, 1, 'permission_logs', 'Access', 'Success', '2026-01-20 18:41:00'),
(1061, 1, 'permission_logs', 'Access', 'Success', '2026-01-20 18:42:07'),
(1062, 1, 'disbursement_tracker', 'Access', 'Success', '2026-01-20 18:42:08'),
(1063, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-20 18:42:08'),
(1064, 1, 'Repayment_Tracker', 'Access', 'Success', '2026-01-20 18:42:09'),
(1065, 1, 'Repayment_Tracker', 'Access', 'Success', '2026-01-20 18:42:34'),
(1066, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-20 18:42:35'),
(1067, 1, 'disbursement_tracker', 'Access', 'Success', '2026-01-20 18:42:36'),
(1068, 1, 'compliance_logs', 'Access', 'Success', '2026-01-20 18:42:37'),
(1069, 1, 'user_management', 'Access', 'Success', '2026-01-20 18:42:38'),
(1070, 1, 'Repayment_Tracker', 'Access', 'Success', '2026-01-20 18:42:46'),
(1071, 1, 'disbursement_tracker', 'Access', 'Success', '2026-01-20 18:42:47'),
(1072, 1, 'disbursement_tracker', 'Access', 'Success', '2026-01-20 18:42:49'),
(1073, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-20 18:42:51'),
(1074, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-20 18:42:53'),
(1075, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-20 18:43:00'),
(1076, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-20 18:43:02'),
(1077, 1, 'compliance_logs', 'Access', 'Success', '2026-01-20 18:43:03'),
(1078, 1, 'user_management', 'Access', 'Success', '2026-01-20 18:43:03'),
(1079, 1, 'user_management', 'Access', 'Success', '2026-01-20 18:43:04'),
(1080, 1, 'user_management', 'Access', 'Success', '2026-01-20 18:43:04'),
(1081, 1, 'compliance_logs', 'Access', 'Success', '2026-01-20 18:43:17'),
(1082, 1, 'compliance_logs', 'Access', 'Success', '2026-01-20 18:43:24'),
(1083, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-20 18:43:25'),
(1084, 1, 'disbursement_tracker', 'Access', 'Success', '2026-01-20 18:43:25'),
(1085, 1, 'role_permissions', 'Access', 'Success', '2026-01-20 18:43:26'),
(1086, 1, 'user_management', 'Access', 'Success', '2026-01-20 18:43:27'),
(1087, 1, 'compliance_logs', 'Access', 'Success', '2026-01-20 18:46:33'),
(1088, 1, 'disbursement_tracker', 'Access', 'Success', '2026-01-20 18:46:34'),
(1089, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-20 18:46:35'),
(1090, 1, 'Repayment_Tracker', 'Access', 'Success', '2026-01-20 18:46:36'),
(1091, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-20 18:47:56'),
(1092, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-20 18:48:04'),
(1093, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-20 18:49:54'),
(1094, 1, 'disbursement_tracker', 'Access', 'Success', '2026-01-20 18:49:55'),
(1095, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-20 18:49:57'),
(1096, 1, 'Repayment_Tracker', 'Access', 'Success', '2026-01-20 18:49:57'),
(1097, 1, 'disbursement_tracker', 'Access', 'Success', '2026-01-20 18:49:58'),
(1098, 1, 'compliance_logs', 'Access', 'Success', '2026-01-20 18:50:00'),
(1099, 1, 'user_management', 'Access', 'Success', '2026-01-20 18:50:01'),
(1100, 1, 'role_permissions', 'Access', 'Success', '2026-01-20 18:50:02'),
(1101, 1, 'role_permissions', 'Access', 'Success', '2026-01-20 18:50:09'),
(1102, 1, 'role_permissions', 'Access', 'Success', '2026-01-20 18:51:44'),
(1103, 1, 'compliance_logs', 'Access', 'Success', '2026-01-20 18:51:45'),
(1104, 1, 'disbursement_tracker', 'Access', 'Success', '2026-01-20 18:51:46'),
(1105, 1, 'compliance_logs', 'Access', 'Success', '2026-01-20 18:51:48'),
(1106, 1, 'compliance_logs', 'Access', 'Success', '2026-01-20 18:53:32'),
(1107, 1, 'compliance_logs', 'Access', 'Success', '2026-01-20 18:55:22'),
(1108, 1, 'user_management', 'Access', 'Success', '2026-01-20 18:55:24'),
(1109, 1, 'compliance_logs', 'Access', 'Success', '2026-01-20 18:55:29'),
(1110, 1, 'compliance_logs', 'Access', 'Success', '2026-01-20 18:56:06'),
(1111, 1, 'user_management', 'Access', 'Success', '2026-01-20 18:56:07'),
(1112, 1, 'Repayment_Tracker', 'Access', 'Success', '2026-01-20 18:56:14'),
(1113, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-20 18:56:14'),
(1114, 1, 'disbursement_tracker', 'Access', 'Success', '2026-01-20 18:56:15'),
(1115, 1, 'disbursement_tracker', 'Access', 'Success', '2026-01-20 18:56:34'),
(1116, 1, 'compliance_logs', 'Access', 'Success', '2026-01-20 18:56:38'),
(1117, 1, 'Repayment_Tracker', 'Access', 'Success', '2026-01-21 11:33:38'),
(1118, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-21 11:34:27'),
(1119, 1, 'disbursement_tracker', 'Access', 'Success', '2026-01-21 11:34:47'),
(1120, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-21 11:34:50'),
(1121, 1, 'disbursement_tracker', 'Access', 'Success', '2026-01-21 11:34:52'),
(1122, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-21 11:34:54'),
(1123, 1, 'disbursement_tracker', 'Access', 'Success', '2026-01-21 11:34:54'),
(1124, 1, 'compliance_logs', 'Access', 'Success', '2026-01-21 11:34:55'),
(1125, 1, 'user_management', 'Access', 'Success', '2026-01-21 11:35:04'),
(1126, 1, 'role_permissions', 'Access', 'Success', '2026-01-21 11:35:13'),
(1127, 1, 'permission_logs', 'Access', 'Success', '2026-01-21 11:36:25'),
(1128, 1, 'permission_logs', 'Access', 'Success', '2026-01-21 11:37:02'),
(1129, 1, 'Repayment_Tracker', 'Access', 'Success', '2026-01-21 11:37:03'),
(1130, 1, 'Repayment_Tracker', 'Access', 'Success', '2026-01-21 11:37:39'),
(1131, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-21 11:37:40'),
(1132, 1, 'compliance_logs', 'Access', 'Success', '2026-01-21 11:37:41'),
(1133, 1, 'disbursement_tracker', 'Access', 'Success', '2026-01-21 11:37:41'),
(1134, 1, 'Repayment_Tracker', 'Access', 'Success', '2026-01-22 14:20:01'),
(1135, 1, 'Repayment_Tracker', 'Access', 'Success', '2026-01-22 14:30:04'),
(1136, 1, 'Repayment_Tracker', 'Access', 'Success', '2026-01-22 14:31:35'),
(1137, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-22 15:06:27'),
(1138, 1, 'disbursement_tracker', 'Access', 'Success', '2026-01-22 15:06:28'),
(1139, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-22 15:06:29'),
(1140, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-22 15:25:35'),
(1141, 1, 'disbursement_tracker', 'Access', 'Success', '2026-01-22 15:25:36'),
(1142, 1, 'disbursement_tracker', 'Access', 'Success', '2026-01-22 15:25:36'),
(1143, 1, 'compliance_logs', 'Access', 'Success', '2026-01-22 15:25:37'),
(1144, 1, 'user_management', 'Access', 'Success', '2026-01-22 15:25:37'),
(1145, 1, 'permission_logs', 'Access', 'Success', '2026-01-22 15:25:38'),
(1146, 1, 'role_permissions', 'Access', 'Success', '2026-01-22 15:25:39'),
(1147, 1, 'user_management', 'Access', 'Success', '2026-01-22 15:25:40'),
(1148, 1, 'role_permissions', 'Access', 'Success', '2026-01-22 15:25:41'),
(1149, 1, 'role_permissions', 'Access', 'Success', '2026-01-22 15:25:41'),
(1150, 1, 'permission_logs', 'Access', 'Success', '2026-01-22 15:25:41'),
(1151, 1, 'Repayment_Tracker', 'Access', 'Success', '2026-01-22 15:27:52'),
(1152, 1, 'Repayment_Tracker', 'Access', 'Success', '2026-01-22 15:28:06'),
(1153, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-22 15:29:04'),
(1154, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-22 15:29:13'),
(1155, 1, 'disbursement_tracker', 'Access', 'Success', '2026-01-22 15:29:14'),
(1156, 1, 'compliance_logs', 'Access', 'Success', '2026-01-22 15:29:16'),
(1157, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-24 09:41:34'),
(1158, 1, 'disbursement_tracker', 'Access', 'Success', '2026-01-24 09:41:38'),
(1159, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 09:41:40'),
(1160, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-24 10:06:57'),
(1161, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-24 10:36:22'),
(1162, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-24 10:36:23'),
(1163, 1, 'disbursement_tracker', 'Access', 'Success', '2026-01-24 10:36:23'),
(1164, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 10:36:24'),
(1165, 1, 'disbursement_tracker', 'Access', 'Success', '2026-01-24 10:36:24'),
(1166, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 10:36:26'),
(1167, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-24 10:36:28'),
(1168, 1, 'disbursement_tracker', 'Access', 'Success', '2026-01-24 10:36:28'),
(1169, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 10:36:29'),
(1170, 1, 'user_management', 'Access', 'Success', '2026-01-24 10:36:30'),
(1171, 1, 'role_permissions', 'Access', 'Success', '2026-01-24 10:36:31'),
(1172, 1, 'permission_logs', 'Access', 'Success', '2026-01-24 10:36:32'),
(1173, 1, 'permission_logs', 'Access', 'Success', '2026-01-24 10:36:32'),
(1174, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 10:36:33'),
(1175, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-24 10:36:38'),
(1176, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-24 10:40:23'),
(1177, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-24 10:40:26'),
(1178, 1, 'disbursement_tracker', 'Access', 'Success', '2026-01-24 10:40:56'),
(1179, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 10:40:57'),
(1180, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-24 10:40:58'),
(1181, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-24 10:41:02'),
(1182, 1, 'disbursement_tracker', 'Access', 'Success', '2026-01-24 10:46:01'),
(1183, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-24 10:57:17'),
(1184, 1, 'disbursement_tracker', 'Access', 'Success', '2026-01-24 10:58:55'),
(1185, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-24 10:58:56'),
(1186, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-24 10:59:42'),
(1187, 1, 'disbursement_tracker', 'Access', 'Success', '2026-01-24 11:00:09'),
(1188, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-24 11:00:15'),
(1189, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-24 11:00:27'),
(1190, 1, 'disbursement_tracker', 'Access', 'Success', '2026-01-24 11:00:29'),
(1191, 1, 'disbursement_tracker', 'Access', 'Success', '2026-01-24 11:00:46'),
(1192, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-24 11:00:54'),
(1193, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-24 11:01:07'),
(1194, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-24 11:01:15'),
(1195, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-24 11:11:04'),
(1196, 1, 'disbursement_tracker', 'Access', 'Success', '2026-01-24 11:11:06'),
(1197, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-24 11:20:46'),
(1198, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-24 11:31:11'),
(1199, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-24 11:31:23'),
(1200, 1, 'disbursement_tracker', 'Access', 'Success', '2026-01-24 11:31:30'),
(1201, 1, 'disbursement_tracker', 'Access', 'Success', '2026-01-24 11:31:36'),
(1202, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 11:31:37'),
(1203, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-24 11:31:40'),
(1204, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-24 11:31:47'),
(1205, 1, 'permission_logs', 'Access', 'Success', '2026-01-24 11:35:49'),
(1206, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-24 11:38:23'),
(1207, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-24 11:38:47'),
(1208, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-24 11:38:54'),
(1209, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-24 11:43:42'),
(1210, 1, 'user_management', 'Access', 'Success', '2026-01-24 11:47:20'),
(1211, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-24 11:47:31'),
(1212, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-24 11:57:38'),
(1213, 1, 'disbursement_tracker', 'Access', 'Success', '2026-01-24 11:57:39'),
(1214, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 11:57:39'),
(1215, 1, 'disbursement_tracker', 'Access', 'Success', '2026-01-24 11:57:40'),
(1216, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 11:57:41'),
(1217, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-24 15:02:09'),
(1218, 1, 'disbursement_tracker', 'Access', 'Success', '2026-01-24 15:02:13'),
(1219, 1, 'permission_logs', 'Access', 'Success', '2026-01-24 15:07:24'),
(1220, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 15:07:25'),
(1221, 1, 'disbursement_tracker', 'Access', 'Success', '2026-01-24 15:07:26'),
(1222, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-24 15:07:33'),
(1223, 1, 'disbursement_tracker', 'Access', 'Success', '2026-01-24 15:07:36'),
(1224, 1, 'disbursement_tracker', 'Access', 'Success', '2026-01-24 15:13:29'),
(1225, 1, 'disbursement_tracker', 'Access', 'Success', '2026-01-24 15:14:58'),
(1226, 1, 'disbursement_tracker', 'Access', 'Success', '2026-01-24 15:14:59'),
(1227, 1, 'disbursement_tracker', 'Access', 'Success', '2026-01-24 15:15:22'),
(1228, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-24 15:16:13'),
(1229, 1, 'disbursement_tracker', 'Access', 'Success', '2026-01-24 15:16:18'),
(1230, 1, 'disbursement_tracker', 'Access', 'Success', '2026-01-24 15:17:50'),
(1231, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-24 15:17:56'),
(1232, 1, 'disbursement_tracker', 'Access', 'Success', '2026-01-24 15:17:56'),
(1233, 1, 'disbursement_tracker', 'Access', 'Success', '2026-01-24 15:18:02'),
(1234, 1, 'disbursement_tracker', 'Access', 'Success', '2026-01-24 15:18:25'),
(1235, 1, 'disbursement_tracker', 'Access', 'Success', '2026-01-24 15:26:57'),
(1236, 1, 'disbursement_tracker', 'Access', 'Success', '2026-01-24 15:27:12'),
(1237, 1, 'disbursement_tracker', 'Access', 'Success', '2026-01-24 15:28:35'),
(1238, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-24 15:28:41'),
(1239, 1, 'disbursement_tracker', 'Access', 'Success', '2026-01-24 15:28:45'),
(1240, 1, 'disbursement_tracker', 'Access', 'Success', '2026-01-24 15:33:16'),
(1241, 1, 'disbursement_tracker', 'Access', 'Success', '2026-01-24 15:40:43'),
(1242, 1, 'disbursement_tracker', 'Access', 'Success', '2026-01-24 15:40:48'),
(1243, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-24 15:40:50'),
(1244, 1, 'disbursement_tracker', 'Access', 'Success', '2026-01-24 15:40:50'),
(1245, 1, 'disbursement_tracker', 'Access', 'Success', '2026-01-24 15:42:05'),
(1246, 1, 'disbursement_tracker', 'Access', 'Success', '2026-01-24 15:44:29'),
(1247, 1, 'disbursement_tracker', 'Access', 'Success', '2026-01-24 15:48:59'),
(1248, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 15:53:50'),
(1249, 1, 'disbursement_tracker', 'Access', 'Success', '2026-01-24 15:54:31'),
(1250, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-24 16:09:38'),
(1251, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-24 16:09:54'),
(1252, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-24 16:19:27'),
(1253, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 16:20:36'),
(1254, 1, 'permission_logs', 'Access', 'Success', '2026-01-24 16:20:40'),
(1255, 1, 'user_management', 'Access', 'Success', '2026-01-24 16:20:46'),
(1256, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 16:20:47'),
(1257, 1, 'user_management', 'Access', 'Success', '2026-01-24 16:32:07'),
(1258, 1, 'user_management', 'Access', 'Success', '2026-01-24 16:50:23'),
(1259, 1, 'user_management', 'Access', 'Success', '2026-01-24 16:50:25'),
(1260, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 16:50:26'),
(1261, 1, 'user_management', 'Access', 'Success', '2026-01-24 16:50:27'),
(1262, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 16:51:32'),
(1263, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-24 16:51:36'),
(1264, 1, 'permission_logs', 'Access', 'Success', '2026-01-24 16:51:38'),
(1265, 1, 'role_permissions', 'Access', 'Success', '2026-01-24 16:51:39'),
(1266, 1, 'user_management', 'Access', 'Success', '2026-01-24 16:51:39'),
(1267, 1, 'user_management', 'Access', 'Success', '2026-01-24 16:52:54'),
(1268, 1, 'role_permissions', 'Access', 'Success', '2026-01-24 16:53:24'),
(1269, 1, 'user_management', 'Access', 'Success', '2026-01-24 16:53:25'),
(1270, 1, 'user_management', 'Access', 'Success', '2026-01-24 16:53:40'),
(1271, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 16:53:44'),
(1272, 1, 'user_management', 'Access', 'Success', '2026-01-24 16:53:45'),
(1273, 1, 'user_management', 'Access', 'Success', '2026-01-24 16:53:53'),
(1274, 1, 'role_permissions', 'Access', 'Success', '2026-01-24 16:54:53'),
(1275, 1, 'user_management', 'Access', 'Success', '2026-01-24 16:54:54'),
(1276, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 16:54:54'),
(1277, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-24 16:54:57'),
(1278, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-24 16:56:27'),
(1279, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 16:56:36'),
(1280, 1, 'user_management', 'Access', 'Success', '2026-01-24 16:56:38'),
(1281, 1, 'role_permissions', 'Access', 'Success', '2026-01-24 16:56:39'),
(1282, 1, 'permission_logs', 'Access', 'Success', '2026-01-24 16:56:40'),
(1283, 6, 'user_management', 'Access', '', '2026-01-24 16:56:59'),
(1284, 6, 'user_management', 'Access', '', '2026-01-24 16:57:04'),
(1285, 6, 'permission_logs', 'Access', '', '2026-01-24 16:57:06'),
(1286, 6, 'compliance_logs', 'Access', '', '2026-01-24 16:57:08'),
(1287, 6, 'savings_monitoring', 'Access', 'Success', '2026-01-24 16:57:12'),
(1288, 6, 'savings_monitoring', 'Access', 'Success', '2026-01-24 16:57:18'),
(1289, 6, 'savings_monitoring', 'Access', 'Success', '2026-01-24 16:57:22'),
(1290, 1, 'user_management', 'Access', 'Success', '2026-01-24 16:57:45'),
(1291, 1, 'user_management', 'Access', 'Success', '2026-01-24 16:57:52'),
(1292, 1, 'user_management', 'Access', 'Success', '2026-01-24 16:58:18'),
(1293, 1, 'permission_logs', 'Access', 'Success', '2026-01-24 16:58:19'),
(1294, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-24 19:10:17'),
(1295, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 19:10:39'),
(1296, 1, 'user_management', 'Access', 'Success', '2026-01-24 19:10:50'),
(1297, 1, 'role_permissions', 'Access', 'Success', '2026-01-24 19:10:52'),
(1298, 1, 'permission_logs', 'Access', 'Success', '2026-01-24 19:10:52'),
(1299, 1, 'user_management', 'Access', 'Success', '2026-01-24 19:10:53'),
(1300, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-24 19:10:57'),
(1301, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 19:11:52'),
(1302, 1, 'user_management', 'Access', 'Success', '2026-01-24 19:12:01'),
(1303, 1, 'role_permissions', 'Access', 'Success', '2026-01-24 19:12:01'),
(1304, 1, 'permission_logs', 'Access', 'Success', '2026-01-24 19:12:02'),
(1305, 1, 'user_management', 'Access', 'Success', '2026-01-24 19:12:04'),
(1306, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 20:04:42'),
(1307, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 20:04:43'),
(1308, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 20:04:46'),
(1309, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 20:04:47'),
(1310, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 20:04:48'),
(1311, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 20:04:49'),
(1312, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 20:04:49'),
(1313, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 20:04:50'),
(1314, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 20:04:51'),
(1315, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 20:04:52'),
(1316, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 20:04:53'),
(1317, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 20:04:53'),
(1318, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 20:04:54'),
(1319, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 20:04:55'),
(1320, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 20:04:55'),
(1321, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 20:04:56'),
(1322, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 20:04:57'),
(1323, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 20:04:57'),
(1324, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 20:04:57'),
(1325, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 20:04:58'),
(1326, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 20:04:58'),
(1327, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 20:04:59'),
(1328, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 20:04:59'),
(1329, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 20:05:00'),
(1330, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 20:05:01'),
(1331, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 20:05:02'),
(1332, 1, 'permission_logs', 'Access', 'Success', '2026-01-24 20:05:16'),
(1333, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 20:05:19'),
(1334, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 20:05:19'),
(1335, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 20:11:32'),
(1336, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 20:11:32'),
(1337, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 20:11:38'),
(1338, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 20:11:39'),
(1339, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 20:11:47'),
(1340, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 20:11:51'),
(1341, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 20:12:13'),
(1342, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 20:12:39'),
(1343, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 20:12:46'),
(1344, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 20:12:51'),
(1345, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 20:13:05'),
(1346, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 20:13:07'),
(1347, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 20:13:11'),
(1348, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 20:13:13'),
(1349, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 20:13:15'),
(1350, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 20:13:17'),
(1351, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 20:13:19'),
(1352, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 20:14:00'),
(1353, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 20:14:01'),
(1354, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 20:14:04'),
(1355, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 20:15:26'),
(1356, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 20:15:27'),
(1357, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 20:15:27'),
(1358, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 20:15:27'),
(1359, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 20:15:27'),
(1360, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 20:15:28'),
(1361, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 20:15:31'),
(1362, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 20:15:31'),
(1363, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 20:15:32'),
(1364, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 20:15:32'),
(1365, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 20:16:19'),
(1366, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 20:16:19'),
(1367, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 20:16:20'),
(1368, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 20:17:43'),
(1369, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 20:17:43'),
(1370, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 20:17:45'),
(1371, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 20:17:46'),
(1372, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 20:17:46'),
(1373, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-24 20:17:50'),
(1374, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 20:18:00'),
(1375, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 20:18:00'),
(1376, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 20:18:01'),
(1377, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 20:19:51'),
(1378, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 20:24:19'),
(1379, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 20:24:34');
INSERT INTO `permission_logs` (`log_id`, `user_id`, `module_name`, `action_name`, `action_status`, `action_time`) VALUES
(1380, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 20:24:35'),
(1381, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 20:24:35'),
(1382, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 20:24:36'),
(1383, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 20:24:36'),
(1384, 1, 'user_management', 'Access', 'Success', '2026-01-24 20:24:53'),
(1385, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 20:28:25'),
(1386, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 20:28:25'),
(1387, 1, 'permission_logs', 'Access', 'Success', '2026-01-24 20:28:33'),
(1388, 1, 'permission_logs', 'Access', 'Success', '2026-01-24 20:33:58'),
(1389, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 20:34:00'),
(1390, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 20:34:00'),
(1391, 1, 'permission_logs', 'Access', 'Success', '2026-01-24 20:34:02'),
(1392, 1, 'permission_logs', 'Access', 'Success', '2026-01-24 20:34:05'),
(1393, 1, 'role_permissions', 'Access', 'Success', '2026-01-24 20:34:20'),
(1394, 1, 'user_management', 'Access', 'Success', '2026-01-24 20:34:22'),
(1395, 1, 'role_permissions', 'Access', 'Success', '2026-01-24 20:34:22'),
(1396, 1, 'permission_logs', 'Access', 'Success', '2026-01-24 20:34:23'),
(1397, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 20:34:23'),
(1398, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 20:34:23'),
(1399, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 20:34:25'),
(1400, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 20:34:25'),
(1401, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 20:35:54'),
(1402, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 20:35:54'),
(1403, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 20:35:54'),
(1404, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 20:35:54'),
(1405, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 20:35:55'),
(1406, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 20:35:55'),
(1407, 1, 'user_management', 'Access', 'Success', '2026-01-24 20:35:56'),
(1408, 1, 'permission_logs', 'Access', 'Success', '2026-01-24 20:35:57'),
(1409, 1, 'role_permissions', 'Access', 'Success', '2026-01-24 20:35:58'),
(1410, 1, 'role_permissions', 'Access', 'Success', '2026-01-24 20:35:58'),
(1411, 1, 'user_management', 'Access', 'Success', '2026-01-24 20:35:59'),
(1412, 1, 'permission_logs', 'Access', 'Success', '2026-01-24 20:35:59'),
(1413, 1, 'permission_logs', 'Access', 'Success', '2026-01-24 20:37:04'),
(1414, 1, 'permission_logs', 'Access', 'Success', '2026-01-24 20:37:05'),
(1415, 1, 'permission_logs', 'Access', 'Success', '2026-01-24 20:38:23'),
(1416, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 20:38:44'),
(1417, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 20:38:44'),
(1418, 1, 'permission_logs', 'Access', 'Success', '2026-01-24 20:38:48'),
(1419, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 20:40:07'),
(1420, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 20:40:07'),
(1421, 1, 'permission_logs', 'Access', 'Success', '2026-01-24 20:40:10'),
(1422, 1, 'permission_logs', 'Access', 'Success', '2026-01-24 20:40:17'),
(1423, 1, 'permission_logs', 'Access', 'Success', '2026-01-24 20:40:21'),
(1424, 1, 'user_management', 'Access', 'Success', '2026-01-24 20:40:22'),
(1425, 1, 'user_management', 'Access', 'Success', '2026-01-24 20:40:23'),
(1426, 1, 'role_permissions', 'Access', 'Success', '2026-01-24 20:40:24'),
(1427, 1, 'permission_logs', 'Access', 'Success', '2026-01-24 20:40:24'),
(1428, 1, 'user_management', 'Access', 'Success', '2026-01-24 20:43:36'),
(1429, 1, 'role_permissions', 'Access', 'Success', '2026-01-24 20:43:37'),
(1430, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 20:43:38'),
(1431, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 20:43:38'),
(1432, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 20:43:41'),
(1433, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 20:43:41'),
(1434, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 20:43:51'),
(1435, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 20:43:51'),
(1436, 1, 'permission_logs', 'Access', 'Success', '2026-01-24 20:43:58'),
(1437, 1, 'permission_logs', 'Access', 'Success', '2026-01-24 20:46:22'),
(1438, 1, 'role_permissions', 'Access', 'Success', '2026-01-24 20:46:22'),
(1439, 1, 'user_management', 'Access', 'Success', '2026-01-24 20:46:23'),
(1440, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 20:46:23'),
(1441, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 20:46:23'),
(1442, 1, 'permission_logs', 'Access', 'Success', '2026-01-24 20:46:26'),
(1443, 1, 'permission_logs', 'Access', 'Success', '2026-01-24 20:47:33'),
(1444, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-24 20:48:45'),
(1445, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-24 20:48:49'),
(1446, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-24 20:48:52'),
(1447, 1, 'user_management', 'Access', 'Success', '2026-01-24 20:51:24'),
(1448, 1, 'role_permissions', 'Access', 'Success', '2026-01-24 20:51:24'),
(1449, 1, 'permission_logs', 'Access', 'Success', '2026-01-24 20:51:25'),
(1450, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 20:51:27'),
(1451, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 20:51:27'),
(1452, 1, 'permission_logs', 'Access', 'Success', '2026-01-24 20:51:29'),
(1453, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-24 20:51:49'),
(1454, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 20:51:50'),
(1455, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 20:51:50'),
(1456, 1, 'permission_logs', 'Access', 'Success', '2026-01-24 20:51:57'),
(1457, 1, 'permission_logs', 'Access', 'Success', '2026-01-24 20:52:06'),
(1458, 1, 'permission_logs', 'Access', 'Success', '2026-01-24 20:52:14'),
(1459, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 20:52:25'),
(1460, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 20:52:25'),
(1461, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-24 20:52:26'),
(1462, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 20:52:28'),
(1463, 1, 'compliance_logs', 'Access', 'Success', '2026-01-24 20:52:28'),
(1464, 1, 'user_management', 'Access', 'Success', '2026-01-24 20:52:28'),
(1465, 1, 'role_permissions', 'Access', 'Success', '2026-01-24 20:52:29'),
(1466, 1, 'permission_logs', 'Access', 'Success', '2026-01-24 20:52:29'),
(1467, 1, 'permission_logs', 'Access', 'Success', '2026-01-24 20:55:41'),
(1468, 1, 'permission_logs', 'Access', 'Success', '2026-01-24 20:56:24'),
(1469, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-25 03:55:00'),
(1470, 1, 'compliance_logs', 'Access', 'Success', '2026-01-25 03:55:03'),
(1471, 1, 'compliance_logs', 'Access', 'Success', '2026-01-25 03:55:04'),
(1472, 1, 'role_permissions', 'Access', 'Success', '2026-01-25 03:57:43'),
(1473, 1, 'user_management', 'Access', 'Success', '2026-01-25 03:57:44'),
(1474, 1, 'permission_logs', 'Access', 'Success', '2026-01-25 03:57:45'),
(1475, 1, 'compliance_logs', 'Access', 'Success', '2026-01-25 03:57:48'),
(1476, 1, 'compliance_logs', 'Access', 'Success', '2026-01-25 03:57:48'),
(1477, 1, 'role_permissions', 'Access', 'Success', '2026-01-25 03:58:32'),
(1478, 1, 'permission_logs', 'Access', 'Success', '2026-01-25 03:58:33'),
(1479, 1, 'compliance_logs', 'Access', 'Success', '2026-01-25 03:58:36'),
(1480, 1, 'compliance_logs', 'Access', 'Success', '2026-01-25 03:58:36'),
(1481, 1, 'compliance_logs', 'Access', 'Success', '2026-01-25 03:58:41'),
(1482, 1, 'compliance_logs', 'Access', 'Success', '2026-01-25 03:58:44'),
(1483, 1, 'compliance_logs', 'Access', 'Success', '2026-01-25 03:59:03'),
(1484, 1, 'compliance_logs', 'Access', 'Success', '2026-01-25 03:59:03'),
(1485, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-25 04:04:41'),
(1486, 1, 'compliance_logs', 'Access', 'Success', '2026-01-25 04:04:47'),
(1487, 1, 'compliance_logs', 'Access', 'Success', '2026-01-25 04:04:47'),
(1488, 1, 'user_management', 'Access', 'Success', '2026-01-25 04:04:50'),
(1489, 1, 'user_management', 'Access', 'Success', '2026-01-25 04:10:49'),
(1490, 1, 'compliance_logs', 'Access', 'Success', '2026-01-25 04:10:49'),
(1491, 1, 'compliance_logs', 'Access', 'Success', '2026-01-25 04:10:50'),
(1492, 1, 'user_management', 'Access', 'Success', '2026-01-25 04:11:07'),
(1493, 1, 'role_permissions', 'Access', 'Success', '2026-01-25 04:11:15'),
(1494, 1, 'user_management', 'Access', 'Success', '2026-01-25 04:16:51'),
(1495, 1, 'compliance_logs', 'Access', 'Success', '2026-01-25 04:16:53'),
(1496, 1, 'compliance_logs', 'Access', 'Success', '2026-01-25 04:16:53'),
(1497, 1, 'user_management', 'Access', 'Success', '2026-01-25 04:16:54'),
(1498, 1, 'user_management', 'Access', 'Success', '2026-01-25 04:18:19'),
(1499, 1, 'role_permissions', 'Access', 'Success', '2026-01-25 04:18:19'),
(1500, 1, 'user_management', 'Access', 'Success', '2026-01-25 04:18:20'),
(1501, 1, 'user_management', 'Access', 'Success', '2026-01-25 04:26:20'),
(1502, 1, 'user_management', 'Access', 'Success', '2026-01-25 04:29:40'),
(1503, 1, 'user_management', 'Access', 'Success', '2026-01-25 04:35:24'),
(1504, 1, 'user_management', 'Access', 'Success', '2026-01-25 04:42:51'),
(1505, 1, 'user_management', 'Access', 'Success', '2026-01-25 04:49:29'),
(1506, 5, 'user_management', 'Access', '', '2026-01-25 04:50:54'),
(1507, 5, 'compliance_logs', 'Access', 'Success', '2026-01-25 04:50:56'),
(1508, 5, 'compliance_logs', 'Access', 'Success', '2026-01-25 04:50:56'),
(1509, 5, 'savings_monitoring', 'Access', 'Success', '2026-01-25 04:50:57'),
(1510, 5, 'permission_logs', 'Access', '', '2026-01-25 04:51:00'),
(1511, 5, 'user_management', 'Access', '', '2026-01-25 04:51:05'),
(1512, 5, 'compliance_logs', 'Access', 'Success', '2026-01-25 04:51:07'),
(1513, 5, 'compliance_logs', 'Access', 'Success', '2026-01-25 04:51:07'),
(1514, 1, 'user_management', 'Access', 'Success', '2026-01-25 04:51:28'),
(1515, 1, 'role_permissions', 'Access', 'Success', '2026-01-25 04:52:41'),
(1516, 1, 'permission_logs', 'Access', 'Success', '2026-01-25 04:52:42'),
(1517, 1, 'role_permissions', 'Access', 'Success', '2026-01-25 04:52:42'),
(1518, 1, 'role_permissions', 'Access', 'Success', '2026-01-25 04:54:11'),
(1519, 1, 'user_management', 'Access', 'Success', '2026-01-25 04:54:11'),
(1520, 1, 'user_management', 'Access', 'Success', '2026-01-25 04:55:05'),
(1521, 1, 'user_management', 'Access', 'Success', '2026-01-25 04:55:38'),
(1522, 1, 'role_permissions', 'Access', 'Success', '2026-01-25 04:56:25'),
(1523, 1, 'user_management', 'Access', 'Success', '2026-01-25 04:56:27'),
(1524, 1, 'user_management', 'Access', 'Success', '2026-01-25 04:56:31'),
(1525, 1, 'role_permissions', 'Access', 'Success', '2026-01-25 04:56:31'),
(1526, 1, 'role_permissions', 'Access', 'Success', '2026-01-25 05:09:06'),
(1527, 1, 'role_permissions', 'Access', 'Success', '2026-01-25 05:09:46'),
(1528, 1, 'role_permissions', 'Edit', 'Success', '2026-01-25 05:11:41'),
(1529, 1, 'role_permissions', 'Edit', 'Success', '2026-01-25 05:11:45'),
(1530, 1, 'role_permissions', 'Access', 'Success', '2026-01-25 05:27:32'),
(1531, 1, 'permission_logs', 'Access', 'Success', '2026-01-25 05:31:01'),
(1532, 1, 'role_permissions', 'Access', 'Success', '2026-01-25 05:31:05'),
(1533, 1, 'permission_logs', 'Access', 'Success', '2026-01-25 05:34:23'),
(1534, 1, 'role_permissions', 'Access', 'Success', '2026-01-25 05:54:03'),
(1535, 1, 'user_management', 'Access', 'Success', '2026-01-25 05:54:04'),
(1536, 1, 'permission_logs', 'Access', 'Success', '2026-01-25 05:54:09'),
(1537, 1, 'permission_logs', 'Access', 'Success', '2026-01-25 05:54:55'),
(1538, 1, 'permission_logs', 'Access', 'Success', '2026-01-25 05:54:55'),
(1539, 1, 'permission_logs', 'Access', 'Success', '2026-01-25 06:00:55'),
(1540, 1, 'permission_logs', 'Access', 'Success', '2026-01-25 06:00:56'),
(1541, 1, 'role_permissions', 'Access', 'Success', '2026-01-25 06:01:00'),
(1542, 1, 'user_management', 'Access', 'Success', '2026-01-25 06:01:02'),
(1543, 1, 'permission_logs', 'Access', 'Success', '2026-01-25 06:01:17'),
(1544, 1, 'permission_logs', 'Access', 'Success', '2026-01-25 06:01:17'),
(1545, 1, 'permission_logs', 'Access', 'Success', '2026-01-25 06:01:22'),
(1546, 1, 'permission_logs', 'Access', 'Success', '2026-01-25 06:01:22'),
(1547, 1, 'permission_logs', 'Access', 'Success', '2026-01-25 06:01:27'),
(1548, 1, 'compliance_logs', 'Access', 'Success', '2026-01-25 06:01:33'),
(1549, 1, 'compliance_logs', 'Access', 'Success', '2026-01-25 06:01:33'),
(1550, 1, 'permission_logs', 'Access', 'Success', '2026-01-25 06:01:34'),
(1551, 1, 'permission_logs', 'Access', 'Success', '2026-01-25 06:01:35'),
(1552, 1, 'permission_logs', 'Access', 'Success', '2026-01-25 06:01:36'),
(1553, 1, 'permission_logs', 'Access', 'Success', '2026-01-25 06:01:45'),
(1554, 1, 'permission_logs', 'Access', 'Success', '2026-01-25 06:01:46'),
(1555, 1, 'permission_logs', 'Access', 'Success', '2026-01-25 06:01:49'),
(1556, 1, 'role_permissions', 'Access', 'Success', '2026-01-25 06:01:52'),
(1557, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-25 06:03:08'),
(1558, 1, 'compliance_logs', 'Access', 'Success', '2026-01-25 06:03:09'),
(1559, 1, 'compliance_logs', 'Access', 'Success', '2026-01-25 06:03:09'),
(1560, 1, 'user_management', 'Access', 'Success', '2026-01-25 06:03:21'),
(1561, 1, 'role_permissions', 'Access', 'Success', '2026-01-25 06:03:22'),
(1562, 1, 'user_management', 'Access', 'Success', '2026-01-25 06:03:23'),
(1563, 1, 'compliance_logs', 'Access', 'Success', '2026-01-25 06:04:06'),
(1564, 1, 'compliance_logs', 'Access', 'Success', '2026-01-25 06:04:06'),
(1565, 1, 'compliance_logs', 'Access', 'Success', '2026-01-25 06:04:09'),
(1566, 1, 'compliance_logs', 'Access', 'Success', '2026-01-25 06:04:12'),
(1567, 1, 'compliance_logs', 'Access', 'Success', '2026-01-25 06:04:12'),
(1568, 1, 'compliance_logs', 'Access', 'Success', '2026-01-25 06:04:15'),
(1569, 1, 'compliance_logs', 'Access', 'Success', '2026-01-25 06:04:19'),
(1570, 1, 'compliance_logs', 'Access', 'Success', '2026-01-25 06:04:19'),
(1571, 1, 'compliance_logs', 'Access', 'Success', '2026-01-25 06:06:38'),
(1572, 1, 'compliance_logs', 'Access', 'Success', '2026-01-25 06:06:38'),
(1573, 1, 'compliance_logs', 'Access', 'Success', '2026-01-25 06:06:39'),
(1574, 1, 'user_management', 'Access', 'Success', '2026-01-25 06:35:43'),
(1575, 1, 'role_permissions', 'Access', 'Success', '2026-01-25 06:35:45'),
(1576, 1, 'permission_logs', 'Access', 'Success', '2026-01-25 06:35:50'),
(1577, 1, 'permission_logs', 'Access', 'Success', '2026-01-25 06:35:51'),
(1578, 1, 'permission_logs', 'Access', 'Success', '2026-01-25 06:36:54'),
(1579, 1, 'permission_logs', 'Access', 'Success', '2026-01-25 06:36:54'),
(1580, 1, 'user_management', 'Access', 'Success', '2026-01-25 06:37:19'),
(1581, 1, 'compliance_logs', 'Access', 'Success', '2026-01-25 06:37:21'),
(1582, 1, 'compliance_logs', 'Access', 'Success', '2026-01-25 06:37:21'),
(1583, 1, 'permission_logs', 'Access', 'Success', '2026-01-25 06:37:24'),
(1584, 1, 'permission_logs', 'Access', 'Success', '2026-01-25 06:37:24'),
(1585, 1, 'compliance_logs', 'Access', 'Success', '2026-01-25 06:37:54'),
(1586, 1, 'compliance_logs', 'Access', 'Success', '2026-01-25 06:37:54'),
(1587, 1, 'compliance_logs', 'Access', 'Success', '2026-01-25 06:37:56'),
(1588, 1, 'compliance_logs', 'Access', 'Success', '2026-01-25 06:37:59'),
(1589, 1, 'compliance_logs', 'Access', 'Success', '2026-01-25 06:38:01'),
(1590, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-25 06:38:27'),
(1591, 1, 'permission_logs', 'Access', 'Success', '2026-01-25 06:39:06'),
(1592, 1, 'permission_logs', 'Access', 'Success', '2026-01-25 06:39:06'),
(1593, 1, 'role_permissions', 'Access', 'Success', '2026-01-25 06:39:13'),
(1594, 1, 'permission_logs', 'Access', 'Success', '2026-01-25 06:39:14'),
(1595, 1, 'permission_logs', 'Access', 'Success', '2026-01-25 06:39:14'),
(1596, 1, 'permission_logs', 'Access', 'Success', '2026-01-25 06:39:48'),
(1597, 1, 'permission_logs', 'Access', 'Success', '2026-01-25 06:39:48'),
(1598, 1, 'permission_logs', 'Access', 'Success', '2026-01-25 06:41:34'),
(1599, 1, 'permission_logs', 'Access', 'Success', '2026-01-25 06:41:34'),
(1600, 1, 'permission_logs', 'Access', 'Success', '2026-01-25 06:41:36'),
(1601, 1, 'permission_logs', 'Access', 'Success', '2026-01-25 06:41:44'),
(1602, 1, 'permission_logs', 'Access', 'Success', '2026-01-25 06:41:46'),
(1603, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-25 06:41:51'),
(1604, 1, 'savings_monitoring', 'Access', 'Success', '2026-01-25 06:42:06'),
(1605, 1, 'compliance_logs', 'Access', 'Success', '2026-01-25 06:42:37'),
(1606, 1, 'compliance_logs', 'Access', 'Success', '2026-01-25 06:42:37'),
(1607, 1, 'user_management', 'Access', 'Success', '2026-01-25 06:42:39'),
(1608, 1, 'permission_logs', 'Access', 'Success', '2026-01-25 06:47:53'),
(1609, 1, 'permission_logs', 'Access', 'Success', '2026-01-25 06:47:53'),
(1610, 6, 'user_management', 'Access', '', '2026-01-25 06:48:19'),
(1611, 6, 'compliance_logs', 'Access', '', '2026-01-25 06:48:21'),
(1612, 6, 'permission_logs', 'Access', '', '2026-01-25 06:48:25'),
(1613, 6, 'savings_monitoring', 'Access', 'Success', '2026-01-25 06:48:55'),
(1614, 6, 'user_management', 'Access', '', '2026-01-25 06:49:16'),
(1615, 6, 'permission_logs', 'Access', '', '2026-01-25 06:49:33'),
(1616, 6, 'permission_logs', 'Access', '', '2026-01-25 06:49:36'),
(1617, 6, 'user_management', 'Access', '', '2026-01-25 06:49:37'),
(1618, 6, 'permission_logs', 'Access', '', '2026-01-25 06:50:01'),
(1619, 6, 'user_management', 'Access', '', '2026-01-25 06:50:03'),
(1620, 6, 'savings_monitoring', 'Access', 'Success', '2026-01-25 06:50:06'),
(1621, 1, 'compliance_logs', 'Access', 'Success', '2026-01-25 06:57:05'),
(1622, 1, 'compliance_logs', 'Access', 'Success', '2026-01-25 06:57:05'),
(1623, 1, 'user_management', 'Access', 'Success', '2026-01-25 06:57:06'),
(1624, 1, 'role_permissions', 'Access', 'Success', '2026-01-25 06:57:07'),
(1625, 1, 'permission_logs', 'Access', 'Success', '2026-01-25 06:57:08'),
(1626, 1, 'permission_logs', 'Access', 'Success', '2026-01-25 06:57:08'),
(1627, 1, 'compliance_logs', 'Access', 'Success', '2026-01-25 06:57:10'),
(1628, 1, 'compliance_logs', 'Access', 'Success', '2026-01-25 06:57:10'),
(1629, 1, 'user_management', 'Access', 'Success', '2026-01-25 06:57:14'),
(1630, 5, 'user_management', 'Access', '', '2026-01-25 06:57:29'),
(1631, 5, 'permission_logs', 'Access', '', '2026-01-25 06:57:34'),
(1632, 5, 'permission_logs', 'Access', '', '2026-01-25 06:58:00'),
(1633, 5, 'user_management', 'Access', '', '2026-01-25 06:58:01'),
(1634, 5, 'permission_logs', 'Access', '', '2026-01-25 06:58:16'),
(1635, 5, 'permission_logs', 'Access', '', '2026-01-25 06:58:19'),
(1636, 5, 'user_management', 'Access', '', '2026-01-25 06:58:22'),
(1637, 5, 'compliance_logs', 'Access', 'Success', '2026-01-25 06:58:24'),
(1638, 5, 'compliance_logs', 'Access', 'Success', '2026-01-25 06:58:24'),
(1639, 5, 'savings_monitoring', 'Access', 'Success', '2026-01-25 06:58:24'),
(1640, 6, 'compliance_logs', 'Access', '', '2026-01-25 06:58:37'),
(1641, 6, 'compliance_logs', 'Access', '', '2026-01-25 06:58:39'),
(1642, 6, 'savings_monitoring', 'Access', 'Success', '2026-01-25 06:58:47'),
(1643, 6, 'savings_monitoring', 'Access', 'Success', '2026-01-25 07:00:09'),
(1644, 6, 'savings_monitoring', 'Access', 'Success', '2026-01-25 07:00:29'),
(1645, 6, 'savings_monitoring', 'Access', 'Success', '2026-01-25 07:02:57'),
(1646, 6, 'savings_monitoring', 'Access', 'Success', '2026-01-25 07:03:06'),
(1647, 6, 'savings_monitoring', 'Access', 'Success', '2026-01-25 07:03:14'),
(1648, 5, 'compliance_logs', 'Access', 'Success', '2026-01-25 07:06:16'),
(1649, 5, 'compliance_logs', 'Access', 'Success', '2026-01-25 07:06:16'),
(1650, 5, 'user_management', 'Access', '', '2026-01-25 07:06:17'),
(1651, 5, 'permission_logs', 'Access', '', '2026-01-25 07:06:21'),
(1652, 5, 'compliance_logs', 'Access', 'Success', '2026-01-25 07:06:23'),
(1653, 5, 'compliance_logs', 'Access', 'Success', '2026-01-25 07:06:23'),
(1654, 5, 'savings_monitoring', 'Access', 'Success', '2026-01-25 07:06:25'),
(1655, 5, 'savings_monitoring', 'Access', 'Success', '2026-01-25 07:06:27'),
(1656, 5, 'savings_monitoring', 'Access', 'Success', '2026-01-25 07:06:36'),
(1657, 5, 'compliance_logs', 'Access', 'Success', '2026-01-25 07:06:45'),
(1658, 5, 'compliance_logs', 'Access', 'Success', '2026-01-25 07:06:45'),
(1659, 5, 'compliance_logs', 'Access', 'Success', '2026-01-25 07:06:48'),
(1660, 1, 'user_management', 'Access', 'Success', '2026-01-25 07:22:50'),
(1661, 1, 'role_permissions', 'Access', 'Success', '2026-01-25 07:22:58'),
(1662, 1, 'compliance_logs', 'Access', 'Success', '2026-01-25 07:22:58'),
(1663, 1, 'compliance_logs', 'Access', 'Success', '2026-01-25 07:22:58'),
(1664, 1, 'compliance_logs', 'Access', 'Success', '2026-01-25 07:23:00'),
(1665, 1, 'compliance_logs', 'Access', 'Success', '2026-01-25 07:23:01'),
(1666, 1, 'compliance_logs', 'Access', 'Success', '2026-01-25 07:23:01'),
(1667, 1, 'compliance_logs', 'Access', 'Success', '2026-01-25 07:23:05'),
(1668, 1, 'compliance_logs', 'Access', 'Success', '2026-01-25 07:23:05');

-- --------------------------------------------------------

--
-- Table structure for table `repayments`
--

CREATE TABLE `repayments` (
  `repayment_id` int(11) NOT NULL,
  `loan_id` int(11) NOT NULL,
  `amount` decimal(12,2) NOT NULL,
  `repayment_date` date NOT NULL,
  `method` varchar(50) DEFAULT NULL,
  `remarks` varchar(200) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_by_name` varchar(100) DEFAULT NULL,
  `overdue_count` int(11) DEFAULT 0,
  `risk_level` varchar(20) DEFAULT NULL,
  `next_due` date DEFAULT NULL,
  `created_at` date DEFAULT curdate()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `report_id` int(11) NOT NULL,
  `report_type` varchar(100) DEFAULT NULL,
  `generated_by` int(11) DEFAULT NULL,
  `generated_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `file_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `role_permissions`
--

CREATE TABLE `role_permissions` (
  `perm_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `module_name` varchar(100) NOT NULL,
  `action_name` varchar(50) NOT NULL,
  `can_view` tinyint(1) DEFAULT 0,
  `can_add` tinyint(1) DEFAULT 0,
  `can_edit` tinyint(1) DEFAULT 0,
  `can_delete` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `role_permissions`
--

INSERT INTO `role_permissions` (`perm_id`, `role_id`, `module_name`, `action_name`, `can_view`, `can_add`, `can_edit`, `can_delete`) VALUES
(18, 16, 'User Management', '', 1, 1, 1, 1),
(19, 16, 'Loan Portfolio', '', 1, 1, 1, 1),
(20, 16, 'Savings Monitoring', '', 1, 1, 1, 1),
(21, 16, 'Disbursement Tracker', '', 1, 1, 1, 1),
(22, 16, 'Compliance & Audit Trail', '', 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `savings`
--

CREATE TABLE `savings` (
  `saving_id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `transaction_date` date NOT NULL,
  `transaction_type` enum('Deposit','Withdrawal') NOT NULL,
  `amount` decimal(12,2) NOT NULL,
  `balance` decimal(12,2) DEFAULT 0.00,
  `recorded_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `savings`
--

INSERT INTO `savings` (`saving_id`, `member_id`, `transaction_date`, `transaction_type`, `amount`, `balance`, `recorded_by`) VALUES
(19, 1, '2025-10-16', 'Deposit', 7000.00, 12000.00, 1),
(20, 2, '2025-10-16', 'Deposit', 10000.00, 10000.00, 1),
(21, 3, '2025-10-17', 'Deposit', 8000.00, 8000.00, 1),
(22, 3, '2025-10-18', 'Withdrawal', 4000.00, 9000.00, 5),
(33, 5, '2025-10-22', 'Withdrawal', 10000.00, 10000.00, 5),
(34, 5, '2025-10-22', 'Deposit', 1500.00, 11500.00, 5),
(35, 5, '2025-10-22', 'Deposit', 2450.00, 13950.00, 5);

-- --------------------------------------------------------

--
-- Table structure for table `system_info`
--

CREATE TABLE `system_info` (
  `id` int(11) NOT NULL,
  `meta_field` varchar(100) NOT NULL,
  `meta_value` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `system_info`
--

INSERT INTO `system_info` (`id`, `meta_field`, `meta_value`) VALUES
(1, 'system_name', 'Microfinance EIS'),
(2, 'system_tagline', 'Integrated Loan, Savings, and Collection Monitoring'),
(3, 'address', 'Manila, Philippines'),
(4, 'contact', '+63 912 345 6789'),
(5, 'email', 'info@coret2.local'),
(6, 'logo', 'dist/img/logo.jpg'),
(7, 'cover', 'dist/img/default-cover.png'),
(8, 'theme_color', '#004aad'),
(9, 'footer_text', '© 2025 Core Transaction 2. All rights reserved.');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `role_id` int(11) DEFAULT NULL,
  `username` varchar(50) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `role` enum('Super Admin','Admin','Staff','Client','Distributor') DEFAULT NULL,
  `status` enum('Active','Inactive') DEFAULT 'Active',
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `role_id`, `username`, `password_hash`, `full_name`, `email`, `role`, `status`, `date_created`) VALUES
(1, 16, 'admin', '$2y$10$Had0.u5AFPE9dKz9DEW7bOFDewlI6tOritseF0nlS7DxLwRb.L4o.', 'Fernando Jr.', 'fg708304@gmail.com', 'Super Admin', 'Active', '2025-10-12 06:30:49'),
(5, 16, 'Nands', '$2y$10$PW1v5z3K4W/Sw/HqJSGN6Oa8iZZ.Z4nEtM47PNpKK/VwN.SGDXHl2', 'Fernando M. Gonzales Jr.', 'fgonzales493@gmail.com', 'Admin', 'Active', '2025-10-18 10:18:46'),
(6, NULL, 'user1', '$2y$10$0iqBNXwX/d9gWrDMCkTZceJBLO6GgyoqxBF5rtvcunyJbUlpG4sEe', 'Noby', 'alcorizatrixie@gmail.com', 'Staff', 'Active', '2025-10-19 05:29:45'),
(7, NULL, 'Fernando', '$2y$10$hSka/B.mslNccC3D5LtXMelRnZjrKjGk8r/oMYojO6LW2GL7SCksG', 'Noby Gonzales', 'fg708304@gmail.com', 'Staff', 'Active', '2025-10-22 05:06:51'),
(8, NULL, 'Rico', '$2y$10$4jK1YoviwxxSoYqCmGSZYOlNBvb.eVyEstYwOzq.7O/ojTcsGLeVe', 'FERNANDO MALONES GONZALES', 'fg70830411@gmail.com', 'Client', 'Active', '2026-01-25 04:56:12');

-- --------------------------------------------------------

--
-- Table structure for table `user_roles`
--

CREATE TABLE `user_roles` (
  `role_id` int(11) NOT NULL,
  `role_name` varchar(50) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_roles`
--

INSERT INTO `user_roles` (`role_id`, `role_name`, `description`, `created_at`) VALUES
(16, 'Admin', 'Full access to system', '2025-10-18 10:33:35'),
(17, 'Manager', 'Manage loans and users', '2025-10-18 10:33:35'),
(18, 'Officer', 'Handle day-to-day operations', '2025-10-18 10:33:35'),
(19, 'Auditor', 'View audit logs and reports', '2025-10-18 10:33:35'),
(20, 'Member', 'Basic access to own account', '2025-10-18 10:33:35');

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_audit_summary`
-- (See below for the actual view)
--
CREATE TABLE `v_audit_summary` (
`audit_date` date
,`module_name` varchar(100)
,`compliance_status` varchar(50)
,`log_count` bigint(21)
,`unique_users` bigint(21)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_collection_summary`
-- (See below for the actual view)
--
CREATE TABLE `v_collection_summary` (
`loan_id` int(11)
,`full_name` varchar(100)
,`total_collected` decimal(34,2)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_member_savings`
-- (See below for the actual view)
--
CREATE TABLE `v_member_savings` (
`member_id` int(11)
,`member_name` varchar(100)
,`total_savings` decimal(34,2)
,`transaction_count` bigint(21)
,`last_transaction_date` date
);

-- --------------------------------------------------------

--
-- Structure for view `v_audit_summary`
--
DROP TABLE IF EXISTS `v_audit_summary`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_audit_summary`  AS SELECT cast(`audit_trail`.`action_time` as date) AS `audit_date`, `audit_trail`.`module_name` AS `module_name`, `audit_trail`.`compliance_status` AS `compliance_status`, count(0) AS `log_count`, count(distinct `audit_trail`.`user_id`) AS `unique_users` FROM `audit_trail` GROUP BY cast(`audit_trail`.`action_time` as date), `audit_trail`.`module_name`, `audit_trail`.`compliance_status` ;

-- --------------------------------------------------------

--
-- Structure for view `v_collection_summary`
--
DROP TABLE IF EXISTS `v_collection_summary`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_collection_summary`  AS SELECT `l`.`loan_id` AS `loan_id`, `m`.`full_name` AS `full_name`, sum(`c`.`amount_collected`) AS `total_collected` FROM ((`collections` `c` join `loan_portfolio` `l` on(`c`.`loan_id` = `l`.`loan_id`)) join `members` `m` on(`l`.`member_id` = `m`.`member_id`)) GROUP BY `l`.`loan_id` ;

-- --------------------------------------------------------

--
-- Structure for view `v_member_savings`
--
DROP TABLE IF EXISTS `v_member_savings`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_member_savings`  AS SELECT `m`.`member_id` AS `member_id`, `m`.`full_name` AS `member_name`, ifnull(sum(`s`.`amount`),0) AS `total_savings`, count(`s`.`saving_id`) AS `transaction_count`, max(`s`.`transaction_date`) AS `last_transaction_date` FROM (`members` `m` left join `savings` `s` on(`m`.`member_id` = `s`.`member_id`)) GROUP BY `m`.`member_id`, `m`.`full_name` ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `audit_trail`
--
ALTER TABLE `audit_trail`
  ADD PRIMARY KEY (`audit_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `collections`
--
ALTER TABLE `collections`
  ADD PRIMARY KEY (`collection_id`),
  ADD KEY `loan_id` (`loan_id`),
  ADD KEY `member_id` (`member_id`),
  ADD KEY `collector_id` (`collector_id`);

--
-- Indexes for table `compliance_logs`
--
ALTER TABLE `compliance_logs`
  ADD PRIMARY KEY (`compliance_id`),
  ADD KEY `audit_id` (`audit_id`);

--
-- Indexes for table `disbursements`
--
ALTER TABLE `disbursements`
  ADD PRIMARY KEY (`disbursement_id`),
  ADD KEY `loan_id` (`loan_id`),
  ADD KEY `member_id` (`member_id`),
  ADD KEY `approved_by` (`approved_by`);

--
-- Indexes for table `disbursement_logs`
--
ALTER TABLE `disbursement_logs`
  ADD PRIMARY KEY (`log_id`),
  ADD KEY `fk_logs_disbursement` (`disbursement_id`),
  ADD KEY `fk_logs_user` (`user_id`);

--
-- Indexes for table `loan_portfolio`
--
ALTER TABLE `loan_portfolio`
  ADD PRIMARY KEY (`loan_id`),
  ADD KEY `member_id` (`member_id`);

--
-- Indexes for table `loan_schedule`
--
ALTER TABLE `loan_schedule`
  ADD PRIMARY KEY (`schedule_id`),
  ADD KEY `loan_id` (`loan_id`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`member_id`),
  ADD UNIQUE KEY `member_code` (`member_code`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `permission_logs`
--
ALTER TABLE `permission_logs`
  ADD PRIMARY KEY (`log_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `repayments`
--
ALTER TABLE `repayments`
  ADD PRIMARY KEY (`repayment_id`),
  ADD KEY `loan_id` (`loan_id`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`report_id`),
  ADD KEY `generated_by` (`generated_by`);

--
-- Indexes for table `role_permissions`
--
ALTER TABLE `role_permissions`
  ADD PRIMARY KEY (`perm_id`),
  ADD KEY `role_id` (`role_id`);

--
-- Indexes for table `savings`
--
ALTER TABLE `savings`
  ADD PRIMARY KEY (`saving_id`),
  ADD KEY `member_id` (`member_id`),
  ADD KEY `recorded_by` (`recorded_by`);

--
-- Indexes for table `system_info`
--
ALTER TABLE `system_info`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `meta_field` (`meta_field`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `fk_users_role_id` (`role_id`);

--
-- Indexes for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD PRIMARY KEY (`role_id`),
  ADD UNIQUE KEY `role_name` (`role_name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `audit_trail`
--
ALTER TABLE `audit_trail`
  MODIFY `audit_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=348;

--
-- AUTO_INCREMENT for table `collections`
--
ALTER TABLE `collections`
  MODIFY `collection_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `compliance_logs`
--
ALTER TABLE `compliance_logs`
  MODIFY `compliance_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `disbursements`
--
ALTER TABLE `disbursements`
  MODIFY `disbursement_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `disbursement_logs`
--
ALTER TABLE `disbursement_logs`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `loan_portfolio`
--
ALTER TABLE `loan_portfolio`
  MODIFY `loan_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `loan_schedule`
--
ALTER TABLE `loan_schedule`
  MODIFY `schedule_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=321;

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `member_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `permission_logs`
--
ALTER TABLE `permission_logs`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1669;

--
-- AUTO_INCREMENT for table `repayments`
--
ALTER TABLE `repayments`
  MODIFY `repayment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `report_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `role_permissions`
--
ALTER TABLE `role_permissions`
  MODIFY `perm_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `savings`
--
ALTER TABLE `savings`
  MODIFY `saving_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `system_info`
--
ALTER TABLE `system_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `user_roles`
--
ALTER TABLE `user_roles`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `audit_trail`
--
ALTER TABLE `audit_trail`
  ADD CONSTRAINT `audit_trail_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `collections`
--
ALTER TABLE `collections`
  ADD CONSTRAINT `collections_ibfk_1` FOREIGN KEY (`loan_id`) REFERENCES `loan_portfolio` (`loan_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `collections_ibfk_2` FOREIGN KEY (`member_id`) REFERENCES `members` (`member_id`),
  ADD CONSTRAINT `collections_ibfk_3` FOREIGN KEY (`collector_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `compliance_logs`
--
ALTER TABLE `compliance_logs`
  ADD CONSTRAINT `compliance_logs_ibfk_1` FOREIGN KEY (`audit_id`) REFERENCES `audit_trail` (`audit_id`);

--
-- Constraints for table `disbursement_logs`
--
ALTER TABLE `disbursement_logs`
  ADD CONSTRAINT `fk_logs_disbursement` FOREIGN KEY (`disbursement_id`) REFERENCES `disbursements` (`disbursement_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_logs_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `loan_portfolio`
--
ALTER TABLE `loan_portfolio`
  ADD CONSTRAINT `loan_portfolio_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `members` (`member_id`);

--
-- Constraints for table `loan_schedule`
--
ALTER TABLE `loan_schedule`
  ADD CONSTRAINT `loan_schedule_ibfk_1` FOREIGN KEY (`loan_id`) REFERENCES `loan_portfolio` (`loan_id`);

--
-- Constraints for table `members`
--
ALTER TABLE `members`
  ADD CONSTRAINT `members_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE SET NULL;

--
-- Constraints for table `permission_logs`
--
ALTER TABLE `permission_logs`
  ADD CONSTRAINT `permission_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `repayments`
--
ALTER TABLE `repayments`
  ADD CONSTRAINT `repayments_ibfk_1` FOREIGN KEY (`loan_id`) REFERENCES `loan_portfolio` (`loan_id`) ON DELETE CASCADE;

--
-- Constraints for table `reports`
--
ALTER TABLE `reports`
  ADD CONSTRAINT `reports_ibfk_1` FOREIGN KEY (`generated_by`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `role_permissions`
--
ALTER TABLE `role_permissions`
  ADD CONSTRAINT `role_permissions_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `user_roles` (`role_id`) ON DELETE CASCADE;

--
-- Constraints for table `savings`
--
ALTER TABLE `savings`
  ADD CONSTRAINT `savings_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `members` (`member_id`),
  ADD CONSTRAINT `savings_ibfk_2` FOREIGN KEY (`recorded_by`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_users_role_id` FOREIGN KEY (`role_id`) REFERENCES `user_roles` (`role_id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
