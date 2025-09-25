-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 25/09/2025 às 20:16
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
  `data_consumo` date NOT NULL,
  `quantidade` double NOT NULL,
  `unidade` varchar(80) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `tipo` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `consumo_diario`
--

INSERT INTO `consumo_diario` (`id`, `data_consumo`, `quantidade`, `unidade`, `id_usuario`, `tipo`) VALUES
(1, '2025-09-19', 25, 'L', 7, 'Louça'),
(2, '2025-09-21', 0.1, 'm³', 7, 'Banho'),
(3, '2025-09-25', 30, 'L', 7, 'Louça'),
(4, '2025-09-25', 10000, 'mL', 7, 'Faxina');

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

-- --------------------------------------------------------

--
-- Estrutura para tabela `meta_consumo`
--

CREATE TABLE `meta_consumo` (
  `id` int(11) NOT NULL,
  `meta_mensal` int(11) NOT NULL,
  `meta_reducao` int(11) NOT NULL,
  `prazo` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `meta_consumo`
--

INSERT INTO `meta_consumo` (`id`, `meta_mensal`, `meta_reducao`, `prazo`, `usuario_id`) VALUES
(1, 10000, 15, 3, 7),
(2, 950, 5, 3, 7),
(3, 500, 10, 2, 7);

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `routes`
--

INSERT INTO `routes` (`id`, `nome_rota`, `slug`, `controller`, `action`, `status`, `created_at`, `updated_at`, `is_dynamic`, `pattern`) VALUES
(1, 'Site_Login', '', 'SiteController', 'login', 1, '2025-08-16 04:53:06', '2025-08-22 04:50:27', 0, NULL),
(2, 'Site_Menu', 'menu', 'SiteController', 'menu', 1, '2025-08-16 04:53:33', '2025-08-22 04:49:09', 0, NULL),
(3, 'Site_Dashboard', 'dashboard', 'SiteController', 'dashboard', 1, '2025-08-22 04:47:04', '2025-08-22 04:49:58', 0, NULL),
(4, 'Site_Consumo', 'consumo', 'SiteController', 'consumo', 1, '2025-08-22 04:51:01', '2025-08-22 04:51:01', 0, NULL),
(5, 'Site_senha', 'redefinirSenha', 'SiteController', 'redefinirSenha', 1, '2025-08-24 00:45:23', '2025-08-24 00:45:23', 0, NULL),
(6, 'InserirUsuario', 'inserirusuario', 'UsuarioController', 'inserirUsuario', 1, '2025-08-29 02:00:47', '2025-09-02 02:23:06', 0, NULL),
(7, 'InserirValordaConta', 'InserirValordaConta', 'ConsumoController', 'inserirValordaConta', 1, '2025-09-02 02:33:28', '2025-09-02 03:36:38', 0, NULL),
(8, 'InserirMetaConsumo', 'inserirmetaconsumo', 'ConsumoController', 'inserirMetaConsumo', 1, '2025-09-18 03:23:58', '2025-09-18 03:23:58', 0, NULL),
(9, 'InserirConsumoDiario', 'inserirconsumodiario', 'ConsumoController', 'inserirConsumoDiario', 1, '2025-09-19 01:19:43', '2025-09-19 01:19:43', 0, NULL),
(10, 'Login', 'login', 'UsuarioController', 'login', 1, '2025-09-19 02:10:33', '2025-09-19 02:10:33', 0, NULL),
(11, 'Sair', 'sair', 'UsuarioController', 'logout', 1, '2025-09-22 15:41:16', '2025-09-22 15:41:16', 0, NULL),
(12, 'EditarUsuario', 'editarusuario', 'UsuarioController', 'editar', 1, '2025-09-23 02:23:06', '2025-09-23 02:23:06', 0, NULL),
(13, 'AlteraSenha', 'alterasenha', 'UsuarioController', 'alteraSenha', 1, '2025-09-23 03:26:26', '2025-09-23 03:26:26', 0, NULL),
(14, 'Site_Metas', 'metas', 'SiteController', 'metas', 1, '2025-09-23 03:32:08', '2025-09-23 03:32:08', 0, NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `cpf` bigint(10) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(100) NOT NULL,
  `action` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`cpf`, `nome`, `email`, `senha`, `action`, `created_at`, `updated_at`, `id`) VALUES
(38961251090, 'Labubu Boob Goods', 'email@gmail.com', '1234mudar*', '', '2025-09-02 02:18:07', '2025-09-25 18:00:11', 1),
(81508590044, 'Labubu da Silva', 'labubu@gmail.com', 'senha123', '', '2025-09-02 02:25:49', '2025-09-25 18:00:26', 2),
(49870041000, 'João Jão', 'joao@jao.com', '123mudar*', '', '2025-09-19 19:05:39', '2025-09-25 18:00:36', 3),
(8738340038, 'Nome Sobrenome', 'nome.sobre@gmail.com', 'nome12345', '', '2025-09-25 18:01:17', '2025-09-25 18:03:16', 4);

-- --------------------------------------------------------

--
-- Estrutura para tabela `valordaconta`
--

CREATE TABLE `valordaconta` (
  `id` int(11) NOT NULL,
  `mes_da_fatura` date NOT NULL,
  `valor` float NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `valordaconta`
--

INSERT INTO `valordaconta` (`id`, `mes_da_fatura`, `valor`, `id_usuario`) VALUES
(1, '2025-03-01', 230.7, 2),
(2, '2025-03-01', 752.12, 3),
(3, '2025-04-01', 117, 2),
(4, '2025-04-01', 143.98, 4),
(5, '2025-04-01', 168.31, 2),
(6, '2025-05-01', 151.76, 2);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `consumo_diario`
--
ALTER TABLE `consumo_diario`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `dicas`
--
ALTER TABLE `dicas`
  ADD PRIMARY KEY (`ID_DICAS`);

--
-- Índices de tabela `meta_consumo`
--
ALTER TABLE `meta_consumo`
  ADD PRIMARY KEY (`id`);

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
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `valordaconta`
--
ALTER TABLE `valordaconta`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `consumo_diario`
--
ALTER TABLE `consumo_diario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de tabela `dicas`
--
ALTER TABLE `dicas`
  MODIFY `ID_DICAS` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de tabela `meta_consumo`
--
ALTER TABLE `meta_consumo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `routes`
--
ALTER TABLE `routes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de tabela `valordaconta`
--
ALTER TABLE `valordaconta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
