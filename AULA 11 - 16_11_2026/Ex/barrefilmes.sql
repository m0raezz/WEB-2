-- Aula 11 - Sistema de sugestão de filmes
-- Banco de dados `barrefilmes`

SET NAMES utf8mb4;

CREATE DATABASE IF NOT EXISTS `barrefilmes` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `barrefilmes`;

-- --------------------------------------------------------
-- usuarios (nome, e-mail, nascimento, senha)
-- A senha é salva com hash("sha256", $senha), que tem 64 caracteres.
-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `nascimento` date NOT NULL,
  `senha` varchar(256) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
-- pendente (id_usuario, id_amigo)
-- id_usuario = quem pediu a amizade, id_amigo = quem precisa aprovar
-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `pendente` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `id_amigo` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
-- amigos (id_usuario, id_amigo)
-- Cada amizade aprovada gera duas linhas (A -> B e B -> A)
-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `amigos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `id_amigo` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
-- filmes (id_usuario, nome, descrição, foto, link, classificação, nota_usuario)
-- classificacao em anos (L = 0), nota_usuario de 0 a 10
-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `filmes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `nome` varchar(200) NOT NULL,
  `descricao` varchar(300) NOT NULL,
  `foto` varchar(200) NOT NULL,
  `link` varchar(200) NOT NULL,
  `classificacao` int(11) NOT NULL,
  `nota_usuario` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
-- curtidas (id_usuario, id_filme)
-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `curtidas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `id_filme` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
-- comentarios (id_usuario, id_filme, comentario)
-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `comentarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `id_filme` int(11) NOT NULL,
  `comentario` varchar(300) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
