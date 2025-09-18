-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 19-Set-2025 às 01:23
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
-- Estrutura da tabela `consumo_diario`
--

CREATE TABLE `consumo_diario` (
  `id` int(11) NOT NULL,
  `data_consumo` date NOT NULL,
  `quantidade` double NOT NULL,
  `unidade` varchar(80) NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `consumo_diario`
--

INSERT INTO `consumo_diario` (`id`, `data_consumo`, `quantidade`, `unidade`, `id_usuario`) VALUES
(1, '2025-09-10', 123, 'm³', 0),
(2, '2004-10-01', 123, 'L', 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `dicas`
--

CREATE TABLE `dicas` (
  `ID_DICAS` int(11) NOT NULL,
  `DICAS_DESC` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `dicas`
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
-- Estrutura da tabela `meta_consumo`
--

CREATE TABLE `meta_consumo` (
  `id` int(11) NOT NULL,
  `meta_mensal` int(11) NOT NULL,
  `meta_reducao` int(11) NOT NULL,
  `prazo` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `meta_consumo`
--

INSERT INTO `meta_consumo` (`id`, `meta_mensal`, `meta_reducao`, `prazo`, `usuario_id`) VALUES
(1, 123, 123, 213, 0),
(2, 215125, 215315325, 21, 0);

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
(9, 'InserirConsumoDiario', 'inserirconsumodiario', 'ConsumoController', 'inserirConsumoDiario', 1, '2025-09-18 22:19:43', '2025-09-18 22:19:43', 0, NULL),
(10, 'Login', 'login', 'UsuarioController', 'login', 1, '2025-09-18 23:10:33', '2025-09-18 23:10:33', 0, NULL);

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

-- --------------------------------------------------------

--
-- Estrutura da tabela `valordaconta`
--

CREATE TABLE `valordaconta` (
  `id` int(11) NOT NULL,
  `mes_da_fatura` date NOT NULL,
  `valor` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `valordaconta`
--

INSERT INTO `valordaconta` (`id`, `mes_da_fatura`, `valor`) VALUES
(1, '0000-00-00', 123),
(2, '0000-00-00', 2131),
(3, '0000-00-00', 123),
(4, '0000-00-00', 1241),
(5, '0000-00-00', 123),
(6, '0000-00-00', 123),
(7, '0000-00-00', 513),
(8, '0000-00-00', 123),
(9, '0000-00-00', 31),
(10, '0000-00-00', 12),
(11, '0000-00-00', 123),
(12, '0000-00-00', 123),
(13, '0000-00-00', 123),
(14, '0001-01-01', 123),
(15, '0000-00-00', 123),
(16, '0000-00-00', 123),
(17, '2025-03-01', 123),
(18, '2016-02-01', 123),
(19, '2018-07-01', 12),
(20, '2025-11-01', 12.4);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `consumo_diario`
--
ALTER TABLE `consumo_diario`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `dicas`
--
ALTER TABLE `dicas`
  ADD PRIMARY KEY (`ID_DICAS`);

--
-- Índices para tabela `meta_consumo`
--
ALTER TABLE `meta_consumo`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `routes`
--
ALTER TABLE `routes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`(191));

--
-- Índices para tabela `valordaconta`
--
ALTER TABLE `valordaconta`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `consumo_diario`
--
ALTER TABLE `consumo_diario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `dicas`
--
ALTER TABLE `dicas`
  MODIFY `ID_DICAS` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de tabela `meta_consumo`
--
ALTER TABLE `meta_consumo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `routes`
--
ALTER TABLE `routes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `valordaconta`
--
ALTER TABLE `valordaconta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
