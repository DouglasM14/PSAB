-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Tempo de geração: 28-Nov-2024 às 14:43
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
  `passwordAdm` varchar(255) NOT NULL,
  `idUser` int(11) NOT NULL,
  PRIMARY KEY (`idAdm`),
  KEY `idUser` (`idUser`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `tb_adm`
--

INSERT INTO `tb_adm` (`idAdm`, `nameAdm`, `emailAdm`, `passwordAdm`, `idUser`) VALUES
(1, 'Tiko', 'karraroAdm@gmail.com', '$2y$10$lcxkb0emdpRfT7nGK2BZnOoPSTWN/MrxqiycdbxrjEOdcWkoBT98G', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_barber`
--

CREATE TABLE IF NOT EXISTS `tb_barber` (
  `idBarber` int(11) NOT NULL AUTO_INCREMENT,
  `nameBarber` varchar(100) NOT NULL,
  `emailBarber` varchar(75) NOT NULL,
  `passwordBarber` varchar(255) NOT NULL,
  `unavailabilityBarber` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `photoBarber` varchar(100) NOT NULL,
  `idUser` int(11) NOT NULL,
  PRIMARY KEY (`idBarber`),
  KEY `idUser` (`idUser`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `tb_barber`
--

INSERT INTO `tb_barber` (`idBarber`, `nameBarber`, `emailBarber`, `passwordBarber`, `unavailabilityBarber`, `photoBarber`, `idUser`) VALUES
(1, 'Tico', 'Tico@gmail.com', '$2y$10$VUQDqlYtU3wwCFptjGZeLu4MybWk0xWYlLpEIHZV28uoyjEoHgMrS', '{\"unavaible\":{\"date\":\"\",\"times\":[]}}', 'barber6748771ff3270.png', 2),
(2, 'Raridade', 'Raridade@gmail.com', '$2y$10$mvuAVZV8RnDKJmB0J2AhVezpSZ7neAmuaLHsFGiujsEbQxE8HtuCG', '{\"unavaible\":{\"date\":\"\",\"times\":[]}}', 'barber67487813410a0.jpg', 3),
(3, 'Daniel', 'Daniel@gmail.com', '$2y$10$JQaNBPiu8e.hpJ858.4SGOIAMg8buE02ua1SzsIQeuDWPSnmWtOoq', '{\"unavaible\":{\"date\":\"\",\"times\":[]}}', 'barber67487834069ac.png', 4);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_client`
--

CREATE TABLE IF NOT EXISTS `tb_client` (
  `idClient` int(11) NOT NULL AUTO_INCREMENT,
  `nameClient` varchar(100) NOT NULL,
  `emailClient` varchar(75) NOT NULL,
  `passwordClient` varchar(255) NOT NULL,
  `idUser` int(11) NOT NULL,
  PRIMARY KEY (`idClient`),
  KEY `idUser` (`idUser`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tabela dos clientes da barbearia';

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
(5, 'Sexta-feira', '09:00:00', '22:00:00', 1),
(6, 'Sábado', '09:00:00', '22:00:00', 1),
(7, 'Domingo', '09:00:00', '20:00:00', 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_schedule`
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `tb_service`
--

INSERT INTO `tb_service` (`idService`, `nameService`, `descService`, `priceService`, `iconService`, `expPriceService`) VALUES
(1, 'Corte de Cabelo', 'Um corte específico adaptado para cada cliente', '10.00', 'scissors.png', '20.00'),
(2, 'Corte de Barba', 'Baraba extremamente bem feita a gosto do cliente', '8.00', 'razor2.png', '16.00'),
(3, 'Descoloração', 'Deixar seu cabelo tão claro quanto a neve', '20.00', 'cream.png', '25.00');

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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `tb_userlogin`
--

INSERT INTO `tb_userlogin` (`idUser`, `emailUser`, `passwordUser`, `typeUser`) VALUES
(1, 'karraroAdm@gmail.com', '$2y$10$lcxkb0emdpRfT7nGK2BZnOoPSTWN/MrxqiycdbxrjEOdcWkoBT98G', 'adm'),
(2, 'Tico@gmail.com', '$2y$10$VUQDqlYtU3wwCFptjGZeLu4MybWk0xWYlLpEIHZV28uoyjEoHgMrS', 'barber'),
(3, 'Raridade@gmail.com', '$2y$10$mvuAVZV8RnDKJmB0J2AhVezpSZ7neAmuaLHsFGiujsEbQxE8HtuCG', 'barber'),
(4, 'Daniel@gmail.com', '$2y$10$JQaNBPiu8e.hpJ858.4SGOIAMg8buE02ua1SzsIQeuDWPSnmWtOoq', 'barber');

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
