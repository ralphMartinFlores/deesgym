-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 05, 2021 at 05:54 PM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 7.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cartridge_extra_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `brands_tbl`
--

CREATE TABLE `brands_tbl` (
  `brand_id` int(11) NOT NULL,
  `brand_name` char(50) NOT NULL,
  `brand_createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `brand_updatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `brands_tbl`
--

INSERT INTO `brands_tbl` (`brand_id`, `brand_name`, `brand_createdAt`, `brand_updatedAt`) VALUES
(6, 'Brother', '2021-11-05 04:26:13', '2021-11-05 04:26:13'),
(7, 'HP', '2021-11-05 04:26:17', '2021-11-05 04:26:17'),
(8, 'Epson', '2021-11-05 04:26:21', '2021-11-05 04:26:21'),
(9, 'Canon', '2021-11-05 04:27:42', '2021-11-05 04:27:42');

-- --------------------------------------------------------

--
-- Table structure for table `carts_tbl`
--

CREATE TABLE `carts_tbl` (
  `cart_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `cart_createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `cart_updatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `carts_tbl`
--

INSERT INTO `carts_tbl` (`cart_id`, `user_id`, `cart_createdAt`, `cart_updatedAt`) VALUES
(1, 4, '2021-11-04 05:20:10', '2021-11-04 05:20:10'),
(2, 5, '2021-11-04 05:44:10', '2021-11-04 05:44:10'),
(3, 6, '2021-11-16 03:21:00', '2021-11-16 03:21:00'),
(4, 7, '2021-11-16 03:22:00', '2021-11-16 03:22:00'),
(5, 1, '2021-11-18 04:41:34', '2021-11-18 04:41:34'),
(6, 8, '2021-11-25 02:49:17', '2021-11-25 02:49:17'),
(7, 9, '2021-11-25 02:52:14', '2021-11-25 02:52:14');

-- --------------------------------------------------------

--
-- Table structure for table `cart_items_tbl`
--

CREATE TABLE `cart_items_tbl` (
  `cart_item_id` int(11) NOT NULL,
  `cart_id` int(11) NOT NULL,
  `prod_id` int(11) NOT NULL,
  `cart_item_isTod` int(1) NOT NULL,
  `cart_item_quantity` int(11) NOT NULL DEFAULT 1,
  `cart_item_createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `cart_item_updatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cart_items_tbl`
--

INSERT INTO `cart_items_tbl` (`cart_item_id`, `cart_id`, `prod_id`, `cart_item_isTod`, `cart_item_quantity`, `cart_item_createdAt`, `cart_item_updatedAt`) VALUES
(57, 4, 47, 1, 1, '2021-11-16 03:23:20', '2021-11-16 03:23:20'),
(129, 1, 46, 1, 1, '2021-12-04 05:21:34', '2021-12-04 05:21:34'),
(130, 5, 46, 1, 2, '2021-12-04 07:02:47', '2021-12-05 08:59:04');

-- --------------------------------------------------------

--
-- Table structure for table `categories_tbl`
--

CREATE TABLE `categories_tbl` (
  `category_id` int(11) NOT NULL,
  `category_name` char(50) NOT NULL,
  `category_createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `category_updatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories_tbl`
--

INSERT INTO `categories_tbl` (`category_id`, `category_name`, `category_createdAt`, `category_updatedAt`) VALUES
(3, 'Inks', '2021-11-06 04:48:06', '2021-11-06 04:48:06'),
(4, 'Toners', '2021-11-06 04:48:06', '2021-11-06 04:48:06'),
(17, 'Printers', '2021-11-06 04:48:06', '2021-11-06 04:48:06');

-- --------------------------------------------------------

--
-- Table structure for table `customers_tbl`
--

CREATE TABLE `customers_tbl` (
  `customer_id` int(11) NOT NULL,
  `customer_fname` varchar(255) NOT NULL,
  `customer_lname` varchar(255) NOT NULL,
  `customer_email` varchar(255) NOT NULL,
  `customer_email2` varchar(255) DEFAULT NULL,
  `customer_email3` varchar(255) DEFAULT NULL,
  `customer_phonenum` varchar(255) NOT NULL,
  `customer_company_name` varchar(255) DEFAULT NULL,
  `customer_country` varchar(255) NOT NULL,
  `customer_city` varchar(255) NOT NULL,
  `customer_state` varchar(255) NOT NULL,
  `customer_zipcode` char(10) NOT NULL,
  `customer_address` varchar(255) NOT NULL,
  `customer_createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `customer_updatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customers_tbl`
--

INSERT INTO `customers_tbl` (`customer_id`, `customer_fname`, `customer_lname`, `customer_email`, `customer_email2`, `customer_email3`, `customer_phonenum`, `customer_company_name`, `customer_country`, `customer_city`, `customer_state`, `customer_zipcode`, `customer_address`, `customer_createdAt`, `customer_updatedAt`) VALUES
(2, 'mike', 'test', 'test@gmail.com', 'test2@gmail.com', 'test3@gmail.com', '12312323', 'test@gmail.com', 'Algeria', 'Olongapo City', 'Queensland', '2200', 'test test test test', '2021-12-04 06:58:55', '2021-12-04 09:47:00'),
(4, 'customer', 'customer', 'customer@gmail.com', 'customer2@gmail.com', 'customer3@gmail.com', '123123123', 'customer@gmail.com', 'Albania', 'Olongapo City', 'Queensland', '2200', 'test test test test', '2021-12-04 10:21:17', '2021-12-04 10:21:17');

-- --------------------------------------------------------

--
-- Table structure for table `orders_tbl`
--

CREATE TABLE `orders_tbl` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `order_total` int(11) NOT NULL,
  `order_shipping_fee` int(11) NOT NULL,
  `order_grand_total` int(11) NOT NULL,
  `order_total_items` int(11) NOT NULL,
  `order_delivery_method` int(11) NOT NULL,
  `order_status` int(1) NOT NULL DEFAULT 0,
  `order_createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `order_updatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders_tbl`
--

INSERT INTO `orders_tbl` (`order_id`, `user_id`, `order_total`, `order_shipping_fee`, `order_grand_total`, `order_total_items`, `order_delivery_method`, `order_status`, `order_createdAt`, `order_updatedAt`) VALUES
(108, 4, 369, 0, 369, 3, 0, 2, '2021-11-17 05:16:39', '2021-11-30 05:06:54'),
(109, 1, 246, 8, 254, 2, 0, 2, '2021-11-24 11:35:36', '2021-12-04 06:48:20'),
(110, 1, 738, 8, 746, 3, 0, 2, '2021-11-25 02:56:56', '2021-12-04 06:48:20'),
(111, 4, 369, 8, 377, 3, 0, 2, '2021-11-25 03:01:25', '2021-12-04 05:36:15'),
(112, 4, 123, 8, 131, 1, 0, 2, '2021-11-27 06:23:23', '2021-12-04 06:48:20'),
(113, 4, 246, 8, 254, 2, 0, 2, '2021-11-27 06:26:48', '2021-12-04 06:48:20'),
(114, 4, 246, 8, 254, 2, 0, 2, '2021-11-27 06:37:34', '2021-12-04 06:48:20'),
(115, 1, 123, 7, 130, 1, 0, 2, '2021-11-27 06:57:13', '2021-12-04 07:12:25'),
(116, 1, 123, 7, 130, 1, 0, 2, '2021-11-27 06:57:44', '2021-12-04 07:12:25'),
(117, 1, 123, 7, 130, 1, 0, 2, '2021-11-27 06:59:12', '2021-12-04 07:12:25'),
(118, 4, 111, 10, 121, 1, 0, 0, '2021-11-30 06:20:40', '2021-11-30 06:20:40'),
(119, 4, 111, 10, 121, 1, 0, 0, '2021-12-01 07:15:51', '2021-12-01 07:15:51'),
(120, 4, 111, 10, 121, 1, 0, 0, '2021-12-01 07:20:31', '2021-12-01 07:20:31'),
(121, 4, 111, 10, 121, 1, 0, 0, '2021-12-01 07:39:48', '2021-12-01 07:39:48');

-- --------------------------------------------------------

--
-- Table structure for table `order_items_tbl`
--

CREATE TABLE `order_items_tbl` (
  `order_item_id` int(11) NOT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `order_id` int(11) NOT NULL,
  `prod_id` int(11) NOT NULL,
  `order_item_quantity` int(11) NOT NULL,
  `order_item_isTod` int(1) NOT NULL,
  `order_item_tracking_number` varchar(255) DEFAULT NULL,
  `order_item_createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `order_item_updatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `order_items_tbl`
--

INSERT INTO `order_items_tbl` (`order_item_id`, `supplier_id`, `order_id`, `prod_id`, `order_item_quantity`, `order_item_isTod`, `order_item_tracking_number`, `order_item_createdAt`, `order_item_updatedAt`) VALUES
(206, 3, 108, 46, 1, 1, '123', '2021-11-24 05:16:39', '2021-11-27 07:27:58'),
(207, 1, 108, 49, 1, 0, '123', '2021-11-24 05:16:39', '2021-11-30 05:06:44'),
(208, 1, 108, 52, 1, 0, '123', '2021-11-24 05:16:39', '2021-11-30 05:06:44'),
(209, 3, 109, 46, 1, 1, NULL, '2021-11-24 11:35:36', '2021-11-24 11:35:36'),
(210, 3, 109, 48, 1, 0, NULL, '2021-11-24 11:35:36', '2021-11-24 11:35:36'),
(211, 3, 110, 44, 3, 1, NULL, '2021-11-25 02:56:56', '2021-11-25 02:56:56'),
(212, 3, 110, 47, 1, 0, NULL, '2021-11-25 02:56:56', '2021-11-25 02:56:56'),
(213, 3, 110, 48, 2, 0, NULL, '2021-11-25 02:56:56', '2021-11-25 02:56:56'),
(214, 3, 111, 46, 1, 1, NULL, '2021-11-25 03:01:25', '2021-11-25 03:01:25'),
(215, 1, 111, 50, 1, 0, NULL, '2021-11-25 03:01:25', '2021-11-25 03:01:25'),
(216, 1, 111, 44, 1, 0, NULL, '2021-11-25 03:01:25', '2021-11-25 03:01:25'),
(217, 1, 112, 46, 1, 0, NULL, '2021-11-27 06:23:23', '2021-11-27 06:23:23'),
(218, 1, 113, 46, 1, 0, NULL, '2021-11-27 06:26:48', '2021-11-27 06:26:48'),
(219, 3, 113, 44, 1, 1, NULL, '2021-11-27 06:26:48', '2021-11-27 06:26:48'),
(220, 3, 114, 46, 1, 1, NULL, '2021-11-27 06:37:34', '2021-11-27 06:37:34'),
(221, 1, 114, 44, 1, 0, NULL, '2021-11-27 06:37:34', '2021-11-27 06:37:34'),
(222, 1, 115, 46, 1, 0, NULL, '2021-11-27 06:57:13', '2021-11-27 06:57:13'),
(223, 1, 116, 46, 1, 0, NULL, '2021-11-27 06:57:44', '2021-11-27 06:57:44'),
(224, 1, 117, 46, 1, 0, '321', '2021-11-27 06:59:12', '2021-11-29 08:47:19'),
(225, 1, 118, 46, 1, 0, NULL, '2021-11-30 06:20:40', '2021-11-30 06:20:40'),
(226, 1, 119, 46, 1, 0, NULL, '2021-12-01 07:15:51', '2021-12-01 07:15:51'),
(227, 1, 120, 46, 1, 0, NULL, '2021-12-01 07:20:31', '2021-12-01 07:20:31'),
(228, 1, 121, 46, 1, 0, NULL, '2021-12-01 07:39:48', '2021-12-01 07:39:48');

-- --------------------------------------------------------

--
-- Table structure for table `products_tbl`
--

CREATE TABLE `products_tbl` (
  `prod_id` int(11) NOT NULL,
  `prod_image_filepath` varchar(255) NOT NULL,
  `category_id` int(11) NOT NULL,
  `brand_id` int(11) NOT NULL,
  `prod_model` text NOT NULL,
  `prod_tod_code` char(50) NOT NULL,
  `prod_oem_code` char(50) DEFAULT NULL,
  `prod_name` char(50) NOT NULL,
  `prod_color` char(50) DEFAULT NULL,
  `prod_yield` char(50) DEFAULT NULL,
  `prod_desc` longtext DEFAULT NULL,
  `prod_qty` int(11) NOT NULL,
  `prod_cost_raw` int(11) NOT NULL,
  `prod_sell_price` int(11) NOT NULL,
  `ratingsCount` int(11) NOT NULL,
  `ratingsValue` int(11) NOT NULL,
  `prod_createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `prod_updatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products_tbl`
--

INSERT INTO `products_tbl` (`prod_id`, `prod_image_filepath`, `category_id`, `brand_id`, `prod_model`, `prod_tod_code`, `prod_oem_code`, `prod_name`, `prod_color`, `prod_yield`, `prod_desc`, `prod_qty`, `prod_cost_raw`, `prod_sell_price`, `ratingsCount`, `ratingsValue`, `prod_createdAt`, `prod_updatedAt`) VALUES
(44, 'uploads/products/202111041824040.jpg', 3, 8, 'Ink1', 'asddsa', 'qweeqw', 'Ink1', 'Magenta', 'Ink1', 'Ink1', 123, 123, 123, 5, 100, '2021-11-04 07:24:04', '2021-11-25 02:54:10'),
(46, 'uploads/products/202111041845360.jpg', 3, 9, 'Ink2', 'asddsa', 'qweeq', 'Ink2', 'Yellow', 'Ink2', 'Ink2', 117, 123, 111, 0, 0, '2021-11-04 07:45:36', '2021-12-01 07:50:44'),
(47, 'uploads/products/202111041846270.jpg', 3, 7, 'Ink3', 'Ink3', 'Ink3', 'Ink3', 'Black', 'Ink3', 'Ink3', 123, 123, 123, 0, 0, '2021-11-04 07:46:27', '2021-11-15 11:46:47'),
(48, 'uploads/products/202111041848180.jpg', 17, 9, 'p1p1', 'p1p1', 'p1p1', 'p1p1', 'Black', 'p1p1', 'p1p1', 123, 123, 123, 0, 0, '2021-11-04 07:48:18', '2021-11-15 11:46:53'),
(49, 'uploads/products/202111041853530.jpg', 17, 8, 'p2p2', 'p2p2', 'p2p2', 'p2p2', 'Magenta', 'p2p2', 'p2p2', 123, 123, 123, 0, 0, '2021-11-04 07:53:53', '2021-11-15 11:47:02'),
(50, 'uploads/products/202111041854150.jpg', 17, 7, 'p3p3', 'p3p3', 'p3p3', 'p3p3', 'Cyan', 'p3p3', 'p3p3', 123, 123, 123, 0, 0, '2021-11-04 07:54:15', '2021-11-15 11:46:58'),
(51, 'uploads/products/202111041855020.jpg', 17, 7, 'p4p4', 'p4p4', 'p4p4', 'p4p4', 'Yellow', 'p4p4', 'p4p4', 123, 123, 123, 0, 0, '2021-11-04 07:55:02', '2021-11-16 04:00:45'),
(52, 'uploads/products/202111041855270.jpg', 4, 7, 'toner1', 'toner1', 'toner1', 'toner1', 'Light Cyan', 'toner1', 'toner1', 123, 123, 123, 0, 0, '2021-11-04 07:55:27', '2021-11-15 11:47:18'),
(53, 'uploads/products/202111041855430.jpg', 4, 9, 'toner2', 'toner2', 'toner2', 'toner2', 'Magenta', 'toner2', 'toner2', 123, 123, 123, 0, 0, '2021-11-04 07:55:43', '2021-11-15 11:47:22'),
(54, 'uploads/products/202111041855580.png', 4, 6, 'toner2', 'toner2', 'toner2', 'toner3', 'Black', 'toner2', 'toner2', 123, 123, 123, 0, 0, '2021-11-04 07:55:58', '2021-11-15 11:47:26');

-- --------------------------------------------------------

--
-- Table structure for table `product_images_tbl`
--

CREATE TABLE `product_images_tbl` (
  `prod_img_id` int(11) NOT NULL,
  `prod_id` int(11) NOT NULL,
  `prod_img_filepath` varchar(255) NOT NULL,
  `prod_image_createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `prod_image_updatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product_images_tbl`
--

INSERT INTO `product_images_tbl` (`prod_img_id`, `prod_id`, `prod_img_filepath`, `prod_image_createdAt`, `prod_image_updatedAt`) VALUES
(95, 44, 'uploads/products/202111041824040.jpg', '2021-11-04 07:24:04', '2021-11-04 07:24:04'),
(98, 46, 'uploads/products/202111041845360.jpg', '2021-11-04 07:45:36', '2021-11-04 07:45:36'),
(99, 47, 'uploads/products/202111041846270.jpg', '2021-11-04 07:46:27', '2021-11-04 07:46:27'),
(100, 48, 'uploads/products/202111041848180.jpg', '2021-11-04 07:48:18', '2021-11-04 07:48:18'),
(101, 49, 'uploads/products/202111041853530.jpg', '2021-11-04 07:53:53', '2021-11-04 07:53:53'),
(102, 50, 'uploads/products/202111041854150.jpg', '2021-11-04 07:54:15', '2021-11-04 07:54:15'),
(103, 51, 'uploads/products/202111041855020.jpg', '2021-11-04 07:55:02', '2021-11-04 07:55:02'),
(104, 52, 'uploads/products/202111041855270.jpg', '2021-11-04 07:55:27', '2021-11-04 07:55:27'),
(105, 53, 'uploads/products/202111041855430.jpg', '2021-11-04 07:55:43', '2021-11-04 07:55:43'),
(106, 54, 'uploads/products/202111041855580.png', '2021-11-04 07:55:58', '2021-11-04 07:55:58'),
(107, 55, 'uploads/products/202111161411060.jpg', '2021-11-16 03:11:06', '2021-11-16 03:11:06'),
(108, 56, 'uploads/products/202111161444150.jpg', '2021-11-16 03:44:16', '2021-11-16 03:44:16'),
(109, 57, 'uploads/products/202111161449290.jpg', '2021-11-16 03:49:29', '2021-11-16 03:49:29'),
(110, 58, 'uploads/products/202111251347410.png', '2021-11-25 02:47:41', '2021-11-25 02:47:41'),
(111, 59, 'uploads/products/202111251355250.png', '2021-11-25 02:55:25', '2021-11-25 02:55:25');

-- --------------------------------------------------------

--
-- Table structure for table `ratings_tbl`
--

CREATE TABLE `ratings_tbl` (
  `rating_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `prod_id` int(11) NOT NULL,
  `rating_star` int(1) NOT NULL,
  `rating_comment` longtext DEFAULT NULL,
  `rating_reply` longtext NOT NULL,
  `rating_status` int(1) NOT NULL,
  `rating_createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `rating_updatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ratings_tbl`
--

INSERT INTO `ratings_tbl` (`rating_id`, `user_id`, `prod_id`, `rating_star`, `rating_comment`, `rating_reply`, `rating_status`, `rating_createdAt`, `rating_updatedAt`) VALUES
(1, 4, 44, 4, '', 'thank you so much!', 1, '2021-11-08 07:22:33', '2021-11-08 08:20:18'),
(5, 4, 46, 2, 'pwede na, dina masama', '', 0, '2021-11-08 09:53:52', '2021-11-08 09:53:52'),
(6, 4, 44, 2, 'pwede na', '', 0, '2021-11-09 03:13:56', '2021-11-09 03:13:56'),
(7, 4, 46, 4, NULL, '', 0, '2021-12-01 06:46:49', '2021-12-01 06:46:49'),
(8, 4, 46, 4, NULL, '', 0, '2021-12-01 06:47:05', '2021-12-01 06:47:05'),
(9, 4, 46, 4, NULL, '', 0, '2021-12-01 06:49:44', '2021-12-01 06:49:44'),
(10, 4, 46, 3, NULL, '', 0, '2021-12-01 06:50:47', '2021-12-01 06:50:47'),
(11, 4, 46, 4, NULL, '', 0, '2021-12-01 06:57:06', '2021-12-01 06:57:06'),
(12, 4, 46, 4, NULL, '', 0, '2021-12-01 07:00:18', '2021-12-01 07:00:18'),
(13, 4, 46, 2, NULL, '', 0, '2021-12-01 07:05:22', '2021-12-01 07:05:22');

-- --------------------------------------------------------

--
-- Table structure for table `regular_orders_tbl`
--

CREATE TABLE `regular_orders_tbl` (
  `reg_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `prod_id` int(11) NOT NULL,
  `reg_isTod` int(1) NOT NULL,
  `reg_createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `reg_updatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `suppliers_tbl`
--

CREATE TABLE `suppliers_tbl` (
  `sup_id` int(11) NOT NULL,
  `sup_code` varchar(255) NOT NULL,
  `sup_name` char(100) NOT NULL,
  `sup_email` char(100) NOT NULL,
  `sup_homepage` char(100) NOT NULL,
  `sup_contact_person` char(20) DEFAULT NULL,
  `sup_tel_phone` char(20) DEFAULT NULL,
  `sup_phonenum` text DEFAULT NULL,
  `sup_phone_work` char(20) DEFAULT NULL,
  `sup_country` text NOT NULL,
  `sup_city` text NOT NULL,
  `sup_state` text NOT NULL,
  `sup_zipcode` text NOT NULL,
  `sup_address` char(150) NOT NULL,
  `sup_delivery_fee` int(11) NOT NULL,
  `sup_createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `sup_updatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `suppliers_tbl`
--

INSERT INTO `suppliers_tbl` (`sup_id`, `sup_code`, `sup_name`, `sup_email`, `sup_homepage`, `sup_contact_person`, `sup_tel_phone`, `sup_phonenum`, `sup_phone_work`, `sup_country`, `sup_city`, `sup_state`, `sup_zipcode`, `sup_address`, `sup_delivery_fee`, `sup_createdAt`, `sup_updatedAt`) VALUES
(1, 'PGI2600XLBK', 'supplier2', 'supplier2@gmail.com', 'www.supplier2.com', 'supplier2', '123123123', '09472011518', '1111111', 'Philippines', 'Olongapo City', 'Zambales', '2200', '1383 tabacuhan road sta. rita', 7, '2021-11-05 06:48:46', '2021-12-04 07:09:42'),
(3, 'PGI2600XLC', 'Supplier1', 'supplier1@gmail.com', 'www.supplier1.com', 'supplier1', '321321321', '09126361812', '222222', 'Philippines', 'Olongapo City', 'Queensland', '2200', 'test test test test', 8, '2021-11-15 08:51:12', '2021-12-04 07:10:10'),
(5, 'PGI2600JSI', 'supplier3', 'supplier3@gmail.com', 'www.supplier3.com', 'supplier3', '423423423', '1231312321', '3333333', 'Aland Islands', 'Olongapo City', 'Queensland', '2200', 'supplier3', 20, '2021-11-27 07:06:24', '2021-12-04 07:10:13');

-- --------------------------------------------------------

--
-- Table structure for table `users_tbl`
--

CREATE TABLE `users_tbl` (
  `fld_id` int(11) NOT NULL,
  `user_lname` char(50) NOT NULL,
  `user_fname` char(50) NOT NULL,
  `user_email` char(100) NOT NULL,
  `user_email2` varchar(255) DEFAULT NULL,
  `user_email3` varchar(255) DEFAULT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_image` char(50) NOT NULL,
  `user_country` char(50) NOT NULL,
  `user_city` char(50) NOT NULL,
  `user_state` char(50) NOT NULL,
  `user_zipcode` int(5) NOT NULL,
  `user_address` char(100) NOT NULL,
  `user_role` int(1) NOT NULL DEFAULT 2,
  `user_contactnum` text NOT NULL,
  `fld_token` varchar(255) NOT NULL,
  `fld_isVerified` int(1) NOT NULL DEFAULT 0,
  `user_isDeleted` int(1) NOT NULL DEFAULT 0,
  `user_dateJoined` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_updatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users_tbl`
--

INSERT INTO `users_tbl` (`fld_id`, `user_lname`, `user_fname`, `user_email`, `user_email2`, `user_email3`, `user_password`, `user_image`, `user_country`, `user_city`, `user_state`, `user_zipcode`, `user_address`, `user_role`, `user_contactnum`, `fld_token`, `fld_isVerified`, `user_isDeleted`, `user_dateJoined`, `user_updatedAt`) VALUES
(1, 'Cartidge', 'Extra', 'admin@cartridgeextra.com', NULL, NULL, '$2y$10$Yzk3OWJlOTQ0Y2YyMDg3NuVYIlCOsb4R/tc16I9MABZT40lMaAcuq', 'uploads/users/20211013141422.jpg', 'Philippines', 'Olongapo City', 'Zambales', 2200, '1383 tabacuhan road sta. rita', 0, '09472011518', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiIsImFwcCI6Ik15IEFwcCIsImRldiI6IlRoZSBEZXZlbG9wZXIifQ.eyJ1YyI6MSwidWUiOiJhZG1pbkBjYXJ0cmlkZ2VleHRyYS5jb20iLCJpdG8iOiJFeHRyYSBDYXJ0aWRnZSIsImlieSI6IlRoZSBEZXZlbG9wZXIiLCJpZSI6InRoZWRldmVsb3BlckB0ZXN0LmNvbSIsImV4cCI6IjIwMjEt', 0, 0, '2021-10-08 05:58:48', '2021-11-30 06:31:48'),
(4, 'client', 'Client', 'client@gmail.com', 'client2@gmail.com', 'client3@gmail.com', '$2y$10$ZDg5MWNiYTAxMDljYzJkNufSt2OQnYfClLtyjFwYlKps/lfQGy4Py', '', 'Poland', 'Olongapo City', 'Zambales', 2200, '1383 tabacuhan road sta. rita', 2, '09472011518', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiIsImFwcCI6Ik15IEFwcCIsImRldiI6IlRoZSBEZXZlbG9wZXIifQ.eyJ1YyI6NCwidWUiOiJjbGllbnRAZ21haWwuY29tIiwiaXRvIjoiQ2xpZW50IGNsaWVudCIsImlieSI6IlRoZSBEZXZlbG9wZXIiLCJpZSI6InRoZWRldmVsb3BlckB0ZXN0LmNvbSIsImV4cCI6IjIwMjEtMTItMDUgMTk6', 0, 0, '2021-11-04 05:20:10', '2021-12-05 08:30:34'),
(7, 'sample', 'sample', 'sample@gmail.com', NULL, NULL, '$2y$10$MjNiZDA5YTczMjE2OWY4OOj.U1UhiolI.gPT00xpQkIndKDupctBi', '', '', '', '', 0, '', 2, '', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiIsImFwcCI6Ik15IEFwcCIsImRldiI6IlRoZSBEZXZlbG9wZXIifQ.eyJ1YyI6NywidWUiOiJzYW1wbGVAZ21haWwuY29tIiwiaXRvIjoic2FtcGxlIHNhbXBsZSIsImlieSI6IlRoZSBEZXZlbG9wZXIiLCJpZSI6InRoZWRldmVsb3BlckB0ZXN0LmNvbSIsImV4cCI6IjIwMjEtMTEtMTYgMTQ6', 0, 0, '2021-11-16 03:22:00', '2021-11-16 03:22:05'),
(9, 'Front', 'Desk', 'frontdesk@cartridgeextra.com', NULL, NULL, '$2y$10$ZTU1ZDRmYWZmN2IwMDE3M.95GV9cbCjxycgj56G5Rhae987Aa9pCW', 'uploads/users/20211125135214.jpg', '', '', '', 0, '', 1, '12312312321', '', 0, 0, '2021-11-25 02:52:14', '2021-11-25 02:52:14');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `brands_tbl`
--
ALTER TABLE `brands_tbl`
  ADD PRIMARY KEY (`brand_id`);

--
-- Indexes for table `carts_tbl`
--
ALTER TABLE `carts_tbl`
  ADD PRIMARY KEY (`cart_id`);

--
-- Indexes for table `cart_items_tbl`
--
ALTER TABLE `cart_items_tbl`
  ADD PRIMARY KEY (`cart_item_id`);

--
-- Indexes for table `categories_tbl`
--
ALTER TABLE `categories_tbl`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `customers_tbl`
--
ALTER TABLE `customers_tbl`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `orders_tbl`
--
ALTER TABLE `orders_tbl`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `order_items_tbl`
--
ALTER TABLE `order_items_tbl`
  ADD PRIMARY KEY (`order_item_id`);

--
-- Indexes for table `products_tbl`
--
ALTER TABLE `products_tbl`
  ADD PRIMARY KEY (`prod_id`);

--
-- Indexes for table `product_images_tbl`
--
ALTER TABLE `product_images_tbl`
  ADD PRIMARY KEY (`prod_img_id`);

--
-- Indexes for table `ratings_tbl`
--
ALTER TABLE `ratings_tbl`
  ADD PRIMARY KEY (`rating_id`);

--
-- Indexes for table `regular_orders_tbl`
--
ALTER TABLE `regular_orders_tbl`
  ADD PRIMARY KEY (`reg_id`);

--
-- Indexes for table `suppliers_tbl`
--
ALTER TABLE `suppliers_tbl`
  ADD PRIMARY KEY (`sup_id`);

--
-- Indexes for table `users_tbl`
--
ALTER TABLE `users_tbl`
  ADD PRIMARY KEY (`fld_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `brands_tbl`
--
ALTER TABLE `brands_tbl`
  MODIFY `brand_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `carts_tbl`
--
ALTER TABLE `carts_tbl`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `cart_items_tbl`
--
ALTER TABLE `cart_items_tbl`
  MODIFY `cart_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=131;

--
-- AUTO_INCREMENT for table `categories_tbl`
--
ALTER TABLE `categories_tbl`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `customers_tbl`
--
ALTER TABLE `customers_tbl`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `orders_tbl`
--
ALTER TABLE `orders_tbl`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=122;

--
-- AUTO_INCREMENT for table `order_items_tbl`
--
ALTER TABLE `order_items_tbl`
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=229;

--
-- AUTO_INCREMENT for table `products_tbl`
--
ALTER TABLE `products_tbl`
  MODIFY `prod_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `product_images_tbl`
--
ALTER TABLE `product_images_tbl`
  MODIFY `prod_img_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;

--
-- AUTO_INCREMENT for table `ratings_tbl`
--
ALTER TABLE `ratings_tbl`
  MODIFY `rating_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `regular_orders_tbl`
--
ALTER TABLE `regular_orders_tbl`
  MODIFY `reg_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `suppliers_tbl`
--
ALTER TABLE `suppliers_tbl`
  MODIFY `sup_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users_tbl`
--
ALTER TABLE `users_tbl`
  MODIFY `fld_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
