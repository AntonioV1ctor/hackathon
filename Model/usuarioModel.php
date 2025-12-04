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
            $sql = "SELECT id, nome, email, tipo, criado_em FROM usuarios WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erro ao buscar usuário por id: " . $e->getMessage());
            return false;
        }
    }
}
