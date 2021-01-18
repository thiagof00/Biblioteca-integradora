-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 19-Set-2020 às 23:02
-- Versão do servidor: 10.4.10-MariaDB
-- versão do PHP: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `biblioteca`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `historico`
--

DROP TABLE IF EXISTS `historico`;
CREATE TABLE IF NOT EXISTS `historico` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `datasr` varchar(255) CHARACTER SET utf8 NOT NULL,
  `id_leitores` int(255) NOT NULL,
  `id_livros` int(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_historico` (`id_leitores`),
  KEY `FK_historico2` (`id_livros`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `historico`
--

INSERT INTO `historico` (`id`, `datasr`, `id_leitores`, `id_livros`) VALUES
(1, '66 66', 6, 6),
(2, '11 11', 2, 1),
(3, '26/09-29/09', 9, 11),
(4, '16/09-25/09', 11, 12);

-- --------------------------------------------------------

--
-- Estrutura da tabela `leitores`
--

DROP TABLE IF EXISTS `leitores`;
CREATE TABLE IF NOT EXISTS `leitores` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `rg` int(15) NOT NULL,
  `nome` varchar(255) CHARACTER SET utf8 NOT NULL,
  `cpf` varchar(16) CHARACTER SET utf8 NOT NULL,
  `endereco` varchar(255) CHARACTER SET utf8 NOT NULL,
  `fone` varchar(255) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `leitores`
--

INSERT INTO `leitores` (`id`, `rg`, `nome`, `cpf`, `endereco`, `fone`) VALUES
(11, 0, 'Claiton Alex', '054.051.470-52', 'Cohab-2 Fernando Tramount-63', '(+55) 55 98403-3160'),
(10, 0, 'Thiago Ribeiro Fernandes', '040.695.340-67', 'UniÃ£o das vilas Ivo Rodrigues-699', '(+55) 55 99119-5011'),
(9, 0, 'Bruno de Canes Garcia', '047.028.000-00', 'Av Deputado Fernando Ferrari 1318', '(+55) 55 99733-1153'),
(12, 1154421794, 'Cleitin Junior da silva', '054.846.465-46', 'Av Presidente Vargas 1528', '+(55) 55 99733 1153'),
(13, 123456789, 'Brenda Paola Moura dos Santos', '040.111.400-55', 'UniÃ£o das Vilas, Rua V - 804', '988085432');

-- --------------------------------------------------------

--
-- Estrutura da tabela `livros`
--

DROP TABLE IF EXISTS `livros`;
CREATE TABLE IF NOT EXISTS `livros` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `cod_livro` varchar(255) CHARACTER SET utf8 NOT NULL,
  `nomel` varchar(50) CHARACTER SET utf8 NOT NULL,
  `autor` varchar(50) CHARACTER SET utf8 NOT NULL,
  `genero` varchar(50) CHARACTER SET utf8 NOT NULL,
  `ano` varchar(30) NOT NULL,
  `emestoque` int(255) DEFAULT NULL,
  `locali` varchar(100) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `livros`
--

INSERT INTO `livros` (`id`, `cod_livro`, `nomel`, `autor`, `genero`, `ano`, `emestoque`, `locali`) VALUES
(15, '505040', 'o brasil', 'Bruno', 'Literatura', '1900', 49, '15/15'),
(12, '22018', 'O Estrangeiro', 'Albert Camus', 'Romance', '1942', 0, '1/8'),
(11, '23321', 'A Batalha do Apocalipse', 'Eduardo Spohr', 'FicÃ§Ã£o', '2012', 1, '1/8'),
(16, '221133', 'Principios Lekonicos', 'Lekao', 'Filosofico', '2019', 1, '1/1'),
(17, '203214', 'DiÃ¡rio Postumo de Charlotte', 'Jairo Sarfati', 'Drama', '2013', -2, '2/5');

-- --------------------------------------------------------

--
-- Estrutura da tabela `login`
--

DROP TABLE IF EXISTS `login`;
CREATE TABLE IF NOT EXISTS `login` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(255) CHARACTER SET utf8 NOT NULL,
  `senha` varchar(255) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `login`
--

INSERT INTO `login` (`id`, `usuario`, `senha`) VALUES
(1, 'admin@gmail.com', '1234');

-- --------------------------------------------------------

--
-- Estrutura da tabela `reservas`
--

DROP TABLE IF EXISTS `reservas`;
CREATE TABLE IF NOT EXISTS `reservas` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `datasr` varchar(255) NOT NULL,
  `dataret` varchar(255) NOT NULL,
  `id_leitores` int(255) NOT NULL,
  `id_livros` int(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_reservas` (`id_leitores`),
  KEY `FK_reservas2` (`id_livros`)
) ENGINE=MyISAM AUTO_INCREMENT=37 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `reservas`
--

INSERT INTO `reservas` (`id`, `datasr`, `dataret`, `id_leitores`, `id_livros`) VALUES
(28, '2020-09-24', '', 11, 17),
(29, '2020-09-28', '1', 13, 12),
(30, '2020-09-30', '2020-09-30', 11, 17),
(31, '2020-09-20', '', 11, 11),
(32, '2020-09-23', 'Array', 11, 17),
(33, '2020-09-22', '', 11, 12),
(34, '28/09/20', '2', 11, 12),
(35, '28/09/20', '19/09/20', 11, 12),
(36, '24/09/20', '19/09/20', 13, 15);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
