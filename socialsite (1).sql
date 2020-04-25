-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 08, 2020 at 06:15 AM
-- Server version: 10.3.16-MariaDB
-- PHP Version: 7.1.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `socialsite`
--

-- --------------------------------------------------------

--
-- Table structure for table `about`
--

CREATE TABLE `about` (
  `username` varchar(30) NOT NULL,
  `education` varchar(30) NOT NULL,
  `subject` varchar(20) NOT NULL,
  `phonenumber` varchar(11) NOT NULL,
  `propic` varchar(100) NOT NULL,
  `coverpic` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `about`
--

INSERT INTO `about` (`username`, `education`, `subject`, `phonenumber`, `propic`, `coverpic`) VALUES
('admin', 'N/A', 'N/A', 'N/A', 'blankImage/propic.jpg', 'blankImage/coverpic.jpg'),
('afif1234', 'NSU', 'EEE', '01571798589', 'propic/afif1234.jpg', 'coverpic/afif1234.jpg'),
('Batman', 'Harvard', 'CSE', '12323423542', 'propic/Batman.jpg', 'coverpic/Batman.jpg'),
('koushiq', 'N/A', 'N/A', 'N/A', 'blankImage/propic.jpg', 'blankImage/coverpic.jpg'),
('koushiq1234', 'AIUB', 'CSE', '01571798589', 'propic/koushiq1234.jpg', 'coverpic/koushiq1234.jpg'),
('root', 'AIUB', 'CSE', '11315645', 'propic/root.jpg', 'coverpic/root.jpg'),
('rownak', 'AIUB', 'CSE', '1231243646', 'propic/rownak.jpg', 'coverpic/rownak.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `admininfo`
--

CREATE TABLE `admininfo` (
  `username` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admininfo`
--

INSERT INTO `admininfo` (`username`, `password`) VALUES
('root', '1234');

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `postid` int(100) NOT NULL,
  `username` varchar(30) NOT NULL,
  `content` varchar(1000) NOT NULL,
  `picture` varchar(100) NOT NULL,
  `likecount` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`postid`, `username`, `content`, `picture`, `likecount`) VALUES
(0, 'root', 'Hehehehe!', 'postpic/root0.jpg', '0'),
(1, 'root', 'lolololol', 'postpic/root1.jpg', '0'),
(2, 'root', 'wassupppp', 'postpic/root2.jpg', '0'),
(3, 'root', '#asdasd', 'postpic/root3.jpg', '0'),
(4, 'Batman', 'Feeling cute \r\nmight beat up thugs tonight!', 'postpic/Batman4.jpg', '0'),
(5, 'afif1234', 'This guy is awesome', 'postpic/afif12345.jpg', '0'),
(6, 'rownak', 'Coollll', 'postpic/rownak6.jpg', '0'),
(7, 'rownak', 'adfdsafgdsf', 'postpic/rownak7.jpg', '0'),
(8, 'rownak', 'asdasdasdas', 'postpic/rownak8.jpg', '0'),
(9, 'root', '#Asdasdasd', 'postpic/root9.jpg', '0'),
(10, 'koushiq1234', 'dasdasdasdas', 'postpic/koushiq123410.jpg', '0'),
(11, 'koushiq1234', '12312321312', 'postpic/koushiq123411.jpg', '0'),
(12, 'koushiq1234', 'dasdasdasdas', 'postpic/koushiq123412.jpg', '0');

-- --------------------------------------------------------

--
-- Table structure for table `userinfo`
--

CREATE TABLE `userinfo` (
  `username` varchar(30) NOT NULL,
  `firstName` varchar(10) NOT NULL,
  `lastName` varchar(10) NOT NULL,
  `password` varchar(30) NOT NULL,
  `dateOfBirth` date NOT NULL,
  `securityQuestion` varchar(20) NOT NULL,
  `gender` varchar(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `userinfo`
--

INSERT INTO `userinfo` (`username`, `firstName`, `lastName`, `password`, `dateOfBirth`, `securityQuestion`, `gender`) VALUES
('admin', 'Mushfiqur', 'Rahman', '123', '2007-12-03', 'titanic', 'male'),
('afif1234', 'Mushfiqur', 'Rahman', '1234', '1996-07-25', 'titanic', 'male'),
('Batman', 'Bruce', 'Wayne', '1234', '0000-00-00', 'batman', 'male'),
('koushiq', 'Mushfiqur', 'Rahman', '1234', '1996-06-10', 'titanic', 'male'),
('koushiq1234', 'Mushfiqur', 'Rahman', '1234', '1996-06-10', 'Harry Potter', 'male'),
('root', 'Mushfiqur', 'Rahman', '1234', '0000-00-00', 'titanic', 'male'),
('rownak', 'MRRownak', 'Abin', '1234', '1996-08-23', 'Gispy', 'male');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `about`
--
ALTER TABLE `about`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `admininfo`
--
ALTER TABLE `admininfo`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`postid`);

--
-- Indexes for table `userinfo`
--
ALTER TABLE `userinfo`
  ADD PRIMARY KEY (`username`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
