-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 09, 2020 at 06:04 PM
-- Server version: 5.7.29
-- PHP Version: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hyperboo_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `pish_hikashop_order_product`
--

CREATE TABLE `pish_hikashop_order_product` (
  `order_product_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `order_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `product_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `order_product_quantity` int(10) UNSIGNED NOT NULL DEFAULT '1',
  `order_product_name` varchar(255) NOT NULL DEFAULT '',
  `order_product_code` varchar(255) NOT NULL DEFAULT '',
  `order_product_price` decimal(17,5) NOT NULL DEFAULT '0.00000',
  `order_product_tax` decimal(17,5) NOT NULL DEFAULT '0.00000',
  `order_product_tax_info` text NOT NULL,
  `order_product_options` text NOT NULL,
  `order_product_option_parent_id` int(10) UNSIGNED DEFAULT '0',
  `order_product_status` varchar(255) NOT NULL DEFAULT '',
  `order_product_wishlist_id` int(11) NOT NULL DEFAULT '0',
  `order_product_wishlist_product_id` int(11) NOT NULL DEFAULT '0',
  `order_product_shipping_id` varchar(255) NOT NULL DEFAULT '',
  `order_product_shipping_method` varchar(255) NOT NULL DEFAULT '',
  `order_product_shipping_price` decimal(17,5) NOT NULL DEFAULT '0.00000',
  `order_product_shipping_tax` decimal(17,5) NOT NULL DEFAULT '0.00000',
  `order_product_shipping_params` text,
  `order_product_parent_id` int(10) NOT NULL DEFAULT '0',
  `order_product_vendor_price` decimal(12,5) NOT NULL DEFAULT '0.00000',
  `order_product_params` text,
  `vendor_id_accepted` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pish_hikashop_order_product`
--

INSERT INTO `pish_hikashop_order_product` (`order_product_id`, `order_id`, `product_id`, `order_product_quantity`, `order_product_name`, `order_product_code`, `order_product_price`, `order_product_tax`, `order_product_tax_info`, `order_product_options`, `order_product_option_parent_id`, `order_product_status`, `order_product_wishlist_id`, `order_product_wishlist_product_id`, `order_product_shipping_id`, `order_product_shipping_method`, `order_product_shipping_price`, `order_product_shipping_tax`, `order_product_shipping_params`, `order_product_parent_id`, `order_product_vendor_price`, `order_product_params`, `vendor_id_accepted`) VALUES
(3372, 1771, 8548, 1, ' زعفران پاراین', 'product_8548', 0.00000, 0.00000, '', '', 0, '', 0, 0, '', '', 0.00000, 0.00000, '', 0, 0.00000, NULL, NULL),
(3373, 1771, 8547, 1, ' زعفران پاراین', 'product_8547', 0.00000, 0.00000, '', '', 0, '', 0, 0, '', '', 0.00000, 0.00000, '', 0, 0.00000, NULL, NULL),
(3374, 1771, 8545, 1, ' زعفران پاراین', 'product_8545', 0.00000, 0.00000, '', '', 0, '', 0, 0, '', '', 0.00000, 0.00000, '', 0, 0.00000, NULL, NULL),
(3375, 1772, 8548, 1, ' زعفران پاراین', 'product_8548', 0.00000, 0.00000, '', '', 0, '', 0, 0, '', '', 0.00000, 0.00000, '', 0, 0.00000, NULL, NULL),
(3376, 1772, 8547, 1, ' زعفران پاراین', 'product_8547', 0.00000, 0.00000, '', '', 0, '', 0, 0, '', '', 0.00000, 0.00000, '', 0, 0.00000, NULL, NULL),
(3377, 1772, 8545, 1, ' زعفران پاراین', 'product_8545', 0.00000, 0.00000, '', '', 0, '', 0, 0, '', '', 0.00000, 0.00000, '', 0, 0.00000, NULL, NULL),
(3378, 1773, 9038, 1, ' سوپ جو سبزان', 'product_9038', 0.00000, 0.00000, '', '', 0, '', 0, 0, '', '', 0.00000, 0.00000, '', 0, 0.00000, NULL, NULL),
(3379, 1773, 9036, 1, 'فلافل 400 گرمی مام', 'product_9036', 0.00000, 0.00000, '', '', 0, '', 0, 0, '', '', 0.00000, 0.00000, '', 0, 0.00000, NULL, NULL),
(3380, 1773, 8547, 1, ' زعفران پاراین', 'product_8547', 0.00000, 0.00000, '', '', 0, '', 0, 0, '', '', 0.00000, 0.00000, '', 0, 0.00000, NULL, NULL),
(3381, 1774, 9038, 1, ' سوپ جو سبزان', 'product_9038', 0.00000, 0.00000, '', '', 0, '', 0, 0, '', '', 0.00000, 0.00000, '', 0, 0.00000, NULL, NULL),
(3382, 1775, 9036, 1, 'فلافل 400 گرمی مام', 'product_9036', 0.00000, 0.00000, '', '', 0, '', 0, 0, '', '', 0.00000, 0.00000, '', 0, 0.00000, NULL, NULL),
(3383, 1776, 8547, 1, ' زعفران پاراین', 'product_8547', 0.00000, 0.00000, '', '', 0, '', 0, 0, '', '', 0.00000, 0.00000, '', 0, 0.00000, NULL, NULL),
(3384, 1777, 49695, 1, 'اسپری زنانه کاتن + رول رایگان  رکسونا', 'product_49695', 0.00000, 0.00000, '', '', 0, '', 0, 0, '', '', 0.00000, 0.00000, '', 0, 0.00000, NULL, NULL),
(3385, 1778, 49695, 1, 'اسپری زنانه کاتن + رول رایگان  رکسونا', 'product_49695', 0.00000, 0.00000, '', '', 0, '', 0, 0, '', '', 0.00000, 0.00000, '', 0, 0.00000, NULL, NULL),
(3386, 1779, 49695, 1, 'اسپری زنانه کاتن + رول رایگان  رکسونا', 'product_49695', 0.00000, 0.00000, '', '', 0, '', 0, 0, '', '', 0.00000, 0.00000, '', 0, 0.00000, NULL, NULL),
(3387, 1780, 49695, 1, 'اسپری زنانه کاتن + رول رایگان  رکسونا', 'product_49695', 0.00000, 0.00000, '', '', 0, '', 0, 0, '', '', 0.00000, 0.00000, '', 0, 0.00000, NULL, NULL),
(3388, 1781, 50131, 1, 'نرم کننده موی رنگ شده 350 میلی سانسیلک', 'product_50131', 0.00000, 0.00000, '', '', 0, '', 0, 0, '', '', 0.00000, 0.00000, '', 0, 0.00000, NULL, NULL),
(3389, 1782, 50131, 1, 'نرم کننده موی رنگ شده 350 میلی سانسیلک', 'product_50131', 0.00000, 0.00000, '', '', 0, '', 0, 0, '', '', 0.00000, 0.00000, '', 0, 0.00000, NULL, NULL),
(3390, 1783, 50661, 1, 'جرم گیر 4000 گرمی سورمه ای اکتیو', 'product_50661', 0.00000, 0.00000, '', '', 0, '', 0, 0, '', '', 0.00000, 0.00000, '', 0, 0.00000, NULL, NULL),
(3391, 1784, 50661, 1, 'جرم گیر 4000 گرمی سورمه ای اکتیو', 'product_50661', 0.00000, 0.00000, '', '', 0, '', 0, 0, '', '', 0.00000, 0.00000, '', 0, 0.00000, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pish_hikashop_order_product`
--
ALTER TABLE `pish_hikashop_order_product`
  ADD PRIMARY KEY (`order_product_id`),
  ADD KEY `order_id` (`order_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pish_hikashop_order_product`
--
ALTER TABLE `pish_hikashop_order_product`
  MODIFY `order_product_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3392;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
