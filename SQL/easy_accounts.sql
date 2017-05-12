-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: May 12, 2017 at 04:47 AM
-- Server version: 5.6.33
-- PHP Version: 5.6.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `easy_accounts`
--

-- --------------------------------------------------------

--
-- Table structure for table `du_accounts`
--

CREATE TABLE `du_accounts` (
  `acc_id` varchar(200) NOT NULL,
  `created_date` datetime NOT NULL,
  `acc_name` varchar(200) NOT NULL,
  `starting_balance` varchar(500) NOT NULL,
  `current_balance` varchar(500) NOT NULL,
  `acc_type` varchar(200) NOT NULL,
  `open_date` date NOT NULL,
  `acc_holder_name` varchar(200) NOT NULL,
  `acc_number` varchar(200) NOT NULL,
  `bank` varchar(200) NOT NULL,
  `branch` varchar(200) NOT NULL,
  `city` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `du_accounts`
--

INSERT INTO `du_accounts` (`acc_id`, `created_date`, `acc_name`, `starting_balance`, `current_balance`, `acc_type`, `open_date`, `acc_holder_name`, `acc_number`, `bank`, `branch`, `city`) VALUES
('ACC_1', '2016-11-03 21:09:07', 'Salary HDFC', '30000', '51365', 'Savings', '2016-07-18', 'Ramu Ramasamy', '1234', 'HDFC', 'Kottivakkam', 'Chennai'),
('ACC_2', '2016-11-03 21:09:48', 'SBI', '5000', '76000', 'Savings', '2016-10-01', 'Ramu Ramasamy', '2345', 'SBI', 'Vadavalli', 'Coimbatore'),
('ACC_4', '2016-11-05 17:21:45', 'Fund', '900000', '726200', 'Others', '2016-11-05', 'NA', 'NA', 'NA', 'NA', 'NA'),
('ACC_5', '2016-11-12 08:43:57', 'LVB', '30000', '29500', 'Savings', '2016-11-12', 'NA', 'NA', 'NA', 'NA', 'NA'),
('ACC_6', '2017-02-26 21:47:46', 'new', '5000', '5000', 'Savings', '2017-02-09', 'Ramu Ramasamy', '11223344', 'r', 'r', 'Coimbatore'),
('ACC_7', '2017-02-26 21:50:29', 'new2', '4000', '4000', 'Loan', '2017-02-08', 'Ramu Ramasamy', '11223344', 'r', 'r', 'Coimbatore');

-- --------------------------------------------------------

--
-- Table structure for table `du_categories`
--

CREATE TABLE `du_categories` (
  `cat_id` varchar(200) NOT NULL,
  `created_date` datetime NOT NULL,
  `category_name` varchar(200) NOT NULL,
  `category_type` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `du_categories`
--

INSERT INTO `du_categories` (`cat_id`, `created_date`, `category_name`, `category_type`) VALUES
('CAT_1', '2016-11-03 21:11:44', 'Eating Out', 'Expense'),
('CAT_2', '2016-11-03 21:11:53', 'Movies', 'Expense'),
('CAT_5', '2016-11-04 07:39:38', 'mobile', 'Expense'),
('CAT_6', '2016-11-05 20:21:19', 'Salary', 'Income'),
('CAT_7', '2016-11-05 20:22:24', 'd', 'Income');

-- --------------------------------------------------------

--
-- Table structure for table `du_transactions`
--

CREATE TABLE `du_transactions` (
  `tra_id` varchar(200) NOT NULL,
  `created_date` datetime NOT NULL,
  `payee` varchar(800) NOT NULL,
  `transaction_type` varchar(100) NOT NULL,
  `amount` varchar(500) NOT NULL,
  `category` varchar(300) NOT NULL,
  `account` varchar(300) NOT NULL,
  `after_bal_account` varchar(200) NOT NULL,
  `from_account` varchar(200) NOT NULL,
  `to_account` varchar(200) NOT NULL,
  `after_bal_from_account` varchar(200) NOT NULL,
  `after_bal_to_account` varchar(200) NOT NULL,
  `transaction_date` date NOT NULL,
  `description` varchar(2000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `du_transactions`
--

INSERT INTO `du_transactions` (`tra_id`, `created_date`, `payee`, `transaction_type`, `amount`, `category`, `account`, `after_bal_account`, `from_account`, `to_account`, `after_bal_from_account`, `after_bal_to_account`, `transaction_date`, `description`) VALUES
('TRA_1', '2016-11-03 21:14:23', 'Shell', 'Expense', '400', 'Petrol', 'Wallet', '100', '', '', '', '', '2016-11-02', ''),
('TRA_10', '2016-11-05 17:34:30', 'Swiggy', 'Expense', '90000', 'Eating Out', 'Fund', '810000', '', '', '', '', '2016-11-04', ''),
('TRA_16', '2016-11-05 21:13:10', 'simply', 'Expense', '75000', 'CAT_5', 'ACC_4', '726200', 'ACC_4', 'ACC_2', '726200', '150000', '2016-11-05', 'NA'),
('TRA_17', '2016-11-12 08:48:38', 'mobile', 'Expense', '500', 'CAT_5', 'ACC_5', '29500', '', '', '', '', '2016-11-12', 'NA'),
('TRA_18', '2016-11-13 16:18:33', 'ramu', 'Transfer', '5000', '', '', '', 'ACC_1', 'ACC_2', '51365', '76000', '2016-11-13', 'transfer from hdfc'),
('TRA_5', '2016-11-04 07:46:05', 'Infoview', 'Income', '31865', 'Salary', 'ACC_1', '59865', '', '', '', '', '2016-11-01', ''),
('TRA_9', '2016-11-05 17:31:03', 'Movie', 'Income', '70000', 'Salary', 'SBI', '75000', '', '', '', '', '2016-11-05', '');

-- --------------------------------------------------------

--
-- Table structure for table `mrram_accounts`
--

CREATE TABLE `mrram_accounts` (
  `acc_id` varchar(200) NOT NULL,
  `created_date` datetime NOT NULL,
  `acc_name` varchar(200) NOT NULL,
  `starting_balance` varchar(500) NOT NULL,
  `current_balance` varchar(500) NOT NULL,
  `acc_type` varchar(200) NOT NULL,
  `open_date` date NOT NULL,
  `acc_holder_name` varchar(200) NOT NULL,
  `acc_number` varchar(200) NOT NULL,
  `bank` varchar(200) NOT NULL,
  `branch` varchar(200) NOT NULL,
  `city` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mrram_categories`
--

CREATE TABLE `mrram_categories` (
  `cat_id` varchar(200) NOT NULL,
  `created_date` datetime NOT NULL,
  `category_name` varchar(200) NOT NULL,
  `category_type` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mrram_transactions`
--

CREATE TABLE `mrram_transactions` (
  `tra_id` varchar(200) NOT NULL,
  `created_date` datetime NOT NULL,
  `payee` varchar(800) NOT NULL,
  `transaction_type` varchar(100) NOT NULL,
  `amount` varchar(500) NOT NULL,
  `category` varchar(300) NOT NULL,
  `account` varchar(300) NOT NULL,
  `after_bal_account` varchar(200) NOT NULL,
  `from_account` varchar(200) NOT NULL,
  `to_account` varchar(200) NOT NULL,
  `after_bal_from_account` varchar(200) NOT NULL,
  `after_bal_to_account` varchar(200) NOT NULL,
  `transaction_date` date NOT NULL,
  `description` varchar(2000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `firstname` varchar(200) NOT NULL,
  `lastname` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `mobile` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `firstname`, `lastname`, `email`, `mobile`) VALUES
(1, 'du', 'c4ca4238a0b923820dcc509a6f75849b', 'dummy', 'user', 'du@du.com', '9894130821'),
(2, 'mrram', '6048ff4e8cb07aa60b6777b6f7384d52', 'Ramasamy', 'Muthuraman', 'prof.ramasamy@gmail.com', '9442970857');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `du_accounts`
--
ALTER TABLE `du_accounts`
  ADD PRIMARY KEY (`acc_id`);

--
-- Indexes for table `du_categories`
--
ALTER TABLE `du_categories`
  ADD PRIMARY KEY (`cat_id`);

--
-- Indexes for table `du_transactions`
--
ALTER TABLE `du_transactions`
  ADD PRIMARY KEY (`tra_id`);

--
-- Indexes for table `mrram_accounts`
--
ALTER TABLE `mrram_accounts`
  ADD PRIMARY KEY (`acc_id`);

--
-- Indexes for table `mrram_categories`
--
ALTER TABLE `mrram_categories`
  ADD PRIMARY KEY (`cat_id`);

--
-- Indexes for table `mrram_transactions`
--
ALTER TABLE `mrram_transactions`
  ADD PRIMARY KEY (`tra_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
