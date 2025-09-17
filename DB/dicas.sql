-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 17/09/2025 às 02:43
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

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
-- Estrutura para tabela `dicas`
--

CREATE TABLE `dicas` (
  `ID_DICAS` int(11) NOT NULL,
  `DICAS_DESC` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `dicas`
--

INSERT INTO `dicas` (`ID_DICAS`, `DICAS_DESC`) VALUES
(1, 'Beba água regularmente'),
(2, 'Pratique exercícios diariamente'),
(3, 'Faça pausas durante o trabalho'),
(4, 'Apague as luzes ao sair de um cômodo'),
(5, 'Desligue aparelhos eletrônicos em standby'),
(6, 'Prefira transporte público ou bicicleta'),
(7, 'Planeje suas refeições da semana'),
(8, 'Evite compras por impulso'),
(9, 'Reaproveite sobras de alimentos'),
(10, 'Use sacolas reutilizáveis'),
(11, 'Compre produtos em promoção'),
(12, 'Evite desperdício de água no banho'),
(13, 'Lave roupas em carga cheia da máquina'),
(14, 'Aproveite luz natural durante o dia'),
(15, 'Compare preços antes de comprar online'),
(16, 'Utilize cupons de desconto sempre que possível'),
(17, 'Prefira marcas genéricas para produtos básicos'),
(18, 'Faça manutenção preventiva de eletrodomésticos'),
(19, 'Cozinhe mais em casa e evite delivery frequente'),
(20, 'Organize seu orçamento mensal e acompanhe os gastos'),
(21, 'Evite usar cartão de crédito sem planejamento'),
(22, 'Venda ou doe roupas e objetos que não usa mais'),
(23, 'Evite desperdício de alimentos vencidos'),
(24, 'Aproveite promoções de supermercado com planejamento'),
(25, 'Use lâmpadas de LED'),
(26, 'Evite tomar banhos longos'),
(27, 'Desligue o chuveiro ao ensaboar-se'),
(28, 'Congele alimentos que não vai consumir imediatamente'),
(29, 'Evite usar ar-condicionado em temperatura muito baixa'),
(30, 'Faça compras de atacado para itens de uso frequente');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `dicas`
--
ALTER TABLE `dicas`
  ADD PRIMARY KEY (`ID_DICAS`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `dicas`
--
ALTER TABLE `dicas`
  MODIFY `ID_DICAS` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
