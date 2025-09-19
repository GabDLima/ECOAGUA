-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 20-Set-2025 às 00:36
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
-- Estrutura da tabela `valordaconta`
--

CREATE TABLE `valordaconta` (
  `id` int(11) NOT NULL,
  `mes_da_fatura` date NOT NULL,
  `valor` float NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `valordaconta`
--

INSERT INTO `valordaconta` (`id`, `mes_da_fatura`, `valor`, `id_usuario`) VALUES
(1, '0000-00-00', 123, 0),
(2, '0000-00-00', 2131, 0),
(3, '0000-00-00', 123, 0),
(4, '0000-00-00', 1241, 0),
(5, '0000-00-00', 123, 0),
(6, '0000-00-00', 123, 0),
(7, '0000-00-00', 513, 0),
(8, '0000-00-00', 123, 0),
(9, '0000-00-00', 31, 0),
(10, '0000-00-00', 12, 0),
(11, '0000-00-00', 123, 0),
(12, '0000-00-00', 123, 0),
(13, '0000-00-00', 123, 0),
(14, '0001-01-01', 123, 0),
(15, '0000-00-00', 123, 0),
(16, '0000-00-00', 123, 0),
(17, '2025-03-01', 123, 0),
(18, '2016-02-01', 123, 0),
(19, '2018-07-01', 12, 0),
(20, '2025-11-01', 12.4, 0);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `valordaconta`
--
ALTER TABLE `valordaconta`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `valordaconta`
--
ALTER TABLE `valordaconta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
