-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 27, 2025 at 04:56 PM
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
-- Database: `site`
--

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `token` varchar(255) NOT NULL,
  `expira` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`id`, `user_id`, `token`, `expira`) VALUES
(1, 1, '0b2523c3a70363923ccc09055058287856e1e3d176b68ecbfa8d953bf75c701b3757d5bfba0919c6f5eff60eca91f665c703', '2025-08-27 17:45:46'),
(2, 1, '513be17f2d5fb48478bca91cd6d3c1105690963d15a5695d5099dd2a1de2f106dfaddb1b9e9640189660e5134c2a224c12e9', '2025-08-27 17:45:48'),
(3, 1, 'eed21b756970cb813839dbffba7950775b17a47a43cca9e7806fe6dc32d7d87105c4832414e5d506a06a7606f0f38b57c1a5', '2025-08-27 17:45:50'),
(4, 1, '6181f5301fb20f1b31eded3212014149a6ac1c9734070705dd6cfa71de55d5485206bdb48a73d7b9be6866b676eb7fd03f59', '2025-08-27 17:45:52'),
(5, 1, 'c29daa4221a6ecd27c2de61dc49d8f6400ff20e22fb9c8dcba312dd5fa423b5e624cd6a6a8283e72595d63113b538a1b65d1', '2025-08-27 17:45:54'),
(6, 1, '3ca99c0e78f72adc8dc1cf9ed7bb6c702e5b8d9b3a4ba4690bef28d4ec2f6087bc6a90d4e73574636f56eba8675884d4810b', '2025-08-27 17:45:56'),
(7, 1, '79aedc41cc7747c6c027108abe8b53b959a687f79046958637b5b93f632415a64fb8ba10bbdd0ef6c754819f3a8ee359e602', '2025-08-27 17:45:58'),
(8, 1, '3137ed965a860f99363b1c5abbfafc4756044e613c6936ddaf8510c4b502a08df4e13d30ec6e70ae96984c7967aa6d9e4c8b', '2025-08-27 17:46:00'),
(9, 1, 'fe9da8318c4b62d3256e4d075c3e0f5eca7f6c59cec575c69ee25e049fd0660ec62d223e0bd16113fb5b546530c0a2d15e7b', '2025-08-27 17:46:02'),
(10, 1, 'c35146295d7eb71841956b318efbe235db301c539c8e1f3bedd6bfbf7d149df6e0294835def765c7e629dc1d8ad80e361957', '2025-08-27 17:46:05'),
(11, 1, 'f9c605baf5996cf56ae110e7ef53e3c83d6e11d7e9eeeb6851cea88dc66e2df414c3fa12aa76c51ff2c7f3d6bf613eb0448b', '2025-08-27 17:46:07'),
(12, 1, 'b6bf0f272d00c5cf2161a262244abc7aa7634bf3605c64924fc408e4b3409cf3a1bba4ecee9376c24e5e5c10336ca85798ae', '2025-08-27 17:46:19'),
(13, 1, '9d9fd5ade7229d10aaa4ccb7b6f510dcfc572e0412519a1febfc35bd4c9f5748b72f16093fc0de62cd24ea549e33b08e3c8f', '2025-08-27 17:46:21');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD CONSTRAINT `password_resets_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
