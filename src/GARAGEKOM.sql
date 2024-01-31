-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 22, 2024 at 12:41 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `GARAGEKOM`
--

-- --------------------------------------------------------

--
-- Table structure for table `cars`
--

CREATE TABLE `cars` (
  `car_id` int(11) NOT NULL,
  `car_registration` varchar(255) NOT NULL,
  `client_id` int(11) NOT NULL,
  `car_name` varchar(255) NOT NULL,
  `car_brand` varchar(255) NOT NULL,
  `car_model` year(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `client_id` int(11) NOT NULL,
  `client_name` varchar(255) NOT NULL,
  `client_email` varchar(255) NOT NULL,
  `client_phone` varchar(20) NOT NULL,
  `client_address` varchar(255) NOT NULL,
  `client_added_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `message` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `employee_id` int(11) NOT NULL,
  `employee_name` varchar(255) NOT NULL,
  `employee_address` varchar(255) NOT NULL,
  `employee_phone` varchar(20) NOT NULL,
  `employee_salary` decimal(10,2) NOT NULL,
  `employee_added_date` date NOT NULL,
  `employee_position` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`employee_id`, `employee_name`, `employee_address`, `employee_phone`, `employee_salary`, `employee_added_date`, `employee_position`) VALUES
(1, 'John Doe', '123 Main St', '123456789', 50000.00, '2022-01-01', 'Mechanic'),
(2, 'Jane Smith', '456 Oak Ave', '987654321', 60000.00, '2022-01-02', 'Manager'),
(3, 'Bob Johnson', '789 Pine Rd', '111222333', 55000.00, '2022-01-03', 'Technician'),
(4, 'Alice Williams', '101 Cedar Ln', '444555666', 52000.00, '2022-01-04', 'Mechanic'),
(5, 'David Davis', '202 Birch Blvd', '777888999', 58000.00, '2022-01-05', 'Manager'),
(6, 'Eva Wilson', '303 Elm Ct', '222333444', 53000.00, '2022-01-06', 'Technician'),
(7, 'Michael Miller', '404 Maple Dr', '555666777', 56000.00, '2022-01-07', 'Mechanic'),
(8, 'Olivia Jones', '505 Pineapple Ln', '888999000', 59000.00, '2022-01-08', 'Manager'),
(9, 'Charlie Brown', '606 Peach St', '333444555', 54000.00, '2022-01-09', 'Technician'),
(10, 'Sophie Davis', '707 Cherry Ave', '666777888', 57000.00, '2022-01-10', 'Mechanic');

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `item_id` int(11) NOT NULL,
  `item_name` varchar(255) NOT NULL,
  `item_car_name` varchar(255) NOT NULL,
  `item_brand` varchar(40) NOT NULL,
  `item_model` year(4) NOT NULL,
  `item_price` decimal(10,2) NOT NULL,
  `item_quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`item_id`, `item_name`, `item_car_name`, `item_brand`, `item_model`, `item_price`, `item_quantity`) VALUES
(1, 'Oil Filter', 'Universal', 'Brand1', '2022', 8.00, 200),
(2, 'Brake Pads', 'Universal', 'Brand2', '2021', 20.00, 150),
(3, 'Air Filter', 'Universal', 'Brand3', '2022', 12.00, 180),
(4, 'Spark Plugs', 'Universal', 'Brand4', '2021', 5.00, 250),
(5, 'Engine Oil (5L)', 'Universal', 'Brand5', '2022', 30.00, 100),
(6, 'Transmission Fluid', 'Universal', 'Brand6', '2021', 15.00, 120),
(7, 'Tire (Set of 4)', 'Universal', 'Brand7', '2022', 200.00, 50),
(8, 'Battery', 'Universal', 'Brand8', '2021', 80.00, 80),
(9, 'Wiper Blades (Pair)', 'Universal', 'Brand9', '2022', 10.00, 150),
(10, 'Coolant', 'Universal', 'Brand10', '2021', 8.00, 200);

-- --------------------------------------------------------

--
-- Table structure for table `inventory_usage`
--

CREATE TABLE `inventory_usage` (
  `usage_id` int(11) NOT NULL,
  `service_request_id` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `quantity_used` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `invoice_id` int(11) NOT NULL,
  `service_request_id` int(11) DEFAULT NULL,
  `invoice_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `total_amount` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `service_id` int(11) NOT NULL,
  `service_name` varchar(255) NOT NULL,
  `service_type` enum('Maintenance','Repair') NOT NULL,
  `service_description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`service_id`, `service_name`, `service_type`, `service_description`) VALUES
(1, 'Oil Change', 'Maintenance', 'Regular oil change service'),
(2, 'Brake Repair', 'Repair', 'Brake system inspection and repair'),
(3, 'Tire Rotation', 'Maintenance', 'Rotate and balance tires'),
(4, 'Engine Tune-up', 'Maintenance', 'Optimize engine performance'),
(5, 'Transmission Repair', 'Repair', 'Fix issues with the transmission system'),
(6, 'Diagnostic Check', 'Maintenance', 'Identify and troubleshoot car issues'),
(7, 'Battery Replacement', 'Maintenance', 'Replace old or faulty batteries'),
(8, 'Wheel Alignment', 'Maintenance', 'Align the wheels for better stability'),
(9, 'AC System Service', 'Maintenance', 'Check and service the air conditioning system'),
(10, 'Exhaust System Repair', 'Repair', 'Fix issues with the exhaust system');

-- --------------------------------------------------------

--
-- Table structure for table `service_requests`
--

CREATE TABLE `service_requests` (
  `request_id` int(11) NOT NULL,
  `client_id` int(11) DEFAULT NULL,
  `service_id` int(11) DEFAULT NULL,
  `car_id` int(11) DEFAULT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `request_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('Pending','In progress','Completed') DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `user_email`, `password_hash`, `role`) VALUES
(4, 'Noureddine DRIOUECH', 'nourddinedriouech@gmail.com', '$2y$10$ccYviIW6Z.jrZXRP1eJpYeyYV/kfRc8Z/4Jz7wb2kRndtJivzzy7C', 'admin'),
(5, 'Yassine TOUMI', 'yari1986@gmail.com', '$2y$10$S0zOYZGGFZ.ICZmYgrRg9unVPbH./T0ZMSTZTWzyrJWpC4dZ8jSne', 'mechanic');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cars`
--
ALTER TABLE `cars`
  ADD PRIMARY KEY (`car_id`),
  ADD KEY `client_id` (`client_id`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`client_id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`employee_id`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`item_id`);

--
-- Indexes for table `inventory_usage`
--
ALTER TABLE `inventory_usage`
  ADD PRIMARY KEY (`usage_id`),
  ADD KEY `service_request_id` (`service_request_id`),
  ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`invoice_id`),
  ADD KEY `service_request_id` (`service_request_id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`service_id`);

--
-- Indexes for table `service_requests`
--
ALTER TABLE `service_requests`
  ADD PRIMARY KEY (`request_id`),
  ADD KEY `client_id` (`client_id`),
  ADD KEY `service_id` (`service_id`),
  ADD KEY `employee_id` (`employee_id`),
  ADD KEY `car_id` (`car_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cars`
--
ALTER TABLE `cars`
  MODIFY `car_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `client_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `employee_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `inventory_usage`
--
ALTER TABLE `inventory_usage`
  MODIFY `usage_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `invoice_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `service_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `service_requests`
--
ALTER TABLE `service_requests`
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cars`
--
ALTER TABLE `cars`
  ADD CONSTRAINT `cars_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `clients` (`client_id`);

--
-- Constraints for table `inventory_usage`
--
ALTER TABLE `inventory_usage`
  ADD CONSTRAINT `inventory_usage_ibfk_1` FOREIGN KEY (`service_request_id`) REFERENCES `service_requests` (`request_id`),
  ADD CONSTRAINT `inventory_usage_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `inventory` (`item_id`);

--
-- Constraints for table `invoices`
--
ALTER TABLE `invoices`
  ADD CONSTRAINT `invoices_ibfk_1` FOREIGN KEY (`service_request_id`) REFERENCES `service_requests` (`request_id`);

--
-- Constraints for table `service_requests`
--
ALTER TABLE `service_requests`
  ADD CONSTRAINT `service_requests_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `clients` (`client_id`),
  ADD CONSTRAINT `service_requests_ibfk_2` FOREIGN KEY (`service_id`) REFERENCES `services` (`service_id`),
  ADD CONSTRAINT `service_requests_ibfk_3` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`employee_id`),
  ADD CONSTRAINT `service_requests_ibfk_4` FOREIGN KEY (`car_id`) REFERENCES `cars` (`car_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
