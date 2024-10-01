-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 30/09/2024 às 03:44
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
CREATE DATABASE IF NOT EXISTS `psab` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `psab`;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_adm`
--
-- Criação: 29/09/2024 às 23:00
--

CREATE TABLE `tb_adm` (
  `idAdm` int(11) NOT NULL,
  `nameAdm` varchar(100) NOT NULL,
  `emailAdm` varchar(75) NOT NULL,
  `passwordAdm` int(32) NOT NULL,
  `idUser` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
q
--
-- Despejando dados para a tabela `tb_adm`
--

INSERT INTO `tb_adm` (`idAdm`, `nameAdm`, `emailAdm`, `passwordAdm`, `idUser`) VALUES
(1, 'Tico', 'adm@gmail.com', 123, 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_barber`
--
-- Criação: 29/09/2024 às 23:00
--

CREATE TABLE `tb_barber` (
  `idBarber` int(11) NOT NULL,
  `nameBarber` varchar(100) NOT NULL,
  `emailBarber` varchar(75) NOT NULL,
  `passwordBarber` int(32) NOT NULL,
  `idUser` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `tb_barber`
--

INSERT INTO `tb_barber` (`idBarber`, `nameBarber`, `emailBarber`, `passwordBarber`, `idUser`) VALUES
(1, 'Tico', 'tico@gmail.com', 123, 3),
(2, 'Daniel', 'daniel@gmail.com', 123, 2),
(3, 'Rari', 'rari@gmail.com', 123, 4);

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_client`
--
-- Criação: 29/09/2024 às 23:00
--

CREATE TABLE `tb_client` (
  `idClient` int(11) NOT NULL,
  `nameClient` varchar(100) NOT NULL,
  `emailClient` varchar(75) NOT NULL,
  `passwordClient` varchar(32) NOT NULL,
  `idUser` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci COMMENT='Tabela dos clientes da barbearia';

--
-- Despejando dados para a tabela `tb_client`
--

INSERT INTO `tb_client` (`idClient`, `nameClient`, `emailClient`, `passwordClient`, `idUser`) VALUES
(1, 'Douglas', 'douglas@gmail.com', '123', 6),
(2, 'Eduardo', 'eduardo@gmail.com', '123', 5),
(3, 'Vitor', 'vitor@gmail.com', '123', 8),
(4, 'Caua', 'caua@gmail.com', '123', 7);

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_schedule`
--
-- Criação: 29/09/2024 às 23:00
--

CREATE TABLE `tb_schedule` (
  `idSchedule` int(11) NOT NULL,
  `timeSchedule` time NOT NULL,
  `dateSchedule` date NOT NULL,
  `idClient` int(11) NOT NULL,
  `idBarber` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `tb_schedule`
--

INSERT INTO `tb_schedule` (`idSchedule`, `timeSchedule`, `dateSchedule`, `idClient`, `idBarber`) VALUES
(1, '23:21:00', '2024-09-18', 1, 2),
(3, '06:13:00', '0000-00-00', 4, 1),
(5, '02:11:00', '2024-07-05', 4, 3),
(6, '05:12:00', '2024-09-07', 4, 1),
(7, '16:14:00', '2024-09-27', 3, 2),
(8, '21:16:00', '2024-09-04', 3, 2),
(9, '10:16:00', '2024-09-14', 3, 3);

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_service`
--
-- Criação: 29/09/2024 às 23:00
--

CREATE TABLE `tb_service` (
  `idService` int(11) NOT NULL,
  `nameService` varchar(50) NOT NULL,
  `descriptionService` varchar(255) NOT NULL,
  `priceService` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `tb_service`
--

INSERT INTO `tb_service` (`idService`, `nameService`, `descriptionService`, `priceService`) VALUES
(1, 'Corte Básico', 'Um simples corte de cabelo', 12);

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_userlogin`
--
-- Criação: 29/09/2024 às 23:00
--

CREATE TABLE `tb_userlogin` (
  `idUser` int(11) NOT NULL,
  `emailUser` varchar(255) NOT NULL,
  `passwordUser` varchar(255) NOT NULL,
  `typeUser` enum('client','barber','adm') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `tb_userlogin`
--

INSERT INTO `tb_userlogin` (`idUser`, `emailUser`, `passwordUser`, `typeUser`) VALUES
(1, 'adm@gmail.com', '123', 'adm'),
(2, 'daniel@gmail.com', '123', 'barber'),
(3, 'tico@gmail.com', '123', 'barber'),
(4, 'rari@gmail.com', '123', 'barber'),
(5, 'eduardo@gmail.com', '123', 'client'),
(6, 'douglas@gmail.com', '123', 'client'),
(7, 'caua@gmail.com', '123', 'client'),
(8, 'vitor@gmail.com', '123', 'client');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `tb_adm`
--
ALTER TABLE `tb_adm`
  ADD PRIMARY KEY (`idAdm`),
  ADD KEY `idUser` (`idUser`);

--
-- Índices de tabela `tb_barber`
--
ALTER TABLE `tb_barber`
  ADD PRIMARY KEY (`idBarber`),
  ADD KEY `idUser` (`idUser`);

--
-- Índices de tabela `tb_client`
--
ALTER TABLE `tb_client`
  ADD PRIMARY KEY (`idClient`),
  ADD KEY `idUser` (`idUser`);

--
-- Índices de tabela `tb_schedule`
--
ALTER TABLE `tb_schedule`
  ADD PRIMARY KEY (`idSchedule`),
  ADD KEY `idClient` (`idClient`),
  ADD KEY `idBarber` (`idBarber`);

--
-- Índices de tabela `tb_service`
--
ALTER TABLE `tb_service`
  ADD PRIMARY KEY (`idService`);

--
-- Índices de tabela `tb_userlogin`
--
ALTER TABLE `tb_userlogin`
  ADD PRIMARY KEY (`idUser`),
  ADD UNIQUE KEY `emailUser` (`emailUser`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `tb_adm`
--
ALTER TABLE `tb_adm`
  MODIFY `idAdm` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `tb_barber`
--
ALTER TABLE `tb_barber`
  MODIFY `idBarber` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `tb_client`
--
ALTER TABLE `tb_client`
  MODIFY `idClient` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `tb_schedule`
--
ALTER TABLE `tb_schedule`
  MODIFY `idSchedule` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `tb_service`
--
ALTER TABLE `tb_service`
  MODIFY `idService` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `tb_userlogin`
--
ALTER TABLE `tb_userlogin`
  MODIFY `idUser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

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
