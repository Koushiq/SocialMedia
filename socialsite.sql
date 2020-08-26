-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 26, 2020 at 06:19 AM
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
('admin', 'NSU', 'BBa', '13123122', 'propic/admin-23.jpg', 'coverpic/admin-44.jpg'),
('afif1234', 'NSU', 'EEE', '01571798589', 'propic/afif1234.jpg', 'coverpic/afif1234.jpg'),
('Batman', 'Harvard', 'CSE', '12323423542', 'propic/Batman-39.jpg', 'coverpic/Batman-40.jpg'),
('koushiq', 'N/A', 'N/A', 'N/A', 'blankImage/propic.jpg', 'blankImage/coverpic.jpg'),
('koushiq1234', 'AIUB', 'CSE', '01571798589', 'propic/koushiq1234.jpg', 'coverpic/koushiq1234.jpg'),
('prodipta', 'AIUB', 'CSE', '123123123', 'propic/prodipta-34.jpg', 'coverpic/prodipta-20.jpg');

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
('fifa1234', '1234'),
('root', '1234');

-- --------------------------------------------------------

--
-- Table structure for table `friend`
--

CREATE TABLE `friend` (
  `friendId` int(255) NOT NULL,
  `username` varchar(30) NOT NULL,
  `receivername` varchar(30) NOT NULL,
  `usernameFirstName` varchar(30) NOT NULL,
  `usernameLastName` varchar(30) NOT NULL,
  `receivernameFirstName` varchar(30) NOT NULL,
  `receivernameLastName` varchar(30) NOT NULL,
  `usernamePropic` varchar(100) NOT NULL,
  `receivernamePropic` varchar(30) NOT NULL,
  `status` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `friend`
--

INSERT INTO `friend` (`friendId`, `username`, `receivername`, `usernameFirstName`, `usernameLastName`, `receivernameFirstName`, `receivernameLastName`, `usernamePropic`, `receivernamePropic`, `status`) VALUES
(31, 'admin', 'prodipta', 'Forda', 'William', 'Joyce', 'Prodipta', 'propic/admin-23.jpg', 'propic/prodipta-34.jpg', 'accepted'),
(33, 'Batman', 'prodipta', 'Bruce', 'Wayne', 'Joyce', 'Prodipta', 'propic/Batman-39.jpg', 'propic/prodipta-34.jpg', 'accepted'),
(39, 'admin', 'Batman', 'Forda', 'William', 'Bruce', 'Wayne', 'propic/admin-23.jpg', 'propic/Batman-39.jpg', 'accepted'),
(43, 'Batman', 'afif1234', 'Bruce', 'Wayne', 'Afif', 'Rahman', 'propic/Batman-39.jpg', 'propic/afif1234.jpg', 'accepted');

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `messageId` int(255) NOT NULL,
  `content` varchar(918) NOT NULL,
  `messageType` varchar(10) NOT NULL,
  `senderUsername` varchar(30) NOT NULL,
  `receiverUsername` varchar(30) NOT NULL,
  `sendTime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`messageId`, `content`, `messageType`, `senderUsername`, `receiverUsername`, `sendTime`) VALUES
(144, 'Hi', 'text', 'prodipta', 'admin', '2020-05-03 16:56:38'),
(145, 'here is a meme', 'text', 'prodipta', 'admin', '2020-05-03 16:56:49'),
(146, 'messagePics/146.jpg', 'path', 'prodipta', 'admin', '2020-05-03 16:56:49'),
(147, 'haha', 'text', 'admin', 'prodipta', '2020-05-03 16:57:01'),
(148, 'messagePics/148.jpg', 'path', 'admin', 'prodipta', '2020-05-03 16:57:01'),
(152, 'Hi Bruci', 'text', 'prodipta', 'Batman', '2020-05-09 21:48:23'),
(153, 'messagePics/153.jpg', 'path', 'Batman', 'prodipta', '2020-05-09 21:48:57'),
(154, 'messagePics/154.jpg', 'path', 'prodipta', 'Batman', '2020-05-09 21:49:12'),
(155, 'Hello Prodipta How are you  ?', 'text', 'admin', 'prodipta', '2020-05-16 09:54:59'),
(156, 'Hello who ever you are ', 'text', 'prodipta', 'admin', '2020-05-18 15:14:53'),
(157, 'messagePics/157.jpg', 'path', 'prodipta', 'admin', '2020-05-18 15:14:57'),
(158, 'messagePics/158.jpg', 'path', 'admin', 'prodipta', '2020-05-19 07:07:21'),
(159, 'sadasdas', 'text', 'admin', 'prodipta', '2020-05-19 07:07:24'),
(160, 'asdasdas', 'text', 'admin', 'prodipta', '2020-05-19 07:07:30'),
(161, 'messagePics/161.jpg', 'path', 'admin', 'prodipta', '2020-05-19 07:07:30'),
(162, 'asdasdasd', 'text', 'admin', 'prodipta', '2020-05-19 07:07:56'),
(163, 'messagePics/163.jpg', 'path', 'admin', 'prodipta', '2020-05-19 07:07:56'),
(164, 'lalalalala', 'text', 'prodipta', 'admin', '2020-05-19 07:08:56'),
(165, 'asdasdasd', 'text', 'prodipta', 'admin', '2020-05-19 07:09:03'),
(166, 'messagePics/166.jpg', 'path', 'admin', 'prodipta', '2020-05-19 07:09:21'),
(167, 'messagePics/167.jpg', 'path', 'prodipta', 'admin', '2020-05-19 07:09:32'),
(168, 'asdasdas', 'text', 'Batman', 'prodipta', '2020-08-26 05:49:53'),
(169, 'messagePics/169.jpg', 'path', 'Batman', 'prodipta', '2020-08-26 05:49:59'),
(170, 'hi bruci', 'text', 'afif1234', 'Batman', '2020-08-26 05:51:40'),
(171, 'hello babe', 'text', 'Batman', 'afif1234', '2020-08-26 05:51:56');

-- --------------------------------------------------------

--
-- Table structure for table `photos`
--

CREATE TABLE `photos` (
  `photoId` bigint(255) NOT NULL,
  `username` varchar(30) NOT NULL,
  `path` varchar(100) NOT NULL,
  `type` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `photos`
--

INSERT INTO `photos` (`photoId`, `username`, `path`, `type`) VALUES
(18, 'Batman', 'coverpic/Batman-18.jpg', 'coverpic'),
(19, 'prodipta', 'propic/prodipta-19.jpg', 'propic'),
(20, 'prodipta', 'coverpic/prodipta-20.jpg', 'coverpic'),
(23, 'admin', 'propic/admin-23.jpg', 'propic'),
(27, 'prodipta', 'postpic/prodipta-24.jpg', 'postpic'),
(33, 'Batman', 'propic/Batman-28.jpg', 'propic'),
(34, 'prodipta', 'propic/prodipta-34.jpg', 'propic'),
(35, 'admin', 'postpic/admin-35.jpg', 'postpic'),
(36, 'admin', 'postpic/admin-36.jpg', 'postpic'),
(37, 'Batman', 'postpic/Batman-37.jpg', 'postpic'),
(38, 'Batman', 'postpic/Batman-38.jpg', 'postpic'),
(39, 'Batman', 'propic/Batman-39.jpg', 'propic'),
(40, 'Batman', 'coverpic/Batman-40.jpg', 'coverpic'),
(41, 'admin', 'postpic/admin-41.jpg', 'postpic'),
(42, 'admin', 'postpic/admin-42.jpg', 'postpic'),
(43, 'admin', 'postpic/admin-43.jpg', 'postpic'),
(44, 'admin', 'coverpic/admin-44.jpg', 'coverpic');

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `postid` int(100) NOT NULL,
  `username` varchar(30) NOT NULL,
  `content` varchar(1000) NOT NULL,
  `picture` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`postid`, `username`, `content`, `picture`) VALUES
(7, 'prodipta', 'hello my friends how are doing?', 'postpic/prodipta-24.jpg'),
(13, 'admin', '1231312312', 'postpic/admin-35.jpg'),
(14, 'admin', 'asdasdas', 'postpic/admin-36.jpg'),
(15, 'Batman', 'asdasdasdasdasd', 'postpic/Batman-37.jpg'),
(16, 'Batman', 'asdasdasdasd', 'postpic/Batman-38.jpg'),
(17, 'admin', 'asdsad', 'postpic/admin-41.jpg'),
(18, 'admin', 'dasdasdas', 'postpic/admin-42.jpg'),
(19, 'admin', 'asdasdasda', 'postpic/admin-43.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `postcomment`
--

CREATE TABLE `postcomment` (
  `id` int(255) NOT NULL,
  `postId` int(255) NOT NULL,
  `commentBy` varchar(30) NOT NULL,
  `commentContent` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `postcomment`
--

INSERT INTO `postcomment` (`id`, `postId`, `commentBy`, `commentContent`) VALUES
(3, 1, 'Batman', 'I am Batman'),
(4, 1, 'Batman', 'Hello World'),
(7, 5, 'Batman', 'hELL'),
(12, 7, 'prodipta', 'Hiii !'),
(15, 16, 'Batman', 'sadsadadasdas'),
(16, 7, 'admin', 'asdasdadasd'),
(17, 16, 'admin', 'asdasdasdas'),
(18, 15, 'admin', 'caustic '),
(19, 19, 'prodipta', 'asdasdasd');

-- --------------------------------------------------------

--
-- Table structure for table `postlike`
--

CREATE TABLE `postlike` (
  `id` int(255) NOT NULL,
  `postId` int(255) NOT NULL,
  `likedBy` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `postlike`
--

INSERT INTO `postlike` (`id`, `postId`, `likedBy`) VALUES
(3, 1, 'prodipta'),
(4, 5, 'prodipta'),
(9, 1, 'Batman'),
(20, 7, 'prodipta'),
(21, 15, 'admin'),
(22, 16, 'admin'),
(23, 7, 'admin'),
(24, 19, 'prodipta'),
(25, 14, 'Batman');

-- --------------------------------------------------------

--
-- Table structure for table `usercommentpermission`
--

CREATE TABLE `usercommentpermission` (
  `username` varchar(30) NOT NULL,
  `c` varchar(15) NOT NULL,
  `r` varchar(15) NOT NULL,
  `u` varchar(15) NOT NULL,
  `d` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `usercommentpermission`
--

INSERT INTO `usercommentpermission` (`username`, `c`, `r`, `u`, `d`) VALUES
('fifa1234', 'true', 'true', 'true', 'true'),
('root', 'true', 'true', 'true', 'true');

-- --------------------------------------------------------

--
-- Table structure for table `userdatapermission`
--

CREATE TABLE `userdatapermission` (
  `username` varchar(30) NOT NULL,
  `c` varchar(15) NOT NULL,
  `r` varchar(15) NOT NULL,
  `u` varchar(15) NOT NULL,
  `d` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `userdatapermission`
--

INSERT INTO `userdatapermission` (`username`, `c`, `r`, `u`, `d`) VALUES
('fifa1234', 'true', 'true', 'true', 'true'),
('root', 'true', 'true', 'true', 'true');

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
('admin', 'Forda', 'William', '123', '1996-12-03', 'James', 'female'),
('afif1234', 'Afif', 'Rahman', '1234', '1996-07-25', 'titanic', 'male'),
('Batman', 'Bruce', 'Wayne', '1234', '0000-00-00', 'batman', 'male'),
('koushiq', 'Mushfiqur', 'Rahman', '1234', '1996-06-10', 'titanic', 'male'),
('koushiq1234', 'Mushfiqur', 'Rahman', '1234', '1996-06-10', 'Harry Potter', 'male'),
('prodipta', 'Joyce', 'Prodipta', '1234', '1996-01-01', 'Hobbit', 'female');

-- --------------------------------------------------------

--
-- Table structure for table `userlikepermission`
--

CREATE TABLE `userlikepermission` (
  `username` varchar(30) NOT NULL,
  `c` varchar(15) NOT NULL,
  `r` varchar(15) NOT NULL,
  `u` varchar(15) NOT NULL,
  `d` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `userlikepermission`
--

INSERT INTO `userlikepermission` (`username`, `c`, `r`, `u`, `d`) VALUES
('fifa1234', 'true', 'true', 'true', 'true'),
('root', 'true', 'true', 'true', 'true');

-- --------------------------------------------------------

--
-- Table structure for table `usermessagepermission`
--

CREATE TABLE `usermessagepermission` (
  `username` varchar(30) NOT NULL,
  `c` varchar(15) NOT NULL,
  `r` varchar(15) NOT NULL,
  `u` varchar(15) NOT NULL,
  `d` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `usermessagepermission`
--

INSERT INTO `usermessagepermission` (`username`, `c`, `r`, `u`, `d`) VALUES
('fifa1234', 'true', 'true', 'true', 'true'),
('root', 'true', 'true', 'true', 'true');

-- --------------------------------------------------------

--
-- Table structure for table `userphotopermission`
--

CREATE TABLE `userphotopermission` (
  `username` varchar(30) NOT NULL,
  `c` varchar(15) NOT NULL,
  `r` varchar(15) NOT NULL,
  `u` varchar(15) NOT NULL,
  `d` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `userphotopermission`
--

INSERT INTO `userphotopermission` (`username`, `c`, `r`, `u`, `d`) VALUES
('fifa1234', 'true', 'true', 'true', 'true'),
('root', 'true', 'true', 'true', 'true');

-- --------------------------------------------------------

--
-- Table structure for table `userpostpermission`
--

CREATE TABLE `userpostpermission` (
  `username` varchar(30) NOT NULL,
  `c` varchar(15) NOT NULL,
  `r` varchar(15) NOT NULL,
  `u` varchar(15) NOT NULL,
  `d` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `userpostpermission`
--

INSERT INTO `userpostpermission` (`username`, `c`, `r`, `u`, `d`) VALUES
('fifa1234', 'true', 'true', 'true', 'true'),
('root', 'true', 'true', 'true', 'true');

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
-- Indexes for table `friend`
--
ALTER TABLE `friend`
  ADD PRIMARY KEY (`friendId`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`messageId`);

--
-- Indexes for table `photos`
--
ALTER TABLE `photos`
  ADD PRIMARY KEY (`photoId`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`postid`);

--
-- Indexes for table `postcomment`
--
ALTER TABLE `postcomment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `postlike`
--
ALTER TABLE `postlike`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usercommentpermission`
--
ALTER TABLE `usercommentpermission`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `userdatapermission`
--
ALTER TABLE `userdatapermission`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `userinfo`
--
ALTER TABLE `userinfo`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `userlikepermission`
--
ALTER TABLE `userlikepermission`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `usermessagepermission`
--
ALTER TABLE `usermessagepermission`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `userphotopermission`
--
ALTER TABLE `userphotopermission`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `userpostpermission`
--
ALTER TABLE `userpostpermission`
  ADD PRIMARY KEY (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `friend`
--
ALTER TABLE `friend`
  MODIFY `friendId` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `messageId` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=172;

--
-- AUTO_INCREMENT for table `photos`
--
ALTER TABLE `photos`
  MODIFY `photoId` bigint(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `postid` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `postcomment`
--
ALTER TABLE `postcomment`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `postlike`
--
ALTER TABLE `postlike`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
