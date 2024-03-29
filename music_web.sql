-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 10, 2024 at 06:24 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `music_web`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `adname` varchar(11) NOT NULL,
  `adpassword` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`adname`, `adpassword`) VALUES
('admin', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `albums`
--

CREATE TABLE `albums` (
  `alid` int(11) NOT NULL,
  `alname` varchar(255) NOT NULL,
  `alimage` varchar(255) NOT NULL,
  `alview` int(11) NOT NULL,
  `alstatus` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `albums`
--

INSERT INTO `albums` (`alid`, `alname`, `alimage`, `alview`, `alstatus`) VALUES
(6, 'Album1323212', '2.jpg', 111, 0),
(7, 'ALbum2', '65ebe60f4abfc.jpg', 5, 0),
(8, 'Album3', '65e939004d110.jpg', 0, 0),
(9, 'Nhạc Việt Nam', '65ebf6a5540ef.jpg', 0, 1),
(10, 'Nhạc nước ngoài', '65ebf6c27f452.jpg', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `albums_songs`
--

CREATE TABLE `albums_songs` (
  `id` int(11) NOT NULL,
  `alid` int(11) NOT NULL,
  `sid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `albums_songs`
--

INSERT INTO `albums_songs` (`id`, `alid`, `sid`) VALUES
(25, 8, 11),
(26, 8, 12),
(30, 6, 10),
(31, 6, 11),
(32, 9, 13),
(33, 9, 16),
(34, 10, 14),
(35, 10, 15);

-- --------------------------------------------------------

--
-- Table structure for table `artists`
--

CREATE TABLE `artists` (
  `aid` int(11) NOT NULL,
  `aname` varchar(255) NOT NULL,
  `aimage` varchar(255) NOT NULL,
  `aview` int(11) NOT NULL,
  `astatus` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `artists`
--

INSERT INTO `artists` (`aid`, `aname`, `aimage`, `aview`, `astatus`) VALUES
(3, 'Nguyễn Trần Trung Quân 2', '2.jpg', 0, 0),
(4, 'Jack23', '65df21c9dd0c5.jpg', 0, 0),
(5, 'hai ba bốn', '65df21cfbd03c.jpg', 123, 0),
(6, 'abc', '65de92b8a475d.jpg', 0, 0),
(7, 'Sơn Tùng MTP', '65ebed191ae1f.jpg', 0, 1),
(8, 'Vengaboys', '65ebedefd7c8d.jpg', 0, 1),
(9, 'Drake', '65ebee6620dbf.jpg', 0, 1),
(10, 'Lynk Lee', '65ebef4267301.jpg', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `notify`
--

CREATE TABLE `notify` (
  `nid` int(11) NOT NULL,
  `nname` varchar(200) NOT NULL,
  `ndesc` varchar(200) NOT NULL,
  `nimage` varchar(200) NOT NULL,
  `nlink` varchar(200) DEFAULT NULL,
  `nstatus` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notify`
--

INSERT INTO `notify` (`nid`, `nname`, `ndesc`, `nimage`, `nlink`, `nstatus`) VALUES
(4, 'Thông báo 1', 'Những bài hát hay nhất mới được cập nhật ngày 07/03', '65e97d41e81ed.jpg', 'index.php', 1);

-- --------------------------------------------------------

--
-- Table structure for table `playlist`
--

CREATE TABLE `playlist` (
  `pid` int(11) NOT NULL,
  `pname` varchar(255) NOT NULL,
  `uid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `playlist`
--

INSERT INTO `playlist` (`pid`, `pname`, `uid`) VALUES
(4, 'Tên Playlist mới', 8),
(5, 'Tên Playlist mới', 8);

-- --------------------------------------------------------

--
-- Table structure for table `podcasts`
--

CREATE TABLE `podcasts` (
  `poid` int(11) NOT NULL,
  `poname` varchar(255) NOT NULL,
  `poimage` varchar(255) NOT NULL,
  `polink` varchar(255) NOT NULL,
  `poview` int(11) NOT NULL DEFAULT 0,
  `aid` int(11) NOT NULL,
  `postatus` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `podcasts`
--

INSERT INTO `podcasts` (`poid`, `poname`, `poimage`, `polink`, `poview`, `aid`, `postatus`) VALUES
(2, 'dang cap', 'Fukumean.jpg', '2.mp3', 0, 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `songs`
--

CREATE TABLE `songs` (
  `sid` int(11) NOT NULL,
  `sname` varchar(255) NOT NULL,
  `simage` varchar(255) NOT NULL,
  `slink` varchar(255) NOT NULL,
  `sview` int(11) NOT NULL DEFAULT 0,
  `sstatus` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `songs`
--

INSERT INTO `songs` (`sid`, `sname`, `simage`, `slink`, `sview`, `sstatus`) VALUES
(10, 'Fukumean', '2.jpg', '2.mp3', 0, 0),
(11, 'DucAnhBOM', '65ebe46301914.jpg', '65e5764599065.mp3', 0, 0),
(12, 'Dycccc', '65ebe476761b5.jpg', '65e577c4451a1.mp3', 0, 0),
(13, 'Em của ngày hôm qua', '65ebedaf61920.jpg', '65ebedaf619d7.mp3', 0, 1),
(14, 'Boom boom boom', '65ebee0f63270.jpg', '65ebee0f6331c.mp3', 0, 1),
(15, 'Gods plan', '65ebef090ac6f.jpg', '65ebef090aded.mp3', 0, 1),
(16, 'Em ơi', '65ebef66b067f.jpg', '65ebef66b0731.mp3', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `songs_artists`
--

CREATE TABLE `songs_artists` (
  `id` int(11) NOT NULL,
  `sid` int(11) NOT NULL,
  `aid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `songs_artists`
--

INSERT INTO `songs_artists` (`id`, `sid`, `aid`) VALUES
(12, 10, 3),
(28, 11, 3),
(29, 11, 4),
(30, 11, 5),
(31, 12, 4),
(32, 12, 5),
(33, 12, 6),
(34, 13, 7),
(35, 14, 8),
(36, 15, 9),
(37, 16, 10);

-- --------------------------------------------------------

--
-- Table structure for table `songs_playlist`
--

CREATE TABLE `songs_playlist` (
  `id` int(11) NOT NULL,
  `sid` int(11) NOT NULL,
  `pid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `songs_playlist`
--

INSERT INTO `songs_playlist` (`id`, `sid`, `pid`) VALUES
(14, 11, 5),
(16, 11, 5),
(20, 11, 4),
(21, 11, 4),
(22, 12, 4),
(23, 12, 5),
(24, 11, 4),
(25, 12, 5);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `uid` int(11) NOT NULL,
  `uemail` varchar(255) NOT NULL,
  `uname` varchar(255) NOT NULL,
  `upassword` varchar(255) NOT NULL,
  `ustatus` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`uid`, `uemail`, `uname`, `upassword`, `ustatus`) VALUES
(8, 'ducanhb8a4@gmail.com', 'DucAnh4r', '123', 1),
(9, 'dadasdadasd', 'DucAnh4r222', '222', 1),
(10, 'ducanhb8a4@gmail.com22', 'DucAnh4radsa', '123', 1),
(11, 'adasd@gmail.côm', 'acc', '123', 1),
(12, 'adsd3333', 'ddd', '123', 1),
(13, 'adsd33332', 'dddd', '123', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `albums`
--
ALTER TABLE `albums`
  ADD PRIMARY KEY (`alid`);

--
-- Indexes for table `albums_songs`
--
ALTER TABLE `albums_songs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sid` (`sid`),
  ADD KEY `alid` (`alid`);

--
-- Indexes for table `artists`
--
ALTER TABLE `artists`
  ADD PRIMARY KEY (`aid`);

--
-- Indexes for table `notify`
--
ALTER TABLE `notify`
  ADD PRIMARY KEY (`nid`);

--
-- Indexes for table `playlist`
--
ALTER TABLE `playlist`
  ADD PRIMARY KEY (`pid`),
  ADD KEY `uid` (`uid`);

--
-- Indexes for table `podcasts`
--
ALTER TABLE `podcasts`
  ADD PRIMARY KEY (`poid`),
  ADD KEY `aid` (`aid`);

--
-- Indexes for table `songs`
--
ALTER TABLE `songs`
  ADD PRIMARY KEY (`sid`);

--
-- Indexes for table `songs_artists`
--
ALTER TABLE `songs_artists`
  ADD PRIMARY KEY (`id`),
  ADD KEY `aid` (`aid`),
  ADD KEY `sid` (`sid`);

--
-- Indexes for table `songs_playlist`
--
ALTER TABLE `songs_playlist`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pid` (`pid`),
  ADD KEY `sid` (`sid`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`uid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `albums`
--
ALTER TABLE `albums`
  MODIFY `alid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `albums_songs`
--
ALTER TABLE `albums_songs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `artists`
--
ALTER TABLE `artists`
  MODIFY `aid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `notify`
--
ALTER TABLE `notify`
  MODIFY `nid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `playlist`
--
ALTER TABLE `playlist`
  MODIFY `pid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `podcasts`
--
ALTER TABLE `podcasts`
  MODIFY `poid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `songs`
--
ALTER TABLE `songs`
  MODIFY `sid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `songs_artists`
--
ALTER TABLE `songs_artists`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `songs_playlist`
--
ALTER TABLE `songs_playlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `albums_songs`
--
ALTER TABLE `albums_songs`
  ADD CONSTRAINT `albums_songs_ibfk_2` FOREIGN KEY (`sid`) REFERENCES `songs` (`sid`),
  ADD CONSTRAINT `albums_songs_ibfk_3` FOREIGN KEY (`alid`) REFERENCES `albums` (`alid`);

--
-- Constraints for table `playlist`
--
ALTER TABLE `playlist`
  ADD CONSTRAINT `playlist_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `user` (`uid`);

--
-- Constraints for table `podcasts`
--
ALTER TABLE `podcasts`
  ADD CONSTRAINT `podcasts_ibfk_1` FOREIGN KEY (`aid`) REFERENCES `artists` (`aid`);

--
-- Constraints for table `songs_artists`
--
ALTER TABLE `songs_artists`
  ADD CONSTRAINT `songs_artists_ibfk_1` FOREIGN KEY (`aid`) REFERENCES `artists` (`aid`),
  ADD CONSTRAINT `songs_artists_ibfk_2` FOREIGN KEY (`sid`) REFERENCES `songs` (`sid`);

--
-- Constraints for table `songs_playlist`
--
ALTER TABLE `songs_playlist`
  ADD CONSTRAINT `songs_playlist_ibfk_1` FOREIGN KEY (`pid`) REFERENCES `playlist` (`pid`),
  ADD CONSTRAINT `songs_playlist_ibfk_2` FOREIGN KEY (`sid`) REFERENCES `songs` (`sid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
