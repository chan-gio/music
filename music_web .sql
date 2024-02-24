-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th2 24, 2024 lúc 07:16 AM
-- Phiên bản máy phục vụ: 10.4.28-MariaDB
-- Phiên bản PHP: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `music_web`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `albums`
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
-- Đang đổ dữ liệu cho bảng `albums`
--

INSERT INTO `albums` (`alid`, `alname`, `alimage`, `alview`, `aid`, `alstatus`) VALUES
(4, 'moi', '2.jpg', 0, 3, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `albums_songs`
--

CREATE TABLE `albums_songs` (
  `id` int(11) NOT NULL,
  `alid` int(11) NOT NULL,
  `sid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `albums_songs`
--

INSERT INTO `albums_songs` (`id`, `alid`, `sid`) VALUES
(8, 4, 7),
(10, 4, 6);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `artists`
--

CREATE TABLE `artists` (
  `aid` int(11) NOT NULL,
  `aname` varchar(255) NOT NULL,
  `aimage` varchar(255) NOT NULL,
  `aview` int(11) NOT NULL,
  `astatus` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `artists`
--

INSERT INTO `artists` (`aid`, `aname`, `aimage`, `aview`, `astatus`) VALUES
(3, 'Hoàng Thùy Linh', '2.jpg', 0, 1),
(4, 'Jack', '3.jpg', 0, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `playlist`
--

CREATE TABLE `playlist` (
  `pid` int(11) NOT NULL,
  `pname` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `playlist`
--

INSERT INTO `playlist` (`pid`, `pname`) VALUES
(1, '');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `podcasts`
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
-- Đang đổ dữ liệu cho bảng `podcasts`
--

INSERT INTO `podcasts` (`poid`, `poname`, `poimage`, `polink`, `poview`, `aid`, `postatus`) VALUES
(2, 'dang cap', 'Fukumean.jpg', '2.mp3', 0, 4, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `songs`
--

CREATE TABLE `songs` (
  `sid` int(11) NOT NULL,
  `sname` varchar(255) NOT NULL,
  `simage` varchar(255) NOT NULL,
  `slink` varchar(255) NOT NULL,
  `aid` int(11) DEFAULT NULL,
  `sview` int(11) NOT NULL DEFAULT 0,
  `sstatus` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `songs`
--

INSERT INTO `songs` (`sid`, `sname`, `simage`, `slink`, `aid`, `sview`, `sstatus`) VALUES
(4, 'Hồng nhan', 'Hong-Nhan-Jack.jpg', 'Hong-Nhan-Jack.mp3', 4, 0, 1),
(6, 'number 2', 'ChiMuonBenEmLucNay.jpg', 'ChiMuonBenEmLucNay.mp3', 3, 0, 1),
(7, 'so 3', '3.jpg', '3.mp3', 4, 0, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `songs_playlist`
--

CREATE TABLE `songs_playlist` (
  `id` int(11) NOT NULL,
  `sid` int(11) NOT NULL,
  `pid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `songs_playlist`
--

INSERT INTO `songs_playlist` (`id`, `sid`, `pid`) VALUES
(1, 4, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user`
--

CREATE TABLE `user` (
  `uid` int(11) NOT NULL,
  `uemail` varchar(255) NOT NULL,
  `uname` varchar(255) NOT NULL,
  `upassword` varchar(255) NOT NULL,
  `pid` int(11) NOT NULL,
  `ustatus` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `user`
--

INSERT INTO `user` (`uid`, `uemail`, `uname`, `upassword`, `pid`, `ustatus`) VALUES
(2, '[value-2]', '[value-3]', '[value-4]', 1, 1);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `albums`
--
ALTER TABLE `albums`
  ADD PRIMARY KEY (`alid`),
  ADD KEY `aid` (`aid`);

--
-- Chỉ mục cho bảng `albums_songs`
--
ALTER TABLE `albums_songs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sid` (`sid`),
  ADD KEY `alid` (`alid`);

--
-- Chỉ mục cho bảng `artists`
--
ALTER TABLE `artists`
  ADD PRIMARY KEY (`aid`);

--
-- Chỉ mục cho bảng `playlist`
--
ALTER TABLE `playlist`
  ADD PRIMARY KEY (`pid`);

--
-- Chỉ mục cho bảng `podcasts`
--
ALTER TABLE `podcasts`
  ADD PRIMARY KEY (`poid`),
  ADD KEY `aid` (`aid`);

--
-- Chỉ mục cho bảng `songs`
--
ALTER TABLE `songs`
  ADD PRIMARY KEY (`sid`),
  ADD KEY `aid` (`aid`);

--
-- Chỉ mục cho bảng `songs_playlist`
--
ALTER TABLE `songs_playlist`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pid` (`pid`),
  ADD KEY `sid` (`sid`);

--
-- Chỉ mục cho bảng `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`uid`),
  ADD KEY `pid` (`pid`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `albums`
--
ALTER TABLE `albums`
  MODIFY `alid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `albums_songs`
--
ALTER TABLE `albums_songs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `artists`
--
ALTER TABLE `artists`
  MODIFY `aid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `playlist`
--
ALTER TABLE `playlist`
  MODIFY `pid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `podcasts`
--
ALTER TABLE `podcasts`
  MODIFY `poid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `songs`
--
ALTER TABLE `songs`
  MODIFY `sid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `songs_playlist`
--
ALTER TABLE `songs_playlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `user`
--
ALTER TABLE `user`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `albums`
--
ALTER TABLE `albums`
  ADD CONSTRAINT `albums_ibfk_1` FOREIGN KEY (`aid`) REFERENCES `artists` (`aid`);

--
-- Các ràng buộc cho bảng `albums_songs`
--
ALTER TABLE `albums_songs`
  ADD CONSTRAINT `albums_songs_ibfk_2` FOREIGN KEY (`sid`) REFERENCES `songs` (`sid`),
  ADD CONSTRAINT `albums_songs_ibfk_3` FOREIGN KEY (`alid`) REFERENCES `albums` (`alid`);

--
-- Các ràng buộc cho bảng `podcasts`
--
ALTER TABLE `podcasts`
  ADD CONSTRAINT `podcasts_ibfk_1` FOREIGN KEY (`aid`) REFERENCES `artists` (`aid`);

--
-- Các ràng buộc cho bảng `songs`
--
ALTER TABLE `songs`
  ADD CONSTRAINT `songs_ibfk_1` FOREIGN KEY (`aid`) REFERENCES `artists` (`aid`);

--
-- Các ràng buộc cho bảng `songs_playlist`
--
ALTER TABLE `songs_playlist`
  ADD CONSTRAINT `songs_playlist_ibfk_1` FOREIGN KEY (`pid`) REFERENCES `playlist` (`pid`),
  ADD CONSTRAINT `songs_playlist_ibfk_2` FOREIGN KEY (`sid`) REFERENCES `songs` (`sid`);

--
-- Các ràng buộc cho bảng `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`pid`) REFERENCES `playlist` (`pid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
