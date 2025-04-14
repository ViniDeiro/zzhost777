-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Tempo de geração: 21/03/2025 às 06:53
-- Versão do servidor: 10.11.6-MariaDB-log
-- Versão do PHP: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `chinav2`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `admin_users`
--

CREATE TABLE `admin_users` (
  `id` int(11) NOT NULL,
  `nome` text NOT NULL,
  `email` text NOT NULL,
  `contato` text DEFAULT NULL,
  `senha` text NOT NULL,
  `nivel` int(11) NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 0,
  `token_recover` text DEFAULT NULL,
  `avatar` text DEFAULT NULL,
  `2fa` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `admin_users`
--

INSERT INTO `admin_users` (`id`, `nome`, `email`, `contato`, `senha`, `nivel`, `status`, `token_recover`, `avatar`, `2fa`) VALUES
(1, 'EXPFY', 'contato@expfy.com.br', NULL, '$2y$10$mLL0tIwc.41Bacy72EQBtOAqOC4WMvjGbT/iSqgdUybEq/9plScdq', 0, 1, NULL, NULL, '123321');

-- --------------------------------------------------------

--
-- Estrutura para tabela `afiliados_config`
--

CREATE TABLE `afiliados_config` (
  `id` int(11) NOT NULL,
  `cpaLvl1` decimal(10,2) DEFAULT NULL,
  `cpaLvl2` decimal(10,2) DEFAULT NULL,
  `cpaLvl3` decimal(10,2) DEFAULT NULL,
  `chanceCpa` int(11) NOT NULL,
  `revShareFalso` decimal(5,2) DEFAULT NULL,
  `revShareLvl1` decimal(5,2) DEFAULT NULL,
  `revShareLvl2` decimal(5,2) DEFAULT NULL,
  `revShareLvl3` decimal(5,2) DEFAULT NULL,
  `minDepForCpa` decimal(10,2) DEFAULT NULL,
  `minResgate` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Despejando dados para a tabela `afiliados_config`
--

INSERT INTO `afiliados_config` (`id`, `cpaLvl1`, `cpaLvl2`, `cpaLvl3`, `chanceCpa`, `revShareFalso`, `revShareLvl1`, `revShareLvl2`, `revShareLvl3`, `minDepForCpa`, `minResgate`) VALUES
(1, 0.00, 0.00, 0.00, 0, 0.00, 0.00, 0.00, 0.00, 10.00, 100.00);

-- --------------------------------------------------------

--
-- Estrutura para tabela `apipragmatic`
--

CREATE TABLE `apipragmatic` (
  `id` int(11) NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  `agent_code` text DEFAULT NULL,
  `agent_token` text DEFAULT NULL,
  `agent_secret` text DEFAULT NULL,
  `ativo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Despejando dados para a tabela `apipragmatic`
--

INSERT INTO `apipragmatic` (`id`, `url`, `agent_code`, `agent_token`, `agent_secret`, `ativo`) VALUES
(1, 'https://api.supremabet.online', 'china23', 'f2e678c417c9f5de60f06f37fad73588', '49cab6f89cb237b6ea1dd9ab41cdf619', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `banner`
--

CREATE TABLE `banner` (
  `id` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp(),
  `img` text NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Despejando dados para a tabela `banner`
--

INSERT INTO `banner` (`id`, `titulo`, `criado_em`, `img`, `status`) VALUES
(1, 'Banner 1', '2024-06-28 18:10:47', '1739860551_banner1.png.webp', 1),
(2, 'Banner 2', '2024-06-28 18:08:02', '1739860560_banner3.png.webp', 1),
(3, 'Banner 3', '2024-06-28 18:08:02', '1739860567_banner2.png.webp', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `bau`
--

CREATE TABLE `bau` (
  `id` int(11) NOT NULL,
  `num` text DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `is_get` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `beeplay`
--

CREATE TABLE `beeplay` (
  `id` int(11) NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  `agent_code` text DEFAULT NULL,
  `agent_token` text DEFAULT NULL,
  `ativo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Despejando dados para a tabela `beeplay`
--

INSERT INTO `beeplay` (`id`, `url`, `agent_code`, `agent_token`, `ativo`) VALUES
(1, 'https://api.beeplay.top', 'k58qbaQDzorpDHwGfInL4XKtjcCFvR', 'JJUwHBZW9rD1zwPAzq3B5L600vFCcB', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `bspay`
--

CREATE TABLE `bspay` (
  `id` int(11) NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  `client_id` text DEFAULT NULL,
  `client_secret` text DEFAULT NULL,
  `atualizado` varchar(45) DEFAULT NULL,
  `ativo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Despejando dados para a tabela `bspay`
--

INSERT INTO `bspay` (`id`, `url`, `client_id`, `client_secret`, `atualizado`, `ativo`) VALUES
(1, 'https://api.pixupbr.com', 'Jooabets_2235943873', 'e922828e87ffdfaa12f5597a8b031979f2778b3b1f6d48420ed6c9b432063627', NULL, 0);

-- --------------------------------------------------------

--
-- Estrutura para tabela `config`
--

CREATE TABLE `config` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) DEFAULT NULL,
  `nome_site` text DEFAULT NULL,
  `descricao` text DEFAULT NULL,
  `grupoplataforma` varchar(255) DEFAULT NULL,
  `logo` text DEFAULT NULL,
  `avatar` text DEFAULT NULL,
  `telegram` text DEFAULT NULL,
  `instagram` text DEFAULT NULL,
  `whatsapp` text DEFAULT NULL,
  `suporte` text DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `sublogo` text DEFAULT NULL,
  `facebookads` text DEFAULT NULL,
  `rodapelogo` text DEFAULT NULL,
  `favicon` text DEFAULT NULL,
  `logoapp` text DEFAULT NULL,
  `googleAnalytics` text DEFAULT NULL,
  `minplay` int(11) DEFAULT NULL,
  `minsaque` double DEFAULT NULL,
  `maxsaque` int(11) DEFAULT 1000,
  `saque_automatico` int(11) NOT NULL,
  `rollover` int(11) DEFAULT NULL,
  `mindep` text DEFAULT NULL,
  `jackpot` int(11) DEFAULT NULL,
  `numero_jackpot` int(11) DEFAULT NULL,
  `jackpot_custom` text DEFAULT NULL,
  `cor_padrao` varchar(45) NOT NULL,
  `background_padrao` varchar(50) DEFAULT NULL,
  `custom_css` longtext NOT NULL,
  `texto` varchar(45) NOT NULL,
  `img_seo` text DEFAULT NULL,
  `keyword` text DEFAULT NULL,
  `marquee` text DEFAULT NULL,
  `status_topheader` int(11) NOT NULL DEFAULT 0,
  `cor_topheader` varchar(48) DEFAULT '#ed1c24',
  `niveisbau` text DEFAULT NULL,
  `qntsbaus` int(11) DEFAULT NULL,
  `nvlbau` int(11) DEFAULT NULL,
  `pessoasbau` int(11) DEFAULT NULL,
  `tema` int(11) DEFAULT NULL,
  `versao_app_android` text DEFAULT NULL,
  `versao_app_ios` text DEFAULT NULL,
  `mensagem_app` text DEFAULT NULL,
  `link_app_android` text DEFAULT NULL,
  `link_app_ios` text DEFAULT NULL,
  `broadcast` text DEFAULT NULL,
  `mostrar_barra_topo` tinyint(1) NOT NULL DEFAULT 0,
  `mostrar_barra_inferior` tinyint(1) NOT NULL DEFAULT 0,
  `mostrar_modal_download` tinyint(1) NOT NULL DEFAULT 1,
  `suporte_url` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Despejando dados para a tabela `config`
--

INSERT INTO `config` (`id`, `nome`, `nome_site`, `descricao`, `grupoplataforma`, `logo`, `avatar`, `telegram`, `instagram`, `whatsapp`, `suporte`, `email`, `sublogo`, `facebookads`, `rodapelogo`, `favicon`, `logoapp`, `googleAnalytics`, `minplay`, `minsaque`, `maxsaque`, `saque_automatico`, `rollover`, `mindep`, `jackpot`, `numero_jackpot`, `jackpot_custom`, `cor_padrao`, `background_padrao`, `custom_css`, `texto`, `img_seo`, `keyword`, `marquee`, `status_topheader`, `cor_topheader`, `niveisbau`, `qntsbaus`, `nvlbau`, `pessoasbau`, `tema`, `versao_app_android`, `versao_app_ios`, `mensagem_app`, `link_app_android`, `link_app_ios`, `broadcast`, `mostrar_barra_topo`, `mostrar_barra_inferior`, `mostrar_modal_download`, `suporte_url`) VALUES
(1, 'EXPFY', '', 'Aumente seu nível jogando na melhor! Os melhores jogos estão aqui!', 'EXPFY.com.br', 'logo_1739860675.webp', 'favicon.png.webp', '', '', '', NULL, '', '', 'Insira o ID', NULL, 'favicon_1740297553.png', 'logoapp_1740371707.avif', 'Insira o ID', 1, 10, 2000, 0, 2, '1,10,25,50,80,100,150,300,500,1000', 1, 5, NULL, '#0096DD', '#010e24', '', '', '154504365733.png', 'Cassino, plataforma chinesa, casa pagante', 'Adquira já a sua! (31) 9 8491-5035  // Bem-vindo, Mega Sorteio de Membros: 254732 ganhar 2956BRL, 942048 ganhar 6590BRL, 224782 ganhar 50081BRL, 148295 ganhar 2320BRL, 592841 ganhar 9922BRL, 783323 ganhar 2880BRL, 352708 ganhar 5239BRL, 109803 ganhar 6288BRL, 820682 ganhar 3220BRL, 592444 ganhar 1530BRL. Espero que você seja o próximo ganhador e boa sorte!', 0, '#0096dd', '10,20', 50, 5, 1, 28, '2.2', '2.0.1', 'Baixar App', 'https://chinav2.expfygaming.online/', 'https://chinav2.expfygaming.online/', 'expfygaming', 1, 0, 1, 'https://jivo.chat/IvwRiIQ08G');

-- --------------------------------------------------------

--
-- Estrutura para tabela `cupom`
--

CREATE TABLE `cupom` (
  `id` int(11) NOT NULL,
  `nome` text NOT NULL,
  `tipo` int(11) NOT NULL DEFAULT 2,
  `valor` int(11) NOT NULL,
  `qtd` int(11) NOT NULL DEFAULT 0,
  `qtd_insert` int(11) NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `cupom`
--

INSERT INTO `cupom` (`id`, `nome`, `tipo`, `valor`, `qtd`, `qtd_insert`, `status`) VALUES
(1, 'Bônus de Depósito', 2, 1, 100, 15, 0),
(2, 'Bônus de Depósito 2x', 2, 30, 5, 15, 0),
(3, 'Bônus de Depósito 3x', 2, 40, 5, 20, 0);

-- --------------------------------------------------------

--
-- Estrutura para tabela `cupom_usados`
--

CREATE TABLE `cupom_usados` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_cupom` int(11) NOT NULL,
  `valor` int(11) NOT NULL DEFAULT 0,
  `data_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `expfypay`
--

CREATE TABLE `expfypay` (
  `id` int(11) NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  `client_id` text DEFAULT NULL,
  `client_secret` text DEFAULT NULL,
  `atualizado` varchar(45) DEFAULT NULL,
  `ativo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Despejando dados para a tabela `expfypay`
--

INSERT INTO `expfypay` (`id`, `url`, `client_id`, `client_secret`, `atualizado`, `ativo`) VALUES
(1, 'https://expfypay.com', 'pk_X', 'sk_X', NULL, 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `financeiro`
--

CREATE TABLE `financeiro` (
  `id` int(11) NOT NULL,
  `usuario` int(11) DEFAULT NULL,
  `saldo` decimal(10,2) DEFAULT NULL,
  `bonus` decimal(10,2) DEFAULT NULL,
  `saldo_afiliados` decimal(10,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `fiverscan`
--

CREATE TABLE `fiverscan` (
  `id` int(11) NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  `agent_code` text DEFAULT NULL,
  `agent_token` text DEFAULT NULL,
  `ativo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Despejando dados para a tabela `fiverscan`
--

INSERT INTO `fiverscan` (`id`, `url`, `agent_code`, `agent_token`, `ativo`) VALUES
(1, 'https://api.playfivers.com', '28fd0b9c-7004-46fd-8922-cebc96827215', 'efd02bfb-c25f-4631-a9aa-193d7daa342e', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `floats`
--

CREATE TABLE `floats` (
  `id` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp(),
  `img` text NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ROW_FORMAT=DYNAMIC;

--
-- Despejando dados para a tabela `floats`
--

INSERT INTO `floats` (`id`, `titulo`, `criado_em`, `img`, `status`) VALUES
(1, 'Float 1', '2024-06-28 18:10:47', 'float1.png', 1),
(2, 'Float 2', '2024-06-28 18:08:02', 'float2.gif', 1),
(3, 'Float 3', '2024-06-28 18:08:02', 'float3.gif', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `games`
--

CREATE TABLE `games` (
  `id` int(11) NOT NULL,
  `game_code` text NOT NULL,
  `game_name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `banner` text DEFAULT NULL,
  `status` int(11) NOT NULL,
  `provider` text DEFAULT NULL,
  `popular` int(11) NOT NULL DEFAULT 0,
  `type` text DEFAULT NULL,
  `game_type` int(11) DEFAULT NULL,
  `distribution` varchar(255) DEFAULT 'Clone'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Despejando dados para a tabela `games`
--

INSERT INTO `games` (`id`, `game_code`, `game_name`, `banner`, `status`, `provider`, `popular`, `type`, `game_type`, `distribution`) VALUES
(1, 'fortune-snake', 'Fortune Snake', '/uploads/igamewin/fortune-snake.avif', 1, 'PGSOFT', 1, 'slot', 0, 'igamewin'),
(2, 'fortune-tiger', 'Fortune Tiger', '/uploads/igamewin/fortune-tiger.avif', 1, 'PGSOFT', 1, 'slot', 3, 'igamewin'),
(3, 'fortune-dragon', 'Fortune Dragon', '/uploads/igamewin/fortune-dragon.avif', 1, 'PGSOFT', 1, 'slot', 3, 'igamewin'),
(4, 'fortune-ox', 'Fortune Ox', '/uploads/igamewin/fortune-ox.avif', 1, 'PGSOFT', 1, 'slot', 3, 'igamewin'),
(5, 'graffiti-rush', 'Graffiti Rush', '/uploads/igamewin/graffiti-rush.jpg', 1, 'PGSOFT', 1, 'slot', 0, 'igamewin'),
(6, 'mr-treas-fort', 'Mr. Treasure\'s Fortune', '/uploads/igamewin/mr-treasure.jpg', 1, 'PGSOFT', 1, 'slot', 0, 'igamewin'),
(7, 'wild-ape-3258', 'Wild Ape #3258', '/uploads/igamewin/wild-ape.avif', 1, 'PGSOFT', 1, 'slot', 3, 'igamewin'),
(8, 'incan-wonders', 'Incan Wonders', '/uploads/igamewin/incan-wonders.jpg', 1, 'PGSOFT', 1, 'slot', 0, 'igamewin'),
(9, 'vs20fruitsw', 'Sweet Bonanza', 'https://igamewin.com/storage/igamewin/177.webp', 1, 'PRAGMATIC', 1, 'slot', 0, 'igamewin'),
(10, 'ganesha-gold', 'Ganesha Gold', '/uploads/igamewin/ganesha-gold.avif', 1, 'PGSOFT', 1, 'slot', 3, 'igamewin'),
(11, 'fortune-rabbit', 'Fortune Rabbit', '/uploads/igamewin/fortune-rabbit.avif', 1, 'PGSOFT', 1, 'slot', 3, 'igamewin'),
(12, 'cash-mania', 'Cash Mania', '/uploads/igamewin/cash-mania.avif', 1, 'PGSOFT', 1, 'slot', 3, 'igamewin'),
(13, 'fortune-mouse', 'Fortune Mouse', '/uploads/igamewin/fortune-mouse.avif', 1, 'PGSOFT', 1, 'slot', 3, 'igamewin'),
(14, 'dragon-hatch2', 'Dragon Hatch 2', '/uploads/igamewin/dragon-hatch-2.avif', 1, 'PGSOFT', 1, 'slot', 3, 'igamewin'),
(15, 'piggy-gold', 'Piggy Gold', '/uploads/igamewin/piggy-gold.avif', 1, 'PGSOFT', 1, 'slot', 3, 'igamewin'),
(16, 'wild-bandito', 'Wild Bandito', '/uploads/igamewin/wild-bandito.avif', 1, 'PGSOFT', 1, 'slot', 3, 'igamewin'),
(17, 'jewels-prosper', 'Jewels of Prosperity', '/uploads/igamewin/jewels.avif', 1, 'PGSOFT', 1, 'slot', 3, 'igamewin'),
(18, 'double-fortune', 'Double Fortune', '/uploads/igamewin/double-fortune.avif', 1, 'PGSOFT', 1, 'slot', 3, 'igamewin'),
(19, 'captains-bounty', 'Captain’s Bounty', '/uploads/igamewin/captain-bounty.avif', 1, 'PGSOFT', 1, 'slot', 3, 'igamewin'),
(20, 'gem-saviour', 'Gem Saviour', '/uploads/igamewin/gem-conquest.avif', 1, 'PGSOFT', 1, 'slot', 3, 'igamewin'),
(21, 'rio-fantasia', 'Rio Fantasia', '/uploads/igamewin/rio-fantasia.avif', 1, 'PGSOFT', 1, 'slot', 3, 'igamewin'),
(22, 'oishi-delights', 'Oishi Delights', '/uploads/igamewin/oishi.avif', 1, 'PGSOFT', 1, 'slot', 3, 'igamewin'),
(23, 'wings-iguazu', 'Wings of Iguazu', '/uploads/igamewin/wings.avif', 1, 'PGSOFT', 1, 'slot', 3, 'igamewin'),
(24, 'mahjong-ways', 'Mahjong Ways', '/uploads/igamewin/mahjong.avif', 1, 'PGSOFT', 1, 'slot', 3, 'igamewin'),
(25, 'three-cz-pigs', 'Three Crazy Piggies', '/uploads/igamewin/3porquinhos.avif', 1, 'PGSOFT', 1, 'slot', 3, 'igamewin'),
(26, 'anubis-wrath', 'Anubis Wrath', '/uploads/igamewin/anubis.avif', 1, 'PGSOFT', 1, 'slot', 3, 'igamewin'),
(27, 'gemstones-gold', 'Gemstones Gold', '/uploads/igamewin/gemstones.avif', 1, 'PGSOFT', 1, 'slot', 3, 'igamewin'),
(28, 'futebol-fever', 'Futebol Fever', '/uploads/igamewin/futebol-fever.avif', 1, 'PGSOFT', 1, 'slot', 3, 'igamewin'),
(29, 'hip-hop-panda', 'Chicky Run', '/uploads/igamewin/chikcy-run.avif', 1, 'PGSOFT', 1, 'slot', 3, 'igamewin'),
(30, 'the-great-icescape', 'The Great Icescape', '/uploads/igamewin/icescape.avif', 1, 'PGSOFT', 1, 'slot', 3, 'igamewin'),
(31, 'emoji-riches', 'Emoji Riches', '/uploads/igamewin/emoji.avif', 1, 'PGSOFT', 1, 'slot', 3, 'igamewin'),
(32, 'bikini-paradise', 'Bikini Paradise', '/uploads/igamewin/bikini-paradise.avif', 1, 'PGSOFT', 1, 'slot', 3, 'igamewin'),
(33, 'ganesha-fortune', 'Ganesha Fortune', '/uploads/igamewin/ganesha-fortune.avif', 1, 'PGSOFT', 1, 'slot', 3, 'igamewin'),
(34, 'dreams-of-macau', 'Dreams of Macau', '/uploads/igamewin/dreams-of-macau.avif', 1, 'PGSOFT', 1, 'slot', 3, 'igamewin'),
(35, 'jungle-delight', 'Jungle Delight', '/uploads/igamewin/jungle-delight.avif', 1, 'PGSOFT', 1, 'slot', 3, 'igamewin'),
(36, 'phoenix-rises', 'Phoenix Rises', '/uploads/igamewin/phoenix-rises.avif', 1, 'PGSOFT', 1, 'slot', 3, 'igamewin'),
(37, 'wild-fireworks', 'Wild Fireworks', '/uploads/igamewin/wild-fireworks.avif', 1, 'PGSOFT', 1, 'slot', 3, 'igamewin'),
(38, 'lucky-neko', 'Lucky Neko', '/uploads/igamewin/lucky-neko.avif', 1, 'PGSOFT', 1, 'slot', 3, 'igamewin'),
(39, 'sct-cleopatra', 'Secrets of Cleopatra', '/uploads/igamewin/sct-cleopatra.avif', 1, 'PGSOFT', 1, 'slot', 3, 'igamewin'),
(40, 'gdn-ice-fire', 'Guardians of Ice & Fire', '/uploads/igamewin/gdn-ice-fire.avif', 1, 'PGSOFT', 1, 'slot', 3, 'igamewin'),
(41, 'alchemy-gold', 'Alchemy Gold', 'https://igamewin.com/storage/igamewin/157.webp', 1, 'PGSOFT', 1, 'slot', 3, 'igamewin'),
(42, 'bali-vacation', 'Bali Vacation', 'https://igamewin.com/storage/igamewin/81.webp', 1, 'PGSOFT', 1, 'slot', 3, 'igamewin'),
(43, 'battleground', 'Battleground Royale', 'https://igamewin.com/storage/igamewin/41.webp', 1, 'PGSOFT', 1, 'slot', 3, 'igamewin'),
(44, 'buffalo-win', 'Buffalo Win', 'https://igamewin.com/storage/igamewin/88.webp', 1, 'PGSOFT', 1, 'slot', 3, 'igamewin'),
(45, 'btrfly-blossom', 'Butterfly Blossom', 'https://igamewin.com/storage/igamewin/39.webp', 1, 'PGSOFT', 1, 'slot', 3, 'igamewin'),
(46, 'candy-bonanza', 'Candy Bonanza', 'https://igamewin.com/storage/igamewin/30.webp', 1, 'PGSOFT', 1, 'slot', 3, 'igamewin'),
(47, 'choc-deluxe', 'Chocolate Deluxe', 'https://igamewin.com/storage/igamewin/341.webp', 1, 'PGSOFT', 1, 'slot', 3, 'igamewin'),
(48, 'forge-wealth', 'Forge of Wealth', 'https://igamewin.com/storage/igamewin/143.webp', 1, 'PGSOFT', 1, 'slot', 3, 'igamewin'),
(49, 'cocktail-nite', 'Cocktail Nights', 'https://igamewin.com/storage/igamewin/94.webp', 1, 'PGSOFT', 1, 'slot', 3, 'igamewin'),
(50, 'cruise-royale', 'Cruise Royale', 'https://igamewin.com/storage/igamewin/148.webp', 1, 'PGSOFT', 1, 'slot', 3, 'igamewin'),
(51, 'crypto-gold', 'Crypto Gold', 'https://igamewin.com/storage/igamewin/85.webp', 1, 'PGSOFT', 1, 'slot', 3, 'igamewin'),
(52, 'fruity-candy', 'Fruity Candy', 'https://igamewin.com/storage/igamewin/149.webp', 1, 'PGSOFT', 1, 'slot', 3, 'igamewin'),
(53, 'dragon-hatch', 'Dragon Hatch', 'https://igamewin.com/storage/igamewin/6.webp', 1, 'PGSOFT', 1, 'slot', 3, 'igamewin'),
(54, 'galactic-gems', 'Galactic Gems', 'https://igamewin.com/storage/igamewin/27.webp', 1, 'PGSOFT', 1, 'slot', 3, 'igamewin'),
(55, 'garuda-gems', 'Garuda Gems', 'https://igamewin.com/storage/igamewin/37.webp', 1, 'PGSOFT', 1, 'slot', 3, 'igamewin'),
(56, 'gladi-glory', 'Gladiator\'s Glory', 'https://igamewin.com/storage/igamewin/146.webp', 1, 'PGSOFT', 1, 'slot', 3, 'igamewin'),
(57, 'hawaiian-tiki', 'Hawaiian Tiki', 'https://igamewin.com/storage/igamewin/154.webp', 1, 'PGSOFT', 1, 'slot', 3, 'igamewin'),
(58, 'heist-stakes', 'Heist Stakes', 'https://igamewin.com/storage/igamewin/86.webp', 1, 'PGSOFT', 1, 'slot', 3, 'igamewin'),
(59, 'jack-frosts', 'Jack Frost\'s Winter', 'https://igamewin.com/storage/igamewin/82.webp', 1, 'PGSOFT', 1, 'slot', 3, 'igamewin'),
(60, 'jurassic-kdm', 'Jurassic Kingdom', 'https://igamewin.com/storage/igamewin/90.webp', 1, 'PGSOFT', 1, 'slot', 3, 'igamewin'),
(61, 'lgd-monkey-kg', 'Legendary Monkey King', 'https://igamewin.com/storage/igamewin/34.webp', 1, 'PGSOFT', 1, 'slot', 3, 'igamewin'),
(62, 'Lucky Clover Lady', 'Lucky Clover Lady', 'https://igamewin.com/storage/igamewin/150.webp', 1, 'PGSOFT', 1, 'slot', 3, 'igamewin'),
(63, 'mafia-mayhem', 'Mafia Mayhem', 'https://igamewin.com/storage/igamewin/142.webp', 1, 'PGSOFT', 1, 'slot', 3, 'igamewin'),
(64, 'majestic-ts', 'Majestic Treasures', 'https://igamewin.com/storage/igamewin/31.webp', 1, 'PGSOFT', 1, 'slot', 3, 'igamewin'),
(65, 'mask-carnival', 'Mask Carnival', 'https://igamewin.com/storage/igamewin/95.webp', 1, 'PGSOFT', 1, 'slot', 3, 'igamewin'),
(66, 'mermaid-riches', 'Mermaid Riches', 'https://igamewin.com/storage/igamewin/84.webp', 1, 'PGSOFT', 1, 'slot', 3, 'igamewin'),
(67, 'midas-fortune', 'Midas Fortune', 'https://igamewin.com/storage/igamewin/44.webp', 1, 'PGSOFT', 1, 'slot', 3, 'igamewin'),
(68, 'museum-mystery', 'Museum Mystery', 'https://igamewin.com/storage/igamewin/339.webp', 1, 'PGSOFT', 1, 'slot', 3, 'igamewin'),
(69, 'mystic-potions', 'Mystic Potion', 'https://igamewin.com/storage/igamewin/329.webp', 1, 'PGSOFT', 1, 'slot', 3, 'igamewin'),
(70, 'myst-spirits', 'Mystical Spirits', 'https://igamewin.com/storage/igamewin/152.webp', 1, 'PGSOFT', 1, 'slot', 3, 'igamewin'),
(71, 'ninja-raccoon', 'Ninja Raccoon Frenzy', 'https://igamewin.com/storage/igamewin/145.webp', 1, 'PGSOFT', 1, 'slot', 3, 'igamewin'),
(72, 'opera-dynasty', 'Opera Dynasty', 'https://igamewin.com/storage/igamewin/80.webp', 1, 'PGSOFT', 1, 'slot', 3, 'igamewin'),
(73, 'pinata-wins', 'Pinata Wins', 'https://igamewin.com/storage/igamewin/328.webp', 1, 'PGSOFT', 1, 'slot', 3, 'igamewin'),
(74, 'crypt-fortune', 'Raider Jane\'s Crypt of Fortune', 'https://igamewin.com/storage/igamewin/32.webp', 1, 'PGSOFT', 1, 'slot', 3, 'igamewin'),
(75, 'rave-party-fvr', 'Rave Party Fever', 'https://igamewin.com/storage/igamewin/155.webp', 1, 'PGSOFT', 1, 'slot', 3, 'igamewin'),
(76, 'rise-of-apollo', 'Rise of Apollo', 'https://igamewin.com/storage/igamewin/83.webp', 1, 'PGSOFT', 1, 'slot', 3, 'igamewin'),
(77, 'rooster-rbl', 'Rooster Rumble', 'https://igamewin.com/storage/igamewin/40.webp', 1, 'PGSOFT', 1, 'slot', 3, 'igamewin'),
(78, 'shark-hunter', 'Shark Hunter', 'https://igamewin.com/storage/igamewin/334.webp', 1, 'PGSOFT', 1, 'slot', 3, 'igamewin'),
(79, 'songkran-spl', 'Songkran Splash', 'https://igamewin.com/storage/igamewin/153.webp', 1, 'PGSOFT', 1, 'slot', 3, 'igamewin'),
(80, 'speed-winner', 'Speed Winner', 'https://igamewin.com/storage/igamewin/97.webp', 1, 'PGSOFT', 1, 'slot', 3, 'igamewin'),
(81, 'spirit-wonder', 'Spirit of Wonder', 'https://igamewin.com/storage/igamewin/35.webp', 1, 'PGSOFT', 1, 'slot', 3, 'igamewin'),
(82, 'spr-golf-drive', 'Super Golf Drive', 'https://igamewin.com/storage/igamewin/151.webp', 1, 'PGSOFT', 1, 'slot', 3, 'igamewin'),
(83, 'sprmkt-spree', 'Supermarket Spree', 'https://igamewin.com/storage/igamewin/33.webp', 1, 'PGSOFT', 1, 'slot', 3, 'igamewin'),
(84, 'thai-river', 'Thai River Wonders', 'https://igamewin.com/storage/igamewin/79.webp', 1, 'PGSOFT', 1, 'slot', 3, 'igamewin'),
(85, 'queen-banquet', 'The Queen\'s Banquet', 'https://igamewin.com/storage/igamewin/96.webp', 1, 'PGSOFT', 1, 'slot', 3, 'igamewin'),
(86, 'totem-wonders', 'Totem Wonders', 'https://igamewin.com/storage/igamewin/158.webp', 1, 'PGSOFT', 1, 'slot', 3, 'igamewin'),
(87, 'ways-of-qilin', 'Ways of the Qilin', 'https://igamewin.com/storage/igamewin/87.webp', 1, 'PGSOFT', 1, 'slot', 3, 'igamewin'),
(88, 'werewolf-hunt', 'Werewolf\'s Hunt', 'https://igamewin.com/storage/igamewin/139.webp', 1, 'PGSOFT', 1, 'slot', 3, 'igamewin'),
(89, 'wild-bounty-sd', 'Wild Bounty Showdown', 'https://igamewin.com/storage/igamewin/160.webp', 1, 'PGSOFT', 1, 'slot', 3, 'igamewin'),
(90, 'wild-coaster', 'Wild Coaster', 'https://igamewin.com/storage/igamewin/161.webp', 1, 'PGSOFT', 1, 'slot', 3, 'igamewin'),
(91, 'wild-heist-co', 'Wild Heist Cashout', 'https://igamewin.com/storage/igamewin/144.webp', 1, 'PGSOFT', 1, 'slot', 3, 'igamewin'),
(92, 'win-win-fpc', 'Win Win Fish Prawn Crab', 'https://igamewin.com/storage/igamewin/98.webp', 1, 'PGSOFT', 1, 'slot', 3, 'igamewin'),
(93, 'wings-iguazu', 'Yakuza Honor', 'https://igamewin.com/storage/igamewin/336.webp', 1, 'PGSOFT', 1, 'slot', 3, 'igamewin'),
(94, 'zombie-outbrk', 'Zombie Outbreak', 'https://igamewin.com/storage/igamewin/331.webp', 1, 'PGSOFT', 1, 'slot', 3, 'igamewin'),
(95, 'aviator_core', 'Aviator', 'https://igamewin.com/storage/igamewin/170.webp', 1, 'SPRIBE', 1, 'slot', 3, 'igamewin'),
(96, 'dice', 'Dice', 'https://igamewin.com/storage/igamewin/165.webp', 1, 'SPRIBE', 1, 'slot', 3, 'igamewin'),
(97, 'goal', 'Goal', 'https://igamewin.com/storage/igamewin/167.webp', 1, 'PGSOFT', 1, 'slot', 3, 'igamewin'),
(98, 'hilo', 'Hilo', 'https://igamewin.com/storage/igamewin/169.webp', 1, 'SPRIBE', 1, 'slot', 3, 'igamewin'),
(99, 'hotline', 'Hotline', 'https://igamewin.com/storage/igamewin/163.webp', 1, 'SPRIBE', 1, 'slot', 3, 'igamewin'),
(100, 'mines', 'Mines', 'https://igamewin.com/storage/igamewin/162.webp', 1, 'SPRIBE', 1, 'slot', 3, 'igamewin'),
(101, 'keno', 'Keno', 'https://igamewin.com/storage/igamewin/168.webp', 1, 'SPRIBE', 1, 'slot', 3, 'igamewin'),
(102, 'roulette', 'Mini Roulette', 'https://igamewin.com/storage/igamewin/164.webp', 1, 'PGSOFT', 1, 'slot', 3, 'igamewin'),
(103, 'plinko', 'Plinko', 'https://igamewin.com/storage/igamewin/166.webp', 1, 'PGSOFT', 1, 'slot', 3, 'igamewin'),
(104, 'vswayscharms', '5 Frozen Charms Megaways', 'https://igamewin.com/storage/igamewin/237.webp', 1, 'PRAGMATIC', 1, 'slot', 3, 'igamewin'),
(105, 'vs10gdchalleng', '8 Golden Dragon Challenge', 'https://igamewin.com/storage/igamewin/249.webp', 1, 'PRAGMATIC', 1, 'slot', 3, 'igamewin'),
(106, 'vs1dragon8', '888 Dragons', 'https://igamewin.com/storage/igamewin/188.webp', 1, 'PRAGMATIC', 1, 'slot', 3, 'igamewin'),
(107, 'vs1dragon8', '888 Dragons', 'https://igamewin.com/storage/igamewin/188.webp', 1, 'PRAGMATIC', 1, 'slot', 3, 'igamewin'),
(108, 'vs20hotzone', 'African Elephant', 'https://igamewin.com/storage/igamewin/280.webp', 1, 'PRAGMATIC', 1, 'slot', 3, 'igamewin'),
(109, 'vs5aztecgems', 'Aztec Gems', 'https://igamewin.com/storage/igamewin/183.webp', 1, 'PRAGMATIC', 1, 'slot', 3, 'igamewin'),
(110, 'vs5aztecgems', 'Aztec Powernudge', 'https://igamewin.com/storage/igamewin/183.webp', 1, 'PRAGMATIC', 1, 'slot', 3, 'igamewin'),
(111, 'vs20sbpnudge', 'Aztec Powernudge', 'https://kto.kgp-cdn.com/kto/2023/11/20130929/Bakery-Bonanzax-654d0ee0c7f7c-766x1024.jpg', 1, 'PRAGMATIC', 1, 'slot', 3, 'igamewin'),
(112, 'vswaysmegahays', 'Barnyard Megahays Megaways', 'https://igamewin.com/storage/igamewin/205.webp', 1, 'PRAGMATIC', 1, 'slot', 3, 'igamewin'),
(113, 'vs10bbbonanza', 'Big Bass Bonanza', 'https://igamewin.com/storage/igamewin/175.webp', 1, 'PRAGMATIC', 1, 'slot', 3, 'igamewin'),
(114, 'vs10bbkir', 'Big Bass Bonanza - Keeping it Reel', 'https://igamewin.com/storage/igamewin/307.webp', 1, 'PRAGMATIC', 1, 'slot', 3, 'igamewin'),
(115, 'vs10bbbrlact', 'Big Bass Bonanza - Reel Action', 'https://igamewin.com/storage/igamewin/198.webp', 1, 'PRAGMATIC', 1, 'slot', 3, 'igamewin'),
(116, 'vs10bbfloats', 'Big Bass Floats my Boat', 'https://igamewin.com/storage/igamewin/225.webp', 1, 'PRAGMATIC', 1, 'slot', 3, 'igamewin'),
(117, 'vswaysbbhas', 'Big Bass Hold & Spinner Megaways', 'https://igamewin.com/storage/igamewin/252.webp', 1, 'PRAGMATIC', 1, 'slot', 3, 'igamewin'),
(118, 'vs10bbfmission', 'Big Bass Mission Fishin\'', 'https://igamewin.com/storage/igamewin/193.webp', 1, 'PRAGMATIC', 1, 'slot', 3, 'igamewin'),
(119, 'vs10bburger', 'Big Burger Load it up with Xtra Cheese', 'https://igamewin.com/storage/igamewin/209.webp', 1, 'PRAGMATIC', 1, 'slot', 3, 'igamewin'),
(120, 'vs12bbbxmas', 'Bigger Bass Blizzard - Christmas Catch', 'https://igamewin.com/storage/igamewin/301.webp', 1, 'PRAGMATIC', 1, 'slot', 3, 'igamewin'),
(121, 'vs20mergedwndw', 'Blade & Fangs', 'https://igamewin.com/storage/igamewin/232.webp', 1, 'PRAGMATIC', 1, 'slot', 3, 'igamewin'),
(122, 'vs20trswild2', 'Black Bull', 'https://igamewin.com/storage/igamewin/325.webp', 1, 'PRAGMATIC', 1, 'slot', 3, 'igamewin'),
(123, 'vswaysfirewmw', 'Blazing Wilds Megaways', 'https://igamewin.com/storage/igamewin/222.webp', 1, 'PRAGMATIC', 1, 'slot', 3, 'igamewin'),
(124, 'vswaysbook', 'Book of Golden Sands', 'https://igamewin.com/storage/igamewin/316.webp', 1, 'PRAGMATIC', 1, 'slot', 3, 'igamewin'),
(125, 'vswaystut', 'Book of Tut Megaways', 'https://igamewin.com/storage/igamewin/248.webp', 1, 'PRAGMATIC', 1, 'slot', 3, 'igamewin'),
(126, 'vs10bookviking', 'Book of Vikings', 'https://igamewin.com/storage/igamewin/253.webp', 1, 'PRAGMATIC', 1, 'slot', 3, 'igamewin'),
(127, 'vswaysbkingasc', 'Buffalo King Untamed Megaways', 'https://igamewin.com/storage/igamewin/192.webp', 1, 'PRAGMATIC', 1, 'slot', 3, 'igamewin'),
(128, 'vs20candybltz2', 'Candy Blitz Bombs', 'https://igamewin.com/storage/igamewin/203.webp', 1, 'PRAGMATIC', 1, 'slot', 3, 'igamewin'),
(129, 'vswaysexpandng', 'Castle of Fire', 'https://igamewin.com/storage/igamewin/234.webp', 1, 'PRAGMATIC', 1, 'slot', 3, 'igamewin'),
(130, 'vs12tropicana', 'Club Tropicana', 'https://igamewin.com/storage/igamewin/289.webp', 1, 'PRAGMATIC', 1, 'slot', 3, 'igamewin'),
(131, 'vswaysultrcoin', 'Cowboy Coins', 'https://igamewin.com/storage/igamewin/286.webp', 1, 'PRAGMATIC', 1, 'slot', 3, 'igamewin'),
(132, 'vs10crownfire', 'Crown of Fire', 'https://igamewin.com/storage/igamewin/313.webp', 1, 'PRAGMATIC', 1, 'slot', 3, 'igamewin'),
(133, 'vs20earthquake', 'Cyclops Smash', 'https://igamewin.com/storage/igamewin/262.webp', 1, 'PRAGMATIC', 1, 'slot', 3, 'igamewin'),
(134, 'vs5luckytig', 'Tigre Sortudo', 'https://igamewin.com/storage/igamewin/343.webp', 1, 'PRAGMATIC', 1, 'slot', 3, 'igamewin'),
(135, 'vs40demonpots', 'Demon Pots', 'https://igamewin.com/storage/igamewin/242.webp', 1, 'PRAGMATIC', 1, 'slot', 3, 'igamewin'),
(136, 'vs20devilic', 'Devilicious', 'https://igamewin.com/storage/igamewin/195.webp', 1, 'PRAGMATIC', 1, 'slot', 3, 'igamewin'),
(137, 'vs20drgbless', 'Dragon Hero', 'https://igamewin.com/storage/igamewin/295.webp', 1, 'PRAGMATIC', 1, 'slot', 3, 'igamewin'),
(138, 'vswaysspltsym', 'Dwarf & Dragon', 'https://igamewin.com/storage/igamewin/172.webp', 1, 'PRAGMATIC', 1, 'slot', 3, 'igamewin'),
(139, 'vs20olympgate', 'Gates of Olympus', 'https://mediumrare.imgix.net/abb9098000cde7009fb88c54c26621682110bfbe895818cff2a7b99e7a05a0d3?&dpr=2&format=auto&auto=format&q=50', 1, 'PRAGMATIC', 1, 'slot', 3, 'igamewin'),
(140, 'vs20doghouse', 'The Dog House', 'https://mediumrare.imgix.net/eb75dbe63e5b45feb035e02cba7f846d6e71a9343f66187387a32ee8abe21e75?&dpr=2&format=auto&auto=format&q=50', 1, 'PRAGMATIC', 1, 'slot', 3, 'igamewin'),
(141, 'vs20excalibur', 'Excalibur Unleashed', 'https://igamewin.com/storage/igamewin/279.webp', 1, 'PRAGMATIC', 1, 'slot', 3, 'igamewin'),
(142, 'vs20beefed', 'Fat Panda', 'https://igamewin.com/storage/igamewin/268.webp', 1, 'PRAGMATIC', 1, 'slot', 3, 'igamewin'),
(143, 'vs25archer', 'Fire Archer', 'https://igamewin.com/storage/igamewin/268.webp', 1, 'PRAGMATIC', 1, 'slot', 3, 'igamewin'),
(144, 'vs100firehot', 'Fire Hot 100', 'https://igamewin.com/storage/igamewin/322.webp', 1, 'PRAGMATIC', 1, 'slot', 3, 'igamewin'),
(145, 'vs20portals', 'Fire Portals', 'https://igamewin.com/storage/igamewin/211.webp', 1, 'PRAGMATIC', 1, 'slot', 3, 'igamewin'),
(146, 'vs10fisheye', 'Fish Eye', 'https://igamewin.com/storage/igamewin/292.webp', 1, 'PRAGMATIC', 1, 'slot', 3, 'igamewin'),
(147, 'vs10floatdrg', 'Floating Dragon', 'https://igamewin.com/storage/igamewin/185.webp', 1, 'PRAGMATIC', 1, 'slot', 3, 'igamewin'),
(148, 'vs10fdrasbf', 'Floating Dragon - Dragon Boat Festival', 'https://igamewin.com/storage/igamewin/269.webp', 1, 'PRAGMATIC', 1, 'slot', 3, 'igamewin'),
(149, 'vs20forge', 'Forge of Olympus', 'https://igamewin.com/storage/igamewin/260.webp', 1, 'PRAGMATIC', 1, 'slot', 3, 'igamewin'),
(150, 'vswaysstrlght', 'Fortunes of Aztec', 'https://igamewin.com/storage/igamewin/245.webp', 1, 'PRAGMATIC', 1, 'slot', 3, 'igamewin'),
(151, 'vs10frontrun', 'Front Runner Odds On', 'https://igamewin.com/storage/igamewin/219.webp', 1, 'PRAGMATIC', 1, 'slot', 3, 'igamewin'),
(152, 'vswaysftropics', 'Frozen Tropics', 'https://igamewin.com/storage/igamewin/250.webp', 1, 'PRAGMATIC', 1, 'slot', 3, 'igamewin'),
(153, 'vs20fortbon', 'Fruity Treats', 'https://igamewin.com/storage/igamewin/202.webp', 1, 'PRAGMATIC', 1, 'slot', 3, 'igamewin'),
(154, 'vswaysfuryodin', 'Fury of Odin Megaways', 'https://igamewin.com/storage/igamewin/300.webp', 1, 'PRAGMATIC', 1, 'slot', 3, 'igamewin'),
(155, 'vs20olympdice', 'Gates of Olympus Dice', 'https://igamewin.com/storage/igamewin/230.webp', 1, 'PRAGMATIC', 1, 'slot', 3, 'igamewin'),
(156, 'vs20sugarrush', 'Sugar Rush', 'https://imagedelivery.net/BgH9d8bzsn4n0yijn4h7IQ/5527e6f0-38c1-4736-d0c5-7bae6b5a1b00/public', 1, 'PRAGMATIC', 1, 'slot', 3, 'igamewin'),
(157, 'vs20wildparty', '3 buzzing wild', 'https://imagedelivery.net/BgH9d8bzsn4n0yijn4h7IQ/228b9736-0e3e-4cf7-c631-0fdd39c36400/public', 1, 'PRAGMATIC', 1, 'slot', 3, 'igamewin'),
(158, 'vs15godsofwar', 'Zeus vs Hades - Gods of War', 'https://imagedelivery.net/BgH9d8bzsn4n0yijn4h7IQ/70ec752f-f027-4b62-7439-b98231ba6700/public', 1, 'PRAGMATIC', 1, 'slot', 3, 'igamewin'),
(159, 'vs20octobeer', 'Octobeer', 'https://storage.googleapis.com/www.mcluck.com/tiles/vs20octobeer/source.png', 1, 'PRAGMATIC', 1, 'slot', 3, 'igamewin'),
(160, 'vs20clustext', 'Gears of Horus', 'https://igamewin.com/storage/igamewin/231.webp', 1, 'PRAGMATIC', 1, 'slot', 3, 'igamewin'),
(161, 'vs20lcount', 'Gems of Serengeti', 'https://igamewin.com/storage/igamewin/303.webp', 1, 'PRAGMATIC', 1, 'slot', 3, 'igamewin'),
(162, 'vs10gizagods', 'Gods of Giza', 'https://igamewin.com/storage/igamewin/281.webp', 1, 'PRAGMATIC', 1, 'slot', 3, 'igamewin'),
(163, 'vswaysincwnd', 'Gold Oasis', 'https://igamewin.com/storage/igamewin/251.webp', 1, 'PRAGMATIC', 1, 'slot', 3, 'igamewin'),
(164, 'vs25goldparty', 'Gold Party', 'https://igamewin.com/storage/igamewin/184.webp', 1, 'PRAGMATIC', 1, 'slot', 3, 'igamewin'),
(165, 'vs10luckfort', 'Good Luck & Good Fortune', 'https://igamewin.com/storage/igamewin/235.webp', 1, 'PRAGMATIC', 1, 'slot', 3, 'igamewin'),
(166, 'vs1024gmayhem', 'Gorilla Mayhem', 'https://igamewin.com/storage/igamewin/327.webp', 1, 'PRAGMATIC', 1, 'slot', 3, 'igamewin'),
(167, 'vs20gravity', 'Gravity Bonanza', 'https://igamewin.com/storage/igamewin/246.webp', 1, 'PRAGMATIC', 1, 'slot', 3, 'igamewin'),
(168, 'vs20wolfie', 'Greedy Wolf', 'https://igamewin.com/storage/igamewin/326.webp', 1, 'PRAGMATIC', 1, 'slot', 3, 'igamewin'),
(169, 'vs20midas2', 'Hand of Midas 2', 'https://igamewin.com/storage/igamewin/190.webp', 1, 'PRAGMATIC', 1, 'slot', 3, 'igamewin'),
(170, 'vs20heartcleo', 'Heart of Cleopatra', 'https://igamewin.com/storage/igamewin/200.webp', 1, 'PRAGMATIC', 1, 'slot', 3, 'igamewin'),
(171, 'vs20hstgldngt', 'Heist for the Golden Nuggets', 'https://igamewin.com/storage/igamewin/265.webp', 1, 'PRAGMATIC', 1, 'slot', 3, 'igamewin'),
(172, 'vs243nudge4gold', 'Hellvis Wild', 'https://igamewin.com/storage/igamewin/258.webp', 1, 'PRAGMATIC', 1, 'slot', 3, 'igamewin'),
(173, 'vs20shootstars', 'Heroic Spins', 'https://igamewin.com/storage/igamewin/173.webp', 1, 'PRAGMATIC', 1, 'slot', 3, 'igamewin'),
(174, 'vs20dugems', 'Hot Pepper', 'https://igamewin.com/storage/igamewin/298.webp', 1, 'PRAGMATIC', 1, 'slot', 3, 'igamewin'),
(175, 'vs40hotburnx', 'Hot To Burn Extreme', 'https://igamewin.com/storage/igamewin/324.webp', 1, 'PRAGMATIC', 1, 'slot', 0, 'igamewin'),
(176, 'vs5hotbmult', 'Hot To Burn Multiplier', 'https://igamewin.com/storage/igamewin/191.webp', 1, 'PRAGMATIC', 1, 'slot', 0, 'igamewin'),
(177, 'vs20stickypos', 'Ice Lobster', 'https://igamewin.com/storage/igamewin/206.webp', 1, 'PRAGMATIC', 1, 'slot', 0, 'igamewin'),
(178, 'vs40infwild', 'Infective Wild', 'https://igamewin.com/storage/igamewin/247.webp', 1, 'PRAGMATIC', 1, 'slot', 0, 'igamewin'),
(179, 'vs20mvwild', 'Jasmine Dreams', 'https://igamewin.com/storage/igamewin/284.webp', 1, 'PRAGMATIC', 1, 'slot', 0, 'igamewin'),
(180, 'vs20jewelparty', 'Jewel Rush', 'https://igamewin.com/storage/igamewin/272.webp', 1, 'PRAGMATIC', 1, 'slot', 0, 'igamewin'),
(181, 'vs20sugarrush', 'Sugar Rush', 'https://igamewin.com/storage/igamewin/176.webp', 1, 'PRAGMATIC', 1, 'slot', 0, 'igamewin'),
(182, 'vs20clustcol', 'Sweet Kingdom', 'https://igamewin.com/storage/igamewin/171.webp', 1, 'PRAGMATIC', 1, 'slot', 0, 'igamewin'),
(7018, '112', 'Pyramid Raider', 'https://images.jiamengweiquan.com/cherry/icon/qkTykFxR.png', 1, 'slot-cq9', 1, 'slot', 3, 'igamewin'),
(7019, '125', 'Zeus M', 'https://images.jiamengweiquan.com/cherry/icon/DPnXZKQx.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7020, '123', 'Lucky Bats M', 'https://images.jiamengweiquan.com/cherry/icon/J1Nzx0J1.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7021, '129', 'Gu Gu Gu 2 M', 'https://images.jiamengweiquan.com/cherry/icon/hXsF4prq.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7022, '137', 'Disco Night M', 'https://images.jiamengweiquan.com/cherry/icon/EYe9gKUL.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7023, '118', 'SkrSkr', 'https://images.jiamengweiquan.com/cherry/icon/gSA0sJWW.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7024, '121', 'Rave Jump 2 M', 'https://images.jiamengweiquan.com/cherry/icon/B6WtMKzZ.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7025, '135', 'Gu Gu Gu M', 'https://images.jiamengweiquan.com/cherry/icon/OccXMvsd.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7026, '116', 'Wonderland', 'https://images.jiamengweiquan.com/cherry/icon/ZcsPXlbg.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7027, '115', 'Snow Queen', 'https://images.jiamengweiquan.com/cherry/icon/zaG4epx7.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7028, '221', 'Detective Dee 2', 'https://images.jiamengweiquan.com/cherry/icon/rnxFXz4M.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7029, '124', 'Invincible Elephant', 'https://images.jiamengweiquan.com/cherry/icon/sOuNJHuS.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7030, '131', 'Fa Cai Shen M', 'https://images.jiamengweiquan.com/cherry/icon/vIhTvyji.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7031, '109', 'Rave Jump mobile', 'https://images.jiamengweiquan.com/cherry/icon/FTOgWQxD.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7032, '122', 'Zuma Wild', 'https://images.jiamengweiquan.com/cherry/icon/bvDiSUot.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7033, '139', 'Fire Chibi M', 'https://images.jiamengweiquan.com/cherry/icon/2ydsCVXV.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7034, '127', 'God of War M', 'https://images.jiamengweiquan.com/cherry/icon/8MFGZdVV.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7035, '144', 'Diamond Treasure', 'https://images.jiamengweiquan.com/cherry/icon/Mu1a6J0d.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7036, '130', 'Gold Stealer', 'https://images.jiamengweiquan.com/cherry/icon/2LfJumfY.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7037, '138', 'Move n\' Jump', 'https://images.jiamengweiquan.com/cherry/icon/NMA5c7qp.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7038, '147', 'Flower Fortunes', 'https://images.jiamengweiquan.com/cherry/icon/3is7ZyOl.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7039, '157', '5 Boxing', 'https://images.jiamengweiquan.com/cherry/icon/4aI0yoPF.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7040, '132', 'Meow', 'https://images.jiamengweiquan.com/cherry/icon/7JNuaTTN.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7041, '142', 'Hephaestus', 'https://images.jiamengweiquan.com/cherry/icon/31qyLrb2.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7042, '143', 'Fa Cai Fu Wa', 'https://images.jiamengweiquan.com/cherry/icon/CMDpUcV7.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7043, '152', 'Double Fly', 'https://images.jiamengweiquan.com/cherry/icon/H1Mjnq2a.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7044, '153', 'Six Candy', 'https://images.jiamengweiquan.com/cherry/icon/h58qXy8j.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7045, '150', 'Shou-Xin', 'https://images.jiamengweiquan.com/cherry/icon/scwq2K9q.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7046, '148', 'Fortune Totem', 'https://images.jiamengweiquan.com/cherry/icon/wTXE7f95.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7047, '136', 'Running Animals', 'https://images.jiamengweiquan.com/cherry/icon/OEzu2TxD.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7048, '140', 'Fire Chibi 2', 'https://images.jiamengweiquan.com/cherry/icon/zeAzPHVB.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7049, '206', 'Sweet POP', 'https://images.jiamengweiquan.com/cherry/icon/ghppFsDy.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7050, '209', 'The Cupids', 'https://images.jiamengweiquan.com/cherry/icon/8LAvHcm3.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7051, '13', 'SakuraLegend', 'https://images.jiamengweiquan.com/cherry/icon/V4xFcXeB.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7052, '26', '777', 'https://images.jiamengweiquan.com/cherry/icon/TLC28bsL.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7053, '72', 'HappyRichYear', 'https://images.jiamengweiquan.com/cherry/icon/GIrO0snQ.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7054, '79', 'Chameleon', 'https://images.jiamengweiquan.com/cherry/icon/FFRRdPcq.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7055, '89', 'Thor', 'https://images.jiamengweiquan.com/cherry/icon/xd4z0bYW.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7056, '214', 'Ninja Raccoon', 'https://images.jiamengweiquan.com/cherry/icon/dOr9R2kQ.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7057, '8', 'SoSweet', 'https://images.jiamengweiquan.com/cherry/icon/l2pXvnE2.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7058, '15', 'GuGuGu', 'https://images.jiamengweiquan.com/cherry/icon/R7qHNfZf.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7059, '31', 'God of War', 'https://images.jiamengweiquan.com/cherry/icon/XdsdCyXK.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7060, '42', 'Sherlock Holmes', 'https://images.jiamengweiquan.com/cherry/icon/17tEE26p.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7061, '68', 'WuKong&Peaches', 'https://images.jiamengweiquan.com/cherry/icon/G72CaDlv.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7062, '80', 'Poseidon', 'https://images.jiamengweiquan.com/cherry/icon/h1V9idIR.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7063, '218', 'Dollar Bomb', 'https://images.jiamengweiquan.com/cherry/icon/tl9tGpmv.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7064, '187', 'Wing Chun', 'https://images.jiamengweiquan.com/cherry/icon/SRoNUPP6.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7065, '46', 'Wolf Moon', 'https://images.jiamengweiquan.com/cherry/icon/OIPQMNEH.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7066, '17', 'GreatLion', 'https://images.jiamengweiquan.com/cherry/icon/xekMMfqm.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7067, '64', 'Zeus', 'https://images.jiamengweiquan.com/cherry/icon/GnXe0qaD.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7068, '74', 'Treasure Bowl', 'https://images.jiamengweiquan.com/cherry/icon/ESogCyv6.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7069, '194', 'Fortune Dragon', 'https://images.jiamengweiquan.com/cherry/icon/FatieWGx.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7070, '197', 'Dragon\'s Treasure', 'https://images.jiamengweiquan.com/cherry/icon/B7tBS1CK.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7071, '210', 'Oo Ga Cha Ka', 'https://images.jiamengweiquan.com/cherry/icon/URat0NTk.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7072, '222', 'Loy Krathong', 'https://images.jiamengweiquan.com/cherry/icon/LRuR2t7j.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7073, '173', '6 Toros', 'https://images.jiamengweiquan.com/cherry/icon/R52AT7g9.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7074, '59', 'SummerMood', 'https://images.jiamengweiquan.com/cherry/icon/wvxjYGzX.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7075, '67', 'GoldenEggs', 'https://images.jiamengweiquan.com/cherry/icon/VGzJfXLS.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7076, '96', 'FootballBaby', 'https://images.jiamengweiquan.com/cherry/icon/U8LaXPLT.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7077, '5007', 'Da Fa Cai', 'https://static-r2.ibcsfaqcha.net/cq9/dafacai.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7078, '177', 'Aladdin\'s lamp', 'https://images.jiamengweiquan.com/cherry/icon/5Hu1PvAX.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7079, '154', 'Kronos', 'https://images.jiamengweiquan.com/cherry/icon/SLSCP1Dd.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7080, '32', 'Detective Dee', 'https://images.jiamengweiquan.com/cherry/icon/7SVoxQzw.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7081, '55', 'Dragon Heart', 'https://images.jiamengweiquan.com/cherry/icon/aGRJyWxE.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7082, '202', 'OrientalBeauty', 'https://images.jiamengweiquan.com/cherry/icon/zdtwRVhC.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7083, '203', 'RaveHigh', 'https://images.jiamengweiquan.com/cherry/icon/o7IXNkqO.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7084, '5009', 'Uproar in Heaven', 'https://static-r2.ibcsfaqcha.net/cq9/uproarinheaven.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7085, '171', 'Greek Gods', 'https://images.jiamengweiquan.com/cherry/icon/FnhHfeJD.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7086, '182', 'Thor 2', 'https://images.jiamengweiquan.com/cherry/icon/wlUmyslm.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7087, '16', 'Super5', 'https://images.jiamengweiquan.com/cherry/icon/P97Remip.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7088, '77', 'RedPhoenix', 'https://images.jiamengweiquan.com/cherry/icon/IMGvoCt1.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7089, '86', 'RunningToro', 'https://images.jiamengweiquan.com/cherry/icon/w73Y4I5Z.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7090, '220', 'Floating Market', 'https://images.jiamengweiquan.com/cherry/icon/zaGqaVxt.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7091, '33', 'Fire Chibi', 'https://images.jiamengweiquan.com/cherry/icon/uxeVBYcn.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7092, '44', 'Fruit King II', 'https://images.jiamengweiquan.com/cherry/icon/JnxxReWv.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7093, '49', 'Lonely Planet', 'https://images.jiamengweiquan.com/cherry/icon/nIbfa1mZ.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7094, '76', 'WonWonWon', 'https://images.jiamengweiquan.com/cherry/icon/joK8d56Y.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7095, '212', 'Burning Xi-You', 'https://images.jiamengweiquan.com/cherry/icon/ACqGmHvE.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7096, '211', 'King of Atlantis', 'https://images.jiamengweiquan.com/cherry/icon/AK9ebmsy.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7097, '219', 'King Kong Shake', 'https://images.jiamengweiquan.com/cherry/icon/EYSNJNc7.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7098, '3', 'VampireKiss', 'https://images.jiamengweiquan.com/cherry/icon/j6yXzx7I.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7099, '34', 'Gophers War', 'https://images.jiamengweiquan.com/cherry/icon/x5yPsK1M.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7100, '38', 'All Wilds', 'https://images.jiamengweiquan.com/cherry/icon/yPn5SSj8.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7101, '51', 'Ecstatic Circus', 'https://images.jiamengweiquan.com/cherry/icon/l6yhx0hx.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7102, '70', 'WanBaoDino', 'https://images.jiamengweiquan.com/cherry/icon/iSYzExKo.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7103, '83', 'FireQueen', 'https://images.jiamengweiquan.com/cherry/icon/okYFfluF.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7104, '179', 'Jump High 2', 'https://images.jiamengweiquan.com/cherry/icon/Lsng4kDo.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7105, '186', 'Fire Queen 2', 'https://images.jiamengweiquan.com/cherry/icon/ukH8rpTT.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7106, '184', 'Six Gacha', 'https://images.jiamengweiquan.com/cherry/icon/8zz928W9.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7107, '1', 'FruitKing', 'https://images.jiamengweiquan.com/cherry/icon/M5k8fcBE.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7108, '20', '888', 'https://images.jiamengweiquan.com/cherry/icon/AVVZZDTL.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7109, '57', 'The Beast War', 'https://images.jiamengweiquan.com/cherry/icon/3xReDmGC.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7110, '66', 'Fire777', 'https://images.jiamengweiquan.com/cherry/icon/6KyGSa7t.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7111, '78', 'Apollo', 'https://images.jiamengweiquan.com/cherry/icon/t04iYWeL.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7112, '5', 'Mr.Rich', 'https://images.jiamengweiquan.com/cherry/icon/p6IdSgsl.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7113, '9', 'ZhongKui', 'https://images.jiamengweiquan.com/cherry/icon/Qp8HJX37.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7114, '21', 'BigWolf', 'https://images.jiamengweiquan.com/cherry/icon/A6vuOK7r.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7115, '23', 'YuanBao', 'https://images.jiamengweiquan.com/cherry/icon/Y0ZLI4RN.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7116, '24', 'RaveJump2', 'https://images.jiamengweiquan.com/cherry/icon/3P0UBk4c.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7117, '36', 'Pub Tycoon', 'https://images.jiamengweiquan.com/cherry/icon/aB1Lgsld.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7118, '183', 'Wolf Disco', 'https://images.jiamengweiquan.com/cherry/icon/AVVZZDTL.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7119, '7', 'RaveJump', 'https://images.jiamengweiquan.com/cherry/icon/20x1jSLJ.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7120, '52', 'Jump High', 'https://images.jiamengweiquan.com/cherry/icon/PCddPyrH.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7121, '54', 'Funny Alpaca', 'https://images.jiamengweiquan.com/cherry/icon/CCUV6GQb.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7122, '69', 'FaCaiShen', 'https://images.jiamengweiquan.com/cherry/icon/dYSFNGvb.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7123, '35', 'CrazyNuozha', 'https://images.jiamengweiquan.com/cherry/icon/UFUdbq0z.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7124, '95', 'FootballBoots', 'https://images.jiamengweiquan.com/cherry/icon/U9epZh4q.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7125, '204', 'LuckyBoxes', 'https://images.jiamengweiquan.com/cherry/icon/58EgLK90.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7126, '199', 'Songkran Festival', 'https://images.jiamengweiquan.com/cherry/icon/93i7A6P9.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7127, '12', 'TreasureHouse', 'https://images.jiamengweiquan.com/cherry/icon/41REF4m9.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7128, '19', 'HotSpin', 'https://images.jiamengweiquan.com/cherry/icon/JjppyVxd.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7129, '22', 'MonkeyOfficeLegend', 'https://images.jiamengweiquan.com/cherry/icon/ECTGAb9g.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7130, '27', 'Magic World', 'https://images.jiamengweiquan.com/cherry/icon/oRmX2erV.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7131, '39', 'Apsaras', 'https://images.jiamengweiquan.com/cherry/icon/HEu1Pcbb.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7132, '105', 'Jumping Mobile', 'https://images.jiamengweiquan.com/cherry/icon/zY84kunx.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7133, '195', 'Lord Ganesha', 'https://images.jiamengweiquan.com/cherry/icon/guLGMUxR.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7134, '223', 'Acrobatics', 'https://images.jiamengweiquan.com/cherry/icon/md8hnuwC.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7135, '98', 'All Star Team', 'https://images.jiamengweiquan.com/cherry/icon/Okh58PC3.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7136, '208', 'Money Tree', 'https://images.jiamengweiquan.com/cherry/icon/JOeIAmue.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7137, '188', 'Cricket Fever', 'https://images.jiamengweiquan.com/cherry/icon/5FmroacQ.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7138, '2', 'GodOfChess', 'https://images.jiamengweiquan.com/cherry/icon/xz7zurdV.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7139, '4', 'WildTarzan', 'https://images.jiamengweiquan.com/cherry/icon/0IT0ytjx.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7140, '10', 'LuckyBats', 'https://images.jiamengweiquan.com/cherry/icon/0s2JAojt.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7141, '81', 'Treasure Island', 'https://images.jiamengweiquan.com/cherry/icon/RsviagHn.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7142, '92', 'WorldCupRussia2018', 'https://images.jiamengweiquan.com/cherry/icon/yQV8hHsM.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7143, '205', 'DiscoNight', 'https://images.jiamengweiquan.com/cherry/icon/jR7hDhP5.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7144, '5008', 'Da Hong Zhong', 'https://static-r2.ibcsfaqcha.net/cq9/dahongzhong.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7145, '226', 'Lucky Tigers', 'https://images.jiamengweiquan.com/cherry/icon/HZMTD7vZ.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7146, '225', 'Mr. Miser', 'https://images.jiamengweiquan.com/cherry/icon/ouxlCOaf.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7147, '227', '888 Cai Shen', 'https://images.jiamengweiquan.com/cherry/icon/LwhKroKO.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7148, '228', 'Mirror Mirror', 'https://images.jiamengweiquan.com/cherry/icon/hUSvRvpt.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7149, '231', 'Striker WILD', 'https://images.jiamengweiquan.com/cherry/icon/qZV1fWFy.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7150, '241', 'The Chicken House', 'https://images.jiamengweiquan.com/cherry/icon/HUUzbeUj.png', 1, 'SLOT-CQ9', 1, 'slot', 3, 'igamewin'),
(7193, '14087', 'POP POP CANDY', 'https://dl.lfyanwei.com/jdb-assetsv3/games/14087/14087_en.png', 1, 'slot-jdb', 1, 'slot', 3, 'igamewin'),
(7194, '14086', 'Open Sesame Mega', 'https://dl.lfyanwei.com/jdb-assetsv3/games/14086/14086_en.png', 1, 'slot-jdb', 1, 'slot', 3, 'igamewin'),
(7195, '14042', 'TREASURE BOWL', 'https://dl.lfyanwei.com/jdb-assetsv3/games/14042/14042_en.png', 1, 'slot-jdb', 1, 'slot', 3, 'igamewin'),
(7196, '14085', 'FRUITY BONANZA', 'https://dl.lfyanwei.com/jdb-assetsv3/games/14085/14085_en.png', 1, 'slot-jdb', 1, 'slot', 3, 'igamewin'),
(7197, '14083', 'COOCOO FARM', 'https://dl.lfyanwei.com/jdb-assetsv3/games/14083/14083_en.png', 1, 'slot-jdb', 1, 'slot', 3, 'igamewin'),
(7198, '14082', 'Elemental Link Water', 'https://dl.lfyanwei.com/jdb-assetsv3/games/14082/14082_en.png', 1, 'slot-jdb', 1, 'slot', 3, 'igamewin'),
(7199, '14080', 'ELEMENTAL LINK FIRE', 'https://dl.lfyanwei.com/jdb-assetsv3/games/14080/14080_en.png', 1, 'slot-jdb', 1, 'slot', 3, 'igamewin'),
(7200, '14077', 'TRUMPCARD', 'https://dl.lfyanwei.com/jdb-assetsv3/games/14077/14077_en.png', 1, 'slot-jdb', 1, 'slot', 3, 'igamewin'),
(7201, '14075', 'FORTUNE NEKO', 'https://dl.lfyanwei.com/jdb-assetsv3/games/14075/14075_en.png', 1, 'slot-jdb', 1, 'slot', 3, 'igamewin'),
(7202, '14070', 'BOOK OF MYSTERY', 'https://dl.lfyanwei.com/jdb-assetsv3/games/14070/14070_en.png', 1, 'slot-jdb', 1, 'slot', 3, 'igamewin'),
(7203, '14068', 'PROSPERITY TIGER', 'https://dl.lfyanwei.com/jdb-assetsv3/games/14068/14068_en.png', 1, 'slot-jdb', 1, 'slot', 3, 'igamewin'),
(7204, '14065', 'BLOSSOM OF WEALTH', 'https://dl.lfyanwei.com/jdb-assetsv3/games/14065/14065_en.png', 1, 'slot-jdb', 1, 'slot', 3, 'igamewin'),
(7205, '14064', 'BOOM FIESTA', 'https://dl.lfyanwei.com/jdb-assetsv3/games/14064/14064_en.png', 1, 'slot-jdb', 1, 'slot', 3, 'igamewin'),
(7206, '14063', 'CRAZYBIG THREE DRAGONS', 'https://dl.lfyanwei.com/jdb-assetsv3/games/14063/14063_en.png', 1, 'slot-jdb', 1, 'slot', 3, 'igamewin'),
(7207, '14060', 'LANTERN WEALTH', 'https://dl.lfyanwei.com/jdb-assetsv3/games/14060/14060_en.png', 1, 'slot-jdb', 1, 'slot', 3, 'igamewin'),
(7208, '14061', 'MAYA GOLD', 'https://dl.lfyanwei.com/jdb-assetsv3/games/14061/14061_en.png', 1, 'slot-jdb', 1, 'slot', 3, 'igamewin'),
(7209, '14059', 'MARVELOUS IV', 'https://dl.lfyanwei.com/jdb-assetsv3/games/14059/14059_en.png', 1, 'slot-jdb', 1, 'slot', 3, 'igamewin'),
(7210, '14058', 'WONDER ELEPHANT', 'https://dl.lfyanwei.com/jdb-assetsv3/games/14058/14058_en.png', 1, 'slot-jdb', 1, 'slot', 3, 'igamewin'),
(7211, '14055', 'KONG', 'https://dl.lfyanwei.com/jdb-assetsv3/games/14055/14055_en.png', 1, 'slot-jdb', 1, 'slot', 3, 'igamewin'),
(7212, '14052', 'JUNGLE JUNGLE', 'https://dl.lfyanwei.com/jdb-assetsv3/games/14052/14052_en.png', 1, 'slot-jdb', 1, 'slot', 3, 'igamewin'),
(7213, '14054', 'LUCKY DIAMOND', 'https://dl.lfyanwei.com/jdb-assetsv3/games/14054/14054_en.png', 1, 'slot-jdb', 1, 'slot', 3, 'igamewin'),
(7214, '8049', 'FLIRTING SCHOLAR TANG Ⅱ', 'https://dl.lfyanwei.com/jdb-assetsv3/games/8049/8049_en.png', 1, 'slot-jdb', 1, 'slot', 3, 'igamewin'),
(7215, '8047', 'WINNING MASK Ⅱ', 'https://dl.lfyanwei.com/jdb-assetsv3/games/8047/8047_en.png', 1, 'slot-jdb', 1, 'slot', 3, 'igamewin'),
(7216, '14048', 'DOUBLE WILDS', 'https://dl.lfyanwei.com/jdb-assetsv3/games/14048/14048_en.png', 1, 'slot-jdb', 1, 'slot', 3, 'igamewin'),
(7217, '14047', 'MONEYBAGS MAN', 'https://dl.lfyanwei.com/jdb-assetsv3/games/14047/14047_en.png', 1, 'slot-jdb', 1, 'slot', 3, 'igamewin'),
(7218, '14043', 'GOLDEN DISCO', 'https://dl.lfyanwei.com/jdb-assetsv3/games/14043/14043_en.png', 1, 'slot-jdb', 1, 'slot', 3, 'igamewin'),
(7219, '14045', 'Super Niubi Deluxe', 'https://dl.lfyanwei.com/jdb-assetsv3/games/14045/14045_en.png', 1, 'slot-jdb', 1, 'slot', 3, 'igamewin'),
(7220, '14044', 'FUNKY KING KONG', 'https://dl.lfyanwei.com/jdb-assetsv3/games/14044/14044_en.png', 1, 'slot-jdb', 1, 'slot', 3, 'igamewin'),
(7221, '14040', 'PIRATE TREASURE', 'https://dl.lfyanwei.com/jdb-assetsv3/games/14040/14040_en.png', 1, 'slot-jdb', 1, 'slot', 3, 'igamewin'),
(7222, '14039', 'FORTUNE TREASURE', 'https://dl.lfyanwei.com/jdb-assetsv3/games/14039/14039_en.png', 1, 'slot-jdb', 1, 'slot', 3, 'igamewin'),
(7223, '14038', 'EGYPT TREASURE', 'https://dl.lfyanwei.com/jdb-assetsv3/games/14038/14038_en.png', 1, 'slot-jdb', 1, 'slot', 3, 'igamewin'),
(7224, '14034', 'GO LAI FU', 'https://dl.lfyanwei.com/jdb-assetsv3/games/14034/14034_en.png', 1, 'slot-jdb', 1, 'slot', 3, 'igamewin'),
(7225, '8050', 'FORTUNE HORSE', 'https://dl.lfyanwei.com/jdb-assetsv3/games/8050/8050_en.png', 1, 'slot-jdb', 1, 'slot', 3, 'igamewin'),
(7226, '14027', '777ORIENT', 'https://dl.lfyanwei.com/jdb-assetsv3/games/14027/14027_en.png', 1, 'slot-jdb', 1, 'slot', 3, 'igamewin'),
(7227, '8048', 'OPEN SESAME Ⅱ', 'https://i.ibb.co/zZXcGNV/Open-Sesame-II-250x203-en.jpg', 1, 'slot-jdb', 1, 'slot', 3, 'igamewin'),
(7228, '7003', 'CaiShenFishing', 'https://api.jdbgaming.com/assets/upload/images/game/cover-9778d5d219c5080b9a6a17bef029331c.png', 1, 'fishing-jdb', 1, 'slot', 3, 'igamewin'),
(7229, '7004', 'Shade Dragons Fishing', 'https://api.jdbgaming.com/assets/upload/images/game/cover-a3c65c2974270fd093ee8a9bf8ae7d0b.png', 1, 'fishing-jdb', 1, 'slot', 3, 'igamewin'),
(7230, '7005', 'Fishing Yilufa', 'https://api.jdbgaming.com/assets/upload/images/game/cover-eb160de1de89d9058fcb0b968dbbbd68.png', 1, 'fishing-jdb', 1, 'slot', 3, 'igamewin'),
(7231, 'holy-heist', 'Holy Heist', 'https://bc.imgix.net/game/image/0040ac0db0.png', 1, 'slot-hacksaw', 1, 'slot', 3, 'igamewin'),
(7232, 'dragon-s-domain', 'Dragon’s Domain', 'https://bc.imgix.net/game/image/dcb346ee4d.png', 1, 'slot-hacksaw', 1, 'slot', 3, 'igamewin'),
(7233, 'old-gun', 'Old Gun', 'https://bc.imgix.net/game/image/aab8aa161e.png', 1, 'slot-hacksaw', 1, 'slot', 3, 'igamewin'),
(7234, 'donny-dough', 'Donny Dough', 'https://bc.imgix.net/game/image/8c2358949a.png', 1, 'slot-hacksaw', 1, 'slot', 3, 'igamewin'),
(7235, 'pirate-bonanza', 'Pirate Bonanza', 'https://bc.imgix.net/game/image/2c37bb8398.png', 1, 'slot-hacksaw', 1, 'slot', 3, 'igamewin'),
(7236, 'pickle-bandits', 'Pickle Bandits', 'https://bc.imgix.net/game/image/f7a80ff414.png', 1, 'slot-hacksaw', 1, 'slot', 3, 'igamewin'),
(7237, 'tai-the-toad', 'Tai the Toad', 'https://bc.imgix.net/game/image/8ad8d38094.png?_v=4&auto=format&dpr=1&w=200', 1, 'slot-hacksaw', 1, 'slot', 3, 'igamewin'),
(7238, 'octo-attack', 'Octo Attack', 'https://bc.imgix.net/game/image/eba3e4fef9.png', 1, 'slot-hacksaw', 1, 'slot', 3, 'igamewin'),
(7239, 'cup-heroes', 'Cup Heroes', 'https://hacksaw.goldengatex.com/game-img/logo/cup-heroes.jpeg', 1, 'slot-hacksaw', 1, 'slot', 3, 'igamewin'),
(7240, 'jawsome-pirates', 'Jawsome Pirates', 'https://bc.imgix.net/game/image/556a5b6eaa.png?_v=4&auto=format&dpr=1&w=200', 1, 'slot-hacksaw', 1, 'slot', 3, 'igamewin'),
(7241, 'desert-temple', 'Desert Temple', 'https://bc.imgix.net/game/image/9481e6aae6.png?_v=4&auto=format&dpr=1&w=200', 1, 'slot-hacksaw', 1, 'slot', 3, 'igamewin'),
(7242, 'evil-eyes', 'Evil Eyes', 'https://bc.imgix.net/game/image/ab92e00911.png?_v=4&auto=format&dpr=1&w=200', 1, 'slot-hacksaw', 1, 'slot', 3, 'igamewin'),
(7243, 'ze-zeus', 'Ze Zeus', 'https://bc.imgix.net/game/image/fbcc71adf2.png', 1, 'slot-hacksaw', 1, 'slot', 3, 'igamewin'),
(7244, 'wanted-dead-or-a-wild', 'Wanted Dead or a Wild', 'https://bc.imgix.net/game/image/3bb2f8446f.png', 1, 'slot-hacksaw', 1, 'slot', 3, 'igamewin'),
(7245, 'le-bandit', 'Le Bandit', 'https://bc.imgix.net/game/image/cfdb2fe04a.png', 1, 'slot-hacksaw', 1, 'slot', 3, 'igamewin'),
(7246, 'rip-city', 'Rip City', 'https://bc.imgix.net/game/image/47265b5161.png', 1, 'slot-hacksaw', 1, 'slot', 3, 'igamewin'),
(7247, 'shadow-strike', 'Shadow Strike', 'https://bc.imgix.net/game/image/d20b0f4a22.png', 1, 'slot-hacksaw', 1, 'slot', 3, 'igamewin'),
(7248, 'slayers-inc', 'Slayers INC', 'https://bc.imgix.net/game/image/7da25263f9.png', 1, 'slot-hacksaw', 1, 'slot', 3, 'igamewin'),
(7249, 'fist-of-destruction', 'Fist of Destruction', 'https://bc.imgix.net/game/image/d47fd59815.png', 1, 'slot-hacksaw', 1, 'slot', 3, 'igamewin'),
(7250, 'dork-unit', 'Dork Unit', 'https://bc.imgix.net/game/image/da9db5a0f2.png', 1, 'slot-hacksaw', 1, 'slot', 3, 'igamewin'),
(7251, 'stormforged', 'Stormforged', 'https://bc.imgix.net/game/image/126be620de.png', 1, 'slot-hacksaw', 1, 'slot', 3, 'igamewin'),
(7252, 'hand-of-anubis', 'Hand of Anubis', 'https://bc.imgix.net/game/image/10234_Hand%20of%20Anubis.png', 1, 'slot-hacksaw', 1, 'slot', 3, 'igamewin'),
(7253, 'densho', 'Densho', 'https://bc.imgix.net/game/image/2de18aef4a.png', 1, 'slot-hacksaw', 1, 'slot', 3, 'igamewin'),
(7254, 'book-of-time', 'Book of Time', 'https://hacksaw.goldengatex.com/game-img/logo/book-of-time.jpeg', 1, 'slot-hacksaw', 1, 'slot', 3, 'igamewin'),
(7255, 'rotten', 'Rotten', 'https://bc.imgix.net/game/image/387c8b6e00.png', 1, 'slot-hacksaw', 1, 'slot', 3, 'igamewin'),
(7256, 'xmas-drop', 'Xmas Drop', 'https://bc.imgix.net/game/image/e8ed230c47.png', 1, 'slot-hacksaw', 1, 'slot', 3, 'igamewin');
INSERT INTO `games` (`id`, `game_code`, `game_name`, `banner`, `status`, `provider`, `popular`, `type`, `game_type`, `distribution`) VALUES
(7257, 'chaos-crew-ii', 'Chaos Crew II', 'https://bc.imgix.net/game/image/e906c6dada.png', 1, 'slot-hacksaw', 1, 'slot', 3, 'igamewin'),
(7258, 'beast-below', 'Beast Below', 'https://bc.imgix.net/game/image/4a7db10d54.png', 1, 'slot-hacksaw', 1, 'slot', 3, 'igamewin'),
(7259, 'divine-drop', 'Divine Drop', 'https://bc.imgix.net/game/image/ec22796b7b.png', 1, 'slot-hacksaw', 1, 'slot', 3, 'igamewin'),
(7260, '2-wild-2-die', '2 Wild 2 Die', 'https://bc.imgix.net/game/image/30a4ec5cf0.png', 1, 'slot-hacksaw', 1, 'slot', 3, 'igamewin'),
(7261, 'magic-piggy', 'Magic Piggy', 'https://bc.imgix.net/game/image/852db221c8.png', 1, 'slot-hacksaw', 1, 'slot', 3, 'igamewin'),
(7262, 'drop-em', 'Drop\'em', 'https://bc.imgix.net/game/image/e1be0d5586.png', 1, 'slot-hacksaw', 1, 'slot', 3, 'igamewin'),
(7263, 'cursed-crypt', 'Cursed Crypt', 'https://bc.imgix.net/game/image/ce6d5b0b6e.png', 1, 'slot-hacksaw', 1, 'slot', 3, 'igamewin'),
(7264, 'cash-crew', 'Cash Crew', 'https://hacksaw.goldengatex.com/game-img/logo/cash-crew.jpeg', 1, 'slot-hacksaw', 1, 'slot', 3, 'igamewin'),
(7265, 'junkyard-kings', 'Junkyard Kings', 'https://bc.imgix.net/game/image/55e7480b42.png', 1, 'slot-hacksaw', 1, 'slot', 3, 'igamewin'),
(7266, 'immortal-desire', 'Immortal Desire', 'https://bc.imgix.net/game/image/960b402aa8.png', 1, 'slot-hacksaw', 1, 'slot', 3, 'igamewin'),
(7267, 'barrel-bonanza', 'Barrel Bonanza', 'https://bc.imgix.net/game/image/10319a0087.png', 1, 'slot-hacksaw', 1, 'slot', 3, 'igamewin'),
(7268, 'temple-of-torment', 'Temple of Torment', 'https://bc.imgix.net/game/image/31cbbe09eb.png', 1, 'slot-hacksaw', 1, 'slot', 3, 'igamewin'),
(7269, 'rusty-curly', 'Rusty & Curly', 'https://bc.imgix.net/game/image/8b34c5db26.png', 1, 'slot-hacksaw', 1, 'slot', 3, 'igamewin'),
(7270, 'cursed-seas', 'Cursed Seas', 'https://bc.imgix.net/game/image/806911bd1f.png', 1, 'slot-hacksaw', 1, 'slot', 3, 'igamewin'),
(7271, 'toshi-video-club', 'Toshi Video Club', 'https://bc.imgix.net/game/image/79cba4f5ef.png', 1, 'slot-hacksaw', 1, 'slot', 3, 'igamewin'),
(7272, 'keep-em', 'Keep \'em', 'https://bc.imgix.net/game/image/7846ae6daf.png', 1, 'slot-hacksaw', 1, 'slot', 3, 'igamewin'),
(7273, 'benny-the-beer', 'Benny the Beer', 'https://bc.imgix.net/game/image/92f9535443.png', 1, 'slot-hacksaw', 1, 'slot', 3, 'igamewin'),
(7274, 'itero', 'Itero', 'https://bc.imgix.net/game/image/10458_Itero.png?_v=4&auto=format&dpr=1&w=200', 1, 'slot-hacksaw', 1, 'slot', 3, 'igamewin'),
(7275, 'dark-summoning', 'Dark Summoning', 'https://bc.imgix.net/game/image/33e44c544a.png', 1, 'slot-hacksaw', 1, 'slot', 3, 'igamewin'),
(7276, 'eye-of-the-panda', 'Eye of the Panda', 'https://bc.imgix.net/game/image/c9d07079bf.png', 1, 'slot-hacksaw', 1, 'slot', 3, 'igamewin'),
(7277, 'undead-fortune', 'Undead Fortune', 'https://bc.imgix.net/game/image/bfbf4f1f15.png', 1, 'slot-hacksaw', 1, 'slot', 3, 'igamewin'),
(7278, 'gladiator-legends', 'Gladiator Legends', 'https://bc.imgix.net/game/image/9852_Gladiator%20Legends.png?_v=4&auto=format&dpr=1&w=200', 1, 'slot-hacksaw', 1, 'slot', 3, 'igamewin'),
(7279, 'stack-em', 'Stack \'em', 'https://bc.imgix.net/game/image/8f3f14b776.png', 1, 'slot-hacksaw', 1, 'slot', 3, 'igamewin'),
(7280, 'double-rainbow', 'Double Rainbow', 'https://bc.imgix.net/game/image/5119d9c41f.png?_v=4&auto=format&dpr=1&w=200', 1, 'slot-hacksaw', 1, 'slot', 3, 'igamewin'),
(7281, 'space-zoo', 'Space Zoo', 'https://bc.imgix.net/game/image/3d97535697.png', 1, 'slot-hacksaw', 1, 'slot', 3, 'igamewin'),
(7282, 'franks-farm', 'Frank\'s Farm', 'https://bc.imgix.net/game/image/0c2ec5d20f.png', 1, 'slot-hacksaw', 1, 'slot', 3, 'igamewin'),
(7283, 'jelly-slice', 'Jelly Slice', 'https://bc.imgix.net/game/image/eda04ea4f7.png', 1, 'slot-hacksaw', 1, 'slot', 3, 'igamewin'),
(7284, 'bloodthirst', 'Bloodthirst', 'https://bc.imgix.net/game/image/fe6228b0d1.png', 1, 'slot-hacksaw', 1, 'slot', 3, 'igamewin'),
(7285, 'fire-born', 'Fire Born', 'https://bc.imgix.net/game/image/eabfaca078.png', 1, 'slot-hacksaw', 1, 'slot', 3, 'igamewin'),
(7286, 'bouncy-bombs', 'Bouncy Bombs', 'https://bc.imgix.net/game/image/a91120458d.png', 1, 'slot-hacksaw', 1, 'slot', 3, 'igamewin'),
(7287, 'the-cursed-king', 'The Cursed King', 'https://bc.imgix.net/game/image/92cbea8d4d.png', 1, 'slot-hacksaw', 1, 'slot', 3, 'igamewin'),
(7288, 'outlaws-inc', 'Outlaws Inc', 'https://www-live.hacksawgaming.com/casino_thumbnails/1083.jpg', 1, 'slot-hacksaw', 1, 'slot', 3, 'igamewin'),
(7289, 'time-spinners', 'Time Spinners', 'https://bc.imgix.net/game/image/734ef5cd63.png', 1, 'slot-hacksaw', 1, 'slot', 3, 'igamewin'),
(7290, 'chaos-crew', 'Chaos Crew', 'https://bc.imgix.net/game/image/9fcaea4df9.png', 1, 'slot-hacksaw', 1, 'slot', 3, 'igamewin'),
(7291, 'fruit-duel', 'Fruit Duel', 'https://bc.imgix.net/game/image/1f4a995f3d.png', 1, 'slot-hacksaw', 1, 'slot', 3, 'igamewin'),
(7292, 'wild-dojo-strike', 'Wild Dojo Strike', 'https://bc.imgix.net/game/image/0c04da554c.png', 1, 'slot-hacksaw', 1, 'slot', 3, 'igamewin'),
(7293, 'fear-the-dark', 'Fear The Dark', 'https://bc.imgix.net/game/image/c4957a0a21.png', 1, 'slot-hacksaw', 1, 'slot', 3, 'igamewin'),
(7294, 'merlins-alchemy', 'Merlin\'s Alchemy', 'https://bc.imgix.net/game/image/b733514070.png', 1, 'slot-hacksaw', 1, 'slot', 3, 'igamewin'),
(7295, 'commander-of-tridents', 'Commander of Tridents', 'https://bc.imgix.net/game/image/33eb431787.png', 1, 'slot-hacksaw', 1, 'slot', 3, 'igamewin'),
(7296, 'alpha-eagle', 'Alpha Eagle', 'https://bc.imgix.net/game/image/aa05ecadb5.png', 1, 'slot-hacksaw', 1, 'slot', 3, 'igamewin'),
(7297, 'feel-the-beat', 'Feel the Beat', 'https://bc.imgix.net/game/image/01d01eda2d.png', 1, 'slot-hacksaw', 1, 'slot', 3, 'igamewin'),
(7298, 'gronks-gems', 'Gronk\'s Gems', 'https://bc.imgix.net/game/image/31a7d43c16.png', 1, 'slot-hacksaw', 1, 'slot', 3, 'igamewin'),
(7299, 'cubes2', 'Cubes2', 'https://bc.imgix.net/game/image/6596_Cubes2.png?_v=4&auto=format&dpr=1&w=200', 1, 'slot-hacksaw', 1, 'slot', 3, 'igamewin'),
(7300, 'hop-n-pop', 'Hop \'n Pop', 'https://bc.imgix.net/game/image/b9748197fc.png', 1, 'slot-hacksaw', 1, 'slot', 3, 'igamewin'),
(7301, 'mafia-clash', 'Mafia Clash', 'https://bc.imgix.net/game/image/2f1ae26dc1.png', 1, 'slot-hacksaw', 1, 'slot', 3, 'igamewin'),
(7302, 'the-bowery-boys', 'The Bowery Boys', 'https://bc.imgix.net/game/image/8638_The%20Bowery%20Boys.png?_v=4&auto=format&dpr=1&w=200', 1, 'slot-hacksaw', 1, 'slot', 3, 'igamewin'),
(7303, 'orb-of-destiny', 'Orb of Destiny', 'https://bc.imgix.net/game/image/7607f1107b.png', 1, 'slot-hacksaw', 1, 'slot', 3, 'igamewin'),
(7304, 'mighty-masks', 'Mighty Masks', 'https://bc.imgix.net/game/image/f8965ebc04.png', 1, 'slot-hacksaw', 1, 'slot', 3, 'igamewin'),
(7305, 'born-wild', 'Born WILD', 'https://bc.imgix.net/game/image/6609_Born%20WILD.png?_v=4&auto=format&dpr=1&w=200', 1, 'slot-hacksaw', 1, 'slot', 3, 'igamewin'),
(7306, 'joker-bombs', 'Joker Bombs', 'https://bc.imgix.net/game/image/837e4f501e.png?_v=4&auto=format&dpr=1&w=200', 1, 'slot-hacksaw', 1, 'slot', 3, 'igamewin'),
(7307, 'lord-venom', 'Lord Venom', 'https://bc.imgix.net/game/image/9105bfa325.png', 1, 'slot-hacksaw', 1, 'slot', 3, 'igamewin'),
(7308, 'blademaster', 'Blademaster', 'https://bc.imgix.net/game/image/7e9c72f5d6.png', 1, 'slot-hacksaw', 1, 'slot', 3, 'igamewin'),
(7309, 'vending-machine', 'Vending Machine', 'https://bc.imgix.net/game/image/e4e64b646d.png', 1, 'slot-hacksaw', 1, 'slot', 3, 'igamewin'),
(7310, 'buffalo-stack-n-sync', 'Buffalo Stack \'n\' Sync', 'https://bc.imgix.net/game/image/62badc0668.png?_v=4&auto=format&dpr=1&w=200', 1, 'slot-hacksaw', 1, 'slot', 3, 'igamewin'),
(7311, 'harvest-wilds', 'Harvest Wilds', 'https://bc.imgix.net/game/image/8214_Harvest%20Wilds.png?_v=4&auto=format&dpr=1&w=200', 1, 'slot-hacksaw', 1, 'slot', 3, 'igamewin'),
(7312, 'breakbones', 'BreakBones', 'https://bc.imgix.net/game/image/a854e955a4.png', 1, 'slot-hacksaw', 1, 'slot', 3, 'igamewin'),
(7313, 'xpander', 'Xpander', 'https://bc.imgix.net/game/image/b4c5bd0ff3.png', 1, 'slot-hacksaw', 1, 'slot', 3, 'igamewin'),
(7314, 'piggy-cluster-hunt', 'Piggy Cluster Hunt', 'https://bc.imgix.net/game/image/06b82f09b5.png', 1, 'slot-hacksaw', 1, 'slot', 3, 'igamewin'),
(7315, 'frutz', 'Frutz', 'https://bc.imgix.net/game/image/485654793e.png', 1, 'slot-hacksaw', 1, 'slot', 3, 'igamewin'),
(7316, 'king-carrot', 'King Carrot', 'https://bc.imgix.net/game/image/0f0eb98abe.png', 1, 'slot-hacksaw', 1, 'slot', 3, 'igamewin'),
(7317, 'mystery-motel', 'Mystery Motel', 'https://bc.imgix.net/game/image/e2188d8c09.png', 1, 'slot-hacksaw', 1, 'slot', 3, 'igamewin'),
(7318, 'rocket-reels', 'Rocket Reels', 'https://bc.imgix.net/game/image/defaa176dd.png', 1, 'slot-hacksaw', 1, 'slot', 3, 'igamewin'),
(7319, 'cash-compass', 'Cash Compass', 'https://bc.imgix.net/game/image/c301547c54.png', 1, 'slot-hacksaw', 1, 'slot', 3, 'igamewin'),
(7320, 'tasty-treats', 'Tasty Treats', 'https://bc.imgix.net/game/image/51bf2cae02.png', 1, 'slot-hacksaw', 1, 'slot', 3, 'igamewin'),
(7321, 'keep-em-cool', 'Keep\'em Cool', 'https://bc.imgix.net/game/image/7aaab25c54.png', 1, 'slot-hacksaw', 1, 'slot', 3, 'igamewin'),
(7322, 'forest-fortune', 'Forest Fortune', 'https://bc.imgix.net/game/image/242686b590.png', 1, 'slot-hacksaw', 1, 'slot', 3, 'igamewin'),
(7323, 'sleepy-grandpa', 'Sleepy Grandpa', 'https://bc.imgix.net/game/image/bb18570742.png', 1, 'slot-hacksaw', 1, 'slot', 3, 'igamewin'),
(7324, 'warrior-ways', 'Warrior Ways', 'https://bc.imgix.net/game/image/9638_Warrior%20Ways.png?_v=4&auto=format&dpr=1&w=200', 1, 'slot-hacksaw', 1, 'slot', 3, 'igamewin'),
(7325, 'the-respinners', 'The Respinners', 'https://bc.imgix.net/game/image/cdf1d75ca8.png', 1, 'slot-hacksaw', 1, 'slot', 3, 'igamewin'),
(7326, 'cash-quest', 'Cash Quest', 'https://bc.imgix.net/game/image/04931a393b.png', 1, 'slot-hacksaw', 1, 'slot', 3, 'igamewin'),
(7327, 'omnom', 'OmNom', 'https://bc.imgix.net/game/image/502dec581a.png', 1, 'slot-hacksaw', 1, 'slot', 3, 'igamewin'),
(7328, 'stickem', 'Stickem', 'https://bc.imgix.net/game/image/1dbf801edb.png', 1, 'slot-hacksaw', 1, 'slot', 3, 'igamewin'),
(7329, 'cubes', 'Cubes', 'https://bc.imgix.net/game/image/95e074e5de.png', 1, 'slot-hacksaw', 1, 'slot', 3, 'igamewin'),
(7330, 'aztec-twist', 'Aztec Twist', 'https://bc.imgix.net/game/image/e1cd43412e.png', 1, 'slot-hacksaw', 1, 'slot', 3, 'igamewin'),
(7331, 'miamimultiplier', 'MiamiMultiplier', 'https://bc.imgix.net/game/image/5080a67980.png', 1, 'slot-hacksaw', 1, 'slot', 3, 'igamewin'),
(7332, 'freds-food-truck', 'Fred\'s Food Truck', 'https://www-live.hacksawgaming.com/casino_thumbnails/1229.jpg', 1, 'slot-hacksaw', 1, 'slot', 3, 'igamewin'),
(7333, 'anubis_moon', 'Anubis Moon', 'https://evoplay.games/wp-content/uploads/2021/09/Anubis_Moon_270x270.jpg', 1, 'slot-evoplay', 1, 'slot', 3, 'igamewin'),
(7334, 'bandit_bust', 'Bandit Bust', 'https://evoplay.games/wp-content/uploads/2024/02/bandit_bust_270x270.jpg', 1, 'slot-evoplay', 1, 'slot', 3, 'igamewin'),
(7335, 'bandit_bust_b_b', 'Bandit Bust Bonus Buy', 'https://evoplay.games/wp-content/uploads/2024/03/bandit_bust_bonus_buy_270x270.jpg', 1, 'slot-evoplay', 1, 'slot', 3, 'igamewin'),
(7336, 'belfry_bliss', 'Belfry Bliss', 'https://evoplay.games/wp-content/uploads/2024/05/belfrybliss_270x270.jpg', 1, 'slot-evoplay', 1, 'slot', 3, 'igamewin'),
(7337, 'book_of_the_priestess', 'Book of the Priestess', 'https://evoplay.games/wp-content/uploads/2023/01/Book_of_the_Priestess_270x270-1.jpg', 1, 'slot-evoplay', 1, 'slot', 3, 'igamewin'),
(7338, 'budai_reels_bonus_buy', 'Budai Reels Bonus Buy', 'https://evoplay.games/wp-content/uploads/2022/02/budaireelsbonusbuy_270x270.jpg', 1, 'slot-evoplay', 1, 'slot', 3, 'igamewin'),
(7339, 'camino_de_chili', 'Camino de Chili', 'https://evoplay.games/wp-content/uploads/2022/06/caminodechili_270x270.jpg', 1, 'slot-evoplay', 1, 'slot', 3, 'igamewin'),
(7340, 'camino_de_chili_b_b', 'Camino de Chili Bonus Buy', 'https://evoplay.games/wp-content/uploads/2022/07/caminodechilibonusbuy_270x270-1.jpg', 1, 'slot-evoplay', 1, 'slot', 3, 'igamewin'),
(7341, 'candy_craze', 'Candy Craze', 'https://evoplay.games/wp-content/uploads/2024/04/Candy_craze_270x270.jpg', 1, 'slot-evoplay', 1, 'slot', 3, 'igamewin'),
(7342, 'candy_dreams_sweet_planet', 'Candy Dreams: Sweet Planet', 'https://evoplay.games/wp-content/uploads/2022/06/Candydreamssweetplanet_270x270.png', 1, 'slot-evoplay', 1, 'slot', 3, 'igamewin'),
(7343, 'candy_dreams_sweet_planet_b_b', 'Candy Dreams Sweet Planet Bonus Buy', 'https://evoplay.games/wp-content/uploads/2022/08/Candydreamssweetplanetbonusbuy_270x270.png', 1, 'slot-evoplay', 1, 'slot', 3, 'igamewin'),
(7344, 'christmas_reach_bonus_buy', 'Christmas Reach Bonus Buy', 'https://evoplay.games/wp-content/uploads/2021/12/christmasreach_270x270-1.jpg', 1, 'slot-evoplay', 1, 'slot', 3, 'igamewin'),
(7345, 'collapsed_castle_b_b', 'Collapsed Castle Bonus Buy', 'https://evoplay.games/wp-content/uploads/2022/12/CollapsedCastleBonusBuy_270x270-1.jpg', 1, 'slot-evoplay', 1, 'slot', 3, 'igamewin'),
(7346, 'cursed_can', 'Cursed Can', 'https://evoplay.games/wp-content/uploads/2023/10/Cursed_can_270x270.jpg', 1, 'slot-evoplay', 1, 'slot', 3, 'igamewin'),
(7347, 'cursed_can_b_b', 'Cursed Can Bonus Buy', 'https://evoplay.games/wp-content/uploads/2023/11/Cursed_can_bonus_buy_270x270.jpg', 1, 'slot-evoplay', 1, 'slot', 3, 'igamewin'),
(7348, 'cycle_of_luck', 'Cycle of Luck', 'https://evoplay.games/wp-content/uploads/2021/04/580x580.jpg', 1, 'slot-evoplay', 1, 'slot', 3, 'igamewin'),
(7349, 'ellens_fortune', 'Ellen\'s Fortune', 'https://evoplay.games/wp-content/uploads/2021/03/EllensFortune_360x360.jpg', 1, 'slot-evoplay', 1, 'slot', 3, 'igamewin'),
(7350, 'epic_legends', 'Epic Legends', 'https://evoplay.games/wp-content/uploads/2021/03/270x270-2.jpg', 1, 'slot-evoplay', 1, 'slot', 3, 'igamewin'),
(7351, 'europe_transit', 'Europe Transit', 'https://evoplay.games/wp-content/uploads/2023/06/Europe_transit_270x270.jpg', 1, 'slot-evoplay', 1, 'slot', 3, 'igamewin'),
(7352, 'europe_transit_b_b', 'Europe Transit Bonus Buy', 'https://evoplay.games/wp-content/uploads/2023/08/Europe_transit_bonus_buy_270x270.jpg', 1, 'slot-evoplay', 1, 'slot', 3, 'igamewin'),
(7353, 'fruit_super_nova', 'Fruit Super Nova', 'https://evoplay.games/wp-content/uploads/2021/03/FruitSuperNova_270x270.jpg', 1, 'slot-evoplay', 1, 'slot', 3, 'igamewin'),
(7354, 'fruit_super_nova_80', 'Fruit Super Nova 80', 'https://evoplay.games/wp-content/uploads/2021/12/fruitsupernova80_270x270-1.jpg', 1, 'slot-evoplay', 1, 'slot', 3, 'igamewin'),
(7355, 'gold_of_sirens_bonus_buy', 'Gold of Sirens Bonus Buy', 'https://evoplay.games/wp-content/uploads/2021/08/Gold_of_Sirens_270x270-1.jpg', 1, 'slot-evoplay', 1, 'slot', 3, 'igamewin'),
(7356, 'hot_mania', 'Hot Mania', 'https://evoplay.games/wp-content/uploads/2023/09/hotmania_580x580.jpg', 1, 'slot-evoplay', 1, 'slot', 3, 'igamewin'),
(7357, 'hot_triple_sevens', 'Hot Triple Sevens', 'https://evoplay.games/wp-content/uploads/2021/03/360x360-1.jpg', 1, 'slot-evoplay', 1, 'slot', 3, 'igamewin'),
(7358, 'hot_triple_sevens_special', 'Hot Triple Sevens Special', 'https://evoplay.games/wp-content/uploads/2021/11/hottriplesevensspecial_270x270-1.jpg', 1, 'slot-evoplay', 1, 'slot', 3, 'igamewin'),
(7359, 'hot_volcano', 'Hot Volcano', 'https://evoplay.games/wp-content/uploads/2022/07/hotvolkano_270x270.jpg', 1, 'slot-evoplay', 1, 'slot', 3, 'igamewin'),
(7360, 'hot_volcano_b_b', 'Hot Volcano Bonus Buy', 'https://evoplay.games/wp-content/uploads/2022/10/hotvolkanobonusbuy_270x270.jpg', 1, 'slot-evoplay', 1, 'slot', 3, 'igamewin'),
(7361, 'ice_mania', 'Ice Mania', 'https://evoplay.games/wp-content/uploads/2021/03/publicpreview-3.jpg', 1, 'slot-evoplay', 1, 'slot', 3, 'igamewin'),
(7362, 'inner_fire', 'Inner Fire', 'https://evoplay.games/wp-content/uploads/2022/12/innerfire_270x270.jpg', 1, 'slot-evoplay', 1, 'slot', 3, 'igamewin'),
(7363, 'inner_fire_b_b', 'Inner Fire Bonus Buy', 'https://evoplay.games/wp-content/uploads/2023/01/innerfirebonusbuy_270x270.jpg', 1, 'slot-evoplay', 1, 'slot', 3, 'igamewin'),
(7364, 'irish_weekend_b_b', 'Irish Weekend Bonus Buy', 'https://evoplay.games/wp-content/uploads/2023/04/irishweekendbonusbuy_270x270.jpg', 1, 'slot-evoplay', 1, 'slot', 3, 'igamewin'),
(7365, 'jhana_of_god_b_b', 'Jhana Of God Bonus Buy', 'https://evoplay.games/wp-content/uploads/2023/08/Jhana_of_god_bonus_buy270x270.jpg', 1, 'slot-evoplay', 1, 'slot', 3, 'igamewin'),
(7366, 'juicy_gems', 'Juicy Gems', 'https://evoplay.games/wp-content/uploads/2022/05/juicygems_270x270.jpg', 1, 'slot-evoplay', 1, 'slot', 3, 'igamewin'),
(7367, 'massive_luck', 'Massive Luck', 'https://evoplay.games/wp-content/uploads/2022/08/massiveluck_270x270.jpg', 1, 'slot-evoplay', 1, 'slot', 3, 'igamewin'),
(7368, 'massive_luck_b_b', 'Massive Luck Bonus Buy', 'https://evoplay.games/wp-content/uploads/2022/12/massiveluckbonusbuy_270x270.jpg', 1, 'slot-evoplay', 1, 'slot', 3, 'igamewin'),
(7369, 'money_minter', 'Money Minter', 'https://evoplay.games/wp-content/uploads/2022/07/moneyminter_270x270.jpg', 1, 'slot-evoplay', 1, 'slot', 3, 'igamewin'),
(7370, 'money_minter_b_b', 'Money Minter Bonus Buy', 'https://evoplay.games/wp-content/uploads/2022/09/moneyminterbonusbuy_270x270.jpg', 1, 'slot-evoplay', 1, 'slot', 3, 'igamewin'),
(7371, 'neon_capital', 'Neon Capital', 'https://evoplay.games/wp-content/uploads/2023/05/neoncapital_270x270.jpg', 1, 'slot-evoplay', 1, 'slot', 3, 'igamewin'),
(7372, 'neon_capital_b_b', 'Neon Capital Bonus Buy', 'https://evoplay.games/wp-content/uploads/2023/06/neoncapitalbonusbuy_270x270.jpg', 1, 'slot-evoplay', 1, 'slot', 3, 'igamewin'),
(7373, 'northern_temple', 'Northern Temple', 'https://evoplay.games/wp-content/uploads/2023/06/Northern_temple_270x270.jpg', 1, 'slot-evoplay', 1, 'slot', 3, 'igamewin'),
(7374, 'northern_temple_b_b', 'Northern Temple Bonus Buy', 'https://evoplay.games/wp-content/uploads/2023/06/Northern_temple_bonus_buy_270x270.jpg', 1, 'slot-evoplay', 1, 'slot', 3, 'igamewin'),
(7375, 'nuke_world', 'Nuke World', 'https://evoplay.games/wp-content/uploads/2021/03/NukeWorld_270x270.jpg', 1, 'slot-evoplay', 1, 'slot', 3, 'igamewin'),
(7376, 'ocean_catch', 'Ocean Catch', 'https://evoplay.games/wp-content/uploads/2024/03/Ocean-Catch_270x270.jpg', 1, 'slot-evoplay', 1, 'slot', 3, 'igamewin'),
(7377, 'roman_rule', 'Roman Rule', 'https://evoplay.games/wp-content/uploads/2024/06/romanrule_270x270.jpg', 1, 'slot-evoplay', 1, 'slot', 3, 'igamewin'),
(7378, 'rueda_de_chile', 'Rueda De Chile', 'https://evoplay.games/wp-content/uploads/2022/09/ruedadechile_270x270.jpg', 1, 'slot-evoplay', 1, 'slot', 3, 'igamewin'),
(7379, 'rueda_de_chile_b_b', 'Rueda De Chile Bonus Buy', 'https://evoplay.games/wp-content/uploads/2022/10/ruedadechilebonusbuy_270x270.jpg', 1, 'slot-evoplay', 1, 'slot', 3, 'igamewin'),
(7380, 'sweet_sugar', 'Sweet Sugar', 'https://evoplay.games/wp-content/uploads/2021/03/promo_360_360-1.png', 1, 'slot-evoplay', 1, 'slot', 3, 'igamewin'),
(7381, 'temple_of_thunder2', 'Temple Of Thunder II', 'https://evoplay.games/wp-content/uploads/2023/12/temple_of_thunderII_270x270.jpg', 1, 'slot-evoplay', 1, 'slot', 3, 'igamewin'),
(7382, 'temple_of_thunder2_b_b', 'Temple Of Thunder II Bonus Buy', 'https://evoplay.games/wp-content/uploads/2024/02/temple_of_thunderII_bonus_buy_580x580.jpg', 1, 'slot-evoplay', 1, 'slot', 3, 'igamewin'),
(7383, 'the_greatest_catch', 'The Greatest Catch', 'https://evoplay.games/wp-content/uploads/2022/04/Thegreatestcatch_270x270.jpg', 1, 'slot-evoplay', 1, 'slot', 3, 'igamewin'),
(7384, 'treasure_mania', 'Treasure Mania', 'https://evoplay.games/wp-content/uploads/2021/03/TreasureMania_270x270.jpg', 1, 'slot-evoplay', 1, 'slot', 3, 'igamewin'),
(7385, 'valley_of_dreams', 'Valley Of Dreams', 'https://evoplay.games/wp-content/uploads/2021/03/ValleyOfDeams_270x270.jpg', 1, 'slot-evoplay', 1, 'slot', 3, 'igamewin'),
(7386, 'wild_bullets', 'Wild Bullets', 'https://evoplay.games/wp-content/uploads/2021/03/WildBullets_270x270.jpg', 1, 'slot-evoplay', 1, 'slot', 3, 'igamewin'),
(7387, 'yggdrasil/ElixirOfWealth', 'Elixir of Wealth', 'https://igamewin.com/storage/igamewin/6806.webp', 1, 'jelly', 1, 'slot', 3, 'igamewin'),
(7388, 'yggdrasil/SecretRichesoftheIrish', 'secret Riches of the Irish', 'https://igamewin.com/storage/igamewin/8684.webp', 1, 'jelly', 1, 'slot', 3, 'igamewin'),
(7389, 'yggdrasil/FuryofHydeMegaways', 'Fury of Hyde Megaways', 'https://igamewin.com/storage/igamewin/8967.webp', 1, 'jelly', 1, 'slot', 3, 'igamewin'),
(7390, 'yggdrasil/CleoPatrickDoubleMax', 'CleoPatrick DoubleMax', 'https://igamewin.com/storage/igamewin/8968.webp', 1, 'jelly', 1, 'slot', 3, 'igamewin'),
(7391, 'yggdrasil/SugarBombMultiBoost', 'sugar Bomb MultiBoost', 'https://igamewin.com/storage/igamewin/8969.webp', 1, 'jelly', 1, 'slot', 3, 'igamewin'),
(7392, 'yggdrasil/BurningBloxGigaBlox', 'Burning Blox GigaBlox', 'https://igamewin.com/storage/igamewin/8970.webp', 1, 'jelly', 1, 'slot', 3, 'igamewin'),
(7393, 'yggdrasil/DigginforDiamondsTheBigBonanza', 'Diggin for Diamonds The Big Bonanza', 'https://igamewin.com/storage/igamewin/8971.webp', 1, 'jelly', 1, 'slot', 3, 'igamewin'),
(7394, 'yggdrasil/WildFishinWildWays', 'Wild Fishin\' Wild Ways', 'https://igamewin.com/storage/igamewin/8972.webp', 1, 'jelly', 1, 'slot', 3, 'igamewin'),
(7395, 'yggdrasil/BeastyBloxGigaBlox', 'Beasty Blox GigaBlox', 'https://igamewin.com/storage/igamewin/8973.webp', 1, 'jelly', 1, 'slot', 3, 'igamewin'),
(7396, 'softswiss/LuckyDucky', 'Lucky Ducky', 'https://cdn2.softswiss.net/i/s6/softswiss/LuckyDucky.webp', 1, 'bgaming', 1, 'slot', 3, 'igamewin'),
(7397, 'softswiss/WildMoonThieves', 'Wild Moon Thieves', 'https://cdn2.softswiss.net/i/s6/softswiss/WildMoonThieves.webp', 1, 'bgaming', 1, 'slot', 3, 'igamewin'),
(7398, 'softswiss/RotatingElement', 'Rotating Element', 'https://cdn2.softswiss.net/i/s6/softswiss/RotatingElement.webp', 1, 'bgaming', 1, 'slot', 3, 'igamewin'),
(7399, 'softswiss/FortunaTrueways', 'Fortuna TRUEWAYS', 'https://cdn2.softswiss.net/i/s6/softswiss/FortunaTrueways.webp', 1, 'bgaming', 1, 'slot', 3, 'igamewin'),
(7400, 'softswiss/RoyalFruitsMultiLines', 'Royal Fruits MultiLines', 'https://cdn2.softswiss.net/i/s6/softswiss/RoyalFruitsMultiLines.webp', 1, 'bgaming', 1, 'slot', 3, 'igamewin'),
(7401, 'softswiss/VoodooPeople', 'Voodoo People', 'https://cdn2.softswiss.net/i/s6/softswiss/VoodooPeople.webp', 1, 'bgaming', 1, 'slot', 3, 'igamewin'),
(7402, 'softswiss/FishingClub', 'Fishing Club', 'https://cdn2.softswiss.net/i/s6/softswiss/FishingClub.webp', 1, 'bgaming', 1, 'slot', 3, 'igamewin'),
(7403, 'softswiss/AlchemyAcademy', 'Alchemy Academy', 'https://admin-prod.b6z-cdn.com/optimized_images/portrait/softswiss/AlchemyAcademy.jpg', 1, 'bgaming', 1, 'slot', 3, 'igamewin'),
(7404, 'softswiss/TrainToRioGrande', 'Train to Rio Grande', 'https://cdn2.softswiss.net/i/s6/softswiss/TrainToRioGrande.webp', 1, 'bgaming', 1, 'slot', 3, 'igamewin'),
(7405, 'softswiss/WildWestTrueways', 'Wild West TRUEWAYS', 'https://cdn2.softswiss.net/i/s6/softswiss/WildWestTrueways.webp', 1, 'bgaming', 1, 'slot', 3, 'igamewin'),
(7406, 'softswiss/GoldMagnate', 'Gold Magnate', 'https://cdn2.softswiss.net/i/s6/softswiss/GoldMagnate.webp', 1, 'bgaming', 1, 'slot', 3, 'igamewin'),
(7407, 'softswiss/Aviamasters', 'Aviamasters', 'https://cdn2.softswiss.net/i/s6/softswiss/Aviamasters.webp', 1, 'bgaming', 1, 'slot', 3, 'igamewin'),
(7408, 'softswiss/AlienFruits2', 'Alien Fruits 2', 'https://cdn2.softswiss.net/i/s6/softswiss/AlienFruits2.webp', 1, 'bgaming', 1, 'slot', 3, 'igamewin'),
(7409, 'softswiss/PandaLuck', 'Panda Luck', 'https://cdn2.softswiss.net/i/s6/softswiss/PandaLuck.webp', 1, 'bgaming', 1, 'slot', 3, 'igamewin'),
(7410, 'softswiss/BurningChilliX', 'Burning Chilli X', 'https://cdn2.softswiss.net/i/s6/softswiss/BurningChilliX.webp', 1, 'bgaming', 1, 'slot', 3, 'igamewin'),
(7411, 'softswiss/RoyalHighRoad', 'Royal High-Road', 'https://cdn2.softswiss.net/i/s6/softswiss/RoyalHighRoad.webp', 1, 'bgaming', 1, 'slot', 3, 'igamewin'),
(7412, 'softswiss/MonsterHunt', 'Monster Hunt', 'https://cdn2.softswiss.net/i/s6/softswiss/MonsterHunt.webp', 1, 'bgaming', 1, 'slot', 3, 'igamewin'),
(7413, 'softswiss/Gemza', 'Gemza', 'https://cdn2.softswiss.net/i/s6/softswiss/Gemza.webp', 1, 'bgaming', 1, 'slot', 3, 'igamewin'),
(7414, 'softswiss/TrampDay', 'Tramp Day', 'https://cdn2.softswiss.net/i/s6/softswiss/TrampDay.webp', 1, 'bgaming', 1, 'slot', 3, 'igamewin'),
(7415, 'softswiss/Hottest666', 'Hottest 666', 'https://cdn2.softswiss.net/i/s6/softswiss/Hottest666.webp', 1, 'bgaming', 1, 'slot', 3, 'igamewin'),
(7416, 'softswiss/SlotMachine', 'slot Machine', 'https://cdn2.softswiss.net/i/s6/softswiss/SlotMachine.webp', 1, 'bgaming', 1, 'slot', 3, 'igamewin'),
(7417, 'softswiss/BookOfPanda', 'Book of Panda Megaways', 'https://cdn2.softswiss.net/i/s6/softswiss/BookOfPanda.webp', 1, 'bgaming', 1, 'slot', 3, 'igamewin'),
(7418, 'softswiss/AlohaKingElvis', 'Aloha King Elvis', 'https://cdn2.softswiss.net/i/s6/softswiss/AlohaKingElvis.webp', 1, 'bgaming', 1, 'slot', 3, 'igamewin'),
(7419, 'softswiss/LuckyDamaMuerta', 'Lucky Dama Muerta', 'https://cdn2.softswiss.net/i/s6/softswiss/LuckyDamaMuerta.webp', 1, 'bgaming', 1, 'slot', 3, 'igamewin'),
(7420, 'softswiss/SweetRushMegaways', 'sweet Rush Megaways', 'https://cdn2.softswiss.net/i/s6/softswiss/SweetRushMegaways.webp', 1, 'bgaming', 1, 'slot', 3, 'igamewin'),
(7421, 'softswiss/BookOfCatsMegaways', 'Book Of Cats Megaways', 'https://cdn2.softswiss.net/i/s6/softswiss/BookOfCatsMegaways.webp', 1, 'bgaming', 1, 'slot', 3, 'igamewin'),
(7422, 'softswiss/LuckyOak', 'Lucky Oak', 'https://cdn2.softswiss.net/i/s6/softswiss/LuckyOak.webp', 1, 'bgaming', 1, 'slot', 3, 'igamewin'),
(7423, 'softswiss/Lucky8MergeUp', 'Lucky 8 Merge Up', 'https://cdn2.softswiss.net/i/s6/softswiss/Lucky8MergeUp.webp', 1, 'bgaming', 1, 'slot', 3, 'igamewin'),
(7424, 'softswiss/EasterHeist', 'Easter Heist', 'https://cdn2.softswiss.net/i/s6/softswiss/EasterHeist.webp', 1, 'bgaming', 1, 'slot', 3, 'igamewin'),
(7425, 'softswiss/MiceAndMagic', 'Mice & Magic Wonder Spin', 'https://cdn2.softswiss.net/i/s6/softswiss/MiceAndMagic.webp', 1, 'bgaming', 1, 'slot', 3, 'igamewin'),
(7426, 'softswiss/AlienFruits', 'Alien Fruits', 'https://cdn2.softswiss.net/i/s6/softswiss/AlienFruits.webp', 1, 'bgaming', 1, 'slot', 3, 'igamewin'),
(7427, 'softswiss/CloverBonanza', 'Clover Bonanza', 'https://cdn2.softswiss.net/i/s6/softswiss/CloverBonanza.webp', 1, 'bgaming', 1, 'slot', 3, 'igamewin'),
(7428, 'softswiss/LuckyCrew', 'Lucky Crew', 'https://cdn2.softswiss.net/i/s6/softswiss/LuckyCrew.webp', 1, 'bgaming', 1, 'slot', 3, 'igamewin'),
(7429, 'softswiss/LuckyFarmBonanza', 'Lucky Farm Bonanza', 'https://cdn2.softswiss.net/i/s6/softswiss/LuckyFarmBonanza.webp', 1, 'bgaming', 1, 'slot', 3, 'igamewin'),
(7430, 'softswiss/Soccermania', 'soccermania', 'https://cdn2.softswiss.net/i/s6/softswiss/Soccermania.webp', 1, 'bgaming', 1, 'slot', 3, 'igamewin'),
(7431, 'softswiss/SavageBuffaloSpiritMegaways', 'savage Buffalo Spirit Megaways', 'https://cdn2.softswiss.net/i/s6/softswiss/SavageBuffaloSpiritMegaways.webp', 1, 'bgaming', 1, 'slot', 3, 'igamewin'),
(7432, 'softswiss/BonanzaBillion', 'Bonanza Billion', 'https://cdn2.softswiss.net/i/s6/softswiss/BonanzaBillion.webp', 1, 'bgaming', 1, 'slot', 3, 'igamewin'),
(7433, 'softswiss/HitTheRoute', 'Hit The Route', 'https://cdn2.softswiss.net/i/s6/softswiss/HitTheRoute.webp', 1, 'bgaming', 1, 'slot', 3, 'igamewin'),
(7434, 'softswiss/GiftRush', 'Gift Rush', 'https://cdn2.softswiss.net/i/s6/softswiss/GiftRush.webp', 1, 'bgaming', 1, 'slot', 3, 'igamewin'),
(7435, 'softswiss/MissCherryFruits', 'Miss Cherry Fruits', 'https://cdn2.softswiss.net/i/s6/softswiss/MissCherryFruits.webp', 1, 'bgaming', 1, 'slot', 3, 'igamewin'),
(7436, 'softswiss/WildCashDice', 'Wild Cash Dice', 'https://cdn2.softswiss.net/i/s6/softswiss/WildCashDice.webp', 1, 'bgaming', 1, 'slot', 3, 'igamewin'),
(7437, 'softswiss/DiceBonanza', 'Dice Bonanza', 'https://cdn2.softswiss.net/i/s6/softswiss/DiceBonanza.webp', 1, 'bgaming', 1, 'slot', 3, 'igamewin'),
(7438, 'softswiss/WildCashX9990', 'Wild Cash x9990', 'https://cdn2.softswiss.net/i/s6/softswiss/WildCashX9990.webp', 1, 'bgaming', 1, 'slot', 3, 'igamewin'),
(7439, 'softswiss/JohnnyCash', 'Johnny Cash', 'https://cdn2.softswiss.net/i/s6/softswiss/JohnnyCash.webp', 1, 'bgaming', 1, 'slot', 3, 'igamewin'),
(7440, 'softswiss/AztecMagicMegaways', 'Aztec Magic Megaways', 'https://cdn2.softswiss.net/i/s6/softswiss/AztecMagicMegaways.webp', 1, 'bgaming', 1, 'slot', 3, 'igamewin'),
(7441, 'softswiss/BeastBand', 'Beast Band', 'https://cdn2.softswiss.net/i/s6/softswiss/BeastBand.webp', 1, 'bgaming', 1, 'slot', 3, 'igamewin'),
(7442, 'softswiss/DragonsGold100', 'Dragon\'s Gold 100', 'https://cdn2.softswiss.net/i/s6/softswiss/DragonsGold100.webp', 1, 'bgaming', 1, 'slot', 3, 'igamewin'),
(7443, 'softswiss/LuckyLadyMoon', 'Lady Wolf Moon', 'https://cdn2.softswiss.net/i/s6/softswiss/LuckyLadyMoon.webp', 1, 'bgaming', 1, 'slot', 3, 'igamewin'),
(7444, 'softswiss/WildChicago', 'Wild Chicago', 'https://cdn2.softswiss.net/i/s6/softswiss/WildChicago.webp', 1, 'bgaming', 1, 'slot', 3, 'igamewin'),
(7445, 'softswiss/DiceMillion', 'Dice Million', 'https://cdn2.softswiss.net/i/s6/softswiss/DiceMillion.webp', 1, 'bgaming', 1, 'slot', 3, 'igamewin'),
(7446, 'softswiss/Road2Riches', 'Road 2 Riches', 'https://cdn2.softswiss.net/i/s6/softswiss/Road2Riches.webp', 1, 'bgaming', 1, 'slot', 3, 'igamewin'),
(7447, 'softswiss/JokerQueen', 'Joker Queen', 'https://cdn2.softswiss.net/i/s6/softswiss/JokerQueen.webp', 1, 'bgaming', 1, 'slot', 3, 'igamewin'),
(7448, 'softswiss/FruitMillion', 'Fruit Million', 'https://cdn2.softswiss.net/i/s6/softswiss/FruitMillion.webp', 1, 'bgaming', 1, 'slot', 3, 'igamewin'),
(7449, 'softswiss/BigAtlantisFrenzy', 'Big Atlantis Frenzy', 'https://cdn2.softswiss.net/i/s6/softswiss/BigAtlantisFrenzy.webp', 1, 'bgaming', 1, 'slot', 3, 'igamewin'),
(7450, 'softswiss/HalloweenBonanza', 'Halloween Bonanza', 'https://cdn2.softswiss.net/i/s6/softswiss/HalloweenBonanza.webp', 1, 'bgaming', 1, 'slot', 3, 'igamewin'),
(7451, 'softswiss/SavageBuffaloSpirit', 'savage Buffalo Spirit', 'https://cdn2.softswiss.net/i/s6/softswiss/SavageBuffaloSpirit.webp', 1, 'bgaming', 1, 'slot', 3, 'igamewin'),
(7452, 'softswiss/ElvisFrogTrueways', 'Elvis Frog TRUEWAYS', 'https://cdn2.softswiss.net/i/s6/softswiss/ElvisFrogTrueways.webp', 1, 'bgaming', 1, 'slot', 3, 'igamewin'),
(7453, 'softswiss/PennyPelican', 'Penny Pelican', 'https://cdn2.softswiss.net/i/s6/softswiss/PennyPelican.webp', 1, 'bgaming', 1, 'slot', 3, 'igamewin'),
(7454, 'softswiss/CandyMonsta', 'Candy Monsta', 'https://cdn2.softswiss.net/i/s6/softswiss/CandyMonsta.webp', 1, 'bgaming', 1, 'slot', 3, 'igamewin'),
(7455, 'softswiss/DomnitorsTreasure', 'Domnitor\'s Treasure', 'https://cdn2.softswiss.net/i/s6/softswiss/DomnitorsTreasure.webp', 1, 'bgaming', 1, 'slot', 3, 'igamewin'),
(7456, 'softswiss/WildCash', 'Wild Cash', 'https://cdn2.softswiss.net/i/s6/softswiss/WildCash.webp', 1, 'bgaming', 1, 'slot', 3, 'igamewin'),
(7457, 'softswiss/LuckAndMagic', 'Luck & Magic', 'https://cdn2.softswiss.net/i/s6/softswiss/LuckAndMagic.webp', 1, 'bgaming', 1, 'slot', 3, 'igamewin'),
(7458, 'softswiss/AztecMagicBonanza', 'Aztec Magic Bonanza', 'https://cdn2.softswiss.net/i/s6/softswiss/AztecMagicBonanza.webp', 1, 'bgaming', 1, 'slot', 3, 'igamewin'),
(7459, 'softswiss/GoldRushWithJohnny', 'Gold Rush with Johnny Cash', 'https://cdn2.softswiss.net/i/s6/softswiss/GoldRushWithJohnny.webp', 1, 'bgaming', 1, 'slot', 3, 'igamewin'),
(7460, 'softswiss/Gangsterz', 'Gangsterz', 'https://cdn2.softswiss.net/i/s6/softswiss/Gangsterz.webp', 1, 'bgaming', 1, 'slot', 3, 'igamewin'),
(7461, 'softswiss/BeerBonanza', 'Beer Bonanza', 'https://cdn2.softswiss.net/i/s6/softswiss/BeerBonanza.webp', 1, 'bgaming', 1, 'slot', 3, 'igamewin'),
(7462, 'fortune-gems-2', 'Fortune Gems 2', 'https://storage.googleapis.com/tada-cdn-asia/All-In-One/production/img/jiliPlusPlayer/games/LGmOw0w4iklkLKXz81LfNjNFjDQw5IlZgRSULqy2.png', 1, 'slot-jili', 1, 'slot', 3, 'igamewin'),
(7463, 'fortune-gems-3', 'Fortune Gems 3', 'https://storage.googleapis.com/tada-cdn-asia/All-In-One/production/img/jiliPlusPlayer/games/8lYBJBMzSLs2Rb6DTsHe4h8jmBfVeeUElsE8qbWa.png', 1, 'slot-jili', 1, 'slot', 3, 'igamewin'),
(7464, 'fortune-gems', 'Fortune Gems', 'https://storage.googleapis.com/tada-cdn-asia/All-In-One/production/img/jiliPlusPlayer/games/7hnsYn70DF8p9aAUBr9tPoqMjSDbBxzvNhXdrgle.png', 1, 'slot-jili', 1, 'slot', 3, 'igamewin'),
(7465, 'crazy-seven', 'Crazy Seven', 'https://storage.googleapis.com/tada-cdn-asia/All-In-One/production/img/jiliPlusPlayer/games/W0rhf4hboBqVZVD8TMfV7TYULMgRZlVkIUXw1Fqp.png', 1, 'slot-jili', 1, 'slot', 3, 'igamewin'),
(7466, 'charge-buffalo', 'Charge Buffalo', 'https://storage.googleapis.com/tada-cdn-asia/All-In-One/production/img/jiliPlusPlayer/games/MPtl94BJIgoZGkDzs7iNMHBnkQKKWRJfsxEAW8jl.png', 1, 'slot-jili', 1, 'slot', 3, 'igamewin'),
(7467, 'mega-ace', 'Mega Ace', 'https://storage.googleapis.com/tada-cdn-asia/All-In-One/production/img/jiliPlusPlayer/games/KhQJkNq2D5g7XaZQcgmHokHLENlr5nHenQqghQIp.png', 1, 'slot-jili', 1, 'slot', 3, 'igamewin'),
(7468, 'super-rich', 'Super Rich', 'https://storage.googleapis.com/tada-cdn-asia/All-In-One/production/img/jiliPlusPlayer/games/tVWxwz3tQMKa3TPfMjq9GIm7pwiyEKHGWmDMlO0P.png', 1, 'slot-jili', 1, 'slot', 3, 'igamewin'),
(7469, 'boxingking', 'BoxingKing', 'https://storage.googleapis.com/tada-cdn-asia/All-In-One/production/img/jiliPlusPlayer/games/M5LoqW4yYYVmbMs8jrlBWppsFhMDSWqE9yqINrgc.png', 1, 'slot-jili', 1, 'slot', 3, 'igamewin'),
(7470, 'golden-bank', 'Golden Bank', 'https://storage.googleapis.com/tada-cdn-asia/All-In-One/production/img/jiliPlusPlayer/games/CzjCNYAOnopzNiDJgdfg7I6ZqWoO2bwqxGRMV8t5.png', 1, 'slot-jili', 1, 'slot', 3, 'igamewin'),
(7471, 'aztec-priestess', 'Aztec Priestess', 'https://storage.googleapis.com/tada-cdn-asia/All-In-One/production/img/jiliPlusPlayer/games/a7vxY4coDk5pFrwsZZ2kY8NsM1Bnb1rNK8kLXWBo.png', 1, 'slot-jili', 1, 'slot', 3, 'igamewin'),
(7472, 'ali-baba', 'Ali Baba', 'https://storage.googleapis.com/tada-cdn-asia/All-In-One/production/img/jiliPlusPlayer/games/trieiElNLzrCM5dBtXg1yteriX4r8kQxru2xrtOO.png', 1, 'slot-jili', 1, 'slot', 3, 'igamewin'),
(7473, 'lucky-coming', 'Lucky Coming', 'https://storage.googleapis.com/tada-cdn-asia/All-In-One/production/img/jiliPlusPlayer/games/84zKPNK3RzuNY5tJh9E2jwIV5kzpxZBv4QoRfx9E.png', 1, 'slot-jili', 1, 'slot', 3, 'igamewin'),
(7474, 'crazy-fafafa', 'Crazy FaFaFa', 'https://storage.googleapis.com/tada-cdn-asia/All-In-One/production/img/jiliPlusPlayer/games/xMq0C95WRtknLJC8ISOjiLD3p79oeaw2dcUqjZcD.png', 1, 'slot-jili', 1, 'slot', 3, 'igamewin'),
(7475, 'fortune-tree', 'Fortune Tree', 'https://storage.googleapis.com/tada-cdn-asia/All-In-One/production/img/jiliPlusPlayer/games/1nJZS31DrT0NJqDfcfVDR5DGS12TiKniUahJ4efj.png', 1, 'slot-jili', 1, 'slot', 3, 'igamewin'),
(7476, 'book-of-gold', 'Book of Gold', 'https://storage.googleapis.com/tada-cdn-asia/All-In-One/production/img/jiliPlusPlayer/games/Qw37suZFMwVp2VJr5JwxD88mEAEln7oEtCkRQBLc.png', 1, 'slot-jili', 1, 'slot', 3, 'igamewin'),
(7477, 'jungle-king', 'Jungle King', 'https://storage.googleapis.com/tada-cdn-asia/All-In-One/production/img/jiliPlusPlayer/games/znfDyGil7KHqljcKEyK5eaUAeA0l0A0DWSMeT2Ma.png', 1, 'slot-jili', 1, 'slot', 3, 'igamewin'),
(7478, 'magic-lamp', 'Magic Lamp', 'https://storage.googleapis.com/tada-cdn-asia/All-In-One/production/img/jiliPlusPlayer/games/nLgQLeo2bdl3ZV33xKuWCq36m5IADrGXWjpnECcr.png', 1, 'slot-jili', 1, 'slot', 3, 'igamewin'),
(7479, 'devil-fire-2', 'Devil Fire 2', 'https://storage.googleapis.com/tada-cdn-asia/All-In-One/production/img/jiliPlusPlayer/games/3flwlSPsPtpqvPxZh2MKZuUNhGFvNzYO8YPucdi0.png', 1, 'slot-jili', 1, 'slot', 3, 'igamewin'),
(7480, 'gold-rush', 'Gold Rush', 'https://storage.googleapis.com/tada-cdn-asia/All-In-One/production/img/jiliPlusPlayer/games/SutNHWQCT0brUMPFoGtHWyhxDaV4faH5UJNQK2nF.png', 1, 'slot-jili', 1, 'slot', 3, 'igamewin'),
(7481, 'twin-wins', 'TWIN WINS', 'https://storage.googleapis.com/tada-cdn-asia/All-In-One/production/img/jiliPlusPlayer/games/fLafPjEM19jK7sdCoMJsXtzuRp4wDrvwg56vpGKn.png', 1, 'slot-jili', 1, 'slot', 3, 'igamewin'),
(7482, 'bonus-hunter', 'Bonus Hunter', 'https://storage.googleapis.com/tada-cdn-asia/All-In-One/production/img/jiliPlusPlayer/games/sGwnH7w0dmV98sYjXkGjH20zhziGYkiWqD3pvICz.png', 1, 'slot-jili', 1, 'slot', 3, 'igamewin'),
(7483, 'world-cup', 'World Cup', 'https://storage.googleapis.com/tada-cdn-asia/All-In-One/production/img/jiliPlusPlayer/games/RubvW163jBzIJIj7Ls8DseMYyS39cNnlbcwLqefX.png', 1, 'slot-jili', 1, 'slot', 3, 'igamewin'),
(7484, 'pharaoh-treasure', 'Pharaoh Treasure', 'https://storage.googleapis.com/tada-cdn-asia/All-In-One/production/img/jiliPlusPlayer/games/rwR2jADCmzvGxtGvgHkV1Dd9VC4ibn85Wa4vbrNq.png', 1, 'slot-jili', 1, 'slot', 3, 'igamewin'),
(7485, 'fortune-monkey', 'Fortune Monkey', 'https://storage.googleapis.com/tada-cdn-asia/All-In-One/production/img/jiliPlusPlayer/games/1c09luDhnuarYPWmhNZGFLbKvMkksQblvHe5ekrM.png', 1, 'slot-jili', 1, 'slot', 3, 'igamewin'),
(7486, 'golden-queen', 'Golden Queen', 'https://storage.googleapis.com/tada-cdn-asia/All-In-One/production/img/jiliPlusPlayer/games/Aw9r80iVAeb4r93PrkruL8NskWqaEB4AKGCdGNsi.png', 1, 'slot-jili', 1, 'slot', 3, 'igamewin'),
(7487, 'legacy-of-egypt', 'Legacy of Egypt', 'https://storage.googleapis.com/tada-cdn-asia/All-In-One/production/img/jiliPlusPlayer/games/wmngGe7gHkKjth12VLoQy60S5E68qGD8SkZDrQW3.png', 1, 'slot-jili', 1, 'slot', 3, 'igamewin'),
(7488, 'fa-fa-fa', 'Fa Fa Fa', 'https://storage.googleapis.com/tada-cdn-asia/All-In-One/production/img/jiliPlusPlayer/games/YVH4ILoaSoPVtFWrDHWR5M4xecy4SrL8m1OyNY6q.png', 1, 'slot-jili', 1, 'slot', 3, 'igamewin'),
(7489, 'samba', 'Samba', 'https://storage.googleapis.com/tada-cdn-asia/All-In-One/production/img/jiliPlusPlayer/games/uqju8fzqNHgGOzBMfGAk86UwV3iSRhh2dJ9Ig434.png', 1, 'slot-jili', 1, 'slot', 3, 'igamewin'),
(7490, 'pirate-queen', 'Pirate Queen', 'https://storage.googleapis.com/tada-cdn-asia/All-In-One/production/img/jiliPlusPlayer/games/4ubG7KPOLQdHN5xdrX4gI8gWrY9ysIGlxZ5LcpmW.png', 1, 'slot-jili', 1, 'slot', 3, 'igamewin'),
(7491, 'roma-x', 'Roma X', 'https://storage.googleapis.com/tada-cdn-asia/All-In-One/production/img/jiliPlusPlayer/games/BpFXjfHC5tyw1VgLnaD0ndSQR5HCTPL1t7g7Mpjj.png', 1, 'slot-jili', 1, 'slot', 3, 'igamewin'),
(7492, 'bone-fortune', 'Bone Fortune', 'https://storage.googleapis.com/tada-cdn-asia/All-In-One/production/img/jiliPlusPlayer/games/0NMm5znugdsgOagdTNGinTDLOCWmBljNVyKBuccK.png', 1, 'slot-jili', 1, 'slot', 3, 'igamewin'),
(7493, 'mayan-empire', 'Mayan Empire', 'https://storage.googleapis.com/tada-cdn-asia/All-In-One/production/img/jiliPlusPlayer/games/GRydicVLIcV1EliCXdwpTFUPStmb2tdOBusaYm9R.png', 1, 'slot-jili', 1, 'slot', 3, 'igamewin'),
(7494, 'devil-fire', 'Devil Fire', 'https://storage.googleapis.com/tada-cdn-asia/All-In-One/production/img/jiliPlusPlayer/games/DxIOnb8tRRFzDYCRnNfDB96W1c5hW05FcJnYcQe3.png', 1, 'slot-jili', 1, 'slot', 3, 'igamewin'),
(7495, 'god-of-martial', 'God Of Martial', 'https://storage.googleapis.com/tada-cdn-asia/All-In-One/production/img/jiliPlusPlayer/games/9VNpMeB5LhtPyXMHAqUEIS2934BmdDwnfS5aork4.png', 1, 'slot-jili', 1, 'slot', 3, 'igamewin'),
(7496, 'cricket-king-18', 'Cricket King 18', 'https://storage.googleapis.com/tada-cdn-asia/All-In-One/production/img/jiliPlusPlayer/games/Yc0iRAnTEZQ1z1zRIKTGNdRrHRX7IwlekGes8kAs.png', 1, 'slot-jili', 1, 'slot', 3, 'igamewin'),
(7497, 'xiyangyang', 'XiYangYang', 'https://storage.googleapis.com/tada-cdn-asia/All-In-One/production/img/jiliPlusPlayer/games/rv03MnyE113hguP39QJczWJ9aLo8KZuhXJAmtdSi.png', 1, 'slot-jili', 1, 'slot', 3, 'igamewin'),
(7498, 'bao-boon-chin', 'Bao boon chin', 'https://storage.googleapis.com/tada-cdn-asia/All-In-One/production/img/jiliPlusPlayer/games/anLonuWIeJpa4dHWHFuPuPdvjgGTGuaqj9Yg5197.png', 1, 'slot-jili', 1, 'slot', 3, 'igamewin'),
(7499, 'fortunepig', 'Fortune Pig', 'https://storage.googleapis.com/tada-cdn-asia/All-In-One/production/img/jiliPlusPlayer/games/qcHiZHhXxf3sS8tjqBIQmleM0dZP6Zd8aRoTTiRm.png', 1, 'slot-jili', 1, 'slot', 3, 'igamewin'),
(7500, 'thor-x', 'Thor X', 'https://storage.googleapis.com/tada-cdn-asia/All-In-One/production/img/jiliPlusPlayer/games/hIqrVrY2nxEAKQa7usmdsB5wzDau4xb8sj62Mncs.png', 1, 'slot-jili', 1, 'slot', 3, 'igamewin'),
(7501, 'the-pig-house', 'The Pig House', 'https://storage.googleapis.com/tada-cdn-asia/All-In-One/production/img/jiliPlusPlayer/games/PG6prYy7tSW1EJq6nhSxHwzoGJCyaUD5upKRus0E.png', 1, 'slot-jili', 1, 'slot', 3, 'igamewin'),
(7502, 'agent-ace', 'Agent Ace', 'https://storage.googleapis.com/tada-cdn-asia/All-In-One/production/img/jiliPlusPlayer/games/4iJOHHJMtF4wC89eaUiMLpQrTZWh7Ox15lgZSBV8.png', 1, 'slot-jili', 1, 'slot', 3, 'igamewin'),
(7503, 'night-city', 'Night City', 'https://storage.googleapis.com/tada-cdn-asia/All-In-One/production/img/jiliPlusPlayer/games/l9tglMO9cITw8GJGwWjGKfyGmMDFW3Y9muWnNsH8.png', 1, 'slot-jili', 1, 'slot', 3, 'igamewin'),
(7504, 'fengshen', 'Fengshen', 'https://storage.googleapis.com/tada-cdn-asia/All-In-One/production/img/jiliPlusPlayer/games/2zyjnzyHpfxBBLLSJpK79perLIQQklZHLBJ4tGf1.png', 1, 'slot-jili', 1, 'slot', 3, 'igamewin'),
(7505, 'sin-city', 'Sin City', 'https://storage.googleapis.com/tada-cdn-asia/All-In-One/production/img/jiliPlusPlayer/games/ucjaOJZCks4bkX8lXguqnCz90DSwMtCYyW2hnubj.png', 1, 'slot-jili', 1, 'slot', 3, 'igamewin'),
(7506, 'chin-shi-huang', 'Chin Shi Huang', 'https://storage.googleapis.com/tada-cdn-asia/All-In-One/production/img/jiliPlusPlayer/games/zzmyRGegMynQA2xjpexoeNtH7JHZPmIQJE2qzljd.png', 1, 'slot-jili', 1, 'slot', 3, 'igamewin'),
(7507, 'witches-night', 'Witches Night', 'https://storage.googleapis.com/tada-cdn-asia/All-In-One/production/img/jiliPlusPlayer/games/iVleim1PQh0ru4zigjdFheWL4okAc8869Nt3unkK.png', 1, 'slot-jili', 1, 'slot', 3, 'igamewin'),
(7508, 'dabanggg', 'Dabanggg', 'https://storage.googleapis.com/tada-cdn-asia/All-In-One/production/img/jiliPlusPlayer/games/6783DU3wFo7b6LxkeDkOLOCLJ15XzCuLc8fNskGA.png', 1, 'slot-jili', 1, 'slot', 3, 'igamewin'),
(7509, 'sweet-land', 'Sweet Land', 'https://storage.googleapis.com/tada-cdn-asia/All-In-One/production/img/jiliPlusPlayer/games/6gjWT5M7ESdWCYcF1mF8zRxlffhin11stP3oZi2q.png', 1, 'slot-jili', 1, 'slot', 3, 'igamewin'),
(7510, 'cricket-sah-75', 'Cricket Sah 75', 'https://storage.googleapis.com/tada-cdn-asia/All-In-One/production/img/jiliPlusPlayer/games/r6H6rqMvIQavFhfFaX831OIUAjNFgSmollvgiY3l.png', 1, 'slot-jili', 1, 'slot', 3, 'igamewin'),
(7511, 'zeus', 'Zeus', 'https://storage.googleapis.com/tada-cdn-asia/All-In-One/production/img/jiliPlusPlayer/games/ev52lnWrF6soryGTnt5qafnuPOdHzhDjXoPlTPqf.png', 1, 'slot-jili', 1, 'slot', 3, 'igamewin'),
(7512, 'neko-fortune', 'Neko Fortune', 'https://storage.googleapis.com/tada-cdn-asia/All-In-One/production/img/jiliPlusPlayer/games/VZRGHowsPgKVO4Wx1Cg1zaK6UBmN1MVjMHzBuHTA.png', 1, 'slot-jili', 1, 'slot', 3, 'igamewin'),
(7513, 'king-arthur', 'King Arthur', 'https://storage.googleapis.com/tada-cdn-asia/All-In-One/production/img/jiliPlusPlayer/games/U04cnvDwpBW97Okxz7KvZf7eOdlrB4i4gB3iLOce.png', 1, 'slot-jili', 1, 'slot', 3, 'igamewin'),
(7514, 'happy-taxi', 'Happy Taxi', 'https://storage.googleapis.com/tada-cdn-asia/All-In-One/production/img/jiliPlusPlayer/games/d3jhadDsYzjki9GA6izGTr7fCV1XKU66NYo3OGk8.png', 1, 'slot-jili', 1, 'slot', 3, 'igamewin'),
(7515, 'shanghai-beauty', 'Shanghai Beauty', 'https://storage.googleapis.com/tada-cdn-asia/All-In-One/production/img/jiliPlusPlayer/games/XJsWYaFhZtz4szT4NuPihSsPWts5Lw3aPuYdP2Un.png', 1, 'slot-jili', 1, 'slot', 3, 'igamewin'),
(7516, 'party-night', 'Party Night', 'https://storage.googleapis.com/tada-cdn-asia/All-In-One/production/img/jiliPlusPlayer/games/HUOfU0QDJ01vsAGZM01hPtA4el1bmefvZCPadPrs.png', 1, 'slot-jili', 1, 'slot', 3, 'igamewin'),
(7517, 'super-ace-deluxe', 'Super Ace Deluxe', 'https://storage.googleapis.com/tada-cdn-asia/All-In-One/production/img/jiliPlusPlayer/games/HskVGEVL6UgOWi8rabMgSoOviMD4pFZNuMU3pdvd.png', 1, 'slot-jili', 1, 'slot', 3, 'igamewin'),
(7518, 'super-ace', 'Super Ace', 'https://storage.googleapis.com/tada-cdn-asia/All-In-One/production/img/jiliPlusPlayer/games/7ycivbeSFZ2FzMIi4UfVi4vfmALw2iwP3gEaCsmO.png', 1, 'slot-jili', 1, 'slot', 3, 'igamewin'),
(7519, 'bangla-beauty', 'Bangla Beauty', 'https://storage.googleapis.com/tada-cdn-asia/All-In-One/production/img/jiliPlusPlayer/games/3zYqXEykzJtrTLVBtLVQqHx2NIoy7BgzguIWiGwa.png', 1, 'slot-jili', 1, 'slot', 3, 'igamewin'),
(7520, 'arena-fighter', 'Arena Fighter', 'https://storage.googleapis.com/tada-cdn-asia/All-In-One/production/img/jiliPlusPlayer/games/c5VgTbR3axH1Xv9noEJdJygBF8yn8dL2pGZ2f76w.png', 1, 'slot-jili', 1, 'slot', 3, 'igamewin'),
(7521, 'fourbeauty', 'Four Beauties', 'https://resource.fdsigaming.com/thumbnail/slot/dtech/046.Four Beauties.png', 1, 'slot-dreamtech', 1, 'slot', 3, 'igamewin'),
(7522, 'legend5x25', 'Legend of the King', 'https://resource.fdsigaming.com/thumbnail/slot/dtech/048.Legend of the King.png', 1, 'slot-dreamtech', 1, 'slot', 3, 'igamewin'),
(7523, 'magician', 'Magician', 'https://resource.fdsigaming.com/thumbnail/slot/dtech/065.Magician.png', 1, 'slot-dreamtech', 1, 'slot', 3, 'igamewin'),
(7524, 'hiphop5x25', 'Street Dance of China', 'https://resource.fdsigaming.com/thumbnail/slot/dtech/109.StreetDanceShow.png', 1, 'slot-dreamtech', 1, 'slot', 3, 'igamewin'),
(7525, 'wildchaser5x20', 'Battle Field', 'https://resource.fdsigaming.com/thumbnail/slot/dtech/120.BattleField.png', 1, 'slot-dreamtech', 1, 'slot', 3, 'igamewin'),
(7526, 'sailor', 'Sailor Princess', 'https://resource.fdsigaming.com/thumbnail/slot/dtech/_9660.png', 1, 'slot-dreamtech', 1, 'slot', 3, 'igamewin'),
(7527, 'shiningstars', 'ShiningStars', 'https://resource.fdsigaming.com/thumbnail/slot/dtech/11268.png', 1, 'slot-dreamtech', 1, 'slot', 3, 'igamewin'),
(7528, 'tgow2', 'Cai Shen Dao', 'https://resource.fdsigaming.com/thumbnail/slot/dtech/11554.png', 1, 'slot-dreamtech', 1, 'slot', 3, 'igamewin'),
(7529, 'peeping', 'Peeping', 'https://resource.fdsigaming.com/thumbnail/slot/dtech/11556.png', 1, 'slot-dreamtech', 1, 'slot', 3, 'igamewin'),
(7530, 'dragonball', 'Saiyan Battle', 'https://resource.fdsigaming.com/thumbnail/slot/dtech/001.Saiyan Battle.png', 1, 'slot-dreamtech', 1, 'slot', 3, 'igamewin'),
(7531, 'tgow', 'Wealthy God Arriving', 'https://resource.fdsigaming.com/thumbnail/slot/dtech/012.Wealthy God Arriving.png', 1, 'slot-dreamtech', 1, 'slot', 3, 'igamewin'),
(7532, 'tlod', 'Investiture of Gods', 'https://resource.fdsigaming.com/thumbnail/slot/dtech/018.Investiture of Gods.png', 1, 'slot-dreamtech', 1, 'slot', 3, 'igamewin'),
(7533, 'whitesnake', 'Tales of White Snake', 'https://resource.fdsigaming.com/thumbnail/slot/dtech/020.Tales of White Snake.png', 1, 'slot-dreamtech', 1, 'slot', 3, 'igamewin'),
(7534, 'dnp', 'DragonPhoenix Prosper', 'https://resource.fdsigaming.com/thumbnail/slot/dtech/022.DragonPhoenix Prosper.png', 1, 'slot-dreamtech', 1, 'slot', 3, 'igamewin'),
(7535, 'fls', 'FULUSHOU', 'https://resource.fdsigaming.com/thumbnail/slot/dtech/025.FULUSHOU.png', 1, 'slot-dreamtech', 1, 'slot', 3, 'igamewin'),
(7536, 'fourss', 'Four Holy Beasts', 'https://resource.fdsigaming.com/thumbnail/slot/dtech/026.Four Holy Beasts.png', 1, 'slot-dreamtech', 1, 'slot', 3, 'igamewin'),
(7537, 'casino', '3D Slot', 'https://resource.fdsigaming.com/thumbnail/slot/dtech/028.3D Slot.png', 1, 'slot-dreamtech', 1, 'slot', 3, 'igamewin'),
(7538, 'rocknight', 'RocknRoll Night', 'https://resource.fdsigaming.com/thumbnail/slot/dtech/031.RocknRoll Night.png', 1, 'slot-dreamtech', 1, 'slot', 3, 'igamewin'),
(7539, 'bluesea', 'Blue Sea', 'https://resource.fdsigaming.com/thumbnail/slot/dtech/032.Blue Sea.png', 1, 'slot-dreamtech', 1, 'slot', 3, 'igamewin'),
(7540, 'klnz5x20', 'Happy Farm', 'https://resource.fdsigaming.com/thumbnail/slot/dtech/033.Happy Farm.png', 1, 'slot-dreamtech', 1, 'slot', 3, 'igamewin'),
(7541, 'circus', 'Crazy Circus', 'https://resource.fdsigaming.com/thumbnail/slot/dtech/034.Crazy Circus.png', 1, 'slot-dreamtech', 1, 'slot', 3, 'igamewin'),
(7542, 'dash', 'Four Wheels & Bro', 'https://resource.fdsigaming.com/thumbnail/slot/dtech/035.Four Wheels & Bro.png', 1, 'slot-dreamtech', 1, 'slot', 3, 'igamewin'),
(7543, 'sq5x243', '4X4 BATTLE', 'https://resource.fdsigaming.com/thumbnail/slot/dtech/036.4X4 BATTLE.png', 1, 'slot-dreamtech', 1, 'slot', 3, 'igamewin'),
(7544, 'estate5x25', 'Monopoly', 'https://resource.fdsigaming.com/thumbnail/slot/dtech/039.Monopoly.png', 1, 'slot-dreamtech', 1, 'slot', 3, 'igamewin'),
(7545, 'piratetreasure', 'Pirate_Treasure', 'https://resource.fdsigaming.com/thumbnail/slot/dtech/042.PirateTreasure.png', 1, 'slot-dreamtech', 1, 'slot', 3, 'igamewin'),
(7546, 'merryxmas', 'Merry Xmas', 'https://resource.fdsigaming.com/thumbnail/slot/dtech/044.Merry Xmas.png', 1, 'slot-dreamtech', 1, 'slot', 3, 'igamewin'),
(7547, 'sweethouse', 'Candy House', 'https://resource.fdsigaming.com/thumbnail/slot/dtech/047.Candy House.png', 1, 'slot-dreamtech', 1, 'slot', 3, 'igamewin'),
(7548, 'rocket6x25', 'Happiness Overflow', 'https://resource.fdsigaming.com/thumbnail/slot/dtech/049.Happiness Overflow.png', 1, 'slot-dreamtech', 1, 'slot', 3, 'igamewin'),
(7549, 'opera', 'Beijing opera', 'https://resource.fdsigaming.com/thumbnail/slot/dtech/051.Beijing opera.jpeg', 1, 'slot-dreamtech', 1, 'slot', 3, 'igamewin'),
(7550, 'bigred', 'Big Red', 'https://resource.fdsigaming.com/thumbnail/slot/dtech/055.Big Red.jpeg', 1, 'slot-dreamtech', 1, 'slot', 3, 'igamewin'),
(7551, 'wrathofthor', 'Wrath of Thor', 'https://resource.fdsigaming.com/thumbnail/slot/dtech/056.Wrath of Thor.png', 1, 'slot-dreamtech', 1, 'slot', 3, 'igamewin'),
(7552, 'guhuozai', 'Blood Street', 'https://resource.fdsigaming.com/thumbnail/slot/dtech/058.Blood Street.jpeg', 1, 'slot-dreamtech', 1, 'slot', 3, 'igamewin'),
(7553, 'camgirl5x25', 'Sexy Camgirl', 'https://resource.fdsigaming.com/thumbnail/slot/dtech/062.Sexy Camgirl.png', 1, 'slot-dreamtech', 1, 'slot', 3, 'igamewin'),
(7554, 'hotpotfeast', 'Hotpot Feast', 'https://resource.fdsigaming.com/thumbnail/slot/dtech/064.Hotpot Feast.png', 1, 'slot-dreamtech', 1, 'slot', 3, 'igamewin');
INSERT INTO `games` (`id`, `game_code`, `game_name`, `banner`, `status`, `provider`, `popular`, `type`, `game_type`, `distribution`) VALUES
(7555, 'armorCrisis5x25', 'Armor Crisis', 'https://resource.fdsigaming.com/thumbnail/slot/dtech/067.Armor Crisis.jpeg', 1, 'slot-dreamtech', 1, 'slot', 3, 'igamewin'),
(7556, 'galaxywars', 'Galaxy Wars', 'https://resource.fdsigaming.com/thumbnail/slot/dtech/068.Galaxy Wars.png', 1, 'slot-dreamtech', 1, 'slot', 3, 'igamewin'),
(7557, 'easyrider', 'Easy Rider', 'https://resource.fdsigaming.com/thumbnail/slot/dtech/069.Easy Rider.png', 1, 'slot-dreamtech', 1, 'slot', 3, 'igamewin'),
(7558, 'bwzq5x25', 'Joust for a spouse', 'https://resource.fdsigaming.com/thumbnail/slot/dtech/070.Joust for a spouse.png', 1, 'slot-dreamtech', 1, 'slot', 3, 'igamewin'),
(7559, 'shokudo', 'shokudo', 'https://resource.fdsigaming.com/thumbnail/slot/dtech/073.shokudo.jpeg', 1, 'slot-dreamtech', 1, 'slot', 3, 'igamewin'),
(7560, 'oceanpark5x50', 'Ocean Park', 'https://resource.fdsigaming.com/thumbnail/slot/dtech/075.Ocean Park.jpeg', 1, 'slot-dreamtech', 1, 'slot', 3, 'igamewin'),
(7561, 'garden', 'Little Big Garden', 'https://resource.fdsigaming.com/thumbnail/slot/dtech/079.Little Big Garden.png', 1, 'slot-dreamtech', 1, 'slot', 3, 'igamewin'),
(7562, 'superstar5x50', 'Star Generation', 'https://resource.fdsigaming.com/thumbnail/slot/dtech/083.Star Generation.png', 1, 'slot-dreamtech', 1, 'slot', 3, 'igamewin'),
(7563, 'shopping5x243', 'National Carnival', 'https://resource.fdsigaming.com/thumbnail/slot/dtech/090.National Carnival.png', 1, 'slot-dreamtech', 1, 'slot', 3, 'igamewin'),
(7564, 'clash', 'Clash of Three kingdoms', 'https://resource.fdsigaming.com/thumbnail/slot/dtech/088.Clash of Three kingdoms.png', 1, 'slot-dreamtech', 1, 'slot', 3, 'igamewin'),
(7565, 'cheekyemojis', 'Cheeky Emojis', 'https://resource.fdsigaming.com/thumbnail/slot/dtech/091.Cheeky Emojis.png', 1, 'slot-dreamtech', 1, 'slot', 3, 'igamewin'),
(7566, 'icefire', 'Ice And Fire', 'https://resource.fdsigaming.com/thumbnail/slot/dtech/093.Ice And Fire.png', 1, 'slot-dreamtech', 1, 'slot', 3, 'igamewin'),
(7567, 'onenight5x243', 'Truffle Butter', 'https://resource.fdsigaming.com/thumbnail/slot/dtech/096.Truffle Butter.png', 1, 'slot-dreamtech', 1, 'slot', 3, 'igamewin'),
(7568, 'secretdate', 'Secret Date', 'https://resource.fdsigaming.com/thumbnail/slot/dtech/104.Secret Date.png', 1, 'slot-dreamtech', 1, 'slot', 3, 'igamewin'),
(7569, 'cute5x50', 'Castle Guardian', 'https://resource.fdsigaming.com/thumbnail/slot/dtech/107.CastleGurdian.png', 1, 'slot-dreamtech', 1, 'slot', 3, 'igamewin'),
(7570, 'museum', 'Wondrous Museum', 'https://resource.fdsigaming.com/thumbnail/slot/dtech/110.WondrousMuseum.png', 1, 'slot-dreamtech', 1, 'slot', 3, 'igamewin'),
(7571, 'mysticalstones', 'Mystical Stones', 'https://resource.fdsigaming.com/thumbnail/slot/dtech/111.MysticalStones.png', 1, 'slot-dreamtech', 1, 'slot', 3, 'igamewin'),
(7572, 'westwild', 'West Wild', 'https://resource.fdsigaming.com/thumbnail/slot/dtech/116.WestWild.png', 1, 'slot-dreamtech', 1, 'slot', 3, 'igamewin'),
(7573, 'bloodmoon', 'Blood Wolf legend', 'https://resource.fdsigaming.com/thumbnail/slot/dtech/118.BloodWolf.png', 1, 'slot-dreamtech', 1, 'slot', 3, 'igamewin'),
(7574, 'sgkill5x20', 'Three Kingdoms', 'https://resource.fdsigaming.com/thumbnail/slot/dtech/122.ThreeKingdoms.png', 1, 'slot-dreamtech', 1, 'slot', 3, 'igamewin'),
(7575, 'candycrush', 'Candy Kingdom', 'https://resource.fdsigaming.com/thumbnail/slot/dtech/118.CandyKingdom.png', 1, 'slot-dreamtech', 1, 'slot', 3, 'igamewin'),
(7576, 'muaythai', 'Muaythai', 'https://resource.fdsigaming.com/thumbnail/slot/dtech/_9659.png', 1, 'slot-dreamtech', 1, 'slot', 3, 'igamewin'),
(7577, 'nezha', 'Nezha Legend', 'https://resource.fdsigaming.com/thumbnail/slot/dtech/_9662.png', 1, 'slot-dreamtech', 1, 'slot', 3, 'igamewin'),
(7578, 'bird', 'Bird Island', 'https://resource.fdsigaming.com/thumbnail/slot/dtech/10900.png', 1, 'slot-dreamtech', 1, 'slot', 3, 'igamewin'),
(7579, 'chess', 'Dragon Auto Chess', 'https://resource.fdsigaming.com/thumbnail/slot/dtech/10901.png', 1, 'slot-dreamtech', 1, 'slot', 3, 'igamewin'),
(7580, 'honor', 'Field Of Honor', 'https://resource.fdsigaming.com/thumbnail/slot/dtech/10902.png', 1, 'slot-dreamtech', 1, 'slot', 3, 'igamewin'),
(7581, 'rocknight2', 'Rock Night2', 'https://resource.fdsigaming.com/thumbnail/slot/dtech/10903.png', 1, 'slot-dreamtech', 1, 'slot', 3, 'igamewin'),
(7582, 'girlgroup5x25', 'Sexy Girls', 'https://resource.fdsigaming.com/thumbnail/slot/dtech/10906.png', 1, 'slot-dreamtech', 1, 'slot', 3, 'igamewin'),
(7583, 'boss5x20', 'Rich Asians', 'https://resource.fdsigaming.com/thumbnail/slot/dtech/10907.png', 1, 'slot-dreamtech', 1, 'slot', 3, 'igamewin'),
(7584, 'treasures', 'Secret Treasures', 'https://resource.fdsigaming.com/thumbnail/slot/dtech/10909.png', 1, 'slot-dreamtech', 1, 'slot', 3, 'igamewin'),
(7585, 'empire5x40', 'The Magic Blade', 'https://resource.fdsigaming.com/thumbnail/slot/dtech/12033.png', 1, 'slot-dreamtech', 1, 'slot', 3, 'igamewin'),
(7586, 'maidhotel5x25', 'Maid Hotel', 'https://resource.fdsigaming.com/thumbnail/slot/dtech/12035.png', 1, 'slot-dreamtech', 1, 'slot', 3, 'igamewin'),
(7587, 'secretary3x9', 'Sexy Secretary', 'https://resource.fdsigaming.com/thumbnail/slot/dtech/12036.png', 1, 'slot-dreamtech', 1, 'slot', 3, 'igamewin');

-- --------------------------------------------------------

--
-- Estrutura para tabela `historico_play`
--

CREATE TABLE `historico_play` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `nome_game` text NOT NULL,
  `bet_money` decimal(10,2) NOT NULL DEFAULT 0.00,
  `win_money` decimal(10,2) NOT NULL DEFAULT 0.00,
  `txn_id` text NOT NULL,
  `created_at` datetime NOT NULL,
  `status_play` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `historico_vip`
--

CREATE TABLE `historico_vip` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `bonus` float NOT NULL,
  `data` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `igamewin`
--

CREATE TABLE `igamewin` (
  `id` int(11) NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  `agent_code` text DEFAULT NULL,
  `agent_token` text DEFAULT NULL,
  `ativo` int(11) DEFAULT NULL,
  `rtp` int(11) NOT NULL DEFAULT 50
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Despejando dados para a tabela `igamewin`
--

INSERT INTO `igamewin` (`id`, `url`, `agent_code`, `agent_token`, `ativo`, `rtp`) VALUES
(1, 'https://igamewin.com/api/v1', 'agent', 'token', 1, 90);

-- --------------------------------------------------------

--
-- Estrutura para tabela `logs`
--

CREATE TABLE `logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `action` varchar(255) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `metodos_pagamentos`
--

CREATE TABLE `metodos_pagamentos` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `realname` varchar(255) DEFAULT NULL,
  `pix_id` varchar(255) DEFAULT NULL,
  `flag` tinyint(1) DEFAULT NULL,
  `pix_account` varchar(255) DEFAULT NULL,
  `state` int(11) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `pay_valores_cassino`
--

CREATE TABLE `pay_valores_cassino` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `valor` decimal(10,2) NOT NULL DEFAULT 0.00,
  `tipo` int(11) NOT NULL DEFAULT 0 COMMENT '0: CPA / 1: REV / 2: GAMES',
  `data_time` datetime NOT NULL,
  `game` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `pgclone`
--

CREATE TABLE `pgclone` (
  `id` int(11) NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  `agent_code` text DEFAULT NULL,
  `agent_token` text DEFAULT NULL,
  `agent_secret` text DEFAULT NULL,
  `ativo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Despejando dados para a tabela `pgclone`
--

INSERT INTO `pgclone` (`id`, `url`, `agent_code`, `agent_token`, `agent_secret`, `ativo`) VALUES
(1, 'https://api.expfy.online', ' ', ' ', ' ', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `popups`
--

CREATE TABLE `popups` (
  `id` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp(),
  `redirect_url` text DEFAULT NULL,
  `img` text NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Despejando dados para a tabela `popups`
--

INSERT INTO `popups` (`id`, `titulo`, `criado_em`, `redirect_url`, `img`, `status`) VALUES
(1, '#LEGALIZADA!', '2024-09-05 05:34:42', 'https://expfy.com.br', 'legalizados.jpg', 1),
(2, 'PROMOÇÃO BONUS', '2024-09-05 05:34:42', '', 'vOQxL2ADrnJjL48cQCrxi6ItpzdVaYJmpyEBtN3b.webp', 0),
(3, 'SAQUES IMEDIATOS', '2024-09-05 05:34:42', '', 'BsDFnZKknLWLsV5MV5OceVJmOYJPsq9FdW7T9Bwv.webp', 0);

-- --------------------------------------------------------

--
-- Estrutura para tabela `promocoes`
--

CREATE TABLE `promocoes` (
  `id` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp(),
  `img` text NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Despejando dados para a tabela `promocoes`
--

INSERT INTO `promocoes` (`id`, `titulo`, `criado_em`, `img`, `status`) VALUES
(1, 'Banner 1', '2024-06-28 18:10:47', '1740061103_convide.png', 1),
(2, 'Banner 2', '2024-06-28 18:08:02', '1740061173_ActiveImg9500462301883924.avif', 1),
(3, 'Banner 3', '2024-06-28 18:08:02', '1740061196_ActiveImg2205083029689352.avif', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `provedores`
--

CREATE TABLE `provedores` (
  `id` int(11) NOT NULL,
  `code` varchar(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `type` varchar(20) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Despejando dados para a tabela `provedores`
--

INSERT INTO `provedores` (`id`, `code`, `name`, `type`, `status`) VALUES
(1, 'PGSOFT', 'PGSoft', 'slot', 1),
(2, 'SPRIBE', 'Spribe', 'slot', 1),
(3, 'PRAGMATIC', 'PP', 'slot', 1),
(4, 'slot-cq9', 'CQ9', 'slot', 1),
(5, 'slot-jdb', 'JDB', 'slot', 1),
(6, 'fishing-jdb', 'FishingJDB', 'slot', 1),
(7, 'slot-hacksaw', 'HACKSAW', 'slot', 1),
(8, 'slot-evoplay', 'EVOPLAY', 'slot', 1),
(9, 'jelly', 'Jelly', 'slot', 1),
(10, 'bgaming', 'BGaming', 'slot', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `solicitacao_saques`
--

CREATE TABLE `solicitacao_saques` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `transacao_id` text NOT NULL,
  `transaction_id_gateway` varchar(191) DEFAULT NULL,
  `valor` decimal(10,2) NOT NULL DEFAULT 0.00,
  `tipo` text NOT NULL,
  `pix` text NOT NULL,
  `telefone` varchar(50) DEFAULT NULL,
  `data_cad` date NOT NULL,
  `data_hora` time NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `data_att` datetime DEFAULT NULL,
  `tipo_saque` int(11) NOT NULL DEFAULT 0 COMMENT '0: cassino / 1: afiliados'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `suitpay`
--

CREATE TABLE `suitpay` (
  `id` int(11) NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  `client_id` text DEFAULT NULL,
  `client_secret` text DEFAULT NULL,
  `atualizado` varchar(45) DEFAULT NULL,
  `ativo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Despejando dados para a tabela `suitpay`
--

INSERT INTO `suitpay` (`id`, `url`, `client_id`, `client_secret`, `atualizado`, `ativo`) VALUES
(1, 'https://ws.suitpay.app', 'dopim31_1700750854080', '4b37180491d40daf4320e79495ea398caa3627cf3bd140aa6aeaf47ceb2a10b49f36862ad6d64a08ad68ffda066da5f4', NULL, 0);

-- --------------------------------------------------------

--
-- Estrutura para tabela `tema`
--

CREATE TABLE `tema` (
  `id` int(11) NOT NULL,
  `cor_padrao` varchar(45) DEFAULT NULL,
  `custom_css` longtext DEFAULT NULL,
  `texto` varchar(45) DEFAULT NULL,
  `status_topheader` int(11) NOT NULL DEFAULT 0,
  `cor_topheader` varchar(48) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Despejando dados para a tabela `tema`
--

INSERT INTO `tema` (`id`, `cor_padrao`, `custom_css`, `texto`, `status_topheader`, `cor_topheader`) VALUES
(0, '#9BCD10', '', '#FFFFFF', 0, '');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tokens_recuperacoes`
--

CREATE TABLE `tokens_recuperacoes` (
  `id_usuario` int(11) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `transacoes`
--

CREATE TABLE `transacoes` (
  `id` int(11) NOT NULL,
  `transacao_id` varchar(255) DEFAULT NULL,
  `usuario` int(11) DEFAULT NULL,
  `valor` decimal(10,2) DEFAULT NULL,
  `tipo` enum('deposito','saque') DEFAULT NULL,
  `data_hora` varchar(255) DEFAULT NULL,
  `qrcode` text DEFAULT NULL,
  `code` text DEFAULT NULL,
  `status` enum('pago','processamento','expirado') DEFAULT NULL,
  `comissao` decimal(10,2) DEFAULT NULL,
  `afiliado_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `mobile` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `saldo` decimal(10,2) DEFAULT NULL,
  `saldo_afiliados` decimal(10,2) DEFAULT 0.00,
  `real_name` varchar(255) NOT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `spassword` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `data_cad` datetime DEFAULT NULL,
  `invite_code` varchar(255) NOT NULL,
  `invitation_code` varchar(255) DEFAULT NULL,
  `senha_saque` int(11) NOT NULL DEFAULT 0,
  `senhaparasacar` varchar(255) DEFAULT NULL,
  `pessoas_convidadas` int(11) NOT NULL DEFAULT 0,
  `statusaff` int(11) NOT NULL DEFAULT 0,
  `tipo_pagamento` int(11) NOT NULL DEFAULT 0,
  `banido` int(11) DEFAULT 0,
  `historico` text DEFAULT NULL,
  `favoritos` text DEFAULT NULL,
  `lvl_vip` int(11) DEFAULT 1,
  `rtp` int(11) DEFAULT 50,
  `modo_demo` int(11) DEFAULT 0,
  `prox_salario` date DEFAULT NULL,
  `prox_salario_valor` decimal(10,2) DEFAULT NULL,
  `comissao_percentual` decimal(5,2) NOT NULL DEFAULT 0.00,
  `saque_minimo` decimal(10,2) NOT NULL DEFAULT 100.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios_online`
--

CREATE TABLE `usuarios_online` (
  `id` int(11) NOT NULL,
  `session_id` varchar(255) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `ip_visita` varchar(45) NOT NULL,
  `ultima_acao` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `pagina_atual` varchar(255) NOT NULL,
  `pais` varchar(100) DEFAULT NULL,
  `cidade` varchar(100) DEFAULT NULL,
  `estado` varchar(100) DEFAULT NULL,
  `refer_visita` text DEFAULT NULL,
  `nav_os` text DEFAULT NULL,
  `mac_os` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `vip_levels`
--

CREATE TABLE `vip_levels` (
  `id` int(11) NOT NULL,
  `id_vip` int(11) NOT NULL,
  `meta` float NOT NULL,
  `bonus` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Despejando dados para a tabela `vip_levels`
--

INSERT INTO `vip_levels` (`id`, `id_vip`, `meta`, `bonus`) VALUES
(1, 1, 50, 5),
(2, 2, 200, 7),
(3, 3, 300, 15),
(4, 4, 500, 35),
(5, 5, 1000, 45),
(6, 6, 2000, 80),
(7, 7, 3000, 100),
(8, 8, 5000, 120),
(9, 9, 15000, 150),
(10, 10, 20000, 200),
(11, 11, 25000, 300),
(12, 12, 30000, 400),
(13, 13, 50000, 500),
(14, 14, 100000000, 3000),
(15, 15, 100000, 1000);

-- --------------------------------------------------------

--
-- Estrutura para tabela `visita_site`
--

CREATE TABLE `visita_site` (
  `id` int(11) NOT NULL,
  `nav_os` text DEFAULT NULL,
  `mac_os` text DEFAULT NULL,
  `ip_visita` text DEFAULT NULL,
  `refer_visita` text DEFAULT NULL,
  `data_cad` date DEFAULT NULL,
  `hora_cad` time DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  `pais` text DEFAULT NULL,
  `cidade` text DEFAULT NULL,
  `estado` text DEFAULT NULL,
  `ads_tipo` text DEFAULT NULL,
  `inviter` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `webhook`
--

CREATE TABLE `webhook` (
  `id` int(11) NOT NULL,
  `nome` text NOT NULL,
  `bot_id` varchar(255) NOT NULL,
  `chat_id` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `webhook`
--

INSERT INTO `webhook` (`id`, `nome`, `bot_id`, `chat_id`, `status`) VALUES
(1, 'Cadastros e Pixs', 'Insira o ID', 'Insira o Chat ID', 0);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `afiliados_config`
--
ALTER TABLE `afiliados_config`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `apipragmatic`
--
ALTER TABLE `apipragmatic`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `banner`
--
ALTER TABLE `banner`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `bau`
--
ALTER TABLE `bau`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `beeplay`
--
ALTER TABLE `beeplay`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `bspay`
--
ALTER TABLE `bspay`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `config`
--
ALTER TABLE `config`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `cupom`
--
ALTER TABLE `cupom`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `cupom_usados`
--
ALTER TABLE `cupom_usados`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `expfypay`
--
ALTER TABLE `expfypay`
  ADD UNIQUE KEY `id` (`id`);

--
-- Índices de tabela `financeiro`
--
ALTER TABLE `financeiro`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `fiverscan`
--
ALTER TABLE `fiverscan`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `floats`
--
ALTER TABLE `floats`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Índices de tabela `games`
--
ALTER TABLE `games`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `historico_play`
--
ALTER TABLE `historico_play`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `historico_vip`
--
ALTER TABLE `historico_vip`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `igamewin`
--
ALTER TABLE `igamewin`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `metodos_pagamentos`
--
ALTER TABLE `metodos_pagamentos`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `pay_valores_cassino`
--
ALTER TABLE `pay_valores_cassino`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `pgclone`
--
ALTER TABLE `pgclone`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `popups`
--
ALTER TABLE `popups`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `promocoes`
--
ALTER TABLE `promocoes`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `provedores`
--
ALTER TABLE `provedores`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `solicitacao_saques`
--
ALTER TABLE `solicitacao_saques`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `suitpay`
--
ALTER TABLE `suitpay`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `tema`
--
ALTER TABLE `tema`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `transacoes`
--
ALTER TABLE `transacoes`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `usuarios_online`
--
ALTER TABLE `usuarios_online`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `vip_levels`
--
ALTER TABLE `vip_levels`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `visita_site`
--
ALTER TABLE `visita_site`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `webhook`
--
ALTER TABLE `webhook`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de tabela `afiliados_config`
--
ALTER TABLE `afiliados_config`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `banner`
--
ALTER TABLE `banner`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `bau`
--
ALTER TABLE `bau`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `cupom_usados`
--
ALTER TABLE `cupom_usados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de tabela `financeiro`
--
ALTER TABLE `financeiro`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `floats`
--
ALTER TABLE `floats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `games`
--
ALTER TABLE `games`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7588;

--
-- AUTO_INCREMENT de tabela `historico_play`
--
ALTER TABLE `historico_play`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `historico_vip`
--
ALTER TABLE `historico_vip`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `igamewin`
--
ALTER TABLE `igamewin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `metodos_pagamentos`
--
ALTER TABLE `metodos_pagamentos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `pay_valores_cassino`
--
ALTER TABLE `pay_valores_cassino`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `pgclone`
--
ALTER TABLE `pgclone`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `promocoes`
--
ALTER TABLE `promocoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `provedores`
--
ALTER TABLE `provedores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `solicitacao_saques`
--
ALTER TABLE `solicitacao_saques`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `transacoes`
--
ALTER TABLE `transacoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `usuarios_online`
--
ALTER TABLE `usuarios_online`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `vip_levels`
--
ALTER TABLE `vip_levels`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de tabela `visita_site`
--
ALTER TABLE `visita_site`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
