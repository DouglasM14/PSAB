-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Tempo de geração: 22-Nov-2024 às 15:42
-- Versão do servidor: 5.7.33
-- versão do PHP: 8.0.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `psab`
--
CREATE DATABASE IF NOT EXISTS `psab` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `psab`;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_adm`
--

CREATE TABLE IF NOT EXISTS `tb_adm` (
  `idAdm` int(11) NOT NULL AUTO_INCREMENT,
  `nameAdm` varchar(100) NOT NULL,
  `emailAdm` varchar(75) NOT NULL,
  `passwordAdm` int(32) NOT NULL,
  `idUser` int(11) NOT NULL,
  PRIMARY KEY (`idAdm`),
  KEY `idUser` (`idUser`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `tb_adm`
--

INSERT INTO `tb_adm` (`idAdm`, `nameAdm`, `emailAdm`, `passwordAdm`, `idUser`) VALUES
(1, 'Tico', 'adm@gmail.com', 123, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_barber`
--

CREATE TABLE IF NOT EXISTS `tb_barber` (
  `idBarber` int(11) NOT NULL AUTO_INCREMENT,
  `nameBarber` varchar(100) NOT NULL,
  `emailBarber` varchar(75) NOT NULL,
  `passwordBarber` int(32) NOT NULL,
  `unavailabilityBarber` json NOT NULL,
  `photoBarber` varchar(100) NOT NULL,
  `idUser` int(11) NOT NULL,
  PRIMARY KEY (`idBarber`),
  KEY `idUser` (`idUser`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `tb_barber`
--

INSERT INTO `tb_barber` (`idBarber`, `nameBarber`, `emailBarber`, `passwordBarber`, `unavailabilityBarber`, `photoBarber`, `idUser`) VALUES
(1, 'Tico', 'tico@gmail.com', 123, '[{\"date\": \"2024-11-27\", \"times\": [\"14:40\"]}, {\"date\": \"2024-11-28\", \"times\": [\"10:00\", \"15:20\"]}]', 'barber6740943a2ce1f.png', 3),
(2, 'Daniel', 'daniel@gmail.com', 123, '[{\"date\": \"2024-11-20\", \"times\": []}, {\"date\": \"2024-11-21\", \"times\": []}]', '', 2),
(3, 'Rari', 'rari@gmail.com', 123, 'null', '', 4);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_client`
--

CREATE TABLE IF NOT EXISTS `tb_client` (
  `idClient` int(11) NOT NULL AUTO_INCREMENT,
  `nameClient` varchar(100) NOT NULL,
  `emailClient` varchar(75) NOT NULL,
  `passwordClient` varchar(32) NOT NULL,
  `idUser` int(11) NOT NULL,
  PRIMARY KEY (`idClient`),
  KEY `idUser` (`idUser`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COMMENT='Tabela dos clientes da barbearia';

--
-- Extraindo dados da tabela `tb_client`
--

INSERT INTO `tb_client` (`idClient`, `nameClient`, `emailClient`, `passwordClient`, `idUser`) VALUES
(1, 'Douglas', 'douglas@gmail.com', '123', 6),
(2, 'Eduardo', 'eduardo@gmail.com', '123', 5),
(3, 'Vitor', 'vitor@gmail.com', '123', 8),
(4, 'Caua', 'caua@gmail.com', '123', 7),
(6, 'pedro', 'pedro@gmail.cim', '123', 10),
(7, 'luis', 'luiz@gmail.com', '123', 11),
(9, 'edukof', 'edu@gmail.com', '123', 14),
(10, 'teste', 'teste', '123', 16);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_operatinghours`
--

CREATE TABLE IF NOT EXISTS `tb_operatinghours` (
  `idOperating` int(11) NOT NULL AUTO_INCREMENT,
  `dayOperating` enum('Domingo','Segunda-feira','Terça-feira','Quarta-feira','Quinta-feira','Sexta-feira','Sábado') NOT NULL,
  `startOperating` time NOT NULL,
  `endOperating` time NOT NULL,
  `stateOperating` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`idOperating`),
  UNIQUE KEY `dayOperating` (`dayOperating`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `tb_operatinghours`
--

INSERT INTO `tb_operatinghours` (`idOperating`, `dayOperating`, `startOperating`, `endOperating`, `stateOperating`) VALUES
(1, 'Segunda-feira', '10:00:00', '20:00:00', 1),
(2, 'Terça-feira', '10:00:00', '20:00:00', 1),
(3, 'Quarta-feira', '10:00:00', '20:00:00', 1),
(4, 'Quinta-feira', '10:00:00', '20:00:00', 1),
(5, 'Sexta-feira', '10:00:00', '20:00:00', 1),
(6, 'Sábado', '09:00:00', '22:00:00', 1),
(7, 'Domingo', '10:00:00', '20:00:00', 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_schedule`
--

CREATE TABLE IF NOT EXISTS `tb_schedule` (
  `idSchedule` int(11) NOT NULL AUTO_INCREMENT,
  `timeSchedule` time NOT NULL,
  `dateSchedule` date NOT NULL,
  `stateSchedule` enum('on','end','cancel') NOT NULL DEFAULT 'on',
  `idClient` int(11) NOT NULL,
  `idBarber` int(11) NOT NULL,
  PRIMARY KEY (`idSchedule`),
  KEY `idClient` (`idClient`),
  KEY `idBarber` (`idBarber`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `tb_schedule`
--

INSERT INTO `tb_schedule` (`idSchedule`, `timeSchedule`, `dateSchedule`, `stateSchedule`, `idClient`, `idBarber`) VALUES
(1, '23:21:00', '2024-09-18', 'on', 1, 2),
(3, '06:13:00', '0000-00-00', 'on', 4, 1),
(5, '02:11:00', '2024-07-05', 'on', 4, 3),
(6, '05:12:00', '2024-09-07', 'on', 4, 1),
(7, '16:14:00', '2024-09-27', 'on', 3, 2),
(8, '21:16:00', '2024-09-04', 'on', 3, 2),
(9, '10:16:00', '2024-09-14', 'on', 3, 3),
(10, '15:40:00', '2024-11-07', 'on', 1, 1),
(11, '15:40:00', '2024-11-07', 'on', 1, 1),
(12, '15:20:00', '2024-11-22', 'on', 1, 1),
(13, '12:00:00', '2024-11-21', 'on', 1, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_service`
--

CREATE TABLE IF NOT EXISTS `tb_service` (
  `idService` int(11) NOT NULL AUTO_INCREMENT,
  `nameService` varchar(50) NOT NULL,
  `descService` varchar(255) NOT NULL,
  `priceService` decimal(12,2) NOT NULL,
  `iconService` varchar(100) NOT NULL,
  `expPriceService` decimal(12,2) NOT NULL,
  PRIMARY KEY (`idService`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `tb_service`
--

INSERT INTO `tb_service` (`idService`, `nameService`, `descService`, `priceService`, `iconService`, `expPriceService`) VALUES
(1, 'Corte Básico', 'Um simples corte de cabelo', '30.00', 'cream.png', '35.00'),
(2, 'barba', 'Barba bem feita', '25.00', '', '30.00'),
(3, '123', '123', '123.00', '', '123.00');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_userlogin`
--

CREATE TABLE IF NOT EXISTS `tb_userlogin` (
  `idUser` int(11) NOT NULL AUTO_INCREMENT,
  `emailUser` varchar(255) NOT NULL,
  `passwordUser` varchar(255) NOT NULL,
  `typeUser` enum('client','barber','adm') NOT NULL,
  PRIMARY KEY (`idUser`),
  UNIQUE KEY `emailUser` (`emailUser`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `tb_userlogin`
--

INSERT INTO `tb_userlogin` (`idUser`, `emailUser`, `passwordUser`, `typeUser`) VALUES
(1, 'adm@gmail.com', '123', 'adm'),
(2, 'daniel@gmail.com', '123', 'barber'),
(3, 'tico@gmail.com', '123', 'barber'),
(4, 'rari@gmail.com', '123', 'barber'),
(5, 'eduardo@gmail.com', '123', 'client'),
(6, 'douglas@gmail.com', '123', 'client'),
(7, 'caua@gmail.com', '123', 'client'),
(8, 'vitor@gmail.com', '123', 'client'),
(9, 'luis@gmail.cim', '123', 'client'),
(10, 'pedro@gmail.cim', '123', 'client'),
(11, 'luiz@gmail.com', '123', 'client'),
(12, 'edukof@gmail.com', '123', 'client'),
(14, 'edu@gmail.com', '123', 'client'),
(16, 'teste', '123', 'client');

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `tb_adm`
--
ALTER TABLE `tb_adm`
  ADD CONSTRAINT `tb_adm_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `tb_userlogin` (`idUser`);

--
-- Limitadores para a tabela `tb_barber`
--
ALTER TABLE `tb_barber`
  ADD CONSTRAINT `tb_barber_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `tb_userlogin` (`idUser`);

--
-- Limitadores para a tabela `tb_client`
--
ALTER TABLE `tb_client`
  ADD CONSTRAINT `tb_client_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `tb_userlogin` (`idUser`);

--
-- Limitadores para a tabela `tb_schedule`
--
ALTER TABLE `tb_schedule`
  ADD CONSTRAINT `tb_schedule_ibfk_1` FOREIGN KEY (`idClient`) REFERENCES `tb_client` (`idClient`),
  ADD CONSTRAINT `tb_schedule_ibfk_2` FOREIGN KEY (`idBarber`) REFERENCES `tb_barber` (`idBarber`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
