-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 06, 2024 at 01:28 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `multikart`
--

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `status` int UNSIGNED NOT NULL DEFAULT '1' COMMENT '1=Active, 0=Inactive',
  `image` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `name`, `slug`, `description`, `status`, `image`, `created_at`, `updated_at`) VALUES
(1, 'Elah Fashion', 'elah-fashion', '<p><strong>ELAH Fashion</strong> is most famous clothing brand in feni, Bangladesh.</p>', 1, NULL, '2023-10-03 05:03:47', '2024-02-01 11:42:44'),
(9, 'Jental Park', 'jental-park', NULL, 1, '1702806330-brand.png', '2023-11-04 10:47:02', '2023-12-17 03:45:30'),
(10, 'Easy', 'easy', '<p>Easy Special T-SHIRT COLLECTION SHOP NOW SCROLL NEW COLLECTION EASY JUNIOR SHOP NOW SCROLL PANJABI COLLECTION SHOP NOW SCROLL 010203 Follow</p>', 1, '1702806460-brand.jpeg', '2023-11-04 11:25:18', '2023-12-17 03:47:40'),
(18, 'Arden Casper', NULL, NULL, 0, NULL, '2023-11-22 06:24:36', '2023-11-22 06:24:36'),
(42, 'Sultan', 'sultan', NULL, 1, '1702805792-brand.jpeg', '2023-12-08 09:45:10', '2023-12-17 03:36:32');

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` int UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `product_quantity` int UNSIGNED NOT NULL DEFAULT '0',
  `prdtc_unt_pri` int UNSIGNED DEFAULT '0',
  `order_id` bigint UNSIGNED DEFAULT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`id`, `product_id`, `product_quantity`, `prdtc_unt_pri`, `order_id`, `user_id`, `ip_address`, `created_at`, `updated_at`) VALUES
(481, 204, 1, 590, 12, 22, '127.0.0.1', '2024-04-02 14:39:42', '2024-04-02 14:39:51'),
(482, 112, 1, 350, 13, 22, '127.0.0.1', '2024-04-02 14:40:32', '2024-04-02 14:41:04'),
(483, 69, 1, 1500, 13, 22, '127.0.0.1', '2024-04-02 14:40:55', '2024-04-02 14:41:04'),
(484, 204, 1, 590, 14, 22, '127.0.0.1', '2024-04-02 14:42:58', '2024-04-02 14:43:26'),
(485, 61, 1, 2000, 14, 22, '127.0.0.1', '2024-04-02 14:43:12', '2024-04-02 14:43:26'),
(683, 70, 1, 0, NULL, NULL, '127.0.0.1', '2024-04-24 21:29:22', '2024-04-24 21:29:22'),
(692, 201, 1, 1500, 15, 22, '127.0.0.1', '2024-05-03 10:09:39', '2024-05-03 10:09:58'),
(693, 112, 1, 350, 15, 22, '127.0.0.1', '2024-05-03 10:09:40', '2024-05-03 10:09:58'),
(694, 1, 1, 1100, 16, 22, '127.0.0.1', '2024-05-03 10:11:10', '2024-05-06 00:19:29');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `status` int UNSIGNED NOT NULL DEFAULT '1' COMMENT '1=Active, 0=Inactive',
  `image` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `description`, `status`, `image`, `created_at`, `updated_at`) VALUES
(18, 'Clothing', 'clothing', '<p><em>Clothing</em>&nbsp;is any item worn on the body. Typically,&nbsp;<em>clothing</em>&nbsp;is made of fabrics or textiles, but over time it has included garments made from animal skin and</p>', 1, '1704704813-category.jpeg', '2023-10-17 11:56:07', '2024-01-08 03:06:54'),
(21, 'Electronic', 'electronic', NULL, 1, NULL, '2023-10-19 23:41:59', '2024-01-31 13:06:00'),
(26, 'kids Item', 'kids-item', NULL, 1, '1702824474-category.jpg', '2023-10-26 23:44:19', '2023-12-29 03:03:32'),
(39, 'Women Items', 'women-items', NULL, 1, NULL, '2023-12-29 09:49:09', '2024-01-08 03:10:50'),
(41, 'Winter Collection', 'winter-collection', NULL, 1, '1704705011-category.jpeg', '2024-01-08 03:10:11', '2024-01-08 03:10:11'),
(42, 'Shoes', 'shoes', NULL, 1, '1704706867-category.png', '2024-01-08 03:41:07', '2024-01-08 03:41:07'),
(43, 'Watch', 'watch', '<p>Brand Name: LIGE, Band Length: 22cm, Style: Fashion &amp; Casual, Movement: Quartz, Certification: None, Water Resistance</p>', 1, '1704706993-category.jpg', '2024-01-08 03:43:13', '2024-01-08 03:43:13');

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int UNSIGNED NOT NULL DEFAULT '1' COMMENT '1=Active, 0=Inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `name`, `slug`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Bangladesh', 'bangladesh', 1, '2023-09-23 12:39:52', '2023-12-08 08:18:21'),
(4, 'Uganda', 'uganda', 1, '2023-09-23 12:43:10', '2023-10-13 02:09:04'),
(10, 'Pakistan', 'pakistan', 1, '2023-10-03 05:22:00', '2023-10-12 11:42:26'),
(24, 'x', 'x', 0, '2023-12-08 08:21:15', '2023-12-08 08:21:25');

-- --------------------------------------------------------

--
-- Table structure for table `cupons`
--

CREATE TABLE `cupons` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cupon_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('percent','fixed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'fixed',
  `discount_amount` double(10,2) DEFAULT NULL,
  `min_amount` double(10,2) DEFAULT NULL,
  `max_uses` int DEFAULT NULL,
  `max_uses_user` int DEFAULT NULL,
  `status` int UNSIGNED NOT NULL DEFAULT '1' COMMENT '1=Active, 0=Inactive',
  `start_at` datetime DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cupons`
--

INSERT INTO `cupons` (`id`, `title`, `cupon_code`, `type`, `discount_amount`, `min_amount`, `max_uses`, `max_uses_user`, `status`, `start_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(5, 'test', 'testdsfd', 'fixed', 100.00, 1000.00, 10, 2, 1, '2024-02-13 02:00:00', '2024-07-23 04:00:00', '2024-02-13 08:39:32', '2024-03-13 02:21:37'),
(6, 'test2', 'test2', 'percent', 10.00, 400.00, NULL, NULL, 1, '2024-02-12 22:39:00', '2024-08-22 22:39:00', '2024-02-14 12:51:14', '2024-03-13 02:24:52');

-- --------------------------------------------------------

--
-- Table structure for table `currencies`
--

CREATE TABLE `currencies` (
  `id` bigint UNSIGNED NOT NULL,
  `currency_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sign` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `exchange_rate` int NOT NULL,
  `status` int NOT NULL DEFAULT '1' COMMENT '1-active, 2=inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `currencies`
--

INSERT INTO `currencies` (`id`, `currency_name`, `sign`, `exchange_rate`, `status`, `created_at`, `updated_at`) VALUES
(2, 'BTD', '৳', 0, 1, '2024-01-30 07:47:45', '2024-01-30 07:47:45');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` int NOT NULL,
  `customer_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_email` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `districts`
--

CREATE TABLE `districts` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state_id` int DEFAULT NULL,
  `status` int UNSIGNED NOT NULL DEFAULT '1' COMMENT '1=Active, 0=Inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `districts`
--

INSERT INTO `districts` (`id`, `name`, `state_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Dhaka', 11, 1, '2023-09-25 12:44:17', '2023-12-08 09:35:31'),
(2, 'Gazipur', 11, 1, '2023-09-25 12:44:39', '2023-09-25 12:57:18'),
(5, 'Narayangonj', 11, 1, '2023-09-25 13:17:03', '2023-09-25 13:17:03'),
(6, 'Mirpur', 11, 1, '2023-09-25 13:17:30', '2024-01-21 09:43:31'),
(10, 'Pabna', 6, 1, '2023-09-25 13:21:31', '2023-10-13 09:10:25'),
(11, 'Chandina', 9, 1, '2023-09-25 13:23:19', '2023-09-25 13:23:19'),
(12, 'Chauddagram', 9, 1, '2023-09-25 13:24:07', '2023-09-25 13:24:07'),
(33, 'Feni', 12, 1, '2024-01-21 12:32:40', '2024-01-21 12:32:40');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `image_galleries`
--

CREATE TABLE `image_galleries` (
  `id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `image_galleries`
--

INSERT INTO `image_galleries` (`id`, `product_id`, `name`, `created_at`, `updated_at`) VALUES
(60, 103, 'uploads/product/image-gallery/1161831733-product-gallery.jpg', NULL, NULL),
(61, 103, 'uploads/product/image-gallery/317215348-product-gallery.jpg', NULL, NULL),
(62, 105, 'uploads/product/image-gallery/1108016891-product-gallery.png', NULL, NULL),
(63, 105, 'uploads/product/image-gallery/1915609827-product-gallery.png', NULL, NULL),
(64, 105, 'uploads/product/image-gallery/763058402-product-gallery.png', NULL, NULL),
(65, 105, 'uploads/product/image-gallery/45361358-product-gallery.jpg', NULL, NULL),
(76, 112, 'uploads/product/image-gallery/232355076-product-gallery.png', NULL, NULL),
(77, 112, 'uploads/product/image-gallery/2037508046-product-gallery.png', NULL, NULL),
(105, 39, 'uploads/product/image-gallery/588729694-product-gallery.jpg', NULL, NULL),
(106, 39, 'uploads/product/image-gallery/1835844435-product-gallery.jpg', NULL, NULL),
(154, 40, 'uploads/product/image-gallery/494261689-product-gallery.jpeg', '2024-01-27 03:15:24', '2024-01-27 03:18:59'),
(155, 1, 'uploads/product/image-gallery/1716316842-product-gallery.jpeg', '2024-01-27 03:26:40', '2024-01-27 03:26:40'),
(156, 1, 'uploads/product/image-gallery/442612777-product-gallery.png', '2024-01-27 03:26:41', '2024-01-27 03:26:41'),
(158, 4, 'uploads/product/image-gallery/1035171681-product-gallery.jpg', '2024-01-27 08:55:16', '2024-01-27 08:55:16'),
(161, 32, 'uploads/product/image-gallery/877054816-product-gallery.jpeg', '2024-01-27 14:19:09', '2024-01-27 14:19:56'),
(162, 36, 'uploads/product/image-gallery/1014565905-product-gallery.jpeg', '2024-01-28 06:15:55', '2024-01-28 06:16:47');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` bigint UNSIGNED NOT NULL,
  `ip_address` text COLLATE utf8mb4_unicode_ci,
  `user_id` int DEFAULT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` text COLLATE utf8mb4_unicode_ci,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `rep_message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `message_time` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `ip_address`, `user_id`, `first_name`, `last_name`, `user_email`, `phone`, `message`, `rep_message`, `message_time`, `created_at`, `updated_at`) VALUES
(1, '127.0.0.1', NULL, 'Abdullah', 'Rahin', 'abdullahrahin25@gmail.com', NULL, 'Hello Multikart', '<p>Hello <strong>Abdullah</strong>, How Are You? how can we help you</p>', '2024-01-23 19:08:45', NULL, '2024-01-24 00:23:07'),
(2, '127.0.0.1', 22, 'Rahin', 'Ahmed', 'ahmed@gmail.com', '01887497149', 'Hello', '<p><strong>Thank You</strong></p>', '2024-01-23 20:10:29', NULL, '2024-01-24 00:20:48'),
(3, '127.0.0.1', 22, 'Md', 'kuddus', 'ahmed@gmail.com', '01885940', 'How Are You?', NULL, '2024-02-18 09:13:45', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(9, '2014_10_12_000000_create_users_table', 1),
(10, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(11, '2019_08_19_000000_create_failed_jobs_table', 1),
(12, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(16, '2023_09_22_181438_create_countries_table', 1),
(17, '2023_09_25_141814_create_states_table', 2),
(18, '2023_09_25_141836_create_districts_table', 2),
(19, '2023_09_22_130900_create_brands_table', 3),
(23, '2023_09_22_130920_create_categories_table', 6),
(25, '2023_10_03_104145_create_products_table', 8),
(35, '2014_10_12_000000_create_users_table', 1),
(36, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(37, '2019_08_19_000000_create_failed_jobs_table', 1),
(38, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(39, '2023_09_22_130900_create_brands_table', 1),
(40, '2023_09_22_130920_create_categories_table', 1),
(41, '2023_09_22_181438_create_countries_table', 1),
(42, '2023_09_25_141814_create_states_table', 1),
(43, '2023_09_25_141836_create_districts_table', 1),
(44, '2023_10_03_104145_create_products_table', 1),
(52, '2023_11_22_073943_create_tests_table', 13),
(54, '2023_10_14_151634_create_subcategories_table', 15),
(60, '2023_11_10_192121_create_carts_table', 16),
(85, '2024_01_11_144312_create_customers_table', 19),
(86, '2024_01_13_194757_create_wishlists_table', 19),
(87, '2024_01_16_075647_create_shippings_table', 20),
(90, '2024_01_16_170736_create_reviews_table', 21),
(91, '2024_01_12_183252_create_messages_table', 22),
(93, '2024_01_24_195011_create_image_galleries_table', 23),
(94, '2024_01_30_102010_create_currencies_table', 24),
(107, '2024_01_30_172321_create_settings_table', 25),
(109, '2024_02_04_123428_create_product_variations_table', 26),
(113, '2024_02_04_131645_create_variation_values_table', 27),
(116, '2024_02_04_123643_create_product_attributes_table', 28),
(117, '2024_02_11_190639_create_cupons_table', 29),
(120, '2023_11_17_160044_create_orders_table', 30),
(121, '2024_03_26_162850_create_order_variations_table', 31);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `addressLine1` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `addressLine2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `district_id` int DEFAULT NULL,
  `division_id` int DEFAULT NULL,
  `country_id` int DEFAULT NULL,
  `zip_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` int DEFAULT NULL,
  `paid_amount` int DEFAULT NULL,
  `discount_amount` int DEFAULT NULL,
  `shipping_method` int DEFAULT NULL,
  `cupon_code` text COLLATE utf8mb4_unicode_ci,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transaction_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order_date` text COLLATE utf8mb4_unicode_ci,
  `order_time` text COLLATE utf8mb4_unicode_ci,
  `created_at` text COLLATE utf8mb4_unicode_ci,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `name`, `email`, `phone`, `addressLine1`, `addressLine2`, `district_id`, `division_id`, `country_id`, `zip_code`, `amount`, `paid_amount`, `discount_amount`, `shipping_method`, `cupon_code`, `status`, `transaction_id`, `currency`, `order_date`, `order_time`, `created_at`, `updated_at`) VALUES
(12, 22, 'Rahin Ahmed', 'ahmedrahin660@gmail.com', '01887497149', 'Rampur, Sayed Bari', 'Feni', 11, 9, 1, '4567', 590, 0, 0, 50, NULL, 'Pending', '660c6d1746b4a', 'BDT', 'Apr-03-24', '2024-04-02 20:39:51', 'Apr-03-24 02:39 am', NULL),
(13, 22, 'Rahin Ahmed', 'ahmedrahin660@gmail.com', '01887497149', 'Rampur, Sayed Bari', 'Feni', 11, 9, 1, '4567', 1850, 1850, 0, 50, NULL, 'Pending', '660c6d601e076', 'BDT', 'Apr-03-24', '2024-04-02 20:41:04', 'Apr-03-24 02:41 am', NULL),
(14, 22, 'Rahin Ahmed', 'ahmedrahin660@gmail.com', '01887497149', 'Rampur, Sayed Bari', 'Feni', 11, 9, 1, '4567', 2590, 0, 0, 50, NULL, 'Pending', '660c6deebda20', 'BDT', 'Apr-03-24', '2024-04-02 20:43:26', 'Apr-03-24 02:43 am', NULL),
(15, 22, 'Rahin Ahmed', 'ahmedrahin660@gmail.com', '01887497149', 'Rampur, Sayed Bari', 'Feni', 33, 12, 1, '2345', 1850, 0, 0, 90, NULL, 'Pending', '66350c56cf7d9', 'BDT', 'May-03-24', '2024-05-03 16:09:58', 'May-03-24 10:09 pm', NULL),
(16, 22, 'Rahin Ahmed', 'ahmedrahin660@gmail.com', '01887497149', 'Rampur, Sayed Bari', 'Feni', 33, 12, 1, '2345', 1100, 1100, 0, 90, NULL, 'Pending', '6638767171524', 'BDT', 'May-06-24', '2024-05-06 06:19:29', 'May-06-24 12:19 pm', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `order_variations`
--

CREATE TABLE `order_variations` (
  `id` bigint UNSIGNED NOT NULL,
  `cart_id` int UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `var_val_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_variations`
--

INSERT INTO `order_variations` (`id`, `cart_id`, `product_id`, `var_val_id`, `created_at`, `updated_at`) VALUES
(38, 481, 204, 20, '2024-04-02 14:39:42', '2024-04-02 14:39:42'),
(39, 483, 69, 8, '2024-04-02 14:40:55', '2024-04-02 14:40:55'),
(40, 484, 204, 8, '2024-04-02 14:42:58', '2024-04-02 14:42:58'),
(41, 484, 204, 11, '2024-04-02 14:42:58', '2024-04-02 14:42:58');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('x@gmai.com', '$2y$10$l2Y/Y69fUedNZxoGS.gaY.o8DcsXsDhxkwqZujNSrMzFdkffPL1Gi', '2023-12-12 02:14:19');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` text COLLATE utf8mb4_unicode_ci,
  `brand_id` int DEFAULT '0',
  `category_id` int DEFAULT '0',
  `subCategory_id` int DEFAULT '0',
  `regular_price` int UNSIGNED NOT NULL DEFAULT '1',
  `offer_price` int UNSIGNED DEFAULT NULL,
  `quantity` int UNSIGNED NOT NULL DEFAULT '0',
  `sku_code` text COLLATE utf8mb4_unicode_ci,
  `short_details` text COLLATE utf8mb4_unicode_ci,
  `long_details` text COLLATE utf8mb4_unicode_ci,
  `video_link` text COLLATE utf8mb4_unicode_ci,
  `is_featured` int NOT NULL DEFAULT '0',
  `status` int UNSIGNED NOT NULL DEFAULT '1' COMMENT '1=Active, 0=Inactive',
  `tags` text COLLATE utf8mb4_unicode_ci,
  `thumb_image` text COLLATE utf8mb4_unicode_ci,
  `back_image` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `title`, `slug`, `brand_id`, `category_id`, `subCategory_id`, `regular_price`, `offer_price`, `quantity`, `sku_code`, `short_details`, `long_details`, `video_link`, `is_featured`, `status`, `tags`, `thumb_image`, `back_image`, `created_at`, `updated_at`) VALUES
(1, 'Elah Panjabi', 'elah-panjabi', 1, 18, 1, 1300, 1100, 7, 'pp11', '<p>Greet your wardrobe with this stylish panjabi! This men&#39;s digital-printed blended cotton item features decorative.</p>', '<p><strong>TWELVE CLOTHING </strong>PUTS A GREAT EFFORT INTO MAKING CLOTHES THAT FIT AND PLEASE EVERY INDIVIDUAL CUSTOMER. WE ONLY MAKE PRODUCTS THAT WE CONSIDER ATTRACTIVE, HIGH QUALITY, CONTEMPORARY, GENUINE AND AFFORDABLE. WE WANT PEOPLE TO LOVE THEIR CLOTHES AND BE CONFIDENT WHILE WEARING THEM.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Greet your wardrobe with this stylish panjabi! This men&#39;s digital-printed blended cotton item features decorative buttons for an</p>\r\n\r\n<p>eye-catching look, ensuring you&#39;ll make an elegant impression wherever you go.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><strong>JS-PANB-TM23-10P-48039<br />\r\nBLENDED<br />\r\nMENS BASIC PANJAB</strong>I</p>', 'https://www.youtube.com/watch?v=wuGCV_zc1G0', 1, 1, 'panjabi', '1706187390-product.jpg', '1706186962-product.jpg', '2023-10-19 23:47:35', '2024-05-06 00:19:29'),
(4, 'Full-hand Shirt', 'full-hand-shirt', 1, 18, 2, 1090, 520, 0, NULL, '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore</p>', NULL, 'https://youtu.be/uaQ-swEU1cs?si=7oRZIQFdPoH6ulDt', 0, 1, NULL, '1706367436-product.jpeg', NULL, '2023-10-25 08:33:59', '2024-02-10 08:03:10'),
(10, 'Rs Shirt', 'rs-shirt', NULL, NULL, NULL, 500, NULL, 2, NULL, NULL, NULL, 'https://youtu.be/t83z46Zr5G4', 0, 1, NULL, NULL, NULL, '2023-10-27 02:29:37', '2024-01-12 08:51:15'),
(22, 'Baby Shoes', 'baby-shoes', NULL, 26, 4, 1500, 1200, 0, 'fsdfd', NULL, NULL, NULL, 0, 1, 'babyshoes, shoes', '1706123459-product.jpeg', NULL, '2024-01-03 01:46:22', '2024-01-24 13:10:59'),
(24, 'Walking Baby Shoes -ff', 'walking-baby-shoes-ff', NULL, 26, 4, 800, NULL, 46, 'ff-88', NULL, NULL, NULL, 0, 1, NULL, NULL, NULL, '2024-01-04 02:45:46', '2024-01-24 02:23:28'),
(27, 'New Shirt - 11', 'new-shirt-11', 0, 18, 2, 600, NULL, 0, 'shirt-11', NULL, NULL, NULL, 0, 1, NULL, NULL, NULL, '2024-01-08 03:05:10', '2024-01-08 03:05:10'),
(28, 'Red-b Hoodie', 'red-b-hoodie', 10, 41, 9, 1400, 1300, 28, 'rh-7', NULL, NULL, NULL, 0, 1, NULL, NULL, NULL, '2024-01-08 03:15:11', '2024-01-12 09:55:39'),
(29, 'kids Blazer', 'kids-blazer', 10, 26, 10, 1390, NULL, 5, NULL, NULL, NULL, NULL, 0, 1, NULL, NULL, NULL, '2024-01-08 03:18:37', '2024-02-25 06:21:21'),
(30, 'Hollister', 'hollister', NULL, 18, 3, 800, NULL, 0, 'hol-ts', NULL, NULL, NULL, 0, 1, NULL, NULL, NULL, '2024-01-08 03:20:09', '2024-03-26 15:38:59'),
(31, 'Boys Hoodie', 'boys-hoodie', NULL, 41, 9, 2000, 1440, 20, 'bh-3', NULL, NULL, NULL, 0, 1, 'hoodie', '1706123232-product.jpg', '1706123521-product.jpeg', '2024-01-08 03:23:20', '2024-02-25 06:19:24'),
(32, 'Hoodie with Kangaroo', 'hoodie-with-kangaroo', NULL, 41, 9, 1680, 1350, 0, NULL, NULL, NULL, NULL, 0, 1, NULL, '1706386748-product.jpeg', NULL, '2024-01-08 03:24:39', '2024-01-27 14:19:08'),
(33, 'Boys Jackets - Temu', 'boys-jackets-temu', 42, 41, 11, 3000, NULL, 15, 'jack', NULL, NULL, NULL, 0, 1, 'jacket, hoodie, winter', NULL, NULL, '2024-01-08 03:27:14', '2024-02-02 03:51:30'),
(34, 'Black Denim Jeans', 'black-denim-jeans', NULL, 41, 11, 2600, 2450, 10, 'blue/black', NULL, NULL, 'https://www.target.com/p/boys-long-sleeve-jacket-cat-jack-medium-wash/-/A-87985588', 0, 1, 'jacket, black', '1706186825-product.jpg', NULL, '2024-01-08 03:30:41', '2024-01-27 03:28:15'),
(35, 'Kids Hoodie', 'kids-hoodie', NULL, 41, 9, 1000, NULL, 80, NULL, NULL, NULL, 'https://youtu.be/9XisbJ6OzAY', 0, 1, NULL, NULL, NULL, '2024-01-08 03:33:32', '2024-02-25 13:16:25'),
(36, 'Top Women Bag', 'top-women-bag', NULL, 39, 12, 2790, NULL, 7, NULL, NULL, NULL, NULL, 0, 1, 'bag', '1706444153-product.jpg', NULL, '2024-01-08 03:36:40', '2024-02-25 06:21:29'),
(37, 'Ladies purse', 'ladies-purse', NULL, NULL, NULL, 1630, NULL, 0, 'purse-12', NULL, NULL, 'https://youtu.be/KEfcMfKzk5U', 0, 1, NULL, NULL, NULL, '2024-01-08 03:37:46', '2024-01-14 06:02:13'),
(38, 'Star Converse', 'star-converse', NULL, 42, 14, 2450, NULL, 17, 'star0', NULL, NULL, 'dsfdgg', 1, 1, 'shoes', NULL, NULL, '2024-01-08 03:46:31', '2024-02-25 13:16:16'),
(39, 'Men Black Converse', 'men-black-converse', 10, NULL, NULL, 3400, 3000, 10, NULL, NULL, NULL, NULL, 0, 1, NULL, '1706291101-product.jpg', '1706291437-product.jpg', '2024-01-08 03:47:53', '2024-01-31 07:54:41'),
(40, 'Best Play Shoes', 'best-play-shoes', NULL, 42, 13, 4000, NULL, 2, NULL, NULL, NULL, 'https://www.youtube.com/watch?v=o7xTMzvT-jY', 0, 1, NULL, '1706347138-product.jpeg', NULL, '2024-01-08 03:49:06', '2024-02-26 08:52:24'),
(54, 'Athletic Shoes for Winter', 'athletic-shoes-for-winter', NULL, 42, 13, 1800, 1600, 29, NULL, NULL, NULL, NULL, 0, 1, 'shoes', '1706124839-product.jpeg', NULL, '2024-01-17 08:45:02', '2024-02-17 01:59:43'),
(55, 'Jersey t-shirt', 'jersey-t-shirt', 1, NULL, NULL, 350, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, '2024-01-17 08:59:25', '2024-02-26 09:34:38'),
(61, 'Women Bround Borka', 'women-bround-borka', NULL, 39, 15, 2000, NULL, 47, NULL, NULL, NULL, NULL, 0, 1, NULL, '1706119809-product.jpg', NULL, '2024-01-24 08:25:39', '2024-04-02 14:43:26'),
(69, 'Black Borka', 'black-borka', NULL, 39, 15, 2000, 1500, 33, NULL, NULL, NULL, NULL, 1, 1, 'borka, women', '1706120095-product.jpeg', NULL, '2024-01-24 12:14:55', '2024-04-02 14:41:04'),
(70, 'IELGY men\'s Shoes', 'ielgy-mens-shoes', NULL, NULL, NULL, 2300, 2000, 5, NULL, NULL, NULL, NULL, 0, 1, 'shoes, IELGY', '1706123021-product.jpg', '1706123137-product.jpeg', '2024-01-24 12:21:06', '2024-02-17 02:33:31'),
(103, 'Vasimple Shirt', 'vasimple-shirt', NULL, NULL, NULL, 1800, NULL, 9, NULL, NULL, NULL, NULL, 1, 1, 'shirt', '1706214109-product.jpg', NULL, '2024-01-25 14:21:49', '2024-02-26 09:34:17'),
(105, 'Follow T-shirt', 'follow-t-shirt', NULL, 18, 3, 500, 450, 69, NULL, NULL, NULL, NULL, 0, 1, 't-shirt', '1706259067-product.jpg', NULL, '2024-01-26 02:48:55', '2024-04-02 14:16:50'),
(112, 'Elah t-shirt', 'elah-t-shirt', 1, 18, 3, 350, NULL, 97, NULL, NULL, NULL, NULL, 0, 1, NULL, '1706261270-product.jpg', '1706261270-product.png', '2024-01-26 03:27:51', '2024-05-03 10:09:58'),
(201, 'LUXURY PANJABI', 'luxury-panjabi', NULL, 18, 1, 1500, NULL, 6, NULL, NULL, NULL, NULL, 1, 1, NULL, '1707333191-product.jpg', NULL, '2024-02-07 13:13:12', '2024-05-03 10:09:58'),
(204, 'Ajjo Black Tshirts', 'ajjo-black-tshirts', NULL, 18, 3, 600, 590, 0, NULL, NULL, '<p>The<strong> Model is wearing</strong> a white blouse from our stylist&#39;s collection, see the image for a mock-up of what the actual blouse would look like.it has text written on it in a black cursive language which looks great on a white color.</p>', NULL, 0, 1, NULL, '1707333757-product.jpg', NULL, '2024-02-07 13:22:38', '2024-04-02 14:43:26'),
(233, 'xxx', 'xxx', NULL, NULL, NULL, 150, NULL, 1, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2024-03-27 04:44:14', '2024-03-30 14:16:24');

-- --------------------------------------------------------

--
-- Table structure for table `product_attributes`
--

CREATE TABLE `product_attributes` (
  `id` bigint UNSIGNED NOT NULL,
  `value_id` bigint UNSIGNED DEFAULT NULL,
  `variation_id` bigint UNSIGNED DEFAULT NULL,
  `products_id` bigint UNSIGNED DEFAULT NULL,
  `regular_price` int UNSIGNED DEFAULT NULL,
  `offer_price` int UNSIGNED DEFAULT NULL,
  `quantity` int UNSIGNED NOT NULL DEFAULT '0',
  `sku_code` text COLLATE utf8mb4_unicode_ci,
  `thumb_image` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_attributes`
--

INSERT INTO `product_attributes` (`id`, `value_id`, `variation_id`, `products_id`, `regular_price`, `offer_price`, `quantity`, `sku_code`, `thumb_image`, `created_at`, `updated_at`) VALUES
(112, 8, 2, 22, NULL, NULL, 0, NULL, NULL, '2024-02-08 11:22:06', '2024-02-08 11:22:06'),
(235, 8, 2, 204, NULL, NULL, 0, NULL, NULL, '2024-03-27 10:24:09', '2024-03-27 10:24:09'),
(236, 20, 2, 204, 650, NULL, 0, NULL, NULL, '2024-03-27 10:24:09', '2024-03-27 10:24:09'),
(237, 9, 6, 204, NULL, NULL, 5, NULL, NULL, '2024-03-27 10:24:09', '2024-03-27 10:24:09'),
(238, 11, 6, 204, 550, NULL, 0, NULL, NULL, '2024-03-27 10:24:09', '2024-03-27 10:24:09'),
(264, 20, 2, 233, 80, NULL, 0, NULL, NULL, '2024-03-30 14:16:13', '2024-03-30 14:16:13'),
(265, 11, 6, 233, 120, NULL, 0, NULL, NULL, '2024-03-30 14:16:13', '2024-03-30 14:16:13'),
(266, 9, 6, 69, NULL, NULL, 10, NULL, NULL, '2024-03-30 14:17:11', '2024-03-30 14:17:11'),
(267, 8, 2, 69, NULL, NULL, 0, NULL, NULL, '2024-03-30 14:17:11', '2024-03-30 14:17:11');

-- --------------------------------------------------------

--
-- Table structure for table `product_variations`
--

CREATE TABLE `product_variations` (
  `id` bigint UNSIGNED NOT NULL,
  `var_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_variations`
--

INSERT INTO `product_variations` (`id`, `var_name`, `created_at`, `updated_at`) VALUES
(2, 'Color', '2024-02-05 01:54:06', '2024-03-26 08:46:58'),
(6, 'Size', '2024-02-05 03:38:06', '2024-02-05 03:38:06');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `review` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `rating` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `user_id`, `product_id`, `review`, `rating`, `created_at`, `updated_at`) VALUES
(53, 22, 204, 'rahin', '4', '2024-04-22 10:49:11', '2024-04-22 10:49:11'),
(62, 38, 70, 'orem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusm', '5', '2024-04-22 11:42:54', '2024-04-22 11:42:54'),
(76, 22, 70, 'ff', '4.5', '2024-04-22 12:01:04', '2024-04-22 12:01:04'),
(80, 42, 70, 'We can ensure that the form submission event is properly handled by directly binding it', '2.5', '2024-04-22 12:03:11', '2024-04-22 12:03:11'),
(81, 22, 54, 'Favorite One💕', '5', '2024-04-22 12:04:12', '2024-04-22 12:04:12'),
(83, 22, 32, 'dolor sit N', '1.5', '2024-04-22 12:05:11', '2024-04-22 12:05:11'),
(85, 22, 112, 'KIre', '3', '2024-04-22 22:25:52', '2024-04-22 22:25:52');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint UNSIGNED NOT NULL,
  `fav_icon` text COLLATE utf8mb4_unicode_ci,
  `logo` text COLLATE utf8mb4_unicode_ci,
  `site_title` text COLLATE utf8mb4_unicode_ci,
  `number1` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `number2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `fav_icon`, `logo`, `site_title`, `number1`, `number2`, `email`, `created_at`, `updated_at`) VALUES
(1, '1708197014-fav.png', '1708259474-fav.png', 'Multikart', '01887497149', NULL, 'multikart@gmail.com', NULL, '2024-02-25 09:42:05');

-- --------------------------------------------------------

--
-- Table structure for table `shippings`
--

CREATE TABLE `shippings` (
  `id` bigint UNSIGNED NOT NULL,
  `base_id` int DEFAULT NULL,
  `base_charge` int DEFAULT NULL,
  `provider_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider_charge` int UNSIGNED DEFAULT NULL,
  `status` int NOT NULL DEFAULT '1' COMMENT '1-active, 2=inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `shippings`
--

INSERT INTO `shippings` (`id`, `base_id`, `base_charge`, `provider_name`, `provider_charge`, `status`, `created_at`, `updated_at`) VALUES
(22, 12, 90, NULL, NULL, 1, '2024-01-19 04:02:25', '2024-04-30 04:02:37'),
(23, 11, 60, NULL, NULL, 1, '2024-01-19 04:07:24', '2024-04-30 04:08:58'),
(26, NULL, NULL, 'Shundorbon', 100, 1, '2024-01-19 04:09:01', '2024-05-03 10:16:22'),
(28, NULL, NULL, 'Pathao', 120, 1, '2024-01-19 07:40:01', '2024-04-30 04:11:22'),
(34, 9, 50, NULL, NULL, 2, '2024-04-30 03:23:00', '2024-05-03 10:16:06');

-- --------------------------------------------------------

--
-- Table structure for table `states`
--

CREATE TABLE `states` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `priority_number` int DEFAULT '1',
  `country_id` int NOT NULL,
  `status` int UNSIGNED NOT NULL DEFAULT '1' COMMENT '1=Active, 0=Inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `states`
--

INSERT INTO `states` (`id`, `name`, `priority_number`, `country_id`, `status`, `created_at`, `updated_at`) VALUES
(3, 'Khulna', 3, 1, 1, '2023-09-25 10:23:41', '2023-09-25 13:12:35'),
(6, 'Rajshahi', 4, 1, 1, '2023-09-25 10:25:17', '2023-09-25 10:25:17'),
(7, 'Barishal', 5, 1, 1, '2023-09-25 10:25:36', '2023-09-25 10:58:55'),
(9, 'Comilla', 7, 1, 1, '2023-09-25 10:27:39', '2023-12-08 09:39:19'),
(10, 'Rangpur', 8, 1, 1, '2023-09-25 10:28:01', '2023-09-25 10:28:01'),
(11, 'Dhaka', 1, 1, 1, '2023-09-25 11:57:37', '2023-09-26 11:30:02'),
(12, 'Chottrogram', 2, 1, 1, '2023-09-25 13:08:48', '2023-09-26 10:40:54'),
(17, 'Lahor', 1, 10, 1, '2023-10-14 21:19:46', '2023-12-08 09:17:05'),
(18, 'Kashmir', NULL, 10, 1, '2023-12-08 08:37:57', '2023-12-08 08:40:52'),
(19, 'Srlm', NULL, 4, 1, '2023-12-08 08:41:18', '2024-01-21 12:29:59'),
(20, 'Kampala', 1, 4, 1, '2023-12-08 08:42:07', '2024-01-21 12:29:59');

-- --------------------------------------------------------

--
-- Table structure for table `subcategories`
--

CREATE TABLE `subcategories` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `category_id` bigint UNSIGNED DEFAULT NULL,
  `status` int UNSIGNED NOT NULL DEFAULT '1' COMMENT '1=Active, 0=Inactive',
  `image` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subcategories`
--

INSERT INTO `subcategories` (`id`, `name`, `slug`, `description`, `category_id`, `status`, `image`, `created_at`, `updated_at`) VALUES
(1, 'panjabi', 'panjabi', NULL, 18, 1, '1703864626-subcategory.png', '2023-12-29 09:43:46', '2023-12-29 09:43:46'),
(2, 'Shirt', 'shirt', NULL, 18, 1, '1703864650-subcategory.jpg', '2023-12-29 09:44:10', '2023-12-29 09:44:10'),
(3, 'T-shirt', 't-shirt', NULL, 18, 1, NULL, '2023-12-29 09:44:45', '2023-12-29 09:44:45'),
(4, 'kids Shoes', 'kids-shoes', NULL, 26, 1, NULL, '2023-12-29 09:45:01', '2023-12-29 09:45:01'),
(7, 'Shari', 'shari', NULL, 39, 1, NULL, '2023-12-29 09:49:36', '2023-12-29 09:49:36'),
(9, 'Hoodie', 'hoodie', NULL, 41, 1, '1706727462-subcategories.jpg', '2024-01-08 03:12:37', '2024-01-31 12:57:43'),
(10, 'Kids Dress', 'kids-dress', NULL, 26, 1, '1704705250-subcategory.jpeg', '2024-01-08 03:14:10', '2024-01-08 03:14:10'),
(11, 'Jacket', 'jacket', NULL, 41, 1, NULL, '2024-01-08 03:15:33', '2024-01-08 03:15:33'),
(12, 'Bag', 'bag', NULL, 39, 1, '1704706541-subcategories.jpeg', '2024-01-08 03:34:40', '2024-01-08 03:35:41'),
(13, 'Athletic shoes', 'athletic-shoes', NULL, 42, 1, NULL, '2024-01-08 03:44:00', '2024-01-31 12:57:58'),
(14, 'Converse', 'converse', NULL, 42, 1, NULL, '2024-01-08 03:44:33', '2024-01-08 03:44:33'),
(15, 'Borka', 'borka', NULL, 39, 1, '1706104643-subcategory.jpg', '2024-01-24 07:57:23', '2024-01-24 07:57:23');

-- --------------------------------------------------------

--
-- Table structure for table `tests`
--

CREATE TABLE `tests` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address_line1` text COLLATE utf8mb4_unicode_ci,
  `address_line2` text COLLATE utf8mb4_unicode_ci,
  `division_id` int DEFAULT NULL,
  `district_id` int DEFAULT NULL,
  `country_id` int DEFAULT NULL,
  `zipCode` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int UNSIGNED NOT NULL DEFAULT '1' COMMENT '1=Active, 0=Inactive',
  `role` int UNSIGNED NOT NULL DEFAULT '2' COMMENT '1=Admin',
  `image` text COLLATE utf8mb4_unicode_ci,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `phone`, `address_line1`, `address_line2`, `division_id`, `district_id`, `country_id`, `zipCode`, `status`, `role`, `image`, `remember_token`, `created_at`, `updated_at`) VALUES
(21, 'Md Tawfiq', 'tawfikullah12@gmail.com', NULL, '$2y$10$6jjGBaZmqy1Mv/1bmDQeJ.HI8F.B4aEhymZeduoAtlGYEokq6KopC', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2, NULL, NULL, '2023-12-25 07:33:30', '2024-01-03 11:43:16'),
(22, 'Rahin Ahmed', 'ahmedrahin660@gmail.com', '2023-12-27 07:18:45', '$2y$10$tNSAYxvyfNK7/w.qFRu/iuaFXBKsu4b73qIPtaZ/mmvyb2u9wwnIi', '01887497149', 'Rampur, Sayed Bari', 'Feni', 12, 33, 1, '2345', 1, 1, NULL, 'nAqa3g1bE8lizqMfb3pESiIxv31pIQJQGAkqa5UB6NfqetU0kKGIgYnq8zHp', '2023-12-27 07:15:20', '2024-05-05 11:55:39'),
(23, 'Saiful', 'saiful@gmail.com', '2023-12-27 07:18:45', '$2y$10$eJTjr8kFgZ1RBRLcrpVfcuyWYL0PvSsfPR2md.1BmZyD8BPjwTIo.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 2, '1705135325-user.png', NULL, '2023-12-27 10:53:18', '2024-01-13 02:42:06'),
(32, 'Mehjabin Hoissan', 'mehjabin@gmail.com', '2024-01-12 02:33:23', '$2y$10$YLh9T.UDgmN1Pej6.x14nueQGqeh0NbRMri6vlfes4IE.NAuVs/fO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2, '1705134594-user.png', NULL, '2024-01-13 02:28:22', '2024-01-15 04:12:10'),
(37, 'Sayed Ibnul', 'ibnul@gmail.com', NULL, '$2y$10$SKq0MpXMTOTsVE4MMd1sn.av/sUZXSRYqXOXs7hPggYzCAbqknNvO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2, NULL, NULL, '2024-01-24 05:00:09', '2024-01-24 05:00:09'),
(38, 'Abdullah Rahin', 'abdullahrahin25@gmail.com', '2024-01-24 05:08:06', '$2y$10$YjnErqejXeqsILivNuFXluLxwLJ2fRcfGrdWFVfKyqnwRGLcPVAI2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2, '1706100749-user.jpg', NULL, '2024-01-24 05:03:51', '2024-04-02 14:14:40'),
(39, 'Labonne', 'mehjabinhossain443@gmail.com', NULL, '$2y$10$yvGaYRT.uLM5P.rzXlwnXeS/SbhyOn9kQ8zPrr1xPJo2M.qDzFGk.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2, NULL, NULL, '2024-02-15 12:46:46', '2024-02-15 12:46:46'),
(42, 'Sayed Ibnul', 'saibnul@gmail.com', NULL, '$2y$10$1M6taof9kyXVdDBOekhgZ.MSJ44StCTLMwDJOVhXvbcJ9Srmd7Iq6', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2, NULL, NULL, '2024-04-22 11:50:06', '2024-04-22 11:50:06');

-- --------------------------------------------------------

--
-- Table structure for table `variation_values`
--

CREATE TABLE `variation_values` (
  `id` bigint UNSIGNED NOT NULL,
  `var_id` bigint UNSIGNED NOT NULL,
  `option` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `option_value` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `variation_values`
--

INSERT INTO `variation_values` (`id`, `var_id`, `option`, `option_value`, `created_at`, `updated_at`) VALUES
(7, 2, 'Green', NULL, '2024-02-05 07:56:23', '2024-02-07 13:55:23'),
(8, 2, 'Red', '#de1907', '2024-02-05 07:58:55', '2024-03-26 04:37:57'),
(9, 6, 'M', NULL, '2024-02-05 08:20:54', '2024-02-05 08:20:54'),
(11, 6, 'L', NULL, '2024-02-05 08:21:07', '2024-02-05 08:21:28'),
(16, 6, 'Xl', NULL, '2024-02-05 08:49:09', '2024-02-05 08:49:09'),
(19, 2, 'White', '#fff', '2024-02-08 12:39:06', '2024-02-08 12:39:06'),
(20, 2, 'Black', '#000000d6', '2024-02-08 12:39:16', '2024-02-09 07:24:02');

-- --------------------------------------------------------

--
-- Table structure for table `wishlists`
--

CREATE TABLE `wishlists` (
  `id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `brands_name_unique` (`name`);

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `carts_user_id_foreign` (`user_id`),
  ADD KEY `carts_product_id_foreign` (`product_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_name_unique` (`name`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `countries_name_unique` (`name`);

--
-- Indexes for table `cupons`
--
ALTER TABLE `cupons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `currencies`
--
ALTER TABLE `currencies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `districts`
--
ALTER TABLE `districts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `districts_name_unique` (`name`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `image_galleries`
--
ALTER TABLE `image_galleries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `image_galleries_product_id_foreign` (`product_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_user_id_foreign` (`user_id`);

--
-- Indexes for table `order_variations`
--
ALTER TABLE `order_variations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_variations_cart_id_foreign` (`cart_id`),
  ADD KEY `order_variations_product_id_foreign` (`product_id`),
  ADD KEY `order_variations_var_val_id_foreign` (`var_val_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_title_unique` (`title`);

--
-- Indexes for table `product_attributes`
--
ALTER TABLE `product_attributes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_attributes_variation_id_foreign` (`variation_id`),
  ADD KEY `product_attributes_value_id_foreign` (`value_id`),
  ADD KEY `product_attributes_products_id_foreign` (`products_id`);

--
-- Indexes for table `product_variations`
--
ALTER TABLE `product_variations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reviews_product_id_foreign` (`product_id`),
  ADD KEY `reviews_user_id_foreign` (`user_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shippings`
--
ALTER TABLE `shippings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `states`
--
ALTER TABLE `states`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `states_name_unique` (`name`);

--
-- Indexes for table `subcategories`
--
ALTER TABLE `subcategories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `subcategories_name_unique` (`name`),
  ADD KEY `subcategories_category_id_foreign` (`category_id`);

--
-- Indexes for table `tests`
--
ALTER TABLE `tests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `variation_values`
--
ALTER TABLE `variation_values`
  ADD PRIMARY KEY (`id`),
  ADD KEY `variation_values_var_id_foreign` (`var_id`);

--
-- Indexes for table `wishlists`
--
ALTER TABLE `wishlists`
  ADD PRIMARY KEY (`id`),
  ADD KEY `wishlists_user_id_foreign` (`user_id`),
  ADD KEY `wishlists_product_id_foreign` (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=698;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `cupons`
--
ALTER TABLE `cupons`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `currencies`
--
ALTER TABLE `currencies`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `districts`
--
ALTER TABLE `districts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `image_galleries`
--
ALTER TABLE `image_galleries`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=163;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=122;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `order_variations`
--
ALTER TABLE `order_variations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=234;

--
-- AUTO_INCREMENT for table `product_attributes`
--
ALTER TABLE `product_attributes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=268;

--
-- AUTO_INCREMENT for table `product_variations`
--
ALTER TABLE `product_variations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `shippings`
--
ALTER TABLE `shippings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `states`
--
ALTER TABLE `states`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `subcategories`
--
ALTER TABLE `subcategories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tests`
--
ALTER TABLE `tests`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `variation_values`
--
ALTER TABLE `variation_values`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `wishlists`
--
ALTER TABLE `wishlists`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=321;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `carts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `image_galleries`
--
ALTER TABLE `image_galleries`
  ADD CONSTRAINT `image_galleries_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_variations`
--
ALTER TABLE `order_variations`
  ADD CONSTRAINT `order_variations_cart_id_foreign` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_variations_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_variations_var_val_id_foreign` FOREIGN KEY (`var_val_id`) REFERENCES `variation_values` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_attributes`
--
ALTER TABLE `product_attributes`
  ADD CONSTRAINT `product_attributes_products_id_foreign` FOREIGN KEY (`products_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_attributes_value_id_foreign` FOREIGN KEY (`value_id`) REFERENCES `variation_values` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_attributes_variation_id_foreign` FOREIGN KEY (`variation_id`) REFERENCES `product_variations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `subcategories`
--
ALTER TABLE `subcategories`
  ADD CONSTRAINT `subcategories_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `variation_values`
--
ALTER TABLE `variation_values`
  ADD CONSTRAINT `variation_values_var_id_foreign` FOREIGN KEY (`var_id`) REFERENCES `product_variations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `wishlists`
--
ALTER TABLE `wishlists`
  ADD CONSTRAINT `wishlists_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `wishlists_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
