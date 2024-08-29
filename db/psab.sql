-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 29/08/2024 às 04:16
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
CREATE DATABASE IF NOT EXISTS `psab` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `psab`;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_adm`
--

CREATE TABLE IF NOT EXISTS `tb_adm` (
  `idAdm` int(11) NOT NULL AUTO_INCREMENT,
  `nameAdm` varchar(100) NOT NULL,
  `emailAdm` varchar(75) NOT NULL,
  `passwordAdm` int(32) NOT NULL,
  PRIMARY KEY (`idAdm`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `tb_adm`
--

INSERT INTO `tb_adm` (`idAdm`, `nameAdm`, `emailAdm`, `passwordAdm`) VALUES
(1, 'AdmTico', 'admtico@karraro.com', 123456);

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_barber`
--

CREATE TABLE IF NOT EXISTS `tb_barber` (
  `idBarber` int(11) NOT NULL AUTO_INCREMENT,
  `nameBarber` varchar(100) NOT NULL,
  `emailBarber` varchar(75) NOT NULL,
  `passwordBarber` int(32) NOT NULL,
  PRIMARY KEY (`idBarber`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `tb_barber`
--

INSERT INTO `tb_barber` (`idBarber`, `nameBarber`, `emailBarber`, `passwordBarber`) VALUES
(1, 'barberTico', 'barbertico@karraro.com', 123456),
(2, 'barber1', 'barber1@karraro.com', 123456),
(3, 'barber2', 'barber2@karraro.com', 123456);

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_client`
--

CREATE TABLE IF NOT EXISTS `tb_client` (
  `idClient` int(11) NOT NULL AUTO_INCREMENT,
  `nameClient` varchar(100) NOT NULL,
  `emailClient` varchar(75) NOT NULL,
  `passwordClient` varchar(32) NOT NULL,
  PRIMARY KEY (`idClient`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci COMMENT='Tabela dos clientes da barbearia';

--
-- Despejando dados para a tabela `tb_client`
--

INSERT INTO `tb_client` (`idClient`, `nameClient`, `emailClient`, `passwordClient`) VALUES
(1, 'Douglas', 'douglas@gmail.com', 'douglas123'),
(2, 'Douglas', 'do', '123');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_schedule`
--

CREATE TABLE IF NOT EXISTS `tb_schedule` (
  `idSchedule` int(11) NOT NULL AUTO_INCREMENT,
  `timeSchedule` time NOT NULL,
  `dateSchedule` date NOT NULL,
  `idClient` int(11) NOT NULL,
  `idBarber` int(11) NOT NULL,
  PRIMARY KEY (`idSchedule`),
  KEY `idClient` (`idClient`),
  KEY `idBarber` (`idBarber`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `tb_schedule`
--

INSERT INTO `tb_schedule` (`idSchedule`, `timeSchedule`, `dateSchedule`, `idClient`, `idBarber`) VALUES
(1, '01:10:00', '2024-11-01', 2, 1),
(2, '02:20:00', '2024-09-02', 2, 2),
(3, '03:30:00', '2024-09-03', 2, 3);

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_service`
--

CREATE TABLE IF NOT EXISTS `tb_service` (
  `idService` int(11) NOT NULL AUTO_INCREMENT,
  `nameService` varchar(50) NOT NULL,
  `descriptionService` varchar(255) NOT NULL,
  `priceService` int(11) NOT NULL,
  PRIMARY KEY (`idService`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `tb_service`
--

INSERT INTO `tb_service` (`idService`, `nameService`, `descriptionService`, `priceService`) VALUES
(1, 'Hidratação', 'Descrição muito foda do serviço', 10),
(2, 'Perfil', 'Descrição muito foda do serviço', 10),
(3, 'Sobrancelha', 'Descrição muito foda do serviço', 10),
(4, 'Barba', 'Descrição muito foda do serviço', 30),
(5, 'Corte', 'Descrição muito foda do serviço', 30);

--
-- Restrições para tabelas despejadas
--

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
