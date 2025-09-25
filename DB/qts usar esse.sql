-- Banco de dados unificado qts_merged
CREATE DATABASE IF NOT EXISTS qts_merged DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
USE qts_merged;

-- --------------------------------------------------------
-- Estrutura da tabela consumo_diario
-- --------------------------------------------------------
CREATE TABLE `consumo_diario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `data_consumo` date NOT NULL,
  `quantidade` double NOT NULL,
  `unidade` varchar(80) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `tipo` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dados de qts.sql
INSERT INTO `consumo_diario` (`id`,`data_consumo`,`quantidade`,`unidade`,`id_usuario`,`tipo`) VALUES
(1,'2025-09-10',123,'m³',0,''),
(2,'2004-10-01',123,'L',0,''),
(3,'2025-09-03',12,'m³',9,'');

-- Dados de qts (1).sql
INSERT INTO `consumo_diario` (`id`,`data_consumo`,`quantidade`,`unidade`,`id_usuario`,`tipo`) VALUES
(7,'2025-09-22',13.5,'L',8,'Casa');

-- --------------------------------------------------------
-- Estrutura da tabela dicas
-- --------------------------------------------------------
CREATE TABLE `dicas` (
  `ID_DICAS` int(11) NOT NULL AUTO_INCREMENT,
  `DICAS_DESC` varchar(255) NOT NULL,
  PRIMARY KEY (`ID_DICAS`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dados (iguais nos dois, só inserir uma vez)
INSERT INTO `dicas` (`ID_DICAS`,`DICAS_DESC`) VALUES
(1,'Beba água regularmente'),
(2,'Pratique exercícios diariamente'),
(3,'Faça pausas durante o trabalho'),
(4,'Apague as luzes ao sair de um cômodo'),
(5,'Desligue aparelhos eletrônicos em standby'),
(6,'Prefira transporte público ou bicicleta'),
(7,'Planeje suas refeições da semana'),
(8,'Evite compras por impulso'),
(9,'Reaproveite sobras de alimentos'),
(10,'Use sacolas reutilizáveis'),
(11,'Compre produtos em promoção'),
(12,'Evite desperdício de água no banho'),
(13,'Lave roupas em carga cheia da máquina'),
(14,'Aproveite luz natural durante o dia'),
(15,'Compare preços antes de comprar online'),
(16,'Utilize cupons de desconto sempre que possível'),
(17,'Prefira marcas genéricas para produtos básicos'),
(18,'Faça manutenção preventiva de eletrodomésticos'),
(19,'Cozinhe mais em casa e evite delivery frequente'),
(20,'Organize seu orçamento mensal e acompanhe os gastos'),
(21,'Evite usar cartão de crédito sem planejamento'),
(22,'Venda ou doe roupas e objetos que não usa mais'),
(23,'Evite desperdício de alimentos vencidos'),
(24,'Aproveite promoções de supermercado com planejamento'),
(25,'Use lâmpadas de LED'),
(26,'Evite tomar banhos longos'),
(27,'Desligue o chuveiro ao ensaboar-se'),
(28,'Congele alimentos que não vai consumir imediatamente'),
(29,'Evite usar ar-condicionado em temperatura muito baixa'),
(30,'Faça compras de atacado para itens de uso frequente');

-- --------------------------------------------------------
-- Estrutura da tabela meta_consumo
-- --------------------------------------------------------
CREATE TABLE `meta_consumo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `meta_mensal` int(11) NOT NULL,
  `meta_reducao` int(11) NOT NULL,
  `prazo` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dados (iguais, só inserir uma vez)
INSERT INTO `meta_consumo` (`id`,`meta_mensal`,`meta_reducao`,`prazo`,`usuario_id`) VALUES
(1,123,123,213,0),
(2,215125,215315325,21,0),
(3,12,12,12,9);

-- --------------------------------------------------------
-- Estrutura da tabela routes
-- --------------------------------------------------------
CREATE TABLE `routes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome_rota` varchar(100) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `controller` varchar(255) NOT NULL,
  `action` varchar(255) NOT NULL,
  `status` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `is_dynamic` tinyint(1) DEFAULT 0,
  `pattern` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`(191))
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dados até id 13 (mantendo qts (1).sql e adicionando os 2 extras de qts (1).sql)
INSERT INTO `routes` (`id`,`nome_rota`,`slug`,`controller`,`action`,`status`,`created_at`,`updated_at`,`is_dynamic`,`pattern`) VALUES
(1,'Site_Login','', 'SiteController','login',1,'2025-08-16 01:53:06','2025-08-22 01:50:27',0,NULL),
(2,'Site_Menu','menu','SiteController','menu',1,'2025-08-16 01:53:33','2025-08-22 01:49:09',0,NULL),
(3,'Site_Dashboard','dashboard','SiteController','dashboard',1,'2025-08-22 01:47:04','2025-08-22 01:49:58',0,NULL),
(4,'Site_Consumo','consumo','SiteController','consumo',1,'2025-08-22 01:51:01','2025-08-22 01:51:01',0,NULL),
(5,'Site_senha','redefinirSenha','SiteController','redefinirSenha',1,'2025-08-23 21:45:23','2025-08-23 21:45:23',0,NULL),
(6,'InserirUsuario','inserirusuario','UsuarioController','inserirUsuario',1,'2025-08-28 23:00:47','2025-09-01 23:23:06',0,NULL),
(7,'InserirValordaConta','InserirValordaConta','ConsumoController','inserirValordaConta',1,'2025-09-01 23:33:28','2025-09-02 00:36:38',0,NULL),
(8,'InserirMetaConsumo','inserirmetaconsumo','ConsumoController','inserirMetaConsumo',1,'2025-09-18 00:23:58','2025-09-18 00:23:58',0,NULL),
(9,'InserirConsumoDiario','inserirconsumodiario','ConsumoController','inserirConsumoDiario',1,'2025-09-18 22:19:43','2025-09-18 22:19:43',0,NULL),
(10,'Login','login','UsuarioController','login',1,'2025-09-18 23:10:33','2025-09-18 23:10:33',0,NULL),
(11,'Sair','sair','UsuarioController','logout',1,'2025-09-22 12:41:16','2025-09-22 12:41:16',0,NULL),
(12,'EditarUsuario','editarusuario','UsuarioController','editar',1,'2025-09-22 23:23:06','2025-09-22 23:23:06',0,NULL),
(13,'AlteraSenha','alterasenha','UsuarioController','alteraSenha',1,'2025-09-23 00:26:26','2025-09-23 00:26:26',0,NULL),
(14, 'Site_Metas', 'metas', 'SiteController', 'metas', 1, '2025-09-23 00:32:08', '2025-09-23 00:32:08', 0, NULL);

-- --------------------------------------------------------
-- Estrutura da tabela usuarios
-- --------------------------------------------------------
CREATE TABLE `usuarios` (
  `cpf` BIGINT(10) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(100) NOT NULL,
  `action` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dados qts.sql primeiro
INSERT INTO `usuarios` (`cpf`,`nome`,`email`,`senha`,`action`,`created_at`,`updated_at`,`id`) VALUES
(21321321,'321321','3213@21321','1234','', '2025-09-01 23:13:27','2025-09-01 23:13:27',1),
(111111111,'111111111111111','111111@1111','1234','', '2025-09-01 23:15:48','2025-09-01 23:15:48',2),
(2147483647,'Labubu Boob Goods','email@gmail.com','1234mudar*','', '2025-09-01 23:18:07','2025-09-01 23:18:07',3),
(2147483647,'Labubu da Silva','labubu@gmail.com','senha123','', '2025-09-01 23:25:49','2025-09-01 23:25:49',4),
(123213213,'awdwa','dwad','wadwadwadwad','', '2025-09-18 00:02:32','2025-09-18 00:02:32',5),
(21321321,'adcadwa','dwadwad@adw','wqewqewq','', '2025-09-18 00:03:00','2025-09-18 00:03:00',6),
(123,'123','77@gmai.com','123mudar*','', '2025-09-19 16:05:39','2025-09-19 16:05:39',7),
(213,'123','123','123','', '2025-09-19 16:06:03','2025-09-19 16:06:03',8),
(123,'123','123@gmail.com','123','', '2025-09-19 16:09:02','2025-09-19 16:09:02',9);

-- Dados qts (1).sql depois
INSERT INTO `usuarios` (`cpf`,`nome`,`email`,`senha`,`action`,`created_at`,`updated_at`,`id`) VALUES
(123213213,'awdwa','dwad','321321','', '2025-09-18 00:02:32','2025-09-23 00:36:01',5),
(21321321,'João Jão João','joao@joao.com','','','2025-09-18 00:03:00','2025-09-23 00:33:29',6),
(123,'João Jão','joao@jao.com','123mudar*','', '2025-09-19 16:05:39','2025-09-23 00:11:29',7),
(2147483647,'Nome Completo Plus','gmail@joao.com','senha123','', '2025-09-23 00:42:03','2025-09-23 00:43:55',10),
(2147483647,'Joao Joao de Joao','joao@joaomail.com','123mudar*','', '2025-09-23 00:45:48','2025-09-23 00:45:48',11);

-- --------------------------------------------------------
-- Estrutura da tabela valordaconta
-- --------------------------------------------------------
CREATE TABLE `valordaconta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mes_da_fatura` date NOT NULL,
  `valor` float NOT NULL,
  `id_usuario` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dados qts.sql
INSERT INTO `valordaconta` (`id`,`mes_da_fatura`,`valor`,`id_usuario`) VALUES
(1,'0000-00-00',123,0),
(2,'0000-00-00',2131,0),
(3,'0000-00-00',123,0),
(4,'0000-00-00',1241,0),
(5,'0000-00-00',123,0),
(6,'0000-00-00',123,0),
(7,'0000-00-00',513,0),
(8,'0000-00-00',123,0),
(9,'0000-00-00',31,0),
(10,'0000-00-00',12,0),
(11,'0000-00-00',123,0),
(12,'0000-00-00',123,0),
(13,'0000-00-00',123,0),
(14,'0001-01-01',123,0),
(15,'0000-00-00',123,0),
(16,'0000-00-00',123,0),
(17,'2025-03-01',123,0),
(18,'2016-02-01',123,0),
(19,'2018-07-01',12,0),
(20,'2025-11-01',12.4,0),
(21,'2025-08-01',23,9);

-- Dados qts (1).sql depois
INSERT INTO `valordaconta` (`id`,`mes_da_fatura`,`valor`,`id_usuario`) VALUES
(22,'2025-07-01',123,10);
