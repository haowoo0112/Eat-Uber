-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2023-06-03 08:49:01
-- 伺服器版本： 10.4.27-MariaDB
-- PHP 版本： 8.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `final_project`
--

-- --------------------------------------------------------

--
-- 資料表結構 `menu`
--

CREATE TABLE `menu` (
  `item_id` int(11) NOT NULL,
  `res_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` varchar(200) NOT NULL,
  `price` int(10) UNSIGNED NOT NULL,
  `food` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `menu`
--

INSERT INTO `menu` (`item_id`, `res_id`, `name`, `description`, `price`, `food`) VALUES
(6, 21, 'test', 'nice', 30, 'uploads/menu/1.jpg'),
(7, 21, 'pizza', 'bad', 100, 'uploads/menu/2.jpg'),
(8, 24, 'pizza', 'good', 50, 'uploads/menu/3.jpg'),
(9, 24, 'chicken', 'bad', 80, 'uploads/menu/1.jpg'),
(10, 22, 'rice', 'rew', 80, 'uploads/menu/2.jpg'),
(11, 22, 'beef', 'rewq', 90, 'uploads/menu/3.jpg'),
(13, 28, '456', '456', 456, 'uploads/menu/12.jpg');

-- --------------------------------------------------------

--
-- 資料表結構 `opinion`
--

CREATE TABLE `opinion` (
  `user_id_o` varchar(11) NOT NULL,
  `restaurant_id_o` varchar(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `message` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `opinion`
--

INSERT INTO `opinion` (`user_id_o`, `restaurant_id_o`, `rating`, `message`) VALUES
('17', '24', 4, NULL),
('18', '24', 5, '好吃，我好餓'),
('18', '24', 3, NULL),
('18', '24', 2, NULL);

-- --------------------------------------------------------

--
-- 資料表結構 `order_item_table`
--

CREATE TABLE `order_item_table` (
  `order_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `quantity` int(100) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `order_item_table_finish`
--

CREATE TABLE `order_item_table_finish` (
  `order_id_f` varchar(11) NOT NULL,
  `item_id_f` varchar(11) NOT NULL,
  `quantity_f` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `order_item_table_finish`
--

INSERT INTO `order_item_table_finish` (`order_id_f`, `item_id_f`, `quantity_f`) VALUES
('25', '8', 2),
('25', '9', 2),
('26', '8', 16),
('26', '9', 2),
('27', '8', 3),
('28', '8', 4),
('29', '8', 3),
('30', '8', 4),
('31', '9', 5),
('32', '8', 1);

-- --------------------------------------------------------

--
-- 資料表結構 `order_table`
--

CREATE TABLE `order_table` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `restaurant_id` int(11) NOT NULL,
  `order_time` datetime DEFAULT NULL,
  `delivery_time` datetime DEFAULT NULL,
  `delivery_address` varchar(30) DEFAULT NULL,
  `total_price` int(100) UNSIGNED DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `order_table_finish`
--

CREATE TABLE `order_table_finish` (
  `order_id_f` varchar(11) NOT NULL,
  `user_id_f` varchar(30) NOT NULL,
  `restaurant_id_f` varchar(30) NOT NULL,
  `order_time_f` datetime NOT NULL,
  `delivery_time_f` datetime DEFAULT NULL,
  `delivery_address_f` int(30) NOT NULL,
  `total_price_f` int(100) NOT NULL,
  `billing` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `order_table_finish`
--

INSERT INTO `order_table_finish` (`order_id_f`, `user_id_f`, `restaurant_id_f`, `order_time_f`, `delivery_time_f`, `delivery_address_f`, `total_price_f`, `billing`) VALUES
('25', '17', '24', '2023-05-19 13:04:59', NULL, 321, 260, 'cash'),
('26', '18', '24', '2023-06-02 15:40:45', NULL, 123, 960, 'cash'),
('27', '18', '24', '2023-06-02 15:55:51', NULL, 123, 150, 'cash'),
('28', '18', '24', '2023-06-03 06:39:21', NULL, 123, 200, 'cash'),
('29', '18', '24', '2023-06-03 07:36:20', NULL, 123, 150, 'cash'),
('30', '18', '24', '2023-06-03 07:36:40', NULL, 123, 200, 'card'),
('31', '18', '24', '2023-06-03 07:38:08', NULL, 123, 400, 'card'),
('32', '18', '24', '2023-06-03 08:18:44', NULL, 123, 50, 'cash');

-- --------------------------------------------------------

--
-- 資料表結構 `restaurants`
--

CREATE TABLE `restaurants` (
  `restaurant_id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `description` varchar(200) NOT NULL,
  `logo` text NOT NULL,
  `address` varchar(30) NOT NULL,
  `phone_number` varchar(10) NOT NULL,
  `rating` float NOT NULL,
  `rating_num` int(100) NOT NULL DEFAULT 0,
  `email` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `restaurants`
--

INSERT INTO `restaurants` (`restaurant_id`, `name`, `description`, `logo`, `address`, `phone_number`, `rating`, `rating_num`, `email`, `password`) VALUES
(21, 'test', 'rhewqk', 'uploads/1.jpg', 'rew', '0404845', 0, 0, 'eqws', 'Se1@rhq2313'),
(22, 'tests', 'rhewqk', 'uploads/2.jpg', 'rew', '0404845', 0, 0, '2', 'Se1@rhq2313'),
(24, 'pizza_hut', 'good', 'uploads/3.jpg', 'as', '09849489', 3.5, 4, 'ewqas', 'WQ1321@weq'),
(28, 'Hi', '123', 'uploads/Good_Food_Display_-_NCI_Visuals_Online.jpg', '456', '132-456-78', 0, 0, '123456789@gmail.com', '!Waassd45678');

-- --------------------------------------------------------

--
-- 資料表結構 `user`
--

CREATE TABLE `user` (
  `first_name` varchar(10) NOT NULL,
  `last_name` varchar(10) NOT NULL,
  `email` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  `phone_number` varchar(10) NOT NULL,
  `user_id` int(30) UNSIGNED NOT NULL,
  `delivery_address` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `user`
--

INSERT INTO `user` (`first_name`, `last_name`, `email`, `password`, `phone_number`, `user_id`, `delivery_address`) VALUES
('12q', 'we2q', 'eqw', 'Se1@rhq2313', 'ewq', 17, '321'),
('123', '123', '123456@gmail.com', '123456Qq@123', '123', 18, '123');

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `restaurant_id` (`res_id`);

--
-- 資料表索引 `order_item_table`
--
ALTER TABLE `order_item_table`
  ADD KEY `item_id` (`item_id`),
  ADD KEY `order_id` (`order_id`);

--
-- 資料表索引 `order_item_table_finish`
--
ALTER TABLE `order_item_table_finish`
  ADD PRIMARY KEY (`order_id_f`,`item_id_f`);

--
-- 資料表索引 `order_table`
--
ALTER TABLE `order_table`
  ADD PRIMARY KEY (`order_id`);

--
-- 資料表索引 `order_table_finish`
--
ALTER TABLE `order_table_finish`
  ADD PRIMARY KEY (`order_id_f`);

--
-- 資料表索引 `restaurants`
--
ALTER TABLE `restaurants`
  ADD PRIMARY KEY (`restaurant_id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD UNIQUE KEY `email` (`email`);

--
-- 資料表索引 `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `menu`
--
ALTER TABLE `menu`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `order_table`
--
ALTER TABLE `order_table`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `restaurants`
--
ALTER TABLE `restaurants`
  MODIFY `restaurant_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(30) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- 已傾印資料表的限制式
--

--
-- 資料表的限制式 `menu`
--
ALTER TABLE `menu`
  ADD CONSTRAINT `restaurant_id` FOREIGN KEY (`res_id`) REFERENCES `restaurants` (`restaurant_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 資料表的限制式 `order_item_table`
--
ALTER TABLE `order_item_table`
  ADD CONSTRAINT `item_id` FOREIGN KEY (`item_id`) REFERENCES `menu` (`item_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `order_id` FOREIGN KEY (`order_id`) REFERENCES `order_table` (`order_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
