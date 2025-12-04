<?php

require_once __DIR__ . '/../Config/database.php';

class UsuarioModel
{
    private $conn;

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->conectar();
    }

    public function cadastrarUsuario($nome, $email, $senha, $perguntaSeguranca, $respostaSeguranca)
    {
        try {
            if ($this->findUsuarioByEmail($email)) {
                return false;
            }

            $senhaHash = password_hash($senha, PASSWORD_BCRYPT);
            $respostaHash = password_hash(trim($respostaSeguranca), PASSWORD_BCRYPT);

            $query = "INSERT INTO usuarios (nome, email, senha_hash, pergunta_seguranca, resposta_seguranca_hash, tipo) VALUES (:nome, :email, :senha_hash, :pergunta_seguranca, :resposta_seguranca_hash, :tipo)";
            $stmt = $this->conn->prepare($query);

            $stmt->execute([
                ':nome' => $nome,
                ':email' => $email,
                ':senha_hash' => $senhaHash,
                ':pergunta_seguranca' => $perguntaSeguranca,
                ':resposta_seguranca_hash' => $respostaHash,
                ':tipo' => 'usuario',
            ]);

            return true;
        } catch (PDOException $e) {
            error_log("Erro ao cadastrar usuário: " . $e->getMessage());
            return false;
        }
    }

    public function findUsuarioByEmail($email)
    {
        try {
            $sql = "SELECT * FROM usuarios WHERE email = :email";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erro ao buscar usuário por email: " . $e->getMessage());
            return false;
        }
    }

    public function findUsuarioById($id)
    {
        try {
            $sql = "SELECT id, nome, email, tipo, criado_em, foto_perfil FROM usuarios WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erro ao buscar usuário por id: " . $e->getMessage());
            return false;
        }
    }

    public function getRestaurantesVisitados($usuarioId)
    {
        try {
            $sql = "SELECT r.id, r.nome, r.endereco, rv.visitado_em 
                    FROM restaurantes_visitados rv
                    JOIN restaurantes r ON rv.restaurante_id = r.id
                    WHERE rv.usuario_id = :usuario_id
                    ORDER BY rv.visitado_em DESC";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':usuario_id', $usuarioId);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erro ao buscar restaurantes visitados: " . $e->getMessage());
            return [];
        }
    }

    public function adicionarVisita($usuarioId, $restauranteId)
    {
        try {
            $sql = "INSERT IGNORE INTO restaurantes_visitados (usuario_id, restaurante_id) VALUES (:usuario_id, :restaurante_id)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':usuario_id', $usuarioId);
            $stmt->bindParam(':restaurante_id', $restauranteId);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Erro ao adicionar visita: " . $e->getMessage());
            return false;
        }
    }

    public function removerVisita($usuarioId, $restauranteId)
    {
        try {
            $sql = "DELETE FROM restaurantes_visitados WHERE usuario_id = :usuario_id AND restaurante_id = :restaurante_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':usuario_id', $usuarioId);
            $stmt->bindParam(':restaurante_id', $restauranteId);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Erro ao remover visita: " . $e->getMessage());
            return false;
        }
    }

    public function getIdsRestaurantesVisitados($usuarioId)
    {
        try {
            $sql = "SELECT restaurante_id FROM restaurantes_visitados WHERE usuario_id = :usuario_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':usuario_id', $usuarioId);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_COLUMN);
        } catch (PDOException $e) {
            error_log("Erro ao buscar IDs de restaurantes visitados: " . $e->getMessage());
            return [];
        }
    }

    public function atualizarFotoPerfil($id, $caminhoImagem)
    {
        try {
            $sql = "UPDATE usuarios SET foto_perfil = :foto_perfil WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':foto_perfil', $caminhoImagem);
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Erro ao atualizar foto de perfil: " . $e->getMessage());
            return false;
        }
    }
}
