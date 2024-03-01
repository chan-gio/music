-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 01, 2024 at 12:46 PM
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
  `aid` int(11) NOT NULL,
  `alstatus` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `albums`
--

INSERT INTO `albums` (`alid`, `alname`, `alimage`, `alview`, `aid`, `alstatus`) VALUES
(5, 'aaaaaaaaaaaaaaaaa', 'adf', 2, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `albums_songs`
--

CREATE TABLE `albums_songs` (
  `id` int(11) NOT NULL,
  `alid` int(11) NOT NULL,
  `sid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(3, 'Nguyễn Trần Trung Quân ', '2.jpg', 0, 1),
(4, 'Jack23', '65df21c9dd0c5.jpg', 0, 1),
(5, 'hai ba bốn', '65df21cfbd03c.jpg', 123, 1),
(6, 'abc', '65de92b8a475d.jpg', 0, 1);

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
(5, 'Tên Playlist mới', 8),
(6, 'Tên Playlist mới', 8);

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
(10, 'Fukumean', '2.jpg', '2.mp3', 0, 1);

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
(2, 10, 4),
(4, 10, 3);

-- --------------------------------------------------------

--
-- Table structure for table `songs_playlist`
--

CREATE TABLE `songs_playlist` (
  `id` int(11) NOT NULL,
  `sid` int(11) NOT NULL,
  `pid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(10, 'ducanhb8a4@gmail.com22', 'DucAnh4radsa', '123', 1);

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
  MODIFY `alid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `albums_songs`
--
ALTER TABLE `albums_songs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `artists`
--
ALTER TABLE `artists`
  MODIFY `aid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
  MODIFY `sid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `songs_artists`
--
ALTER TABLE `songs_artists`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `songs_playlist`
--
ALTER TABLE `songs_playlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

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
