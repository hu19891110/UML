/*
  UMLchecker_database.sql
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for `ci_sessions`
-- ----------------------------
DROP TABLE IF EXISTS `ci_sessions`;
CREATE TABLE `ci_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(16) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) DEFAULT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL DEFAULT '',
  PRIMARY KEY (`session_id`),
  KEY `last_activity` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of ci_sessions
-- ----------------------------


-- ----------------------------
-- Table structure for `user_profiles`
-- ----------------------------
DROP TABLE IF EXISTS `user_profiles`;
CREATE TABLE `user_profiles` (
  `upro_id` int(11) NOT NULL AUTO_INCREMENT,
  `upro_uacc_fk` int(11) NOT NULL DEFAULT '0',
  `upro_company` varchar(50) NOT NULL DEFAULT '',
  `upro_first_name` varchar(50) NOT NULL DEFAULT '',
  `upro_last_name` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`upro_id`),
  UNIQUE KEY `upro_id` (`upro_id`),
  KEY `upro_uacc_fk` (`upro_uacc_fk`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of user_profiles
-- ----------------------------
INSERT INTO `user_profiles` VALUES ('1', '1', '', 'John', 'Teacher');
INSERT INTO `user_profiles` VALUES ('3', '3', '', 'Joe', 'Student');

-- ----------------------------
-- Table structure for `user_accounts`
-- ----------------------------
DROP TABLE IF EXISTS `user_accounts`;
CREATE TABLE `user_accounts` (
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of user_accounts
-- ----------------------------
INSERT INTO `user_accounts` VALUES ('1', '2', '1', 'admin@admin.com', 'admin', '$2a$08$lSOQGNqwBFUEDTxm2Y.hb.mfPEAt/iiGY9kJsZsd4ekLJXLD.tCrq', '0.0.0.0', 'XKVT29q2Jr', '', '', '0000-00-00 00:00:00', '', '', '1', '0', '0', '', '0000-00-00 00:00:00', '2012-04-12 21:15:05', '2011-01-01 00:00:00' ,'1', '1');
INSERT INTO `user_accounts` VALUES ('2', '1', '1', 'public@public.com', 'public', '$2a$08$GlxQ00VKlev2t.CpvbTOlepTJljxF2RocJghON37r40mbDl4vJLv2', '0.0.0.0', 'CDNFV6dHmn', '', '', '0000-00-00 00:00:00', '', '', '1', '0', '0', '', '0000-00-00 00:00:00', '2012-04-10 22:01:41', '2011-09-15 12:24:45', '1', '1');

-- ----------------------------
-- Table structure for `user_groups`
-- ----------------------------
DROP TABLE IF EXISTS `user_groups`;
CREATE TABLE `user_groups` (
  `ugrp_id` smallint(5) NOT NULL AUTO_INCREMENT,
  `ugrp_name` varchar(20) NOT NULL DEFAULT '',
  `ugrp_desc` varchar(100) NOT NULL DEFAULT '',
  `ugrp_admin` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ugrp_id`),
  UNIQUE KEY `ugrp_id` (`ugrp_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;



-- ----------------------------
-- Records of user_groups
-- ----------------------------
INSERT INTO `user_groups` VALUES ('1', 'Student', 'Student : has no admin access rights.', '0');
INSERT INTO `user_groups` VALUES ('2', 'Teacher', 'Teacher : has full admin access rights.', '1');

-- ----------------------------
-- Table structure for `student_class`
-- ----------------------------
DROP TABLE IF EXISTS `student_classes`;
CREATE TABLE `student_classes` (
  `studentclass_id` smallint(5) NOT NULL AUTO_INCREMENT,
  `studentclass_name` varchar(20) NOT NULL DEFAULT '',
  `studentclass_desc` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`studentclass_id`),
  UNIQUE KEY `studentclass_id` (`studentclass_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;


-- ----------------------------
-- Records of user_groups
-- ----------------------------
INSERT INTO `student_classes` VALUES ('1', 'None', 'Student is not in a class.');

-- ----------------------------
-- Table structure for `user_login_sessions`
-- ----------------------------
DROP TABLE IF EXISTS `user_login_sessions`;
CREATE TABLE `user_login_sessions` (
  `usess_uacc_fk` int(11) NOT NULL DEFAULT '0',
  `usess_series` varchar(40) NOT NULL DEFAULT '',
  `usess_token` varchar(40) NOT NULL DEFAULT '',
  `usess_login_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`usess_token`),
  UNIQUE KEY `usess_token` (`usess_token`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of user_login_sessions
-- ----------------------------

-- ----------------------------
-- Table structure for `user_privileges`
-- ----------------------------
DROP TABLE IF EXISTS `user_privileges`;
CREATE TABLE `user_privileges` (
  `upriv_id` smallint(5) NOT NULL AUTO_INCREMENT,
  `upriv_name` varchar(20) NOT NULL DEFAULT '',
  `upriv_desc` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`upriv_id`),
  UNIQUE KEY `upriv_id` (`upriv_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of user_privileges
-- ----------------------------
INSERT INTO `user_privileges` VALUES ('1', 'View Users', 'User can view user account details.');
INSERT INTO `user_privileges` VALUES ('2', 'View User Groups', 'User can view user groups.');
INSERT INTO `user_privileges` VALUES ('3', 'View Privileges', 'User can view privileges.');
INSERT INTO `user_privileges` VALUES ('4', 'Insert User Groups', 'User can insert new user groups.');
INSERT INTO `user_privileges` VALUES ('5', 'Insert Privileges', 'User can insert privileges.');
INSERT INTO `user_privileges` VALUES ('6', 'Update Users', 'User can update user account details.');
INSERT INTO `user_privileges` VALUES ('7', 'Update User Groups', 'User can update user groups.');
INSERT INTO `user_privileges` VALUES ('8', 'Update Privileges', 'User can update user privileges.');
INSERT INTO `user_privileges` VALUES ('9', 'Delete Users', 'User can delete user accounts.');
INSERT INTO `user_privileges` VALUES ('10', 'Delete User Groups', 'User can delete user groups.');
INSERT INTO `user_privileges` VALUES ('11', 'Delete Privileges', 'User can delete user privileges.');
INSERT INTO `user_privileges` VALUES ('12', 'View Student Classes', 'User can view student classes.');
INSERT INTO `user_privileges` VALUES ('13', 'Update Student Classes', 'User can update student classes.');
INSERT INTO `user_privileges` VALUES ('14', 'Insert Student Classes', 'User can insert student classes.');
INSERT INTO `user_privileges` VALUES ('15', 'Delete Student Classes', 'User can delete student classes.');
-- ----------------------------
-- Table structure for `user_privilege_users`
-- ----------------------------
DROP TABLE IF EXISTS `user_privilege_users`;
CREATE TABLE `user_privilege_users` (
  `upriv_users_id` smallint(5) NOT NULL AUTO_INCREMENT,
  `upriv_users_uacc_fk` int(11) NOT NULL DEFAULT '0',
  `upriv_users_upriv_fk` smallint(5) NOT NULL DEFAULT '0',
  PRIMARY KEY (`upriv_users_id`),
  UNIQUE KEY `upriv_users_id` (`upriv_users_id`) USING BTREE,
  KEY `upriv_users_uacc_fk` (`upriv_users_uacc_fk`),
  KEY `upriv_users_upriv_fk` (`upriv_users_upriv_fk`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of user_privilege_users
-- ----------------------------
INSERT INTO `user_privilege_users` VALUES ('1', '1', '1');
INSERT INTO `user_privilege_users` VALUES ('2', '1', '2');
INSERT INTO `user_privilege_users` VALUES ('3', '1', '3');
INSERT INTO `user_privilege_users` VALUES ('4', '1', '4');
INSERT INTO `user_privilege_users` VALUES ('5', '1', '5');
INSERT INTO `user_privilege_users` VALUES ('6', '1', '6');
INSERT INTO `user_privilege_users` VALUES ('7', '1', '7');
INSERT INTO `user_privilege_users` VALUES ('8', '1', '8');
INSERT INTO `user_privilege_users` VALUES ('9', '1', '9');
INSERT INTO `user_privilege_users` VALUES ('10', '1', '10');
INSERT INTO `user_privilege_users` VALUES ('11', '1', '11');
INSERT INTO `user_privilege_users` VALUES ('12', '1', '12');
INSERT INTO `user_privilege_users` VALUES ('13', '1', '13');
INSERT INTO `user_privilege_users` VALUES ('14', '1', '14');
INSERT INTO `user_privilege_users` VALUES ('15', '1', '15');


-- ----------------------------
-- Table structure for `user_privilege_groups`
-- ----------------------------

DROP TABLE IF EXISTS `user_privilege_groups`;
CREATE TABLE `user_privilege_groups` (
  `upriv_groups_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `upriv_groups_ugrp_fk` smallint(5) unsigned NOT NULL DEFAULT '0',
  `upriv_groups_upriv_fk` smallint(5) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`upriv_groups_id`),
  UNIQUE KEY `upriv_groups_id` (`upriv_groups_id`) USING BTREE,
  KEY `upriv_groups_ugrp_fk` (`upriv_groups_ugrp_fk`),
  KEY `upriv_groups_upriv_fk` (`upriv_groups_upriv_fk`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;


-- ----------------------------
-- Records of user_privilege_groups
-- ----------------------------

INSERT INTO `user_privilege_groups` VALUES(1, 3, 1);
INSERT INTO `user_privilege_groups` VALUES(3, 3, 3);
INSERT INTO `user_privilege_groups` VALUES(4, 3, 4);
INSERT INTO `user_privilege_groups` VALUES(5, 3, 5);
INSERT INTO `user_privilege_groups` VALUES(6, 3, 6);
INSERT INTO `user_privilege_groups` VALUES(7, 3, 7);
INSERT INTO `user_privilege_groups` VALUES(8, 3, 8);
INSERT INTO `user_privilege_groups` VALUES(9, 3, 9);
INSERT INTO `user_privilege_groups` VALUES(10, 3, 10);
INSERT INTO `user_privilege_groups` VALUES(11, 3, 11);
INSERT INTO `user_privilege_groups` VALUES(12, 2, 2);
INSERT INTO `user_privilege_groups` VALUES(13, 2, 4);
INSERT INTO `user_privilege_groups` VALUES(14, 2, 5);

-- ----------------------------
-- Table structure for 'deadlines'
-- ----------------------------
DROP TABLE IF EXISTS `deadlines`;
CREATE TABLE `deadlines` (
  `deadline_id` smallint(5) NOT NULL AUTO_INCREMENT,
  `deadline_desc` varchar(50) NOT NULL DEFAULT '',
  `deadline_enddate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deadline_date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`deadline_id`),
  UNIQUE KEY `deadline_id` (`deadline_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for `class_deadlines`
-- ----------------------------
DROP TABLE IF EXISTS `class_deadlines`;
CREATE TABLE `class_deadlines` (
  `class_deadline_id` smallint(5) NOT NULL AUTO_INCREMENT,
  `deadline_deadline_id_fk` int(11) NOT NULL DEFAULT '0',
  `deadline_class_id_fk` smallint(5) NOT NULL DEFAULT '0',
  PRIMARY KEY (`class_deadline_id`),
  UNIQUE KEY `class_deadline_id` (`class_deadline_id`) USING BTREE,
  KEY `upriv_users_uacc_fk` (`deadline_deadline_id_fk`),
  KEY `deadline_class_id_fk` (`deadline_class_id_fk`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for assignments
-- ----------------------------
DROP TABLE IF EXISTS `assignments`;
CREATE TABLE `assignments` (
	`assignment_id` smallint(5) NOT NULL AUTO_INCREMENT,
	`assignment_desc` varchar(50) NOT NULL DEFAULT '',
	`assignment_name` varchar(50) NOT NULL DEFAULT '',
  `assignment_checked` smallint(5) NOT NULL DEFAULT '0',
	`deadline_id_fk` smallint(5),
	PRIMARY KEY (`assignment_id`),
	KEY deadline_id_fk (`deadline_id_fk`)
);
	

-- --------------------------------------------------------
--
-- Tabelstructuur voor tabel `checker_errors`
--
DROP TABLE IF EXISTS `uploads`;
CREATE TABLE `uploads` (
  `student_id` int(11) NOT NULL DEFAULT '0',
  `deadline_id` int(11) NOT NULL,
  `grade` int(11) NOT NULL,
  `faults` varchar(9999) NOT NULL,
  `Type` int(11) NOT NULL,
  PRIMARY KEY (`student_id`,`deadline_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `checker_errors`
--

DROP TABLE IF EXISTS `checker_errors`;
CREATE TABLE `checker_errors` (
  `ce_id` int(11) NOT NULL AUTO_INCREMENT,
  `ce_student_id` int(11) NOT NULL DEFAULT '0',
  `ce_deadline_id` int(11) NOT NULL DEFAULT '0',
  `ce_error_id` int(11) NOT NULL DEFAULT '0',
  `ce_class_name` varchar(30) NOT NULL DEFAULT '',
  `ce_operation_name` varchar(30) NOT NULL DEFAULT '',
  `ce_attribute_name` varchar(30) NOT NULL DEFAULT '',
  `ce_parameter_name` varchar(30) NOT NULL DEFAULT '',
  `ce_datatype` varchar(20) NOT NULL DEFAULT '',
  `ce_relatie` varchar(30) NOT NULL DEFAULT '',
  `ce_eigenschappen` varchar(30) NOT NULL DEFAULT '',
  PRIMARY KEY (`ce_id`),
  UNIQUE KEY `ce_id` (`ce_id`),
  KEY `ce_student_id` (`ce_student_id`) USING BTREE,
  KEY `ce_deadline_id` (`ce_deadline_id`) USING BTREE,
  KEY `ce_error_id` (`ce_error_id`) USING BTREE
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;



-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `UML_errors`
--

DROP TABLE IF EXISTS `uml_errors`;
CREATE TABLE `uml_errors` (
  `ue_id` int(11) NOT NULL AUTO_INCREMENT,
  `ue_name` varchar(40) NOT NULL DEFAULT '',
  `ue_desc` varchar(60) NOT NULL DEFAULT '',
  `ue_error_value` smallint(2) NOT NULL DEFAULT '0',

  PRIMARY KEY (`ue_id`),
  UNIQUE KEY `ue_id` (`ue_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4;


-- HIER MOET NOG GEGEVENS VAN ELKE ERROR INGELADEN WORDEN.

INSERT INTO `uml_errors` (`ue_id`, `ue_name`,`ue_desc`,`ue_error_value`) VALUES
(1, 'Relatie naam anders', 'Relatie naam is anders' , '0.1'),
(2, 'Relatie begin', 'Relatie heeft ander begin' , '0.3'),
(3, 'Relatie eind', 'Relatie heeft ander eind' , '0.3'),
(4, 'Relatie soort', 'Relatie heeft andere soort' , '0.2'),
(5, 'Relatie multipliciteit', 'Relatie heeft verkeerde multipliciteit' , '0.3'),
(6, 'Datatype attribuut', 'Datatype van attribuut is fout' , '0.3'),
(7, 'Datatype parameter', 'Datatype van parameter is fout' , '0.3'),
(8, 'Parameter missing', 'Parameter is niet aanwezig' , '0.3'),
(9, 'Operation missing', 'Operation is niet aanwezig' , '0.3'),
(10, 'Attribuut missing', 'Attribuut is niet aanwezig' , '0.3'),
(11, 'Stereotype fout', 'Stereotype is fout' , '0.3'),
(12, 'Return type fout', 'Return type is fout' , '0.3'),
(13, 'Operatie variabelen fout', 'Variabelen van de operatie zijn fout' , '0.1'),
(14, 'Attribuut Variable fout', 'Variabelen van attribuut zijn fout' , '0.3'),
(15, 'Class fout', 'Class is niet aanwezig' , '0.5');

