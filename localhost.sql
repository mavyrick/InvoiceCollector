-- phpMyAdmin SQL Dump
-- version 4.4.15.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 10, 2017 at 11:58 PM
-- Server version: 5.6.33-log
-- PHP Version: 7.0.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `myfr6168_dev002`
--

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE IF NOT EXISTS `invoices` (
  `invoice_date` date NOT NULL,
  `vendor` varchar(100) NOT NULL,
  `invoice_number` int(100) NOT NULL,
  `subtotal` decimal(65,0) NOT NULL,
  `pst` decimal(65,0) NOT NULL,
  `gst` decimal(65,0) NOT NULL,
  `total` decimal(65,0) NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=271 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`invoice_date`, `vendor`, `invoice_number`, `subtotal`, `pst`, `gst`, `total`, `id`) VALUES
('2005-05-05', 'Tap Shack', 2222, 500, 5, 5, 550, 131),
('2005-05-05', 'Browns Social House', 20000, 2000, 2, 2, 2080, 106),
('2005-05-05', 'Browns Social House', 2500, 200, 200, 200, 1000, 102),
('5555-05-05', 'Craft Beer Market', 500, 500, 5, 5, 550, 133),
('2005-05-05', 'La Taqueria', 2000, 100, 5, 5, 110, 116),
('2005-05-05', 'La Taqueria', 1234567, 2000, 5, 5, 2200, 149),
('2005-05-05', 'La Taqueria', 123456789, 2000, 5, 5, 2200, 151),
('2005-05-05', 'Browns Social House', 1122334455, 12345, 5, 5, 13580, 153),
('2005-05-31', 'Browns Social House', 112233445, 12345, 5, 5, 13580, 159),
('2222-02-02', 'Browns Social House', 250, 250, 5, 5, 275, 167),
('2500-05-05', 'Browns Social House', 5, 20, 5, 5, 22, 172),
('2005-05-05', 'Browns Social House', 55555, 55, 10, 10, 66, 175),
('0000-00-00', 'Browns Social House', 150000, 10000, 5, 5, 11000, 197),
('2005-05-05', 'Browns Social House', 123432112, 50, 5, 5, 55, 200),
('2005-05-05', 'Browns Social House', 25055, 50, 5, 5, 55, 202),
('2017-05-09', 'Craft Beer Market', 1000, 1000, 5, 5, 1100, 234),
('2017-05-09', 'La Mezcaleria', 1001, 1000, 5, 5, 1100, 235),
('2017-05-09', 'La Taqueria', 1002, 5000, 5, 5, 5500, 236),
('2017-05-09', 'London Bull', 1003, 5500, 5, 5, 6050, 237),
('2005-05-05', 'Browns Social House', 50, 50, 5, 5, 55, 227),
('2017-05-09', 'Musette Caffe', 1004, 4500, 5, 5, 4950, 239),
('2017-05-09', 'Nicli Antica Pizzeria', 1005, 4500, 5, 5, 4950, 240),
('2017-05-09', 'Rogue Kitchen & Wetbar', 1006, 7000, 5, 5, 7700, 241),
('2017-05-09', 'Steam Works', 1007, 2000, 5, 5, 2200, 242),
('2017-05-09', 'Tap & Barrel', 1008, 2500, 5, 5, 2750, 243),
('2017-05-09', 'Tap Shack', 1009, 2500, 5, 5, 2750, 244),
('2017-05-09', 'Wildebeest', 1015, 10000, 5, 5, 11000, 245),
('2005-05-05', 'Browns Social House', 1020, 1000, 5, 5, 1100, 249),
('2005-05-05', 'Browns Social House', 3453211, 1000, 5, 5, 1100, 250),
('2005-05-05', 'La Taqueria', 2233225, 1000, 5, 5, 1100, 251),
('2000-05-05', 'Browns Social House', 1035, 2000, 5, 5, 2200, 252),
('2005-05-05', 'Craft Beer Market', 23415, 2000, 5, 5, 2200, 253),
('2005-05-05', 'Browns Social House', 2043237, 1000, 5, 5, 1100, 254),
('2005-05-05', 'Browns Social House', 2043237777, 1000, 5, 5, 1100, 255),
('2005-05-05', 'Browns Social House', 2147483647, 1000, 5, 5, 1100, 256),
('2005-05-05', 'Browns Social House', 223344551, 500, 5, 5, 550, 257),
('2005-05-05', 'Browns Social House', 25005, 500, 5, 5, 550, 258),
('2017-05-10', 'Craft Beer Market', 1223344, 1000, 5, 5, 1100, 269),
('2005-02-10', 'Craft Beer Market', 12412123, 1000, 5, 5, 1100, 270);

-- --------------------------------------------------------

--
-- Table structure for table `test`
--

CREATE TABLE IF NOT EXISTS `test` (
  `id` int(1) NOT NULL,
  `value` text NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `test`
--

INSERT INTO `test` (`id`, `value`) VALUES
(1, 'World'),
(2, 'test1'),
(3, 'test2'),
(4, 'test3'),
(5, 'test4'),
(6, 'test5'),
(7, 'test6'),
(8, 'test7'),
(9, 'test15'),
(10, 'test9');

-- --------------------------------------------------------

--
-- Table structure for table `vendors`
--

CREATE TABLE IF NOT EXISTS `vendors` (
  `vendor_title` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vendors`
--

INSERT INTO `vendors` (`vendor_title`, `address`) VALUES
('Browns Social House', '1234 Browns Street'),
('Craft Beer Market', '1234 Craft Street'),
('La Mezcaleria', '1234 Mezcaleria Street'),
('La Taqueria', '1234 Taqueria Street'),
('London Bull', '1234 London Street'),
('Musette Caffe', '1234 Musette Street'),
('Nicli Antica Pizzeria', '1234 Nicli Street'),
('Rogue Kitchen & Wetbar', '1234 Rogue'),
('Steam Works', '1234 Steam'),
('Tap & Barrel', '1234 Tap'),
('Tap Shack', '1234 Shack'),
('Wildebeest', '1234 Wildebeest');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `invoice_number` (`invoice_number`),
  ADD UNIQUE KEY `invoice_number_2` (`invoice_number`),
  ADD UNIQUE KEY `invoice_number_3` (`invoice_number`);

--
-- Indexes for table `test`
--
ALTER TABLE `test`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vendors`
--
ALTER TABLE `vendors`
  ADD PRIMARY KEY (`vendor_title`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=271;
--
-- AUTO_INCREMENT for table `test`
--
ALTER TABLE `test`
  MODIFY `id` int(1) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
