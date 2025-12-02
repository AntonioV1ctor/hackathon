-- Script de Criação da Estrutura do Banco de Dados
-- Projeto: Hackathon Voucher Desenvolvedor MS

SET FOREIGN_KEY_CHECKS = 0;

-- -----------------------------------------------------
-- Tabela `usuarios`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL UNIQUE,
  `senha` VARCHAR(255) NOT NULL,
  `cpf` VARCHAR(14) NULL UNIQUE,
  `data_cadastro` DATETIME DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET=utf8mb4;

-- -----------------------------------------------------
-- Tabela `restaurantes`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `restaurantes`;
CREATE TABLE IF NOT EXISTS `restaurantes` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(255) NOT NULL,
  `descricao` TEXT NULL,
  `endereco` VARCHAR(255) NOT NULL,
  `cidade` VARCHAR(100) NOT NULL,
  `culinaria` VARCHAR(100) NOT NULL,
  `preco_nivel` INT DEFAULT 1 COMMENT '1 to 5',
  `imagem_url` VARCHAR(500) NULL,
  `rating` DECIMAL(3,2) DEFAULT 0.00,
  `ativo` TINYINT(1) DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET=utf8mb4;

-- -----------------------------------------------------
-- Tabela `eventos`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `eventos`;
CREATE TABLE IF NOT EXISTS `eventos` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `titulo` VARCHAR(255) NOT NULL,
  `descricao` TEXT NULL,
  `data_inicio` DATETIME NOT NULL,
  `data_fim` DATETIME NOT NULL,
  `local` VARCHAR(255) NOT NULL,
  `imagem_url` VARCHAR(500) NULL,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET=utf8mb4;

-- -----------------------------------------------------
-- Tabela `vouchers`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `vouchers`;
CREATE TABLE IF NOT EXISTS `vouchers` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `usuario_id` INT NOT NULL,
  `restaurante_id` INT NOT NULL,
  `codigo` VARCHAR(50) NOT NULL UNIQUE,
  `data_geracao` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `data_validade` DATETIME NOT NULL,
  `status` ENUM('ativo', 'utilizado', 'expirado') DEFAULT 'ativo',
  `data_utilizacao` DATETIME NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_vouchers_usuarios`
    FOREIGN KEY (`usuario_id`)
    REFERENCES `usuarios` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_vouchers_restaurantes`
    FOREIGN KEY (`restaurante_id`)
    REFERENCES `restaurantes` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET=utf8mb4;

-- -----------------------------------------------------
-- Tabela `avaliacoes`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `avaliacoes`;
CREATE TABLE IF NOT EXISTS `avaliacoes` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `usuario_id` INT NOT NULL,
  `restaurante_id` INT NOT NULL,
  `nota` INT NOT NULL COMMENT '1 to 5',
  `comentario` TEXT NULL,
  `data_avaliacao` DATETIME DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_avaliacoes_usuarios`
    FOREIGN KEY (`usuario_id`)
    REFERENCES `usuarios` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_avaliacoes_restaurantes`
    FOREIGN KEY (`restaurante_id`)
    REFERENCES `restaurantes` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET=utf8mb4;

SET FOREIGN_KEY_CHECKS = 1;
