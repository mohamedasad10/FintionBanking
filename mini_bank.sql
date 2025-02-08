-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 08, 2025 at 11:41 PM
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
-- Database: `mini_bank`
--

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `sender_account` varchar(50) NOT NULL,
  `recipient_account` varchar(50) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `transaction_type` enum('deposit','withdrawal','transfer') NOT NULL,
  `transaction_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `sender_account`, `recipient_account`, `amount`, `transaction_type`, `transaction_date`) VALUES
(1, '1', '2', 100.00, 'transfer', '2025-02-08 14:26:08'),
(2, '1', '3', 123.00, 'transfer', '2025-02-08 14:28:17'),
(3, '1', '5', 540.00, 'transfer', '2025-02-08 15:03:33'),
(4, '1', '1', 200.00, 'deposit', '2025-02-08 15:07:08'),
(5, '1', '1', 100.00, 'deposit', '2025-02-08 15:09:33'),
(6, '1', '1', 100.00, 'deposit', '2025-02-08 15:10:29'),
(7, '1', '1', 700.00, 'deposit', '2025-02-08 15:13:13'),
(8, '1', '', 2.00, 'withdrawal', '2025-02-08 14:15:30'),
(9, '1', '', 400.00, 'withdrawal', '2025-02-08 14:16:02'),
(10, '1', '', 423.00, 'withdrawal', '2025-02-08 15:18:19'),
(11, '1', '2', 200.00, 'transfer', '2025-02-08 22:02:59');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `account_number` int(11) NOT NULL,
  `holder_name` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `password` varchar(255) NOT NULL,
  `balance` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`account_number`, `holder_name`, `email`, `phone`, `password`, `balance`) VALUES
(1, 'Mohamed Asad Bandarkar', 'mohamedasad11914@gmail.com', '0680845316', '$2y$10$PrMzMAZ7Ga02K8R1UEroZuDNN.9BqCw7Cq92aAFFg1N0oBJ2YRWJC', 1321.00),
(2, 'Jonny Test', 'test@gmail.com', '0834585613', '$2y$10$2IG7FeqchtdowB43rdSV8OYCFdgo5D3lKEvY3n3OTmoJxlmiM6V1i', 1030.00),
(3, 'Andy King', 'a@gmail.com', '05473298849', '$2y$10$fVt2ow7sV6lq/MpL2kxjSODid9sQzIWRUNXHSI7FYkEYoVEcYAF7G', 123.00),
(4, 'Loser', 'l@gmail.com', '036847834279432', '$2y$10$Q/CtP/s6DGTrOnP4jctdJ.pw6CNSfyk2.nOgRi.hLSvUlcLkP.brm', 0.00),
(5, 'winner', 'w@gmail.com', '023456789345', '$2y$10$f26cjLC5GsOPZC.FjLf7IOyXjZ7EZUnTffxdFmVZ/5bl5PyHA.n2O', 540.00);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`account_number`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `account_number` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
