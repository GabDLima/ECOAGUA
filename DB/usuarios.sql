-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 19-Set-2025 às 01:22
-- Versão do servidor: 10.4.25-MariaDB
-- versão do PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `qts`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `cpf` int(10) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(100) NOT NULL,
  `action` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`cpf`, `nome`, `email`, `senha`, `action`, `created_at`, `updated_at`, `id`) VALUES
(21321321, '321321', '3213@21321', '1234', '', '2025-09-01 23:13:27', '2025-09-01 23:13:27', 0),
(111111111, '111111111111111', '111111@1111', '1234', '', '2025-09-01 23:15:48', '2025-09-01 23:15:48', 0),
(2147483647, 'Labubu Boob Goods', 'email@gmail.com', '1234mudar*', '', '2025-09-01 23:18:07', '2025-09-01 23:18:07', 0),
(2147483647, 'Labubu da Silva', 'labubu@gmail.com', 'senha123', '', '2025-09-01 23:25:49', '2025-09-01 23:25:49', 0),
(123213213, 'awdwa', 'dwad', 'wadwadwadwad', '', '2025-09-18 00:02:32', '2025-09-18 00:02:32', 0),
(21321321, 'adcadwa', 'dwadwad@adw', 'wqewqewq', '', '2025-09-18 00:03:00', '2025-09-18 00:03:00', 0);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
