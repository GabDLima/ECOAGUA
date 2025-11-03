-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 03/11/2025 às 17:12
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
-- Estrutura para tabela `consumo_diario`
--

CREATE TABLE `consumo_diario` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `data_consumo` date NOT NULL,
  `quantidade` decimal(10,2) NOT NULL,
  `unidade` varchar(10) NOT NULL DEFAULT 'L',
  `tipo` varchar(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `dicas`
--

CREATE TABLE `dicas` (
  `ID_DICAS` int(11) NOT NULL,
  `DICAS_DESC` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `meta_consumo`
--

CREATE TABLE `meta_consumo` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `meta_mensal` int(11) NOT NULL,
  `meta_reducao` int(11) NOT NULL COMMENT 'Percentual de redução (%)',
  `prazo` int(11) NOT NULL COMMENT 'Prazo em meses',
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `routes`
--

CREATE TABLE `routes` (
  `id` int(11) NOT NULL,
  `nome_rota` varchar(100) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `controller` varchar(255) NOT NULL,
  `action` varchar(255) NOT NULL,
  `status` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `is_dynamic` tinyint(1) DEFAULT 0,
  `pattern` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `routes`
--

INSERT INTO `routes` (`id`, `nome_rota`, `slug`, `controller`, `action`, `status`, `created_at`, `updated_at`, `is_dynamic`, `pattern`) VALUES
(1, 'Site_Login', '', 'SiteController', 'login', 1, '2025-08-16 07:53:06', '2025-08-22 07:50:27', 0, NULL),
(2, 'Site_Menu', 'menu', 'SiteController', 'menu', 1, '2025-08-16 07:53:33', '2025-08-22 07:49:09', 0, NULL),
(3, 'Site_Dashboard', 'dashboard', 'SiteController', 'dashboard', 1, '2025-08-22 07:47:04', '2025-08-22 07:49:58', 0, NULL),
(4, 'Site_Consumo', 'consumo', 'SiteController', 'consumo', 1, '2025-08-22 07:51:01', '2025-08-22 07:51:01', 0, NULL),
(5, 'Site_senha', 'redefinirSenha', 'SiteController', 'redefinirSenha', 1, '2025-08-24 03:45:23', '2025-08-24 03:45:23', 0, NULL),
(6, 'InserirUsuario', 'inserirusuario', 'UsuarioController', 'inserirUsuario', 1, '2025-08-29 05:00:47', '2025-09-02 05:23:06', 0, NULL),
(7, 'InserirValordaConta', 'InserirValordaConta', 'ConsumoController', 'inserirValordaConta', 1, '2025-09-02 05:33:28', '2025-09-02 06:36:38', 0, NULL),
(8, 'InserirMetaConsumo', 'inserirmetaconsumo', 'ConsumoController', 'inserirMetaConsumo', 1, '2025-09-18 06:23:58', '2025-09-18 06:23:58', 0, NULL),
(9, 'InserirConsumoDiario', 'inserirconsumodiario', 'ConsumoController', 'inserirConsumoDiario', 1, '2025-09-19 04:19:43', '2025-09-19 04:19:43', 0, NULL),
(10, 'Login', 'login', 'UsuarioController', 'login', 1, '2025-09-19 05:10:33', '2025-09-19 05:10:33', 0, NULL),
(11, 'Sair', 'sair', 'UsuarioController', 'logout', 1, '2025-09-22 18:41:16', '2025-09-22 18:41:16', 0, NULL),
(12, 'EditarUsuario', 'editarusuario', 'UsuarioController', 'editar', 1, '2025-09-23 05:23:06', '2025-09-23 05:23:06', 0, NULL),
(13, 'AlteraSenha', 'alterasenha', 'UsuarioController', 'alteraSenha', 1, '2025-09-23 06:26:26', '2025-09-23 06:26:26', 0, NULL),
(14, 'Site_Metas', 'metas', 'SiteController', 'metas', 1, '2025-09-23 06:32:08', '2025-09-23 06:32:08', 0, NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `cpf` varchar(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL COMMENT 'Deve usar password_hash()',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `cpf`, `nome`, `email`, `senha`, `created_at`, `updated_at`) VALUES
(8, '46486226854', 'João Gabriel', 'gabdlima@outlook.com', '123@mudar', '2025-11-03 16:12:10', '2025-11-03 16:12:10');

-- --------------------------------------------------------

--
-- Estrutura para tabela `valordaconta`
--

CREATE TABLE `valordaconta` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `mes_da_fatura` date NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `consumo_diario`
--
ALTER TABLE `consumo_diario`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_usuario` (`id_usuario`),
  ADD KEY `idx_data` (`data_consumo`),
  ADD KEY `idx_usuario_data` (`id_usuario`,`data_consumo`);

--
-- Índices de tabela `dicas`
--
ALTER TABLE `dicas`
  ADD PRIMARY KEY (`ID_DICAS`);

--
-- Índices de tabela `meta_consumo`
--
ALTER TABLE `meta_consumo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_usuario` (`id_usuario`);

--
-- Índices de tabela `routes`
--
ALTER TABLE `routes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`(191));

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cpf_unique` (`cpf`),
  ADD UNIQUE KEY `email_unique` (`email`),
  ADD KEY `idx_email` (`email`);

--
-- Índices de tabela `valordaconta`
--
ALTER TABLE `valordaconta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_usuario` (`id_usuario`),
  ADD KEY `idx_mes` (`mes_da_fatura`),
  ADD KEY `idx_usuario_mes` (`id_usuario`,`mes_da_fatura`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `consumo_diario`
--
ALTER TABLE `consumo_diario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `dicas`
--
ALTER TABLE `dicas`
  MODIFY `ID_DICAS` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de tabela `meta_consumo`
--
ALTER TABLE `meta_consumo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `routes`
--
ALTER TABLE `routes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `valordaconta`
--
ALTER TABLE `valordaconta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `consumo_diario`
--
ALTER TABLE `consumo_diario`
  ADD CONSTRAINT `fk_consumo_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `meta_consumo`
--
ALTER TABLE `meta_consumo`
  ADD CONSTRAINT `fk_meta_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `valordaconta`
--
ALTER TABLE `valordaconta`
  ADD CONSTRAINT `fk_fatura_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
