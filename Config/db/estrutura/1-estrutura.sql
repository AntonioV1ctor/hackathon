			SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

CREATE TABLE usuarios (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(150) NOT NULL,
  email VARCHAR(150) NOT NULL UNIQUE,
  senha_hash VARCHAR(255) NOT NULL,
  tipo ENUM('admin','usuario') NOT NULL DEFAULT 'usuario',
  criado_em DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE restaurantes (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(200) NOT NULL,
  cidade INT NULL,
  categoria ENUM('Regional', 'Peixes e Frutos do Mar', 'Churrascaria', 'Comida Caseira', 'Italiano/Massas', 'Japonesa', 'Lanches e Porções'),
  descricao LONGTEXT,
  endereco VARCHAR(255),
  lat varchar(255),
  long varchar(255),
  horario_funcionamento VARCHAR(255),
  faixa_preco ENUM('barato','moderado','caro', 'sofisticado'),
  caminho_imagem VARCHAR(255),
  criado_em DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  atualizado_em DATETIME NULL ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (cidade_id) REFERENCES cidades(id) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE avaliacoes (
  id INT AUTO_INCREMENT PRIMARY KEY,
  usuario_id INT NULL,
  referencia_id INT NOT NULL,
  nota TINYINT NOT NULL CHECK (nota BETWEEN 1 AND 5),
  criado_em DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

SET FOREIGN_KEY_CHECKS = 1;
