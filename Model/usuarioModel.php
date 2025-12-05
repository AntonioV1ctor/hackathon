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

    /**
     * Cadastra um novo usuário no sistema
     * @param string $nome Nome completo do usuário
     * @param string $email Email do usuário
     * @param string $senha Senha do usuário
     * @param string $perguntaSeguranca Pergunta de segurança para recuperação
     * @param string $respostaSeguranca Resposta de segurança
     * @return bool Retorna true se cadastrado com sucesso, false caso contrário
     */
    public function cadastrarUsuario($nome, $email, $senha, $perguntaSeguranca, $respostaSeguranca)
    {
        try {
            if ($this->buscarUsuarioPorEmail($email)) {
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

    /**
     * Busca um usuário pelo email
     * @param string $email Email do usuário
     * @return array|false Retorna os dados do usuário ou false se não encontrar
     */
    public function buscarUsuarioPorEmail($email)
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

    /**
     * Busca um usuário pelo ID
     * @param int $id ID do usuário
     * @return array|false Retorna os dados do usuário ou false se não encontrar
     */
    public function buscarUsuarioPorId($id)
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

    /**
     * Lista os restaurantes visitados por um usuário
     * @param int $usuarioId ID do usuário
     * @return array Lista de restaurantes visitados
     */
    public function listarRestaurantesVisitados($usuarioId)
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

    /**
     * Adiciona um restaurante à lista de visitados do usuário
     * @param int $usuarioId ID do usuário
     * @param int $restauranteId ID do restaurante
     * @return bool Retorna true se adicionado com sucesso
     */
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

    /**
     * Remove um restaurante da lista de visitados do usuário
     * @param int $usuarioId ID do usuário
     * @param int $restauranteId ID do restaurante
     * @return bool Retorna true se removido com sucesso
     */
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

    /**
     * Retorna apenas os IDs dos restaurantes visitados pelo usuário
     * @param int $usuarioId ID do usuário
     * @return array Lista de IDs
     */
    public function listarIdsRestaurantesVisitados($usuarioId)
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

    /**
     * Atualiza a foto de perfil do usuário
     * @param int $id ID do usuário
     * @param string $caminhoImagem Caminho da imagem no servidor
     * @return bool Retorna true se atualizado com sucesso
     */
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
