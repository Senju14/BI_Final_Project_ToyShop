-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 21, 2024 at 06:29 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `toy-shop`
--

-- --------------------------------------------------------



-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `c_id` int(11) NOT NULL,
  `c_name` varchar(255) DEFAULT NULL,
  `c_email` varchar(255) DEFAULT NULL,
  `c_subject` varchar(255) DEFAULT NULL,
  `c_message` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`c_id`, `c_name`, `c_email`, `c_subject`, `c_message`) VALUES
(1, 'dat2004', 'dat.lego@gmail.com', 'First Contact', 'First Contact'),
(2, 'huy2004', 'huy.lego@gmail.com', '10th May', 'Hello');

-- --------------------------------------------------------

--
-- Table structure for table `discount`
--

CREATE TABLE `discount` (
  `d_id` int(20) NOT NULL,
  `d_name` varchar(100) NOT NULL,
  `d_amount` int(20) NOT NULL,
  `d_description` varchar(255) NOT NULL,
  `d_start_date` date DEFAULT NULL,
  `d_end_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `discount`
--

INSERT INTO `discount` (`d_id`, `d_name`, `d_amount`, `d_description`, `d_start_date`, `d_end_date`) VALUES
(1, 'Wood toys for your kids', 20, 'Discount 20%', '2024-04-30', '2024-05-18');


-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `u_id` int(50) NOT NULL,
  `userName` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `loginpassword` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`u_id`, `userName`, `email`, `loginpassword`) VALUES
(1, 'admin', 'admin@gmail.com', 'admin'),
(2, 'user', 'user@gmail.com', 'user');

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `o_id` INT(20) NOT NULL,                          -- ID đơn hàng
  `u_id` INT(50) NOT NULL,                        -- ID người dùng
  `p_id` INT(11) NOT NULL,                    -- ID sản phẩm
  `Product_Name` VARCHAR(255) NOT NULL,             -- Tên sản phẩm
  `Product_Category` VARCHAR(255) NOT NULL,         -- Loại sản phẩm
  `Product_Cost` DECIMAL(10, 2) NOT NULL,           -- Giá vốn sản phẩm
  `Product_Price` DECIMAL(10, 2) NOT NULL,          -- Giá bán sản phẩm
  `Stock_On_Hand` INT(10) NOT NULL,                 -- Số lượng hàng tồn
  `Sale_ID` INT(11) NOT NULL,                       -- ID đơn hàng bán
  `o_price` DECIMAL(10, 2) NOT NULL,                -- Tổng giá trị đơn hàng
  `o_quantity` INT(10) NOT NULL,                    -- Số lượng đơn hàng
  `o_status` INT(2) NOT NULL,                       -- Trạng thái đơn hàng
  `o_date` DATETIME DEFAULT CURRENT_TIMESTAMP(),    -- Ngày tạo đơn hàng
  `Store_Name` VARCHAR(255) NOT NULL,               -- Tên cửa hàng
  `Store_City` VARCHAR(255) NOT NULL,               -- Thành phố cửa hàng
  `Store_Location` VARCHAR(255) NOT NULL,           -- Vị trí cửa hàng
  `Store_Open_Date` DATE NOT NULL                   -- Ngày mở cửa hàng
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Vi du lieu rat lon nen se insert tu file rieng

-- Dumping data for table `order`
INSERT INTO `order` (`o_id`, `u_id`, `p_id`, `Product_Name`, `Product_Category`, `Product_Cost`, `Product_Price`, `Stock_On_Hand`, `Sale_ID`, `o_price`, `o_quantity`, `o_status`, `o_date`, `Store_Name`, `Store_City`, `Store_Location`, `Store_Open_Date`) VALUES
(1, 1, 1, 'Action Figure', 'Toys', 9.99, 15.99, 27, 1210.0, 431.73, 27, 1, '2017-01-02', 'Maven Toys Guadalajara 1', 'Guadalajara', 'Residential', '1992-09-18'),
(2, 1, 1, 'Action Figure', 'Toys', 9.99, 15.99, 27, 1249.0, 431.73, 27, 1, '2017-01-02', 'Maven Toys Guadalajara 1', 'Guadalajara', 'Residential', '1992-09-18'),
(3, 1, 1, 'Action Figure', 'Toys', 9.99, 15.99, 27, 1272.0, 431.73, 27, 1, '2017-01-02', 'Maven Toys Guadalajara 1', 'Guadalajara', 'Residential', '1992-09-18'),
(4, 1, 1, 'Action Figure', 'Toys', 9.99, 15.99, 27, 1275.0, 431.73, 27, 1, '2017-01-02', 'Maven Toys Guadalajara 1', 'Guadalajara', 'Residential', '1992-09-18'),
(5, 1, 1, 'Action Figure', 'Toys', 9.99, 15.99, 27, 1591.0, 431.73, 27, 1, '2017-01-02', 'Maven Toys Guadalajara 1', 'Guadalajara', 'Residential', '1992-09-18'),
(6, 1, 1, 'Action Figure', 'Toys', 9.99, 15.99, 27, 1631.0, 431.73, 27, 1, '2017-01-02', 'Maven Toys Guadalajara 1', 'Guadalajara', 'Residential', '1992-09-18'),
(7, 1, 1, 'Action Figure', 'Toys', 9.99, 15.99, 27, 1721.0, 431.73, 27, 1, '2017-01-02', 'Maven Toys Guadalajara 1', 'Guadalajara', 'Residential', '1992-09-18'),
(8, 1, 1, 'Action Figure', 'Toys', 9.99, 15.99, 27, 2007.0, 431.73, 27, 1, '2017-01-02', 'Maven Toys Guadalajara 1', 'Guadalajara', 'Residential', '1992-09-18'),
(9, 1, 1, 'Action Figure', 'Toys', 9.99, 15.99, 27, 2087.0, 431.73, 27, 1, '2017-01-02', 'Maven Toys Guadalajara 1', 'Guadalajara', 'Residential', '1992-09-18'),
(10, 1, 1, 'Action Figure', 'Toys', 9.99, 15.99, 27, 2810.0, 431.73, 27, 1, '2017-01-04', 'Maven Toys Guadalajara 1', 'Guadalajara', 'Residential', '1992-09-18');

-- --------------------------------------------------------

--
-- Table structure for table `order_detail`
--

CREATE TABLE `order_detail` (
  `od_id` int(20) NOT NULL,
  `o_id` int(20) NOT NULL,
  `od_address` varchar(255) NOT NULL,
  `od_price` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `order_detail` (`od_id`, `o_id`, `od_address`, `od_price`) VALUES
(1, 1, '123 Nguyen Van Linh', 431.73),
(2, 2, '123 Nguyen Trai', 546.90);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `p_id` INT NOT NULL,                -- Tương ứng với Product_ID
  `p_name` VARCHAR(255) NOT NULL,     -- Tương ứng với Product_Name
  `p_image` VARCHAR(255) NOT NULL,
  `p_type` VARCHAR(255) NOT NULL,     -- Tương ứng với Product_Category
  `Product_Cost` DECIMAL(10, 2),
  `p_price` DECIMAL(10, 2) NOT NULL,  -- Tương ứng với Product_Price
  `p_provider` VARCHAR(255) NOT NULL, -- Tương ứng với Store_Name
  `p_age` VARCHAR(100) NOT NULL,
  `p_description` TEXT NOT NULL,

  `Store_ID` INT,
  `Stock_On_Hand` INT,
  `Sale_ID` DECIMAL(10, 1),
  `Date` DATE,
  `Units` DECIMAL(10, 1),

  `Store_City` VARCHAR(100),
  `Store_Location` VARCHAR(100),
  `Store_Open_Date` DATE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



--
-- Dumping data for table `product`
--
INSERT INTO product (
  p_id, p_name, p_image, p_type, Product_Cost, p_price, p_provider, p_age, p_description,
  Store_ID, Stock_On_Hand, Sale_ID, Date, Units,
  Store_City, Store_Location, Store_Open_Date
) 
VALUES 
(1, 'Action Figure', 'Macy 1.jpg', 'Toys', 9.99, 15.99, 'Maven Toys Guadalajara 1', '+1 years', 'New', 1, 27, 1210.0, '2017-01-02', 4.0, 'Saltillo', 'Residential', '2011-10-20'),
(2, 'Animal Figures', 'LEGO.png', 'Toys', 9.99, 12.99, 'Maven Toys Mexicali 2', '+2 years', 'New', 1, 0, 24264.0, '2017-01-27', 3.0, 'Zacatecas', 'Residential', '2011-06-21'),
(3, 'Barrel O'' Slime', 'Macy 3.jpg', 'Art & Crafts', 1.99, 3.99, 'Maven Toys Santiago 1', '+7 years', 'New', 1, 32, 254754.0, '2017-08-21', 1.0, 'Santiago', 'Residential', '2009-11-23'),
(4, 'Chutes & Ladders', 'frog.png', 'Games', 9.99, 12.99, 'Maven Toys Aguascalientes 1', '+3 years', 'New', 1, 6, 12163.0, '2017-01-14', 3.0, 'Chihuahua', 'Commercial', '2014-06-01'),
(5, 'Classic Dominoes', 'Macy 1.jpg', 'Games', 7.99, 9.99, 'Maven Toys Ciudad de Mexico 2', '+4 years', 'New', 1, 0, 3623.0, '2017-01-05', 5.0, 'Durango', 'Downtown', '2013-06-11'),
(6, 'Colorbuds', 'Macy 2.jpg', 'Electronics', 6.99, 14.99, 'Maven Toys Campeche 1', 'Lastest', '+3 years', 1, 79, 9780.0, '2017-01-11', 4.0, 'Chihuahua', 'Residential', '2005-01-14'),
(7, 'Dart Gun', 'bearjellycat.png', 'Sports & Outdoors', 11.99, 15.99, 'Maven Toys Ciudad de Mexico 3', 'Lastest', '+3 years', 1, 5, 10429.0, '2017-01-12', 5.0, 'Chihuahua', 'Commercial', '2013-06-07'),
(8, 'Deck Of Cards', 'LEGO.png', 'Games', 3.99, 6.99, 'Maven Toys Guadalajara 4', 'Lastest', '+3 years', 1, 63, 2241.0, '2017-01-03', 4.0, 'Hermosillo', 'Airport', '2012-08-31'),
(9, 'Dino Egg', 'tiger.png', 'Toys', 9.99, 10.99, 'Maven Toys Aguascalientes 1', 'Lastest', '+2 years', 1, 12, 7113.0, '2017-01-08', 5.0, 'Culiacan', 'Airport', '1995-04-27'),
(10, 'Dinosaur Figures', 'tiger2.png', 'Toys', 10.99, 14.99, 'Maven Toys Pachuca 1', 'Lastest', '+2 years', 1, 22, 1243.0, '2017-01-02', 4.0, 'Guadalajara', 'Residential', '2014-06-30'),
(11, 'Etch A Sketch', 'beach.png', 'Art & Crafts', 10.99, 20.99, 'Maven Toys Zacatecas 1', 'Lastest', '+4 years', 1, 19, 370203.0, '2017-11-28', 1.0, 'Hermosillo', 'Residential', '2010-07-31'),
(12, 'Foam Disk Launcher', 'Elephant.png', 'Sports & Outdoors', 8.99, 11.99, 'Maven Toys La Paz 1', 'Lastest', '+3 years', 1, 3, 523501.0, '2018-03-15', 5.0, 'Chihuahua', 'Downtown', '2013-03-17'),
(13, 'Gamer Headphones', 'LEGO_70362_1.png', 'Electronics', 14.99, 20.99, 'Maven Toys Guadalajara 1', 'Lastest', '+5 years', 1, 12, 254352.0, '2017-08-21', 5.0, 'Monterrey', 'Downtown', '2013-06-11'),
(14, 'Glass Marbles', '19458_lego-nexo-chien-giap-clay-tuticare-2.jpg', 'Games', 5.99, 10.99, 'Maven Toys Toluca 2', 'Lastest', '+3 years', 1, 3, 7370.0, '2017-01-08', 4.0, 'Villahermosa', 'Downtown', '2007-01-31'),
(15, 'Hot Wheels 5-Pack', 'LEGO_70362_2.png', 'Toys', 3.99, 5.99, 'Maven Toys Oaxaca 1', 'Lastest', '+5 years', 1, 2, 73859.0, '2017-03-16', 5.0, 'Cuernavaca', 'Residential', '2011-10-20'),
(16, 'Jenga', 'LEGO.png', 'Games', 2.99, 9.99, 'Maven Toys Aguascalientes 1', 'Lastest', '+3 years', 1, 8, 217088.0, '2017-07-17', 4.0, 'Cuernavaca', 'Residential', '2006-08-30'),
(17, 'Kids Makeup Kit', 'Macy 3.jpg', 'Art & Crafts', 13.99, 19.99, 'Maven Toys Xalapa 2', 'Lastest', '+3 years', 1, 7, 5045.0, '2017-01-06', 1.0, 'La Paz', 'Residential', '2013-06-07'),
(18, 'Lego Bricks', 'Macy 2.jpg', 'Toys', 34.99, 39.99, 'Maven Toys Guadalajara 4', 'Lastest', '+3 years', 1, 11, 3579.0, '2017-01-05', 1.0, 'Zacatecas', 'Commercial', '2010-06-12'),
(19, 'Magic Sand', 'LEGO_70365_1.png', 'Art & Crafts', 13.99, 15.99, 'Maven Toys Toluca 1', 'Lastest', '+3 years', 1, 25, 369468.0, '2017-11-28', 1.0, 'Santiago', 'Downtown', '2001-05-31'),
(20, 'Mini Basketball Hoop', 'LEGO_70365_2.png', 'Sports & Outdoors', 8.99, 24.99, 'Maven Toys Saltillo 1', 'Lastest', '+3 years', 1, 11, 147760.0, '2017-05-20', 4.0, 'Saltillo', 'Airport', '2006-05-05'),
(21, 'Mini Ping Pong Set', 'deer.png', 'Sports & Outdoors', 6.99, 9.99, 'Maven Toys Durango 1', 'Lastest', '+3 years', 1, 21, 141.0, '2017-01-01', 3.0, 'Hermosillo', 'Downtown', '2013-07-01'),
(22, 'Monopoly', 'duck.png', 'Games', 13.99, 19.99, 'Maven Toys Ciudad de Mexico 2', 'Lastest', '+7 years', 1, 2, 7127.0, '2017-01-08', 2.0, 'Chihuahua', 'Residential', '2012-08-31'),
(23, 'Mr. Potatohead', 'frog.png', 'Toys', 4.99, 9.99, 'Maven Toys Ciudad de Mexico 1', 'Lastest', '+3 years', 1, 1, 382675.0, '2017-12-08', 2.0, 'Zacatecas', 'Commercial', '2016-05-10'),
(24, 'Nerf Gun', 'frog1.png', 'Sports & Outdoors', 14.99, 19.99, 'Maven Toys Campeche 1', 'Lastest', '+3 years', 1, 7, 3382.0, '2017-03-06', 5.0, 'Guadalajara', 'Airport', '2012-05-22'),
(25, 'PlayDoh Can', 'cute.jpg', 'Art & Crafts', 1.99, 2.99, 'Maven Toys Monterrey 3', 'Lastest', '+3 years', 1, 54, 28097.0, '2017-01-30', 2.0, 'Ciudad de Mexico', 'Commercial', '1999-12-27'),
(26, 'PlayDoh Playset', 'LEGO.png', 'Art & Crafts', 20.99, 24.99, 'Maven Toys Monterrey 4', 'Lastest', '+3 years', 1, 13, 157520.0, '2017-05-28', 3.0, 'Mexicali', 'Commercial', '2008-08-22'),
(27, 'PlayDoh Toolkit', 'LEGO.png', 'Art & Crafts', 3.99, 4.99, 'Maven Toys Aguascalientes 1', 'Lastest', '+3 years', 1, 33, 3538.0, '2017-01-05', 5.0, 'Guanajuato', 'Residential', '2011-04-01'),
(28, 'Playfoam', 'tiger.png', 'Art & Crafts', 3.99, 10.99, 'Maven Toys Xalapa 2', 'Lastest', '+6 years', 1, 10, 780281.0, '2018-08-25', 4.0, 'Chetumal', 'Airport', '2004-10-14'),
(29, 'Plush Pony', 'tiger2.png', 'Toys', 8.99, 19.99, 'Maven Toys Mexicali 1', 'Lastest', '+3 years', 1, 4, 184365.0, '2017-06-19', 1.0, 'Zacatecas', 'Airport', '2003-12-13'),
(30, 'Rubik''s Cube', 'LEGO.png', 'Games', 17.99, 19.99, 'Maven Toys Xalapa 1', 'Lastest', '+3 years', 1, 44, 10439.0, '2017-01-12', 5.0, 'Ciudad de Mexico', 'Residential', '2000-01-01'),
(31, 'Splash Balls', 'LEGO.png', 'Sports & Outdoors', 7.99, 8.99, 'Maven Toys Santiago 1', 'Lastest', '+3 years', 1, 7, 6.0, '2017-01-01', 5.0, 'Campeche', 'Downtown', '2004-10-15'),
(32, 'Supersoaker Water Gun', 'LEGO.png', 'Sports & Outdoors', 11.99, 14.99, 'Maven Toys Guanajuato 3', 'Lastest', '+3 years', 1, 4, 92424.0, '2017-04-03', 4.0, 'Guanajuato', 'Residential', '2015-06-21'),
(33, 'Teddy Bear', 'frog1.png', 'Toys', 10.99, 12.99, 'Maven Toys Monterrey 2', 'Lastest', '+3 years', 1, 2, 18848.0, '2017-01-21', 5.0, 'Aguascalientes', 'Commercial', '2011-04-01'),
(34, 'Toy Robot', 'frog.png', 'Electronics', 20.99, 25.99, 'Maven Toys Durango 1', 'Lastest', '+3 years', 1, 0, 387.0, '2017-01-01', 5.0, 'Merida', 'Commercial', '2015-10-31'),
(35, 'Uno Card Game', 'LEGO.png', 'Games', 7.99, 9.99, 'Maven Toys Xalapa 1', 'Lastest', '+3 years', 1, 8, 4294.0, '2017-01-22', 4.0, 'Monterrey', 'Downtown', '2012-12-11');

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `r_id` int(50) NOT NULL,
  `r_name` varchar(50) NOT NULL,
  `r_star` varchar(225) NOT NULL,
  `r_email` varchar(100) NOT NULL,
  `r_description` varchar(500) NOT NULL,
  `p_id` int(11) NOT NULL,
  `r_date` DATETIME NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `review`
--

-- Đảm bảo mỗi giá trị có dấu ngoặc đóng và các giá trị được ngăn cách bởi dấu phẩy

INSERT INTO `review` (`r_id`, `r_name`, `r_star`, `r_email`, `r_description`, `p_id`, `r_date`) VALUES
(1, 'User1', '5', 'user1@example.com', 'Sản phẩm rất tốt, tôi rất hài lòng.', 1, NOW()),
(2, 'User2', '1', 'user2@example.com', 'Sản phẩm kém chất lượng, không hài lòng.', 2, NOW()),
(3, 'User3', '4', 'user3@example.com', 'Chất lượng tốt, tôi sẽ mua lại.', 1, NOW()),
(4, 'User4', '2', 'user4@example.com', 'Không giống như quảng cáo, rất thất vọng.', 2, NOW()),
(5, 'User5', '5', 'user5@example.com', 'Sản phẩm vượt mong đợi, tuyệt vời.', 3, NOW());



-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `p_id` int(11) NOT NULL,
  `p_name` varchar(255) NOT NULL,
  `p_image` varchar(255) NOT NULL,
  `p_type` varchar(255) NOT NULL,
  `p_price` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `wishlist` (`p_id`, `p_name`, `p_image`, `p_type`, `p_price`) VALUES
(1, 'Action Figure', 'Macy 1.jpg', 'Toys', 15.99),
(2, 'Animal Figures', 'LEGO.png', 'Toys', 12.99),
(3, 'Barrel O'' Slime', 'Macy 3.jpg', 'Art & Crafts', 3.99),
(4, 'Chutes & Ladders', 'frog.png', 'Games', 12.99),
(5, 'Classic Dominoes', 'Macy 1.jpg', 'Games', 9.99);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
CREATE TABLE `comments` (
  `IDcomment` INT(11) NOT NULL AUTO_INCREMENT,
  `commentText` TEXT NOT NULL,
  `commentName` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `dateComment` DATETIME NOT NULL,
  `replyText` TEXT DEFAULT NULL,
  `p_id` int(11) NOT NULL,
  `u_id` int(50) NOT NULL,
  PRIMARY KEY (`IDcomment`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



-- Insert dữ liệu vào bảng comments
INSERT INTO `comments` (`commentText`, `commentName`, `email`, `dateComment`, `replyText`, `p_id`, `u_id`) VALUES
('Tôi rất thích sản phẩm này, quá tuyệt!', 'Commenter1', 'comm1@example.com', NOW(), NULL, 1, 1),
('Thật sự thất vọng, sản phẩm quá tệ.', 'Commenter2', 'comm2@example.com', NOW(), NULL, 2, 2),
('Giá cả hợp lý, chất lượng tốt.', 'Commenter3', 'comm3@example.com', NOW(), NULL, 3, 3),
('Hoàn toàn không giống mô tả.', 'Commenter4', 'comm4@example.com', NOW(), NULL, 4, 4),
('Dịch vụ khách hàng tuyệt vời.', 'Commenter5', 'comm5@example.com', NOW(), NULL, 5, 5),






--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`c_id`);

--
-- Indexes for table `discount`
--
ALTER TABLE `discount`
  ADD PRIMARY KEY (`d_id`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`u_id`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`o_id`),
  ADD KEY `fk_u_id_user` (`u_id`),
  ADD KEY `fk_p_id_product` (`p_id`);


ALTER TABLE `login` MODIFY `u_id` INT NOT NULL;
ALTER TABLE `comments` MODIFY `u_id` INT NOT NULL;

--
-- Indexes for table `order_detail`
--
ALTER TABLE `order_detail`
  ADD PRIMARY KEY (`od_id`),
  ADD KEY `fk_order_id` (`o_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`p_id`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`r_id`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`p_id`);


--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `discount`
--
ALTER TABLE `discount`
  MODIFY `d_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `u_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `o_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `p_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `review`
--
ALTER TABLE `review`
  MODIFY `r_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `p_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `order_detail`
--
ALTER TABLE `order_detail`
  ADD CONSTRAINT `fk_order_id` FOREIGN KEY (`o_id`) REFERENCES `order` (`o_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

CREATE TABLE `predictions` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `month` INT NOT NULL,
    `revenue` FLOAT NOT NULL
);

CREATE TABLE `product_predictions` (
    `id`INT AUTO_INCREMENT PRIMARY KEY,
    `product_name` VARCHAR(255) NOT NULL,
    `total_quantity`INT NOT NULL
);

CREATE TABLE `comments_predictions` (
    `id`INT AUTO_INCREMENT PRIMARY KEY,      
   `prediction_date` DATE NOT NULL,           
   `predicted_comment_count` INT NOT NULL,   
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE `review_predictions` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,        
    `product_name` VARCHAR(255),                 
    `positive_percentage` DECIMAL(5, 2),        
    `negative_percentage` DECIMAL(5, 2)         
)



-- CREATE TABLE prediction_trigger_event (
--     id INT AUTO_INCREMENT PRIMARY KEY,
--     event_type ENUM('INSERT', 'UPDATE', 'DELETE') NOT NULL,
--     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
-- );

-- -------------------------------
-- DELIMITER $$

-- CREATE TRIGGER after_order_insert
-- AFTER INSERT ON `order`
-- FOR EACH ROW
-- BEGIN
--     INSERT INTO prediction_trigger_event (event_type) VALUES ('INSERT');
-- END $$

-- -- Trở lại delimiter mặc định
-- DELIMITER ;

-- --------------------------------------------------

-- -- Thay đổi delimiter tạm thời
-- DELIMITER $$

-- CREATE TRIGGER after_order_update
-- AFTER UPDATE ON `order`
-- FOR EACH ROW
-- BEGIN
--     INSERT INTO prediction_trigger_event (event_type) VALUES ('UPDATE');
-- END $$

-- -- Trở lại delimiter mặc định
-- DELIMITER ;

-- ---------------------------------------
-- -- Thay đổi delimiter tạm thời
-- DELIMITER $$

-- CREATE TRIGGER after_order_delete
-- AFTER UPDATE ON `order`
-- FOR EACH ROW
-- BEGIN
--     INSERT INTO prediction_trigger_event (event_type) VALUES ('DELETE');
-- END $$

-- -- Trở lại delimiter mặc định
-- DELIMITER ;