-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 16, 2025 at 07:09 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sql_game_test_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `booking_id` int(11) NOT NULL,
  `tourist_id` int(11) DEFAULT NULL,
  `hotel_id` int(11) DEFAULT NULL,
  `check_in` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`booking_id`, `tourist_id`, `hotel_id`, `check_in`) VALUES
(1, 1, 1, '2025-07-10'),
(2, 2, 3, '2025-07-11'),
(3, 3, 5, '2025-07-12'),
(4, 4, 7, '2025-07-13'),
(5, 5, 9, '2025-07-14');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hotels`
--

CREATE TABLE `hotels` (
  `hotel_id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `province_id` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `amenities` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hotels`
--

INSERT INTO `hotels` (`hotel_id`, `name`, `city`, `province_id`, `price`, `amenities`) VALUES
(1, 'Colombo Grand Hotel', 'Colombo', 1, 8000.00, 'WiFi, Pool, Gym'),
(2, 'Ocean View Resort', 'Colombo', 1, 5500.00, 'WiFi, Restaurant'),
(3, 'Kandy Hilltop', 'Kandy', 2, 4500.00, 'WiFi, Breakfast'),
(4, 'Temple View Lodge', 'Kandy', 2, 6000.00, 'WiFi, Parking'),
(5, 'Galle Fort Heritage', 'Galle', 3, 7000.00, 'WiFi, AC'),
(6, 'Surf House', 'Unawatuna', 3, 2500.00, 'WiFi'),
(7, 'Jaffna Palace', 'Jaffna', 4, 5000.00, 'WiFi, Breakfast'),
(8, 'Nallur Guest House', 'Jaffna', 4, 3000.00, 'WiFi'),
(9, 'Pasikuda Beach Resort', 'Pasikuda', 5, 6500.00, 'WiFi, Pool'),
(10, 'Batticaloa Lagoon Inn', 'Batticaloa', 5, 4000.00, 'WiFi, Restaurant');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `levels`
--

CREATE TABLE `levels` (
  `id` int(11) NOT NULL,
  `province` varchar(50) DEFAULT NULL,
  `story` text DEFAULT NULL,
  `dialogue` text DEFAULT NULL,
  `reward` varchar(100) DEFAULT NULL,
  `unlocked_next` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `levels`
--

INSERT INTO `levels` (`id`, `province`, `story`, `dialogue`, `reward`, `unlocked_next`) VALUES
(1, 'Western', 'Story for Western', 'Dialogue', 'Reward1', 'Central'),
(2, 'Central', 'Story for Central', 'Dialogue', 'Reward2', 'Southern'),
(3, 'Southern', 'Story for Southern', 'Dialogue', 'Reward3', 'Northern'),
(4, 'Northern', 'Story for Northern', 'Dialogue', 'Reward4', 'Eastern'),
(5, 'Eastern', 'Story for Eastern', 'Dialogue', 'Reward5', 'North Central'),
(6, 'North Central', 'Story for North Central', 'Dialogue', 'Reward6', 'Uva'),
(7, 'Uva', 'Story for Uva', 'Dialogue', 'Reward7', 'Sabaragamuwa'),
(8, 'Sabaragamuwa', 'Story for Sabaragamuwa', 'Dialogue', 'Reward8', 'North Western'),
(9, 'North Western', 'Story for North Western', 'Dialogue', 'Reward9', 'END');

-- --------------------------------------------------------

--
-- Table structure for table `level_tasks`
--

CREATE TABLE `level_tasks` (
  `id` int(11) NOT NULL,
  `level_id` int(11) DEFAULT NULL,
  `task` text DEFAULT NULL,
  `expected_query` text DEFAULT NULL,
  `clue` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `level_tasks`
--

INSERT INTO `level_tasks` (`id`, `level_id`, `task`, `expected_query`, `clue`) VALUES
(1, 1, 'Show all hotels.', 'SELECT * FROM Hotels', 'Use SELECT * to see all rows.'),
(2, 1, 'See tourist names and their country.', 'SELECT name, country FROM Tourists', 'Pick specific columns.'),
(3, 1, 'List all nationalities of tourists.', 'SELECT DISTINCT country FROM Tourists', 'DISTINCT removes duplicates.'),
(4, 2, 'Find tourists from Mexico.', 'SELECT * FROM Tourists WHERE country=\"Mexico\"', 'Use WHERE condition.'),
(5, 2, 'Find hotels in Kandy under Rs. 5000.', 'SELECT * FROM Hotels WHERE city=\"Kandy\" AND price < 5000', 'Filter by city and price.'),
(6, 2, 'Find Spanish tourists whose names start with G.', 'SELECT * FROM Tourists WHERE country=\"Spain\" AND name LIKE \"G%\"', 'LIKE with % is wildcard.'),
(7, 2, 'Show tourists from Germany or Spain.', 'SELECT * FROM Tourists WHERE country=\"Germany\" OR country=\"Spain\"', 'Combine with OR.'),
(8, 3, 'Sort hotels by price.', 'SELECT * FROM Hotels ORDER BY price', 'ORDER BY sorts results.'),
(9, 3, 'Show the first 3 tourists.', 'SELECT * FROM Tourists LIMIT 3', 'LIMIT restricts rows.'),
(10, 3, 'Exclude tourists from Spain.', 'SELECT * FROM Tourists WHERE NOT country=\"Spain\"', 'NOT negates condition.'),
(11, 4, 'Show hotels with their province.', 'SELECT h.name, h.city, p.name AS province FROM Hotels h INNER JOIN Provinces p ON h.province_id = p.province_id', 'INNER JOIN links two tables.'),
(12, 4, 'Show all tourists, even if no booking (LEFT JOIN).', 'SELECT t.name, b.booking_id FROM Tourists t LEFT JOIN Bookings b ON t.tourist_id = b.tourist_id', 'LEFT JOIN keeps all tourists.'),
(13, 4, 'Merge list of countries and cities.', 'SELECT country FROM Tourists UNION SELECT city FROM Hotels', 'UNION merges results.'),
(14, 5, 'Count tourists per country.', 'SELECT country, COUNT(*) FROM Tourists GROUP BY country', 'GROUP BY groups rows.'),
(15, 5, 'Find minimum hotel price.', 'SELECT MIN(price) FROM Hotels', 'MIN gives the smallest value.'),
(16, 5, 'Show hotels priced between 4000 and 6000.', 'SELECT * FROM Hotels WHERE price BETWEEN 4000 AND 6000', 'BETWEEN filters ranges.'),
(17, 6, 'Cities with more than 2 hotels.', 'SELECT city, COUNT(*) FROM Hotels GROUP BY city HAVING COUNT(*) > 2', 'HAVING filters groups.'),
(18, 6, 'Tourists who made more than 1 booking.', 'SELECT tourist_id, COUNT(*) FROM Bookings GROUP BY tourist_id HAVING COUNT(*) > 1', 'Aggregate with HAVING.'),
(19, 7, 'Hotels cheaper than average.', 'SELECT * FROM Hotels WHERE price < (SELECT AVG(price) FROM Hotels)', 'Subquery finds average.'),
(20, 7, 'Show tourists who have at least one booking.', 'SELECT * FROM Tourists WHERE EXISTS (SELECT * FROM Bookings WHERE Bookings.tourist_id = Tourists.tourist_id)', 'EXISTS checks if subquery returns.'),
(21, 8, 'Add a new hotel.', 'INSERT INTO Hotels (name, city, province_id, price, amenities) VALUES (\"Gemstone Hotel\", \"Ratnapura\", 8, 5000, \"WiFi, Pool\")', 'INSERT adds a row.'),
(22, 8, 'Update hotel price.', 'UPDATE Hotels SET price = 6000 WHERE name=\"Gemstone Hotel\"', 'UPDATE changes data.'),
(23, 8, 'Delete duplicates.', 'DELETE FROM Hotels WHERE hotel_id=12', 'DELETE removes records.'),
(24, 9, 'Create a view for all hotels with WiFi.', 'CREATE VIEW HotelsWithWiFi AS SELECT * FROM Hotels WHERE amenities LIKE \"%WiFi%\"', 'Views save queries.'),
(25, 9, 'Generate a report combining tourists, hotels, and bookings.', 'SELECT t.name, h.name AS hotel, b.check_in FROM Tourists t JOIN Bookings b ON t.tourist_id = b.tourist_id JOIN Hotels h ON b.hotel_id = h.hotel_id', 'JOIN across three tables.'),
(26, 9, 'Find tourists who stayed in more than 1 province.', 'SELECT t.name, COUNT(DISTINCT h.province_id) AS provinces FROM Tourists t JOIN Bookings b ON t.tourist_id = b.tourist_id JOIN Hotels h ON b.hotel_id = h.hotel_id GROUP BY t.name HAVING COUNT(DISTINCT h.province_id) > 1', 'COUNT DISTINCT counts unique values.');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `player_progress`
--

CREATE TABLE `player_progress` (
  `id` int(11) NOT NULL,
  `player_id` int(11) DEFAULT NULL,
  `highest_level` int(11) DEFAULT 1,
  `current_level` int(11) DEFAULT 1,
  `current_task_id` int(11) DEFAULT 1,
  `attempts_left` int(11) DEFAULT 3
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `player_progress`
--

INSERT INTO `player_progress` (`id`, `player_id`, `highest_level`, `current_level`, `current_task_id`, `attempts_left`) VALUES
(1, 1, 1, 1, 1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `provinces`
--

CREATE TABLE `provinces` (
  `province_id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `provinces`
--

INSERT INTO `provinces` (`province_id`, `name`) VALUES
(1, 'Western'),
(2, 'Central'),
(3, 'Southern'),
(4, 'Northern'),
(5, 'Eastern'),
(6, 'North Central'),
(7, 'Uva'),
(8, 'Sabaragamuwa'),
(9, 'North Western');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('WxuW3cvJCKu4NyjS66y9cY3hfTwRspHPWq28tWPf', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoieGM5S1FYMGY1Y25lT2R4cjJ6QTlTcUZib2JqV0FZT2d3RWFXQ1l5eSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzI6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9zcWwtZ2FtZS85Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1755362079);

-- --------------------------------------------------------

--
-- Table structure for table `tourists`
--

CREATE TABLE `tourists` (
  `tourist_id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `country` varchar(50) DEFAULT NULL,
  `age` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tourists`
--

INSERT INTO `tourists` (`tourist_id`, `name`, `country`, `age`) VALUES
(1, 'Emma', 'UK', 29),
(2, 'Haruki', 'Japan', 34),
(3, 'Sofia', 'Spain', 26),
(4, 'Ahmed', 'Egypt', 31),
(5, 'Carlos', 'Brazil', 28);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `tourist_id` (`tourist_id`),
  ADD KEY `hotel_id` (`hotel_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `hotels`
--
ALTER TABLE `hotels`
  ADD PRIMARY KEY (`hotel_id`),
  ADD KEY `province_id` (`province_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `levels`
--
ALTER TABLE `levels`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `level_tasks`
--
ALTER TABLE `level_tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `level_id` (`level_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `player_progress`
--
ALTER TABLE `player_progress`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `provinces`
--
ALTER TABLE `provinces`
  ADD PRIMARY KEY (`province_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `tourists`
--
ALTER TABLE `tourists`
  ADD PRIMARY KEY (`tourist_id`);

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
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hotels`
--
ALTER TABLE `hotels`
  MODIFY `hotel_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `levels`
--
ALTER TABLE `levels`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `level_tasks`
--
ALTER TABLE `level_tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `player_progress`
--
ALTER TABLE `player_progress`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `provinces`
--
ALTER TABLE `provinces`
  MODIFY `province_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tourists`
--
ALTER TABLE `tourists`
  MODIFY `tourist_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`tourist_id`) REFERENCES `tourists` (`tourist_id`),
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`hotel_id`) REFERENCES `hotels` (`hotel_id`);

--
-- Constraints for table `hotels`
--
ALTER TABLE `hotels`
  ADD CONSTRAINT `hotels_ibfk_1` FOREIGN KEY (`province_id`) REFERENCES `provinces` (`province_id`);

--
-- Constraints for table `level_tasks`
--
ALTER TABLE `level_tasks`
  ADD CONSTRAINT `level_tasks_ibfk_1` FOREIGN KEY (`level_id`) REFERENCES `levels` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
