-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 12-Jan-2016 às 23:14
-- Versão do servidor: 5.6.20
-- PHP Version: 5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=32 ;

--
-- Extraindo dados da tabela `curso`
--

INSERT INTO `curso` (`id`, `codigo`, `nome`, `max_horas`) VALUES
(1, 'SI01', 'Sistemas de Informação', 120),
(2, 'IE08', 'Ciências da Computação', 120),
(3, 'FT05', 'Engenharia da Computação', 120),
(4, 'FA06', 'Ciências Econômicas', 0),
(5, 'FG03', 'Engenharia de Pesca', 0),
(6, 'FT01', 'Engenharia Civil', 0),
(7, 'FT02-', 'Engenharia Elétrica - Eletrônica', 0),
(8, 'FT02-', 'Engenharia Elétrica - Eletrônica', 0),
(9, 'FT02-', 'Engenharia Elétrica - Eletrotécnica', 0),
(10, 'FT02-', 'Engenharia Elétrica - Eletrotécnica', 0),
(11, 'FT02-', 'Engenharia Elétrica - Telecomunicações', 0),
(12, 'FT02-', 'Engenharia Elétrica - Telecomunicações', 0),
(13, 'FT09', 'Engenharia Mecânica', 0),
(14, 'IB05', 'Licenciatura Plena em Ciências Naturais', 0),
(15, 'IB14', 'Licenciatura Plena em Ciências Naturais', 0),
(16, 'IE01', 'Estatística', 0),
(17, 'IE03', 'Matemática', 0),
(18, 'IE03-', 'Matemática - Bacharelado', 0),
(19, 'IE03-', 'Matemática - Bacharelado', 0),
(20, 'IE03-', 'Matemática - Bacharelado', 0),
(21, 'IE03-', 'Matemática - Bacharelado', 0),
(22, 'IE03-', 'Licenciatura Plena em Matemática', 0),
(23, 'IE03-', 'Licenciatura Plena em Matemática', 0),
(24, 'IE07', 'Licenciatura Plena em Matemática', 0),
(25, 'IE10', 'Licenciatura Plena em Física', 0),
(26, 'IE13', 'Licenciatura Plena em Física', 0),
(27, 'IE14', 'Física - Bacharelado', 0),
(28, 'IE15', 'Sistemas de Informação', 0),
(29, 'IE16', 'Matemática Aplicada', 0),
(30, 'IH01', 'Biblioteconomia', 0),
(31, 'IH25', 'Arquivologia', 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `disciplina`
--

CREATE TABLE IF NOT EXISTS `disciplina` (
`id` int(11) NOT NULL,
  `codDisciplina` varchar(10) CHARACTER SET utf8 NOT NULL,
  `nomeDisciplina` varchar(150) CHARACTER SET utf8 NOT NULL,
  `cargaHoraria` int(3) NOT NULL,
  `creditos` int(3) NOT NULL,
  `possuiMonitoria` tinyint(1) DEFAULT '1'
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1730 ;

--
-- Extraindo dados da tabela `disciplina`
--

INSERT INTO `disciplina` (`id`, `codDisciplina`, `nomeDisciplina`, `cargaHoraria`, `creditos`, `possuiMonitoria`) VALUES
(1723, 'IEC010', 'MATEMÁTICA DISCRETA', 60, 4, 1),
(1724, 'IEC081', 'INTRODUÇÃO A CIÊNCIA DOS COMPUTADORES', 60, 4, 0),
(1725, 'ICC120', 'MATEMÁTICA DISCRETA', 60, 4, 1),
(1726, 'ICC400', 'INTRODUÇÃO À ENGENHARIA DE SOFTWARE', 90, 5, 0),
(1727, 'ICC410', 'PRÁTICA DE ANÁLISE E PROJETO DE SISTEMAS', 60, 2, 0),
(1728, 'ICC002', 'ALGORITMOS E ESTRUTURA DE DADOS I', 90, 5, 0);

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
  `usaLaboratorio` tinyint(1) DEFAULT NULL,
  `qtdMonitorBolsista` int(4) DEFAULT '0',
  `qtdMonitorNaoBolsista` int(4) DEFAULT '0'
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=128 ;

--
-- Extraindo dados da tabela `disciplina_periodo`
--

INSERT INTO `disciplina_periodo` (`id`, `idDisciplina`, `codTurma`, `idCurso`, `idProfessor`, `nomeUnidade`, `qtdVagas`, `numPeriodo`, `anoPeriodo`, `dataInicioPeriodo`, `dataFimPeriodo`, `usaLaboratorio`, `qtdMonitorBolsista`, `qtdMonitorNaoBolsista`) VALUES
(120, 1723, '03', 3, 10, 'COORD. ACADÊMICA DO INSTITUTO DE COMPUTAÇÃO', 4, 2, 2015, '2015-09-08', '2016-01-18', 0, 1, 0),
(121, 1724, '02', 17, 10, 'COORD. ACADÊMICA DO INSTITUTO DE COMPUTAÇÃO', 0, 2, 2015, '2015-09-08', '2016-01-18', NULL, NULL, NULL),
(122, 1725, 'CB01', 2, 10, 'COORD. ACADÊMICA DO INSTITUTO DE COMPUTAÇÃO', 30, 2, 2015, '2015-09-08', '2016-01-18', NULL, NULL, NULL),
(123, 1724, 'FL01', 26, 10, 'COORD. ACADÊMICA DO INSTITUTO DE COMPUTAÇÃO', 21, 2, 2015, '2015-09-08', '2016-01-18', NULL, NULL, NULL),
(124, 1724, 'FL501', 26, 10, 'COORD. ACADÊMICA DO INSTITUTO DE COMPUTAÇÃO', 20, 2, 2015, '2015-09-08', '2016-01-18', NULL, NULL, NULL),
(125, 1726, '01', 28, 8, 'COORD. ACADÊMICA DO INSTITUTO DE COMPUTAÇÃO', 40, 2, 2015, '2015-09-08', '2016-01-18', NULL, NULL, NULL),
(126, 1727, '01', 28, 8, 'COORD. ACADÊMICA DO INSTITUTO DE COMPUTAÇÃO', 30, 2, 2015, '2015-09-08', '2016-01-18', NULL, NULL, NULL),
(127, 1728, '01', 28, 9, 'COORD. ACADÊMICA DO INSTITUTO DE COMPUTAÇÃO', 50, 2, 2015, '2015-09-08', '2016-01-18', NULL, NULL, NULL);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Extraindo dados da tabela `frequencia`
--

INSERT INTO `frequencia` (`id`, `IDMonitoria`, `dmy`, `ch`, `atividade`) VALUES
(1, 3, '2015-12-01', 2, NULL),
(2, 3, '2015-12-02', 8, NULL),
(3, 3, '2015-12-03', 2, NULL),
(4, 3, '2015-12-04', 2, NULL),
(5, 3, '2015-12-07', 2, NULL),
(6, 3, '2015-12-11', 2, NULL),
(7, 3, '2015-12-14', 2, NULL),
(8, 3, '2015-12-15', 9, NULL),
(9, 3, '2015-12-16', 2, NULL),
(10, 3, '2015-12-18', 2, NULL),
(11, 3, '2015-12-23', 2, NULL),
(12, 3, '2015-12-24', 2, NULL),
(13, 3, '2015-12-25', 2, NULL),
(14, 3, '2015-12-28', 2, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `grupo`
--

CREATE TABLE IF NOT EXISTS `grupo` (
`id` int(11) NOT NULL,
  `codigo` varchar(20) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `max_horas` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

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
  `datacriacao` datetime DEFAULT NULL,
  `pathArqPlanoDisciplina` varchar(250) CHARACTER SET utf8 DEFAULT NULL,
  `pathArqRelatorioSemestral` varchar(250) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Extraindo dados da tabela `monitoria`
--

INSERT INTO `monitoria` (`id`, `IDAluno`, `IDDisc`, `IDperiodoinscr`, `pathArqHistorico`, `status`, `semestreConclusao`, `anoConclusao`, `mediaFinal`, `bolsa`, `banco`, `agencia`, `conta`, `datacriacao`, `pathArqPlanoDisciplina`, `pathArqRelatorioSemestral`) VALUES
(2, 7, 124, 1, 'uploads/historicos/20902175_20151212_074512.pdf', 1, 1, 2016, 8, 0, '', '', '', '0000-00-00 00:00:00', NULL, NULL),
(3, 7, 122, 2, 'uploads/historicos/_20152312_182456.pdf', 1, 2, 2016, 8, 1, '341', '0686', '64684-5', '0000-00-00 00:00:00', 'uploads/plano-semestral-disciplina/333_20161101_205448.doc', 'uploads/relatorio-semestral/333_20161101_223252.doc'),
(4, 5, 125, 2, 'uploads/historicos/20902150_20152312_212035.pdf', 0, 1, 2016, 8, 1, '10', '20', '30', '0000-00-00 00:00:00', NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `periodo`
--

CREATE TABLE IF NOT EXISTS `periodo` (
`id` int(11) NOT NULL,
  `codigo` varchar(10) NOT NULL,
  `dtInicio` date NOT NULL,
  `dtTermino` date NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

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
  `ano` int(4) NOT NULL,
  `justificativa` text
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Extraindo dados da tabela `periodoinscricao`
--

INSERT INTO `periodoinscricao` (`id`, `dataInicio`, `dataFim`, `periodo`, `ano`, `justificativa`) VALUES
(1, '2015-11-20', '2015-11-21', 1, 2015, NULL),
(2, '2015-12-01', '2015-12-31', 2, 2015, 'teste');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

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
  `IDCurso` int(11) DEFAULT NULL,
  `telefone` varchar(25) DEFAULT NULL,
  `endereco` text,
  `rg` text
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Extraindo dados da tabela `usuario`
--

INSERT INTO `usuario` (`id`, `name`, `cpf`, `email`, `password`, `matricula`, `siape`, `perfil`, `dtEntrada`, `isAdmin`, `isAtivo`, `auth_key`, `password_reset_token`, `IDCurso`, `telefone`, `endereco`, `rg`) VALUES
(1, 'Admin Master', '999', 'admin@master.com', 'b706835de79a2b4e80506f582af3676a', '', '', 'admin', '0000-00-00', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'CoordSI', '888', 'coord@si.com.br', '0a113ef6b61820daa5611c870ed8d5ee', NULL, NULL, 'Coordenador', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL),
(3, ' Ana Lucia', '111', 'analuciamachado@gmail.com', 'b706835de79a2b4e80506f582af3676a', NULL, NULL, 'Secretaria', NULL, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 'DENILSON DE ALBUQUERQUE CARVALHO', '74247824287', 'zottozbr@gmail.com', 'b706835de79a2b4e80506f582af3676a', '21203723', NULL, 'Aluno', NULL, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(5, 'LUCIENE OLIVEIRA DA SILVA', '51950880206', 'los@icomp.ufam.edu.br', 'b706835de79a2b4e80506f582af3676a', '20902150', NULL, 'Aluno', NULL, 0, 1, NULL, NULL, 2, NULL, NULL, NULL),
(6, 'TAMMY HIKARI YANAI GUSMAO', '02806338239', 'tammyhikari@gmail.com', 'b706835de79a2b4e80506f582af3676a', '21201463', NULL, 'Secretaria', NULL, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(7, 'KALLEY CORREA', '88309495234', 'kalleycorrea@gmail.com', 'b706835de79a2b4e80506f582af3676a', '20902175', NULL, 'Aluno', NULL, 0, 1, NULL, NULL, 1, '99613-9649', 'Rua Parintins, N 1, Colonia Terra Nova', '1674082-3'),
(8, 'ARILO CLÁUDIO DIAS NETO', '444', 'arilo@icomp.ufam.edu.br', 'b706835de79a2b4e80506f582af3676a', NULL, NULL, 'Professor', NULL, 0, 1, NULL, NULL, NULL, '99100-0001', NULL, NULL),
(9, 'CÉSAR AUGUSTO VIANA MELO', '222', 'cesar@icomp.ufam.edu.br', 'b706835de79a2b4e80506f582af3676a', NULL, NULL, 'Professor', NULL, 0, 1, NULL, NULL, NULL, '99100-0002', NULL, NULL),
(10, 'ELAINE HARADA TEIXEIRA DE OLIVEIRA', '333', 'elaine@icomp.ufam.edu.br', 'b706835de79a2b4e80506f582af3676a', NULL, NULL, 'Professor', NULL, 0, 1, NULL, NULL, NULL, '99100-0003', NULL, NULL),
(11, 'FABIOLA GUERRA NAKAMURA', '555', 'fabiola@icomp.ufam.edu.br', 'b706835de79a2b4e80506f582af3676a', NULL, NULL, 'Coordenador', NULL, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_aluno_monitoria`
--
CREATE TABLE IF NOT EXISTS `view_aluno_monitoria` (
`id` int(11)
,`id_disciplina` int(11)
,`aluno` varchar(100)
,`IDAluno` int(11)
,`matricula` varchar(20)
,`cpf` varchar(100)
,`mediaFinal` float
,`bolsa` tinyint(1)
,`bolsa_traducao` varchar(3)
,`banco` varchar(5)
,`agencia` varchar(10)
,`conta` varchar(10)
,`semestreConclusao` tinyint(1)
,`anoConclusao` int(4)
,`telefoneAluno` varchar(25)
,`enderecoAluno` text
,`emailAluno` varchar(100)
,`RgAluno` text
,`nomeCursoAluno` varchar(100)
,`nomeDisciplina` varchar(150)
,`codTurma` varchar(10)
,`professor` varchar(100)
,`telefoneProfessor` varchar(25)
,`emailProfessor` varchar(100)
,`nomeCurso` varchar(100)
,`status` varchar(20)
,`periodo` varchar(16)
,`IDperiodoinscr` int(11)
,`pathArqHistorico` varchar(250)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `view_disciplina_monitoria`
--
CREATE TABLE IF NOT EXISTS `view_disciplina_monitoria` (
`id` int(11)
,`nomeDisciplina` varchar(150)
,`codDisciplina` varchar(10)
,`nomeCurso` varchar(100)
,`codTurma` varchar(10)
,`nomeProfessor` varchar(100)
,`numPeriodo` tinyint(1)
,`anoPeriodo` int(4)
,`qtdVagas` int(4)
,`lab` tinyint(1)
,`lab_traducao` varchar(3)
,`qtdMonitorBolsista` int(4)
,`qtdMonitorNaoBolsista` int(4)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `view_professor_monitoria`
--
CREATE TABLE IF NOT EXISTS `view_professor_monitoria` (
`id` int(11)
,`id_disciplina` int(11)
,`nomeDisciplina` varchar(150)
,`codTurma` varchar(10)
,`professor` varchar(100)
,`cpfProfessor` varchar(100)
,`idProfessor` int(11)
,`nomeCursoDisciplina` varchar(100)
,`aluno` varchar(100)
,`IDAluno` int(11)
,`matricula` varchar(20)
,`nomeCursoAluno` varchar(100)
,`bolsa` tinyint(1)
,`bolsa_traducao` varchar(3)
,`periodo` varchar(16)
,`IDperiodoinscr` int(11)
,`pathArqPlanoDisciplina` varchar(250)
,`pathArqRelatorioSemestral` varchar(250)
);
-- --------------------------------------------------------

--
-- Structure for view `view_aluno_monitoria`
--
DROP TABLE IF EXISTS `view_aluno_monitoria`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_aluno_monitoria` AS select `m`.`id` AS `id`,`m`.`IDDisc` AS `id_disciplina`,`u`.`name` AS `aluno`,`m`.`IDAluno` AS `IDAluno`,`u`.`matricula` AS `matricula`,`u`.`cpf` AS `cpf`,`m`.`mediaFinal` AS `mediaFinal`,`m`.`bolsa` AS `bolsa`,if((`m`.`bolsa` = 1),'Sim','Não') AS `bolsa_traducao`,`m`.`banco` AS `banco`,`m`.`agencia` AS `agencia`,`m`.`conta` AS `conta`,`m`.`semestreConclusao` AS `semestreConclusao`,`m`.`anoConclusao` AS `anoConclusao`,`u`.`telefone` AS `telefoneAluno`,`u`.`endereco` AS `enderecoAluno`,`u`.`email` AS `emailAluno`,`u`.`rg` AS `RgAluno`,`ca`.`nome` AS `nomeCursoAluno`,`d`.`nomeDisciplina` AS `nomeDisciplina`,`dp`.`codTurma` AS `codTurma`,`p`.`name` AS `professor`,`p`.`telefone` AS `telefoneProfessor`,`p`.`email` AS `emailProfessor`,`c`.`nome` AS `nomeCurso`,(case `m`.`status` when 0 then 'Aguardando Avaliação' when 1 then 'Deferido' when 2 then 'Indeferido' end) AS `status`,concat(`pi`.`ano`,'/',`pi`.`periodo`) AS `periodo`,`m`.`IDperiodoinscr` AS `IDperiodoinscr`,`m`.`pathArqHistorico` AS `pathArqHistorico` from (((((((`monitoria` `m` join `disciplina_periodo` `dp` on((`m`.`IDDisc` = `dp`.`id`))) join `disciplina` `d` on((`dp`.`idDisciplina` = `d`.`id`))) left join `usuario` `u` on((`m`.`IDAluno` = `u`.`id`))) left join `usuario` `p` on((`dp`.`idProfessor` = `p`.`id`))) left join `curso` `c` on((`dp`.`idCurso` = `c`.`id`))) left join `periodoinscricao` `pi` on((`m`.`IDperiodoinscr` = `pi`.`id`))) left join `curso` `ca` on((`u`.`IDCurso` = `ca`.`id`)));

-- --------------------------------------------------------

--
-- Structure for view `view_disciplina_monitoria`
--
DROP TABLE IF EXISTS `view_disciplina_monitoria`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_disciplina_monitoria` AS select `a`.`id` AS `id`,`b`.`nomeDisciplina` AS `nomeDisciplina`,`b`.`codDisciplina` AS `codDisciplina`,`c`.`nome` AS `nomeCurso`,`a`.`codTurma` AS `codTurma`,`d`.`name` AS `nomeProfessor`,`a`.`numPeriodo` AS `numPeriodo`,`a`.`anoPeriodo` AS `anoPeriodo`,`a`.`qtdVagas` AS `qtdVagas`,`a`.`usaLaboratorio` AS `lab`,if((`a`.`usaLaboratorio` = 1),'Sim','Não') AS `lab_traducao`,`a`.`qtdMonitorBolsista` AS `qtdMonitorBolsista`,`a`.`qtdMonitorNaoBolsista` AS `qtdMonitorNaoBolsista` from (((`disciplina_periodo` `a` join `disciplina` `b` on((`a`.`idDisciplina` = `b`.`id`))) left join `curso` `c` on((`a`.`idCurso` = `c`.`id`))) left join `usuario` `d` on((`a`.`idProfessor` = `d`.`id`)));

-- --------------------------------------------------------

--
-- Structure for view `view_professor_monitoria`
--
DROP TABLE IF EXISTS `view_professor_monitoria`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_professor_monitoria` AS select `m`.`id` AS `id`,`m`.`IDDisc` AS `id_disciplina`,`d`.`nomeDisciplina` AS `nomeDisciplina`,`dp`.`codTurma` AS `codTurma`,`p`.`name` AS `professor`,`p`.`cpf` AS `cpfProfessor`,`dp`.`idProfessor` AS `idProfessor`,`c`.`nome` AS `nomeCursoDisciplina`,`u`.`name` AS `aluno`,`m`.`IDAluno` AS `IDAluno`,`u`.`matricula` AS `matricula`,`ca`.`nome` AS `nomeCursoAluno`,`m`.`bolsa` AS `bolsa`,if((`m`.`bolsa` = 1),'Sim','Não') AS `bolsa_traducao`,concat(`pi`.`ano`,'/',`pi`.`periodo`) AS `periodo`,`m`.`IDperiodoinscr` AS `IDperiodoinscr`,`m`.`pathArqPlanoDisciplina` AS `pathArqPlanoDisciplina`,`m`.`pathArqRelatorioSemestral` AS `pathArqRelatorioSemestral` from (((((((`monitoria` `m` join `disciplina_periodo` `dp` on((`m`.`IDDisc` = `dp`.`id`))) join `disciplina` `d` on((`dp`.`idDisciplina` = `d`.`id`))) left join `usuario` `u` on((`m`.`IDAluno` = `u`.`id`))) left join `usuario` `p` on((`dp`.`idProfessor` = `p`.`id`))) left join `curso` `c` on((`dp`.`idCurso` = `c`.`id`))) left join `periodoinscricao` `pi` on((`m`.`IDperiodoinscr` = `pi`.`id`))) left join `curso` `ca` on((`u`.`IDCurso` = `ca`.`id`))) where (`m`.`status` = 1);

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
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `codDisciplina` (`codDisciplina`);

--
-- Indexes for table `disciplina_periodo`
--
ALTER TABLE `disciplina_periodo`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `idDisciplinaPeriodo` (`idDisciplina`,`numPeriodo`,`anoPeriodo`,`codTurma`), ADD KEY `fk_disciplina_periodo_idDisciplina` (`idDisciplina`), ADD KEY `fk_disciplina_periodo_idCurso` (`idCurso`), ADD KEY `fk_disciplina_periodo_idProfessor` (`idProfessor`);

--
-- Indexes for table `frequencia`
--
ALTER TABLE `frequencia`
 ADD PRIMARY KEY (`id`), ADD KEY `IDMonitoria` (`IDMonitoria`);

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
 ADD PRIMARY KEY (`id`), ADD KEY `IDDisc` (`IDDisc`) USING BTREE, ADD KEY `IDAluno` (`IDAluno`), ADD KEY `IDperiodoinscr` (`IDperiodoinscr`);

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
 ADD PRIMARY KEY (`id`), ADD KEY `IDCurso` (`IDCurso`);

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
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=32;
--
-- AUTO_INCREMENT for table `disciplina`
--
ALTER TABLE `disciplina`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1730;
--
-- AUTO_INCREMENT for table `disciplina_periodo`
--
ALTER TABLE `disciplina_periodo`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=128;
--
-- AUTO_INCREMENT for table `frequencia`
--
ALTER TABLE `frequencia`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `grupo`
--
ALTER TABLE `grupo`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `monitoria`
--
ALTER TABLE `monitoria`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `periodo`
--
ALTER TABLE `periodo`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `periodoinscricao`
--
ALTER TABLE `periodoinscricao`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `solicitacao`
--
ALTER TABLE `solicitacao`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `usuario`
--
ALTER TABLE `usuario`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
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
