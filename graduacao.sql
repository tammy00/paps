-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 22-Dez-2015 às 23:53
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
  `creditos` int(3) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1729 ;

--
-- Extraindo dados da tabela `disciplina`
--

INSERT INTO `disciplina` (`id`, `codDisciplina`, `nomeDisciplina`, `cargaHoraria`, `creditos`) VALUES
(1723, 'IEC010', 'MATEMÁTICA DISCRETA', 60, 4),
(1724, 'IEC081', 'INTRODUÇÃO A CIÊNCIA DOS COMPUTADORES', 60, 4),
(1725, 'ICC120', 'MATEMÁTICA DISCRETA', 60, 4),
(1726, 'ICC400', 'INTRODUÇÃO À ENGENHARIA DE SOFTWARE', 90, 5),
(1727, 'ICC410', 'PRÁTICA DE ANÁLISE E PROJETO DE SISTEMAS', 60, 2),
(1728, 'ICC002', 'ALGORITMOS E ESTRUTURA DE DADOS I', 90, 5);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=128 ;

--
-- Extraindo dados da tabela `disciplina_periodo`
--

INSERT INTO `disciplina_periodo` (`id`, `idDisciplina`, `codTurma`, `idCurso`, `idProfessor`, `nomeUnidade`, `qtdVagas`, `numPeriodo`, `anoPeriodo`, `dataInicioPeriodo`, `dataFimPeriodo`, `usaLaboratorio`) VALUES
(120, 1723, '03', 3, 10, 'COORD. ACADÊMICA DO INSTITUTO DE COMPUTAÇÃO', 4, 2, 2015, '2015-09-08', '2016-01-18', NULL),
(121, 1724, '02', 17, 10, 'COORD. ACADÊMICA DO INSTITUTO DE COMPUTAÇÃO', 0, 2, 2015, '2015-09-08', '2016-01-18', NULL),
(122, 1725, 'CB01', 2, 10, 'COORD. ACADÊMICA DO INSTITUTO DE COMPUTAÇÃO', 30, 2, 2015, '2015-09-08', '2016-01-18', NULL),
(123, 1724, 'FL01', 26, 10, 'COORD. ACADÊMICA DO INSTITUTO DE COMPUTAÇÃO', 21, 2, 2015, '2015-09-08', '2016-01-18', NULL),
(124, 1724, 'FL501', 26, 10, 'COORD. ACADÊMICA DO INSTITUTO DE COMPUTAÇÃO', 20, 2, 2015, '2015-09-08', '2016-01-18', NULL),
(125, 1726, '01', 28, 8, 'COORD. ACADÊMICA DO INSTITUTO DE COMPUTAÇÃO', 40, 2, 2015, '2015-09-08', '2016-01-18', NULL),
(126, 1727, '01', 28, 8, 'COORD. ACADÊMICA DO INSTITUTO DE COMPUTAÇÃO', 30, 2, 2015, '2015-09-08', '2016-01-18', NULL),
(127, 1728, '01', 28, 9, 'COORD. ACADÊMICA DO INSTITUTO DE COMPUTAÇÃO', 50, 2, 2015, '2015-09-08', '2016-01-18', NULL);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Extraindo dados da tabela `frequencia`
--

INSERT INTO `frequencia` (`id`, `IDMonitoria`, `dmy`, `ch`, `atividade`) VALUES
(1, 2, '2015-12-16', 5, 'Teste'),
(2, 2, '2015-12-17', 2, 'TESTE 22/12'),
(3, 2, '2015-12-18', 4, 'TESTE 22/12 - 2'),
(4, 2, '2015-12-15', 3, 'test');

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
  `datacriacao` datetime DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Extraindo dados da tabela `monitoria`
--

INSERT INTO `monitoria` (`id`, `IDAluno`, `IDDisc`, `IDperiodoinscr`, `pathArqHistorico`, `status`, `semestreConclusao`, `anoConclusao`, `mediaFinal`, `bolsa`, `banco`, `agencia`, `conta`, `datacriacao`) VALUES
(2, 7, 124, 1, 'uploads/historicos/20902175_20151212_074512.pdf', 1, 1, 2016, 8, 0, '', '', '', '0000-00-00 00:00:00');

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
  `ano` int(4) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

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
  `IDCurso` int(11) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

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
-- Stand-in structure for view `view_aluno_monitoria`
--
CREATE TABLE IF NOT EXISTS `view_aluno_monitoria` (
`id` int(11)
,`id_disciplina` int(11)
,`bolsa` tinyint(1)
,`bolsa_traducao` varchar(3)
,`aluno` varchar(100)
,`IDAluno` int(11)
,`matricula` varchar(20)
,`cpf` varchar(100)
,`nomeDisciplina` varchar(150)
,`codTurma` varchar(10)
,`professor` varchar(100)
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
);
-- --------------------------------------------------------

--
-- Structure for view `view_aluno_monitoria`
--
DROP TABLE IF EXISTS `view_aluno_monitoria`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_aluno_monitoria` AS select `m`.`id` AS `id`,`m`.`IDDisc` AS `id_disciplina`,`m`.`bolsa` AS `bolsa`,if((`m`.`bolsa` = 1),'Sim','Não') AS `bolsa_traducao`,`u`.`name` AS `aluno`,`m`.`IDAluno` AS `IDAluno`,`u`.`matricula` AS `matricula`,`u`.`cpf` AS `cpf`,`d`.`nomeDisciplina` AS `nomeDisciplina`,`dp`.`codTurma` AS `codTurma`,`p`.`name` AS `professor`,`c`.`nome` AS `nomeCurso`,(case `m`.`status` when 0 then 'Aguardando Avaliação' when 1 then 'Deferido' when 2 then 'Indeferido' end) AS `status`,concat(`pi`.`ano`,'/',`pi`.`periodo`) AS `periodo`,`m`.`IDperiodoinscr` AS `IDperiodoinscr`,`m`.`pathArqHistorico` AS `pathArqHistorico` from ((((((`monitoria` `m` join `disciplina_periodo` `dp` on((`m`.`IDDisc` = `dp`.`id`))) join `disciplina` `d` on((`dp`.`idDisciplina` = `d`.`id`))) left join `usuario` `u` on((`m`.`IDAluno` = `u`.`id`))) left join `usuario` `p` on((`dp`.`idProfessor` = `p`.`id`))) left join `curso` `c` on((`dp`.`idCurso` = `c`.`id`))) left join `periodoinscricao` `pi` on((`m`.`IDperiodoinscr` = `pi`.`id`)));

-- --------------------------------------------------------

--
-- Structure for view `view_disciplina_monitoria`
--
DROP TABLE IF EXISTS `view_disciplina_monitoria`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_disciplina_monitoria` AS select `a`.`id` AS `id`,`b`.`nomeDisciplina` AS `nomeDisciplina`,`b`.`codDisciplina` AS `codDisciplina`,`c`.`nome` AS `nomeCurso`,`a`.`codTurma` AS `codTurma`,`d`.`name` AS `nomeProfessor`,`a`.`numPeriodo` AS `numPeriodo`,`a`.`anoPeriodo` AS `anoPeriodo` from (((`disciplina_periodo` `a` join `disciplina` `b` on((`a`.`idDisciplina` = `b`.`id`))) left join `curso` `c` on((`a`.`idCurso` = `c`.`id`))) left join `usuario` `d` on((`a`.`idProfessor` = `d`.`id`)));

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
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1729;
--
-- AUTO_INCREMENT for table `disciplina_periodo`
--
ALTER TABLE `disciplina_periodo`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=128;
--
-- AUTO_INCREMENT for table `frequencia`
--
ALTER TABLE `frequencia`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `grupo`
--
ALTER TABLE `grupo`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `monitoria`
--
ALTER TABLE `monitoria`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
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
