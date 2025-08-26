-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 26, 2025 at 07:42 PM
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
-- Database: `sql_game_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `achievements`
--

CREATE TABLE `achievements` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `badge_image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `achievements`
--

INSERT INTO `achievements` (`id`, `name`, `description`, `badge_image`, `created_at`) VALUES
(1, 'Western Explorer', 'Completed Level 1 – Western Province (Colombo).', 'badges/western.png', '2025-08-23 15:10:21'),
(2, 'Central Adventurer', 'Completed Level 2 – Central Province (Kandy).', 'badges/central.png', '2025-08-23 15:10:21'),
(3, 'Southern Surfer', 'Completed Level 3 – Southern Province (Galle).', 'badges/southern.png', '2025-08-23 15:10:21'),
(4, 'Northern Voyager', 'Completed Level 4 – Northern Province (Jaffna).', 'badges/northern.png', '2025-08-23 15:10:21'),
(5, 'Eastern Relaxer', 'Completed Level 5 – Eastern Province (Pasikuda).', 'badges/eastern.png', '2025-08-23 15:10:21'),
(6, 'Ancient Seeker', 'Completed Level 6 – North Central Province (Anuradhapura).', 'badges/north_central.png', '2025-08-23 15:10:21'),
(7, 'Hill Country Explorer', 'Completed Level 7 – Uva Province (Badulla).', 'badges/uva.png', '2025-08-23 15:10:21'),
(8, 'Gem Hunter', 'Completed Level 8 – Sabaragamuwa Province (Ratnapura).', 'badges/sabaragamuwa.png', '2025-08-23 15:10:21'),
(9, 'SQL Master Explorer', 'Completed Level 9 – North Western Province (Kurunegala).', 'badges/north_western.png', '2025-08-23 15:10:21');

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
  `introduction` text DEFAULT NULL,
  `reference_table` varchar(255) DEFAULT NULL,
  `task` text DEFAULT NULL,
  `task_accepting` text DEFAULT NULL,
  `expected_query` text DEFAULT NULL,
  `clue` text DEFAULT NULL,
  `help` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `level_tasks`
--

INSERT INTO `level_tasks` (`id`, `level_id`, `introduction`, `reference_table`, `task`, `task_accepting`, `expected_query`, `clue`, `help`) VALUES
(1, 1, 'Now, you should select a hotel to stay in Colombo.', 'Hotels', 'First, show all hotels.', 'Okay, how should I select one?', 'SELECT * FROM Hotels', 'Use SELECT * to see all rows.', '\'\n<p>The <code>SELECT</code> statement is used to fetch data from a table.</p>\n\n<p><b>Basic usage:</b></p>\n<pre><code>SELECT * FROM table_name;</code></pre>\n\n<p>This returns all rows and columns.</p>\n\n<p><b>Example:</b></p>\n<pre><code>SELECT * FROM Hotels;</code></pre>\n\n<p><b>Example Output:</b></p>\n<table class=\"table table-bordered table-sm\">\n  <thead>\n    <tr>\n      <th>id</th>\n      <th>hotel_name</th>\n      <th>location</th>\n    </tr>\n  </thead>\n  <tbody>\n    <tr>\n      <td>1</td>\n      <td>Colombo Grand Hotel</td>\n      <td>Colombo</td>\n    </tr>\n    <tr>\n      <td>2</td>\n      <td>Kandy Hills</td>\n      <td>Kandy</td>\n    </tr>\n    <tr>\n      <td>3</td>\n      <td>Galle Beach Resort</td>\n      <td>Galle</td>\n    </tr>\n  </tbody>\n</table>\n\n<p>More about SELECT → \n  <a href=\"https://www.w3schools.com/sql/sql_select.asp\" target=\"_blank\">\n    W3Schools: SQL SELECT Statement\n  </a>\n</p>\n\''),
(2, 1, 'Alex, you have many choices.', 'Hotels', 'Select the hotels from Colombo.', 'Alright, I think I should filter the hotels in Colombo.', 'select * from hotels where city=\"colombo\"', 'Pick specific columns.', 'Instead of `*`, list the columns you need:\n```sql\nSELECT name, country FROM Tourists;\n```'),
(3, 1, 'Hmm, I wonder what hotel you choose.', 'Hotels', 'Ok, show the details of the \"Colombo Grand Hotel\"', 'Let me select the \"Colombo Grand Hotel\"', 'SELECT * FROM `hotels` WHERE name=\"Colombo Grand Hotel\"', 'WHERE name=\"Colombo Grand Hotel\"', 'The `DISTINCT` keyword removes duplicates:\n```sql\nSELECT DISTINCT country FROM Tourists;\n```'),
(4, 2, 'Now, you should select a hotel to stay in Kandy.', 'Hotels', 'Show hotels in Kandy', 'Okay, let me show.', 'SELECT * FROM Hotels WHERE city=\"Kandy\"', 'Use WHERE condition.', '`WHERE` filters rows based on conditions:\n```sql\nSELECT * FROM Tourists WHERE country=\"Mexico\";\n```'),
(5, 2, 'Hotels in Kandy can be pricey. Could you check which ones cost less than Rs. 5000?', 'Hotels', 'Find hotels in Kandy under Rs. 5000.', 'Got it, I need multiple conditions.', 'SELECT * FROM Hotels WHERE city=\"Kandy\" AND price < 5000', 'Filter by city and price.', 'Combine conditions with `AND`:\n```sql\nSELECT * FROM Hotels WHERE city=\"Kandy\" AND price < 5000;\n```'),
(6, 2, 'I heard we have Spanish tourists visiting Kandy. Could you check which of them have names starting with G?', 'Tourists', 'Find Spanish tourists whose names start with G.', 'Okay, I’ll try LIKE with wildcards.', 'SELECT * FROM Tourists WHERE country=\"Spain\" AND name LIKE \"G%\"', 'LIKE with % is wildcard.', '<p>The <code>WHERE</code> clause is used to filter records based on conditions.  \nYou can combine multiple conditions using <code>AND</code>, <code>OR</code>, and pattern matching with <code>LIKE</code>.</p>\n\n<p><b>Example usage:</b></p>\n<pre><code>SELECT * FROM Tourists \nWHERE country = \"Spain\" AND name LIKE \"G%\";</code></pre>\n\n<p>This query returns all tourists from Spain whose names start with the letter <b>G</b>.</p>\n\n<p><b>Example Output:</b></p>\n<table class=\"table table-bordered table-sm\">\n  <thead>\n    <tr>\n      <th>id</th>\n      <th>name</th>\n      <th>country</th>\n      <th>age</th>\n    </tr>\n  </thead>\n  <tbody>\n    <tr>\n      <td>4</td>\n      <td>Gabriel</td>\n      <td>Spain</td>\n      <td>32</td>\n    </tr>\n    <tr>\n      <td>7</td>\n      <td>Gloria</td>\n      <td>Spain</td>\n      <td>28</td>\n    </tr>\n    <tr>\n      <td>9</td>\n      <td>Gonzalo</td>\n      <td>Spain</td>\n      <td>41</td>\n    </tr>\n  </tbody>\n</table>\n\n<p>More about WHERE and LIKE →  \n  <a href=\"https://www.w3schools.com/sql/sql_where.asp\" target=\"_blank\">W3Schools: SQL WHERE</a> |  \n  <a href=\"https://www.w3schools.com/sql/sql_like.asp\" target=\"_blank\">W3Schools: SQL LIKE</a>\n</p>\n```sql\nSELECT * FROM Tourists WHERE name LIKE \"G%\";\n```'),
(7, 2, 'Alex, I’d like to see tourists from Germany and Spain together. Could you find them?', 'Tourists', 'Show tourists from Germany or Spain.', 'Alright, I’ll try using OR.', 'SELECT * FROM Tourists WHERE country=\"Germany\" OR country=\"Spain\"', 'Combine with OR.', '`OR` checks if at least one condition is true:\n```sql\nSELECT * FROM Tourists WHERE country=\"Germany\" OR country=\"Spain\";\n```'),
(8, 3, 'Some hotels here have very different prices. Could you sort them by price so we can compare?', 'Hotels', 'Sort hotels by price.', 'Okay, ordering makes sense here.', 'SELECT * FROM Hotels ORDER BY price', 'ORDER BY sorts results.', '`ORDER BY` sorts results:\n```sql\nSELECT * FROM Hotels ORDER BY price;\n```'),
(9, 3, 'I just need a quick look at the first few tourists. Could you show me only the first 3?', 'Tourists', 'Show the first 3 tourists.', 'Got it, I need to limit the rows.', 'SELECT * FROM Tourists LIMIT 3', 'LIMIT restricts rows.', '`LIMIT` controls how many rows are shown:\n```sql\nSELECT * FROM Tourists LIMIT 3;\n```'),
(10, 3, 'Not everyone is from Spain. Can you show me the tourists who are not from Spain?', 'Tourists', 'Exclude tourists from Spain.', 'Okay, I think I should use NOT.', 'SELECT * FROM Tourists WHERE NOT country=\"Spain\"', 'NOT negates condition.', '`NOT` excludes rows that meet a condition:\n```sql\nSELECT * FROM Tourists WHERE NOT country=\"Spain\";\n```'),
(11, 4, 'Hotels are located in different provinces. Could you show each hotel together with its province?', 'Hotels,Provinces', 'Show hotels with their province.', 'Looks like I need to JOIN two tables.', 'SELECT h.name, h.city, p.name AS province FROM Hotels h INNER JOIN Provinces p ON h.province_id = p.province_id', 'INNER JOIN links two tables.', '`INNER JOIN` combines rows where there’s a match:\n```sql\nSELECT h.name, p.name FROM Hotels h INNER JOIN Provinces p ON h.province_id = p.province_id;\n```'),
(12, 4, 'Some tourists may not have booked anything yet. Can you show all tourists, even those with no bookings?', 'Tourists,Bookings', 'Show all tourists, even if no booking (LEFT JOIN).', 'Okay, LEFT JOIN keeps all tourists.', 'SELECT t.name, b.booking_id FROM Tourists t LEFT JOIN Bookings b ON t.tourist_id = b.tourist_id', 'LEFT JOIN keeps all tourists.', '`LEFT JOIN` includes all rows from the left table even if no match:\n```sql\nSELECT t.name, b.booking_id FROM Tourists t LEFT JOIN Bookings b ON t.tourist_id = b.tourist_id;\n```'),
(13, 4, 'Let’s merge two different lists: countries from tourists and cities from hotels.', 'Tourists,Hotels', 'Merge list of countries and cities.', 'Sounds like I need UNION.', 'SELECT country FROM Tourists UNION SELECT city FROM Hotels', 'UNION merges results.', '`UNION` merges results of two queries:\n```sql\nSELECT country FROM Tourists UNION SELECT city FROM Hotels;\n```'),
(14, 5, 'I’d like to know how many tourists we have from each country. Can you count them for me?', 'Tourists', 'Count tourists per country.', 'Okay, grouping by country should work.', 'SELECT country, COUNT(*) FROM Tourists GROUP BY country', 'GROUP BY groups rows.', '`GROUP BY` groups rows and works with aggregates:\n```sql\nSELECT country, COUNT(*) FROM Tourists GROUP BY country;\n```'),
(15, 5, 'Hotels have different price ranges. Could you check what the cheapest hotel price is?', 'Hotels', 'Find minimum hotel price.', 'I think I should use an aggregate function.', 'SELECT MIN(price) FROM Hotels', 'MIN gives the smallest value.', '`MIN()` finds the smallest value:\n```sql\nSELECT MIN(price) FROM Hotels;\n```'),
(16, 5, 'Some travelers have budgets. Could you show me hotels that cost between 4000 and 6000?', 'Hotels', 'Show hotels priced between 4000 and 6000.', 'Okay, BETWEEN looks right here.', 'SELECT * FROM Hotels WHERE price BETWEEN 4000 AND 6000', 'BETWEEN filters ranges.', '`BETWEEN` selects values in a range:\n```sql\nSELECT * FROM Hotels WHERE price BETWEEN 4000 AND 6000;\n```'),
(17, 6, 'Some cities are very popular. Could you find the cities that have more than 2 hotels?', 'Hotels', 'Cities with more than 2 hotels.', 'Alright, I’ll try HAVING.', 'SELECT city, COUNT(*) FROM Hotels GROUP BY city HAVING COUNT(*) > 2', 'HAVING filters groups.', '`HAVING` works on grouped results:\n```sql\nSELECT city, COUNT(*) FROM Hotels GROUP BY city HAVING COUNT(*) > 2;\n```'),
(18, 6, 'Some tourists travel a lot. Could you find those who made more than one booking?', 'Bookings', 'Tourists who made more than 1 booking.', 'Looks like another HAVING example.', 'SELECT tourist_id, COUNT(*) FROM Bookings GROUP BY tourist_id HAVING COUNT(*) > 1', 'Aggregate with HAVING.', '`HAVING` with aggregates:\n```sql\nSELECT tourist_id, COUNT(*) FROM Bookings GROUP BY tourist_id HAVING COUNT(*) > 1;\n```'),
(19, 7, 'Hotels vary in price. Could you show me the hotels that are cheaper than the average price?', 'Hotels', 'Hotels cheaper than average.', 'Okay, I need to use a subquery.', 'SELECT * FROM Hotels WHERE price < (SELECT AVG(price) FROM Hotels)', 'Subquery finds average.', 'Subqueries are queries inside queries:\n```sql\nSELECT * FROM Hotels WHERE price < (SELECT AVG(price) FROM Hotels);\n```'),
(20, 7, 'I’d like to know which tourists have made at least one booking. Can you find them?', 'Tourists,Bookings', 'Show tourists who have at least one booking.', 'Alright, EXISTS might help here.', 'SELECT * FROM Tourists WHERE EXISTS (SELECT * FROM Bookings WHERE Bookings.tourist_id = Tourists.tourist_id)', 'EXISTS checks if subquery returns.', '`EXISTS` checks for subquery results:\n```sql\nSELECT * FROM Tourists WHERE EXISTS (SELECT * FROM Bookings WHERE Bookings.tourist_id = Tourists.tourist_id);\n```'),
(21, 8, 'A new hotel has opened recently. Could you add it to the list?', 'Hotels', 'Add a new hotel.', 'Okay, I should try INSERT.', 'INSERT INTO Hotels (name, city, province_id, price, amenities) VALUES (\"Gemstone Hotel\", \"Ratnapura\", 8, 5000, \"WiFi, Pool\")', 'INSERT adds a row.', '`INSERT` adds new records:\n```sql\nINSERT INTO Hotels (name, city, price) VALUES (\"Sunrise\", \"Colombo\", 6000);\n```'),
(22, 8, 'One of our hotels updated its prices. Could you adjust the details in the database?', 'Hotels', 'Update hotel price.', 'Got it, UPDATE is used here.', 'UPDATE Hotels SET price = 6000 WHERE name=\"Gemstone Hotel\"', 'UPDATE changes data.', '`UPDATE` modifies rows:\n```sql\nUPDATE Hotels SET price=5500 WHERE city=\"Colombo\";\n```'),
(23, 8, 'We accidentally added duplicate hotel entries. Could you clean that up?', 'Hotels', 'Delete duplicates.', 'Looks like DELETE statement.', 'DELETE FROM Hotels WHERE hotel_id=12', 'DELETE removes records.', '`DELETE` removes rows:\n```sql\nDELETE FROM Hotels WHERE hotel_id=12;\n```'),
(24, 9, 'WiFi is important for travelers. Can you create a view for all hotels that provide WiFi?', 'Hotels', 'Create a view for all hotels with WiFi.', 'Okay, let me create a view.', 'CREATE VIEW HotelsWithWiFi AS SELECT * FROM Hotels WHERE amenities LIKE \"%WiFi%\"', 'Views save queries.', '`VIEW` is a saved query:\n```sql\nCREATE VIEW HotelsWithWiFi AS SELECT * FROM Hotels WHERE amenities LIKE \"%WiFi%\";\n```'),
(25, 9, 'I’d like a complete report showing which tourist stayed at which hotel, with their booking dates.', 'Tourists,Bookings,Hotels', 'Generate a report combining tourists, hotels, and bookings.', 'Alright, this needs multiple JOINs.', 'SELECT t.name, h.name AS hotel, b.check_in FROM Tourists t JOIN Bookings b ON t.tourist_id = b.tourist_id JOIN Hotels h ON b.hotel_id = h.hotel_id', 'JOIN across three tables.', 'JOIN multiple tables step by step:\n```sql\nSELECT t.name, h.name, b.check_in FROM Tourists t JOIN Bookings b ON t.tourist_id=b.tourist_id JOIN Hotels h ON b.hotel_id=h.hotel_id;\n```'),
(26, 9, 'Some tourists love exploring! Can you find those who stayed in more than one province?', 'Tourists,Bookings,Hotels', 'Find tourists who stayed in more than 1 province.', 'Okay, I’ll try COUNT DISTINCT.', 'SELECT t.name, COUNT(DISTINCT h.province_id) AS provinces FROM Tourists t JOIN Bookings b ON t.tourist_id = b.tourist_id JOIN Hotels h ON b.hotel_id = h.hotel_id GROUP BY t.name HAVING COUNT(DISTINCT h.province_id) > 1', 'COUNT DISTINCT counts unique values.', '`COUNT(DISTINCT ...)` counts unique values:\n```sql\nSELECT t.name, COUNT(DISTINCT h.province_id) FROM Tourists t JOIN Bookings b ON t.tourist_id=b.tourist_id JOIN Hotels h ON b.hotel_id=h.hotel_id GROUP BY t.name HAVING COUNT(DISTINCT h.province_id) > 1;\n```');

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
-- Table structure for table `player_achievements`
--

CREATE TABLE `player_achievements` (
  `id` int(11) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `achievement_id` int(11) NOT NULL,
  `earned_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `player_achievements`
--

INSERT INTO `player_achievements` (`id`, `user_id`, `achievement_id`, `earned_at`) VALUES
(1, 1, 1, '2025-08-23 12:15:27'),
(2, 1, 2, '2025-08-26 11:39:57');

-- --------------------------------------------------------

--
-- Table structure for table `player_progress`
--

CREATE TABLE `player_progress` (
  `id` int(11) NOT NULL,
  `player_id` bigint(20) UNSIGNED DEFAULT NULL,
  `highest_level` int(11) DEFAULT 1,
  `intro_status` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `current_level` int(11) DEFAULT 1,
  `current_task_id` int(11) DEFAULT 1,
  `attempts_left` int(11) DEFAULT 3
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `player_progress`
--

INSERT INTO `player_progress` (`id`, `player_id`, `highest_level`, `intro_status`, `current_level`, `current_task_id`, `attempts_left`) VALUES
(1, 1, 3, 2, 3, 8, 3);

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
('i9SYtaXHYRIxk87ryxeYREf1vLTZeBg41lLEcqLv', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiM2E3SGsyVkh3QjNldkJtUnZoUDMwN2Q0UTk5QjVKSjkxVlhDZzB2aiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDQ6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9pbnRyb2R1Y3Rpb24vc2VjdGlvbi8zIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1756230056);

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
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Dineth', 'dinethk222@gmail.com', NULL, 'dinethk222@gmail.com', NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `achievements`
--
ALTER TABLE `achievements`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `player_achievements`
--
ALTER TABLE `player_achievements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `achievement_id` (`achievement_id`);

--
-- Indexes for table `player_progress`
--
ALTER TABLE `player_progress`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_player_progress_user` (`player_id`);

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
-- AUTO_INCREMENT for table `achievements`
--
ALTER TABLE `achievements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

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
-- AUTO_INCREMENT for table `player_achievements`
--
ALTER TABLE `player_achievements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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

--
-- Constraints for table `player_achievements`
--
ALTER TABLE `player_achievements`
  ADD CONSTRAINT `player_achievements_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `player_achievements_ibfk_2` FOREIGN KEY (`achievement_id`) REFERENCES `achievements` (`id`);

--
-- Constraints for table `player_progress`
--
ALTER TABLE `player_progress`
  ADD CONSTRAINT `fk_player_progress_user` FOREIGN KEY (`player_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
