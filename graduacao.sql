-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 12-Dez-2015 às 00:06
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1723 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=120 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

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
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=120;
--
-- AUTO_INCREMENT for table `frequencia`
--
ALTER TABLE `frequencia`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `grupo`
--
ALTER TABLE `grupo`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `monitoria`
--
ALTER TABLE `monitoria`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=19;
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
