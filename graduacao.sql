-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 09-Dez-2015 às 22:51
-- Versão do servidor: 5.6.26
-- PHP Version: 5.6.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `graduacao`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `anexo`
--

CREATE TABLE IF NOT EXISTS `anexo` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `tipo` varchar(100) NOT NULL,
  `hash` int(11) NOT NULL,
  `solicitacao_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `atividade`
--

CREATE TABLE IF NOT EXISTS `atividade` (
  `id` int(11) NOT NULL,
  `codigo` varchar(5) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `max_horas` int(11) NOT NULL,
  `curso_id` int(11) NOT NULL,
  `grupo_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `atividade`
--

INSERT INTO `atividade` (`id`, `codigo`, `nome`, `max_horas`, `curso_id`, `grupo_id`) VALUES
(1, '12312', 'qwdwefdwesf', 111, 1, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `curso`
--

CREATE TABLE IF NOT EXISTS `curso` (
  `id` int(11) NOT NULL,
  `codigo` varchar(5) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `max_horas` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `curso`
--

INSERT INTO `curso` (`id`, `codigo`, `nome`, `max_horas`) VALUES
(1, 'SI01', 'Sistemas de Informação', 120),
(2, 'IE08', 'Ciências da Computação', 120),
(3, 'FT05', 'Engenharia da Computação', 120);

-- --------------------------------------------------------

--
-- Estrutura da tabela `disciplina`
--

CREATE TABLE IF NOT EXISTS `disciplina` (
  `id` int(11) NOT NULL,
  `codDisciplina` varchar(10) CHARACTER SET utf8 NOT NULL,
  `nomeDisciplina` varchar(150) CHARACTER SET utf8 NOT NULL,
  `cargaHoraria` int(3) NOT NULL,
  `creditos` int(3) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1723 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `disciplina`
--

INSERT INTO `disciplina` (`id`, `codDisciplina`, `nomeDisciplina`, `cargaHoraria`, `creditos`) VALUES
(1665, 'ICC001', 'INTRODUÇÃO A COMPUTAÇÃO', 90, 5),
(1666, 'ICC002', 'ALGORITMOS E ESTRUTURA DE DADOS I', 90, 5),
(1667, 'ICC003', 'ALGORITMOS E ESTRUTURAS DE DADOS II', 90, 5),
(1668, 'ICC005', 'TÉCNICAS DE PROGRAMAÇÃO', 90, 4),
(1669, 'ICC011', 'LABORATÓRIO DE PROGRAMAÇÃO A', 60, 2),
(1670, 'ICC013', 'LABORATÓRIO DE PROGRAMAÇÃO C', 60, 2),
(1671, 'ICC030', 'TÓPICOS ESPECIAIS EM PROGRAMAÇÃO I', 60, 4),
(1672, 'ICC040', 'LINGUAGENS FORMAIS E AUTÔMATOS', 60, 4),
(1673, 'ICC041', 'INTRODUÇÃO À TEORIA DOS GRAFOS', 60, 4),
(1674, 'ICC043', 'PARADIGMA DE LINGUAGENS DE PROGRAMAÇÃO', 60, 4),
(1675, 'ICC044', 'COMPILADORES', 60, 4),
(1676, 'ICC060', 'SISTEMAS LÓGICOS', 60, 4),
(1677, 'ICC062', 'ARQUITETURA DE COMPUTADORES', 60, 4),
(1678, 'ICC064', 'SISTEMAS DE COMPUTAÇÃO', 90, 5),
(1679, 'ICC103', 'EMPREENDEDORISMO EM INFORMÁTICA', 60, 4),
(1680, 'ICC120', 'MATEMÁTICA DISCRETA', 60, 4),
(1681, 'ICC150', 'TRABALHO DE CONCLUSÃO DE CURSO', 150, 5),
(1682, 'ICC151', 'ESTÁGIO SUPERVISIONADO', 180, 6),
(1683, 'ICC181', 'TÓPICOS ESPECIAIS EM CIÊNCIA DA COMPUTAÇÃO II', 60, 4),
(1684, 'ICC182', 'TÓPICOS AVANÇADOS EM CIÊNCIA DA COMPUTAÇÃO I', 60, 4),
(1685, 'ICC200', 'BANCO DE DADOS I', 60, 4),
(1686, 'ICC205', 'INTRODUÇÃO A BANCO DE DADOS', 60, 4),
(1687, 'ICC210', 'PRÁTICA EM BANCO DE DADOS', 60, 2),
(1688, 'ICC222', 'TÓPICOS EM RECUPERAÇÃO DE INFORMAÇÃO', 60, 4),
(1689, 'ICC252', 'SISTEMAS COLABORATIVOS MÓVEIS', 60, 4),
(1690, 'ICC270', 'TÓPICOS ESPECIAIS EM INTELIGÊNCIA ARTIFICIAL', 60, 4),
(1691, 'ICC271', 'TÓPICOS AVANÇADOS EM INTELIGÊNCIA ARTIFICIAL', 60, 4),
(1692, 'ICC300', 'INTRODUÇÃO ÀS REDES DE COMPUTADORES', 90, 5),
(1693, 'ICC320', 'TÓPICOS ESPECIAIS EM REDES DE COMPUTADORES', 60, 4),
(1694, 'ICC350', 'INTRODUÇÃO AOS SISTEMAS EMBARCADOS', 60, 4),
(1695, 'ICC400', 'INTRODUÇÃO À ENGENHARIA DE SOFTWARE', 90, 5),
(1696, 'ICC401', 'ANÁLISE E PROJETO DE SISTEMAS', 90, 5),
(1697, 'ICC404', 'GERÊNCIA DE PROJETOS', 60, 4),
(1698, 'ICC406', 'INTERAÇÃO HUMANO-COMPUTADOR', 60, 4),
(1699, 'ICC410', 'PRÁTICA DE ANÁLISE E PROJETO DE SISTEMAS', 60, 2),
(1700, 'ICC450', 'INTRODUÇÃO À COMPUTAÇÃO GRÁFICA', 60, 4),
(1701, 'ICC520', 'TÓPICOS ESPECIAIS EM OTIMIZAÇÃO', 60, 4),
(1702, 'ICC900', 'INFORMÁTICA INSTRUMENTAL', 60, 3),
(1703, 'ICC901', 'INTRODUÇÃO À PROGRAMAÇÃO DE COMPUTADORES', 60, 3),
(1704, 'ICC903', 'GERAÇÃO E USO DE BANCO DE DADOS', 45, 3),
(1705, 'IEC010', 'MATEMÁTICA DISCRETA', 60, 4),
(1706, 'IEC011', 'INTRODUÇÃO À COMPUTAÇÃO', 90, 5),
(1707, 'IEC012', 'ALGORITMOS E ESTRUTURAS DE DADOS  I', 90, 5),
(1708, 'IEC013', 'ALGORITMOS E ESTRUTURAS DE  DADOS II', 90, 5),
(1709, 'IEC016', 'MODELAGEM  E  PROJETO  DE  SISTEMAS', 105, 6),
(1710, 'IEC019', 'PROJETO  FINAL  II', 150, 5),
(1711, 'IEC026', 'INFORMÁTICA APLICADA A CIÊNCIAS AGRÁRIAS', 60, 3),
(1712, 'IEC028', 'COMPILADORES', 75, 4),
(1713, 'IEC048', 'GERAÇÃO E USO DE BANCO DE DADOS', 45, 3),
(1714, 'IEC081', 'INTRODUÇÃO A CIÊNCIA DOS COMPUTADORES', 60, 4),
(1715, 'IEC082', 'CALCULO NUMÉRICO', 60, 4),
(1716, 'IEC087', 'LINGUAGENS FORMAIS E AUTOMATA', 60, 4),
(1717, 'IEC089', 'ARQUITETURA DE COMPUTADORES', 60, 4),
(1718, 'IEC092', 'INTELIGENCIA ARTIFICIAL E EDUCACAO', 60, 4),
(1719, 'IEC111', 'INFORMÁTICA INSTRUMENTAL', 60, 3),
(1720, 'IEC681', 'BANCO DE DADOS I', 75, 4),
(1721, 'IEC782', 'PROJETO FINAL', 150, 5),
(1722, 'IEC905', 'INFORMATICA APLICADA A ECONOMIA', 60, 4);

-- --------------------------------------------------------

--
-- Estrutura da tabela `disciplina_periodo`
--

CREATE TABLE IF NOT EXISTS `disciplina_periodo` (
  `id` int(11) NOT NULL,
  `idDisciplina` int(11) NOT NULL,
  `codTurma` varchar(10) CHARACTER SET utf8 NOT NULL,
  `idCurso` int(11) NOT NULL,
  `idProfessor` int(11) DEFAULT NULL,
  `nomeUnidade` varchar(100) CHARACTER SET utf8 NOT NULL,
  `qtdVagas` int(4) NOT NULL,
  `numPeriodo` tinyint(1) NOT NULL,
  `anoPeriodo` int(4) NOT NULL,
  `dataInicioPeriodo` date DEFAULT NULL,
  `dataFimPeriodo` date DEFAULT NULL,
  `usaLaboratorio` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=167 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `disciplina_periodo`
--

INSERT INTO `disciplina_periodo` (`id`, `idDisciplina`, `codTurma`, `idCurso`, `idProfessor`, `nomeUnidade`, `qtdVagas`, `numPeriodo`, `anoPeriodo`, `dataInicioPeriodo`, `dataFimPeriodo`, `usaLaboratorio`) VALUES
(69, 1665, '3', 1, 8, 'COORD. ACADÊMICA DO INSTITUTO DE COMPUTAÇÃO', 10, 2, 2015, '2015-09-08', '2016-01-18', 0),
(70, 1666, 'CB01', 1, 9, 'COORD. ACADÊMICA DO INSTITUTO DE COMPUTAÇÃO', 25, 2, 2015, '2015-09-08', '2016-01-18', 0),
(71, 1666, 'CB02', 1, 10, 'COORD. ACADÊMICA DO INSTITUTO DE COMPUTAÇÃO', 5, 2, 2015, '2015-09-08', '2016-01-18', NULL),
(72, 1666, 'CB03', 1, 8, 'COORD. ACADÊMICA DO INSTITUTO DE COMPUTAÇÃO', 5, 2, 2015, '2015-09-08', '2016-01-18', NULL),
(73, 1666, '01', 2, 9, 'COORD. ACADÊMICA DO INSTITUTO DE COMPUTAÇÃO', 50, 2, 2015, '2015-09-08', '2016-01-18', NULL),
(74, 1667, 'CB02', 1, 10, 'COORD. ACADÊMICA DO INSTITUTO DE COMPUTAÇÃO', 13, 2, 2015, '2015-09-08', '2016-01-18', NULL),
(75, 1667, '01', 2, NULL, 'COORD. ACADÊMICA DO INSTITUTO DE COMPUTAÇÃO', 5, 2, 2015, '2015-09-08', '2016-01-18', NULL),
(76, 1668, 'CB01', 1, NULL, 'COORD. ACADÊMICA DO INSTITUTO DE COMPUTAÇÃO', 50, 2, 2015, '2015-09-08', '2016-01-18', NULL),
(77, 1669, '01', 2, NULL, 'COORD. ACADÊMICA DO INSTITUTO DE COMPUTAÇÃO', 40, 2, 2015, '2015-09-08', '2016-01-18', NULL),
(78, 1670, 'CB01', 1, NULL, 'COORD. ACADÊMICA DO INSTITUTO DE COMPUTAÇÃO', 15, 2, 2015, '2015-09-08', '2016-01-18', NULL),
(79, 1670, '01', 2, NULL, 'COORD. ACADÊMICA DO INSTITUTO DE COMPUTAÇÃO', 20, 2, 2015, '2015-09-08', '2016-01-18', NULL),
(80, 1671, '01', 2, NULL, 'COORD. ACADÊMICA DO INSTITUTO DE COMPUTAÇÃO', 15, 2, 2015, '2015-09-08', '2016-01-18', NULL),
(81, 1672, 'CB01', 1, NULL, 'COORD. ACADÊMICA DO INSTITUTO DE COMPUTAÇÃO', 50, 2, 2015, '2015-09-08', '2016-01-18', NULL),
(82, 1672, 'CB02', 1, NULL, 'COORD. ACADÊMICA DO INSTITUTO DE COMPUTAÇÃO', 5, 2, 2015, '2015-09-08', '2016-01-18', NULL),
(83, 1673, 'CB01', 1, NULL, 'COORD. ACADÊMICA DO INSTITUTO DE COMPUTAÇÃO', 50, 2, 2015, '2015-09-08', '2016-01-18', NULL),
(84, 1674, '01', 2, NULL, 'COORD. ACADÊMICA DO INSTITUTO DE COMPUTAÇÃO', 40, 2, 2015, '2015-09-08', '2016-01-18', NULL),
(85, 1675, 'CB01', 1, NULL, 'COORD. ACADÊMICA DO INSTITUTO DE COMPUTAÇÃO', 50, 2, 2015, '2015-09-08', '2016-01-18', NULL),
(86, 1676, 'CB01', 1, NULL, 'COORD. ACADÊMICA DO INSTITUTO DE COMPUTAÇÃO', 25, 2, 2015, '2015-09-08', '2016-01-18', NULL),
(87, 1676, 'CB02', 1, NULL, 'COORD. ACADÊMICA DO INSTITUTO DE COMPUTAÇÃO', 25, 2, 2015, '2015-09-08', '2016-01-18', NULL),
(88, 1677, 'CB01', 1, NULL, 'COORD. ACADÊMICA DO INSTITUTO DE COMPUTAÇÃO', 50, 2, 2015, '2015-09-08', '2016-01-18', NULL),
(89, 1678, '01', 2, NULL, 'COORD. ACADÊMICA DO INSTITUTO DE COMPUTAÇÃO', 40, 2, 2015, '2015-09-08', '2016-01-18', NULL),
(90, 1679, 'CB01', 1, NULL, 'COORD. ACADÊMICA DO INSTITUTO DE COMPUTAÇÃO', 40, 2, 2015, '2015-09-08', '2016-01-18', NULL),
(91, 1680, 'CB01', 1, NULL, 'COORD. ACADÊMICA DO INSTITUTO DE COMPUTAÇÃO', 30, 2, 2015, '2015-09-08', '2016-01-18', NULL),
(92, 1680, 'CB02', 1, NULL, 'COORD. ACADÊMICA DO INSTITUTO DE COMPUTAÇÃO', 30, 2, 2015, '2015-09-08', '2016-01-18', NULL),
(93, 1680, '01', 2, NULL, 'COORD. ACADÊMICA DO INSTITUTO DE COMPUTAÇÃO', 50, 2, 2015, '2015-09-08', '2016-01-18', NULL),
(94, 1681, 'CB01', 1, NULL, 'COORD. ACADÊMICA DO INSTITUTO DE COMPUTAÇÃO', 30, 2, 2015, NULL, NULL, NULL),
(95, 1681, '01', 2, NULL, 'COORD. ACADÊMICA DO INSTITUTO DE COMPUTAÇÃO', 15, 2, 2015, NULL, NULL, NULL),
(96, 1682, '01', 2, NULL, 'COORD. ACADÊMICA DO INSTITUTO DE COMPUTAÇÃO', 15, 2, 2015, NULL, NULL, NULL),
(97, 1683, 'CB01', 1, NULL, 'COORD. ACADÊMICA DO INSTITUTO DE COMPUTAÇÃO', 15, 2, 2015, '2015-09-08', '2016-01-18', NULL),
(98, 1684, 'CB02', 1, NULL, 'COORD. ACADÊMICA DO INSTITUTO DE COMPUTAÇÃO', 10, 2, 2015, '2015-09-08', '2016-01-18', NULL),
(99, 1685, 'CB01', 1, NULL, 'COORD. ACADÊMICA DO INSTITUTO DE COMPUTAÇÃO', 40, 2, 2015, '2015-09-08', '2016-01-18', NULL),
(100, 1686, '01', 2, NULL, 'COORD. ACADÊMICA DO INSTITUTO DE COMPUTAÇÃO', 45, 2, 2015, '2015-09-08', '2016-01-18', NULL),
(101, 1687, '01', 2, NULL, 'COORD. ACADÊMICA DO INSTITUTO DE COMPUTAÇÃO', 35, 2, 2015, '2015-09-08', '2016-01-18', NULL),
(102, 1688, 'CB01', 1, NULL, 'COORD. ACADÊMICA DO INSTITUTO DE COMPUTAÇÃO', 15, 2, 2015, '2015-09-08', '2016-01-18', NULL),
(103, 1689, 'CB01', 1, NULL, 'COORD. ACADÊMICA DO INSTITUTO DE COMPUTAÇÃO', 15, 2, 2015, '2015-09-08', '2016-01-18', NULL),
(104, 1689, '01', 2, NULL, 'COORD. ACADÊMICA DO INSTITUTO DE COMPUTAÇÃO', 10, 2, 2015, '2015-09-08', '2016-01-18', NULL),
(105, 1690, 'CB01', 1, NULL, 'COORD. ACADÊMICA DO INSTITUTO DE COMPUTAÇÃO', 20, 2, 2015, '2015-09-08', '2016-01-18', NULL),
(106, 1691, 'CB01', 1, NULL, 'COORD. ACADÊMICA DO INSTITUTO DE COMPUTAÇÃO', 20, 2, 2015, '2015-09-08', '2016-01-18', NULL),
(107, 1692, 'CB01', 1, NULL, 'COORD. ACADÊMICA DO INSTITUTO DE COMPUTAÇÃO', 50, 2, 2015, '2015-09-08', '2016-01-18', NULL),
(108, 1693, 'CB01', 1, NULL, 'COORD. ACADÊMICA DO INSTITUTO DE COMPUTAÇÃO', 10, 2, 2015, '2015-09-08', '2016-01-18', NULL),
(109, 1693, 'CB02', 1, NULL, 'COORD. ACADÊMICA DO INSTITUTO DE COMPUTAÇÃO', 1, 2, 2015, NULL, NULL, NULL),
(110, 1693, '01', 2, NULL, 'COORD. ACADÊMICA DO INSTITUTO DE COMPUTAÇÃO', 15, 2, 2015, '2015-09-08', '2016-01-18', NULL),
(111, 1694, 'CB01', 1, NULL, 'COORD. ACADÊMICA DO INSTITUTO DE COMPUTAÇÃO', 15, 2, 2015, '2015-09-08', '2016-01-18', NULL),
(112, 1695, '01', 2, NULL, 'COORD. ACADÊMICA DO INSTITUTO DE COMPUTAÇÃO', 40, 2, 2015, '2015-09-08', '2016-01-18', NULL),
(113, 1696, 'CB01', 1, NULL, 'COORD. ACADÊMICA DO INSTITUTO DE COMPUTAÇÃO', 50, 2, 2015, '2015-09-08', '2016-01-18', NULL),
(114, 1697, '01', 2, NULL, 'COORD. ACADÊMICA DO INSTITUTO DE COMPUTAÇÃO', 35, 2, 2015, '2015-09-08', '2016-01-18', NULL),
(115, 1698, 'CB01', 1, NULL, 'COORD. ACADÊMICA DO INSTITUTO DE COMPUTAÇÃO', 50, 2, 2015, '2015-09-08', '2016-01-18', NULL),
(116, 1698, '01', 2, NULL, 'COORD. ACADÊMICA DO INSTITUTO DE COMPUTAÇÃO', 35, 2, 2015, '2015-09-08', '2016-01-18', NULL),
(117, 1699, '01', 2, NULL, 'COORD. ACADÊMICA DO INSTITUTO DE COMPUTAÇÃO', 30, 2, 2015, '2015-09-08', '2016-01-18', NULL),
(118, 1700, 'CB01', 1, NULL, 'COORD. ACADÊMICA DO INSTITUTO DE COMPUTAÇÃO', 50, 2, 2015, '2015-09-08', '2016-01-18', NULL),
(119, 1701, 'CB01', 1, NULL, 'COORD. ACADÊMICA DO INSTITUTO DE COMPUTAÇÃO', 30, 2, 2015, '2015-09-08', '2016-01-18', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `frequencia`
--

CREATE TABLE IF NOT EXISTS `frequencia` (
  `id` int(11) NOT NULL,
  `IDMonitoria` int(11) NOT NULL,
  `dmy` date NOT NULL,
  `ch` float NOT NULL,
  `atividade` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `grupo`
--

CREATE TABLE IF NOT EXISTS `grupo` (
  `id` int(11) NOT NULL,
  `codigo` varchar(20) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `max_horas` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `grupo`
--

INSERT INTO `grupo` (`id`, `codigo`, `nome`, `max_horas`) VALUES
(1, 'grupo', 'inovacao', 200);

-- --------------------------------------------------------

--
-- Estrutura da tabela `migration`
--

CREATE TABLE IF NOT EXISTS `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1445643188),
('m151023_003007_Tabela_Usua', 1445643191),
('m151023_004230_Inserir_Usuario', 1445643192),
('m151023_232410_Adc_Coluna_Curso_id', 1445643192),
('m151026_134015_Tabela_Cursos', 1445911357),
('m151026_134357_Tabela_Grupos', 1445911357),
('m151026_134526_Tabela_Atividade', 1445911358),
('m151026_134945_Tabela_Periodo', 1445911358),
('m151026_135427_Tabela_Anexo', 1445911358),
('m151026_140506_Tabela_Solicitacao', 1445911359),
('m151123_212428_add_sol_id_anexo', 1448314132);

-- --------------------------------------------------------

--
-- Estrutura da tabela `monitoria`
--

CREATE TABLE IF NOT EXISTS `monitoria` (
  `id` int(11) NOT NULL,
  `IDAluno` int(11) NOT NULL,
  `IDDisc` int(11) NOT NULL,
  `IDperiodoinscr` int(11) NOT NULL,
  `pathArqHistorico` varchar(250) CHARACTER SET utf8 NOT NULL,
  `status` int(11) DEFAULT NULL,
  `semestreConclusao` tinyint(1) NOT NULL,
  `anoConclusao` int(4) NOT NULL,
  `mediaFinal` float NOT NULL,
  `bolsa` tinyint(1) NOT NULL,
  `banco` varchar(5) CHARACTER SET utf8 DEFAULT NULL,
  `agencia` varchar(10) CHARACTER SET utf8 DEFAULT NULL,
  `conta` varchar(10) CHARACTER SET utf8 DEFAULT NULL,
  `datacriacao` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `monitoria`
--

INSERT INTO `monitoria` (`id`, `IDAluno`, `IDDisc`, `IDperiodoinscr`, `pathArqHistorico`, `status`, `semestreConclusao`, `anoConclusao`, `mediaFinal`, `bolsa`, `banco`, `agencia`, `conta`, `datacriacao`) VALUES
(16, 7, 69, 1, '20902175_20150912_202704.pdf', 0, 127, 1, 8, 1, '10', '20', '30', '2015-09-12 20:27:04'),
(17, 7, 76, 1, '20902175_20150912_202732.pdf', 0, 127, 2, 9, 0, '', '', '', '2015-09-12 20:27:32');

-- --------------------------------------------------------

--
-- Estrutura da tabela `periodo`
--

CREATE TABLE IF NOT EXISTS `periodo` (
  `id` int(11) NOT NULL,
  `codigo` varchar(10) NOT NULL,
  `dtInicio` date NOT NULL,
  `dtTermino` date NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `periodo`
--

INSERT INTO `periodo` (`id`, `codigo`, `dtInicio`, `dtTermino`) VALUES
(1, '2015/1', '2015-11-01', '2015-11-30'),
(2, '2015/2', '2015-10-01', '2016-05-27');

-- --------------------------------------------------------

--
-- Estrutura da tabela `periodoinscricao`
--

CREATE TABLE IF NOT EXISTS `periodoinscricao` (
  `id` int(11) NOT NULL,
  `dataInicio` date NOT NULL,
  `dataFim` date NOT NULL,
  `periodo` tinyint(1) NOT NULL,
  `ano` int(4) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `periodoinscricao`
--

INSERT INTO `periodoinscricao` (`id`, `dataInicio`, `dataFim`, `periodo`, `ano`) VALUES
(1, '2015-11-20', '2015-11-21', 2, 2015);

-- --------------------------------------------------------

--
-- Estrutura da tabela `solicitacao`
--

CREATE TABLE IF NOT EXISTS `solicitacao` (
  `id` int(11) NOT NULL,
  `descricao` varchar(100) NOT NULL,
  `dtInicio` date NOT NULL,
  `dtTermino` date NOT NULL,
  `horasComputadas` int(11) DEFAULT NULL,
  `horasMaxAtiv` int(11) DEFAULT NULL,
  `observacoes` varchar(100) DEFAULT NULL,
  `status` varchar(20) NOT NULL,
  `atividade_id` int(11) NOT NULL,
  `periodo_id` int(11) NOT NULL,
  `solicitante_id` int(11) NOT NULL,
  `aprovador_id` int(11) NOT NULL,
  `anexo_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `solicitacao`
--

INSERT INTO `solicitacao` (`id`, `descricao`, `dtInicio`, `dtTermino`, `horasComputadas`, `horasMaxAtiv`, `observacoes`, `status`, `atividade_id`, `periodo_id`, `solicitante_id`, `aprovador_id`, `anexo_id`) VALUES
(1, 'asasasas', '2015-11-02', '2015-11-10', 12, 12, 'lllll', 'Em Edição', 1, 1, 1, 2, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

CREATE TABLE IF NOT EXISTS `usuario` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `cpf` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `matricula` varchar(20) DEFAULT NULL,
  `siape` varchar(20) DEFAULT NULL,
  `perfil` varchar(20) NOT NULL,
  `dtEntrada` date DEFAULT NULL,
  `isAdmin` tinyint(1) NOT NULL,
  `isAtivo` tinyint(1) NOT NULL,
  `auth_key` varchar(65) DEFAULT NULL,
  `password_reset_token` varchar(255) DEFAULT NULL,
  `IDCurso` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `usuario`
--

INSERT INTO `usuario` (`id`, `name`, `cpf`, `email`, `password`, `matricula`, `siape`, `perfil`, `dtEntrada`, `isAdmin`, `isAtivo`, `auth_key`, `password_reset_token`, `IDCurso`) VALUES
(1, 'Admin Master', '999', 'admin@master.com', 'b706835de79a2b4e80506f582af3676a', '', '', 'admin', '0000-00-00', 1, 1, NULL, NULL, NULL),
(2, 'CoordSI', '888', 'coord@si.com.br', '0a113ef6b61820daa5611c870ed8d5ee', NULL, NULL, 'Coordenador', NULL, 0, 0, NULL, NULL, NULL),
(3, 'Tia', '111', 'tia@icomp.com', '698d51a19d8a121ce581499d7b701668', NULL, NULL, 'Secretaria', NULL, 0, 0, NULL, NULL, NULL),
(4, 'DENILSON DE ALBUQUERQUE CARVALHO', '74247824287', 'zottozbr@gmail.com', 'da1f83c6908ac6c65b8372c8dda40ec0', '21203723', NULL, 'Aluno', NULL, 0, 0, NULL, NULL, NULL),
(5, 'LUCIENE OLIVEIRA DA SILVA', '51950880206', 'los@icomp.ufam.edu.br', '6a6d00f175cb0fab40385efb121996e6', '20902150', NULL, 'Aluno', NULL, 0, 0, NULL, NULL, NULL),
(6, 'TAMMY HIKARI YANAI GUSMAO', '02806338239', 'tammyhikari@gmail.com', 'b706835de79a2b4e80506f582af3676a', '21201463', NULL, 'Secretaria', NULL, 0, 1, NULL, NULL, NULL),
(7, 'KALLEY CORREA', '88309495234', 'kalleycorrea@gmail.com', 'b706835de79a2b4e80506f582af3676a', NULL, NULL, 'Aluno', NULL, 0, 1, NULL, NULL, NULL),
(8, 'ARILO CLÁUDIO DIAS NETO', '111', 'arilo@icomp.ufam.edu.br', 'b706835de79a2b4e80506f582af3676a', NULL, NULL, 'Professor', NULL, 0, 1, NULL, NULL, NULL),
(9, 'CÉSAR AUGUSTO VIANA MELO', '222', 'cesar@icomp.ufam.edu.br', 'b706835de79a2b4e80506f582af3676a', NULL, NULL, 'Professor', NULL, 0, 1, NULL, NULL, NULL),
(10, 'ELAINE HARADA TEIXEIRA DE OLIVEIRA', '333', 'elaine@icomp.ufam.edu.br', 'b706835de79a2b4e80506f582af3676a', NULL, NULL, 'Professor', NULL, 0, 1, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_disciplina_monitoria`
--
CREATE TABLE IF NOT EXISTS `view_disciplina_monitoria` (
`id` int(11)
,`nomeDisciplina` varchar(150)
,`nomeCurso` varchar(100)
,`codTurma` varchar(10)
,`nomeProfessor` varchar(100)
,`numPeriodo` tinyint(1)
,`anoPeriodo` int(4)
);

-- --------------------------------------------------------

--
-- Structure for view `view_disciplina_monitoria`
--
DROP TABLE IF EXISTS `view_disciplina_monitoria`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_disciplina_monitoria` AS select `a`.`id` AS `id`,`b`.`nomeDisciplina` AS `nomeDisciplina`,`c`.`nome` AS `nomeCurso`,`a`.`codTurma` AS `codTurma`,`d`.`name` AS `nomeProfessor`,`a`.`numPeriodo` AS `numPeriodo`,`a`.`anoPeriodo` AS `anoPeriodo` from (((`disciplina_periodo` `a` join `disciplina` `b` on((`a`.`idDisciplina` = `b`.`id`))) left join `curso` `c` on((`a`.`idCurso` = `c`.`id`))) left join `usuario` `d` on((`a`.`idProfessor` = `d`.`id`)));

--
-- Indexes for dumped tables
--

--
-- Indexes for table `anexo`
--
ALTER TABLE `anexo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `atividade`
--
ALTER TABLE `atividade`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `curso`
--
ALTER TABLE `curso`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `disciplina`
--
ALTER TABLE `disciplina`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `codDisciplina` (`codDisciplina`);

--
-- Indexes for table `disciplina_periodo`
--
ALTER TABLE `disciplina_periodo`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idDisciplinaPeriodo` (`idDisciplina`,`numPeriodo`,`anoPeriodo`,`codTurma`),
  ADD KEY `fk_disciplina_periodo_idDisciplina` (`idDisciplina`),
  ADD KEY `fk_disciplina_periodo_idCurso` (`idCurso`),
  ADD KEY `fk_disciplina_periodo_idProfessor` (`idProfessor`);

--
-- Indexes for table `frequencia`
--
ALTER TABLE `frequencia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDMonitoria` (`IDMonitoria`);

--
-- Indexes for table `grupo`
--
ALTER TABLE `grupo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migration`
--
ALTER TABLE `migration`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `monitoria`
--
ALTER TABLE `monitoria`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDDisc` (`IDDisc`) USING BTREE,
  ADD KEY `IDAluno` (`IDAluno`),
  ADD KEY `IDperiodoinscr` (`IDperiodoinscr`);

--
-- Indexes for table `periodo`
--
ALTER TABLE `periodo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `periodoinscricao`
--
ALTER TABLE `periodoinscricao`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `solicitacao`
--
ALTER TABLE `solicitacao`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDCurso` (`IDCurso`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `anexo`
--
ALTER TABLE `anexo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `atividade`
--
ALTER TABLE `atividade`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `curso`
--
ALTER TABLE `curso`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `disciplina`
--
ALTER TABLE `disciplina`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1723;
--
-- AUTO_INCREMENT for table `disciplina_periodo`
--
ALTER TABLE `disciplina_periodo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=167;
--
-- AUTO_INCREMENT for table `frequencia`
--
ALTER TABLE `frequencia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `grupo`
--
ALTER TABLE `grupo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `monitoria`
--
ALTER TABLE `monitoria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `periodo`
--
ALTER TABLE `periodo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `periodoinscricao`
--
ALTER TABLE `periodoinscricao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `solicitacao`
--
ALTER TABLE `solicitacao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `disciplina_periodo`
--
ALTER TABLE `disciplina_periodo`
  ADD CONSTRAINT `disciplina_periodo_ibfk_1` FOREIGN KEY (`idDisciplina`) REFERENCES `disciplina` (`id`),
  ADD CONSTRAINT `disciplina_periodo_ibfk_2` FOREIGN KEY (`idCurso`) REFERENCES `curso` (`id`),
  ADD CONSTRAINT `disciplina_periodo_ibfk_3` FOREIGN KEY (`idProfessor`) REFERENCES `usuario` (`id`);

--
-- Limitadores para a tabela `frequencia`
--
ALTER TABLE `frequencia`
  ADD CONSTRAINT `frequencia_ibfk_1` FOREIGN KEY (`IDMonitoria`) REFERENCES `monitoria` (`id`);

--
-- Limitadores para a tabela `monitoria`
--
ALTER TABLE `monitoria`
  ADD CONSTRAINT `monitoria_ibfk_1` FOREIGN KEY (`IDDisc`) REFERENCES `disciplina_periodo` (`id`),
  ADD CONSTRAINT `monitoria_ibfk_3` FOREIGN KEY (`IDperiodoinscr`) REFERENCES `periodoinscricao` (`id`),
  ADD CONSTRAINT `monitoria_ibfk_4` FOREIGN KEY (`IDAluno`) REFERENCES `usuario` (`id`);

--
-- Limitadores para a tabela `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`IDCurso`) REFERENCES `curso` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
