<?php

require_once __DIR__ . '/../config/database.php';

class UsuarioModel
{
    private $conn;
    
    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->conectar();
    }

    public function CadastrarUsuario($nome, $email, $senha)
    {
        try {
            $senhaHash = password_hash($senha, PASSWORD_BCRYPT);
            
            $query = "INSERT INTO usuarios (nome, email, senha_hash, tipo) VALUES (:nome, :email, :senha_hash, :tipo)";
            $stmt = $this->conn->prepare($query);

            $stmt->execute([
                ':nome' => $nome,
                ':email' => $email,
                ':senha_hash' => $senhaHash,
                ':tipo' => 'usuario',
            ]);

            return true;
        } catch (PDOException $e) {
            error_log("Erro ao cadastrar usuário: " . $e->getMessage());
            return false;
        }
    }

}