-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 26, 2023 at 07:42 AM
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
(1, 'ELAH Fashion', 'elah-fashion', '<p><strong>ELAH Fashion</strong> is most famous clothing brand in feni, Bangladesh.</p>', 1, NULL, '2023-10-03 05:03:47', '2023-11-13 09:56:14'),
(9, 'Jental Park', 'jental-park', NULL, 1, '1699195921-brand.png', '2023-11-04 10:47:02', '2023-11-05 08:52:02'),
(10, 'Easy', 'easy', 'Easy Special T-SHIRT COLLECTION SHOP NOW SCROLL NEW COLLECTION EASY JUNIOR SHOP NOW SCROLL PANJABI COLLECTION SHOP NOW SCROLL 010203 Follow', 1, '1699196106-brand.jpg', '2023-11-04 11:25:18', '2023-11-05 08:55:06'),
(16, 'Roscoe Rutherford', NULL, NULL, 1, NULL, '2023-11-22 06:24:36', '2023-11-22 06:24:36'),
(17, 'Olin Funk', NULL, NULL, 1, NULL, '2023-11-22 06:24:36', '2023-11-22 06:24:36'),
(18, 'Arden Casper', NULL, NULL, 1, NULL, '2023-11-22 06:24:36', '2023-11-22 06:24:36'),
(19, 'Calista Wunsch', NULL, NULL, 1, NULL, '2023-11-22 06:24:36', '2023-11-22 06:24:36'),
(20, 'Dr. Jaleel Homenick Jr.', NULL, NULL, 1, NULL, '2023-11-22 06:24:36', '2023-11-22 06:24:36'),
(21, 'Lolita Lynch', NULL, NULL, 1, NULL, '2023-11-22 06:24:36', '2023-11-22 06:24:36'),
(22, 'Winifred Hackett', NULL, NULL, 1, NULL, '2023-11-22 06:24:36', '2023-11-22 06:24:36'),
(23, 'Dr. Wade Lebsack', NULL, NULL, 1, NULL, '2023-11-22 06:24:36', '2023-11-22 06:24:36'),
(24, 'Dr. Evans Lehner Sr.', NULL, NULL, 1, NULL, '2023-11-22 06:24:36', '2023-11-22 06:24:36'),
(25, 'Janessa Shanahan Sr.', NULL, NULL, 1, NULL, '2023-11-22 06:24:36', '2023-11-22 06:24:36'),
(26, 'Eduardo Walsh', NULL, NULL, 1, NULL, '2023-11-22 06:24:36', '2023-11-22 06:24:36'),
(27, 'Caden Hegmann', NULL, NULL, 1, NULL, '2023-11-22 06:24:36', '2023-11-22 06:24:36'),
(28, 'x', 'x', NULL, 1, NULL, '2023-11-24 12:51:12', '2023-11-24 12:51:12');

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` int UNSIGNED NOT NULL,
  `product_id` int UNSIGNED NOT NULL,
  `product_quantity` int UNSIGNED NOT NULL DEFAULT '0',
  `prdtc_unt_pri` int UNSIGNED DEFAULT '0',
  `order_id` int UNSIGNED DEFAULT NULL,
  `user_id` int UNSIGNED DEFAULT NULL,
  `ip_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`id`, `product_id`, `product_quantity`, `prdtc_unt_pri`, `order_id`, `user_id`, `ip_address`, `created_at`, `updated_at`) VALUES
(39, 4, 1, 0, NULL, NULL, '127.0.0.1', '2023-11-24 05:38:50', '2023-11-24 05:38:50');

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
(18, 'Clothing', 'clothing', '<p><em>Clothing</em>&nbsp;is any item worn on the body. Typically,&nbsp;<em>clothing</em>&nbsp;is made of fabrics or textiles, but over time it has included garments made from animal skin and</p>', 1, NULL, '2023-10-17 11:56:07', '2023-11-11 04:11:05'),
(21, 'Electronic', 'electronic', NULL, 1, NULL, '2023-10-19 23:41:59', '2023-10-19 23:41:59'),
(26, 'kids Item', 'kids-item', NULL, 1, NULL, '2023-10-26 23:44:19', '2023-11-08 03:17:51');

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
(1, 'Bangladesh', 'bangladesh', 1, '2023-09-23 12:39:52', '2023-10-13 02:10:53'),
(4, 'Uganda', 'uganda', 1, '2023-09-23 12:43:10', '2023-10-13 02:09:04'),
(10, 'Pakistan', 'pakistan', 1, '2023-10-03 05:22:00', '2023-10-12 11:42:26');

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
(1, 'Dhaka', 11, 1, '2023-09-25 12:44:17', '2023-09-25 12:44:17'),
(2, 'Gazipur', 11, 1, '2023-09-25 12:44:39', '2023-09-25 12:57:18'),
(5, 'Narayangonj', 11, 1, '2023-09-25 13:17:03', '2023-09-25 13:17:03'),
(6, 'Mirpur', 11, 1, '2023-09-25 13:17:30', '2023-10-13 09:04:10'),
(8, 'Bogura', 6, 1, '2023-09-25 13:20:49', '2023-09-25 13:20:49'),
(9, 'Natore', 6, 1, '2023-09-25 13:21:13', '2023-09-25 13:21:13'),
(10, 'Pabna', 6, 1, '2023-09-25 13:21:31', '2023-10-13 09:10:25'),
(11, 'Chandina', 9, 1, '2023-09-25 13:23:19', '2023-09-25 13:23:19'),
(12, 'Chauddagram', 9, 1, '2023-09-25 13:24:07', '2023-09-25 13:24:07');

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
(24, '2023_10_14_151634_create_subcategories_table', 7),
(25, '2023_10_03_104145_create_products_table', 8),
(26, '2023_11_10_192121_create_carts_table', 9),
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
(45, '2023_10_14_151634_create_subcategories_table', 1),
(46, '2023_11_10_192121_create_carts_table', 1),
(47, '2023_11_17_160044_create_orders_table', 1),
(48, '2023_11_22_073943_create_tests_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` int DEFAULT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `addressLine1` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `addressLine2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `district_id` int DEFAULT NULL,
  `division_id` int DEFAULT NULL,
  `country_id` int DEFAULT NULL,
  `zip_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` int DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transaction_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `first_name`, `last_name`, `email`, `phone`, `addressLine1`, `addressLine2`, `district_id`, `division_id`, `country_id`, `zip_code`, `amount`, `status`, `transaction_id`, `currency`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 920, 'Pending', '655f617c056bc', 'BDT', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `title`, `slug`, `brand_id`, `category_id`, `subCategory_id`, `regular_price`, `offer_price`, `quantity`, `sku_code`, `short_details`, `long_details`, `video_link`, `is_featured`, `status`, `tags`, `created_at`, `updated_at`) VALUES
(1, 'Elah Panjabi', 'elah-panjabi', 1, 18, 31, 1200, 1000, 10, 'pp11', '<p>Greet your wardrobe with this stylish panjabi! This men&#39;s digital-printed blended cotton item features decorative.</p>', '<p><strong>TWELVE CLOTHING </strong>PUTS A GREAT EFFORT INTO MAKING CLOTHES THAT FIT AND PLEASE EVERY INDIVIDUAL CUSTOMER. WE ONLY MAKE PRODUCTS THAT WE CONSIDER ATTRACTIVE, HIGH QUALITY, CONTEMPORARY, GENUINE AND AFFORDABLE. WE WANT PEOPLE TO LOVE THEIR CLOTHES AND BE CONFIDENT WHILE WEARING THEM.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Greet your wardrobe with this stylish panjabi! This men&#39;s digital-printed blended cotton item features decorative buttons for an</p>\r\n\r\n<p>eye-catching look, ensuring you&#39;ll make an elegant impression wherever you go.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><strong>JS-PANB-TM23-10P-48039<br />\r\nBLENDED<br />\r\nMENS BASIC PANJAB</strong>I</p>', 'https://www.youtube.com/watch?v=wuGCV_zc1G0', 2, 1, NULL, '2023-10-19 23:47:35', '2023-11-13 12:37:46'),
(2, 'Converse', 'converse', NULL, NULL, NULL, 1500, 1400, 0, 's-12', NULL, NULL, 'https://youtu.be/0-dJgK2ZdQI?list=PLukI021tlKTPg5Bcb92sC1vYmM-9rieXW', 0, 0, NULL, '2023-10-20 01:51:42', '2023-11-07 11:51:01'),
(4, 'Full-hand Shirt', 'full-hand-shirt', 1, 18, 16, 1090, 520, 0, NULL, NULL, NULL, 'https://youtu.be/uaQ-swEU1cs?si=7oRZIQFdPoH6ulDt', 0, 1, NULL, '2023-10-25 08:33:59', '2023-11-24 05:40:28'),
(9, 'Baby Shirt', 'baby-shirt', NULL, 26, NULL, 930, NULL, 1, NULL, NULL, NULL, NULL, 0, 2, NULL, '2023-10-26 11:08:01', '2023-11-12 04:04:42'),
(10, 'Rs Shirt', 'rs-shirt', NULL, NULL, NULL, 500, NULL, 11, NULL, NULL, NULL, 'https://youtu.be/t83z46Zr5G4', 0, 1, NULL, '2023-10-27 02:29:37', '2023-11-10 10:44:24'),
(16, 'x', 'x', 0, 21, NULL, 100, 99, 9, NULL, NULL, NULL, NULL, 0, 1, NULL, '2023-11-14 08:51:52', '2023-11-14 12:16:45');

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
(8, 'Sylhet', 6, 1, 0, '2023-09-25 10:26:36', '2023-10-03 05:22:41'),
(9, 'Comilla', 7, 1, 1, '2023-09-25 10:27:39', '2023-09-25 13:23:41'),
(10, 'Rangpur', 8, 1, 1, '2023-09-25 10:28:01', '2023-09-25 10:28:01'),
(11, 'Dhaka', 1, 1, 1, '2023-09-25 11:57:37', '2023-09-26 11:30:02'),
(12, 'Chottrogram', 2, 1, 1, '2023-09-25 13:08:48', '2023-09-26 10:40:54'),
(17, 'Lahor', 1, 10, 1, '2023-10-14 21:19:46', '2023-10-14 21:19:46');

-- --------------------------------------------------------

--
-- Table structure for table `subcategories`
--

CREATE TABLE `subcategories` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `category_id` int DEFAULT NULL,
  `status` int UNSIGNED NOT NULL DEFAULT '1' COMMENT '1=Active, 0=Inactive',
  `image` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subcategories`
--

INSERT INTO `subcategories` (`id`, `name`, `slug`, `description`, `category_id`, `status`, `image`, `created_at`, `updated_at`) VALUES
(15, 'T-shirt', 't-shirt', NULL, 18, 1, NULL, '2023-10-17 21:41:22', '2023-10-17 21:41:22'),
(16, 'Shirt', 'shirt', NULL, 18, 1, NULL, '2023-10-19 22:15:21', '2023-10-19 22:15:21'),
(31, 'panjabi', 'panjabi', NULL, 18, 1, NULL, '2023-10-27 02:27:04', '2023-10-27 02:27:04'),
(38, 'Kids Dress', 'kids-dress', NULL, 26, 1, NULL, '2023-11-09 03:27:01', '2023-11-09 11:49:39');

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
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

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
  ADD UNIQUE KEY `subcategories_name_unique` (`name`);

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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `districts`
--
ALTER TABLE `districts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `states`
--
ALTER TABLE `states`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `subcategories`
--
ALTER TABLE `subcategories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `tests`
--
ALTER TABLE `tests`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
