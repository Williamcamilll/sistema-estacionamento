-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 17/11/2024 às 22:37
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
-- Banco de dados: `estacionamento`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `carro`
--

CREATE TABLE `carro` (
  `PLACA` varchar(10) NOT NULL,
  `MARCA` int(11) DEFAULT NULL,
  `KM` int(11) DEFAULT NULL,
  `ANO` int(11) DEFAULT NULL,
  `COR` varchar(10) DEFAULT NULL,
  `DESCRICAO` varchar(255) DEFAULT NULL,
  `MODELO` varchar(50) DEFAULT NULL,
  `VALOR` decimal(8,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `cartao_caucao`
--

CREATE TABLE `cartao_caucao` (
  `ID_CARTAO` int(11) NOT NULL,
  `NOME_CARTAO` varchar(30) DEFAULT NULL,
  `NUMERO_CARTAO` int(11) DEFAULT NULL,
  `DT_VENCTO_CARTAO` date DEFAULT NULL,
  `CVC_CARTAO` int(11) DEFAULT NULL,
  `CLIENTE` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `cliente`
--

CREATE TABLE `cliente` (
  `CPF` varchar(11) NOT NULL,
  `NOME` varchar(20) NOT NULL,
  `EMAIL` varchar(50) DEFAULT NULL,
  `TELEFONE` varchar(14) DEFAULT NULL,
  `CNH` varchar(20) DEFAULT NULL,
  `DT_NASC` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `marcas_carro`
--

CREATE TABLE `marcas_carro` (
  `ID_MARCA` int(11) NOT NULL,
  `NOME_MARCA` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `marcas_carro`
--

INSERT INTO `marcas_carro` (`ID_MARCA`, `NOME_MARCA`) VALUES
(1, 'Toyota'),
(2, 'Ford'),
(3, 'Chevrolet'),
(4, 'Honda'),
(5, 'fiat');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tipos_pagamento`
--

CREATE TABLE `tipos_pagamento` (
  `ID_TIPO_PAGTO` int(11) NOT NULL,
  `NOME_TIPO_PAGTO` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha`) VALUES
(1, 'Admin', 'admin@email.com', '123456');

-- --------------------------------------------------------

--
-- Estrutura para tabela `venda`
--

CREATE TABLE `venda` (
  `ID_VENDA` int(11) NOT NULL,
  `CLIENTE` varchar(11) NOT NULL,
  `DATA_VENDA` date NOT NULL,
  `VALOR_TOTAL` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `carro`
--
ALTER TABLE `carro`
  ADD PRIMARY KEY (`PLACA`),
  ADD KEY `fk_carro_marca` (`MARCA`);

--
-- Índices de tabela `cartao_caucao`
--
ALTER TABLE `cartao_caucao`
  ADD PRIMARY KEY (`ID_CARTAO`),
  ADD KEY `CLIENTE` (`CLIENTE`);

--
-- Índices de tabela `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`CPF`);

--
-- Índices de tabela `marcas_carro`
--
ALTER TABLE `marcas_carro`
  ADD PRIMARY KEY (`ID_MARCA`);

--
-- Índices de tabela `tipos_pagamento`
--
ALTER TABLE `tipos_pagamento`
  ADD PRIMARY KEY (`ID_TIPO_PAGTO`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Índices de tabela `venda`
--
ALTER TABLE `venda`
  ADD PRIMARY KEY (`ID_VENDA`),
  ADD KEY `CLIENTE` (`CLIENTE`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `marcas_carro`
--
ALTER TABLE `marcas_carro`
  MODIFY `ID_MARCA` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `tipos_pagamento`
--
ALTER TABLE `tipos_pagamento`
  MODIFY `ID_TIPO_PAGTO` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `venda`
--
ALTER TABLE `venda`
  MODIFY `ID_VENDA` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `carro`
--
ALTER TABLE `carro`
  ADD CONSTRAINT `carro_ibfk_1` FOREIGN KEY (`MARCA`) REFERENCES `marcas_carro` (`ID_MARCA`),
  ADD CONSTRAINT `fk_carro_marca` FOREIGN KEY (`MARCA`) REFERENCES `marcas_carro` (`ID_MARCA`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `venda`
--
ALTER TABLE `venda`
  ADD CONSTRAINT `venda_ibfk_1` FOREIGN KEY (`CLIENTE`) REFERENCES `cliente` (`CPF`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
