-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Machine: localhost
-- Genereertijd: 11 nov 2013 om 16:23
-- Serverversie: 5.6.12
-- PHP-versie: 5.5.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databank: `UMLchecker`
--
CREATE DATABASE IF NOT EXISTS `UMLchecker` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `UMLchecker`;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `ci_sessions`
--

CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(16) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) DEFAULT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `last_activity` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden uitgevoerd voor tabel `ci_sessions`
--

INSERT INTO `ci_sessions` (`session_id`, `ip_address`, `user_agent`, `last_activity`, `user_data`) VALUES
('ccc1a0eaa793764ee0744f30e4c27b85', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_8_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/30.0.1599.101 Safari/537.36', 1384183362, 'a:2:{s:9:"user_data";s:0:"";s:10:"flexi_auth";a:7:{s:15:"user_identifier";s:15:"admin@admin.com";s:7:"user_id";s:1:"1";s:5:"admin";b:1;s:5:"group";a:1:{i:2;s:7:"Teacher";}s:10:"privileges";a:15:{i:1;s:10:"View Users";i:2;s:16:"View User Groups";i:3;s:15:"View Privileges";i:4;s:18:"Insert User Groups";i:5;s:17:"Insert Privileges";i:6;s:12:"Update Users";i:7;s:18:"Update User Groups";i:8;s:17:"Update Privileges";i:9;s:12:"Delete Users";i:10;s:18:"Delete User Groups";i:11;s:17:"Delete Privileges";i:12;s:20:"View Student Classes";i:13;s:20:"Update Student Class";i:14;s:20:"Insert Student Class";i:15;s:20:"Delete Student Class";}s:22:"logged_in_via_password";b:1;s:19:"login_session_token";s:40:"528b224576db44174b6fb990226925a66b8e2aa0";}}');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `class_deadlines`
--

CREATE TABLE IF NOT EXISTS `class_deadlines` (
  `class_deadline_id` smallint(5) NOT NULL AUTO_INCREMENT,
  `deadline_deadline_id_fk` int(11) NOT NULL DEFAULT '0',
  `deadline_class_id_fk` smallint(5) NOT NULL DEFAULT '0',
  PRIMARY KEY (`class_deadline_id`),
  UNIQUE KEY `class_deadline_id` (`class_deadline_id`) USING BTREE,
  KEY `upriv_users_uacc_fk` (`deadline_deadline_id_fk`),
  KEY `deadline_class_id_fk` (`deadline_class_id_fk`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `deadlines`
--

CREATE TABLE IF NOT EXISTS `deadlines` (
  `deadline_id` smallint(5) NOT NULL AUTO_INCREMENT,
  `deadline_desc` varchar(50) NOT NULL DEFAULT '',
  `deadline_enddate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deadline_date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`deadline_id`),
  UNIQUE KEY `deadline_id` (`deadline_id`) USING BTREE
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `student_classes`
--

CREATE TABLE IF NOT EXISTS `student_classes` (
  `studentclass_id` smallint(5) NOT NULL AUTO_INCREMENT,
  `studentclass_name` varchar(20) NOT NULL DEFAULT '',
  `studentclass_desc` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`studentclass_id`),
  UNIQUE KEY `studentclass_id` (`studentclass_id`) USING BTREE
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Gegevens worden uitgevoerd voor tabel `student_classes`
--

INSERT INTO `student_classes` (`studentclass_id`, `studentclass_name`, `studentclass_desc`) VALUES
(1, 'None', 'Student is not in a class.');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `user_accounts`
--

CREATE TABLE IF NOT EXISTS `user_accounts` (
  `uacc_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uacc_group_fk` smallint(5) unsigned NOT NULL DEFAULT '0',
  `uacc_class_fk` smallint(5) unsigned NOT NULL DEFAULT '0',
  `uacc_email` varchar(100) NOT NULL DEFAULT '',
  `uacc_username` varchar(15) NOT NULL DEFAULT '',
  `uacc_password` varchar(60) NOT NULL DEFAULT '',
  `uacc_ip_address` varchar(40) NOT NULL DEFAULT '',
  `uacc_salt` varchar(40) NOT NULL DEFAULT '',
  `uacc_activation_token` varchar(40) NOT NULL DEFAULT '',
  `uacc_forgotten_password_token` varchar(40) NOT NULL DEFAULT '',
  `uacc_forgotten_password_expire` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `uacc_update_email_token` varchar(40) NOT NULL DEFAULT '',
  `uacc_update_email` varchar(100) NOT NULL DEFAULT '',
  `uacc_active` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `uacc_suspend` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `uacc_fail_login_attempts` smallint(5) NOT NULL DEFAULT '0',
  `uacc_fail_login_ip_address` varchar(40) NOT NULL DEFAULT '',
  `uacc_date_fail_login_ban` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Time user is banned until due to repeated failed logins',
  `uacc_date_last_login` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `uacc_date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `uacc_first_login` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `uacc_times_logged_in` int(255) DEFAULT NULL,
  PRIMARY KEY (`uacc_id`),
  UNIQUE KEY `uacc_id` (`uacc_id`),
  KEY `uacc_group_fk` (`uacc_group_fk`),
  KEY `uacc_class_fk` (`uacc_class_fk`),
  KEY `uacc_email` (`uacc_email`),
  KEY `uacc_username` (`uacc_username`),
  KEY `uacc_fail_login_ip_address` (`uacc_fail_login_ip_address`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Gegevens worden uitgevoerd voor tabel `user_accounts`
--

INSERT INTO `user_accounts` (`uacc_id`, `uacc_group_fk`, `uacc_class_fk`, `uacc_email`, `uacc_username`, `uacc_password`, `uacc_ip_address`, `uacc_salt`, `uacc_activation_token`, `uacc_forgotten_password_token`, `uacc_forgotten_password_expire`, `uacc_update_email_token`, `uacc_update_email`, `uacc_active`, `uacc_suspend`, `uacc_fail_login_attempts`, `uacc_fail_login_ip_address`, `uacc_date_fail_login_ban`, `uacc_date_last_login`, `uacc_date_added`, `uacc_first_login`, `uacc_times_logged_in`) VALUES
(1, 2, 1, 'admin@admin.com', 'admin', '$2a$08$lSOQGNqwBFUEDTxm2Y.hb.mfPEAt/iiGY9kJsZsd4ekLJXLD.tCrq', '::1', 'XKVT29q2Jr', '', '', '0000-00-00 00:00:00', '', '', 1, 0, 0, '', '0000-00-00 00:00:00', '2013-11-11 16:23:02', '2011-01-01 00:00:00', 1, 1),
(2, 1, 1, 'public@public.com', 'public', '$2a$08$GlxQ00VKlev2t.CpvbTOlepTJljxF2RocJghON37r40mbDl4vJLv2', '::1', 'CDNFV6dHmn', '', '', '0000-00-00 00:00:00', '', '', 1, 0, 0, '', '0000-00-00 00:00:00', '2013-11-11 16:22:52', '2011-09-15 12:24:45', 1, 1);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `user_groups`
--

CREATE TABLE IF NOT EXISTS `user_groups` (
  `ugrp_id` smallint(5) NOT NULL AUTO_INCREMENT,
  `ugrp_name` varchar(20) NOT NULL DEFAULT '',
  `ugrp_desc` varchar(100) NOT NULL DEFAULT '',
  `ugrp_admin` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ugrp_id`),
  UNIQUE KEY `ugrp_id` (`ugrp_id`) USING BTREE
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Gegevens worden uitgevoerd voor tabel `user_groups`
--

INSERT INTO `user_groups` (`ugrp_id`, `ugrp_name`, `ugrp_desc`, `ugrp_admin`) VALUES
(1, 'Student', 'Student : has no admin access rights.', 0),
(2, 'Teacher', 'Teacher : has full admin access rights.', 1);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `user_login_sessions`
--

CREATE TABLE IF NOT EXISTS `user_login_sessions` (
  `usess_uacc_fk` int(11) NOT NULL DEFAULT '0',
  `usess_series` varchar(40) NOT NULL DEFAULT '',
  `usess_token` varchar(40) NOT NULL DEFAULT '',
  `usess_login_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`usess_token`),
  UNIQUE KEY `usess_token` (`usess_token`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden uitgevoerd voor tabel `user_login_sessions`
--

INSERT INTO `user_login_sessions` (`usess_uacc_fk`, `usess_series`, `usess_token`, `usess_login_date`) VALUES
(1, '', '528b224576db44174b6fb990226925a66b8e2aa0', '2013-11-11 16:23:04');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `user_privileges`
--

CREATE TABLE IF NOT EXISTS `user_privileges` (
  `upriv_id` smallint(5) NOT NULL AUTO_INCREMENT,
  `upriv_name` varchar(20) NOT NULL DEFAULT '',
  `upriv_desc` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`upriv_id`),
  UNIQUE KEY `upriv_id` (`upriv_id`) USING BTREE
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Gegevens worden uitgevoerd voor tabel `user_privileges`
--

INSERT INTO `user_privileges` (`upriv_id`, `upriv_name`, `upriv_desc`) VALUES
(1, 'View Users', 'User can view user account details.'),
(2, 'View User Groups', 'User can view user groups.'),
(3, 'View Privileges', 'User can view privileges.'),
(4, 'Insert User Groups', 'User can insert new user groups.'),
(5, 'Insert Privileges', 'User can insert privileges.'),
(6, 'Update Users', 'User can update user account details.'),
(7, 'Update User Groups', 'User can update user groups.'),
(8, 'Update Privileges', 'User can update user privileges.'),
(9, 'Delete Users', 'User can delete user accounts.'),
(10, 'Delete User Groups', 'User can delete user groups.'),
(11, 'Delete Privileges', 'User can delete user privileges.'),
(12, 'View Student Classes', 'User can view student classes.'),
(13, 'Update Student Class', 'User can update student classes.'),
(14, 'Insert Student Class', 'User can insert student classes.'),
(15, 'Delete Student Class', 'User can delete student classes.'),
(16, 'Add user', 'Add a user to the system');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `user_privilege_groups`
--

CREATE TABLE IF NOT EXISTS `user_privilege_groups` (
  `upriv_groups_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `upriv_groups_ugrp_fk` smallint(5) unsigned NOT NULL DEFAULT '0',
  `upriv_groups_upriv_fk` smallint(5) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`upriv_groups_id`),
  UNIQUE KEY `upriv_groups_id` (`upriv_groups_id`) USING BTREE,
  KEY `upriv_groups_ugrp_fk` (`upriv_groups_ugrp_fk`),
  KEY `upriv_groups_upriv_fk` (`upriv_groups_upriv_fk`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Gegevens worden uitgevoerd voor tabel `user_privilege_groups`
--

INSERT INTO `user_privilege_groups` (`upriv_groups_id`, `upriv_groups_ugrp_fk`, `upriv_groups_upriv_fk`) VALUES
(1, 3, 1),
(3, 3, 3),
(4, 3, 4),
(5, 3, 5),
(6, 3, 6),
(7, 3, 7),
(8, 3, 8),
(9, 3, 9),
(10, 3, 10),
(11, 3, 11),
(12, 2, 2),
(13, 2, 4),
(14, 2, 5),
(15, 2, 16);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `user_privilege_users`
--

CREATE TABLE IF NOT EXISTS `user_privilege_users` (
  `upriv_users_id` smallint(5) NOT NULL AUTO_INCREMENT,
  `upriv_users_uacc_fk` int(11) NOT NULL DEFAULT '0',
  `upriv_users_upriv_fk` smallint(5) NOT NULL DEFAULT '0',
  PRIMARY KEY (`upriv_users_id`),
  UNIQUE KEY `upriv_users_id` (`upriv_users_id`) USING BTREE,
  KEY `upriv_users_uacc_fk` (`upriv_users_uacc_fk`),
  KEY `upriv_users_upriv_fk` (`upriv_users_upriv_fk`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Gegevens worden uitgevoerd voor tabel `user_privilege_users`
--

INSERT INTO `user_privilege_users` (`upriv_users_id`, `upriv_users_uacc_fk`, `upriv_users_upriv_fk`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 1, 4),
(5, 1, 5),
(6, 1, 6),
(7, 1, 7),
(8, 1, 8),
(9, 1, 9),
(10, 1, 10),
(11, 1, 11),
(12, 1, 12),
(13, 1, 13),
(14, 1, 14),
(15, 1, 15);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `user_profiles`
--

CREATE TABLE IF NOT EXISTS `user_profiles` (
  `upro_id` int(11) NOT NULL AUTO_INCREMENT,
  `upro_uacc_fk` int(11) NOT NULL DEFAULT '0',
  `upro_company` varchar(50) NOT NULL DEFAULT '',
  `upro_first_name` varchar(50) NOT NULL DEFAULT '',
  `upro_last_name` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`upro_id`),
  UNIQUE KEY `upro_id` (`upro_id`),
  KEY `upro_uacc_fk` (`upro_uacc_fk`) USING BTREE
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Gegevens worden uitgevoerd voor tabel `user_profiles`
--

INSERT INTO `user_profiles` (`upro_id`, `upro_uacc_fk`, `upro_company`, `upro_first_name`, `upro_last_name`) VALUES
(1, 1, '', 'John', 'Teacher'),
(3, 3, '', 'Joe', 'Student');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
