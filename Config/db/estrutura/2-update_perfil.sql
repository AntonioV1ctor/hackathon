USE saboresdoturismo;

ALTER TABLE usuarios ADD COLUMN foto_perfil VARCHAR(255) NULL AFTER email;

CREATE TABLE restaurantes_visitados (
  id INT AUTO_INCREMENT PRIMARY KEY,
  usuario_id INT NOT NULL,
  restaurante_id INT NOT NULL,
  visitado_em DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
  FOREIGN KEY (restaurante_id) REFERENCES restaurantes(id) ON DELETE CASCADE,
  UNIQUE KEY unique_visita (usuario_id, restaurante_id)
);
