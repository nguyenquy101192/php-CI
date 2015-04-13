-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Sep 07, 2014 at 06:44 PM
-- Server version: 5.6.20
-- PHP Version: 5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `group3`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_brands`
--

CREATE TABLE IF NOT EXISTS `tbl_brands` (
`brand_id` int(11) NOT NULL,
  `brand_name` varchar(50) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=26 ;

--
-- Dumping data for table `tbl_brands`
--

INSERT INTO `tbl_brands` (`brand_id`, `brand_name`) VALUES
(10, 'Raymond Weil'),
(13, 'Rolex'),
(14, 'Omega'),
(15, 'Chopard'),
(16, 'Breitling'),
(17, 'Cartier'),
(18, 'Patek Philippe'),
(19, 'Swatch'),
(20, 'TAG Heuer'),
(21, 'Brequet'),
(22, 'IWC'),
(23, 'Longines'),
(24, 'Piaget'),
(25, 'Citizen');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_categories`
--

CREATE TABLE IF NOT EXISTS `tbl_categories` (
`cate_id` int(11) NOT NULL,
  `cate_name` varchar(50) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `cate_orderby` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=21 ;

--
-- Dumping data for table `tbl_categories`
--

INSERT INTO `tbl_categories` (`cate_id`, `cate_name`, `parent_id`, `cate_orderby`) VALUES
(13, 'LUXURY', 0, 7),
(14, 'SPORT', 0, 6),
(15, 'NEW ARRIVALS', 0, 5),
(16, 'SALE & DEALS', 0, 4),
(17, 'OTHERS', 0, 1),
(18, 'DRESS', 17, 2),
(20, 'CASUAL', 17, 2);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_config`
--

CREATE TABLE IF NOT EXISTS `tbl_config` (
  `number_page` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_features`
--

CREATE TABLE IF NOT EXISTS `tbl_features` (
  `pro_id` int(11) NOT NULL,
  `pro_orderby` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_feedback`
--

CREATE TABLE IF NOT EXISTS `tbl_feedback` (
  `feed_id` int(11) NOT NULL,
  `feed_name` varchar(50) NOT NULL,
  `feed_email` text NOT NULL,
  `feed_title` varchar(50) NOT NULL,
  `feed_content` text NOT NULL,
  `feed_rate` float NOT NULL,
  `feed_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `pro_id` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_feedback`
--

INSERT INTO `tbl_feedback` (`feed_id`, `feed_name`, `feed_email`, `feed_title`, `feed_content`, `feed_rate`, `feed_time`, `pro_id`, `status`) VALUES
(2, 'Test', 'abc@smartosc.com', 'Test', 'Good!!!', 5, '2014-09-03 00:00:00', 1, 0),
(4, 'Tungnh', 'tungnh@smartosc.com', 'good', 'Good!!!', 5, '2014-09-04 00:00:00', 0, 0),
(5, 'Tungnh', 'tungnh@smartosc.com', 'good', 'Good!!!', 5, '2014-09-04 00:00:00', 0, 0),
(6, 'Test', 'abc@smartosc.com', 'Test', 'Good!!!', 5, '2014-09-03 00:00:00', 1, 0),
(7, 'Test', 'abc@smartosc.com', 'Test', 'Good!!!', 5, '2014-09-03 00:00:00', 1, 0),
(9, 'Test', 'abc@smartosc.com', 'Test', 'Good!!!', 5, '2014-09-03 00:00:00', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_images`
--

CREATE TABLE IF NOT EXISTS `tbl_images` (
`img_id` int(11) NOT NULL,
  `img_link` text NOT NULL,
  `img_status` int(11) NOT NULL,
  `pro_id` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=94 ;

--
-- Dumping data for table `tbl_images`
--

INSERT INTO `tbl_images` (`img_id`, `img_link`, `img_status`, `pro_id`) VALUES
(58, 'product2.png', 1, 20),
(59, 'product5.png', 1, 20),
(61, 'Arcadia_watch_c1960.png', 1, 17),
(62, 'citizen_eco-drive_professional_diver_-_bj8050-59e_1_copy.png', 1, 17),
(63, 'digital_watch.png', 1, 13),
(64, 'file_1_2.png', 1, 13),
(65, 'Pebble_watch.png', 1, 13),
(66, 'rolex_oyster_perpetual_1_copy.png', 1, 14),
(67, 'smart-watch-im_watch.png', 1, 14),
(68, 'thinkgeek--usb-hidden-flash-drive-watch.png', 1, 14),
(69, 'file_1_2.png', 1, 12),
(70, 'file_2.png', 1, 12),
(71, 'watchmark-1000x1300.png', 1, 12),
(72, 'Arcadia_watch_c1960.png', 1, 16),
(73, 'product.png', 1, 16),
(74, 'product2.png', 1, 16),
(75, 'iWatchz Elemetal Stainless Steel Collection.png', 1, 15),
(76, 'rolex_oyster_perpetual_1_copy.png', 1, 15),
(77, 'thinkgeek--usb-hidden-flash-drive-watch.png', 1, 15),
(78, 'file_1_18.png', 1, 19),
(79, 'file_2.png', 1, 19),
(80, 'file_3.png', 1, 19),
(81, 'rolex_oyster_perpetual_1_copy.png', 1, 18),
(82, 'watch_diesel_only_the_brave.png', 1, 18),
(83, 'watchmark-1000x1300.png', 1, 18),
(84, 'watch_diesel_only_the_brave.png', 1, 21),
(85, 'citizen_eco-drive_professional_diver_-_bj8050-59e_1_copy.png', 1, 21),
(86, 'file_1_2.png', 1, 21),
(87, 'rolex_oyster_perpetual_1_copy.png', 1, 22),
(88, 'Qtz_watch.png', 1, 22),
(89, 'rolex_oyster_perpetual_1_copy.png', 1, 23),
(90, 'product1.png', 1, 23),
(91, 'file_3.png', 1, 24),
(92, 'file_1_18.png', 1, 24),
(93, 'file_1_2.png', 1, 24);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_orderdetails`
--

CREATE TABLE IF NOT EXISTS `tbl_orderdetails` (
`orderDetail_id` int(11) NOT NULL,
  `orderDetail_price` int(11) NOT NULL,
  `orderDetail_quantity` int(11) NOT NULL,
  `pro_name` varchar(100) NOT NULL,
  `order_id` int(11) NOT NULL,
  `pro_id` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `tbl_orderdetails`
--

INSERT INTO `tbl_orderdetails` (`orderDetail_id`, `orderDetail_price`, `orderDetail_quantity`, `pro_name`, `order_id`, `pro_id`) VALUES
(1, 7500, 12, 'Xa phong tam', 1, 1),
(2, 12000000, 5, 'Samsung Galaxy S5', 2, 2),
(3, 12000000, 5, 'Samsung Galaxy S5', 3, 3),
(4, 10000000, 5, 'Dien thoai de ban', 3, 3),
(5, 10000000, 3, 'Ti vi', 1, 1),
(6, 10000000, 5, 'Ti vi', 4, 1),
(8, 7500, 12, 'Xa phong tam', 6, 1),
(9, 3131313, 1, 'aasasd', 7, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_orders`
--

CREATE TABLE IF NOT EXISTS `tbl_orders` (
`order_id` int(11) NOT NULL,
  `order_name` varchar(50) NOT NULL,
  `order_email` text NOT NULL,
  `order_address` text NOT NULL,
  `order_phone` int(11) NOT NULL,
  `order_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `order_status` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `tbl_orders`
--

INSERT INTO `tbl_orders` (`order_id`, `order_name`, `order_email`, `order_address`, `order_phone`, `order_time`, `order_status`) VALUES
(1, 'quynh', 'quynh@smartosc.com', 'Hanoi', 123456789, '2014-08-25 08:07:11', 1),
(2, 'toanlv', 'toanlv@smartosc.com', 'Ha noi', 987654321, '2014-08-25 08:08:11', 0),
(3, 'huannt', 'huannt@smartosc.com', 'Ha noi', 987654321, '2014-08-25 08:08:11', 0),
(4, 'minhpv', 'minhpv@smartosc.com', 'Ha noi', 987654321, '2014-08-25 08:08:11', 0),
(6, 'toannt2', 'toannt2@smartosc.com', 'Ha noi', 987654321, '2014-08-25 08:08:11', 1),
(7, 'aaaaa', 'asd@mail.com', 'asdsad', 123213123, '2014-09-02 06:10:51', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_procate`
--

CREATE TABLE IF NOT EXISTS `tbl_procate` (
  `pro_id` int(11) NOT NULL,
  `cate_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_procate`
--

INSERT INTO `tbl_procate` (`pro_id`, `cate_id`) VALUES
(20, 16),
(17, 14),
(13, 18),
(14, 15),
(12, 13),
(16, 15),
(15, 18),
(24, 20),
(22, 13),
(23, 14),
(23, 15),
(21, 13),
(21, 20);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_products`
--

CREATE TABLE IF NOT EXISTS `tbl_products` (
`pro_id` int(11) NOT NULL,
  `pro_name` varchar(50) NOT NULL,
  `pro_list_price` int(11) NOT NULL,
  `pro_sale_price` int(11) NOT NULL,
  `pro_images` text NOT NULL,
  `pro_desc` text NOT NULL,
  `pro_country` varchar(50) NOT NULL,
  `brand_id` int(11) NOT NULL,
  `feature` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=25 ;

--
-- Dumping data for table `tbl_products`
--

INSERT INTO `tbl_products` (`pro_id`, `pro_name`, `pro_list_price`, `pro_sale_price`, `pro_images`, `pro_desc`, `pro_country`, `brand_id`, `feature`) VALUES
(12, 'Omega Seamaster', 4400, 3175, 'citizen_eco-drive_professional_diver_-_bj8050-59e_1_copy.png', 'Cartier was founded by Louis-Francois Cartier in Paris in 1847. Since its inception, Cartier has been known both for exquisite jewelry and fine timepieces. Cartier watches are as recognizable by name as the celebrities and royal personages whose wrists they have graced – iconic Cartier watch models include Santos, Baignoire, Tank, Pasha, and Roadster. Today, Cartier watches retain their distinctive, luxurious aesthetic, but the catalog has expanded to include a wide range of prices and styles to suit the ever-changing needs of its demanding enthusiasts.  Stainless steel case (42 mm in diameter), Rose gold crown set with a synthetic spinel cabochon, Chocolate colored dial, Sweep second hand, Sword-shaped pink gold colored hands, Roman numerals, Date at the 3 o''clock, Scratch resistant sapphire crystal, Swiss automatic movement (Cartier caliber 049), Water resistant 30 meters/100 feet, Stainless steel and 18k pink gold bracelet, Deployment clasp.', 'Taiwan', 10, 1),
(13, 'Colt Chronograph II Black Dial', 3850, 2495, 'smart-watch-im_watch.png', 'Cartier was founded by Louis-Francois Cartier in Paris in 1847. Since its inception, Cartier has been known both for exquisite jewelry and fine timepieces. Cartier watches are as recognizable by name as the celebrities and royal personages whose wrists they have graced – iconic Cartier watch models include Santos, Baignoire, Tank, Pasha, and Roadster. Today, Cartier watches retain their distinctive, luxurious aesthetic, but the catalog has expanded to include a wide range of prices and styles to suit the ever-changing needs of its demanding enthusiasts.  Stainless steel case (42 mm in diameter), Rose gold crown set with a synthetic spinel cabochon, Chocolate colored dial, Sweep second hand, Sword-shaped pink gold colored hands, Roman numerals, Date at the 3 o''clock, Scratch resistant sapphire crystal, Swiss automatic movement (Cartier caliber 049), Water resistant 30 meters/100 feet, Stainless steel and 18k pink gold bracelet, Deployment clasp.', 'Canada', 14, 1),
(14, 'Formula 1 Black Dial', 1050, 799, 'iWatchz Elemetal Stainless Steel Collection.png', 'Cartier was founded by Louis-Francois Cartier in Paris in 1847. Since its inception, Cartier has been known both for exquisite jewelry and fine timepieces. Cartier watches are as recognizable by name as the celebrities and royal personages whose wrists they have graced – iconic Cartier watch models include Santos, Baignoire, Tank, Pasha, and Roadster. Today, Cartier watches retain their distinctive, luxurious aesthetic, but the catalog has expanded to include a wide range of prices and styles to suit the ever-changing needs of its demanding enthusiasts.  Stainless steel case (42 mm in diameter), Rose gold crown set with a synthetic spinel cabochon, Chocolate colored dial, Sweep second hand, Sword-shaped pink gold colored hands, Roman numerals, Date at the 3 o''clock, Scratch resistant sapphire crystal, Swiss automatic movement (Cartier caliber 049), Water resistant 30 meters/100 feet, Stainless steel and 18k pink gold bracelet, Deployment clasp.', 'Taiwan', 24, 1),
(15, 'TAG Heuer Men''s Aquaracer Stainless', 1500, 1192, 'Pebble_watch.png', 'Cartier was founded by Louis-Francois Cartier in Paris in 1847. Since its inception, Cartier has been known both for exquisite jewelry and fine timepieces. Cartier watches are as recognizable by name as the celebrities and royal personages whose wrists they have graced – iconic Cartier watch models include Santos, Baignoire, Tank, Pasha, and Roadster. Today, Cartier watches retain their distinctive, luxurious aesthetic, but the catalog has expanded to include a wide range of prices and styles to suit the ever-changing needs of its demanding enthusiasts.  Stainless steel case (42 mm in diameter), Rose gold crown set with a synthetic spinel cabochon, Chocolate colored dial, Sweep second hand, Sword-shaped pink gold colored hands, Roman numerals, Date at the 3 o''clock, Scratch resistant sapphire crystal, Swiss automatic movement (Cartier caliber 049), Water resistant 30 meters/100 feet, Stainless steel and 18k pink gold bracelet, Deployment clasp.', 'Canada', 18, 1),
(16, 'Rolex Submariner', 3800, 2469, 'product3.png', 'Cartier was founded by Louis-Francois Cartier in Paris in 1847. Since its inception, Cartier has been known both for exquisite jewelry and fine timepieces. Cartier watches are as recognizable by name as the celebrities and royal personages whose wrists they have graced – iconic Cartier watch models include Santos, Baignoire, Tank, Pasha, and Roadster. Today, Cartier watches retain their distinctive, luxurious aesthetic, but the catalog has expanded to include a wide range of prices and styles to suit the ever-changing needs of its demanding enthusiasts.  Stainless steel case (42 mm in diameter), Rose gold crown set with a synthetic spinel cabochon, Chocolate colored dial, Sweep second hand, Sword-shaped pink gold colored hands, Roman numerals, Date at the 3 o''clock, Scratch resistant sapphire crystal, Swiss automatic movement (Cartier caliber 049), Water resistant 30 meters/100 feet, Stainless steel and 18k pink gold bracelet, Deployment clasp.', 'Taiwan', 17, 1),
(17, 'Breitling Colt Chronograph II', 2750, 2045, 'digital_watch.png', 'Cartier was founded by Louis-Francois Cartier in Paris in 1847. Since its inception, Cartier has been known both for exquisite jewelry and fine timepieces. Cartier watches are as recognizable by name as the celebrities and royal personages whose wrists they have graced – iconic Cartier watch models include Santos, Baignoire, Tank, Pasha, and Roadster. Today, Cartier watches retain their distinctive, luxurious aesthetic, but the catalog has expanded to include a wide range of prices and styles to suit the ever-changing needs of its demanding enthusiasts.  Stainless steel case (42 mm in diameter), Rose gold crown set with a synthetic spinel cabochon, Chocolate colored dial, Sweep second hand, Sword-shaped pink gold colored hands, Roman numerals, Date at the 3 o''clock, Scratch resistant sapphire crystal, Swiss automatic movement (Cartier caliber 049), Water resistant 30 meters/100 feet, Stainless steel and 18k pink gold bracelet, Deployment clasp.', 'Canada', 15, 1),
(18, 'Rolex Mens 18k Yellow Gold', 14995, 14995, 'watch.png', 'Cartier was founded by Louis-Francois Cartier in Paris in 1847. Since its inception, Cartier has been known both for exquisite jewelry and fine timepieces. Cartier watches are as recognizable by name as the celebrities and royal personages whose wrists they have graced – iconic Cartier watch models include Santos, Baignoire, Tank, Pasha, and Roadster. Today, Cartier watches retain their distinctive, luxurious aesthetic, but the catalog has expanded to include a wide range of prices and styles to suit the ever-changing needs of its demanding enthusiasts.  Stainless steel case (42 mm in diameter), Rose gold crown set with a synthetic spinel cabochon, Chocolate colored dial, Sweep second hand, Sword-shaped pink gold colored hands, Roman numerals, Date at the 3 o''clock, Scratch resistant sapphire crystal, Swiss automatic movement (Cartier caliber 049), Water resistant 30 meters/100 feet, Stainless steel and 18k pink gold bracelet, Deployment clasp.', 'Canada', 15, 1),
(19, 'Baume & Mercier', 9000, 8725, 'product12841-0-1419.png.thumb_604x800_7e30aae767b14e12d7ec711b8a2c4695.png', 'Cartier was founded by Louis-Francois Cartier in Paris in 1847. Since its inception, Cartier has been known both for exquisite jewelry and fine timepieces. Cartier watches are as recognizable by name as the celebrities and royal personages whose wrists they have graced – iconic Cartier watch models include Santos, Baignoire, Tank, Pasha, and Roadster. Today, Cartier watches retain their distinctive, luxurious aesthetic, but the catalog has expanded to include a wide range of prices and styles to suit the ever-changing needs of its demanding enthusiasts.  Stainless steel case (42 mm in diameter), Rose gold crown set with a synthetic spinel cabochon, Chocolate colored dial, Sweep second hand, Sword-shaped pink gold colored hands, Roman numerals, Date at the 3 o''clock, Scratch resistant sapphire crystal, Swiss automatic movement (Cartier caliber 049), Water resistant 30 meters/100 feet, Stainless steel and 18k pink gold bracelet, Deployment clasp.', 'Taiwan', 24, 1),
(20, 'Rolex Black Dial', 4000, 4000, 'ressence-watches.png', 'Cartier was founded by Louis-Francois Cartier in Paris in 1847. Since its inception, Cartier has been known both for exquisite jewelry and fine timepieces. Cartier watches are as recognizable by name as the celebrities and royal personages whose wrists they have graced – iconic Cartier watch models include Santos, Baignoire, Tank, Pasha, and Roadster. Today, Cartier watches retain their distinctive, luxurious aesthetic, but the catalog has expanded to include a wide range of prices and styles to suit the ever-changing needs of its demanding enthusiasts.  Stainless steel case (42 mm in diameter), Rose gold crown set with a synthetic spinel cabochon, Chocolate colored dial, Sweep second hand, Sword-shaped pink gold colored hands, Roman numerals, Date at the 3 o''clock, Scratch resistant sapphire crystal, Swiss automatic movement (Cartier caliber 049), Water resistant 30 meters/100 feet, Stainless steel and 18k pink gold bracelet, Deployment clasp.', 'Taiwan', 13, 1),
(21, 'Submariner Chronograph Black', 7800, 7800, 'watch_diesel_only_the_brave.png', 'Cartier was founded by Louis-Francois Cartier in Paris in 1847. Since its inception, Cartier has been known both for exquisite jewelry and fine timepieces. Cartier watches are as recognizable by name as the celebrities and royal personages whose wrists they have graced – iconic Cartier watch models include Santos, Baignoire, Tank, Pasha, and Roadster. Today, Cartier watches retain their distinctive, luxurious aesthetic, but the catalog has expanded to include a wide range of prices and styles to suit the ever-changing needs of its demanding enthusiasts.  Stainless steel case (42 mm in diameter), Rose gold crown set with a synthetic spinel cabochon, Chocolate colored dial, Sweep second hand, Sword-shaped pink gold colored hands, Roman numerals, Date at the 3 o''clock, Scratch resistant sapphire crystal, Swiss automatic movement (Cartier caliber 049), Water resistant 30 meters/100 feet, Stainless steel and 18k pink gold bracelet, Deployment clasp.', 'Canada', 20, 1),
(22, 'Heuer  Stainless Casual', 3700, 3400, 'file_3.png', 'Cartier was founded by Louis-Francois Cartier in Paris in 1847. Since its inception, Cartier has been known both for exquisite jewelry and fine timepieces. Cartier watches are as recognizable by name as the celebrities and royal personages whose wrists they have graced – iconic Cartier watch models include Santos, Baignoire, Tank, Pasha, and Roadster. Today, Cartier watches retain their distinctive, luxurious aesthetic, but the catalog has expanded to include a wide range of prices and styles to suit the ever-changing needs of its demanding enthusiasts.  Stainless steel case (42 mm in diameter), Rose gold crown set with a synthetic spinel cabochon, Chocolate colored dial, Sweep second hand, Sword-shaped pink gold colored hands, Roman numerals, Date at the 3 o''clock, Scratch resistant sapphire crystal, Swiss automatic movement (Cartier caliber 049), Water resistant 30 meters/100 feet, Stainless steel and 18k pink gold bracelet, Deployment clasp.', 'Canada', 21, 1),
(23, 'Watch Diesel The Brave', 5750, 5500, 'product2.png', 'Cartier was founded by Louis-Francois Cartier in Paris in 1847. Since its inception, Cartier has been known both for exquisite jewelry and fine timepieces. Cartier watches are as recognizable by name as the celebrities and royal personages whose wrists they have graced – iconic Cartier watch models include Santos, Baignoire, Tank, Pasha, and Roadster. Today, Cartier watches retain their distinctive, luxurious aesthetic, but the catalog has expanded to include a wide range of prices and styles to suit the ever-changing needs of its demanding enthusiasts.  Stainless steel case (42 mm in diameter), Rose gold crown set with a synthetic spinel cabochon, Chocolate colored dial, Sweep second hand, Sword-shaped pink gold colored hands, Roman numerals, Date at the 3 o''clock, Scratch resistant sapphire crystal, Swiss automatic movement (Cartier caliber 049), Water resistant 30 meters/100 feet, Stainless steel and 18k pink gold bracelet, Deployment clasp.', 'Canada', 24, 1),
(24, 'Pebble Watch', 7325, 7325, 'watchmark-1000x1300.png', 'Cartier was founded by Louis-Francois Cartier in Paris in 1847. Since its inception, Cartier has been known both for exquisite jewelry and fine timepieces. Cartier watches are as recognizable by name as the celebrities and royal personages whose wrists they have graced – iconic Cartier watch models include Santos, Baignoire, Tank, Pasha, and Roadster. Today, Cartier watches retain their distinctive, luxurious aesthetic, but the catalog has expanded to include a wide range of prices and styles to suit the ever-changing needs of its demanding enthusiasts.  Stainless steel case (42 mm in diameter), Rose gold crown set with a synthetic spinel cabochon, Chocolate colored dial, Sweep second hand, Sword-shaped pink gold colored hands, Roman numerals, Date at the 3 o''clock, Scratch resistant sapphire crystal, Swiss automatic movement (Cartier caliber 049), Water resistant 30 meters/100 feet, Stainless steel and 18k pink gold bracelet, Deployment clasp.', 'Canada', 17, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sliders`
--

CREATE TABLE IF NOT EXISTS `tbl_sliders` (
  `pro_id` int(11) NOT NULL,
  `img_link` text NOT NULL,
  `img_order` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_sliders`
--

INSERT INTO `tbl_sliders` (`pro_id`, `img_link`, `img_order`) VALUES
(17, 'digital_watch1.png', 1),
(13, 'smart-watch-im_watch.png', 2),
(16, 'product3.png', 3);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE IF NOT EXISTS `tbl_users` (
`user_id` int(11) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `user_password` varchar(50) NOT NULL,
  `user_email` text NOT NULL,
  `user_address` text NOT NULL,
  `user_phone` int(11) NOT NULL,
  `user_gender` int(1) NOT NULL,
  `user_level` int(1) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`user_id`, `user_name`, `user_password`, `user_email`, `user_address`, `user_phone`, `user_gender`, `user_level`) VALUES
(1, 'admin', 'e10adc3949ba59abbe56e057f20f883e', 'administrator@smartosc.com', 'Hà nội', 987654321, 1, 1),
(4, 'quynh', 'e10adc3949ba59abbe56e057f20f883e', 'quynh@gmail.com', 'Ha Noi', 123456789, 1, 2),
(5, 'anhnv', 'e10adc3949ba59abbe56e057f20f883e', 'anhnv@smartosc.com', 'Ha Noi', 123456789, 2, 2),
(6, 'nguyen huu quy', 'e10adc3949ba59abbe56e057f20f883e', 'nguyenquy101192@gmail.com', 'Ha Noi', 123456789, 2, 1),
(8, 'guess123', 'e10adc3949ba59abbe56e057f20f883e', 'guess1@smartosc.com', 'HCM city', 123456789, 2, 2),
(9, 'guess2', 'e10adc3949ba59abbe56e057f20f883e', 'guess2@smartosc.com', 'Hạ Long', 123456789, 1, 1),
(10, 'luanvd1', '031afcbd2af5ac5bf17da10c8b7f0cec', 'luanvd@smartosc.com', 'Bac ninh', 123456789, 2, 2),
(11, 'abc', '123456', 'acb@gmail.com', 'Ha Noi', 123456789, 1, 1),
(12, 'guess123123', 'e10adc3949ba59abbe56e057f20f883e', 'guess1113@smartosc.com', 'Ha Noi', 123456789, 1, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_brands`
--
ALTER TABLE `tbl_brands`
 ADD PRIMARY KEY (`brand_id`);

--
-- Indexes for table `tbl_categories`
--
ALTER TABLE `tbl_categories`
 ADD PRIMARY KEY (`cate_id`);

--
-- Indexes for table `tbl_images`
--
ALTER TABLE `tbl_images`
 ADD PRIMARY KEY (`img_id`);

--
-- Indexes for table `tbl_orderdetails`
--
ALTER TABLE `tbl_orderdetails`
 ADD PRIMARY KEY (`orderDetail_id`);

--
-- Indexes for table `tbl_orders`
--
ALTER TABLE `tbl_orders`
 ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `tbl_products`
--
ALTER TABLE `tbl_products`
 ADD PRIMARY KEY (`pro_id`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
 ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_brands`
--
ALTER TABLE `tbl_brands`
MODIFY `brand_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT for table `tbl_categories`
--
ALTER TABLE `tbl_categories`
MODIFY `cate_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `tbl_images`
--
ALTER TABLE `tbl_images`
MODIFY `img_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=94;
--
-- AUTO_INCREMENT for table `tbl_orderdetails`
--
ALTER TABLE `tbl_orderdetails`
MODIFY `orderDetail_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `tbl_orders`
--
ALTER TABLE `tbl_orders`
MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `tbl_products`
--
ALTER TABLE `tbl_products`
MODIFY `pro_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
