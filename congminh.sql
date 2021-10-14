-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th10 14, 2021 lúc 10:29 PM
-- Phiên bản máy phục vụ: 10.4.14-MariaDB
-- Phiên bản PHP: 7.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `congminh`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `exam`
--

CREATE TABLE `exam` (
  `date_exam` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `point` int(11) DEFAULT NULL,
  `sub` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `exam`
--

INSERT INTO `exam` (`date_exam`, `user_id`, `point`, `sub`) VALUES
('8/10/2019', 3, 25, 1),
('8/10/2019', 3, 35, 2),
('8/10/2019', 3, 30, 3),
('8/10/2019', 3, 40, 4),
('9/10/2019', 2, 35, 1),
('9/10/2019', 2, 35, 2),
('9/10/2019', 1, 35, 1),
('9/10/2019', 1, 35, 4),
('9/10/2019', 1, 35, 3),
('9/10/2019', 1, 35, 2),
('9/10/2019', 4, 35, 1),
('9/10/2019', 4, 35, 2),
('9/10/2019', 5, 35, 1),
('9/10/2019', 5, 35, 4),
('9/10/2019', 5, 35, 3),
('9/10/2019', 5, 35, 2);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `birthday` text NOT NULL,
  `dev` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `name`, `birthday`, `dev`) VALUES
(1, 'Ba', '01/13/1985', 'Dev2'),
(2, 'Huy', '10/1/1986', 'Dev3'),
(3, 'Nguyen', '11/1/1987', 'Dev2'),
(4, 'Hoang', '12/1/1988', 'Dev2'),
(5, 'Tien', '1/1/1990', 'Dev1'),
(6, 'Tuan', '2/1/1991', 'Dev3');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `exam`
--
ALTER TABLE `exam`
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `exam`
--
ALTER TABLE `exam`
  ADD CONSTRAINT `exam_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
