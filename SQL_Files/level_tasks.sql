-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 23, 2025 at 06:27 PM
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
(4, 2, 'We’re expecting some visitors from Mexico. Can you filter the list of tourists to show only them?', 'Tourists', 'Find tourists from Mexico.', 'Okay, let me filter with WHERE.', 'SELECT * FROM Tourists WHERE country=\"Mexico\"', 'Use WHERE condition.', '`WHERE` filters rows based on conditions:\n```sql\nSELECT * FROM Tourists WHERE country=\"Mexico\";\n```'),
(5, 2, 'Hotels in Kandy can be pricey. Could you check which ones cost less than Rs. 5000?', 'Hotels', 'Find hotels in Kandy under Rs. 5000.', 'Got it, I need multiple conditions.', 'SELECT * FROM Hotels WHERE city=\"Kandy\" AND price < 5000', 'Filter by city and price.', 'Combine conditions with `AND`:\n```sql\nSELECT * FROM Hotels WHERE city=\"Kandy\" AND price < 5000;\n```'),
(6, 2, 'I heard we have Spanish tourists visiting. Could you check which of them have names starting with G?', 'Tourists', 'Find Spanish tourists whose names start with G.', 'Okay, I’ll try LIKE with wildcards.', 'SELECT * FROM Tourists WHERE country=\"Spain\" AND name LIKE \"G%\"', 'LIKE with % is wildcard.', '`LIKE` allows pattern matching:\n```sql\nSELECT * FROM Tourists WHERE name LIKE \"G%\";\n```'),
(7, 2, 'Alex, I’d like to see tourists from Germany and Spain together. Could you find them?', 'Tourists', 'Show tourists from Germany or Spain.', 'Alright, I’ll try using OR.', 'SELECT * FROM Tourists WHERE country=\"Germany\" OR country=\"Spain\"', 'Combine with OR.', '`OR` checks if at least one condition is true:\n```sql\nSELECT * FROM Tourists WHERE country=\"Germany\" OR country=\"Spain\";\n```');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `level_tasks`
--
ALTER TABLE `level_tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `level_id` (`level_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `level_tasks`
--
ALTER TABLE `level_tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `level_tasks`
--
ALTER TABLE `level_tasks`
  ADD CONSTRAINT `level_tasks_ibfk_1` FOREIGN KEY (`level_id`) REFERENCES `levels` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
