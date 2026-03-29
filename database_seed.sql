-- ============================================================
-- EcoÁgua - Database Seed
-- Gerado em: 2026-03-28
-- MySQL 8.4.7
-- ============================================================

CREATE DATABASE IF NOT EXISTS ecoagua
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_general_ci;

USE ecoagua;

-- ============================================================
-- TABELA: usuarios
-- ============================================================
CREATE TABLE IF NOT EXISTS `usuarios` (
    `id`         INT(11)      NOT NULL AUTO_INCREMENT,
    `cpf`        VARCHAR(11)  NOT NULL,
    `nome`       VARCHAR(100) NOT NULL,
    `email`      VARCHAR(100) NOT NULL,
    `senha`      VARCHAR(255) NOT NULL COMMENT 'Deve usar password_hash()',
    `dark_mode`  TINYINT(1)   DEFAULT 0 COMMENT 'Tema escuro (0=claro, 1=escuro)',
    `created_at` TIMESTAMP    NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP    NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `cpf_unique`   (`cpf`),
    UNIQUE KEY `email_unique` (`email`),
    KEY `idx_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ============================================================
-- TABELA: consumo_diario
-- ============================================================
CREATE TABLE IF NOT EXISTS `consumo_diario` (
    `id`           INT(11)        NOT NULL AUTO_INCREMENT,
    `id_usuario`   INT(11)        NOT NULL,
    `data_consumo` DATE           NOT NULL,
    `quantidade`   DECIMAL(10,2)  NOT NULL,
    `unidade`      VARCHAR(10)    NOT NULL DEFAULT 'L',
    `tipo`         VARCHAR(50)    NOT NULL,
    `created_at`   TIMESTAMP      NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_usuario`      (`id_usuario`),
    KEY `idx_data`         (`data_consumo`),
    KEY `idx_usuario_data` (`id_usuario`, `data_consumo`),
    CONSTRAINT `fk_consumo_usuario`
        FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ============================================================
-- TABELA: meta_consumo
-- ============================================================
CREATE TABLE IF NOT EXISTS `meta_consumo` (
    `id`           INT(11)   NOT NULL AUTO_INCREMENT,
    `id_usuario`   INT(11)   NOT NULL,
    `meta_mensal`  INT(11)   NOT NULL,
    `meta_reducao` INT(11)   NOT NULL COMMENT 'Percentual de redução (%)',
    `prazo`        INT(11)   NOT NULL COMMENT 'Prazo em meses',
    `created_at`   TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_usuario` (`id_usuario`),
    CONSTRAINT `fk_meta_usuario`
        FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ============================================================
-- TABELA: valordaconta
-- ============================================================
CREATE TABLE IF NOT EXISTS `valordaconta` (
    `id`             INT(11)       NOT NULL AUTO_INCREMENT,
    `id_usuario`     INT(11)       NOT NULL,
    `mes_da_fatura`  DATE          NOT NULL,
    `valor`          DECIMAL(10,2) NOT NULL,
    `created_at`     TIMESTAMP     NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_usuario`     (`id_usuario`),
    KEY `idx_mes`         (`mes_da_fatura`),
    KEY `idx_usuario_mes` (`id_usuario`, `mes_da_fatura`),
    CONSTRAINT `fk_fatura_usuario`
        FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ============================================================
-- TABELA: dicas
-- ============================================================
CREATE TABLE IF NOT EXISTS `dicas` (
    `ID_DICAS`   INT(11)      NOT NULL AUTO_INCREMENT,
    `DICAS_DESC` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`ID_DICAS`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ============================================================
-- TABELA: routes
-- ============================================================
CREATE TABLE IF NOT EXISTS `routes` (
    `id`         INT(11)      NOT NULL AUTO_INCREMENT,
    `nome_rota`  VARCHAR(100) NOT NULL,
    `slug`       VARCHAR(255) NOT NULL,
    `controller` VARCHAR(255) NOT NULL,
    `action`     VARCHAR(255) NOT NULL,
    `status`     TINYINT(1)   DEFAULT 1,
    `created_at` TIMESTAMP    NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP    NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `is_dynamic` TINYINT(1)   DEFAULT 0,
    `pattern`    VARCHAR(255) DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `slug` (`slug`(191))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ============================================================
-- DADOS: routes
-- ============================================================
INSERT INTO `routes` (`id`, `nome_rota`, `slug`, `controller`, `action`, `status`, `created_at`, `updated_at`, `is_dynamic`, `pattern`) VALUES
(1,  'Site_Login',          '',                    'SiteController',    'login',               1, '2025-08-16 07:53:06', '2025-08-22 07:50:27', 0, NULL),
(2,  'Site_Menu',           'menu',                'SiteController',    'menu',                1, '2025-08-16 07:53:33', '2025-08-22 07:49:09', 0, NULL),
(3,  'Site_Dashboard',      'dashboard',           'SiteController',    'dashboard',           1, '2025-08-22 07:47:04', '2025-08-22 07:49:58', 0, NULL),
(4,  'Site_Consumo',        'consumo',             'SiteController',    'consumo',             1, '2025-08-22 07:51:01', '2025-08-22 07:51:01', 0, NULL),
(5,  'Site_senha',          'redefinirSenha',      'SiteController',    'redefinirSenha',      1, '2025-08-24 03:45:23', '2025-08-24 03:45:23', 0, NULL),
(6,  'InserirUsuario',      'inserirusuario',      'UsuarioController', 'inserirUsuario',      1, '2025-08-29 05:00:47', '2025-09-02 05:23:06', 0, NULL),
(7,  'InserirValordaConta', 'InserirValordaConta', 'ConsumoController', 'inserirValordaConta', 1, '2025-09-02 05:33:28', '2025-09-02 06:36:38', 0, NULL),
(8,  'InserirMetaConsumo',  'inserirmetaconsumo',  'ConsumoController', 'inserirMetaConsumo',  1, '2025-09-18 06:23:58', '2025-09-18 06:23:58', 0, NULL),
(9,  'InserirConsumoDiario','inserirconsumodiario','ConsumoController', 'inserirConsumoDiario',1, '2025-09-19 04:19:43', '2025-09-19 04:19:43', 0, NULL),
(10, 'Login',               'login',               'UsuarioController', 'login',               1, '2025-09-19 05:10:33', '2025-09-19 05:10:33', 0, NULL),
(11, 'Sair',                'sair',                'UsuarioController', 'logout',              1, '2025-09-22 18:41:16', '2025-09-22 18:41:16', 0, NULL),
(12, 'EditarUsuario',       'editarusuario',       'UsuarioController', 'editar',              1, '2025-09-23 05:23:06', '2025-09-23 05:23:06', 0, NULL),
(13, 'AlteraSenha',         'alterasenha',         'UsuarioController', 'alteraSenha',         1, '2025-09-23 06:26:26', '2025-09-23 06:26:26', 0, NULL),
(14, 'Site_Metas',          'metas',               'SiteController',    'metas',               1, '2025-09-23 06:32:08', '2025-09-23 06:32:08', 0, NULL),
(15, 'ToggleDarkMode',      'toggledarkmode',      'UsuarioController', 'toggleDarkMode',      1, '2025-11-24 19:00:00', '2025-11-24 19:00:00', 0, NULL),
(16, 'Api_Login',           'api/auth/login',      'ApiController',     'login',               1, '2026-03-28 00:00:00', '2026-03-28 00:00:00', 0, NULL),
(17, 'Api_Register',        'api/auth/register',   'ApiController',     'register',            1, '2026-03-28 00:00:00', '2026-03-28 00:00:00', 0, NULL),
(18, 'Api_Consumo',         'api/consumo',         'ApiController',     'consumo',             1, '2026-03-28 00:00:00', '2026-03-28 00:00:00', 0, NULL),
(19, 'Api_Metas',           'api/metas',           'ApiController',     'metas',               1, '2026-03-28 00:00:00', '2026-03-28 00:00:00', 0, NULL),
(20, 'Api_Faturas',         'api/faturas',         'ApiController',     'faturas',             1, '2026-03-28 00:00:00', '2026-03-28 00:00:00', 0, NULL),
(21, 'Api_Dashboard',       'api/dashboard',       'ApiController',     'getDashboard',        1, '2026-03-28 00:00:00', '2026-03-28 00:00:00', 0, NULL);

-- ============================================================
-- DADOS: usuario de teste
-- senha: 123456  (hash gerado via password_hash)
-- ============================================================
INSERT INTO `usuarios` (`cpf`, `nome`, `email`, `senha`, `dark_mode`) VALUES
('00000000000', 'João Gabriel', 'joao@ecoagua.com', '$2y$10$pvBVmUXyX0eXT3o85keZjuy9yArlDOJWsF/3py0f0jO1NvNcHlqmC', 0);

-- ============================================================
-- DADOS: dicas de economia de água
-- ============================================================
INSERT INTO `dicas` (`DICAS_DESC`) VALUES
('Prefira ducha rápida de 5 minutos ao banho de banheira, que consome até 300 litros.'),
('Colete água da chuva para regar plantas e lavar áreas externas.'),
('Lave a louça com a torneira fechada, abrindo só para enxaguar.'),
('Feche a torneira ao escovar os dentes e economize até 12 litros por vez.'),
('Use a máquina de lavar roupas apenas com carga completa.'),
('Verifique regularmente se há vazamentos em torneiras e descargas.'),
('Regue as plantas no início da manhã ou final da tarde para reduzir evaporação.'),
('Instale válvula de descarga com duplo acionamento para economizar água.'),
('Reutilize a água da máquina de lavar para limpar pisos e calçadas.'),
('Use balde em vez de mangueira para dar banho nos animais de estimação.');
