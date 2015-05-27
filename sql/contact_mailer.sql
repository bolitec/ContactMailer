-- phpMyAdmin SQL Dump
-- version 4.1.8
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 01, 2014 at 02:17 PM
-- Server version: 5.1.73-cll
-- PHP Version: 5.4.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `bolitest_contact_mailer`
--
CREATE DATABASE IF NOT EXISTS `contact_mailer` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `contact_mailer`;

-- --------------------------------------------------------

--
-- Table structure for table `Emails`
--

DROP TABLE IF EXISTS `Emails`;
CREATE TABLE IF NOT EXISTS `Emails` (
  `email_key` int(11) NOT NULL AUTO_INCREMENT,
  `grp_name` varchar(50) CHARACTER SET armscii8 NOT NULL,
  `first_name` text COLLATE utf8_unicode_ci NOT NULL,
  `last_name` text COLLATE utf8_unicode_ci NOT NULL,
  `email_1` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `email_2` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`email_key`),
  UNIQUE KEY `email_1` (`email_1`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=354 ;

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

DROP TABLE IF EXISTS `member`;
CREATE TABLE IF NOT EXISTS `member` (
  `vchEmail` varchar(50) NOT NULL,
  `vchPassword` varchar(32) NOT NULL,
  `chIP` char(15) NOT NULL,
  `dtRegistered` char(25) NOT NULL,
  PRIMARY KEY (`vchEmail`)
) ENGINE=MyISAM DEFAULT CHARSET=ascii COMMENT='Contains email and password';

-- --------------------------------------------------------

--
-- Table structure for table `profile`
--

DROP TABLE IF EXISTS `profile`;
CREATE TABLE IF NOT EXISTS `profile` (
  `iUserId` int(11) NOT NULL AUTO_INCREMENT,
  `vchEmail` varchar(50) NOT NULL,
  `vchFirstName` varchar(100) DEFAULT NULL,
  `vchLastName` varchar(100) DEFAULT NULL,
  `vchAddress1` varchar(100) DEFAULT NULL,
  `vchAddress2` varchar(100) DEFAULT NULL,
  `vchAddress3` varchar(100) DEFAULT NULL,
  `vchCity` varchar(100) DEFAULT NULL,
  `vchState` varchar(100) DEFAULT NULL,
  `vchPhone` varchar(30) DEFAULT NULL,
  `vchGroup` varchar(50) DEFAULT NULL,
  `tsRegModified` char(25) DEFAULT NULL,
  `iNum_ads` int(11) DEFAULT '0',
  `vchCountry` varchar(40) DEFAULT NULL,
  `tiHide_email` tinyint(4) DEFAULT NULL,
  `vchEmail_2` varchar(50) DEFAULT NULL,
  `chAdmin` char(2) DEFAULT NULL,
  `vchUsr_2` varchar(150) DEFAULT NULL,
  `vchUsr_3` varchar(150) DEFAULT NULL,
  `vchUsr_4` varchar(150) DEFAULT NULL,
  `vchUsr_5` varchar(150) DEFAULT NULL,
  `vchZip` varchar(12) DEFAULT NULL,
  PRIMARY KEY (`iUserId`),
  UNIQUE KEY `Email` (`vchEmail`)
) ENGINE=MyISAM  DEFAULT CHARSET=ascii COMMENT='Details of a member key' AUTO_INCREMENT=190 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
