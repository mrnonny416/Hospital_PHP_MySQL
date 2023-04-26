-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 26, 2023 at 10:49 PM
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
-- Database: `hospital_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `login_log`
--

CREATE TABLE `login_log` (
  `id` int(4) NOT NULL,
  `username` varchar(20) NOT NULL,
  `login_flag` int(1) NOT NULL,
  `ip_address` varchar(15) NOT NULL,
  `last_update` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login_log`
--

INSERT INTO `login_log` (`id`, `username`, `login_flag`, `ip_address`, `last_update`) VALUES
(85, 'admin', 0, '::1', '2023-04-26 20:48:16');

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `id` int(4) NOT NULL COMMENT 'แถวข้อมูล (auto-increment)',
  `username` varchar(20) NOT NULL COMMENT 'รหัสสมาชิก',
  `password` varchar(20) NOT NULL COMMENT 'รหัสผ่าน',
  `user_level` int(1) NOT NULL COMMENT 'ระบบผู้ใช้งาน 0 = admin สูงสุด ,1 = admin ทั่วไป (staff) , 2 = user ทั่วไป ',
  `fname` varchar(20) DEFAULT NULL COMMENT 'ชื่อ',
  `lname` varchar(20) DEFAULT NULL COMMENT 'นามสกุล',
  `tel` text DEFAULT NULL COMMENT 'เบอร์โทร',
  `email` varchar(25) DEFAULT NULL COMMENT 'email',
  `address` varchar(256) DEFAULT NULL COMMENT 'ที่อยู่',
  `ref_code` varchar(30) DEFAULT NULL COMMENT 'รหัสสมาชิกผู้แนะ (ถ้ามี)',
  `ref_remark` varchar(256) DEFAULT NULL COMMENT 'หมายเหตุของผู้แนะนำ หรือเอาไว้ระบุว่าทราบข่าวการรับสมัครมาจากไหน',
  `remark` varchar(256) DEFAULT NULL COMMENT 'หมายเหตุทั่วไป (สำหรับ admin)',
  `last_update` timestamp NULL DEFAULT NULL COMMENT 'วันที่ เวลาแก้ไขล่าสุด'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='ข้อมูลสมาชิก';

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`id`, `username`, `password`, `user_level`, `fname`, `lname`, `tel`, `email`, `address`, `ref_code`, `ref_remark`, `remark`, `last_update`) VALUES
(1, 'admin', 'admin', 0, 'Admin', 'Highest', 'admin for edit all user', 'admin@localhost.com', 'Street:  148 Srinakarin Rd., Suan Luang, Suan Luang\r\nCity:   Suan Luang\r\nState/p', 'root', 'creat by root', 'create by root ', '2023-04-26 15:25:41'),
(2, 'staff', 'staff', 1, 'staff1', 'not admin', '99-999-99999', 'staff@localhost.com', 'Street:  75/1 Moo 6 Soi Ekkachai 67 Ekkachai RoadCity:  BangbonState/province/area:    BangkokPhone number  662 4153957Zip code  10150Countr', 'root', 'creat by root', 'creat by root', '2023-04-26 20:39:13'),
(3, 'user1', 'user', 2, 'user11', 'test Edit1', '00-000-000001', 'user1@localhost.com1', '1Street:  Res 119/35 Gp 9 Lakasi Village Saibangvaek Bang PaiCity:  BangkhaeState/province/area:    BangkokPhone number  (02)8653612Zip code  10160Country calling code  +66Country  Thailand', 'root1', 'creat by root1', 'creat by root1', '2023-04-26 20:30:30'),
(4, 'user2', 'user', 2, 'user21', 'test delete user1', '88-888-888881', 'user2@localhost.com1', '1Street:  1/4 Vibhavadi-RangsitCity:  Talard BangkhenState/province/area:    LaksiPhone number  02 811-0481Zip code  10210Country calling code  +66Country  Thailand', 'root', 'creat by root', 'creat by root', '2023-04-26 20:19:55'),
(6, 'admin2', 'admin', 0, 'admin2', 'test unique', '77-777-77777', 'admin2@localhost.com', 'Street:  Room No.604, Surawong Rd., BangrakCity:   BangrakState/province/area:    BangkokPhone number  66 0-2235-6417Zip code  10500Country calling code  +66Country  Thailand', 'root', 'creat by root', 'creat by root', '2023-04-26 20:44:25'),
(7, 'staff2', 'staff', 1, 'staff2', 'test unique', '66-666-66666', 'staff2@localhost.com', 'Street:  15/6 Gp 8 Suphanburi-Bangbuathong Laharn Bang Bua Thong\r\nCity:   Nonthaburi\r\nState/province/area:    Nonthaburi\r\nPhone number  02925566141\r\nZip code  11110\r\nCountry calling code  +66\r\nCountry  Thailand', 'root', 'creat by root', 'creat by root', '2023-04-26 15:55:40');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `login_log`
--
ALTER TABLE `login_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `login_log`
--
ALTER TABLE `login_log`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT COMMENT 'แถวข้อมูล (auto-increment)', AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
