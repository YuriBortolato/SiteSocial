-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 26, 2025 at 05:00 PM
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
-- Table structure for table `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(20) NOT NULL,
  `email` varchar(140) NOT NULL,
  `senha` varchar(20) NOT NULL,
  `nome` varchar(140) NOT NULL,
  `usuario` varchar(140) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`id`, `email`, `senha`, `nome`, `usuario`) VALUES
(1, 'test@gmail.com', 'test', 'Usuario1', 'User0'),
(2, 'gg@gg.com', '$2y$10$gKPu6BtR1yMba', 'd', 'test'),
(3, 'tomas@gmail.com', '$2y$10$tliJ0X9GRsQzS', 'tomas test', 'tomas'),
(4, 'tobias@gmail.com', '$2y$10$RsrDCGL.Q9UP2', 'tobias maicon', 'tobias'),
(5, 'Kirito@gmail.com', '$2y$10$t/wod.RYnoVvE', 'Kirito Kirigaya', 'Espadachim'),
(6, 'testa@gmail.com', '$2y$10$9o0uqjEVcqz7U', 'test', 'testa');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
