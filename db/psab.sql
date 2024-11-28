-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 28/11/2024 às 03:21
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

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
-- Estrutura para tabela `tb_adm`
--

CREATE TABLE IF NOT EXISTS `tb_adm` (
  `idAdm` int(11) NOT NULL AUTO_INCREMENT,
  `nameAdm` varchar(100) NOT NULL,
  `emailAdm` varchar(75) NOT NULL,
  `passwordAdm` varchar(255) NOT NULL,
  `idUser` int(11) NOT NULL,
  PRIMARY KEY (`idAdm`),
  KEY `idUser` (`idUser`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `tb_adm`
--

INSERT INTO `tb_adm` (`idAdm`, `nameAdm`, `emailAdm`, `passwordAdm`, `idUser`) VALUES
(1, 'Tiko', 'karraroAdm@gmail.com', '$2y$10$fqWdh2BXx7A1vm.PiKgJv.gmx5s9aiV/3xZwarwJX7mFIvAX5tDx6', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_barber`
--

CREATE TABLE IF NOT EXISTS `tb_barber` (
  `idBarber` int(11) NOT NULL AUTO_INCREMENT,
  `nameBarber` varchar(100) NOT NULL,
  `emailBarber` varchar(75) NOT NULL,
  `passwordBarber` varchar(255) NOT NULL,
  `unavailabilityBarber` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`unavailabilityBarber`)),
  `photoBarber` varchar(100) NOT NULL,
  `idUser` int(11) NOT NULL,
  PRIMARY KEY (`idBarber`),
  KEY `idUser` (`idUser`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_client`
--

CREATE TABLE IF NOT EXISTS `tb_client` (
  `idClient` int(11) NOT NULL AUTO_INCREMENT,
  `nameClient` varchar(100) NOT NULL,
  `emailClient` varchar(75) NOT NULL,
  `passwordClient` varchar(255) NOT NULL,
  `idUser` int(11) NOT NULL,
  PRIMARY KEY (`idClient`),
  KEY `idUser` (`idUser`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci COMMENT='Tabela dos clientes da barbearia';

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_operatinghours`
--

CREATE TABLE IF NOT EXISTS `tb_operatinghours` (
  `idOperating` int(11) NOT NULL AUTO_INCREMENT,
  `dayOperating` enum('Domingo','Segunda-feira','Terça-feira','Quarta-feira','Quinta-feira','Sexta-feira','Sábado') NOT NULL,
  `startOperating` time NOT NULL,
  `endOperating` time NOT NULL,
  `stateOperating` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`idOperating`),
  UNIQUE KEY `dayOperating` (`dayOperating`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_schedule`
--

CREATE TABLE IF NOT EXISTS `tb_schedule` (
  `idSchedule` int(11) NOT NULL AUTO_INCREMENT,
  `timeSchedule` time NOT NULL,
  `dateSchedule` date NOT NULL,
  `stateSchedule` enum('on','end','cancel','absent') NOT NULL DEFAULT 'on',
  `idClient` int(11) NOT NULL,
  `idBarber` int(11) NOT NULL,
  PRIMARY KEY (`idSchedule`),
  KEY `idClient` (`idClient`),
  KEY `idBarber` (`idBarber`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_service`
--

CREATE TABLE IF NOT EXISTS `tb_service` (
  `idService` int(11) NOT NULL AUTO_INCREMENT,
  `nameService` varchar(50) NOT NULL,
  `descService` varchar(255) NOT NULL,
  `priceService` decimal(12,2) NOT NULL,
  `iconService` varchar(100) NOT NULL,
  `expPriceService` decimal(12,2) NOT NULL,
  PRIMARY KEY (`idService`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_userlogin`
--

CREATE TABLE IF NOT EXISTS `tb_userlogin` (
  `idUser` int(11) NOT NULL AUTO_INCREMENT,
  `emailUser` varchar(255) NOT NULL,
  `passwordUser` varchar(255) NOT NULL,
  `typeUser` enum('client','barber','adm') NOT NULL,
  PRIMARY KEY (`idUser`),
  UNIQUE KEY `emailUser` (`emailUser`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `tb_userlogin`
--

INSERT INTO `tb_userlogin` (`idUser`, `emailUser`, `passwordUser`, `typeUser`) VALUES
(1, 'karraroAdm@gmail.com', '$2y$10$fqWdh2BXx7A1vm.PiKgJv.gmx5s9aiV/3xZwarwJX7mFIvAX5tDx6', 'adm');

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `tb_adm`
--
ALTER TABLE `tb_adm`
  ADD CONSTRAINT `tb_adm_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `tb_userlogin` (`idUser`);

--
-- Restrições para tabelas `tb_barber`
--
ALTER TABLE `tb_barber`
  ADD CONSTRAINT `tb_barber_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `tb_userlogin` (`idUser`);

--
-- Restrições para tabelas `tb_client`
--
ALTER TABLE `tb_client`
  ADD CONSTRAINT `tb_client_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `tb_userlogin` (`idUser`);

--
-- Restrições para tabelas `tb_schedule`
--
ALTER TABLE `tb_schedule`
  ADD CONSTRAINT `tb_schedule_ibfk_1` FOREIGN KEY (`idClient`) REFERENCES `tb_client` (`idClient`),
  ADD CONSTRAINT `tb_schedule_ibfk_2` FOREIGN KEY (`idBarber`) REFERENCES `tb_barber` (`idBarber`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
