-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 19-Set-2025 às 00:20
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
-- Estrutura da tabela `routes`
--

CREATE TABLE `routes` (
  `id` int(11) NOT NULL,
  `nome_rota` varchar(100) NOT NULL COMMENT 'O Nome da Rota DEVE ser Unico no Sistema!!! Não pode conter espaços no nome!!\r\n',
  `slug` varchar(255) NOT NULL,
  `controller` varchar(255) NOT NULL,
  `action` varchar(255) NOT NULL,
  `status` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `is_dynamic` tinyint(1) DEFAULT 0,
  `pattern` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `routes`
--

INSERT INTO `routes` (`id`, `nome_rota`, `slug`, `controller`, `action`, `status`, `created_at`, `updated_at`, `is_dynamic`, `pattern`) VALUES
(1, 'Site_Login', '', 'SiteController', 'login', 1, '2025-08-16 01:53:06', '2025-08-22 01:50:27', 0, NULL),
(2, 'Site_Menu', 'menu', 'SiteController', 'menu', 1, '2025-08-16 01:53:33', '2025-08-22 01:49:09', 0, NULL),
(3, 'Site_Dashboard', 'dashboard', 'SiteController', 'dashboard', 1, '2025-08-22 01:47:04', '2025-08-22 01:49:58', 0, NULL),
(4, 'Site_Consumo', 'consumo', 'SiteController', 'consumo', 1, '2025-08-22 01:51:01', '2025-08-22 01:51:01', 0, NULL),
(5, 'Site_senha', 'redefinirSenha', 'SiteController', 'redefinirSenha', 1, '2025-08-23 21:45:23', '2025-08-23 21:45:23', 0, NULL),
(6, 'InserirUsuario', 'inserirusuario', 'UsuarioController', 'inserirUsuario', 1, '2025-08-28 23:00:47', '2025-09-01 23:23:06', 0, NULL),
(7, 'InserirValordaConta', 'InserirValordaConta', 'ConsumoController', 'inserirValordaConta', 1, '2025-09-01 23:33:28', '2025-09-02 00:36:38', 0, NULL),
(8, 'InserirMetaConsumo', 'inserirmetaconsumo', 'ConsumoController', 'inserirMetaConsumo', 1, '2025-09-18 00:23:58', '2025-09-18 00:23:58', 0, NULL),
(9, 'InserirConsumoDiario', 'inserirconsumodiario', 'ConsumoController', 'inserirConsumoDiario', 1, '2025-09-18 22:19:43', '2025-09-18 22:19:43', 0, NULL);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `routes`
--
ALTER TABLE `routes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`(191));

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `routes`
--
ALTER TABLE `routes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
