-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2024-10-24 10:49:48
-- 伺服器版本： 10.4.32-MariaDB
-- PHP 版本： 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `practice`
--

-- --------------------------------------------------------

--
-- 資料表結構 `customer`
--

CREATE TABLE `customer` (
  `id` int(11) NOT NULL,
  `name` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `job`
--

CREATE TABLE `job` (
  `postid` int(11) NOT NULL,
  `company` varchar(45) NOT NULL,
  `content` text NOT NULL,
  `pdate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `job`
--

INSERT INTO `job` (`postid`, `company`, `content`, `pdate`) VALUES
(1, '統一', '誠徵程式設計師一名', '2019-08-19'),
(3, '輔仁大學', '誠徵程式設計師一名', '2019-08-19'),
(4, '大考中心', '誠徵專案經理一名', '2019-08-19'),
(6, '輔仁大學', '誠徵系統管理員一名', '2019-08-19'),
(7, '輔仁大學', '誠徵網路管理員一名', '2019-08-19'),
(8, '誠品', '誠徵程式設計師一名', '2019-08-19'),
(10, '成功大學', '誠徵程式設計師一名', '2019-08-19'),
(11, '誠品', '誠徵系統分析師一名', '2019-08-19'),
(15, '成功大學', '誠徵專案經理一位', '2019-08-19'),
(16, '中原大學', '誠徵程式設計師', '2019-08-19');

-- --------------------------------------------------------

--
-- 資料表結構 `user`
--

CREATE TABLE `user` (
  `account` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `user`
--

INSERT INTO `user` (`account`, `password`) VALUES
('student1', '1'),
('student2', '2'),
('student3', '3'),
('student4', '4'),
('student5', '5');

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `job`
--
ALTER TABLE `job`
  ADD PRIMARY KEY (`postid`);

--
-- 資料表索引 `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`account`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `job`
--
ALTER TABLE `job`
  MODIFY `postid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
