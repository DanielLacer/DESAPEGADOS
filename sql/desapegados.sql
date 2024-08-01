-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 30/07/2024 às 21:18
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
-- Banco de dados: `desapegados`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `categorias_produto`
--

CREATE TABLE `categorias_produto` (
  `id_categoria` int(11) UNSIGNED NOT NULL COMMENT 'id da categoria do produto',
  `nome_categoria` varchar(50) DEFAULT NULL COMMENT 'nome da categoria do produto'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Despejando dados para a tabela `categorias_produto`
--

INSERT INTO `categorias_produto` (`id_categoria`, `nome_categoria`) VALUES
(1, 'eletrônicos'),
(2, 'lazer'),
(3, 'higiene'),
(4, 'cozinha'),
(6, 'brinquedos'),
(7, 'decorações'),
(13, 'gerais');

-- --------------------------------------------------------

--
-- Estrutura para tabela `categorias_servico`
--

CREATE TABLE `categorias_servico` (
  `id_categoria` int(11) UNSIGNED NOT NULL COMMENT 'id da categoria dos servicos',
  `nome_categoria` varchar(50) DEFAULT NULL COMMENT 'nome da categoria dos serviços'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Despejando dados para a tabela `categorias_servico`
--

INSERT INTO `categorias_servico` (`id_categoria`, `nome_categoria`) VALUES
(1, 'Aulas Particulares'),
(3, 'Consultoria Empresarial'),
(4, 'Consultoria Financeira'),
(5, 'Consultoria de Marketing'),
(7, 'Creche'),
(8, 'Desenvolvimento de Software'),
(9, 'Suporte Técnico'),
(10, 'Design Gráfico'),
(11, 'Massagem Terapêutica'),
(12, 'Nutricionista'),
(13, 'Personal Trainer'),
(14, 'Planejamento de Eventos'),
(15, 'Decoração de Festas'),
(16, 'Cabeleireiro'),
(17, 'Manicure e Pedicure'),
(19, 'cursos online');

-- --------------------------------------------------------

--
-- Estrutura para tabela `produtos`
--

CREATE TABLE `produtos` (
  `id_produto` int(10) UNSIGNED ZEROFILL NOT NULL,
  `nome_produto` varchar(255) DEFAULT NULL,
  `quantidade_produto` int(10) UNSIGNED DEFAULT NULL COMMENT 'quantidade desse produto',
  `id_categoria_produto` int(10) UNSIGNED DEFAULT NULL COMMENT 'chave estrangera da categoria do produto.',
  `descri_produto` text DEFAULT NULL,
  `fotos_produto` varchar(255) DEFAULT NULL COMMENT 'fotos do produto desse anúncio',
  `data_postagem` date DEFAULT NULL COMMENT 'data de postagem do anúncio',
  `id_usuario` int(11) UNSIGNED ZEROFILL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Despejando dados para a tabela `produtos`
--

INSERT INTO `produtos` (`id_produto`, `nome_produto`, `quantidade_produto`, `id_categoria_produto`, `descri_produto`, `fotos_produto`, `data_postagem`, `id_usuario`) VALUES
(0000000042, 'teste4', 7, 7, 'teste4', '58299a1f9d8637ef258b0b5432126538.jpg;', '2024-07-27', 00000000066),
(0000000043, 'teste5', 2, 3, 'teste5', '39797f13b6b74f412339591330ff9d22.jpg;', '2024-07-27', 00000000066),
(0000000044, 'teste8', 12, 13, 'teste12', '93fbce091b99d9fb83caa166e080585b.jpg;', '2024-07-27', 00000000066),
(0000000045, 'teste11', 6, 1, 'teste11', '633daad56f0f05e7224f0c0ddcc913ce.jpg;', '2024-07-27', 00000000022),
(0000000046, 'teste12', 6, 1, 'teste12', '9b2fd3f78bbbd3313bb8acc09de87670.jpg;', '2024-07-27', 00000000022),
(0000000047, 'teste13', 9, 7, 'teste13', '289a7e44cb5cbe52777c45fc6abfff43.jpg;', '2024-07-27', 00000000022),
(0000000048, 'teste14', 9, 13, 'teste14', 'f39fcfc0c79cd67ef05663160420a336.jpg;', '2024-07-27', 00000000022),
(0000000049, 'teste15', 8, 6, 'teste15', 'f214e82fef7b4055b470f90582b076c2.jpg;', '2024-07-27', 00000000022),
(0000000050, 'teste1111', 9, 1, 'teste111', 'f473db9205a30e4bce43c6fde8c767f8.jpg;1243206c54ac851dcf4e04fdda0d2c29.jpg;', '2024-07-27', 00000000022);

-- --------------------------------------------------------

--
-- Estrutura para tabela `servicos`
--

CREATE TABLE `servicos` (
  `id_servico` int(10) UNSIGNED ZEROFILL NOT NULL COMMENT 'id do serviço',
  `nome_servico` varchar(255) DEFAULT NULL COMMENT 'nome do serviço',
  `descri_servico` text DEFAULT NULL COMMENT 'descrição do serviço',
  `fotos_servico` varchar(255) DEFAULT NULL COMMENT 'fotos do serviço',
  `id_categoria_servico` int(10) UNSIGNED DEFAULT NULL COMMENT 'id da categoria do servico',
  `duracao_servico` tinyint(3) DEFAULT NULL COMMENT 'duração do serviço',
  `data_postagem` date DEFAULT NULL COMMENT 'data da postagem do servico',
  `id_usuario` int(11) UNSIGNED ZEROFILL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Despejando dados para a tabela `servicos`
--

INSERT INTO `servicos` (`id_servico`, `nome_servico`, `descri_servico`, `fotos_servico`, `id_categoria_servico`, `duracao_servico`, `data_postagem`, `id_usuario`) VALUES
(0000000019, 'teste3', 'teste', 'f5429766097efeec0dff5cce0e1ad444.jpg;', 4, 91, '2024-07-27', 00000000022),
(0000000020, 'teste9', 'teste9', 'dcc7ffcc7d69d876da93a92a8f563f14.jpg;', 15, 1, '2024-07-27', 00000000066),
(0000000021, 'teste10', 'teste10', '3d1b7f991a64545dc115c9b9d5542489.jpg;', 19, 5, '2024-07-27', 00000000066),
(0000000022, 'teste33', 'sdfsdfdsfsdf', '8a2799be039ab17eb0ab2df4be3c6a13.jpg;84fd4456204e5abddc1eb356d3f061fa.jpg;', 12, 3, '2024-07-29', 00000000022),
(0000000023, 'hgghhghjghj', 'jghjghjghjghj', '499a896bbcd4f1c5682bb6929190431e.png;80a656e620806571fe3057556b21e3e5.jpg;f69de633837a5e146e75709a3ec3180c.png;0ff9b326a324107fd8ad12ddf8cecfc2.jpg;479bdfe460a468d1042680800769af95.jpg;7b01e379e84921a3bb5c48cd4d324ec5.jpg;', 16, 8, '2024-07-30', 00000000022);

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) UNSIGNED ZEROFILL NOT NULL COMMENT 'id do usuario',
  `nome_usuario` varchar(255) DEFAULT NULL COMMENT 'nome do usuario',
  `telefone_usuario` varchar(15) DEFAULT NULL COMMENT 'telefone do usuario',
  `senha_usuario` varchar(255) DEFAULT NULL COMMENT 'senha do usuário',
  `email_usuario` varchar(100) DEFAULT NULL COMMENT 'email do usuario',
  `estado_usuario` varchar(50) DEFAULT NULL COMMENT 'estado do usuario',
  `cidade_usuario` varchar(50) DEFAULT NULL COMMENT 'cidade do usuario',
  `data_cadastro` date DEFAULT NULL COMMENT 'tempo de cadastro do usuario',
  `nivel_usuario` tinyint(1) DEFAULT NULL COMMENT 'nivel de cadastro do  usuario cadastrado',
  `foto_usuario` varchar(21844) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nome_usuario`, `telefone_usuario`, `senha_usuario`, `email_usuario`, `estado_usuario`, `cidade_usuario`, `data_cadastro`, `nivel_usuario`, `foto_usuario`) VALUES
(00000000022, 'Daniel', '4788942183', '$2y$10$BEcLYzLAWgRiakvrnYgOJOD6hThKMPpsspT6u10zY9OgPKVw89XNK', 'daniel@gmail.com', 'São Paulo', 'Guarulhos', '2024-05-07', 2, '0ab37f5a379a4436ea96a044356135d1.jpg'),
(00000000066, 'teste1', '4799581161', '$2y$10$g8KwS/YA0GCDPG7NbJE8k.itmINBe8O51Gp2UnAz7bQfPiydoEQVq', 'aparecida@gmail.com', 'São Paulo', 'Álvares Machado', '2024-07-27', 2, '5ce95d155adab36727be5f55990503c2.jpg'),
(00000000067, 'teste6', '4788945181', '$2y$10$x9z6e3ePSxKkMOwcpI6kK.o2jK0RIze.1X7G.MCC1b.3Tx4VHMkSm', 'teste5@gmail.com', 'São Paulo', 'Americana', '2024-07-30', 1, '690e9afd1724ab810fe45ce98f6c694c.jpg'),
(00000000068, 'teste7', '4799581661', '$2y$10$ZgHtmVYYrC6OL/h6B.w4Wuxw2uDMI/Q85kjXQ9jo0YqVFJuX2NByi', 'teste7@gmail.com', 'Espírito Santo', 'Colatina', '2024-07-30', 1, NULL),
(00000000069, 'teste8', '4788945182', '$2y$10$NATa9xOzYC0nmHKTaeSU/eAGmR/MPefzoTS/nDlfyFN4hcCkAopay', 'teste8@gmail.com', 'Rio de Janeiro', 'Cardoso Moreira', '2024-07-30', 2, NULL),
(00000000070, 'teste66', '4799581669', '$2y$10$SsF4bt71Wi0GytoFXZt.Duq17.61I/7TqSUPdmXvekHKVS0cGix3S', 'teste81@gmail.com', 'São Paulo', 'Aguaí', '2024-07-30', 2, NULL);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `categorias_produto`
--
ALTER TABLE `categorias_produto`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Índices de tabela `categorias_servico`
--
ALTER TABLE `categorias_servico`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Índices de tabela `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`id_produto`),
  ADD KEY `produtos_ibfk_1` (`id_usuario`),
  ADD KEY `id_categoria_produto` (`id_categoria_produto`);

--
-- Índices de tabela `servicos`
--
ALTER TABLE `servicos`
  ADD PRIMARY KEY (`id_servico`),
  ADD KEY `servicos_ibfk_1` (`id_usuario`),
  ADD KEY `id_categoria_servico` (`id_categoria_servico`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `email_usuario` (`email_usuario`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `categorias_produto`
--
ALTER TABLE `categorias_produto`
  MODIFY `id_categoria` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id da categoria do produto', AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de tabela `categorias_servico`
--
ALTER TABLE `categorias_servico`
  MODIFY `id_categoria` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id da categoria dos servicos', AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de tabela `produtos`
--
ALTER TABLE `produtos`
  MODIFY `id_produto` int(10) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT de tabela `servicos`
--
ALTER TABLE `servicos`
  MODIFY `id_servico` int(10) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT 'id do serviço', AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT 'id do usuario', AUTO_INCREMENT=71;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `produtos`
--
ALTER TABLE `produtos`
  ADD CONSTRAINT `produtos_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`),
  ADD CONSTRAINT `produtos_ibfk_2` FOREIGN KEY (`id_categoria_produto`) REFERENCES `categorias_produto` (`id_categoria`);

--
-- Restrições para tabelas `servicos`
--
ALTER TABLE `servicos`
  ADD CONSTRAINT `servicos_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`),
  ADD CONSTRAINT `servicos_ibfk_2` FOREIGN KEY (`id_categoria_servico`) REFERENCES `categorias_servico` (`id_categoria`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
